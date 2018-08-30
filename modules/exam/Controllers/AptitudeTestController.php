<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 3/9/2017
 * Time: 3:53 PM
 */

namespace Modules\Exam\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Modules\Exam\AptitudeExamResult;
use Modules\Admin\ExamTime;
use Modules\Admin\ExamCode;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Modules\Exam\FileDownloadPermission;
use Modules\Question\QBankAptitudeTest;
use Modules\Question\QSelectionAptitudeTest;
use Session;
use Cookie;
use URL;
use Illuminate\Support\Facades\Input;
use Excel;
use File;
use Validator;
use PHPExcel;
//use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class AptitudeTestController extends Controller
{

    public function index()
    {
        $page_title = "Aptitude Test";
        
        return view('exam::aptitude_exam.index', compact('page_title'));
    }

    public function aptitude_question()
    {

        $user = Auth::user();
        $user_id = $user->id;
        $user_data = User::where('id',$user_id)->first();


        /*$users = QSelectionAptitudeTest::with(['file_download' => function ($query) use($user_id) {
            $query->where('user_id', $user_id);

        }])->get();*/


        $page_title = "Aptitude Test";

        $apt_test_questions = QSelectionAptitudeTest::with('qbank_aptitude_question')
            ->with(['file_download' => function ($query) use($user_id) {
                $query->where('user_id', $user_id);
                $query->where('status', 'active');
            }])
            ->where('exam_code_id',$user->aptitude_exam_code_id)
            ->where('status','active')
            ->get();


            $exam_code = $apt_test_questions->first()->exam_code()->first()->exam_code_name;

            $default_time = ExamTime::where('exam_type','aptitude_exam')->first()->exam_time;

            $user = Auth::user();

            if (empty($user->started_exam)) {

                setcookie("file_upload", "", time()-3600, "/");
                setcookie("file_upload_start_time", "", time()-3600, "/");
                
                $user->started_exam = 'aptitude_test';
                $remove_alert_cookie = true;
                $user->aptitude_exam_start_time = date('Y-m-d H:i:s');
                $user->save();

            }else{

                $remove_alert_cookie = false;

            }

            
            $start_time = $user->aptitude_exam_start_time;

            $passed_time = time()-strtotime($start_time);

            $remaining_time = $default_time*60 - $passed_time;



        $final_submit = AptitudeExamResult::with('qsel_apt_test')->where('user_id',$user_id)->get();

        //dd($user_id);exit("ok");

        //setcookie("aptitude_exam_time", "", time() - 3600,'/');

        return view('exam::aptitude_exam.question_index', compact('remove_alert_cookie','page_title','apt_test_questions','final_submit','default_time','start_time','default_time','remaining_time','exam_code'));
    }

    public function download_new_doc($selection_id,$qbank_aptitude_id)
    {


        $user_id = Auth::user()->id;
        $user_name = Auth::user()->username;

        $question_title = QBankAptitudeTest::where('id',$qbank_aptitude_id)->first()->title;

        

        $input['qselection_aptitude_id'] = $selection_id;
        $input['user_id'] = $user_id;
        $input['open_flag'] = 1;
        $input['question_type'] = 'word';
        $input['status'] = 'active';


        $model = new FileDownloadPermission();
        $model->create($input);

        $downloadfolder = 'attachment/';
        $filename = $downloadfolder."sample_doc.docx";

        $file = $user_id.'_'.$selection_id.'_'.$user_name.'_ansdoc'.'_'.$question_title.'.docx';

        if (file_exists($filename)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="' . $file . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;

        }

    }

    public function down_csv_file($selection_id,$qbank_aptitude_id)
    {

        $user_id = Auth::user()->id;
        $user_name = Auth::user()->username;

        $question_title = QBankAptitudeTest::where('id',$qbank_aptitude_id)->first()->title;

        $input['qselection_aptitude_id'] = $selection_id;
        $input['user_id'] = $user_id;
        $input['open_flag'] = 1;
        $input['question_type'] = 'excel';
        $input['status'] = 'active';

        $model = new FileDownloadPermission();
        $model->create($input);


        $file_name = $user_id.'_'.$selection_id.'_'.$user_name.'_ansexcel'.'_'.$question_title;

        Excel::create($file_name, function($excel) {

            // Set the title
            $excel->setTitle('My awesome report 2016');

            // Chain the setters
            $excel->setCreator('Me')->setCompany('Our Code World');

            $excel->setDescription('A demonstration to change the file properties');

            $data = [];

            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
                $sheet->setPrintGridlines('TRUE');
            });

        })->download('xlsx');

        //return Response::download('attachment/sample_excel.csv', $user_id.'_'.$selection_id.'_ansexcel.csv', ['Content-Type: text/cvs']);
    }

    public function down_ppt_file($selection_id,$qbank_aptitude_id)
    {
        
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->username;

        $question_title = QBankAptitudeTest::where('id',$qbank_aptitude_id)->first()->title;

        $input['qselection_aptitude_id'] = $selection_id;
        $input['user_id'] = $user_id;
        $input['open_flag'] = 1;
        $input['question_type'] = 'ppt';
        $input['status'] = 'active';

        $model = new FileDownloadPermission();
        $model->create($input);

        $downloadfolder = 'attachment/';
        $filename = $downloadfolder."sample_ppt.pptx";

        $file = $user_id.'_'.$selection_id.'_'.$user_name.'_ansppt'.'_'.$question_title.'.pptx';

        if (file_exists($filename)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
            header('Content-Disposition: attachment; filename="'. $file .'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;

        }
     
    }

    public function answer_submit(Requests\AptitudeExamRequest $request)
    {

        $input_count = $request->except('file_upload_attachment','_token');

        $count = $input_count['q_no'];

        $user_id = Auth::user()->id;

        $attachments=Input::file('file_upload_attachment');

        $file_count = count($attachments);



        /*if($count!= $file_count){

            return redirect()->back()->with('ddd','1');

        }*/



        if(isset($attachments))
        {
            foreach($attachments as $attachment)
            {
                $rules = array();
                $validator = Validator::make(array('file' => $attachment), $rules);

                if ($validator->passes())
                {
                    if(isset($attachment))
                    {
                        $file_original_name = $attachment->getClientOriginalName();
                        $original_file = (explode('_',$file_original_name));

                        // dd($original_file);

                        if($original_file['3'] == 'ansdoc')
                        {
                            $upload_folder = 'answer_files/org_doc_files/';

                            //exit($file_original_name);

                            $attachment->move($upload_folder, $file_original_name);

                            $attachment3 = $upload_folder . $file_original_name;

                            $input['qselection_aptitude_id'] = $original_file[1];
                            $input['user_id'] = $user_id;
                            $input['question_type'] = 'word';
                            $input['answer_original_file_path'] = $attachment3;
                            $input['status'] = 'active';


                            //dd($input);
                            $model = new AptitudeExamResult();

                            DB::beginTransaction();
                            try{

                                $model->create($input);


                                DB::commit();
                                Session::flash('message','Success!!' . ' ' . $file_count . ' ' . 'Files Successfully Submited!');

                            }catch(\Exception $e) {

                                DB::rollback();

                                //dd($e->getMessage());
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }

                        }

                        elseif($original_file['3'] == 'ansexcel')
                        {
                            $upload_folder = 'answer_files/org_excel_files/';

                            $attachment->move($upload_folder, $file_original_name);
                            $attachment3 = $upload_folder . $file_original_name;

                            $input['qselection_aptitude_id'] = $original_file[1];
                            $input['user_id'] = $user_id;
                            $input['question_type'] = 'excel';
                            $input['answer_original_file_path'] = $attachment3;
                            $input['status'] = 'active';

                            $model = new AptitudeExamResult();

                            DB::beginTransaction();
                            try{

                                Session::flash('message','Success!!' . ' ' . $file_count . ' ' . 'Files Successfully Submited!');

                                $model->create($input);
                                DB::commit();

                            }catch(\Exception $e) {

                                DB::rollback();
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }

                        }elseif($original_file['3'] == 'ansppt')
                        {
                            $upload_folder = 'answer_files/org_ppt_files/';

                            $attachment->move($upload_folder, $file_original_name);
                            $attachment3 = $upload_folder . $file_original_name;

                            $input['qselection_aptitude_id'] = $original_file[1];
                            $input['user_id'] = $user_id;
                            $input['question_type'] = 'ppt';
                            $input['answer_original_file_path'] = $attachment3;
                            $input['status'] = 'active';

                            $model = new AptitudeExamResult();

                            DB::beginTransaction();
                            try{

                                $model->create($input);
                                DB::commit();

                                Session::flash('message','Success!!' . ' ' . $file_count . ' ' . 'Files Successfully Submited!');

                            }catch(\Exception $e) {

                                DB::rollback();
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }

                        }
                    }
                }
                else
                {

                    Session::flash('danger','An error occured. Please try again.');
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }


        $url = URL::previous();

        $link_array = explode('/', $url);

        $page = end($link_array);


        if ($page == 'file-upload') {

            return redirect()->route('aptitude-congratulation');
            
        }

        return redirect()->back();

    }


    public function answer_redownload($aptitude_exam_result_id,$qbank_aptitude_id)
    {

        $user_id = Auth::user()->id;
        $user_name = Auth::user()->username;

        $aptitude_exam_result = AptitudeExamResult::where('id', $aptitude_exam_result_id)->first();
        $answer_original_file_path = $aptitude_exam_result->answer_original_file_path;

        $question_title = QBankAptitudeTest::where('id',$qbank_aptitude_id)->first()->title;



        if($aptitude_exam_result->question_type == 'word')
        {

            $file_name = $user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_'.$user_name.'_ansdoc'.'_'.$question_title.'.docx';

            $input['re_submit_flag'] = 1;
            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();

            $model->update($input);


            $headers = array(
                'Content-Type: application/docx',
            );
            return Response::download($answer_original_file_path, $file_name, $headers);

        }
        elseif($aptitude_exam_result->question_type == 'excel')
        {

            $file_name = $user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_'.$user_name.'_ansexcel'.'_'.$question_title.'.xlsx';

            $input['re_submit_flag'] = 1;
            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();

            $model->update($input);

            $headers = array(
                'Content-Type: application/xlsx',
            );
            return Response::download($answer_original_file_path, $file_name, $headers);
        }
        elseif($aptitude_exam_result->question_type == 'ppt')
        {

            $file_name = $user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_'.$user_name.'_ansppt'.'_'.$question_title.'.pptx';

            $input['re_submit_flag'] = 1;
            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();

            $model->update($input);

            $headers = array(
                'Content-Type: application/pptx',
            );
            return Response::download($answer_original_file_path, $file_name, $headers);
        }

        return redirect()->route('aptitude-question');

    }


    public function answer_re_submit(Requests\AptitudeExamRequest $request)
    {

        $user_id = Auth::user()->id;
        $attachments=Input::file('file_upload_attachment');


        $count = $request->only('q_no')['q_no'];

        $file_count = count($attachments);


        if($count!= $file_count){

            //return redirect()->back()->with('ddd','1');

        }



        if(isset($attachments))
        {
            foreach($attachments as $attachment)
            {
                $rules = array();
                $validator = Validator::make(array('file' => $attachment), $rules);

                if ($validator->passes())
                {
                    if(isset($attachment))
                    {
                        $file_original_name = $attachment->getClientOriginalName();
                        $original_file = (explode('_',$file_original_name));


                        $input['qselection_aptitude_id'] = $original_file[1];
                            $input['user_id'] = $user_id;
                            $input['re_submit_flag'] = 0;
                            $input['status'] = 'active';



                        if($original_file['3'] == 'ansdoc')
                        {

                            $model = AptitudeExamResult::where('user_id',$user_id)->where('qselection_aptitude_id',$original_file[1])->first();

                            $upload_folder = 'answer_files/org_doc_files/';

                            


                            $attachment->move($upload_folder, $file_original_name);

                            
                            DB::beginTransaction();
                            try{

                                if (empty($model)) {

                                $input['answer_original_file_path'] = $upload_folder . $file_original_name;

                                $input['question_type'] = 'word';

                                $model = new AptitudeExamResult();

                                $model->create($input);

                                //return $this->answer_submit($request);
                                
                            }else{

                                $model->update($input);

                            }
                                
                                //Session::flash('message','Success!! Files Successfully Submited!');
                                DB::commit();

                            }catch(\Exception $e) {

                                DB::rollback();
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }
                        }
                        elseif($original_file['3'] == 'ansexcel')
                        {

                            $model = AptitudeExamResult::where('user_id',$user_id)->where('qselection_aptitude_id',$original_file[1])->first();

                            $upload_folder = 'answer_files/org_excel_files/';

                            


                            $attachment->move($upload_folder, $file_original_name);

                            
                            DB::beginTransaction();
                            try{

                                if (empty($model)) {

                                $input['answer_original_file_path'] = $upload_folder . $file_original_name;

                                $input['question_type'] = 'excel';

                                $model = new AptitudeExamResult();

                                $model->create($input);

                                //return $this->answer_submit($request);
                                
                            }else{

                                $model->update($input);

                            }
                                DB::commit();

                            }catch(\Exception $e) {

                                DB::rollback();
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }

                        }
                        elseif($original_file['3'] == 'ansppt')
                        {

                            $model = AptitudeExamResult::where('user_id',$user_id)->where('qselection_aptitude_id',$original_file[1])->first();

                            $upload_folder = 'answer_files/org_ppt_files/';

                            


                            $attachment->move($upload_folder, $file_original_name);

                            
                            DB::beginTransaction();
                            try{

                                if (empty($model)) {

                                $input['answer_original_file_path'] = $upload_folder . $file_original_name;

                                $input['question_type'] = 'ppt';

                                $model = new AptitudeExamResult();

                                $model->create($input);

                                //return $this->answer_submit($request);
                                
                            }else{

                                $model->update($input);

                            }
                            DB::commit();

                            }catch(\Exception $e) {

                                DB::rollback();
                                Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                            }

                        }
                    }
                }
                else
                {

                    Session::flash('danger','An error occured. Please try again.');
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }

        Session::flash('message','Success!!' . ' ' . $file_count . ' ' . 'Files Successfully Updated!');

        $url = URL::previous();

        $link_array = explode('/', $url);

        $page = end($link_array);


        if ($page == 'file-upload') {

            return redirect()->route('aptitude-congratulation');
            
        }

        return redirect()->back();

    }




    public function aptitude_congratulation()
    {

        $page_title = 'Congratulations';

        return view('exam::aptitude_exam.congratulation',compact('page_title'));

    }




    public function file_upload()
    {

        $page_title = 'File Upload';

        $user = Auth::user();

        $user_id = $user->id;

        $exam_code = ExamCode::find($user->aptitude_exam_code_id)->exam_code_name;


        $submitted_files = AptitudeExamResult::where('user_id',$user_id)->get();

        $apt_test_questions = QSelectionAptitudeTest::with(['file_download' => function ($query) use($user_id) {
                $query->where('user_id', $user_id);
                $query->where('status', 'active');
            }])
            ->where('exam_code_id',$user->aptitude_exam_code_id)
            ->where('status','active')
            ->get()
            ->count();

        


            if (!isset($_COOKIE['file_upload'])) {

              setcookie('file_upload', 1, time() + (86400 * 30), "/");
              setcookie('file_upload_start_time', date('Y-m-d H:i:s'), time() + (3600 * 3), "/");

          }

    

            $file_upload_start_time = isset($_COOKIE['file_upload_start_time']) ? $_COOKIE['file_upload_start_time'] : date('Y-m-d H:i:s'); 

            $passed_time = time()-strtotime($file_upload_start_time);

            $remaining_time = 15*60 - $passed_time;

            //dd($remaining_time);

        return view('exam::aptitude_exam.file_upload',compact('submitted_files','apt_test_questions','start_time','default_time','remaining_time','exam_code'));

    }




    public function ajax_get_file_upload_info()
    {

        $user_id = $_POST['user_id'];
        $question_no = $_POST['question_no'];

      $exams = AptitudeExamResult::select('re_submit_flag')->where('user_id', $user_id)->get();

      $re_submit_flag = isset($exams->where('re_submit_flag',1)->first()->re_submit_flag) ? $exams->where('re_submit_flag',1)->first()->re_submit_flag : 0;

      if ($exams->count()!= $question_no || $re_submit_flag) {

          return 'all_files_not_submitted';

      }else{

        return 0;

      }

    }


    /*public function answer_submit()
    {
        $user_id = Auth::user()->id;

        exec('wmic COMPUTERSYSTEM Get UserName', $user);
        $pc_user = (explode('\\',$user[1]));
        $download_location = "c:/users/$pc_user[1]/downloads/";

        $question_selection_id = QSelectionAptitudeTest::where('company_id',1)->where('designation_id',4)->where('exam_date','2017-03-05')->get();

        foreach($question_selection_id as $value)
        {
            if($value->question_type == 'word')
            {
                $down_file_name = $user_id.'_'.$value->id.'_'.'ansdoc.docx';
                $download_full_path = $download_location.$down_file_name;
                copy($download_full_path, 'answer_files/org_doc_files/'.$down_file_name);

                $input['qselection_aptitude_id'] = $value->id;
                $input['user_id'] = $user_id;
                $input['question_type'] = 'word';
                $input['answer_original_file_path'] = 'answer_files/org_doc_files/'.$down_file_name;
                $input['status'] = 'active';

                $model = new AptitudeExamResult();

                DB::beginTransaction();
                try{

                    unlink($download_full_path);
                    Session::flash('message','Success!! Files Successfully Submited!');

                    $model->create($input);
                    DB::commit();

                }catch(\Exception $e) {

                    DB::rollback();
                    Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                }
            }
            elseif($value->question_type == 'excel')
            {
                $down_file_name = $user_id.'_'.$value->id.'_'.'ansexcel.xlsx';
                $download_full_path = $download_location.$down_file_name;
                copy($download_full_path, 'answer_files/org_excel_files/'.$down_file_name);

                $input['qselection_aptitude_id'] = $value->id;
                $input['user_id'] = $user_id;
                $input['question_type'] = 'excel';
                $input['answer_original_file_path'] = 'answer_files/org_excel_files/'.$down_file_name;
                $input['status'] = 'active';

                $model = new AptitudeExamResult();

                DB::beginTransaction();
                try{

                    unlink($download_full_path);
                    Session::flash('message','Success!! Files Successfully Submited!');

                    $model->create($input);
                    DB::commit();

                }catch(\Exception $e) {

                    DB::rollback();
                    Session::flash('danger','ERROR!! Files Not Submited! Before Submit Save All Files Then Close All Files.');
                }
            }
        }

        return redirect()->route('aptitude-question');
    }

    public function answer_redownload($aptitude_exam_result_id)
    {


        exec('wmic COMPUTERSYSTEM Get UserName', $user);
        $pc_user = (explode('\\',$user[1]));
        $download_location = "c:/users/$pc_user[1]/downloads/";


        $aptitude_exam_result = AptitudeExamResult::where('id', $aptitude_exam_result_id)->first();
        $answer_original_file_path = $aptitude_exam_result->answer_original_file_path;

        if($aptitude_exam_result->question_type == 'word')
        {

            $file_name = $aptitude_exam_result->user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_ansdoc.docx';

            $input['re_submit_flag'] = 1;
            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();
            $model->update($input);


            $headers = array(
                'Content-Type: application/docx',
            );
            return Response::download($answer_original_file_path, $file_name, $headers);

        }
        elseif($aptitude_exam_result->question_type == 'excel')
        {
            $file_name = $aptitude_exam_result->user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_ansexcel.xlsx';

            $input['re_submit_flag'] = 1;
            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();
            $model->update($input);

            $headers = array(
                'Content-Type: application/xlsx',
            );
            return Response::download($answer_original_file_path, $file_name, $headers);
        }

        return redirect()->route('aptitude-question');

    }


    public function answer_re_submit($aptitude_exam_result_id)
    {

        $user_id = Auth::user()->id;

        exec('wmic COMPUTERSYSTEM Get UserName', $user);
        $pc_user = (explode('\\',$user[1]));
        $download_location = "c:/users/$pc_user[1]/downloads/";

        $aptitude_exam_result = AptitudeExamResult::where('id', $aptitude_exam_result_id)->first();
        $answer_original_file_path = $aptitude_exam_result->answer_original_file_path;

        if($aptitude_exam_result->question_type == 'word')
        {
            $file_name = $aptitude_exam_result->user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_ansdoc.docx';
            $download_full_path = $download_location.$file_name;
            $ans_org_doc_path = 'answer_files/org_doc_files/'.$file_name;

            $file_exist = file_exists($download_full_path);

            if($file_exist == 1)
            {
                DB::beginTransaction();
                try{

                    unlink($ans_org_doc_path);
                    copy($download_full_path, $ans_org_doc_path);

                    unlink($download_full_path);

                    Session::flash('message','Success!! Files Successfully Submited!');

                    //$input['re_submit_flag'] = 0;
                    //$model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();
                    //$model->update($input);

                }catch(\Exception $e) {

                    DB::rollback();
                    Session::flash('danger','ERROR!! Files Not Re-Submited! Before Re-Submit Save All Files Then Close All Files.');
                }
            }
            else
            {
                Session::flash('danger','ERROR!! Files Not Re-Submited! Before Re-Submit Download The File And Save Then Close The File.');
            }
        }
        elseif($aptitude_exam_result->question_type == 'excel')
        {
            $file_name = $aptitude_exam_result->user_id.'_'.$aptitude_exam_result->qselection_aptitude_id.'_ansexcel.xlsx';
            $download_full_path = $download_location.$file_name;
            $ans_org_doc_path = 'answer_files/org_excel_files/'.$file_name;

            $file_exist = file_exists($download_full_path);

            if($file_exist == 1)
            {
                DB::beginTransaction();
                try{

                    unlink($ans_org_doc_path);
                    copy($download_full_path, $ans_org_doc_path);

                    unlink($download_full_path);

                    Session::flash('message','Success!! Files Successfully Submited!');

                    //$input['re_submit_flag'] = 0;
                    //$model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();
                    //$model->update($input);

                }catch(\Exception $e) {

                    DB::rollback();
                    Session::flash('danger','ERROR!! Files Not Re-Submited! Before Re-Submit Save All Files Then Close All Files.');
                }
            }
            else
            {
                Session::flash('danger','ERROR!! Files Not Re-Submited! Before Re-Submit Download The File And Save Then Close The File.');
            }

        }

        return redirect()->route('aptitude-question');

    }
    */





    public function rnd_methods()
    {
        $download_location = "http://127.0.0.1/shajjad.docx";
        unlink($download_location);

        exit("ok");
        /*********Get User Name***********/

        //C:\Users\".getenv('USERNAME')."\Desktop'
        //$user = 'C:\Users\'..getenv('USERNAME');

        /*exec('wmic COMPUTERSYSTEM Get UserName', $user);
        $pc_user = (explode('\\',$user[1]));
        $download_location = "c:/users/$pc_user[1]/downloads/sample_123456456.docx";*/

        /********* Copy file One directory to another ***********/

        //copy($download_location, 'attachment/sample_123456456.docx');

        /********* Download and Store a new DOC File ***********/

        $file="answer_files/org_excel_files/1_2_ansexcel.xlsx";
        $headers = array(
            'Content-Type: application/docx',
        );
        return Response::download($file, '1_2_ansexcel.xlsx', $headers);

        /********* Create, Download and Store a new Excel File ***********/

        //$upload_folder = 'attachment/';
        //$file_name = 'saju_101';

        /*Excel::create('Report2016', function($excel) {

            // Set the title
            $excel->setTitle('My awesome report 2016');

            // Chain the setters
            $excel->setCreator('Me')->setCompany('Our Code World');

            $excel->setDescription('A demonstration to change the file properties');

            $data = [];

            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A3');
            });

        })->download('xlsx');*/
       // ->store('xls',$upload_folder)->download();
        // or  ->store('xls', storage_path('excel-folder'));

        /********* Copy file One directory to another ***********/

        //copy($download_location, 'attachment/new_name2.xls');

        /*********File Generate Part***********/

        /*$file= $download_location."new_name.xls";
        $headers = array(
            'Content-Type: application/xls',
        );
        return Response::download($file, 'shajjad.xls', $headers);*/

        //unlink($download_location.'shajjad.xls');

        /*********File Read Part***********/

        /*$handle = fopen($file, "w");
        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            echo $buffer;
        }
        fclose($handle);*/

        /*********Create New File and Store in Specific Location***********/

        //Storage::disk('partitionE')->put('adnan.xls', null);

        //$content = Storage::disk('partitionE')->get('adnan.xls');
        //print_r($content);

        //Storage::disk('downloads')->put('file.xls', 'Contents');

        /*********PDF File Read Part***********/

        /*$filename = 'attachment/abcd.pdf';

        return Response::make(file_get_contents($filename), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);

        return readfile('attachment/Report2016.xls');*/

    }

}



