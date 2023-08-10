<?php

/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/17/2017
 * Time: 6:15 PM
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
use Modules\Exam\Examination;
use Modules\Exam\ExamProcess;
use Modules\Exam\AptitudeExamResult;
use Modules\Exam\FileDownloadPermission;
use Session;
use Illuminate\Support\Facades\Input;
use Excel;
use File;
use Validator;
use PHPExcel;
//use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class CandidateReExamController extends Controller
{

    public function index()
    {
        $page_title = "Candidate Re-Exam";

        $exam_code_list =  ['' => 'Select exam code'] + ExamCode::with('exam_code')->where('status', 'active')->orderBy('id', 'desc')->lists('exam_code_name', 'id')->all();


        $exam_process_code_list =  ExamProcess::lists('exam_code_id')->all();

        //$exam_process_code_list =  ExamProcess::orderBy('id','desc')->take('5')->get()->lists('exam_code_id')->all();
        $exam_process_code_list =  ExamProcess::orderBy('id', 'desc')->get()->lists('exam_code_id')->all();

        $exam_code_list = ['' => 'Select exam code'] + collect($exam_code_list)->flip()->intersect($exam_process_code_list)->flip()->all();



        // $data = CandidateReExam::with('exam_code.company','exam_code.designation')->where('status','active')->get();

        return view('exam::candidate_re_exam.index', compact('data', 'page_title', 'exam_code_list'));
    }



    public function update(Requests\CandidateReExamRequest $request)
    {


        $data = $request->all();


        $main_exam_type = ExamCode::find($data['exam_code_id'])->exam_type;


        if ($main_exam_type == 'aptitude_test') {

            $user_data = $request->only(['exam_code_id', 'roll_no']);

            $user_data['aptitude_exam_code_id'] = $user_data['exam_code_id'];

            unset($user_data['exam_code_id']);

            $user = User::where($user_data)->get();
        } else {

            $user_data = $request->only(['exam_code_id', 'roll_no']);

            $user_data['typing_exam_code_id'] = $user_data['exam_code_id'];

            unset($user_data['exam_code_id']);

            $user = User::where($user_data)->get();
        }




        if ($user->isEmpty()) {
            Session::flash('error', "No user found. Please Try Again");
            return redirect()->back()->withInput()->with('exam_type', $data['exam_type']);
        }



        $user_numbers = $user->count();


        // if ($user_numbers > 1) {

        //    Session::flash('error', "More than one user found. Please Try Again");
        //    return redirect()->back()->withInput();

        // }



        if ($main_exam_type == 'aptitude_test') {

            $user->first()->exam_type = 'aptitude_test';

            $user->first()->aptitude_status = $data['status'];

            $user->first()->aptitude_exam_cancel_comments = $data['cancel_comments'];

            $user->first()->started_exam = null;

            $user->first()->aptitude_exam_start_time = null;


            DB::beginTransaction();
            try {

                if (!in_array($request->get('status'), ['cancelled', 'expelled'])) {

                    AptitudeExamResult::where('user_id', $user->first()->id)->where('question_type', 'word')->delete();
                    AptitudeExamResult::where('user_id', $user->first()->id)->where('question_type', 'excel')->delete();
                    AptitudeExamResult::where('user_id', $user->first()->id)->where('question_type', 'ppt')->delete();


                    FileDownloadPermission::where('user_id', $user->first()->id)->where('question_type', 'word')->delete();
                    FileDownloadPermission::where('user_id', $user->first()->id)->where('question_type', 'excel')->delete();
                    FileDownloadPermission::where('user_id', $user->first()->id)->where('question_type', 'ppt')->delete();
                }


                $user->first()->save();

                DB::commit();
                Session::flash('message', "Successfully Reseted Aptitude Test.");
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', "An error occured. Please Try Again");
            }

            return redirect()->back();
        }





        if ($main_exam_type == 'typing_test') {

            $user->first()->exam_type = 'typing_test';

            $user->first()->typing_status = $data['status'];

            $user->first()->typing_exam_cancel_comments = $data['cancel_comments'];




            DB::beginTransaction();
            try {

                if (!in_array($request->get('status'), ['cancelled', 'expelled'])) {

                    if ($request->get('exam_type') != 'all') {

                        Examination::where('user_id', $user->first()->id)->where('exam_type', $request->get('exam_type'))->delete();
                    } else {

                        Examination::where('user_id', $user->first()->id)->where('exam_type', 'bangla')->delete();

                        Examination::where('user_id', $user->first()->id)->where('exam_type', 'english')->delete();
                    }
                }

                $user->first()->save();

                DB::commit();
                Session::flash('message', "Successfully Reset Typing Test.");
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', "An error occurred. Please Try Again");
            }

            return redirect()->back();
        }
    }


    function ajax_get_main_exam_type()
    {

        $exam_code = DB::table('exam_code')->where('id', $_POST['exam_code_id'])->first();

        if (!empty($exam_code)) {

            return $exam_code->exam_type;
        } else {

            return '';
        }
    }


    function ajax_get_answered_text()
    {

        $user = User::where('roll_no', $_POST['roll_no'])->where('typing_exam_code_id', $_POST['exam_code_id'])->first();

        if (isset($user)) {
            $answered_text = !empty($user->typing_test_result()->where('exam_type', $_POST['exam_type'])->first()) ? $user->typing_test_result()->where('exam_type', $_POST['exam_type'])->first()->answered_text : '';
            $username = $user->username;
        } else {

            $answered_text = '';
            $username = '';
        }
        $data['answered_text'] = strip_tags($answered_text);
        $data['username'] = $username;

        return $data;
    }



    function ajax_get_remarks()
    {

        $exam_code_field = $_POST['exam_type'] . '_' . 'code_id';

        $remarks_field = $_POST['exam_type'] . '_' . 'cancel_comments';

        $user = User::where('roll_no', $_POST['roll_no'])->where($exam_code_field, $_POST['exam_code_id'])->first();

        if (isset($user)) {

            $remarks = $user->{$remarks_field};
        } else {

            $remarks = '';
        }


        return strip_tags($remarks);
    }
}
