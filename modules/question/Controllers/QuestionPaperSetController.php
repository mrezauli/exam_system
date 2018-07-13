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
use Modules\Question\QBankAptitudeTest;
use Modules\Question\QSelectionAptitudeTest;
use Modules\Question\QuestionPaperSet;
use Modules\Exam\AptitudeExamResult;
use Modules\Exam\FileDownloadPermission;
use App\Http\Requests;
use DB;
use Session;
use Input;


class QuestionPaperSetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */


    public function index()
    {

        $page_title = "Aptitude Question Paper";

        $data = QuestionPaperSet::with('aptitude_questions')->where('status','active')->orderBy('id','desc')->get();

        return view('question::question_paper_set.index', compact('data', 'page_title'));
    }


    public function create()
    {



        $page_title = "Select Aptitude Test Question";

        $created_date_from = Input::get('created_date_from');
        $created_date_to = Input::get('created_date_to');

        $model = QBankAptitudeTest::where('status','active');


        if($created_date_from == '' && $created_date_to != ''){

            $model = $model->whereDate('created_at','=',$created_date_to);

        }

        if($created_date_from != '' && $created_date_to == ''){

            $model = $model->whereDate('created_at','=',$created_date_from);

        }

        if($created_date_from != '' && $created_date_to != ''){

            $ddd = strtotime($created_date_to) + (3600*24);

            $created_date_to = date('Y-m-d',$ddd);

            $model = $model->whereBetween('created_at', array($created_date_from, $created_date_to ));

        }

        $data = $model->orderBy('created_at','DESC')->get();


        return view('question::question_paper_set.create',compact('data','page_title'));

    }

    public function store(Requests\QuestionPaperSetRequest $request)
    {
               

       $input = $request->all();

       $checked_ids = json_decode($input['checked_ids']);

       $decoded_question_marks_id = json_decode($input['question_marks_id']);

       $question_marks_id = collect($decoded_question_marks_id)->toArray();

     
       if (empty($checked_ids)) {

            Session::flash('message', 'Please select questions first.');

            return redirect()->route('create-question-paper-set');
        
        }


        $keys = array_keys( $question_marks_id);

        $values = array_values( $question_marks_id);
        
        $question_marks_id = array_combine($keys,$values);


        foreach ($checked_ids as $key=>$value) {


            if (! isset($question_marks_id[$value]) || empty($question_marks_id[$value])){
           
               Session::flash('danger', 'Add marks to all the selected questions.');

               return redirect()->back();

           }

        }

        $question_paper_set = '';

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $question_paper_set = ['question_set_title'=>$input['question_set_title'],
                                   'status'=>'active'];


            $question_paper_set = QuestionPaperSet::create($question_paper_set);


            foreach ($checked_ids as $key => $value) {
                //print_r($value);exit("ok");
                //$ddd = QBankAptitudeTest::find($value);


                $question_mark = $question_marks_id[$value];

                $input_data = ['question_mark'=>$question_mark,'status'=>'active'];


                // dd('ddd');
                $eee = $question_paper_set->aptitude_questions()->attach($value,$input_data);

            }



            DB::commit();

            Session::flash('message', 'Successfully added!');


        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            //Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
        }



        return redirect()->route('question-paper-set');

    }

    public function show_qbank_aptitude_question($id)
    {

        $page_title = 'View Aptitude Question Paper';

        $data = QuestionPaperSet::where('id',$id)->get();

        return view('question::question_paper_set.view', compact('data','page_title'));

    }


        public function show($id)
    {

        $page_title = 'View Aptitude Test Question';

        $data = QuestionPaperSet::with('aptitude_questions')->where('id',$id)->first();
    
        return view('question::question_paper_set.view', compact('data','page_title'));

    }


    public function edit($id)
    {   

        $data = $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$id)->where('status','active')->first();


        $created_date_from = Input::get('created_date_from');
        $created_date_to = Input::get('created_date_to');

        $model = QBankAptitudeTest::where('status','active');


        if($created_date_from == '' && $created_date_to != ''){

            $model = $model->whereDate('created_at','=',$created_date_to);

        }

        if($created_date_from != '' && $created_date_to == ''){

            $model = $model->whereDate('created_at','=',$created_date_from);

        }

        if($created_date_from != '' && $created_date_to != ''){

            $model = $model->whereBetween('created_at', array($created_date_from, $created_date_to));

        }

        $questions = $model->orderBy('created_at','DESC')->get();



        $selected_questions_id = $question_set->aptitude_questions()->get()->lists('id')->toArray();

        $page_title = 'Update Question Paper Set';

        return view('question::question_paper_set.edit', compact('data','page_title','questions','selected_questions_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\QuestionPaperSetRequest $request, $id)
    {

        
           $input = $request->all();

           $checked_ids = json_decode($input['checked_ids']);




           $decoded_question_marks_id = json_decode($input['question_marks_id']);

           $question_marks_id = collect($decoded_question_marks_id)->toArray();


            $keys = array_keys( $question_marks_id);


            $values = array_values( $question_marks_id);
            $question_marks_id = array_combine($keys,$values);



            if (empty($checked_ids)) {

                Session::flash('message', 'Please select questions first.');

                return redirect()->route('edit-question-paper-set',$id);

            }

   

            foreach ($checked_ids as $key => $value) {

               if (! isset($question_marks_id[$value]) || empty($question_marks_id[$value])){

                   Session::flash('danger', 'Add marks to all the selected questions.');

                   return redirect()->back();

               }

            }


            $input_data = [];
            
            foreach ($checked_ids as $key => $value) {

                $question_mark = $question_marks_id[$value];

                $input_data[$value] = ['question_mark'=>$question_mark,'status'=>'active'];

            }



            $model = QSelectionAptitudeTest::where('question_set_id',$id)->get();

            //$model = ->delete($input);
            // dd($model->lists('qbank_aptitude_id'));


            $aptitude_exam_result = AptitudeExamResult::whereIn('qselection_aptitude_id',$model->lists('id'))->get();

            $file_download_permission = FileDownloadPermission::whereIn('qselection_aptitude_id',$model->lists('id'))->get();
            

            if ( ! $aptitude_exam_result->isEmpty() || ! $file_download_permission->isEmpty()){
              
              Session::flash('danger', "An exam has already occured with the previous selected questions.");

              return redirect()->route('edit-question-paper-set',$id)->withInput();

            }


            $extra_questions = collect($checked_ids)->diff(QSelectionAptitudeTest::where('question_set_id',$id)->get()->lists('qbank_aptitude_id'));


            // dd($extra_questions);


            $model = QSelectionAptitudeTest::where('question_set_id',$id)->whereNotIn('qbank_aptitude_id',$checked_ids)->delete();


            $add_aptitude_questions = QSelectionAptitudeTest::where('question_set_id',$id)->groupBy('company_id','designation_id','exam_date','shift')->get();



            $values = [];

            foreach ($add_aptitude_questions as $aptitude_question) {

                foreach ($extra_questions as $key => $value) {

                $values[] = ['qbank_aptitude_id' => $value,
                'question_set_id' => $id,
                'company_id'=> $aptitude_question->company_id,
                'designation_id'=> $aptitude_question->designation_id,
                'exam_date'=> $aptitude_question->exam_date,
                'shift'=> $aptitude_question->shift,
                'question_type'=> $aptitude_question->question_type,
                'status' => 'active'];

                }

            }

            


            /* Transaction Start Here */
            DB::beginTransaction();
            try {

                QSelectionAptitudeTest::insert($values);

                $model = QuestionPaperSet::find($id);

                $question_paper_set = $model->update(['question_set_title'=>$input['question_set_title']]);
                // dd($input['checkbox']);  

                $model->aptitude_questions()->sync($input_data);
            
                DB::commit();

                Session::flash('message', 'Successfully updated!');

            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
                return redirect()->route('edit-question-paper-set',$id);

            }

            return redirect()->route('question-paper-set');

        
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = QuestionPaperSet::findOrFail($id);

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