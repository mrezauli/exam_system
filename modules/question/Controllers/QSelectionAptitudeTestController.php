<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Question\Controllers;
require public_path() . '/assets/cloudconvert/vendor/autoload.php';
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Admin\ExamTime;
use Modules\Question\QBankAptitudeTest;
use Modules\Question\QSelectionAptitudeTest;
use Modules\Question\QuestionPaperSet;
use Modules\Exam\AptitudeExamResult;
use App\Http\Requests;
use DB;
use Session;
use Input;
use File;
use \CloudConvert\Api;
use \CloudConvert\Process;
use GuzzleHttp\Client;



class QSelectionAptitudeTestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    public function index()
    {

        $page_title = "Aptitude Test Question Selection";

        $data = QSelectionAptitudeTest::with('exam_code.company','exam_code.designation')->with('question_set')->groupBy('company_id','designation_id','exam_date','shift')->orderBy('id','desc')->where('status','active')->get();

        // dd($data);

        return view('question::qselection_aptitude_test.index', compact('data', 'page_title'));
    }


    public function create()
    {

        $page_title = "Select Aptitude Test Question Set";

        $data = QuestionPaperSet::where('status','active')->orderBy('id','desc')->get();

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $excluded_exam_code = QSelectionAptitudeTest::select('exam_code_id')->where('status','active')->get()->groupBy('exam_code_id')->keys();

        
        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','aptitude_test')->where('status','active')->whereNotIn('id',$excluded_exam_code)->orderBy('id','desc')->lists('exam_code_name','id')->all();


        return view('question::qselection_aptitude_test.create',compact('data','page_title','company_list','designation_list','exam_code_list'));
    }

    public function store(Requests\QSelectionAptitudeTestRequest $request)
    {

       $input = $request->except('exam_length');

       $question_set_id = Input::get('checked_id');

       if (empty($question_set_id)) {
         Session::flash('message', 'Please select a question.');
         return redirect()->route('create-qselection-aptitude-test')->withInput();
       }


       $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$question_set_id)->first();

       $question_found = QSelectionAptitudeTest::where('exam_code_id',$input['exam_code_id'])->where('status','active')->first();

       $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);


       if ($exam_date_error) {

           Session::flash('danger', "Exam date must be equal or greater than current date.");
           return redirect()->route('create-qselection-aptitude-test')->withInput();
        
       }


       if ($question_found) {

        Session::flash('danger', 'You have already selected a question with this exam code before.');

        return redirect()->route('create-qselection-aptitude-test')->withInput();

       }

  

       foreach ($question_set->aptitude_questions as $aptitude_question) {

           $values[] = ['qbank_aptitude_id' => $aptitude_question->id,
                      'question_set_id' => $question_set_id,
                      'company_id'=>$input['company_id'],
                      'designation_id'=>$input['designation_id'],
                      'exam_code_id'=>$input['exam_code_id'],
                      'exam_date'=>$input['exam_date'],
                      'shift'=>$input['shift'],
                      'question_type'=>$aptitude_question->question_type,
                      'status' => 'active'];
       }


        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            QSelectionAptitudeTest::insert($values);

            DB::commit();

            Session::flash('message', 'Successfully added!');


        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }

        return redirect()->route('qselection-aptitude-test');
    }



    public function show_qbank_aptitude_question($id)
    {
        $page_title = 'View Aptitude Test Question Set';

        $data = QBankAptitudeTest::where('id',$id)->get();

        return view('question::qselection_aptitude_test.view', compact('data','page_title'));
    }



        public function show($id)
    {
        $page_title = 'View Aptitude Test Question Set';

        $data = QSelectionAptitudeTest::with('qbank_aptitude_question')->where('id',$id)->first();
        $data_dtls = QBankAptitudeTest::where('qbank_aptitude_id',$id)->get();

        return view('question::qselection_aptitude_test.view', compact('data','page_title'));
    }



    public function edit($id)
    {   

        $data = QSelectionAptitudeTest::find($id);

        $questions = QuestionPaperSet::where('status','active')->orderBy('id','desc')->get();

        $selected_questions_id = $data->question_set_id;



        $eee = $questions->keyBy('id');

        if (isset($eee[$selected_questions_id])) {

          $selected_question = $eee[$selected_questions_id];

          unset($eee[$selected_questions_id]);

          $sorted_question = $eee->values();

          $questions = $sorted_question->prepend($selected_question);

        }



        $page_title = 'Update Aptitude Test Question Set';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $excluded_exam_code = QSelectionAptitudeTest::select('exam_code_id')->whereNotIn('exam_code_id',[$data->exam_code_id])->where('status','active')->get()->groupBy('exam_code_id')->keys();
        

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','aptitude_test')->where('status','active')->whereNotIn('id',$excluded_exam_code)->orderBy('id','desc')->lists('exam_code_name','id')->all();


        return view('question::qselection_aptitude_test.edit', compact('data','page_title','questions','selected_questions_id','company_list','designation_list','exam_code_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\QSelectionAptitudeTestRequest $request, $id)
    {
        

        $input = $request->except('example_length','_method','_token');


        $aptitude_exam_result = AptitudeExamResult::where('qselection_aptitude_id',$id)->get();

        if (! $aptitude_exam_result->isEmpty()) {

          Session::flash('danger', "You can't update this row anymore because an exam has already been occured.");
          return redirect()->route('edit-qselection-aptitude-test',$id)->withInput();

        }


        $question_found = QSelectionAptitudeTest::where('exam_code_id',$input['exam_code_id'])->where('status','active')->first();

        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);


        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");
            return redirect()->route('edit-qselection-aptitude-test',$id)->withInput();
         
        }


        if ( ! empty($question_found) && $question_found->id != $id) {

         Session::flash('danger', 'You have already created a question with this exam code before.');

         return redirect()->route('edit-qselection-aptitude-test',$id)->withInput();

        }


        $model = QSelectionAptitudeTest::find($id);

        $question_set_id = Input::get('checked_id');


        if (empty($question_set_id)) {
          Session::flash('message', 'Please select a question.');
          return redirect()->route('edit-qselection-aptitude-test',$id)->withInput();
        }

        
        $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$question_set_id)->first();


        foreach ($question_set->aptitude_questions as $aptitude_question) {

            $values[] = ['qbank_aptitude_id' => $aptitude_question->id,
                       'question_set_id' => $question_set_id,
                       'company_id'=>$input['company_id'],
                       'designation_id'=>$input['designation_id'],
                       'exam_code_id'=>$input['exam_code_id'],
                       'exam_date'=>$input['exam_date'],
                       'shift'=>$input['shift'],
                       'question_type'=>$aptitude_question->question_type,
                       'status' => 'active'];
        }


        DB::beginTransaction();
        try {

            QSelectionAptitudeTest::where('company_id',$model->company_id)->where('designation_id',$model->designation_id)->where('exam_date',$model->exam_date)->where('shift',$model->shift)->delete($input);

            QSelectionAptitudeTest::insert($values);

            DB::commit();
            Session::flash('message', "Successfully Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
        }

        return redirect()->route('qselection-aptitude-test');   
        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {



      // $aptitude_exam_result = AptitudeExamResult::where('qselection_aptitude_id',$id)->get();


      // if (! $aptitude_exam_result->isEmpty()) {

      //   Session::flash('danger', "You can't delete this row anymore because an exam has already been occured.");
      //   return redirect()->route('edit-qselection-aptitude-test',$id)->withInput();

      // }

      
        $model = QSelectionAptitudeTest::findOrFail($id);

        $qselection_aptitude_questions = QSelectionAptitudeTest::where('company_id',$model->company_id)->where('designation_id',$model->designation_id)->where('exam_date',$model->exam_date)->where('shift',$model->shift)->where('status','active')->get();

        DB::beginTransaction();
        try {

          foreach ($qselection_aptitude_questions as $model) {

            if($model->status =='active'){

                $model->status = 'inactive';

            }else{

                $model->status = 'active';

            }

            $model->save(); 

          }
            
            DB::commit();
            Session::flash('message', "Successfully Deleted.");

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('error', "Invalid Request. Please Try Again");
        }
        return redirect()->back();
    }



public function ajax_print_qselection_aptitude_question(){


  $id = $_POST['id'];

  $client = new \GuzzleHttp\Client(['verify' => public_path() . '/assets/cacert.pem.txt' ]);

  // $api = new Api("Lyu0UGEhGNeOB5A34_KA1luyidAvMqdTcR19bY3iFSLGAGYa_qfZe5MgoZUCysZCSaEfWruycr8c33bCvX4EwA",$client);


  $api = new Api("jE0BIWAbAEdn90a5rNz52EcyR9eQQp6j68LSOKkGBojP8-FOdoQiTP42LuQvxh9OEyxmJATizW47Cf59iw-X_g",$client);


  $model = QSelectionAptitudeTest::findOrFail($id);

  $aptitude_exam_time = ExamTime::where('exam_type','aptitude_exam')->first()->exam_time;



  $company_name =  $model->exam_code()->first()->company->company_name;

  $designation_name = $model->exam_code()->first()->designation->designation_name;


  $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$model->question_set_id)->first();


$i = 0;

$total_question_marks = 0;

foreach ($question_set->aptitude_questions as $aptitude_question) {
 
   $i++;

   $total_question_marks += $aptitude_question->pivot->question_mark;

   $file_extension = pathinfo($aptitude_question->original_file_path, PATHINFO_EXTENSION);



  $question_array[$aptitude_question->question_type][] = $aptitude_question->question_type . '_' . $i . '_' . $aptitude_question->pivot->question_mark  . '_' . '.html';

  $api->convert([
          'inputformat' => $file_extension,
          'outputformat' => 'html',
          'input' => 'upload',
          'file' => fopen('file://' . public_path() . '/' . $aptitude_question->original_file_path, 'r'),
      ])
      ->wait()
      ->download('file://' . public_path() . '/' . 'temp_preview/' .$aptitude_question->question_type . '_' . $i . '.html');

}

   $ddd = explode('_', $question_array['word'][0]);

   //return $question_title = $ddd[0] . '-' . $ddd[1] . $ddd[3];

   $question_mark = $ddd[2];

   
      $email_template_path = 'temp_preview/' . rand(1111111, 9999999) . '-' . 'question_paper.html';

      $email_template_content =  view('question::qselection_aptitude_test.question_print',compact('question_array','company_name','designation_name','aptitude_exam_time','total_question_marks'))->render();

      $email_template_created = file_put_contents( $email_template_path, $email_template_content);


        if ($email_template_created) {

            return $email_template_path;

        }else{

            return 'error';
            
        }


}


public function ajax_delete_print_qselection_aptitude_question(){

  $files = array_diff(scandir('file://' . public_path() . '/' . 'temp_preview/'), array('.', '..'));

  foreach ($files as $key => $value) {

    if($value != '.gitignore'){

    File::delete(public_path() . '/' . 'temp_preview/' . $value);

    }

  }


}



}