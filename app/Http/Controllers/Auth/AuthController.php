<?php

namespace App\Http\Controllers\Auth;
use App\Role;
use App\User;
use App\UserActivity;
use App\UserImage;
use App\UserLoginHistory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\ExamCode;
use URL;
use HTML;
use Mockery\CountValidator\Exception;
use Validator;
use Input;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Modules\Question\QSelectionTypingTest;
use Modules\Exam\ExamProcess;


use Illuminate\Session\TokenMismatchException;

//use App\Helpers\MenuItems;
use Illuminate\Support\Facades\Schema;
use App\RoleUser;
use App\Permission;
use App\PermissionRole;
use App\MenuPanel;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }*/

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            #'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        return User::create([
            #'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function reset_password($user_id){

        return view('user::reset_password._form',['user_id'=>$user_id]);
    }

    public function update_new_password(Request $request){

        $input = $request->all();

        date_default_timezone_set("Asia/Dacca");

        if($input['confirm_password']==$input['password']) {

            $model = User::findOrFail($request['user_id']);
            $model->password = Hash::make($input['password']);
            $model->last_visit = date('Y-m-d h:i:s', time());
            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                $model->save();
                DB::commit();

                Auth::logout();
                Session::flush(); //delete the session

                Session::flash('message','Successfully Reset Your Password.You May Login Now.');
                //return redirect()->route('get-user-login');
                return redirect()->route('admin');
            } catch (Exception $e) {
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error',$e->getMessage());
            }
        }
        else{
            Session::flash('error', "Password and Confirm Password Does not match !");
        }
        return redirect()->back();
    }

    public function getLogin()
    {

        if(Session::has('email')) {
            return redirect()->to('dashboard');
        }
        else{
            return view('user::signin._form');
        }
    }

    public function postLogin(Request $request)
    {

        $data = Input::all();




        /*$secret = '6LeOZxcUAAAAAPpGnX_6Ik9LMGHkszc2A4WQnFC-';

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$data['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        

        if(empty($data['g-recaptcha-response'])){
            Session::flash('danger', "google captcha is a required field");
            return redirect()->back();

        }elseif(! $responseData->success){

            Session::flash('danger', "Please fill out the google captcha correctly.");
            return redirect()->back();
        }*/



        if(Auth::check()){
            Session::put('email', isset(Auth::user()->get()->id));
            Session::flash('message', "You Are Already Logged In.");
            return redirect()->route('dashboard');
        }else{

            $field = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $user_data_exists = User::where($field, $data['email'])->where('role_id','!=', 5)->exists();
            if($user_data_exists){

                $user_data = User::where($field, $data['email'])->first();
                $check_password = Hash::check($data['password'], $user_data->password);
                if($check_password){
                    #exit('ok');
                    // if($user_data->last_visit!=NULL)

                    if(1){
                        if($user_data->expire_date < date('Y-m-d h:i:s', time())){
                            DB::table('user')->where('id', '=', $user_data->id)->update(array('status' =>'inactive'));
                            Session::flash('message', "Login Activation Time Is Expired.You Can Contact With System-Admin To Reactivate Account.");
                        }elseif($user_data->status=='inactive'){
                            Session::flash('error', "Sorry!! Your Account Is Inactive. You Can Contact With BCC Admin To Reactivate Your Account.");
                        }
                        else{
                            $attempt = Auth::attempt([
                                $field => $request->get('email'),
                                'password' => $request->get('password'),
                            ]);




                            if($attempt){
                                DB::table('user')->where('id', '=', $user_data->id)->update(array('last_visit' =>date('Y-m-d h:i:s', time())));
                                $user_model = new UserLoginHistory();

                                $user_history = [
                                    /*'action_name' => 'user-login',
                                    'action_url' => 'get-user-login',
                                    'action_details' => Auth::user()->username.' '. 'logged in',
                                    'action_table' => 'user',
                                    'date' => date('Y-m-d h:i:s', time()),
                                    'user_id' => Auth::user()->id,*/
                                    'user_id' => Auth::user()->id,
                                    'login_time' => date('Y-m-d h:i:s', time()),
                                    'ip_address' => getHostByName(getHostName()),
                                    'date' => date('Y-m-d h:i:s', time()),
                                ];
                                $user_model->create($user_history);
                                /*user-image in session........*/
                                if(!Session::has('user_image')){
                                    $image_exists = UserImage::where('user_id',Auth::user()->id)->exists();
                                    if($image_exists){
                                        $user_image = UserImage::where('user_id',Auth::user()->id)->first()->thumbnail;
                                        Session::put('user_image',$user_image);
                                    }
                                }

                                $role_name = Role::where('id', $user_data->role_id)->first();

                                #print_r($role_name->slug);exit;

                                Session::put('email', $user_data->email);
                                Session::put('user_id', $user_data->id);
                                Session::put('role_title', $role_name->slug);
                                Session::put('company_id', $user_data->company_id);

                                Session::flash('message', "Successfully  Logged In.");
                                return redirect()->intended('dashboard');

                            }else{
                                Session::flash('danger', "Password Incorrect.Please Try Again");
                            }
                        }
                    }else{
                        // Session::flash('info', "Your account is inactive.To activate your account you should reset your password.");
                        // #return redirect()->to('welcome');
                        // return redirect()->route('reset-password',['user_id'=>$user_data['id']]);
                    }
                }else{
                    #exit('no');
                    Session::flash('danger', "Password Incorrect.Please Try Again!!!");
                }
            }else{
                Session::flash('danger', "UserName/Email does not exists.Please Try Again");
            }
            return redirect()->back();
        }
    }


    /************** - Candidate Login - **************************/


    public function candidate_login_page()
    {

        if(Session::has('email')) {
            return redirect()->to('dashboard');
        }
        else{
            return view('user::candidate_signin._form');
        }
    }


    public function post_candidate_login(Request $request)
    {


        $data = Input::all();

        if(Auth::check())Auth::logout();


        $exam_code = ExamCode::where('exam_code_name',$request->get('exam_code'))->select('exam_type','id')->first();


        if(isset($exam_code->exam_type))
        {
            if($exam_code->exam_type == 'typing_test')
            {
                $attempt = Auth::attempt([
                    'roll_no' => $request->get('roll_no'),
                    'password' => $request->get('roll_no'),
                    'typing_exam_code_id' => $exam_code->id,
                ]);
            }
            elseif($exam_code->exam_type == 'aptitude_test')
            {
                $attempt = Auth::attempt([
                    'roll_no' => $request->get('roll_no'),
                    'password' => $request->get('roll_no'),
                    'aptitude_exam_code_id' => $exam_code->id,
                ]);
            }
        }
        else{
            Session::flash('danger', "Exam Code does not match. Please try again.");
            return redirect()->route('candidate');
        }



        if($attempt){

            $user = Auth::user();

            $typing_exam_code = isset($user->typing_exam_code->exam_code_name)?$user->typing_exam_code->exam_code_name:'';
            $aptitude_exam_code = isset($user->aptitude_exam_code->exam_code_name)?$user->aptitude_exam_code->exam_code_name:'';

            if ($request->get('exam_code') != $typing_exam_code  && $request->get('exam_code') != $aptitude_exam_code) {

                Session::flash('danger', "Exam Code does not match. Please try again.");
                return redirect()->route('candidate');
            }



            $typing_exam_type = isset($user->typing_exam_code->exam_type)?$user->typing_exam_code->exam_type:'';
            $aptitude_exam_type = isset($user->aptitude_exam_code->exam_type)?$user->aptitude_exam_code->exam_type:'';



            if($exam_code->exam_type == 'typing_test') {
                if ($user->typing_status == 'inactive') {
                    Session::flash('danger', "You don't have permission to seat in the examination, please contact with BCC admin.");
                    Auth::logout();
                    return redirect()->route('candidate');
                }
            }elseif($exam_code->exam_type == 'aptitude_test'){
                if ($user->aptitude_status == 'inactive') {
                    Session::flash('danger', "You don't have permission to seat in the examination, please contact with BCC admin.");
                    Auth::logout();
                    return redirect()->route('candidate');
                }
            }

            if ($exam_code->exam_type == 'typing_test' ) {

                DB::table('user')->where('id', '=', $user->id)->update(array('last_visit' =>date('Y-m-d h:i:s', time()),'typing_status'=>'inactive','attended_typing_test'=>'true'));

            }elseif( $exam_code->exam_type == 'aptitude_test' ) {

                DB::table('user')->where('id', '=', $user->id)->update(array('last_visit' =>date('Y-m-d h:i:s', time()),'aptitude_status'=>'inactive','attended_aptitude_test'=>'true'));

            }else{

                Session::flash('danger', "An error occured. Please try again.");
                Auth::logout();
                return redirect()->route('candidate');

            }


            //DB::table('user')->where('id', '=', $user->id)->update(array('last_visit' =>date('Y-m-d h:i:s', time()),'status'=>'inactive'));
            $user_model = new UserLoginHistory();

            $user_history = [
                                /*'action_name' => 'user-login',
                                'action_url' => 'get-user-login',
                                'action_details' => Auth::user()->username.' '. 'logged in',
                                'action_table' => 'user',
                                'date' => date('Y-m-d h:i:s', time()),
                                'user_id' => Auth::user()->id,*/
                                'user_id' => $user->id,
                                'login_time' => date('Y-m-d h:i:s', time()),
                                'ip_address' => getHostByName(getHostName()),
                                'date' => date('Y-m-d h:i:s', time()),
                            ];
                                    $user_model->create($user_history);


                                    $role_name = Role::where('id', $user->role_id)->first();

                                #print_r($role_name->slug);exit;

                                    Session::put('roll_no', $user->roll_no);
                                    Session::put('user_id', $user->id);
                                    Session::put('role_title', $role_name->slug);

                                    Session::flash('message', "Successfully  Logged In.");


                                    if ($exam_code->exam_type == 'typing_test') {

                                        return redirect()->route('typing-exams');

                                    }elseif($exam_code->exam_type == 'aptitude_test'){

                                        return redirect()->route('aptitude-exams');

                                    }else{

                                        Session::flash('message', "You are not selected for any exam. Please contact with BCC admin.");

                                        return redirect()->back();

                                    }


                                }else{
                                    Session::flash('danger', "Roll no. does not match. Please try again.");
                                }



                                return redirect()->route('candidate');
        
    }


    public function candidate_logout() {

        $user_model = new UserLoginHistory();
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


        return redirect()->route('candidate');
    }


    /************** - Candidate Login - **************************/
}
