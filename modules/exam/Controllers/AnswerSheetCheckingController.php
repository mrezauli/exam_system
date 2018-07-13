<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 4/26/2017
 * Time: 12:03 PM
 */

namespace Modules\Exam\Controllers;
//require public_path() . '/assets/cloudconvert/vendor/autoload.php';

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Admin\ExamCode;
use Modules\Exam\AptitudeExamResult;
use Modules\Exam\ExaminerSelection;
use Modules\Question\QuestionPaperSet;
use Session;
use Illuminate\Support\Facades\Input;
use Excel;
use File;
use Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


require base_path() . '/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
//require '/home/qpands/public_html/exam_system' . '/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
use PHPExcel;
use PHPExcel_IOFactory;



class AnswerSheetCheckingController extends Controller
{

    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    public function index()
    {
        $page_title = "Answer Sheet Checking";

        //$data = ExamProcess::with('company','designation')->orderBy('status', 'ASC')->get();

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id', 'desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id', 'desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','aptitude_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();


        return view('exam::answer_sheet_checking.index', compact('page_title', 'company_list', 'designation_list','exam_code_list'));
    }

    public function create($company_id = null, $designation_id = null, $exam_code_id = null, $exam_date = null, $shift = null)
    {

        $page_title = "Answer Sheet Checking";
        $ftp_server = "qpands.com";
        $ftp_username = "uits@qpands.com";
        $ftp_userpass = "uitsuits";

        $examiner_id = Auth::user()->id;
    

   

        if($company_id == null)
        {
            $company_id = Input::get('company_id');
            $designation_id = Input::get('designation_id');
            $exam_date = Input::get('exam_date');
            $shift = Input::get('shift');
            $exam_code_id = Input::get('exam_code_id');
        }
        


        $permission_granted = ExaminerSelection::whereHas('exam_code', function ($query) use ($company_id,$designation_id,$exam_date,$shift){
            $query->where('company_id',$company_id)
                  ->where('designation_id',$designation_id)
                  ->where('exam_date',$exam_date)
                  ->where('shift',$shift);
        })->first();

       
        $permission_granted = ExaminerSelection::where('exam_code_id',$exam_code_id)->first();

        

        if (empty($permission_granted)) {

            Session::flash('danger', "You don't have permission to check answer sheets for this exam.");
            return redirect()->route('answer-checking')->withInput();

        }


        if (Session::has('candidate_id') ) {
            $candidate_id = Session::get('candidate_id');
            $data = User::find($candidate_id);
        }else{

            // $data = User::where('company_id',$company_id)->where('designation_id',$designation_id)->where('exam_date',$exam_date)->where('examined_status',0)->where('started_exam','aptitude_test')->select('id','username','roll_no','designation_id')->first();

            // $data = User::select('id','username','roll_no','designation_id')->where('started_exam','aptitude_test')->where('examined_status',0)->whereHas('exam_code', function ($query) use ($company_id,$designation_id,$exam_date){
            //     $query->where('company_id',$company_id)
            //           ->where('designation_id',$designation_id)
            //           ->where('exam_date',$exam_date);

            // })->first();

            $unchecked_answer_found =  User::where('aptitude_exam_code_id',$exam_code_id)->where('answer_sheet_given',1)->where('examined_status',0)->where('examined_by',$examiner_id)->where('started_exam','aptitude_test')->has('aptitude_test_result')->select('id','username','roll_no','designation_id')->first();


            if ($unchecked_answer_found) {

                $data = $unchecked_answer_found;

            }else{

                $data = User::where('aptitude_exam_code_id',$exam_code_id)->where('answer_sheet_given',0)->where('examined_status',0)->where('examined_by',null)->where('started_exam','aptitude_test')->select('id','username','roll_no','designation_id')->has('aptitude_test_result')->first();

            }

            
        }

        


        // $total_answer_sheet = User::where('company_id',$company_id)->where('designation_id',$designation_id)->where('exam_date',$exam_date)->where('started_exam','aptitude_test')->select('examined_status')->get();

        // $checked_answer_sheet = User::where('company_id',$company_id)->where('designation_id',$designation_id)->where('exam_date',$exam_date)->where('started_exam','aptitude_test')->where('examined_status',1)->select('examined_status')->get();

        // $my_answer_sheet = User::where('company_id',$company_id)->where('designation_id',$designation_id)->where('exam_date',$exam_date)->where('examined_by',$examiner_id)->where('started_exam','aptitude_test')->select('examined_status')->get();



        $total_answer_sheet = User::select('examined_status')->where('started_exam','aptitude_test')->whereHas('aptitude_exam_code', function ($query) use ($company_id,$designation_id,$exam_date,$shift){
            $query->where('company_id',$company_id)
                  ->where('designation_id',$designation_id)
                  ->where('exam_date',$exam_date)
                  ->where('shift',$shift);
        })->get();


        $checked_answer_sheet = User::select('examined_status')->where('examined_status',1)->where('started_exam','aptitude_test')->whereHas('aptitude_exam_code', function ($query) use ($company_id,$designation_id,$exam_date,$shift){
            $query->where('company_id',$company_id)
                  ->where('designation_id',$designation_id)
                  ->where('exam_date',$exam_date)
                  ->where('shift',$shift);
        })->get();


        $my_answer_sheet = User::select('examined_status')->where('examined_status',1)->where('examined_by',$examiner_id)->where('started_exam','aptitude_test')->whereHas('aptitude_exam_code', function ($query) use ($company_id,$designation_id,$exam_date,$shift){
            $query->where('company_id',$company_id)
                  ->where('designation_id',$designation_id)
                  ->where('exam_date',$exam_date)
                  ->where('shift',$shift);
        })->get();

        // dd($total_answer_sheet);

        $answer_sheet_array =[
            'total_answer_sheet'=>count($total_answer_sheet),
            'checked_answer_sheet'=>count($checked_answer_sheet),
            'my_answer_sheet'=>count($my_answer_sheet)
        ];





        if($data != null && ! AptitudeExamResult::with('qsel_apt_test.qbank_aptitude_question')->where('user_id',$data->id)->get()->isEmpty())
        {
           
            $user_data = [
                'answer_sheet_given'=>1,
                'examined_by'=>$examiner_id
            ];
            
            $data->update($user_data);

            $aptitude_exam_sheet = AptitudeExamResult::with('qsel_apt_test.qbank_aptitude_question')->where('user_id',$data->id)->get();

            
            
            $m = 0;

            foreach($aptitude_exam_sheet as $values)
            {
                
                $question_set_id = $values->qsel_apt_test->question_set_id;

                $qbank_aptitude_id = $values->qsel_apt_test->qbank_aptitude_question->id;
              
                $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$question_set_id)->where('status','active')->first();


                $question_mark = isset($question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark) ? $question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark : '0';
                    
            
                $file_html = explode('/', $values->answer_original_file_path);
                $filename_html = explode('.', $file_html[2]);
                $answer_html_files[$m]['type'] = $values->question_type;
                $answer_html_files[$m]['id'] = $values->id;
                $answer_html_files[$m]['mark'] = $question_mark;


                if($values->question_type == 'word')
                {

                    $answer_html_files[$m]['file'] = $filename_html[0].'.docx';

                    //This line for all server
                    copy($values->answer_original_file_path , 'answer_files/image_doc_files/'.$file_html[2]);

                    //***Start****This code only for local host....In cpanel it will be blocked

                    $file = $values->answer_original_file_path;
                    $remote_file = "image_doc_files/".$file_html[2];
                    $ftp_conn = ftp_connect($ftp_server) or die("fff");
                    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
                    ftp_put($ftp_conn, $remote_file, $file, FTP_BINARY);
                    ftp_close($ftp_conn);

                    //***End****This code only for local host....In cpanel it will be blocked
                }
                elseif($values->question_type == 'excel')
                {

                    $answer_html_files[$m]['file'] = $filename_html[0].'.html';

                    //libxml_use_internal_errors(true);

                    $inputFileName = "answer_files/org_excel_files/".$file_html[2];

                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

                    // $ddd = $objPHPExcel->getActiveSheet()->toArray();

                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
                    $objWriter->save("answer_files/image_excel_files/".$filename_html[0].'.html');
                }
                elseif($values->question_type == 'ppt')
                {

                   $answer_html_files[$m]['file'] = $filename_html[0].'.pptx';

                   //This line for all server
                   copy($values->answer_original_file_path , 'answer_files/image_ppt_files/'.$file_html[2]);

                   //***Start****This code only for local host....In cpanel it will be blocked

                   $file = $values->answer_original_file_path;
                   $remote_file = "image_ppt_files/".$file_html[2];
                   $ftp_conn = ftp_connect($ftp_server) or die("fff");
                   $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
                   ftp_put($ftp_conn, $remote_file, $file, FTP_BINARY);
                   ftp_close($ftp_conn);

                   //***End****This code only for local host....In cpanel it will be blocked
                }
                $m++;
            }
        }
        else{

            $answer_html_files = [];
            Session::flash('danger', "Candidate Answer Sheet Not Available !!!");
        }


        return view('exam::answer_sheet_checking.answer_sheet_index', compact('page_title','answer_html_files','company_id','designation_id','exam_code_id','exam_date','shift','data','answer_sheet_array'));
        
    }

    public function store(Requests\AnswerSheetCheckingRequest $request)
    {

        $input= $request->all();


        for ($i=1; $i <= $input['count']; $i++)
        {


            $aptitude_exam_result_id = $input['marks_id_'.$i];
            $marks = $input['marks_'.$i];
            $question_marks = $input['question_marks_'.$i];



            if ($marks > $question_marks || (! is_numeric($marks) )) {


                $candidate_id = $input['candidate_id'];
                $model = User::find($candidate_id);


                if($model !=null)
                {

                    $user_data = [
                    'examined_status'=>0,
                    'examined_by'=>null
                    ];

                    DB::beginTransaction();
                    try {
                        $model->update($user_data);
                        DB::commit();

                    }
                    catch ( Exception $e ){
                                    //If there are any exceptions, rollback the transaction
                        DB::rollback();
                                    //Session::flash('danger', $e->getMessage());
                        Session::flash('danger', "An error occured. Please Try Again.");
                    }


                }


                Session::flash('danger', "Answer mark must be a valid number and can't be greater than the question mark.");

                return redirect()->route('start-checking',[$input['company_id'], $input['designation_id'], $input['exam_code_id'], $input['exam_date']])->withInput()->with('candidate_id',$input['candidate_id']);

            }


        }



        for ($i=1; $i <= $input['count']; $i++)
        {

            $aptitude_exam_result_id = $input['marks_id_'.$i];
            $marks = $input['marks_'.$i];
            $question_marks = $input['question_marks_'.$i];

          

         
            $input_data = [
                'answer_marks'=>$marks
            ];

            $model = AptitudeExamResult::where('id',$aptitude_exam_result_id)->first();

            DB::beginTransaction();
            try {
                $model->update($input_data);
                DB::commit();
                Session::flash('message', "Marks Saved Successfully.");
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't Save Successfully. Please Try Again.");
            }
        }


        $candidate_id = $input['candidate_id'];
        $model = User::find($candidate_id);

        $user_data = [
            'examined_status'=>1,
        ];
        
       $model->update($user_data);



        DB::beginTransaction();
        try {
          //  $model->update($user_data);
            DB::commit();
            Session::flash('message', "Answer sheet checked Successfully.");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Check Answer Sheet Successfully. Please Try Again.");
        }


        return redirect()->route('next-checking', [$input['company_id'],$input['designation_id'],$input['exam_code_id'],$input['exam_date'],$input['shift']]);

    }


    public function download_candidate_answersheet($id)
    {
        $model = AptitudeExamResult::where('id',$id)->first();

        $filename = $model['answer_original_file_path'];

        $file = explode('/', $filename);

        $headers = array(
            'Content-Type: application/xlsx',
        );
        return Response::download($filename, $file[2], $headers);
    }

}