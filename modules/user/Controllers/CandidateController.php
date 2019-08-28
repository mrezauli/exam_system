<?php
/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 3/28/2017
 * Time: 1:08 PM
 */

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use App\Helpers\LogFileHelper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\UserLoginHistory;
use App\UserProfile;
use App\UserImage;
use App\User;
use App\Department;
use Modules\Admin\Company;
use Validator;
use App\Helpers\ImageResize;
use App\Role;
use App\UserMeta;
use App\UserResetPassword;
use DateTime;
use App\RoleUser;
use App\UserActivity;
use Modules\Admin\Designation;
use PHPExcel_IOFactory;

use Mockery\CountValidator\Exception;


class CandidateController extends Controller
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

        $pageTitle = "Candidate List";

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select name of the post'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $model = User::select('id','sl','role_id','roll_no','username','dob','nid','company_id','designation_id','status','typing_status','aptitude_status')->with(['relCompany' => function ($query) {

            $query->select('id','company_name','status');

        }])->with(['relDesignation' => function ($query) {

            $query->select('id','designation_name','status');

        }])->where('username','!=','super-admin')->where('role_id',4)->orderBy('id', 'asc')->where('status','active')->orWhereNull('status')->paginate(30);




        return view('user::candidate.index', ['model' => $model, 'pageTitle'=> $pageTitle,'company_list'=>$company_list,'designation_list'=>$designation_list]);
    }

    public function download_user_excel()
    {
        $downloadfolder = 'candidate_list_format/';

        $filename = $downloadfolder."candidate_list_data.xlsx";
        $headers = array(
            'Content-Type: application/xlsx',
        );
        return Response::download($filename, 'candidate_list_data.xlsx', $headers);
    }

    public function create_candidate(Request $request)
    {

        $input = $request->except('excel_file');

        #$fil_in= $_FILES['excel_file']['name'];
        $file2 = Input::file('excel_file');
        $destinationPath = public_path()."/candidate_excel_files/";
        $file2_original_name = $file2->getClientOriginalName();
        $file2_new_name = $input['company_id'].'_'.$input['designation_id'].'_' . str_random(7) .'_' . $file2_original_name;

        $file2->move($destinationPath, $file2_new_name);
        $file = public_path()."/candidate_excel_files/".$file2_new_name;
 

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        //Duplicate value check in candidate list ::

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            $row = 4;
            for ($row; $row <= $highestRow; $row++)
            {
                $val=array();
                for ($col = 0; $col < $highestColumnIndex; ++ $col) 
                {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);

                    //print_r($cell->getValue());exit("ok");

                    $val[] = $cell->getValue();
                }

                /*if($val[0] != null){

                    $roll_no[] = $val[0];
                    $nid[] = $val[2];
                }*/
            }
        }

        /*if(count($roll_no) !== count(array_unique($roll_no)))
        {
            Session::flash('danger', 'Duplicate Roll Number Found ! Please Check.');
            return redirect()->back();
        }

        if(count($nid) !== count(array_unique($nid)))
        {
            Session::flash('danger', 'Duplicate NID Number Found ! Please Check.');
            return redirect()->back();
        }*/

        $exam_number = User::select('sl')->where('company_id',$input['company_id'])->where('designation_id',$input['designation_id'])->max('exam_number');


        $last_user = User::select('sl')->where('company_id',$input['company_id'])->where('designation_id',$input['designation_id'])->where('exam_number',$exam_number)->orderBy('sl','asc')->get()->last();

        


        if ($input['exam_number'] == '0') {

            $exam_number = $exam_number;
            $sl = $last_user->sl;

        }elseif ($input['exam_number'] == '1') {

            $exam_number = $exam_number + 1;
            $sl = '0';

        }else{

            Session::flash('danger',  'Exam number is not found.');
            DB::rollback();
        }


        // if ($exam_number == '') {
        //     $exam_number = '1';
        // }






        //DB
        DB::beginTransaction();
        try
        {
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {

                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

                // $sl = isset($last_user) ? $last_user->sl : 0;
                $row = 4;
                for ($row; $row <= $highestRow; $row++)
                {

                    $val=array();
                    for ($col = 0; $col < $highestColumnIndex; ++ $col)
                    {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val[] = $cell->getValue();
                    }

                    if($val[0] != null){

                        $sl++;

                        $roll_no_exists = User::where('roll_no', $val[0])->exists();
                        $nid_exists = User::where('nid', $val[2])->exists();
                        //$username_exists = User::where('username', $val[0])->exists();
                        //if($roll_no_exists == null && $nid_exists == null)
                        //{
                            $input_data = [
                                'sl'=>$sl,
                                'company_id'=>$input['company_id'],
                                'designation_id'=>$input['designation_id'],
                                'exam_number'=>$exam_number,
                                'roll_no'=>trim($val[0]),
                                'username'=>$val[1],
                                'nid'=>$val[2],
                                'dob'=>trim($val[3]),
                                'password'=>Hash::make(trim($val[0])),
                                'district'=>$val[4],
                                'role_id'=>4,
                                'typing_status'=> 'inactive',
                                'aptitude_status'=> 'inactive',
                                'mcq_status'=> 'inactive',
                                'status'=> 'active',                        
                            ];

                            User::create($input_data);
                            Session::flash('message', "Insert Successfully");
                            DB::commit();
                        //}
                    }
                }
            }




        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            //dd($e->getMessage());
            Session::flash('danger',  $e->getMessage());
            DB::rollback();
        }
        return redirect()->back();

    }

    public function show_candidate($id)
    {
        $pageTitle = 'Candidate Informations';
        $data = User::with('relCompany','relDesignation')->where('id',$id)->first();

        return view('user::candidate.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    public function edit_candidate($id)
    {
        $pageTitle = 'Edit Candidate Information';

        $data = User::with('relCompany','relDesignation')->findOrFail($id);

        return view('user::candidate.update', ['pageTitle'=>$pageTitle,'data' => $data]);
    }

    public function update_candidate(Requests\UserRequest $request, $id)
    {
    
    
        $input = Input::all();
        $model1 = User::findOrFail($id);


        $input_data = [
            'username'=>$input['username'],
            'roll_no'=>trim($input['roll_no']),
            'nid'=>$input['nid'],
            'dob'=>$input['dob'],
            'password'=>Hash::make(trim($input['roll_no'])),
            'district'=> $input['district'],
            'typing_status'=> $input['typing_status'],
            'aptitude_status'=> $input['aptitude_status'],
        ];

        DB::beginTransaction();
        try{

            $model1->update($input_data);

            DB::commit();
            Session::flash('message', "Successfully Updated");
            //LogFileHelper::log_info('update-user', 'Successfully Updated!', ['Username:'.$input['username']]);

        }catch(\Exception $e){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', 'Duplicate NID Number Found ! Please Check.');
            return redirect()->back();
            //LogFileHelper::log_error('update-user', 'error!'.$e->getMessage(), ['Username:'.$input['username']]);
        }

        //role-user update if exists...
        #print_r($model1->role_id);exit;

        return redirect()->back();
    }

    public function destroy_candidate($id)
    {

        $model = User::where('id',$id)->first();
        DB::beginTransaction();
        try {
            
            $model->status = 'inactive';
            $model->last_visit = Null;
            
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            //LogFileHelper::log_info('destroy-user', 'Successfully Deleted!change status to cancel',['User id:'.$model->id]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',"Data Deleted Fail");
            //LogFileHelper::log_error('user-destroy', $e->getMessage(), ['User id:'.$model->id]);
        }
        return redirect()->route('candidate-list');
    }





}