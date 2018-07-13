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
use Modules\Application\TemplateExtraInformation;
use Validator;
use Storage;
use File;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;


class BccTemplateController extends Controller
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

        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->orderBy('id', 'desc')->get();
        //print_r($data);exit;

        return view('application::bcc_template.index', ['pageTitle'=> $pageTitle,'data'=> $data]);
    }

    public function create()
    {
        
        $company_list =  [''=>'Select organization'] + Company::where('status','active')->where('id','!=',1)->orderBy('id','desc')->lists('company_name','id')->all();

        $company_details_list =  Company::where('status','active')->orderBy('id', 'desc')->get();
        $bcc_company = Company::find(1);
        $date_email = date("d-m-Y");

        $page_title = "Application To Organization";
    
        return view('application::bcc_template.create',compact('page_title','company_list','company_details_list','bcc_company','date_email'));
    }

    public function store(Requests\OrganizationMasterRequest $request)
    {

        $company_id= $request->only('company_id')['company_id'];
        

        $user = User::where('company_id',$company_id)->where('role_id',5)->first();

        if (empty($user)) {
            Session::flash('danger', "This organization has not been registered yet.");
            return redirect()->route('create-bcc-template');
        }

        $from_email = $this->from_email;
        $to_email = $user->email;

        $file_paths = [];

        if (empty($to_email)) {
            Session::flash('danger', "This company does not have email set.");
            return redirect()->route('create-bcc-template');
        }

        $input['user_id'] = $user->id;
        $input['company_id'] = $company_id;
        $input['application_format'] = 'template';
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
            return redirect()->route('create-bcc-template');
        }


        $org_app_dtls = $request->only('subject','to_person','date_email','yours_only','letter_no','email_description');
        $org_app_dtls['org_app_mst_id'] = $org_app_mst->id;
        $org_app_dtls['to_email'] = $to_email;
        $org_app_dtls['from_email'] = $from_email;


        DB::beginTransaction();
        try {
            $model = new OrganizationDetails();
            $org_app_dtls = $model->create($org_app_dtls);
            DB::commit();
            
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "An error occured. Please Try Again.");
            return redirect()->route('create-bcc-template');
        }



            $reference_nos = $request->only('reference_no')['reference_no'];
            $copys = $request->only('copy')['copy'];


            $extra_data_array=[];


            if($reference_nos || $copys){

                DB::beginTransaction();
                try {
                    $model = new TemplateExtraInformation();

                    foreach ($reference_nos as $reference_no) {
                     
                     $extra_data['extra_information'] = $reference_no;
                     $extra_data['extra_information_type'] = 'reference_no';
                     $extra_data['org_app_mst_id'] = $org_app_mst->id;
                     $extra_data_array[] = $extra_data;

                 }

                 foreach ($copys as $copy) {
                     
                     $extra_data['extra_information'] = $copy;
                     $extra_data['extra_information_type'] = 'copy';
                     $extra_data['org_app_mst_id'] = $org_app_mst->id;
                     $extra_data_array[] = $extra_data;

                 }
    
                 $model->insert($extra_data_array);
                 DB::commit();

             }

             catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
                DB::rollback();
            //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't save extra information. Please Try Again.");
                return redirect()->route('create-organization-template');
            }

        }



        //----------------- For Attachment file-------------------//
        $attachments=Input::file('template_extra_attachment');
        //print_r($file_attachments); exit("ok");
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
                    return redirect('create-bcc-template')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }//---------End Attachment


        //$email_template_path='';

        if($org_app_mst) {


            $input = $request->all();

            $has_file = ! empty($_FILES['template_extra_attachment']['name'][0]);

            $company = Company::find($company_id);

            $bcc_company = Company::find(1);

            $input['address'] = $company->address;
            
            $email_template_content =  view('application::bcc_template.email_template',compact('input','company','bcc_company','has_file'))->render();
            
            $email_template_relative_path = $upload_folder . rand(1111111, 9999999) . '-' . 'application_letter.html';

            $email_template_path = public_path() . '/' . $email_template_relative_path;

            $email_template_created = file_put_contents($email_template_path, $email_template_content);

            if ($email_template_created) {
                $data = [
                'org_app_mst_id' => $org_app_mst->id,
                'application_attachment_path'=>$email_template_relative_path,
                'attachment_type'=>'template_main',
                'status' => 'active'
                ];

                ApplicationAttachment::create($data);
            }


            if (! empty($file_paths)){
                foreach($file_paths as $file_path){
                    $data = [
                        'org_app_mst_id' => $org_app_mst->id,
                        'application_attachment_path'=>$file_path,
                        'attachment_type'=>'template_extra',
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
                $mail_sent = Mail::send('application::bcc_template.org_mail_notification', $email_data,
                    function($message) use ($to_email,$subject,$from_email,$email_template_path,$file_paths)
                    {
                        $message->from($from_email, 'Application for examination arrangement');
                        $message->to($to_email);
                        //$message->to('shajjadhossain81@gmail.com');
                        //$message->replyTo('devdhaka405@gmail.com','New Air Safety Data Added');
                        $message->subject($subject);

                        $message->attach($email_template_path);
            
                        if (! empty($file_paths)) {
                            foreach ($file_paths as $file_path) {
                                $message->attach($file_path);
                            }
                        }
                    });

                if($mail_sent){
                    Session::flash('message', 'Application has been successfully sent.');
                }else{
                    Session::flash('error', 'Your mail was not sent Successfully. Please try again.');
                    return redirect()->route('create-bcc-template');
                }

            }catch (\Exception $e){

                Session::flash('danger', $e->getMessage());
                Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                return redirect()->route('create-bcc-template');
            }
        



    }else{
            Session::flash('error', 'Does not Save!');
            return redirect()->route('create-bcc-template');
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



        $data = OrganizationMaster::with('user')->with('company')->with('relAppOrgDtls')->with('relAttachment')->where('id',$id)->first();

        $file_main_data = $data->relAttachment()->where('attachment_type','template_main')->where('status','active')->first();

        $file_extra_data = $data->relAttachment()->where('attachment_type','template_extra')->where('status','active')->get();

        return view('application::bcc_template.view', compact('data','page_title','file_main_data','file_extra_data'));

    }

    public function edit($id)
    {

        $user = Auth::user();
        $bcc_company = Company::find(1);
        $date_email = date("d-m-Y");
        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();


        $app_org_mst = OrganizationMaster::with('relAppOrgDtls')->with('relAttachment')->with('relExtraInformation')->where('id',$id)->first();
        $has_file = $app_org_mst->relAttachment()->where('attachment_type','template_extra')->count();

        $company_id = $app_org_mst->company_id;
        $company = Company::find($company_id);
    
        $data = $app_org_mst->relAppOrgDtls;

        $data->company_id = $company_id;


        $data->id = $app_org_mst->id;
        $file_data = $app_org_mst->relAttachment()->where('attachment_type','template_extra')->get();
        

        $extra_reference_no_informations = $app_org_mst->relExtraInformation()->where('extra_information_type','reference_no')->get();
        $extra_copy_informations = $app_org_mst->relExtraInformation()->where('extra_information_type','copy')->get();


        $page_title = "Application To Organization";
        return view('application::bcc_template.edit',compact('page_title','data','extra_informations','file_data','company','bcc_company','company_list','has_file','date_email','extra_reference_no_informations','extra_copy_informations'));
    }
    

    public function update(Requests\OrganizationMasterRequest $request, $id)
    {

        $company_id= $request->only('company_id')['company_id'];

        $user = User::where('company_id',$company_id)->where('role_id',5)->first();

        if (empty($user)) {
            Session::flash('danger', "This organization has not been registered yet.");
            return redirect()->route('edit-bcc-template',$id);
        }


        $from_email = $this->from_email;
        $to_email = $user->email;
        $file_paths = [];

        if (empty($to_email)) {
            Session::flash('danger', "No organization user email has been set.");
            return redirect()->route('edit-bcc-template',$id);
        }
        

        $org_app_dtls = $request->only('subject','to_person','date_email','yours_only','letter_no','email_description');
        $org_app_dtls['to_email'] = $to_email;
        $org_app_dtls['from_email'] = $from_email;


        DB::beginTransaction();
        try {
            $model = OrganizationDetails::where('org_app_mst_id',$id)->first();

            $org_app_dtls = $model->update($org_app_dtls);

            DB::commit();
            
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            //Session::flash('danger', $e->getMessage());
            Session::flash('danger', "An error occured. Please Try Again.");
            return redirect()->route('edit-bcc-template',$id);
        }





        $reference_nos = $request->only('reference_no')['reference_no'];
        $copys = $request->only('copy')['copy'];
        $extra_data_array=[];


                if($reference_nos || $copys){

                DB::beginTransaction();


                try {

                    TemplateExtraInformation::where('org_app_mst_id',$id)->delete();

                    $model = new TemplateExtraInformation();

                    foreach ($reference_nos as $reference_no) {
                     
                     $extra_data['extra_information'] = $reference_no;
                     $extra_data['extra_information_type'] = 'reference_no';
                     $extra_data['org_app_mst_id'] = $id;
                     $extra_data_array[] = $extra_data;

                 }

                 foreach ($copys as $copy) {
                     
                     $extra_data['extra_information'] = $copy;
                     $extra_data['extra_information_type'] = 'copy';
                     $extra_data['org_app_mst_id'] = $id;
                     $extra_data_array[] = $extra_data;

                 }

        
                 $model->insert($extra_data_array);
                 DB::commit();

             }

             catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
                DB::rollback();
            //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't update extra information. Please Try Again.");
                return redirect()->route('edit-bcc-template',$id);
            }

        }


        //----------------- For Attachment file-------------------//
        $attachments=Input::file('template_extra_attachment');
        //print_r($file_attachments); exit("ok");
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
                    return redirect('edit-bcc-template',$id)
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }//---------End Attachment

      


            if($org_app_dtls) {


                $email_template = ApplicationAttachment::where('org_app_mst_id',$id)->where('attachment_type','template_main')->first();

                $email_template_path = $email_template->application_attachment_path;

                if(File::exists($email_template_path)){

                    File::delete($email_template_path);

                }else{

                    Session::flash('error', 'Email template file doesn\'t exist.');
                    
                }

                $input = $request->all();

                $company = Company::find($company_id);

                $bcc_company = Company::find(1);

                $company_name = $company->company_name;

                $input['address'] = $company->address;



                $app_org_mst = OrganizationMaster::where('id',$id)->first();

                $has_previous_file = $app_org_mst->relAttachment()->where('attachment_type','template_extra')->count();

                $has_current_file = ! empty($_FILES['template_extra_attachment']['name'][0]);

                $has_file = ($has_previous_file || $has_current_file) ? true : false;



                $email_template_content =  view('application::bcc_template.email_template',compact('input','company_name','bcc_company','has_file'))->render();
                

                $email_template_relative_path = $upload_folder . rand(1111111, 9999999) . '-' . 'application_letter.html';

                $email_template_path = public_path() . '/' . $email_template_relative_path;
    

                $email_template_created = file_put_contents($email_template_path, $email_template_content);


                if ($email_template_created) {
                    
                    $model = ApplicationAttachment::where('org_app_mst_id',$id)->first();
                    
                    DB::beginTransaction();

                    try{
                        
                                                
                        $main_attachment['application_attachment_path'] = $email_template_relative_path;
                    
                        $model->update($main_attachment);

                        DB::commit();

                    }catch (\Exception $e){

                        Session::flash('danger', $e->getMessage());
                        //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                        return redirect()->route('edit-bcc-template',$id);
                    }

                }

                // /dd($file_paths);

                if(! empty($file_paths)){
                    foreach($file_paths as $file_path){
                        $data = [
                            'org_app_mst_id' => $id,
                            'application_attachment_path'=>$file_path,
                            'attachment_type'=>'template_extra',
                            'status' => 'active'
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
                        $mail_sent = Mail::send('application::bcc_template.org_mail_notification', $email_data,
                            function($message) use ($to_email,$subject,$from_email,$email_template_path,$file_paths)
                            {

                                $message->from($from_email, 'Application for examination arrangement');
                                $message->to($to_email);
                                //$message->to('shajjadhossain81@gmail.com');
                                //$message->replyTo('devdhaka405@gmail.com','New Air Safety Data Added');
                                $message->subject($subject);

                                $message->attach($email_template_path);
                                if (! empty($file_paths)) {
                                    foreach ($file_paths as $file_path) {
                                        $message->attach($file_path);
                                    }
                                }
                                
                            });

                        if($mail_sent){
                            Session::flash('message', 'Application has been successfully sent.');
                        }else{
                            Session::flash('error', 'Your mail was not sent Successfully. Please try again.');
                            return redirect()->route('edit-bcc-template',$id);
                        }

                    }catch (\Exception $e){

                        Session::flash('danger', $e->getMessage());
                        //Session::flash('error', 'Invalid Request! Your mail was not sent Successfully. Please try again.');
                        return redirect()->route('edit-bcc-template',$id);
                    }




        }else{
                Session::flash('error', 'Does not Save!');
                return redirect()->route('edit-bcc-template',$id);
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


    public function ajax_preview_data()
    {

        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $bcc_company = Company::find(1);        
        $input = $_POST;

        if (isset($input['app_org_mst_id'])) {

            $app_org_mst = OrganizationMaster::where('id',$input['app_org_mst_id'])->first();

            $has_previous_file = $app_org_mst->relAttachment()->where('attachment_type','template_extra')->count();

            $has_current_file = ! empty($_FILES['template_extra_attachment']['name'][0]);

            $has_file = ($has_previous_file || $has_current_file) ? true : false;

        }else{

            $has_file = ! empty($_FILES['template_extra_attachment']['name'][0]);
        }

        $company = Company::find($company_id);

        return $email_template_content =  view('application::bcc_template.email_template',compact('input','company','bcc_company','has_file'))->render();

    }




    public function ajax_print_preview_data()
    {


        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $bcc_company = Company::find(1);        
        $input = $_POST;

        if (isset($input['app_org_mst_id'])) {

            $app_org_mst = OrganizationMaster::where('id',$input['app_org_mst_id'])->first();

            $has_previous_file = $app_org_mst->relAttachment()->where('attachment_type','template_extra')->count();

            $has_current_file = ! empty($_FILES['template_extra_attachment']['name'][0]);

            $has_file = ($has_previous_file || $has_current_file) ? true : false;

        }else{

            $has_file = ! empty($_FILES['template_extra_attachment']['name'][0]);
        }

        $company = Company::find($company_id);

        $email_template_content =  view('application::bcc_template.email_template',compact('input','company','bcc_company','has_file'))->render();
        
        
        $email_template_path = 'temp_preview/' . rand(1111111, 9999999) . '-' . 'application_letter.html';

        $email_template_created = file_put_contents($email_template_path, $email_template_content);



        if ($email_template_created) {

            return $email_template_path;

        }else{

            return 'error';
            
        }



    }


    public function ajax_delete_print_preview_data()
    {

        $path = $_POST;

        $file_path = public_path() . '/' . $path['data'];


        if(File::exists($file_path)){

           File::delete($file_path);

       }else{
        
        Session::flash('danger',"Preview File was not found");
        return redirect()->back();

        }



    }




}