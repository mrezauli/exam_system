<?php

namespace Modules\Reports\Controllers;

use Modules\Exam\Helpers\StdClass;
use Illuminate\Http\Request;
use App\Helpers\LogFileHelper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use Modules\Admin\Company;
use Modules\Admin\Designation;
use Modules\Exam\Examination;
use Dompdf\Dompdf;
use Illuminate\Pagination\LengthAwarePaginator;



class RollWiseAttendanceSheetReportController extends Controller
{


    public function attendance_sheet_report(){


        $page_title = 'Roll Wise Attendance Sheet Report';

        $status = 1;

        $header = '';

        $exam_dates_string = '';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        return view('reports::roll_wise_attendance_sheet_report.index', compact('page_title','company_list','designation_list','status','header','exam_dates_string'));


    }

 


    public function generate_attendance_sheet_report(Request $request){


        $page_title = 'Roll Wise Attendance Sheet Report';

        $status = 2;



        $exam_code = Input::get('exam_code','');
        $aptitude_exam_code = Input::get('aptitude_exam_code','');
        $company_id = Input::get('company_id');
        $designation_id = Input::get('designation_id');
        $exam_date_from = Input::get('exam_date_from');
        $exam_date_to = Input::get('exam_date_to');
        $exam_type = Input::get('exam_type');


        if(! isset($exam_type) && empty($exam_type)){

         $exam_type = isset(DB::table('exam_code')->where('exam_code_name',$exam_code)->first()->exam_type) ? DB::table('exam_code')->where('exam_code_name',$exam_code)->first()->exam_type : '';
           
        }
        


        $typing_exam_code = '';
        $aptitude_exam_code = '';
        

        if($exam_type == 'typing_test'){

            $typing_exam_code = $exam_code;

        }

        if($exam_type == 'aptitude_test'){

            $aptitude_exam_code = $exam_code;

        }




        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();




        $typing_model = DB::table( 'user AS u' )
         ->select('u.id','u.sl','u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','u.attended_aptitude_test','e.exam_type','e.company_id','e.designation_id','e.exam_date','c.company_name','c.address','d.designation_name')
         ->leftJoin( 'exam_code as e', 'e.id', '=', 'u.typing_exam_code_id')
         ->leftJoin( 'company as c', 'u.company_id', '=', 'c.id')
         ->leftJoin( 'designation as d', 'u.designation_id', '=', 'd.id')
        ->where('u.role_id',4)
        ->orderBy('u.sl');




        $aptitude_model = DB::table( 'user AS u' )
         ->select('u.id','u.sl','u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','u.attended_aptitude_test','e.exam_type','e.company_id','e.designation_id','e.exam_date','c.company_name','c.address','d.designation_name')
         ->leftJoin( 'exam_code as e', 'e.id', '=', 'u.aptitude_exam_code_id')
         ->leftJoin( 'company as c', 'u.company_id', '=', 'c.id')
         ->leftJoin( 'designation as d', 'u.designation_id', '=', 'd.id')
        ->where('u.role_id',4)
        ->orderBy('u.sl');



    if ($typing_exam_code != '' || $aptitude_exam_code != ''){
            
        $typing_model = $typing_model->where('e.exam_code_name','=',$typing_exam_code);
        $aptitude_model = $aptitude_model->where('e.exam_code_name','=',$aptitude_exam_code);
        $model_all = array_merge($typing_model->get(),$aptitude_model->get());

    }elseif($company_id !=''){
       

        if(isset($company_id) && !empty($company_id)){

            $typing_model = $typing_model->where('e.company_id','=',$company_id);
            $aptitude_model = $aptitude_model->where('e.company_id','=',$company_id);
           
        }

        if(isset($designation_id) && !empty($designation_id)){

            $typing_model = $typing_model->where('e.designation_id','=',$designation_id);
            $aptitude_model = $aptitude_model->where('e.designation_id','=',$designation_id);
            
        }
 

        if($exam_date_from == '' && $exam_date_to != ''){

            $typing_model = $typing_model->where('e.exam_date','=',$exam_date_to);
            $aptitude_model = $aptitude_model->where('e.exam_date','=',$exam_date_to);

        }


        if($exam_date_from != '' && $exam_date_to == ''){

            $typing_model = $typing_model->where('e.exam_date','=',$exam_date_from);
            $aptitude_model = $aptitude_model->where('e.exam_date','=',$exam_date_from);
          
        }


        if($exam_date_from != '' && $exam_date_to != ''){

            $typing_model = $typing_model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
            $aptitude_model = $aptitude_model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
            
        }

        if($exam_type == 'typing_test') {
           $model_all = $typing_model->get();
        }else{
           $model_all = $aptitude_model->get();
        }

    }else{
           $model_all = [];
    }



    $model_collection = collect($model_all);



    

    function presence($attendence){
      return $attendence ? 'Present' : 'Absent';
    }


    $model_collection->each(function ($values, $key) {


      if ($values->exam_type == 'typing_test') {

        $values->presence =  presence($values->attended_typing_test); 

    }


    if ($values->exam_type == 'aptitude_test') {

        $values->presence =  presence($values->attended_aptitude_test); 

    }

    });



        
        $present = $model_collection->filter(function ($value) {
            return $value->presence == "Present";
        })->sortBy(function ($values, $key) {
            return $values->sl;
        });


        $absent = $model_collection->filter(function ($value) {
            return $value->presence == "Absent";
        })->sortBy(function ($values, $key) {
            return $values->sl;
        });


        //$model_collection = $present->merge($absent);

        $model_collection = $model_collection->sortBy(function ($value, $key) {

            return (int)$value->roll_no;

        });

        $model_all = $model_collection->all();




        $exam_dates = $model_collection->groupBy('exam_date')->keys()->map(function ($values, $key) {

         return implode('-', array_reverse(explode('-', $values)));

        })->toArray();


        $exam_dates_string = implode(',',$exam_dates);



        $typing_paginated_model = $typing_model->paginate(50);

        $aptitude_paginated_model = $aptitude_model->paginate(50);



        $page = Input::get('page', 1);

        $perPage = 1000;

        $offset = ($page * $perPage) - $perPage;

        $header = $model_collection->first();


        if(! empty($model_all)){
            $model = new LengthAwarePaginator(array_slice($model_all, $offset, $perPage, true), count($model_all), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);
        }else{
            $model = [];
        }

    

        return view('reports::roll_wise_attendance_sheet_report.index', compact('page_title','status','company_id','designation_id','exam_date_from','exam_date_to','company_list','designation_list','model','model_all','header','exam_dates_string'));

    }






    
        public function attendance_sheet_report_pdf($company_id, $exam_date_from="", $designation_id, $exam_date_to=""){


      
            $model = DB::table( 'user AS u' )
                     ->select('u.id','u.sl','u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','u.attended_aptitude_test','u.company_id','u.designation_id','u.exam_date','c.company_name','c.address','d.designation_name')
                    ->where('u.role_id',4)
                    ->leftJoin( 'company as c', 'u.company_id', '=', 'c.id')
                    ->leftJoin( 'designation as d', 'u.designation_id', '=', 'd.id')
                    ->orderBy('u.sl');



            if(isset($company_id) && !empty($company_id)){

                $model = $model->where('u.company_id','=',$company_id);

            }


            if(isset($designation_id) && !empty($designation_id)){

                $model = $model->where('u.designation_id','=',$designation_id);

            }

            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('u.exam_date','=',$exam_date_to);


            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('u.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('u.exam_date', array($exam_date_from, $exam_date_to));

            }


            $model = collect($model->get());

            $exam_dates = $model->groupBy('exam_date')->keys()->toArray();

            $exam_dates_string = implode(',',$exam_dates);
            
        

            $header = $model->first();
            // dd($header);

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

    .tbl1 {
       margin-left: -20px !important;
       margin-right: -20px !important;

       border: 1px solid #333;
       width: 100%;
    }

    .tbl1 tr th,.tbl1 tr td {
        border: 1px solid #333;
        text-align: center;
        font-size: 13px;
    }

    .tbl1 thead tr th:empty{
        border-right:none !important;
        border-top:none !important;
    }   

    .tbl1 thead:first-child tr,.tbl1 thead tr th.no-border{
        border-bottom:0 !important;
    }


    .no-border span{
        display:block;
        position:absolute;
        top:18px;
        left:auto;
        right:auto;
   
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

    .tbl1 thead th{
        padding: 7px 5px;
        font-weight: 500;
        color: #000;
        text-align: center !important;     
    }

    .tbl1 tbody td{
        padding: 5px 3px;
        font-weight: 500;
        color: #000;
        text-align: center !important;    
    }

    .table-name{
        white-space: nowrap;
    }

    td.details table tr td, .dataTable tr:last-child {
        border-bottom: 1px solid #ccc !important;
        background: #e9f7ff;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #fff;
    }

    .header{
        font-size: 16px;
        text-align: center;
        max-width: 250px;
        margin: 5px auto;
    }

    .header-section{
        margin-bottom: 20px;
    }
 

    </style>';

                $html = $html.'

                <div class="header-section">
                    <p class="header">' . $header->company_name . '</p>
                    <p class="header">Designation: ' . $header->designation_name . '</p>
                    <p class="header">Exam Date: ' . $exam_dates_string . '</p>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">

                    <thead>
                    <tr>
                        <th> SL. </th>
                        <th> Roll No. </th>
                        <th> Name </th>
                        <th> Presence </th>
                    </tr>
                    </thead>

                    <tbody>';
                    
                    foreach($model as $values)
                    {

                        $presence = ($values->attended_typing_test == 'true' && $values->attended_aptitude_test == 'true') ? 'present' : 'absent';
                        


                        $html = $html . "<tr class='gradeX'>
                                                           
                                    <td>" . $values->sl . "</td>
                                    <td>" . $values->roll_no . "</td>
                                    <td class='table-name'>" . $values->username . ' ' . $values->middle_name . ' ' . $values->last_name . "</td>
                                    <td>" . $presence . "</td>
                                   
                                </tr>";
                   }


                $html = $html.'</tbody></table>';
            

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream('exam_system.pdf',array('Attachment'=>0));


        }




        public function attendance_sheet_details($bangla_exam_id,$english_exam_id){

            $page_title= '';

            $bangla_text = Examination::find($bangla_exam_id);
            $english_text = Examination::find($english_exam_id);

            $user = User::with('relCompany','relDesignation')->find($bangla_text->user_id);

            return view('reports::attendance_sheet_report.attendance_sheet_details', compact('page_title','bangla_text','english_text','user'));

        }



        public function all_graph_report($company_id, $designation_id, $exam_date){

            $page_title= '';

            
            $header = DB::table( 'qselection_attendance_sheet AS q' )
                        ->select('q.exam_date','c.company_name','c.address','d.designation_name')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id');
                        


            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.roll_no','u.started_exam','u.attended_attendance_sheet','t.id AS exam_id','t.user_id','u.company_id','u.designation_id','u.exam_date','t.exam_time','t.exam_type','t.original_text','t.answered_text')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_attendance_sheet as q', 't.qselection_typing_id', '=', 'q.id')
                    ->orderBy('u.id'); 




            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('u.company_id','=',$company_id);
                $header = $header->where('q.company_id','=',$company_id);
            }

            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('u.designation_id','=',$designation_id);
                $header = $header->where('q.designation_id','=',$designation_id);
            }

            if(isset($exam_date) && !empty($exam_date)){
                $model = $model->where('u.exam_date','=',$exam_date);
                $header = $header->where('q.exam_date','=',$exam_date);
            }

            $model = collect($model->get())->groupBy('user_id');

            unset($model['']);

            // dd($model);

            return view('reports::attendance_sheet_report.all_graph_report', compact('page_title','model','user'));

        }


















}