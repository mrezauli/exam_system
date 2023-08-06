<?php

namespace Modules\Reports\Controllers;

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
use Modules\Admin\JobArea;
use Modules\Admin\Product;
use Modules\Admin\Industry;
use Modules\Crms\Task;
use Modules\Crms\Meeting;
use Validator;
use App\Helpers\ImageResize;
use App\Role;
use App\UserMeta;
use App\UserResetPassword;
use DateTime;
use App\RoleUser;
use App\UserActivity;

use Mockery\CountValidator\Exception;

use Dompdf\Dompdf;


class ReportController extends Controller
{
    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    public function datewise_movement()
    {
        $pageTitle = "Sales Person Movement Statement";

        $visiting_area =  [''=>'Select Visiting Area'] + JobArea::lists('area_name','id')->all();
        //$user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [1, 3])->lists('username','id')->all();
        $user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [3])->lists('username','id')->all();

        $status = 1;

        return view('reports::datewise_movement.index', ['pageTitle'=> $pageTitle,'visiting_area'=>$visiting_area,'user_list'=>$user_list,'status'=>$status]);
    }

    public function generate_datewise_movement(){



        $pageTitle = "Sales Person Movement Statement";

        $visiting_area =  [''=>'Select Visiting Area'] + JobArea::lists('area_name','id')->all();
        //$user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [1, 3])->lists('username','id')->all();
        $user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [3])->lists('username','id')->all();

        $status = 2;

        if($this->isGetRequest()){
            $user_id = Input::get('user_id');
            $job_area_id = Input::get('job_area_id');
            $meeting_date_from = Input::get('meeting_date_from');
            $meeting_date_to = Input::get('meeting_date_to');

            /*$model = DB::select(DB::raw("SELECT
                t.subject,m.meeting_date,u.username,j.area_name,l.lead_name,c.company_name
                FROM task AS t
                LEFT JOIN meeting as m ON (t.id=m.task_id)
                LEFT JOIN user as u on t.created_by = u.id
                LEFT JOIN job_area as j ON (j.id=m.job_area_id)
                LEFT JOIN lead as l ON (l.id=t.lead_id)
                LEFT JOIN company as c ON (c.id=l.company_id)
                WHERE t.created_by=$user_id"));*/

            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 'm.meeting_date','u.username','j.area_name','l.lead_name','c.company_name','t.id AS task_id','m.id AS meeting_id')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' );
            /* ->leftJoin( DB::raw( 'SELECT postslikes.post_id, SUM( postslikes.status ) FROM postslikes GROUP BY postslikes.post_id' ), function( $join )
                {
                    $join->on( 'postslikes.post_id', '=', 'post.id' );
                })
                ->leftJoin( DB::raw( 'SELECT comments.post_id, COUNT(*) FROM comments GROUP BY comments.post_id' ), function( $join )
                {
                    $join->on( 'comments.post_id', '=', 'post.id' );
                })*/

            if(isset($user_id) && !empty($user_id)){
                $model = $model->where('t.created_by','=',$user_id);
            }
            if(isset($job_area_id) && !empty($job_area_id)){
                $model = $model->where('m.job_area_id','=',$job_area_id);
            }


            if($meeting_date_from == '' && $meeting_date_to != ''){
                $model = $model->where('m.meeting_date','=',$meeting_date_to);
            }
            if($meeting_date_from != '' && $meeting_date_to == ''){
                $model = $model->where('m.meeting_date','=',$meeting_date_from);
            }
            if($meeting_date_from != '' && $meeting_date_to != ''){
                $model = $model->whereBetween('m.meeting_date', array($meeting_date_from, $meeting_date_to));
            }
            //$meeting_date_from = isset($meeting_date_from) && !empty($meeting_date_from) ? $meeting_date_from:'2000-10-10';
            //$meeting_date_to = isset($meeting_date_to) && !empty($meeting_date_to) ? $meeting_date_to:date('Y-m-d');



            $model = $model->paginate(30);

            //print_r($model);exit;

            /*if(isset($user_id) && !empty($user_id)){
                $model = $model->where('user.username', 'LIKE', '%'.$username.'%');
            }
            if(isset($branch_id) && !empty($branch_id)){
                $model = $model->where('user.company_id', '=', $branch_id);
            }
            if(isset($status) && !empty($status)){
                $model = $model->where('user.status', '=', $status);
            }

            $model = $model->paginate(30);*/


        }else{
            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 'm.meeting_date','u.username','j.area_name','l.lead_name','c.company_name','t.id AS task_id','m.id AS meeting_id')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' );
            $model = $model->paginate(30);
        }

        return view('reports::datewise_movement.index', ['pageTitle'=> $pageTitle,'visiting_area'=>$visiting_area,'user_list'=>$user_list,'model'=>$model,'status'=>$status]);

    }

    public function meeting_details($task_id, $meeting_id){

        $pageTitle = "Sales Person Movement Statement";

        $model = DB::table( 'task AS t' )
            ->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name','t.id AS task_id','m.id AS meeting_id')
            ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
            ->where('t.id','=',$task_id)
            ->where('m.id','=',$meeting_id)
            ->get();

        $meeting_owner = Meeting::with('user')->where('id',$meeting_id)->first();

        $task_client_existing_products = Task::with('relClientExistingProducts')->find($task_id);

        #print_r($meeting_owner->user->username);exit("ok");

        return view('reports::datewise_movement.meeting_details', ['pageTitle'=> $pageTitle,'data'=>$model, 'meeting_owner'=>$meeting_owner,'task_client_existing_products'=>$task_client_existing_products]);

    }

    public function task_report(){

        $pageTitle = "Task Informations";
        $company_list =  [''=>'Select client company'] + Company::where('company_type','=','client_company')->lists('company_name','id')->all();

        $status = 1;

        return view('reports::task_report.index', ['pageTitle'=> $pageTitle,'company_list'=>$company_list,'status'=>$status]);
    }

    public function generate_task_report(){

        $pageTitle = "Task Informations";

        $company_list =  [''=>'Select client company'] + Company::where('company_type','=','client_company')->lists('company_name','id')->all();

        $status = 2;

        if($this->isGetRequest()){

            $task_name = Input::get('task_name');
            $contact_person = Input::get('contact_person');
            $company_name = Input::get('company_list');
            $meeting_date_from = Input::get('meeting_date_from');
            $meeting_date_to = Input::get('meeting_date_to');

            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 't.priority','u.username','l.lead_name','c.company_name','t.id AS task_id')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' );


            if(isset($company_name) && !empty($company_name)){

                $model = $model->where('c.id','=',$company_name);
            }
            if(isset($contact_person) && !empty($contact_person)){
                $model = $model->where('l.lead_name','LIKE','%'.$contact_person.'%');
            }
            if(isset($task_name) && !empty($task_name)){
                $model = $model->where('t.subject','LIKE','%'.$task_name.'%');
            }

            if( !empty($meeting_date_from) || !empty($meeting_date_from) ){

            $meeting_date_from = isset($meeting_date_from) && !empty($meeting_date_from) ? $meeting_date_from:'2000-10-10';

            $meeting_date_to = isset($meeting_date_to) && !empty($meeting_date_to) ? $meeting_date_to:date('Y-m-d');

            $model = $model->whereBetween('m.meeting_date', array($meeting_date_from, $meeting_date_to));
}

            $model = $model->paginate(30);
        }else{
            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 't.priority','u.username','l.lead_name','c.company_name','t.id AS task_id')
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' );
            $model = $model->paginate(30);
        }

        return view('reports::task_report.index', ['pageTitle'=> $pageTitle,'company_list'=>$company_list,'model'=>$model,'status'=>$status]);
    }

    public function task_detail($task_id){

        $pageTitle = "Task Detail Information";

        //->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name')

        $model = DB::table( 'task AS t' )
            ->select( 't.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','t.id AS task_id')
            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
            ->where('t.id','=',$task_id)
            ->get();

        $meeting_details = DB::table( 'meeting AS m' )
            ->select( 'm.*','u.username AS uname','j.area_name')
            ->leftJoin( 'user as u', 'm.user_id', '=', 'u.id' )
            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
            ->where('m.task_id','=',$task_id)
            ->get();



        //$meeting_owner = Meeting::with('user')->where('id',$meeting_id)->first();

        #print_r($meeting_details);exit("ok");

        $task_client_existing_products = Task::with('relClientExistingProducts')->find($task_id);

        return view('reports::task_report.task_detail', ['pageTitle'=> $pageTitle,'data'=>$model,'meeting_details'=>$meeting_details,'task_client_existing_products'=>$task_client_existing_products]);
    }













    public function visiting_information()
    {
        $pageTitle = "Visiting Information";

        $visiting_area =  [''=>'Select Visiting Area'] + JobArea::lists('area_name','id')->all();
        //$user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [1, 3])->lists('username','id')->all();
        $user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [3])->lists('username','id')->all();

        $status = 1;

        return view('reports::visiting_information.index', ['pageTitle'=> $pageTitle,'visiting_area'=>$visiting_area,'user_list'=>$user_list,'status'=>$status]);
    }

    public function generate_visiting_information(){

        $pageTitle = "Visiting Information";

        $visiting_area =  [''=>'Select Visiting Area'] + JobArea::lists('area_name','id')->all();
        //$user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [1, 3])->lists('username','id')->all();
        $user_list =  [''=>'Select Sales Person'] + User::whereNotIn('role_id', [3])->lists('username','id')->all();

        $status = 2;

        if($this->isGetRequest()){
            $user_id = Input::get('user_id');
            $job_area_id = Input::get('job_area_id');
            $meeting_date_from = Input::get('meeting_date_from');
            $meeting_date_to = Input::get('meeting_date_to');

            /*$model = DB::select(DB::raw("SELECT
                t.subject,m.meeting_date,u.username,j.area_name,l.lead_name,c.company_name
                FROM task AS t
                LEFT JOIN meeting as m ON (t.id=m.task_id)
                LEFT JOIN user as u on t.created_by = u.id
                LEFT JOIN job_area as j ON (j.id=m.job_area_id)
                LEFT JOIN lead as l ON (l.id=t.lead_id)
                LEFT JOIN company as c ON (c.id=l.company_id)
                WHERE t.created_by=$user_id"));*/

            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 'm.meeting_date','m.status AS meeting_status','u.username','j.area_name','l.lead_name','c.company_name','t.id AS task_id','m.id AS meeting_id','p.product_name AS product_name')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' );
            /* ->leftJoin( DB::raw( 'SELECT postslikes.post_id, SUM( postslikes.status ) FROM postslikes GROUP BY postslikes.post_id' ), function( $join )
                {
                    $join->on( 'postslikes.post_id', '=', 'post.id' );
                })
                ->leftJoin( DB::raw( 'SELECT comments.post_id, COUNT(*) FROM comments GROUP BY comments.post_id' ), function( $join )
                {
                    $join->on( 'comments.post_id', '=', 'post.id' );
                })*/

            if(isset($user_id) && !empty($user_id)){
                $model = $model->where('t.created_by','=',$user_id);
            }
            if(isset($job_area_id) && !empty($job_area_id)){
                $model = $model->where('m.job_area_id','=',$job_area_id);
            }

            if($meeting_date_from == '' && $meeting_date_to != ''){
                $model = $model->where('m.meeting_date','=',$meeting_date_to);
            }
            if($meeting_date_from != '' && $meeting_date_to == ''){
                $model = $model->where('m.meeting_date','=',$meeting_date_from);
            }
            if($meeting_date_from != '' && $meeting_date_to != ''){
                $model = $model->whereBetween('m.meeting_date', array($meeting_date_from, $meeting_date_to));
            }

           // $meeting_date_from = isset($meeting_date_from) && !empty($meeting_date_from) ? $meeting_date_from:'2000-10-10';
           // $meeting_date_to = isset($meeting_date_to) && !empty($meeting_date_to) ? $meeting_date_to:date('Y-m-d');

            //$model = $model->whereBetween('m.meeting_date', array($meeting_date_from, $meeting_date_to));

            $model = $model->paginate(30);

            /*if(isset($user_id) && !empty($user_id)){
                $model = $model->where('user.username', 'LIKE', '%'.$username.'%');
            }
            if(isset($branch_id) && !empty($branch_id)){
                $model = $model->where('user.company_id', '=', $branch_id);
            }
            if(isset($status) && !empty($status)){
                $model = $model->where('user.status', '=', $status);
            }

            $model = $model->paginate(30);*/


        }else{
            $model = DB::table( 'task AS t' )
                ->select( 't.subject', 'm.meeting_date','u.username','j.area_name','l.lead_name','c.company_name','t.id AS task_id','m.id AS meeting_id')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' );
            $model = $model->paginate(30);
        }

        //dd($model);

        return view('reports::visiting_information.index', ['pageTitle'=> $pageTitle,'visiting_area'=>$visiting_area,'user_list'=>$user_list,'model'=>$model,'status'=>$status]);

    }

    public function visiting_information_details($task_id, $meeting_id){

        $pageTitle = "Visiting Information";

        $data = DB::table( 'task AS t')
            ->select( 't.*', 'm.*','u.username AS uname','l.lead_name','l.mobile','l.phone','l.designation','c.company_name','c.factory_address','ho_address','p.product_name','j.area_name','b.name as business_type_name','i.name as industry_category_name','m.id as meeting_id','t.id as task_id')
            ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
            ->leftJoin( 'industry as i', 'i.id', '=', 'c.industry_id' )
            ->leftJoin( 'business_type as b', 'b.id', '=', 'c.business_type_id' )
            ->where('t.id','=',$task_id)
            ->where('m.id','=',$meeting_id)
            ->get();

        $meeting_owner = Meeting::with('user')->where('id',$meeting_id)->first();

        $task = Task::find($task_id);
        $company = Company::with('clientExistingProducts')->find($task->company_id);

        return view('reports::visiting_information.visiting_information_details', compact('pageTitle','data', 'meeting_owner','company'));

    }

    public function visiting_info_pdf($task_id, $meeting_id){

        $pageTitle = "Visiting Information";

        $data = DB::table( 'task AS t')
            ->select( 't.*', 'm.*','u.username AS uname','l.lead_name','l.mobile','l.phone','l.designation','c.company_name','c.factory_address','ho_address','p.product_name','j.area_name','b.name as business_type_name','i.name as industry_category_name','m.id as meeting_id')
            ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
            ->leftJoin( 'industry as i', 'i.id', '=', 'c.industry_id' )
            ->leftJoin( 'business_type as b', 'b.id', '=', 'c.business_type_id' )
            ->where('t.id','=',$task_id)
            ->where('m.id','=',$meeting_id)
            ->get();

        $meeting_owner = Meeting::with('user')->where('id',$meeting_id)->first();

       $task = Task::find($task_id);
       $company = Company::with('clientExistingProducts')->find($task->company_id);

        $html = '

<style>

th span{
    word-wrap:break-word !important;
    font-family: Arial, Helvetica, sans-serif;
}

tr th span{

display:inline-block !important;
margin-top:1px !important;
margin-left:3px !important;

}
    .tbl {
        margin-bottom: 0px !important;
        border: 2px solid;
        border-bottom: 0px !important;
        width: 100%;
        font-family: Arial !important;
    }

    .tbl3 {
        margin: 0px !important;
        border: 2px solid;
        border-top: 0px!important;
        border-left: 0px!important;
        border-right: 0px!important;
        width: 100%;
    }

    .tbl2 {
       margin: 0px !important;
       border: 2px solid;
       width: 100%;
    }
    .tbl2 tr th {
        border: 2px solid;
    }

    .tbl2 th{
    text-align: left; font-weight: normal; padding: 5px; font-size:13px;
    }

    .tbl2 tr td {
        padding:7px; text-align: left;
        text-align: left !important;
        }

    .report_img{
        height: 100px!important;
        text-align: center!important;
        padding: 15px 10px 18px 10px!important;
    }

    .report_img2{
        height: 10px!important;
        text-align: left!important;
        padding: 5px 2px 8px 2px!important;
    }

    .panel, .panel-body{
        width: 100%;
    }
th{
    word-wrap:break-word !important;

}

</style>

    <div class="panel">
        <h3 style="text-align: center"><b>Visiting Information</b></h3>
        <div style="text-align: right"><b>Sales Person ::'.ucfirst($data[0]->uname).'</b></div>
            <br>
            <div class="panel-body" style="border:3px solid #000000">
                <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
                    <tr>
                        <th style="text-align: center;background-color: #C5E5F0;" colspan="2">Client Information</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Visited Date :</b>'.ucfirst($data[0]->meeting_date).'</th>
                        <th width="50%"><b>Visited Zone : </b>'.ucfirst($data[0]->area_name).'</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Name : </b>'.ucfirst($data[0]->lead_name).'</th>
                        <th width="50%"><b>Company Name : </b>'.$data[0]->company_name.'</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Mobile No. :</b>'.$data[0]->mobile.'</th>
                        <th width="50%"><b>Office Phone :</b>'.$data[0]->phone.'</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Designation : </b>'.ucfirst($data[0]->designation).'</th>
                        <th width="50%"><b>Factory Address :</b>'.ucfirst($data[0]->factory_address).'</th>

                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>H/O Address : </b>'.ucfirst($data[0]->ho_address).'</th>
                        <th width="50%"><b>Industry Category : </b>'.ucfirst($data[0]->industry_category_name).'</th>

                    </tr>
                    <tr style="vertical-align: top;">
                    <th colspan="2"><b>Business Type : </b>'.ucfirst($data[0]->business_type_name).'</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>';


    if($company->clientExistingProducts()->lists('status')->contains('active'))
        {
            $html = $html.'

            <h3 style="text-align: center;">Client Existing Product</h3>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">

                <thead>
                    <tr style="background-color: #C5E5F0;">
                        <th><b> Product Name</b></th>
                        <th><b> Age</b></th>
                        <th><b> Brand</b></th>
                        <th><b> Capacity</b></th>
                        <th><b> Comments</b></th>
                    </tr>
                </thead>';

                foreach($company->clientExistingProducts as $values)
                {
                    if($values->status == 'active'){

                        $html = $html.'<tr>

                        <th>'.$values->product_name.'</th>
                        <th>'.$values->age.'</th>
                        <th>'.$values->brand.'</th>
                        <th>'.$values->capacity.'</th>
                        <th>'.$values->comments.'</th>
                    </tr>';

                }
            }

            $html = $html.'</table>';
        }


     $html = $html.'

     <br>
     <h3 style="text-align: center;">Meeting Summary</h3>
     <table cellpadding="0" cellspacing="0" style="table-layout:fixed" class="table table-bordered table-responsive no-spacing tbl2">
        <tr style="vertical-align: top;">
            <th width="50%" style="word-wrap:break-word"><b>Marketing Product :</b>'.ucfirst($data[0]->product_name).'</th>
            <th width="50%"><b>Present Requirement Status : </b>'.ucfirst($data[0]->product_requirement_status).'</th>
            <th width="50%"><b>Next Meeting Date : </b><span style="word-wrap:break-word">'.$data[0]->next_meeting_date.'</th>
        </tr>
        <tr style="vertical-align: top;">
            <th width="50%" colspan="3"><b>Meeting Summary :</b>'.ucfirst($data[0]->meeting_summary).'</th>
        </tr>
     </table>';


        //$html = CabinCrewController::show(1);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream('my.pdf',array('Attachment'=>0));


        /*$downloadfolder = public_path().'/pdf_files/';

        if ( !file_exists($downloadfolder) ) {
            $oldmask = umask(0);  // helpful when used in linux server
            mkdir ($downloadfolder, 0777);
        }

        $output = $dompdf->output();
        file_put_contents($downloadfolder.'Visiting_Information_Report.pdf', $output);

        $file = $downloadfolder.'/Visiting_Information_Report.pdf';

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, 'Visiting_Information_Report.pdf', $headers);*/



    }













        public function datewise_movement_pdf($task_id, $meeting_id){

            $pageTitle = "Sales Person Movement Statement";

            $data = DB::table( 'task AS t' )
                ->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name','t.id AS task_id','m.id AS meeting_id','c.company_name')
                ->leftJoin( 'meeting AS m', 't.id', '=', 'm.task_id' )
                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
                ->where('t.id','=',$task_id)
                ->where('m.id','=',$meeting_id)
                ->get();

            $meeting_owner = Meeting::with('user')->where('id',$meeting_id)->first();

            $task = Task::with('relClientExistingProducts')->find($task_id);

            $task_client_existing_products = $task->relClientExistingProducts()->where('client_existing_product_task.status','active')->get();

            $user = User::find($task->created_by);
            $task_owner = $user->username;
//dd($task->product_id);
            $product = Product::find($task->product_id);

            $product_name = isset($product->product_name) ? $product->product_name:'';

            $html = '

    <style>
        .tbl {
            margin-bottom: 0px !important;
            border: 2px solid;
            border-bottom: 0px !important;
            width: 100%;
            font-family: Arial !important;
        }

        .tbl3 {
            margin: 0px !important;
            border: 2px solid;
            border-top: 0px!important;
            border-left: 0px!important;
            border-right: 0px!important;
            width: 100%;
        }

        .tbl2 {
           margin: 0px !important;
           border: 2px solid;
           width: 100%;
        }
        .tbl2 tr th {
            border: 2px solid;
        }

        .tbl2 th{
        text-align: left; font-weight: normal; padding: 5px; font-size:13px;
        }

        .tbl2 tr td {
            padding:7px; text-align: left;
            text-align: left !important;
            }

        .report_img{
            height: 100px!important;
            text-align: center!important;
            padding: 15px 10px 18px 10px!important;
        }

        .report_img2{
            height: 10px!important;
            text-align: left!important;
            padding: 5px 2px 8px 2px!important;
        }

        .panel, .panel-body{
            width: 100%;
        }


    </style>

        <div class="panel">
            <h3 style="text-align: center"><b>Datewise Movement</b></h3>
            <div style="text-align: right"><b>Sales Person ::'.ucfirst($data[0]->uname).'</b></div>
                <br>
                <div class="panel-body" style="border:3px solid #000000">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
                        <tr>
                            <th colspan="3" style="text-align: center;background-color: #C5E5F0;" colspan="2">Task Information</th>
                        </tr>
                        <tr style="vertical-align: top;">
                            <th colspan="3"><b>Subject: </b>'.ucfirst($data[0]->subject).'</th>
                        </tr>
                        <tr style="vertical-align: top;">
                            <th width="50%"><b>Lead Name: </b>'.ucfirst($data[0]->lead_name).'</th>
                            <th width="50%"><b>Company Name: </b>'.ucfirst($data[0]->company_name).'</th>
                            <th width="50%"><b>Start Date : </b>'.ucfirst($data[0]->start_date).'</th>
                        </tr>
                        <tr style="vertical-align: top;">
                            <th width="50%"><b>Finish Date: </b>'.ucfirst($data[0]->finish_date).'</th>
                            <th width="50%"><b>Task Owner: </b>'.ucfirst($task_owner).'</th>
                            <th width="50%"><b>Priority: </b>'.ucfirst($data[0]->priority).'</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: center;background-color: #C5E5F0;" colspan="2">Marketing Product</th>
                        </tr>
                        <tr style="vertical-align: top;">
                            <th width="50%"><b>Target Product: </b>'.ucfirst($product_name).'</th>
                            <th width="50%" colspan="2"><b>Comment: </b>'.ucfirst($data[0]->comments).'</th>

                        </tr>

                    </table>
                </div>
            </div>
        </div>';

        if(!$task_client_existing_products->isEmpty())
        {
            $html = $html.'

            <h3 style="text-align: center;">Client Existing Product</h3>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">

                <thead>
                    <tr style="background-color: #C5E5F0;">
                        <th><b> Product Name</b></th>
                        <th><b> Age</b></th>
                        <th><b> Brand</b></th>
                        <th><b> Capacity</b></th>
                        <th><b> Comments</b></th>
                    </tr>
                </thead>';

                foreach($task_client_existing_products as $values)
                {
                    if($values->pivot->status == 'active'){

                        $html = $html.'<tr>

                        <th>'.$values->pivot->product_name.'</th>
                        <th>'.$values->pivot->age.'</th>
                        <th>'.$values->pivot->brand.'</th>
                        <th>'.$values->pivot->capacity.'</th>
                        <th>'.$values->pivot->comments.'</th>
                        </tr>';

                    }
                }

            $html = $html.'</table>';
        }

         $html = $html.'

         <br>
         <h3 style="text-align: center;">Meeting Summary</h3>
         <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
            <tr style="vertical-align: top;">
                <th width="50%"><b>Marketing Product :</b>'.ucfirst($data[0]->product_name).'</th>
                <th width="50%"><b>Present Requirement Status : </b>'.ucfirst($data[0]->product_requirement_status).'</th>
                <th width="50%"><b>Next Meeting Date : </b>'.$data[0]->next_meeting_date.'</th>
            </tr>
            <tr style="vertical-align: top;">
                <th width="50%" colspan="3"><b>Meeting Summary :</b>'.ucfirst($data[0]->meeting_summary).'</th>
            </tr>
         </table>';


            //$html = CabinCrewController::show(1);

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
            $dompdf->render();

    // Output the generated PDF to Browser
            $dompdf->stream('my.pdf',array('Attachment'=>0));






        }





        public function task_detail_pdf($task_id){


            $pageTitle = "Task Detail Information";

                    //->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name')

            $data = DB::table( 'task AS t' )
            ->select( 't.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','t.id AS task_id')
            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
            ->where('t.id','=',$task_id)
            ->get();

            $meeting_details = DB::table( 'meeting AS m' )
            ->select( 'm.*','u.username AS uname','j.area_name')
            ->leftJoin( 'user as u', 'm.user_id', '=', 'u.id' )
            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
            ->where('m.task_id','=',$task_id)
            ->get();

            $task = Task::with('relClientExistingProducts')->find($task_id);

            $task_client_existing_products = $task->relClientExistingProducts()->where('client_existing_product_task.status','active')->get();

            $user = User::find($task->created_by);
            $task_owner = $user->username;

            $product = Product::find($task->product_id);

            $product_name = isset($product->product_name) ? $product->product_name:'';

            $html = '

            <style>
                .tbl {
                    margin-bottom: 0px !important;
                    border: 2px solid;
                    border-bottom: 0px !important;
                    width: 100%;
                    font-family: Arial !important;
                }

                .tbl3 {
                    margin: 0px !important;
                    border: 2px solid;
                    border-top: 0px!important;
                    border-left: 0px!important;
                    border-right: 0px!important;
                    width: 100%;
                }

                .tbl2 {
                 margin: 0px !important;
                 border: 2px solid;
                 width: 100%;
             }
             .tbl2 tr th {
                border: 2px solid;
            }

            .tbl2 th{
                text-align: left; font-weight: normal; padding: 5px; font-size:13px;
            }

            .tbl2 tr td {
                padding:7px; text-align: left;
                text-align: left !important;
            }

            .report_img{
                height: 100px!important;
                text-align: center!important;
                padding: 15px 10px 18px 10px!important;
            }

            .report_img2{
                height: 10px!important;
                text-align: left!important;
                padding: 5px 2px 8px 2px!important;
            }

            .panel, .panel-body{
                width: 100%;
            }


        </style>

        <div class="panel">
            <h3 style="text-align: center"><b>Task Details</b></h3>
            <div style="text-align: right"><b>Sales Person ::'.ucfirst($data[0]->uname).'</b></div>
            <br>
            <div class="panel-body" style="border:3px solid #000000">
                <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
                    <tr>
                        <th colspan="3" style="text-align: center;background-color: #C5E5F0;" colspan="2">Task Information</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th colspan="3"><b>Subject:</b>'.ucfirst($data[0]->subject).'</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Lead Name: </b>'.ucfirst($data[0]->lead_name).'</th>
                        <th width="50%"><b>Company Name: </b>'.ucfirst($data[0]->company_name).'</th>
                        <th width="50%"><b>Start Date : </b>'.ucfirst($data[0]->start_date).'</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Finish Date: </b>'.ucfirst($data[0]->finish_date).'</th>
                        <th width="50%"><b>Task Owner: </b>'.ucfirst($task_owner).'</th>
                        <th width="50%"><b>Priority: </b>'.ucfirst($data[0]->priority).'</th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: center;background-color: #C5E5F0;" colspan="2">Marketing Product</th>
                    </tr>
                    <tr style="vertical-align: top;">
                        <th width="50%"><b>Target Product: </b>'.ucfirst($product_name).'</th>
                        <th width="50%" colspan="2"><b>Comment: </b>'.ucfirst($data[0]->comments).'</th>

                    </tr>

                </table>
            </div>
        </div>
    </div>';

    if(!$task_client_existing_products->isEmpty())
    {
        $html = $html.'

        <h3 style="text-align: center;">Client Existing Product</h3>
        <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">

            <thead>
                <tr style="background-color: #C5E5F0;">
                    <th><b> Product Name</b></th>
                    <th><b> Age</b></th>
                    <th><b> Brand</b></th>
                    <th><b> Capacity</b></th>
                    <th><b> Comments</b></th>
                </tr>
            </thead>';

            foreach($task_client_existing_products as $values)
            {
                if($values->pivot->status == 'active'){

                    $html = $html.'<tr>

                    <th>'.$values->pivot->product_name.'</th>
                    <th>'.$values->pivot->age.'</th>
                    <th>'.$values->pivot->brand.'</th>
                    <th>'.$values->pivot->capacity.'</th>
                    <th>'.$values->pivot->comments.'</th>
                </tr>';

            }
        }

        $html = $html.'</table>';
    }

    $html = $html.'<br>
    <h3 style="text-align: center;">Meeting Informations</h3>';
    $i = 0;

    if(isset($meeting_details)){
        foreach($meeting_details as $values){
          $i++;


          $html = $html.'

          <br>
          <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
           <tr><td colspan="3" style="color: blue"><strong><font size="3">Meeting ::' . $i . '</font></strong></td></tr>
           <tr style="vertical-align: top;">
            <th width="50%"><b>Meeting Date:</b>'. ucfirst($values->meeting_date).'</th>
            <th width="50%"><b>Meeting With (concern person):</b>'.ucfirst($values->concern_person_name).'</th>
            <th width="50%"><b>Visiting Zone:</b>'.ucfirst($values->area_name).'</th>
        </tr>

        <tr style="vertical-align: top;">
            <th width="50%"><b>Reminder:</b>'. ucfirst($values->reminder).'</th>
            <th width="50%"><b>Start Time:</b>'.ucfirst($values->start_time).'</th>
            <th width="50%"><b>End Time:</b>'.ucfirst($values->end_time).'</th>
        </tr>

        <tr style="vertical-align: top;">
            <th width="50%"><b>Duration:</b>'. ucfirst($values->duration).'</th>
            <th width="50%"><b>Product Requirement Status:</b>'.ucfirst($values->product_requirement_status).'</th>
            <th width="50%"><b>Next Meeting Date:</b>'.ucfirst($values->next_meeting_date).'</th>
        </tr>
        <tr style="vertical-align: top;">
            <th width="50%"><b>Owner:<span style="color: #07709e">'. ucfirst($values->uname).'</b></th>
            <th width="50%" colspan="2"><b>Meeting Summary:</b>'.ucfirst($values->meeting_summary).'</th>

        </tr>

    </table>';
}}

            //$html = CabinCrewController::show(1);

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
$dompdf->render();

            // Output the generated PDF to Browser
$dompdf->stream('my.pdf',array('Attachment'=>0));


}














                    public function company_report(){

                        $pageTitle = "Company Wise Visiting Report";
                        $company_list =  [''=>'Select client company'] + Company::where('company_type','=','client_company')->lists('company_name','id')->all();

                        $industry_list =  [''=>'select industry type'] + Industry::where('status','active')->lists('name','id')->all();

                        $status = 1;

                        return view('reports::company_report.index', ['pageTitle'=> $pageTitle,'company_list'=>$company_list,'industry_list'=>$industry_list,'status'=>$status]);
                    }

                    public function generate_company_report(){

                        $pageTitle = "Company Wise Visiting Report";

                        $company_list =  [''=>'Select client company'] + Company::where('company_type','=','client_company')->lists('company_name','id')->all();

                        $industry_list =  [''=>'select industry type'] + Industry::where('status','active')->lists('name','id')->all();

                        $status = 2;





                        if($this->isGetRequest()){

                            $task_name = Input::get('task_name');
                            $company_name = Input::get('company_list');
                            $industry_name = Input::get('industry_list');

                            $model = DB::table( 'task AS t' )
                                ->select( 't.subject', 't.priority','l.lead_name','c.company_name','t.id AS task_id','u.username AS username','c.industry_id','i.name AS industry_name')
                                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                                ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
                                ->leftJoin( 'industry as i', 'i.id', '=', 'c.industry_id' );

                            if(isset($company_name) && !empty($company_name)){
                                $model = $model->where('c.id','=',$company_name);
                            }

                            if(isset($task_name) && !empty($task_name)){
                                $model = $model->where('t.subject','LIKE','%'.$task_name.'%');
                            }

                           if(isset($industry_name) && !empty($industry_name)){
                               $model = $model->where('industry_id', '=', $industry_name);
                           }


                            $model = $model->paginate(30);


                        }else{


                            $model = DB::table( 'task AS t' )
                                ->select( 't.subject', 't.priority','u.username','l.lead_name','c.company_name','t.id AS task_id')
                                ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                                ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                                ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' );
                            $model = $model->paginate(30);
                        }

                        return view('reports::company_report.index', ['pageTitle'=> $pageTitle,'company_list'=>$company_list,'industry_list'=>$industry_list,'model'=>$model,'status'=>$status]);
                    }

                    public function company_details($task_id){

                        $pageTitle = "Company Wise Visiting Report";

                        //->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name')

                        $model = DB::table( 'task AS t' )
                            ->select( 't.*','u.username AS uname','l.lead_name','l.mobile','l.phone','l.designation','c.company_name','p.product_name','t.id AS task_id','c.factory_address','c.ho_address','b.name as business_type_name','i.name as industry_category_name')
                            ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                            ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                            ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                            ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
                            ->leftJoin( 'industry as i', 'i.id', '=', 'c.industry_id' )
                            ->leftJoin( 'business_type as b', 'b.id', '=', 'c.business_type_id' )
                            ->where('t.id','=',$task_id)
                            ->get();

                        $meeting_details = DB::table( 'meeting AS m' )
                            ->select( 'm.*','u.username AS uname','j.area_name')
                            ->leftJoin( 'user as u', 'm.user_id', '=', 'u.id' )
                            ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                            ->where('m.task_id','=',$task_id)
                            ->get();

                        $task = Task::find($task_id);
                        $company = Company::with('clientExistingProducts')->find($task->company_id);

                        return view('reports::company_report.company_details', ['pageTitle'=> $pageTitle,'data'=>$model,'meeting_details'=>$meeting_details,'company'=>$company]);
                    }



                            public function company_details_pdf($task_id){

                                $pageTitle = "Company Wise Visiting Report";

                                        //->select( 't.*', 'm.*','u.username AS uname','l.lead_name','c.company_name','p.product_name','j.area_name')

                                $data = DB::table( 'task AS t' )
                                    ->select( 't.*','u.username AS uname','l.lead_name','l.mobile','l.phone','l.designation','c.company_name','p.product_name','t.id AS task_id','c.factory_address','c.ho_address','b.name as business_type_name','i.name as industry_category_name')
                                    ->leftJoin( 'lead as l', 'l.id', '=', 't.lead_id' )
                                    ->leftJoin( 'company as c', 'c.id', '=', 'l.company_id' )
                                    ->leftJoin( 'user as u', 't.created_by', '=', 'u.id' )
                                    ->leftJoin( 'product as p', 'p.id', '=', 't.product_id' )
                                    ->leftJoin( 'industry as i', 'i.id', '=', 'c.industry_id' )
                                    ->leftJoin( 'business_type as b', 'b.id', '=', 'c.business_type_id' )
                                    ->where('t.id','=',$task_id)
                                    ->get();

                                $meeting_details = DB::table( 'meeting AS m' )
                                    ->select( 'm.*','u.username AS uname','j.area_name')
                                    ->leftJoin( 'user as u', 'm.user_id', '=', 'u.id' )
                                    ->leftJoin( 'job_area as j', 'j.id', '=', 'm.job_area_id' )
                                    ->where('m.task_id','=',$task_id)
                                    ->get();

                                $task = Task::find($task_id);
                                $company = Company::with('clientExistingProducts')->find($task->company_id);

                                $user = User::find($task->created_by);
                                $task_owner = $user->username;

                                $product = Product::find($task->product_id);

                                $product_name = isset($product->product_name) ? $product->product_name:'';

                                $html = '

                                <style>
                                    .tbl {
                                        margin-bottom: 0px !important;
                                        border: 2px solid;
                                        border-bottom: 0px !important;
                                        width: 100%;
                                        font-family: Arial !important;
                                    }

                                    .tbl3 {
                                        margin: 0px !important;
                                        border: 2px solid;
                                        border-top: 0px!important;
                                        border-left: 0px!important;
                                        border-right: 0px!important;
                                        width: 100%;
                                    }

                                    .tbl2 {
                                     margin: 0px !important;
                                     border: 2px solid;
                                     width: 100%;
                                 }
                                 .tbl2 tr th {
                                    border: 2px solid;
                                }

                                .tbl2 th{
                                    text-align: left; font-weight: normal; padding: 5px; font-size:13px;
                                }

                                .tbl2 tr td {
                                    padding:7px; text-align: left;
                                    text-align: left !important;
                                }

                                .report_img{
                                    height: 100px!important;
                                    text-align: center!important;
                                    padding: 15px 10px 18px 10px!important;
                                }

                                .report_img2{
                                    height: 10px!important;
                                    text-align: left!important;
                                    padding: 5px 2px 8px 2px!important;
                                }

                                .panel, .panel-body{
                                    width: 100%;
                                }


                            </style>

                            <div class="panel">
                                <h3 style="text-align: center"><b>Company Wise Visiting Report</b></h3>
                                <div style="text-align: right"><b>Sales Person ::'.ucfirst($data[0]->uname).'</b></div>
                                <br>
                                <div class="panel-body" style="border:3px solid #000000">
                                    <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
                                        <tr>
                                            <th style="text-align: center;background-color: #C5E5F0;" colspan="2">Client Information</th>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th width="50%"><b>Name : </b>'.ucfirst($data[0]->lead_name).'</th>
                                            <th width="50%"><b>Company Name : </b>'.$data[0]->company_name.'</th>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th width="50%"><b>Mobile No. :</b>'.$data[0]->mobile.'</th>
                                            <th width="50%"><b>Office Phone :</b>'.$data[0]->phone.'</th>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th width="50%"><b>Designation : </b>'.ucfirst($data[0]->designation).'</th>
                                            <th width="50%"><b>Factory Address :</b>'.ucfirst($data[0]->factory_address).'</th>

                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th width="50%"><b>H/O Address : </b>'.ucfirst($data[0]->ho_address).'</th>
                                            <th width="50%"><b>Industry Category : </b>'.ucfirst($data[0]->industry_category_name).'</th>

                                        </tr>
                                        <tr style="vertical-align: top;">
                                        <th colspan="2"><b>Business Type : </b>'.ucfirst($data[0]->business_type_name).'</th>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th colspan="2" style="text-align: center;background-color: #C5E5F0;">Marketing Product</th>
                                        </tr>
                                        <tr style="vertical-align: top;">
                                            <th width="50%"><b>Target Product: </b>'.ucfirst($product_name).'</th>
                                            <th width="50%"><b>Comment: </b>'.ucfirst($data[0]->comments).'</th>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>';

                        if($company->clientExistingProducts()->lists('status')->contains('active'))
                            {
                                $html = $html.'

                                <h3 style="text-align: center;">Client Existing Product</h3>
                                <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">

                                    <thead>
                                        <tr style="background-color: #C5E5F0;">
                                            <th><b> Product Name</b></th>
                                            <th><b> Age</b></th>
                                            <th><b> Brand</b></th>
                                            <th><b> Capacity</b></th>
                                            <th><b> Comments</b></th>
                                        </tr>
                                    </thead>';

                                    foreach($company->clientExistingProducts as $values)
                                    {
                                        if($values->status == 'active'){

                                            $html = $html.'<tr>

                                            <th>'.$values->product_name.'</th>
                                            <th>'.$values->age.'</th>
                                            <th>'.$values->brand.'</th>
                                            <th>'.$values->capacity.'</th>
                                            <th>'.$values->comments.'</th>
                                        </tr>';

                                    }
                                }

                                $html = $html.'</table>';
                            }

                        if(isset($meeting_details) && ! empty($meeting_details)){

                        $html = $html.'<br>
                        <h3 style="text-align: center;">Meeting Informations</h3>';
                        $i = 0;

                        if(isset($meeting_details)){
                            foreach($meeting_details as $values){
                            if($values->status == 'active'){

                              $i++;

                              $html = $html.'

                              <br>
                              <table cellpadding="0" cellspacing="0" class="table table-bordered table-responsive no-spacing tbl2">
                               <tr><td colspan="3" style="color: blue"><strong><font size="3">Meeting ::' . $i . '</font></strong></td></tr>
                               <tr style="vertical-align: top;">
                                <th width="50%"><b>Meeting Date:</b>'. ucfirst($values->meeting_date).'</th>
                                <th width="50%"><b>Meeting With (concern person):</b>'.ucfirst($values->concern_person_name).'</th>
                                <th width="50%"><b>Visiting Zone:</b>'.ucfirst($values->area_name).'</th>
                            </tr>

                            <tr style="vertical-align: top;">
                                <th width="50%"><b>Reminder:</b>'. ucfirst($values->reminder).'</th>
                                <th width="50%"><b>Start Time:</b>'.ucfirst($values->start_time).'</th>
                                <th width="50%"><b>End Time:</b>'.ucfirst($values->end_time).'</th>
                            </tr>

                            <tr style="vertical-align: top;">
                                <th width="50%"><b>Duration:</b>'. ucfirst($values->duration).'</th>
                                <th width="50%"><b>Product Requirement Status:</b>'.ucfirst($values->product_requirement_status).'</th>
                                <th width="50%"><b>Next Meeting Date:</b>'.ucfirst($values->next_meeting_date).'</th>
                            </tr>
                            <tr style="vertical-align: top;">
                                <th width="50%"><b>Owner:<span style="color: #07709e">'. ucfirst($values->uname).'</b></th>
                                <th width="50%" colspan="2"><b>Meeting Summary:</b>'.ucfirst($values->meeting_summary).'</th>

                            </tr>

                        </table>';
                    }}}


                }

                                        //$html = CabinCrewController::show(1);

                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($html);

                                // (Optional) Setup the paper size and orientation
                    $dompdf->setPaper('A4', 'portrait');

                                // Render the HTML as PDF
                    $dompdf->render();

                                // Output the generated PDF to Browser
                    $dompdf->stream('my.pdf',array('Attachment'=>0));


                    }
















}
