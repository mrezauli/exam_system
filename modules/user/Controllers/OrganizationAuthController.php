<?php

namespace Modules\User\Controllers;
use App\Role;
use App\User;
use App\UserActivity;
use App\UserImage;
use App\UserLoginHistory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use URL;
use HTML;
use Mockery\CountValidator\Exception;
use Validator;
use Input;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Session\TokenMismatchException;

//use App\Helpers\MenuItems;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Company;
use App\RoleUser;
use App\Permission;
use App\PermissionRole;
use App\MenuPanel;

class OrganizationAuthController extends Controller
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

        if(Session::has('username')) {

            return redirect()->to('dashboard');

        }else{

            $company_list =  [''=>'Select organization'] + Company::where('status','active')->where('id','!=',1)->orderBy('id','desc')->lists('company_name','id')->all();

            return view('user::organization_user.login',compact('company_list'));

        }
    }

    public function postLogin(Request $request)
    {

        $data = Input::all();

        $secret = '6LeOZxcUAAAAAPpGnX_6Ik9LMGHkszc2A4WQnFC-';

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$data['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        

        if(empty($data['g-recaptcha-response'])){
            Session::flash('danger', "Google varification is required.");
            return redirect()->back();

        }elseif(! $responseData->success){

            Session::flash('danger', "Please fill out the google captcha correctly.");
            return redirect()->back();
        }

        if(Auth::check()){
            Session::put('username', isset(Auth::user()->get()->id));
            Session::flash('message', "You Are Already Logged In.");
            return redirect()->route('dashboard');
        }else{



            $username_exists = User::where('company_id', $data['company_id'])->exists();
            $email_exists = User::where('email', $data['email'])->exists();
      
            if($email_exists){

                $user = User::where('email', $data['email'])->first();

                if($user->company_id == $data['company_id']){


                $user_data = User::where('email', $data['email'])->first();
                $check_password = Hash::check($data['password'], $user_data->password);
                if($check_password){
                    #exit('ok');
                    // $user_data->last_visit!=NULL
                    
                        if($user_data->status=='inactive'){

                            Session::flash('danger', "Sorry!! Your Account Is Inactive. You Can Contact With BCC Admin To Activate Your Account.");
                        }else{
                            $attempt = Auth::attempt([
                                'email' => $request->get('email'),
                                'password' => $request->get('password'),
                            ]);
                            if($attempt){
                                DB::table('user')->where('id', '=', $user_data->id)->update(array('last_visit' =>date('Y-m-d h:i:s', time())));
                                $user_model = new UserLoginHistory();

                                $user_history = [
                                    /*'action_name' => 'user-login',
                                    'action_url' => 'get-user-login',
                                    'action_details' => Auth::user()->email.' '. 'logged in',
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
                    #exit('no');
                    Session::flash('danger', "Password Incorrect.Please Try Again!!!");
                }
            }else{
                    Session::flash('danger', "email and company does not match.");


            }
            }else{
                Session::flash('danger', "email does not exists.Please Try Again");
            }
            return redirect()->back();
        }
    }
}
