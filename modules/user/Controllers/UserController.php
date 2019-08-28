<?php

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

use Mockery\CountValidator\Exception;


class UserController extends Controller
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

        $pageTitle = "User List";

        $user_role = Session::get('role_title');
        $user_id = Auth::user()->id;


        $ddd = User::select('id')->get();

        //dd($ddd);

        for ($i=7000; $i < 51010 ; $i++) {

            //$email ='ddd@ddd.com';
            
            //DB::select("INSERT INTO `user` (`id`, `sl`, `roll_no`, `username`, `middle_name`, `last_name`, `nid`, `email`, `password`, `dob`, `district`, `role_id`, `company_id`, `designation_id`, `typing_exam_code_id`, `aptitude_exam_code_id`, `exam_type`, `exam_date`, `shift`, `status`, `typing_status`, `aptitude_status`, `mcq_status`, `attended_typing_test`, `attended_aptitude_test`, `started_exam`, `aptitude_exam_start_time`, `examined_status`, `answer_sheet_given`, `examined_by`, `department_id`, `last_visit`, `expire_date`, `remember_token`, `auth_key`, `access_token`, `csrf_token`, `ip_address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES ($i, NULL, NULL, 'ddddddddd', '', '', NULL, '', 'Ke2YFfo2erPPnpju4eR9KXES', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, '2017-10-07 03:33:06', '2020-06-04 10:47:37', 'hhLEwGPvhEpra6YY1pfeNRM3BSy7QXzBzt0xqJvitYUxkxeaRolBCEHZZ8eG', NULL, NULL, 'XRI87AC6YAcKqHdf7RcgT2jtDKWO1Y', 'bccrems.bcc.gov.bd', 1, 1, '0000-00-00 00:00:00', '2017-10-07 09:24:13')");

        }


        if($user_role == 'super-admin')
        {
            $model = User::with('relCompany')->where('status','!=','cancel')->where('role_id','!=',4)->where('role_id','!=',5)->orderBy('id', 'DESC')->paginate(30);
        }
        elseif($user_role == 'admin')
        {
            $model = User::with('relCompany')->where('status','!=','cancel')->where('role_id','!=',3)->where('role_id','!=',4)->where('role_id','!=',5)->orderBy('id', 'DESC')->paginate(30);
        }
        else
        {
            $model = User::with('relCompany')->where('status','!=','cancel')->where('username','!=','super-admin')->where('role_id','!=',4)->where('role_id','!=',5)->where('id',$user_id)->orderBy('id', 'DESC')->paginate(30);
        }


        $company_data =  [''=>'Select Company'] + Company::Where('id',1)->orderBy('id','desc')->lists('company_name','id')->all();

        //print_r($company_data);exit("ok");
        $role =  [''=>'Select Role'] +  Role::where('role.title', '!=', 'super-admin')->where('status','=','active')->orderBy('id','desc')->lists('title','id')->all();
        /*set 30days for expire-date to user*/
        $i=90;
        $add_days = +$i.' days';
        //$days= date('Y/m/d H:i:s', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));
        $days= date('Y/m/d', strtotime($add_days, strtotime(date('Y/m/d'))));

        

        return view('user::user.index', ['model' => $model, 'pageTitle'=> $pageTitle,'branch_data'=>$company_data,'role'=>$role,'days'=>$days,'role_name'=>$user_role]);
    }

    public function search_user(){

        $pageTitle = 'User Informations';
        $model = new User();

        if($this->isGetRequest()){
            $branch_id = Input::get('company_id');
            $username = Input::get('username');
            $status = Input::get('status');

            $model = $model->select('user.*');

            if(isset($username) && !empty($username)){
                $model = $model->where('user.username', 'LIKE', '%'.$username.'%');
            }
            if(isset($branch_id) && !empty($branch_id)){
                $model = $model->where('user.company_id', '=', $branch_id);
            }
            if(isset($status) && !empty($status)){
                $model = $model->where('user.status', '=', $status);
            }

            $model = $model->paginate(30);

        }else{
            $model = $model->with('relCompany','relRoleInfo')->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(30);
        }

        $i=30;
        $add_days = +$i.' days';
        $days= date('Y/m/d H:i:s', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));

        $branch_data =  [''=>'Select Company'] + Company::lists('company_name','id')->all();
        $role =  [''=>'Select Role'] +  Role::lists('title','id')->all();


        return view('user::user.index',['pageTitle'=>$pageTitle,'branch_data'=>$branch_data,'model'=>$model,'branch_data'=>$branch_data,'role'=>$role,'days'=>$days]);
    }

    public function add_user(Requests\UserRequest $request){

        $input = $request->all();
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
                'expire_date'=> $input['expire_date'],
                'role_id'=> $input['role_id'],
                'status'=> $input['status'],
            ];

            if($user = User::create($input_data)){
                $role_user = [
                    'user_id'=>$user['id'],
                    'role_id'=>$input['role_id'],
                    'status'=>'active',
                ];
                RoleUser::create($role_user);
            }
            DB::commit();
            Session::flash('message', 'Successfully added!');
            //LogFileHelper::log_info('user-add', 'Successfully added!', ['Username: '.$input_data['username']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            //LogFileHelper::log_error('user-add', $e->getMessage(), ['Username: '.$input['username']]);
        }

        return redirect()->back();
    }

    public function show_user($id)
    {
        $pageTitle = 'User Informations';
        $data = User::with('relCompany','relRoleInfo')->where('id',$id)->first();

        return view('user::user.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    public function edit_user($id)
    {
        $pageTitle = 'Edit User Information';

        $data = User::with('relCompany')->findOrFail($id);
        $branch_data =  Company::lists('company_name','id');
        $role =  Role::lists('title','id');

        return view('user::user.update', ['pageTitle'=>$pageTitle,'data' => $data,'branch_data'=>$branch_data,'role'=>$role]);
    }

    public function update_user(Requests\UserRequest $request, $id)
    {

        $input = Input::all();
        $model1 = User::findOrFail($id);

        if($input['password2']!=Null){
            $password = Hash::make($input['password2']);
        }else{
            $password =  $input['password'];
        }

        $role_id = $model1->role_id;
        $to_email = $input['email'];
        $subject = 'Organization User Activate Notificaton';


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


        $email_data['page_title'] = 'Organization User Activate Notificaton';

        DB::beginTransaction();
        try{
            $model1->update($input_data);

            if($role_id == 5)
            {
                $mail_sent = Mail::send('user::organization_user.org_user_activate_notification', $email_data,
                    function($message) use ($to_email,$subject)
                    {
                        $message->from('rems@bcc.gov.bd', 'Organization User Activate Notificaton');
                        $message->to('shajjadhossain81@gmail.com');
                        //$message->to($to_email);
                        //$message->replyTo('devdhaka405@gmail.com','New Air Safety Data Added');
                        $message->subject($subject);

                    });
            }

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

    public function forget_password_view()
    {
        //exit('exit');
        return view('user::forget_password._form');
    }

    public function forget_password()
    {
        $email = Input::get('email');

        $user_exists = DB::table('user')->where('email', '=', $email)->exists();
        if($user_exists){

            $user = DB::table('user')->where('email', '=', $email)->first();
            #print_r($user);exit;
            $model = new UserResetPassword();
            $model->user_id = $user->id;
            $model->reset_password_token = str_random(30);
            $token = $model->reset_password_token;
            $model->reset_password_expire = date("Y-m-d h:i:s", (strtotime(date('Y-m-d h:i:s', time())) + (60 * 30)));
            $model->reset_password_time = date('Y-m-d h:i:s', time());
            $model->status = 2;
            if($model->save()) {

                try{
                    Mail::send('user::forget_password.email_notification', array('link'=>$token,'user'=>$user),
                        function($message) use ($user)
                        {
                            $message->from('devdhaka405@gmail.com', 'User Password Set Notification');
                            $message->to('shajjadhossain81@gmail.com');
                            //$message->to($user->email);
                            $message->replyTo('shajjadhossain81@gmail.com','forgot password Request');
                            $message->subject('Forgot Password Reset Mail');
                        });

                    #print_r($user);exit;
                    Session::flash('message', 'Successfully sent email to reset password. Please check your email!');
                }catch (\Exception $e){

                    Session::flash('error', $e->getMessage());
                }
            }else{
                Session::flash('error', 'Does not Save!');
            }
        }else{
            Session::flash('error', 'The Specified Email address Is not Listed On Your Account. Please Try Again.');
        }
        return redirect()->back();
    }


    public function password_reset_confirm($reset_password_token){

        $user = UserResetPassword::where('reset_password_token','=',$reset_password_token)->first();
        $current_time = date('Y-m-d h:i:s', time());
        if(isset($user)) {
            $data = [
                isset($user->id) ? 'user_id': '' => isset($user->id) ? $user->id : '',
                'reset_password_expire' => isset($user) ? $user->reset_password_expire : '',
                'reset_password_time'=> isset($user) ? $user->reset_password_time : '',
                'status'=> isset($user) ? $user->status : '',
            ];
            if ($data['reset_password_expire'] > $current_time && $data['status'] == 2) {
                $id =  isset($user->id) ?$data['user_id']:'';
                return view('user::forget_password.reset_password_form',['id'=>$id]);
            }
            if($data['reset_password_expire'] < $current_time){
                Session::flash('error', 'Time Expired.Please Try Again.');
                return redirect()->back();
            }
            if($data['status'] == 0) {
                Session::flash('error', 'You can Not Access To This link.Please Try Again.');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Invalid Password Reset Link.Please Try Again.');
            return redirect()->route('admin');
        }
        return redirect()->route('admin');
    }

    public function save_new_password(Request $request)
    {

        $data = $request->all();
        $user_id = DB::table('user_reset_password')->where('id', '=', $data['id'])->first();

        $model = User::findOrFail($user_id->user_id);

        if($data['confirm_password']==$data['password']) {
            //update status and password
            #date_default_timezone_set("Asia/Dacca");
            $user_update_data =[
                'password'=>Hash::make($data['password']),
                'last_visit'=>date('Y-m-d h:i:s', time()),
            ];
            DB::beginTransaction();
            try {
                if ($model->update($user_update_data)) {
                    DB::table('user_reset_password')->where('user_id', '=', $user_id->user_id)->update(array('status' => 0));
                }
                DB::commit();
                Session::flash('message', 'You have reset your password successfully. You may signin now.');
                //LogFileHelper::log_info('save_new_password', 'successfully reset password',["New password for user_id".$user_id->user_id]);
                return redirect()->route('admin');
            }catch(Exception $e){
                Session::flash('message', $e->getMessage());
                //LogFileHelper::log_error('save_new_password', $e->getMessage(), ["New password for user_id".$user_id->user_id]);
            }
        }else{
            Session::flash('error', "Password and Confirm Password Does not match !");
        }
        return redirect()->back();
    }

    public function logout() {

        $user_model = new UserLoginHistory();

        $user_role = Session::get('role_title');

        /* Transaction Start Here */
        DB::beginTransaction();
        try{
            $user_history = [
                'user_id' => Auth::user()->id,
                'logout_time' => date('Y-m-d h:i:s', time()),
                'ip_address' => getHostByName(getHostName()),
                'date' => date('Y-m-d h:i:s', time()),
            ];
            $user_model->create($user_history);

            Auth::logout();
            Session::flush(); //delete the session
            DB::commit();
            Session::flash('message', 'You Are Now Logged Out.');
        }catch(\Exception $e){
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('error', $e->getMessage());
        }

        if($user_role == 'organization')
        {
            return redirect()->route('login');
        }
        elseif($user_role == 'candidate')
        {
            return redirect()->route('candidate');
        }
        else{
            return redirect()->route('admin');
        }


    }

    public function create_user_info()
    {
        if(Auth::check())
        {
            $pageTitle = 'User Profile';
            $user_id = Auth::user()->id;
            $profile_data = UserProfile::where('user_id',$user_id)->first();
            $user_image = UserImage::where('user_id',$user_id)->first();
            $user = User::where('id',$user_id)->first();
            $department_data =  [''=>'Select Department'] + Department::lists('title','id')->all();

            return view('user::user_info.index',['user_id'=>$user_id,'profile_data'=>$profile_data,'user_image'=>$user_image,'user'=>$user,'department_data'=>$department_data,'pageTitle'=>$pageTitle]);
        }
    }

    public function user_info($value){

        $user_id = Auth::user()->id;

        /*if($this->isPostRequest()){*/
        try{
            if($value == 'profile'){

                $data = UserProfile::with('relUser')->where('user_id',$user_id)->first();

                return Response::json(view('user::user_info.profile.ajax_profile_data', ['data' => $data])->render());
            }
            if($value == 'meta'){
                $data = UserMeta::with('relUser')->where('user_id',$user_id)->first();
                return Response::json(view('user::user_info.meta_data.ajax_meta_data', ['data' => $data])->render());
            }
            if($value == 'acc-settings'){
                $profile_data = UserProfile::with('relUser')->where('user_id',$user_id)->first();
                $user_data = User::with('relRoleInfo')->where('id',$user_id)->first();
                return Response::json(view('user::user_info.account_settings._ajax_data', ['user_data' => $user_data,'profile_data'=>$profile_data])->render());
            }

        }catch(\Exception $e){
            return Response::json($e);
        }

        /*}else{
              return Response::json('only for ajax request!');
          }*/

    }

    public function store_user_profile(Requests\UserProfileRequest $request){

        $input = $request->all();

        $image_model = new UserImage();
        $profile_model = new UserProfile();

#print_r($image);exit;

        DB::beginTransaction();
        try {
            $profile_model->create($input);
            DB::commit();
            Session::flash('message', "Successfully Added");
            #LogFileHelper::log_info('store_user_profile', 'Successfully added', ['User profile firstname:'.$input['first_name']]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', 'Profile Information Do not Added');
            #LogFileHelper::log_error('store-user-profile', $e->getMessage(),  ['User profile firstname:'.$input['first_name']]);
        }

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            //print_r(base_path('public').'/'.$uploadfolder);exit;//public_html

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }/*else{
                chmod(base_path('public').'/'.$uploadfolder, 0777);
            }*/

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }/*else{
                chmod(base_path('public').'/'.$uploadfolder, 0777);
            }*/

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);

            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->create($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('store-user-profile', 'Successfully added', ['User profile image:'.$input['image']] );
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('store-user-profile', $e->getMessage(), ['User profile image:'.$input['image']] );
            }
        }
        return redirect()->back();
    }

    public function edit_user_profile($id){

        $pageTitle = 'Edit User Profile Information';

        $data = UserProfile::findOrFail($id);
        $user_id = Auth::user()->id;

        $user_image = UserImage::where('user_id',$user_id)->first();
        #$user_image_id = ($user_image->id)?$user_image->id:'';

        return view('user::user_info.profile.update', ['pageTitle'=>$pageTitle,'data' => $data,'user_id'=>$user_id,'user_image'=>$user_image]);
    }

    public function update_user_profile(Requests\UserProfileRequest $request,$id){

        $input = $request->all();
        $user_id = Auth::user()->id;

        $profile_model = UserProfile::findOrFail($id);

        DB::beginTransaction();
        try {
            $profile_model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Added");
            #LogFileHelper::log_info('update-user-profile', 'successfully updated', ['User profile firstname:'.$input['first_name']]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', 'Profile Information Do not Added');
            #LogFileHelper::log_error('update-user-profile', $e->getMessage(), ['User profile firstname:'.$input['first_name']]);
        }

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);
            #print_r($file_name);exit;
            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
//                $image_model = $user_image_id ? UserImage::findOrFail($user_image_id):new UserImage();
                $user_image_exists = UserImage::where('user_id',$user_id)->exists();
                if($user_image_exists){
                    $user_image = UserImage::where('user_id',$user_id)->first();
                    $image_model = UserImage::findOrFail($user_image['id']);
                }else{
                    $image_model = new UserImage();
                }

                $image_model->fill($input)->save();
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('update-user-profile', 'Successfully added',  ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('update-user-profile', $e->getMessage(),  ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->route('user-profile');
    }

    public function store_profile_image(Request $request){

        $input = $request->all();



        $image_model = new UserImage();
        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';


            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }



            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);

            //print_r($file_name);exit;

            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->create($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('store-profile-image', 'successfully added', ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', "Profile Image Do Not added");
                #LogFileHelper::log_error('store-profile-image', $e->getMessage(),  ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->back();
    }

    public function edit_profile_image($user_image_id){

        $pageTitle = 'Edit User Profile Picture';
        $model = UserImage::findOrFail($user_image_id);
        return view('user::user_info.profile_image.update_image', ['pageTitle'=>$pageTitle,'model'=>$model,'user_image_id'=>$user_image_id]);
    }

    public function update_profile_image(Request $request,$user_image_id){

        $input = $request->all();

        $image_model = UserImage::findOrFail($user_image_id);

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,gif,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);
            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->update($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('update-profile-image', 'successfully update',  ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('update-profile-image', $e->getMessage(), ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->route('user-profile');
    }

    public function store_meta_data(Request $request){

        $input = $request->all();


        $image = Input::file('signature');

        if(count($image)>0) {

            $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');
            $validator = Validator::make(array('file' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                $destinationPath = 'uploads/user_image/';

                // Create folders if they don't exist
                if ( !file_exists($destinationPath) ) {
                    $oldmask = umask(0);  // helpful when used in linux server
                    mkdir ($destinationPath, 0777);
                }

                $file_original_name = $image->getClientOriginalName();
                $file_name = rand(11111, 99999) . $file_original_name;
                $upload_success = $image->move($destinationPath, $file_name);
                $input['signature'] = 'uploads/user_image/' . $file_name;
            }
        }
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            UserMeta::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
            #LogFileHelper::log_info('store-meta-data', 'Successfully added', ['User metadata signature:'.$input['signature']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            #LogFileHelper::log_error('store-meta-data', $e->getMessage(),['User metadata signature:'.$input['signature']]);
        }
        return redirect()->route('user-profile');
    }

    public function edit_meta_data($id){

        $pageTitle = 'Edit Biographical Information';

        $data = UserMeta::findOrFail($id);
        $user_id = Auth::user()->id;

        return view('user::user_info.meta_data.update', ['pageTitle'=>$pageTitle,'data' => $data,'user_id'=>$user_id]);
    }

    public function update_meta_data(Request $request,$id){

        $input = $request->all();

        $model= UserMeta::findOrFail($id);

        $image = Input::file('signature');

        if(count($image)>0) {

            $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');
            $validator = Validator::make(array('file' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                $destinationPath = 'uploads/user_image/';

                // Create folders if they don't exist
                if ( !file_exists($destinationPath) ) {
                    $oldmask = umask(0);  // helpful when used in linux server
                    mkdir ($destinationPath, 0777);
                }

                $file_original_name = $image->getClientOriginalName();
                $file_name = rand(11111, 99999) . $file_original_name;
                $upload_success = $image->move($destinationPath, $file_name);
                $input['signature'] = 'uploads/user_image/' . $file_name;
            }
        }
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', 'Successfully Updated!');
            #LogFileHelper::log_info('update-meat-data', 'Successfully updated',['User metadata signature:'.$input['signature']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            #LogFileHelper::log_error('update-meta-data', $e->getMessage(), ['User metadata signature:'.$input['signature']]);
        }
        return redirect()->back();
    }

    public function change_user_password_view()
    {
        return view('admin.change_password._form');
    }

    public function update_password()
    {
        if(Auth::check())
        {

            $input = Input::all();

            if($input['confirm_password']==$input['password']) {
                $hash_check = Hash::check($input['pass'], User::findOrNew(Auth::user()->id)->password);

                if ($hash_check > 0) {

                    $model = User::findOrNew(Auth::user()->id);
                    $model->password = Hash::make($input['password']);

                    /* Transaction Start Here */

                    DB::beginTransaction();

                    try {
                        $model->save();

                        DB::commit();
                        Session::flash('message', "Successfully Updated Your Password");
                        #LogFileHelper::log_info('update-user-password', 'Successfully update password', ['User id: '.$model->id]);

                    } catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction
                        DB::rollback();
                        Session::flash('error',$e->getMessage());
                        #LogFileHelper::log_error('update-user-password', $e->getMessage(), ['User id: '.$model->id]);
                    }
                } else {
                    Session::flash('error', "Your old password is not correct !");
                }
            }
            else{
                Session::flash('error', "Password and Confirm Password Does not match !");
            }
        }
        else
        {
            Session::flash('error', "Please Login !" );
        }
        return redirect()->back();
    }

    public function image_upload($image,$file_type_required,$destinationPath){

        if ($image != '') {
            $img_name = ($_FILES['image']['name']);
            $random_number = rand(111, 999);

            $thumb_name = 'thumb_50x50_'.$random_number.'_'.$img_name;

            $newWidth=200;
            $targetFile=$destinationPath.$thumb_name;
            $originalFile=$image;

            $resizedImages 	= ImageResize::resize($newWidth, $targetFile,$originalFile);
            //print_r($resizedImages);exit;
            $thumb_image_destination=$destinationPath;
            $thumb_image_name=$thumb_name;

            //$rules = array('image' => 'required|mimes:png,jpeg,jpg');
            $rules = array('image' => 'required|mimes:'.$file_type_required);
            $validator = Validator::make(array('image' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                //$destinationPath = 'uploads/slider_image/';
                // Create folders if they don't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $image_original_name = $image->getClientOriginalName();
                $image_name = rand(11111, 99999) . $image_original_name;




                $upload_success = $image->move($destinationPath, $image_name);

                $file=array($destinationPath . $image_name, $thumb_image_destination.$thumb_image_name);

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

    public function destroy_user($id)
    {
        $model = User::where('id',$id)->first();
        DB::beginTransaction();
        try {
            
            $model->status = 'cancel';
            $model->last_visit = Null;
            
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            //LogFileHelper::log_info('destroy-user', 'Successfully Deleted!change status to cancel',['User id:'.$model->id]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            //LogFileHelper::log_error('user-destroy', $e->getMessage(), ['User id:'.$model->id]);
        }
        return redirect()->back();
    }



}
