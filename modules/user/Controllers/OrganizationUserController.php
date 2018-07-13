<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/25/16
 * Time: 11:54 AM
 */

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\RoleUser;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Company;
use Modules\Admin\Product;
use Modules\Admin\JobArea;
use App\Http\Requests;
use Validator;
use DB;
use Session;
use Input;


class OrganizationUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
         */
    public function index()
    {

        $pageTitle = "User List";

        $model = User::with('relCompany')->where('status','!=','cancel')->where('role_id','5')->orderBy('id', 'DESC')->paginate(30);

        $company_list =  [''=>'Select Organization'] + Company::orderBy('id','desc')->where('status','active')->lists('company_name','id')->all();
        
        $role =  [''=>'Select Role'] +  Role::where('role.title', '!=', 'super-admin')->lists('title','id')->all();
        /*set 30days for expire-date to user*/
        $i=90;
        $add_days = +$i.' days';
        //$days= date('Y/m/d H:i:s', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));
        $days= date('Y/m/d', strtotime($add_days, strtotime(date('Y/m/d'))));

        $user_role = Session::get('role_title');


        return view('user::organization_user.index', ['model' => $model, 'pageTitle'=> $pageTitle,'company_list'=>$company_list,'role'=>$role,'days'=>$days,'user_role' => $user_role]);
    }

  


    public function add_organization_user(){

        $company_list =  [''=>'Select Organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();


        return view('user::organization_user.registration', compact('company_list'));

    }







    public function store_organization_user(Requests\OrganizationUserRequest $request){


        $input = $request->all();


        
        

    if (! Auth::check()) {

        $secret_key = '6LeOZxcUAAAAAPpGnX_6Ik9LMGHkszc2A4WQnFC-';

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$input['g-recaptcha-response']);

        $responseData = json_decode($verifyResponse);

        if(empty($input['g-recaptcha-response'])){
            Session::flash('danger', "Google varification is required.");
            return redirect()->back();

        }elseif(! $responseData->success){

            Session::flash('danger', "Please fill out the google captcha correctly.");
            return redirect()->back();

        }
    }



        $user = User::where('company_id',$input['company_id'])->where('role_id',5)->first();


        if ( isset($user->company_id)) {

            Session::flash('danger', 'Organization is already registered.');
            return redirect()->back();
        }

        

        date_default_timezone_set("Asia/Dacca");
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $input_data = [
                'username'=>$input['username'],
                'middle_name'=>$input['middle_name'],
                'last_name'=>$input['last_name'],
                'email'=>$input['email'],
                'password'=>Hash::make($input['password']),
                'csrf_token'=> str_random(30),
                'ip_address'=> getHostByName(getHostName()),
                'company_id'=> $input['company_id'],
                'status'=> 'inactive',
                'role_id'=>5,
                'expire_date'=>'3000-01-01',
            ];

            $role_user = '';

            if($user = User::create($input_data)){

                $company = Company::find($input['company_id']);

                $company->email = $input['email'];

                $company->save();

                $role_organization_user = [
                    'user_id'=>$user['id'],
                    'role_id'=>5,
                    'status'=>'inactive',
                ];
            $role_user = RoleUser::create($role_organization_user);
            }



            // if($role_user){

            //     $data = $request->only('contact_person','designation','phone','mobile','email','address','web_address');

            //     $model = Company::findOrFail($input['company_id']);
                
            //    DB::beginTransaction();
            //    try {
            //        $model->update($data);
            //        DB::commit();
            //        Session::flash('message', "Successfully Updated");
            //    }
            //    catch ( Exception $e ){
            //        //If there are any exceptions, rollback the transaction
            //        DB::rollback();
            //        Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
            //        return redirect()->back();

            //    }

            // }




            DB::commit();
            Session::flash('message', 'Successfully Registered!');
            //LogFileHelper::log_info('user-add', 'Successfully added!', ['Username: '.$input_data['username']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', 'An Error Occured. Please Try Again.');

            if (Auth::check()) {
                return redirect()->back();
            }

            return redirect()->route('login');
            //LogFileHelper::log_error('user-add', $e->getMessage(), ['Username: '.$input['username']]);


        }

    if (Auth::check()) {
        return redirect()->back();
    }

        return redirect()->route('login');
    }





    public function show_organization_user($id)
    {
        $pageTitle = 'User Informations';
        $data = User::with('relCompany','relRoleInfo')->where('id',$id)->first();

        return view('user::user.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    public function edit_organization_user($id)
    {
        $pageTitle = 'Edit User Information';

        $data = User::with('relCompany')->findOrFail($id);
        $branch_data =  Company::lists('company_name','id');
        $role =  Role::lists('title','id');

        return view('user::user.update', ['pageTitle'=>$pageTitle,'data' => $data,'branch_data'=>$branch_data,'role'=>$role]);
    }

    public function update_organization_user(Requests\UserRequest $request, $id)
    {

        $input = Input::all();
        $model1 = User::findOrFail($id);

        if($input['password2']!=Null){
            $password = Hash::make($input['password2']);
        }else{
            $password =  $input['password'];
        }
        $input_data = [
            'username'=>$input['username'],
            'middle_name'=>$input['middle_name'],
            'last_name'=>$input['last_name'],
            'email'=>$input['email'],
            'password'=>$password,
            'csrf_token'=> str_random(30),
            'ip_address'=> getHostByName(getHostName()),
            'company_id'=> $input['company_id'],
            'expire_date'=> $input['expire_date'],
            'status'=> $input['status'],
        ];
        DB::beginTransaction();
        try{
            $model1->update($input_data);

            DB::commit();
            Session::flash('message', "Successfully Updated");
            //LogFileHelper::log_info('update-user', 'Successfully Updated!', ['Username:'.$input['username']]);

        }catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', $e->getMessage());
            //LogFileHelper::log_error('update-user', 'error!'.$e->getMessage(), ['Username:'.$input['username']]);
        }

        //role-user update if exists...
        #print_r($model1->role_id);exit;

        return redirect()->back();
    }












    public function file_upload($file,$file_type_required,$destinationPath){
     
        if ($file != '') {
            $file_name = ($_FILES['files']['name']);
            

          
            //$targetFile=$destinationPath.$file_name;
    


            //$rules = array('file' => 'required|mimes:png,jpeg,jpg');
            $rules = array('file' => 'required|mimes:'.$file_type_required);
            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                // Files destination
                //$destinationPath = 'uploads/slider_file/';
                // Create folders if they don't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $random_number = rand(111, 999);
                $file_name = $random_number.$file->getClientOriginalName();
        

                $upload_success = $file->move($destinationPath, $file_name);

                $file=array($destinationPath . $file_name);

                if ($upload_success) {
                    return $file_name = $file;
                }
                else{
                    return $file_name = '';
                }
            }
            else{
                return $file_name = '';
            }
        }
    }




}