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


class OrganizationFileUploadController extends Controller
{

    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    private $to_email;

    private $from_email;

    public function __construct()
    {

     $this->to_email = BccEmail::all()->pluck('email_address')->toArray(); 

     $this->from_email = Auth::user()->email;

    }


    public function index()
    {
        
        $pageTitle = "Letter's Sent to BCC";

        $user_role = Session::get('role_title');
        $company_id = Session::get('company_id');

        if($user_role == 'admin' || $user_role == 'super-admin')
        {
            $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','organization')->orderBy('id', 'desc')->get();
        }
        else
        {
            $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','organization')->where('company_id',$company_id)->orderBy('id', 'desc')->get();
        }


        return view('application::organization_file_upload.index', ['pageTitle'=> $pageTitle,'data'=> $data]);
    }

    public function received_email_index()
    {
                        
        $pageTitle = "Letter's Received from BCC";

        $user_role = Session::get('role_title');
        $company_id = Session::get('company_id');

        if($user_role == 'admin' || $user_role == 'super-admin')
        {
            $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','bcc')->orderBy('id', 'desc')->get();
        }
        else
        {
            $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->where('bcc_or_organization','bcc')->where('company_id',$company_id)->orderBy('id', 'desc')->get();
        }

        return view('application::organization_file_upload.received_email_index', ['pageTitle'=> $pageTitle,'data'=> $data]);
    }

    public function create()
    {

        $user = Auth::user();
        $company_id = $user->company_id;
        $company = Company::where('id',$company_id)->where('status','active')->first();

        $page_title = "Application To Bangladesh Computer Council";
        return view('application::organization_file_upload.create',compact('page_title','company'));
    }

    public function store(Requests\OrganizationMasterRequest $request)
    {
    


        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $from_email = $this->from_email;
        $to_email = $this->to_email;

        if (empty($to_email)) {
            Session::flash('danger', "No BCC email has been set. Please go to option panel to set BCC email address.");
            return redirect()->route('create-organization-file-upload');
        }


        $input['user_id'] = $user_id;
        $input['company_id'] = $company_id;
        $input['application_format'] = 'file_upload';
        $input['bcc_or_organization'] = 'organization';
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
            return redirect()->route('organization-file-upload');
        }


        $org_app_dtls = $request->only('subject','letter_no');
        $org_app_dtls['org_app_mst_id'] = $org_app_mst->id;
        $org_app_dtls['to_email'] = implode(",",$to_email);
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
            return redirect()->route('organization-file-upload');
        }






        $model = Company::where('id',$company_id)->first();
        $company_input = $request->only('mobile','phone','address');

        DB::beginTransaction();
        try {
            $model->update($company_input);
            DB::commit();
            
        }

        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Update Company information Successfully. Please Try Again.");
            return redirect()->route('organization-file-upload');
        }


        //dd('fff');

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
                    $upload_folder = 'organization_application/';
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
                    return redirect('create-organization-file-upload')
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
                    $mail_sent = Mail::send('application::organization_file_upload.org_mail_notification', $email_data,
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
                        return redirect()->route('organization-file-upload');
                    }

                }catch (\Exception $e){
            Session::flash('danger', $e->getMessage());

                    //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                    return redirect()->route('organization-file-upload');
                }

        }else{
            Session::flash('error', 'Does not Save!');
            return redirect()->route('organization-file-upload');
        }

        return redirect()->route('organization-file-upload');

    }

    public function show($received = null, $id)
    {


        if ($received == 'received') {

            $page_title = 'Received Letter from Organization';

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

            $page_title = 'Sent Letter to BCC';

        }
        



        

        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->with('relAttachment')->where('id',$id)->first();

        $has_file = $data->relAttachment()->count();

        $file_data = $data->relAttachment;

        return view('application::organization_file_upload.view', compact('data','page_title','has_file','file_data'));

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

        $page_title = "Application To Bangladesh Computer Council";
        return view('application::organization_file_upload.edit',compact('page_title','data','file_data','company','has_file'));
    }


    public function update(Requests\OrganizationMasterRequest $request, $id)
    {

        dd($request->all());
        
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $from_email = $this->from_email;
        $to_email = $this->to_email;

        if (empty($to_email)) {
            Session::flash('danger', "No BCC email has been set. Please go to option panel to set BCC email address.");
            return redirect()->route('create-organization-template');
        }

        $org_app_dtls = $request->only('subject','letter_no');
        $org_app_dtls['to_email'] = implode(",",$to_email);
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
            return redirect()->route('organization-file-upload');
        }



        $model = Company::where('id',$company_id)->first();
        $company_input = $request->only('mobile','phone','address');

        DB::beginTransaction();
        try {
            $model->update($company_input);
            DB::commit();
            
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "Couldn't Update Company information Successfully. Please Try Again.");
            return redirect()->route('organization-file-upload');
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
                    $upload_folder = 'organization_application/';
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
                    return redirect('create-organization-file-upload')
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
                    $mail_sent = Mail::send('application::organization_file_upload.org_mail_notification', $email_data,
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
                        return redirect()->route('organization-file-upload');
                    }

                }catch (\Exception $e){
           Session::flash('danger',$e->getMessage());

                    //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                    return redirect()->route('organization-file-upload');
                }


        return redirect()->route('organization-file-upload');

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