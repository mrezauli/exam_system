<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\Question\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Exam\Examination;
use Modules\Question\QBankTypingTest;
use Modules\Question\QSelectionTypingTest;
use App\Http\Requests;
use DB;
use Session;
use Input;


class QSelectionTypingTestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    public function index()
    {

        $page_title = "Typing Speed Test Question Selection";

        $data = QSelectionTypingTest::with('exam_code.company','exam_code.designation')->where('status','active')->orderBy('id','desc')->get();

        return view('question::qselection_typing_test.index', compact('data', 'page_title'));
        
    }


    public function create()
    {

        $page_title = "Select Typing Test Question";


        $input = Session::get('input');

        $exam_type = isset($input['exam_type']) ? $input['exam_type'] : '';

        $exam_type = Input::get('exam_type',$exam_type);


        $question_id = isset($input['question_id']) ? $input['question_id'] : '';

        $selected_questions_id = Input::get('question_id',$question_id);

        // dd($selected_questions_id);
        // $selected_questions_id = ! empty($question_id) ? $question_id : $selected_questions_id;
        
        // $input = $_POST;

        // $exam_type = $input;
        

         // dd($input['exam_type']);

        $data = QBankTypingTest::where('status','active')->where('exam_type','LIKE','%'.$exam_type.'%')->orderBy('id','desc')->get();

        $eee = $data->keyBy('id');

        if (isset($eee[$selected_questions_id])) {

          $selected_question = $eee[$selected_questions_id];

          unset($eee[$selected_questions_id]);

          $sorted_question = $eee->values();

          $data = $sorted_question->prepend($selected_question);

        }


        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $ddd = QSelectionTypingTest::select('exam_code_id')->where('status','active')->get()->toArray();



        $array = [];

        foreach ($ddd as $key => $value) {
          $array[] = $value['exam_code_id'];
        }

        $cnt_array = array_count_values($array);

        $excluded_exam_code = [];

        foreach($cnt_array as $key=>$val){

         if($val > 1){
          $excluded_exam_code[] = $key;
        }
        
      }


        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->take('5')->all();


        return view('question::qselection_typing_test.create',compact('data','page_title','company_list','designation_list','exam_code_list','selected_questions_id'));

    }

    public function store(Requests\QSelectionTypingTestRequest $request, $action)
    {

        $input = $request->all();
        $checked_id = $input['checked_id'];


        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);


        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");
            return redirect()->route('create-qselection-typing-test')->with('input',$input)->withInput();
            
        }



        if (empty($checked_id)) {
          Session::flash('message', 'Please select a question.');
          return redirect()->route('create-qselection-typing-test')->with('input',$input)->withInput();
        }


        $question_found = QSelectionTypingTest::where('exam_code_id',$input['exam_code_id'])->where('exam_type',$input['exam_type'])->where('status','active')->first();


        if ($question_found) {

         Session::flash('danger', 'You have already selected a question with this exam code before.');

         return redirect()->route('create-qselection-typing-test')->with('input',$input)->withInput();

       }
              

       $data = ['qbank_typing_id' => $checked_id,
       'company_id'=>$input['company_id'],
       'designation_id'=>$input['designation_id'],
       'exam_code_id'=>$input['exam_code_id'],
       'exam_date'=>$input['exam_date'],
       'exam_type'=>$input['exam_type'],
       'shift'=>$input['shift'],
       'status' => 'active'];


       /* Transaction Start Here */
       DB::beginTransaction();
       try {

        QSelectionTypingTest::create($data);

        DB::commit();

        Session::flash('message', 'Successfully added!');

      } catch (\Exception $e) {
              //If there are any exceptions, rollback the transaction`
        DB::rollback();
        Session::flash('danger', $e->getMessage());
        //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
      }

      return redirect()->route('qselection-typing-test');

    }

    public function show_qbank_typing_question($id)
    {
        $page_title = 'View Typing Test Question';

        $data = QBankTypingTest::where('id',$id)->get();

        return view('question::qselection_typing_test.view', compact('data','page_title'));
    }


        public function show($id)
    {
        $page_title = 'View Typing Test Question';

        $data = QSelectionTypingTest::with('qbank_typing_question')->where('id',$id)->first();

        $data_dtls = QBankTypingTest::where('qbank_typing_id',$id)->get();

        return view('question::qselection_typing_test.view', compact('data','page_title'));
    }


    public function edit($id)
    {   

        $data = QSelectionTypingTest::find($id);



        $input = Session::get('input');

        $exam_type = isset($input['exam_type']) ? $input['exam_type'] : '';

        $exam_type = Input::get('exam_type',$exam_type);

        $exam_type = ! empty($exam_type) ? $exam_type : $data->exam_type;




        $question_id = Input::get('url_question_id','');

        $questions = QBankTypingTest::where('status','active')->where('exam_type','LIKE','%'.$exam_type.'%')->orderBy('id','desc')->get();

        $selected_questions_id = QSelectionTypingTest::where('company_id',$data->company_id)->where('designation_id',$data->designation_id)->where('exam_date',$data->exam_date)->where('exam_type',$data->exam_type)->where('shift',$data->shift)->lists('qbank_typing_id')->first();


        $selected_questions_id = ! empty($question_id) ? $question_id : $selected_questions_id;


        $eee = $questions->keyBy('id');

        if (isset($eee[$selected_questions_id])) {

          $selected_question = $eee[$selected_questions_id];

          unset($eee[$selected_questions_id]);

          $sorted_question = $eee->values();

          $questions = $sorted_question->prepend($selected_question);

        }
       

        $page_title = 'Update Typing Question Informations';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->lists('designation_name','id')->all();

        $ddd = QSelectionTypingTest::select('exam_code_id')->where('status','active')->get()->toArray();



          $array = [];

          foreach ($ddd as $key => $value) {
            $array[] = $value['exam_code_id'];
          }

          $cnt_array = array_count_values($array);

          $included_exam_code =[$data->exam_code_id];

          $excluded_exam_code = [];

          foreach($cnt_array as $key=>$val){

           if($val > 1){
            $excluded_exam_code[] = $key;
          }
          
        }

      $excluded_exam_code =  array_diff($excluded_exam_code,$included_exam_code);




        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();

        return view('question::qselection_typing_test.edit', compact('data','page_title','questions','selected_questions_id','company_list','designation_list','exam_code_list'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\QSelectionTypingTestRequest $request, $id)
    {


        $model = QSelectionTypingTest::find($id);
       
        $input = $request->all();
        // dd($input);
        $question_id = Input::get('question_id','');

        $checked_id = Input::get('checked_id','');

        $validation_checked_id = Input::get('validation_checked_id','');

        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);


        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");
            return redirect()->route('edit-qselection-typing-test',$id)->with('input',$input)->withInput();
            

        }



        if (empty($question_id) && empty($validation_checked_id)) {
          Session::flash('message', 'Please select a question.');
          return redirect()->route('edit-qselection-typing-test',$id)->with('input',$input)->withInput();
        }



        $typing_exam_result = Examination::where('qselection_typing_id',$id)->get();


        if (! $typing_exam_result->isEmpty()) {

          Session::flash('danger', "You can't update this row anymore because an exam has already been occured.");
          return redirect()->route('edit-qselection-typing-test',$id)->withInput();

        }


        $question_found = QSelectionTypingTest::where('exam_code_id',$input['exam_code_id'])->where('exam_type',$input['exam_type'])->where('status','active')->first();


        if ( ! empty($question_found) && $question_found->id != $id) {

          Session::flash('danger', 'You have already created a question with this exam code before.');

          return redirect()->route('edit-qselection-typing-test',$id)->with('input',$input)->withInput();

        }


        $data = ['qbank_typing_id' => $checked_id,
        'company_id'=>$input['company_id'],
        'designation_id'=>$input['designation_id'],
        'exam_code_id'=>$input['exam_code_id'],
        'exam_date'=>$input['exam_date'],
        'exam_type'=>$input['exam_type'],
        'shift'=>$input['shift'],
        'status' => 'active'];



          /* Transaction Start Here */
          DB::beginTransaction();
          try {
              $model->update($data);
              DB::commit();
              Session::flash('message', "Successfully Updated");
              return redirect()->route('qselection-typing-test');
          }
          catch ( Exception $e ){
              //If there are any exceptions, rollback the transaction
              DB::rollback();
              Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");    
              return redirect()->route('edit-qselection-typing-test',$id)->withInput();     
          }

        

        
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {


      // $typing_exam_result = Examination::where('qselection_typing_id',$id)->get();


      // if (! $typing_exam_result->isEmpty()) {

      //   Session::flash('danger', "You can't delete this row anymore because an exam has already been occured.");
      //   return redirect()->route('qselection-typing-test');

      // }


      $model = QSelectionTypingTest::findOrFail($id);


      DB::beginTransaction();
      try {
        if($model->status =='active'){

          $model->status = 'inactive';

        }else{

          $model->status = 'active';

        }

        $model->save();

        DB::commit();

        Session::flash('message', "Successfully Deleted.");

      } catch(\Exception $e) {

        DB::rollback();
        Session::flash('error', "Invalid Request. Please Try Again");
      }
      return redirect()->back();
    }



}