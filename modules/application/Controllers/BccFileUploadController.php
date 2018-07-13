<?php

/**
 * Created by PhpStorm.
 * User: UITS-Shajjad
 * Date: 2/28/2017
 * Time: 11:43 AM
 */

namespace Modules\Application\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Modules\Admin\BccEmail;
use Modules\Admin\Company;
use Modules\Application\OrganizationDetails;
use Modules\Application\OrganizationMaster;
use Modules\Application\ApplicationAttachment;
use Validator;
use Storage;
use File;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;


class BccFileUploadController extends Controller
{

    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    private $from_email;

    public function __construct()
    {

     $this->from_email = Auth::user()->email;

    }


    public function index()
    {
        
        $pageTitle = "Letter's Sent to Organization";

        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','bcc')->orderBy('id', 'desc')->get();
        //print_r($data);exit;

        return view('application::bcc_file_upload.index', ['pageTitle'=> $pageTitle,'data'=> $data]);
    }

    public function received_email_index()
    {
        
        $pageTitle = "Letter's Received from Organization";

        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','organization')->orderBy('created_at','DESC')->get();
        //print_r($data);exit;

        return view('application::bcc_file_upload.received_email_index', ['pageTitle'=> $pageTitle,'data'=> $data]);
    }

    public function create()
    {

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->where('id','!=',1)->orderBy('id','desc')->lists('company_name','id')->all();

        $company_details_list =  Company::where('status','active')->get();

        $page_title = "Application To Organization";
        return view('application::bcc_file_upload.create',compact('page_title','company_list','company_details_list'));
    }

    public function store(Requests\OrganizationMasterRequest $request)
    {

        $company_id= $request->only('company_id')['company_id'];

        $user = User::where('company_id',$company_id)->where('role_id',5)->first();

        if (empty($user)) {
            Session::flash('danger', "This organization has not been registered yet.");
            return redirect()->route('create-bcc-file-upload');
        }


        $from_email = $this->from_email;
        $to_email = $user->email;

        if (empty($to_email)) {
            Session::flash('danger', "No Organization user email has been set.");
            return redirect()->route('create-bcc-file-upload');
        }

        $input['user_id'] = $user->id;
        $input['company_id'] = $company_id;
        $input['application_format'] = 'file_upload';
        $input['bcc_or_organization'] = 'bcc';
        $input['status'] = 'active';

    
        DB::beginTransaction();
        try {
            $model = new OrganizationMaster();
            $org_app_mst = $model->create($input);
            DB::commit();            
        }

        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "An error occured. Please Try Again.");
            return redirect()->route('bcc-file-upload');
        }



        $org_app_dtls = $request->only('subject','letter_no');
        $org_app_dtls['org_app_mst_id'] = $org_app_mst->id;
        $org_app_dtls['to_email'] = $to_email;
        $org_app_dtls['from_email'] = $from_email;


        DB::beginTransaction();

        try {
            $model = new OrganizationDetails();
            $model->create($org_app_dtls);
            DB::commit();
        }

        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "An error occured. Please Try Again.");
            return redirect()->route('bcc-file-upload');
        }



        //----------------- For Attachment file-------------------//
        $attachments=Input::file('file_upload_attachment');
        //print_r($attachments); exit("ok");
        if(isset($attachments)){
            //$rules = array('file' => 'mimes:pdf,doc');
            //$rules = array('file' => 'max:300');


            foreach($attachments as $attachment) {

                $rules = array();
                $validator = Validator::make(array('file' => $attachment), $rules);
                //print_r($validator->passes());exit;

                if ($validator->passes()) {
                    //exit('Exit');
                    $upload_folder = 'bcc_application/';
                    if (!file_exists($upload_folder)) {
                        $oldmask = umask(0);  // helpful when used in linux server
                        mkdir($upload_folder, 0777);
                    }
                    if(isset($attachment)) {
                        $file_original_name = $attachment->getClientOriginalName();
                        //print_r($file_original_name);exit;
                        $file_name = rand(11111, 99999) . '-' . $file_original_name;
                        $attachment->move($upload_folder, $file_name);
                        $attachment = $upload_folder . $file_name;
                        //$model->attachment = $attachment;

                        $file_paths[] = $attachment;
                    }

                    #print_r($file_path); exit();

                } else {
                    // Redirect or return json to frontend with a helpful message to inform the user
                    // that the provided file was not an adequate type
                    return redirect('create-bcc-file-upload')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }//---------End Attachment

      
        if($org_app_mst) {

            if(isset($file_paths)){
                foreach($file_paths as $file_path){
                    $data = [
                        'org_app_mst_id' => $org_app_mst->id,
                        'application_attachment_path'=>$file_path,
                        'attachment_type'=>'file_upload',
                        'status' => 'active'
                    ];

                    ApplicationAttachment::create($data);
                }
            }



                $input = $request->all();

                $subject = $input['subject'];

                $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->with('relAttachment')->where('id',$org_app_mst->id)->first();
    

                $email_data['page_title'] = 'View Application for examination Arrangement';
                $email_data['user_name'] = $data->user->username;
                $email_data['company_name'] = $data->company->company_name;
                $email_data['subject'] = $data->relAppOrgDtls->subject;
                $email_data['from_email'] = $from_email;
                $email_data['letter_no'] = $data->relAppOrgDtls->letter_no;

                try{
                    $mail_sent = Mail::send('application::bcc_file_upload.org_mail_notification', $email_data,
                        function($message) use ($to_email,$subject,$from_email,$file_paths)
                        {
                            $message->from($from_email, 'Application for examination arrangement');
                            $message->to($to_email);
                            //$message->to('dctrino@gmail.com');
                            //$message->replyTo('devdhaka405@gmail.com','New Air Safety Data Added');
                            $message->subject($subject);

                            foreach ($file_paths as $file_path) {
                                $message->attach($file_path);
                            }
                            
                        });

                    if($mail_sent){
                        Session::flash('message', 'Application has been successfully sent.');
                    }else{
                        Session::flash('error', 'Your mail was not sent Successfully. Please try again.');
                        return redirect()->route('bcc-file-upload');
                    }

                }catch (\Exception $e){

                    Session::flash('danger', $e->getMessage());
                    //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');

                    return redirect()->route('bcc-file-upload');
                }

        }else{
            Session::flash('error', 'Does not Save!');
            return redirect()->route('bcc-file-upload');
        }

        return redirect()->route('bcc-file-upload');

    }

    public function show($received = null, $id)
    {

        if ($received == 'received') {

            $page_title = 'Received Letter from BCC';

            DB::beginTransaction();

            try {
                $model = OrganizationDetails::where('org_app_mst_id',$id)->first();

                $org_app_dtls = $model->update(['read_email' => 'true']);

                DB::commit();
                
            }
            
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "An error occured. Please Try Again.");
                return redirect()->back();
            }

        } else {

            $page_title = 'Sent Letter to Organization';

        }


        $page_title = 'Received Letter';

        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->with('relAttachment')->where('id',$id)->first();

        $has_file = $data->relAttachment()->count();

        $file_data = $data->relAttachment;

        return view('application::bcc_file_upload.view', compact('data','page_title','has_file','file_data'));

    }

    public function edit($id)
    {

        $user = Auth::user();
        $company_id = $user->company_id;
        $company = Company::find($company_id);

        $app_org_mst = OrganizationMaster::with('relAppOrgDtls')->with('relAttachment')->where('id',$id)->first();
        $has_file = $app_org_mst->relAttachment()->count();

        $data = $app_org_mst->relAppOrgDtls;

        $data->id = $app_org_mst->id;
        $file_data = $app_org_mst->relAttachment;

        $page_title = "Application To Organization";
        return view('application::bcc_file_upload.edit',compact('page_title','data','file_data','company','has_file'));
    }


    public function update(Requests\OrganizationMasterRequest $request, $id)
    {

        $company_id= $request->only('company_id')['company_id'];

        $user = User::where('company_id',$company_id)->where('role_id',5)->first();

        if (empty($user)) {
            Session::flash('danger', "This organization has not been registered yet.");
            return redirect()->route('edit-bcc-file-upload',$id);
        }

        $from_email = $this->from_email;
        $to_email = $user->email;

        if (empty($to_email)) {
            Session::flash('danger', "No organization user email has been set.");
            return redirect()->route('edit-bcc-file-upload',$id);
        }

        $org_app_dtls = $request->only('subject','letter_no');
        $org_app_dtls['to_email'] = $to_email;
        $org_app_dtls['from_email'] = $from_email;


        DB::beginTransaction();
        try {
            $model = OrganizationDetails::where('org_app_mst_id',$id)->first();
            $model->update($org_app_dtls);
            DB::commit();
            
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "An error occured. Please Try Again.");
            return redirect()->route('edit-bcc-file-upload',$id);
        }


        //----------------- For Attachment file-------------------//
        $attachments=Input::file('file_upload_attachment');
        //print_r($attachments); exit("ok");
        if(isset($attachments)){
            //$rules = array('file' => 'mimes:pdf,doc');
            //$rules = array('file' => 'max:300');


            foreach($attachments as $attachment) {

                $rules = array();
                $validator = Validator::make(array('file' => $attachment), $rules);
                //print_r($validator->passes());exit;

                if ($validator->passes()) {
                    //exit('Exit');
                    $upload_folder = 'bcc_application/';
                    if (!file_exists($upload_folder)) {
                        $oldmask = umask(0);  // helpful when used in linux server
                        mkdir($upload_folder, 0777);
                    }
                    if(isset($attachment)) {
                        $file_original_name = $attachment->getClientOriginalName();
                        //print_r($file_original_name);exit;
                        $file_name = rand(11111, 99999) . '-' . $file_original_name;
                        $attachment->move($upload_folder, $file_name);
                        $attachment = $upload_folder . $file_name;
                        //$model->attachment = $attachment;

                        $file_paths[] = $attachment;
                    }

                    #print_r($file_path); exit();

                } else {
                    // Redirect or return json to frontend with a helpful message to inform the user
                    // that the provided file was not an adequate type
                    return redirect('edit-bcc-file-upload',$id)
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }//---------End Attachment

      


            if(isset($file_paths)){
                foreach($file_paths as $file_path){
                    $data = [
                        'org_app_mst_id' => $id,
                        'application_attachment_path'=>$file_path,
                        'attachment_type'=>'file_upload',
                    ];

                    ApplicationAttachment::create($data);
                }
            }


        
                $input = $request->all();

                $subject = $input['subject'];

                $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->with('relAttachment')->where('id',$id)->first();


                $email_data['page_title'] = 'View Application for examination Arrangement';
                $email_data['user_name'] = $data->user->username;
                $email_data['company_name'] = $data->company->company_name;
                $email_data['subject'] = $data->relAppOrgDtls->subject;
                $email_data['from_email'] = $from_email;
                $email_data['letter_no'] = $data->relAppOrgDtls->letter_no;


                try{
                    $mail_sent = Mail::send('application::bcc_file_upload.org_mail_notification', $email_data,
                        function($message) use ($to_email,$subject,$from_email)
                        {
                            $message->from($from_email, 'Application for examination arrangement');
                            $message->to($to_email);
                            //$message->to('dctrino@gmail.com');
                            //$message->replyTo('devdhaka405@gmail.com','New Air Safety Data Added');
                            $message->subject($subject);
                        });

                    if($mail_sent){
                        Session::flash('message', 'Application has been successfully sent.');
                    }else{
                        Session::flash('error', 'Your mail was not sent Successfully. Please try again.');
                        return redirect()->route('bcc-file-upload');
                    }

                }catch (\Exception $e){
                    Session::flash('danger',$e->getMessage());
                    //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                    return redirect()->route('edit-bcc-file-upload',$id);
                }


        return redirect()->route('bcc-file-upload');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_attachment_file($id)
    {


        $model = ApplicationAttachment::findOrFail($id);

        $file_path = public_path() . '/' . $model->application_attachment_path;
       

        if(File::exists($file_path)){

         File::delete($file_path);

        }else{

            Session::flash('danger',"Attached File was not found");
            return redirect()->back();

        }

       DB::beginTransaction();
       try {
           
           $model->delete();
           DB::commit();
           Session::flash('message', "File Successfully Deleted.");

       } catch(\Exception $e) {
           DB::rollback();
           //Session::flash('danger',$e->getMessage());
           Session::flash('danger',"Couldn't Delete File Successfully. Please Try Again.");
       }
       return redirect()->back();
       
    }




}