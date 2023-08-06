<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/22/2017
 * Time: 12:29 PM
 */

namespace Modules\Exam\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Question\QSelectionTypingTest;
use Modules\Question\QSelectionAptitudeTest;
use Modules\Exam\ExamProcess;
use Session;
use Illuminate\Support\Facades\Input;
use Excel;
use File;
use Validator;
use PHPExcel;
//use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;




class ExamProcessController extends Controller
{

    public function index()
    {
        $page_title = "Examination Process List";

        $data = ExamProcess::with('exam_code.company','exam_code.designation')->orderBy('id', 'desc')->get();

        return view('exam::exam_process.index', compact('data', 'page_title'));
    }

    public function create()
    {

        $page_title = "Examination Process";

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id', 'desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id', 'desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('status','active')->orderBy('id', 'desc')->lists('exam_code_name','id')->all();

        $exam_process_code_list =  ExamProcess::where('status','active')->lists('exam_code_id')->all();



        foreach ($exam_process_code_list as $key => $value) {
            unset($exam_code_list[$value]);
        }

        $ddd = [];
        $i = 0;

        foreach ($exam_code_list as $key => $value) {

            $ddd[$key] = $value;

            $i++;

            if($i == '6'){

                break;

            }

        }


        $exam_code_list = $ddd;

        // $exam_code_list = collect($exam_code_list)->get('6');


        /*$exam_code_list = DB::table('exam_code as e')
            ->select('e.id')
            ->leftJoin('examination_process as p', 'e.id', '=', 'p.exam_code_id')
            ->where('p.exam_code_id', '=', null)->get();*/

        //dd($exam_code_list);

        return view('exam::exam_process.create',compact('page_title','company_list','designation_list','exam_code_list'));
    }

    public function start_process(Requests\ExamProcessRequest $request)
    {
        //dd($request);
        //$input = $request->all();

        $input = $request->except('_token');
        $input['status']= 'active';


        $exam_date_error = strtotime(Date('Y-m-d')) > strtotime($input['exam_date']);


        if ($exam_date_error) {

            Session::flash('danger', "Exam date must be equal or greater than current date.");

            return redirect()->route('create-process')->withInput();

        }

        // if ( ! empty(ExamProcess::where('status','active')->first() )) {

        //     $active_process = ExamProcess::where('status','active')->first()->toArray();

        //     User::where('company_id',$active_process['company_id'])->where('designation_id',$active_process['designation_id'])->whereBetween('sl', [$active_process['sl_from'], $active_process['sl_to']])->update(['status'=>'inactive']);

        // }



        $input_candidate['exam_type']= $input['exam_type'];
        $input_candidate['exam_date']= $input['exam_date'];
        $input_candidate['shift']= $input['shift'];



        if($input['exam_type'] == 'typing_test')
        {

           $question_found = QSelectionTypingTest::where('exam_code_id', $input['exam_code_id'])->where('status','active')->first();

        }elseif($input['exam_type'] == 'aptitude_test')
        {

           $question_found = QSelectionAptitudeTest::where('exam_code_id', $input['exam_code_id'])->where('status','active')->first();

        }

        if (! $question_found) {

           Session::flash('danger', "No question has been set for this exam.");

           return redirect()->route('create-process')->withInput();

        }



        if($input['exam_type'] == 'typing_test')
        {

            $model = User::where('company_id',$input['company_id'])
                            ->where('designation_id',$input['designation_id'])
                            ->whereBetween('sl', [$input['sl_from'], $input['sl_to']])
                            ->where('aptitude_exam_code_id',null)
                            ->where('typing_status','inactive')
                            ->where('attended_typing_test',null)->get();


            $input_candidate['typing_exam_code_id']= $input['exam_code_id'];
            $input_candidate['typing_status']= 'active';

        }
        elseif($input['exam_type'] == 'aptitude_test')
        {


            $model = User::where('company_id',$input['company_id'])
                            ->where('designation_id',$input['designation_id'])
                            ->whereBetween('sl', [$input['sl_from'], $input['sl_to']])
                            ->where('typing_exam_code_id',null)
                            ->where('aptitude_status','inactive')
                            ->where('attended_aptitude_test',null)->get();


            $input_candidate['aptitude_exam_code_id']= $input['exam_code_id'];
            $input_candidate['aptitude_status']= 'active';

        }

        //print_r(count($model_process));exit("ok");

        if(count($model)>0){
            /* Transaction Start Here */
            DB::beginTransaction();
            try
            {

                ExamProcess::create($input);

                foreach ($model as $model_data)
                {
                    $model_data->update($input_candidate);
                }

                DB::commit();
                Session::flash('message', 'Successfully processed!');
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());
            }
        }else{
            Session::flash('danger', "Nothing to process.");
        }

        return redirect()->route('exam-process');

    }




    public function deactivate_process($id)
    {

        $active_process = ExamProcess::where('id',$id)->where('status','active')->first();

        $active_process->status = 'inactive';

        if($active_process->exam_code->exam_type == 'typing_test')
        {
            $model = User::where('typing_exam_code_id',$active_process->exam_code_id)->whereBetween('sl', [$active_process->sl_from, $active_process->sl_to])->get();
            $input_candidate['typing_status']= 'inactive';
        }
        elseif($active_process->exam_code->exam_type == 'aptitude_test')
        {
            $model = User::where('aptitude_exam_code_id',$active_process->exam_code_id)->whereBetween('sl', [$active_process->sl_from, $active_process->sl_to])->get();
            $input_candidate['aptitude_status']= 'inactive';
        }


        //print_r(count($model_process));exit("ok");

        if(count($model)>0){

            /* Transaction Start Here */
            DB::beginTransaction();
            try
            {

                $active_process->save();

                foreach ($model as $model_data)
                {
                    $model_data->update($input_candidate);
                }

                DB::commit();
                Session::flash('message', 'Process Successfully deactivated!');

            } catch (\Exception $e) {

                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());

            }
        }else{

            Session::flash('danger', "Please Check Organization name and Post Name");

        }

        return redirect()->route('exam-process');

    }




        public function reactivate_process($id)
    {



        $active_process = ExamProcess::where('id',$id)->where('status','inactive')->first();

        $active_process->status = 'active';



        $model = User::where('exam_code_id',$active_process->exam_code_id)->whereBetween('sl', [$active_process->sl_from, $active_process->sl_to])->get();

        $input_candidate['status']= 'active';

        //print_r(count($model_process));exit("ok");

        if(count($model)>0){
            /* Transaction Start Here */
            DB::beginTransaction();
            try
            {

                $active_process->save();

                foreach ($model as $model_data)
                {
                    $model_data->update($input_candidate);
                }

                DB::commit();
                Session::flash('message', 'Successfully added!');
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());
            }
        }else{
            Session::flash('danger', "Please Check Organization name and Position");
        }

        return redirect()->route('exam-process');

    }


}