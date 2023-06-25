<?php

namespace Modules\Reports\Controllers;

use Session;
use App\User;
use Validator;
use Dompdf\Dompdf;
use App\Http\Requests;
use Modules\Admin\Company;
use Modules\Admin\ExamCode;
use Modules\Admin\ExamTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Modules\Exam\Examination;
use App\Helpers\LogFileHelper;
use Modules\Admin\Designation;
use Illuminate\Support\Facades\DB;
use Modules\Exam\Helpers\StdClass;
use App\Jobs\NewLineCountRemoveJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;



class TypingTestReportController extends Controller
{


    public function typing_test_report(){

        $page_title = 'Typing Test Report';
        //$bangla_speed = $english_speed = ExamTime::where('exam_type','typing_exam')->first()->exam_time;
        $bangla_speed = $english_speed = $passed_count = $failed_count = $expelled_count = $cancelled_count = $total_count = '';


        
        $status = 1;

        $header = $passed_count = $failed_count = '';

        $exam_dates_string = '';

        $model_all = collect([]);

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();

        return view('reports::typing_test_report.index', compact('page_title','company_list','designation_list','exam_code_list','status','header','exam_dates_string','model_all','bangla_speed','english_speed','passed_count','failed_count','expelled_count','cancelled_count','total_count'));


    }

 


    public function generate_typing_test_report(Request $request){

        $job = new NewLineCountRemoveJob();
        dispatch($job);

        $page_title = 'Typing Test Report';

        $status = 2;


        $exam_code = Input::get('exam_code','');
        $company_id = Input::get('company_id');
        $designation_id = Input::get('designation_id');
        $exam_date_from = Input::get('exam_date_from');
        $exam_date_to = Input::get('exam_date_to');
        $bangla_speed = Input::get('bangla_speed');
        $english_speed = Input::get('english_speed');
        $spmDigit = Input::get('spmDigit');
        if (empty($company_id)) {
            $companyIdArray = DB::table('exam_code')->select('company_id', 'designation_id', 'exam_date')->where('exam_code_name', Input::get('exam_code'))->get();
            foreach ($companyIdArray as $key => $value) {
                $company_id = $value->company_id;
                $designation_id = $value->designation_id;
                $exam_date_from = $value->exam_date;
                $exam_date_to = $value->exam_date;
            }
            //dd($exam_date_to);
        }
        
        

        $validator = Validator::make($request->all(), [
            'bangla_speed' => 'required|integer',
            'english_speed' => 'required|integer',
        ]);


        if ($validator->fails()) {

            Session::flash('danger', "The bangla speed and english speed field must be an integer.");
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }



        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        $exam_code_list =  [''=>'Select exam code'] + ExamCode::where('exam_type','typing_test')->where('status','active')->orderBy('id','desc')->lists('exam_code_name','id')->all();



        $header = DB::table( 'qselection_typing_test AS q' )
                    ->select('e.exam_date','c.company_name','c.address_one','c.address_two','c.address_three','c.address_four','d.designation_name')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->leftJoin( 'company as c', 'e.company_id', '=', 'c.id')
                    ->leftJoin( 'designation as d', 'e.designation_id', '=', 'd.id');



        $model = DB::table( 'user AS u' )
         ->select('u.id','u.sl','u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','t.id AS exam_id','u.id as user_id','u.typing_status','e.company_id','e.designation_id','e.exam_code_name','e.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.accuracy')
         ->leftJoin( 'exam_code as e', 'e.id', '=', 'u.typing_exam_code_id')         
        ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
        ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
        ->orderBy('u.id');


        if ($exam_code != ''){

            $model = $model->where('e.exam_code_name','=',$exam_code);
            $header = $header->where('e.exam_code_name','=',$exam_code);
            
        }else{

            if(isset($company_id) && !empty($company_id)){

                $model = $model->where('e.company_id','=',$company_id);
            }


            if(isset($designation_id) && !empty($designation_id)){

                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);

            }

            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }

        }

        
        $model_collection = collect($model->get());

        $exam_dates = $model_collection->groupBy('exam_date')->keys()->map(function ($values, $key) {

            return implode('-', array_reverse(explode('-', $values)));

        })->toArray();


        $exam_dates_string = implode(',',$exam_dates);


        $header = $header->first();
                         
        $model = collect($model->get())->groupBy('user_id');



        if (isset($model[''])) {

            foreach ($model[''] as $value) {

               $array = [$value];

               $model->push($array);
           }

       }
        

        unset($model['']);




        function round_to_integer($number){
           
           if (is_integer($number)) {

               return $number;

           }
            
           $parts = explode(".",$number);
        
           if (isset($parts[1]) && (int)$parts[1] >= 5) {

               return $parts[0] + 1;

           }else{

               return $number;

           }

        }


        
        $ddd = [];
        
        $model->each(function ($values, $key)use($bangla_speed,$english_speed,&$ddd) {
           
        
            $values = collect($values);
            $null_object = StdClass::fromArray();
            
           

            $grouped_by_exam_type = $values->groupBy('exam_type');
            
            $bangla = $grouped_by_exam_type->get('bangla',[$null_object])[0];

            $english = $grouped_by_exam_type->get('english',[$null_object])[0];
            

            $bangla_time = isset($bangla->exam_time) && $bangla->exam_time > 10 ? $bangla->exam_time - 1: 1;

            $english_time = isset($english->exam_time) && $bangla->exam_time > 10 ? $english->exam_time - 1: 1;


            $bangla_exam_time = $bangla_speed;

            //$english_exam_time = isset($english->exam_time) ? $english->exam_time: 1;
            $english_exam_time = $english_speed;

            $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;

            $bangla_wpm = round($bangla_corrected_words/$bangla_time,1);

            $bangla_wpm = round_to_integer($bangla_wpm);            

            $english_corrected_words = $english->typed_words - $english->inserted_words;

            $english_wpm = round($english_corrected_words/$english_time,1);

            $english_wpm = round_to_integer($english_wpm);            

            $values->total_typing_speed = $bangla_wpm + $english_wpm;

            $values->roll_no = isset($values->first()->roll_no) ? $values->first()->roll_no : '';

            // dd($values);

            if(! $values->lists('attended_typing_test')->contains('true')){

                $values->R = 'Absent';

            }elseif($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed){

                $values->R = 'Pass';

            }else{

                $values->R = 'Fail';
                
            }

            $ddd[$key] = $values;

            
        });   


        $model = collect($ddd);



        $makeComparer = function($criteria) {

          $comparer = function ($first, $second) use ($criteria) {

            foreach ($criteria as $key => $orderType) {
                
        // normalize sort direction

              $orderType = strtolower($orderType);

            if ( (int) $first->{$key} < (int) $second->{$key}) {

                return $orderType === "asc" ? -1 : 1;

            } else if ( (int) $first->{$key} > (int) $second->{$key}) {

                return $orderType === "asc" ? 1 : -1;

            }
        }

        // all elements were equal
        return 0;

        };

        return $comparer;

        };


        $passed = $model->filter(function ($value) {
            
            return $value->R == "Pass";
        });


        $failed = $model->filter(function ($value) {
            return $value->R == "Fail";
        });


        $absent = $model->filter(function ($value) {
            return $value->R == "Absent";
        });


        $expelled = $model->filter(function ($value) {
            return $value['0']->typing_status == "expelled";
        });


        $cancelled = $model->filter(function ($value) {
            return $value['0']->typing_status == "cancelled";
        });

    
        $passed_count = $model->filter(function ($value) {

            if ($value->R == "Fail" && in_array($value['0']->typing_status, ['expelled','cancelled'])) {

                return false;

            }else if ($value->R == "Pass" && in_array($value['0']->typing_status, ['expelled','cancelled'])) {

                return false;

            }else{

                return $value->R == "Pass";
            }
        

        })->count();



        $failed_count = $model->filter(function ($value) {

            if ($value->R == "Fail" && in_array($value['0']->typing_status, ['expelled','cancelled'])) {

                return false;

            }else if ($value->R == "Pass" && in_array($value['0']->typing_status, ['expelled','cancelled'])) {

                return false;

            }else{

                return $value->R == "Fail";
            }
        

        })->count();


        $expelled_count = $expelled->count();

        $cancelled_count = $cancelled->count();

        $total_count = $passed_count + $failed_count + $expelled_count + $cancelled_count;

        //$total_count = $passed_count + $failed_count  + $cancelled_count;

        $criteria = ["total_typing_speed" => "desc", "roll_no" => "asc"];

        $comparer = $makeComparer($criteria);
        $passed = $passed->sort($comparer);

        $comparer = $makeComparer($criteria);
        $failed = $failed->sort($comparer);

        $comparer = $makeComparer($criteria);
        $absent = $absent->sort($comparer);


        $model = $passed->merge($failed);

        $model_all = $model;

        
        // dd($model);
        
        $page = Input::get('page', 1);


        $perPage = 1000; 
        $offset = ($page * $perPage) - $perPage;


        $model = new LengthAwarePaginator(array_slice($model->toArray(), $offset, $perPage, true), count($model->toArray()), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);


        return view('reports::typing_test_report.index', compact('spmDigit', 'page_title','status','company_id','designation_id','exam_code','exam_date','exam_time','company_list','designation_list','exam_code_list','model','model_all','bangla_speed','english_speed','exam_date_from','exam_date_to','header','exam_dates_string','passed_count','failed_count','expelled_count','cancelled_count','total_count'));

    }

        public function typing_test_report_pdf($company_id, $designation_id, $exam_date_from, $exam_date_to, $bangla_speed, $english_speed, $spmDigit){


            $header = DB::table( 'qselection_typing_test AS q' )
                        ->select('q.exam_date','c.company_name','c.address_one','c.address_two','c.address_three','c.address_four','d.designation_name')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id')
                        ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id');

                        

            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','u.typing_status', 't.id AS exam_id','t.user_id','u.company_id','u.designation_id','u.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.accuracy')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->orderBy('u.id'); 




            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('e.company_id','=',$company_id);
                $header = $header->where('e.company_id','=',$company_id);
            }


            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);
            }


            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }


            $model = collect($model->get())->groupBy('user_id');

            
            if (isset($model[''])) {

                foreach ($model[''] as $value) {

                    $array = [$value];

                    $model->push($array);
                }

            }

            unset($model['']);

            $header = $header->first();


            $html = '
            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://sonnetdp.github.io/nikosh/css/nikosh.css" rel="stylesheet" type="text/css">
    <title>Result with Remarks</title>

    <style>

    th span{    
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        line-height: 100vh;
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
        font-size: 13px;
        text-align: center;
        max-width: 250px;
        margin: 5px auto;
    }

    .header-section{
        margin-bottom: 20px;
    }

    .center-table {
        margin-left: auto;
        margin-right: auto;
      }
 

    </style>
    </head>
    <body>';

                $html = $html.'

                <div class="header-section">
                    <p class="header">' . $header->company_name . '</p>
                    <p class="header">' . $header->address_one . '</p>
                    <p class="header">' . $header->address_two . '</p>
                    <p class="header">' . $header->address_three . '</p>
                    <p class="header">' . $header->address_four . '</p>
                    <p class="header">Designation: ' . $header->designation_name . '</p>
                    <p class="header">Exam Date: ' . $header->exam_date . '</p>
                    <p class="header">Exam Taker: Bangladesh Computer Council (BCC)</p>
                </div>
                <div style="text-align: center;">
                    <table cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table tbl1 center-table" id="examples">
                        <thead>
                            <tr>
                                <th colspan="8">Abbreviations</th>
                            </tr>
                            <tr>
                                <th>CWS</th>
                                <th>TW</th>
                                <th>WW</th>
                                <th>CW</th>
                                <th>SPM</th>
                                <th>T</th>
                                <th>M</th>
                                <th>AM</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr class="gradeX">  
                                    <td class="table-name">Characters (with space)</td>
                                    <td class="table-name">Total Words</td>
                                    <td class="table-name">Wrong Words</td>
                                    <td class="table-name">Correct Words</td>
                                    <td class="table-name">Speed Per Mintues</td>
                                    <td class="table-name">Tolerance (5%)</td>
                                    <td class="table-name">Marks</td>
                                    <td class="table-name">Average Marks</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            <br/>
            <br/>
            <div style="text-align: center;">
                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">

                    <thead>
                    <tr>
                    <th class="no-border"> <span>SL</span> </th>
                    <th class="no-border"> <span>Roll No</span> </th>
                    <th class="no-border"> <span>Name</span> </th>
                    <th colspan="7" style="border-right: 1.7px solid #8189fd !important">Bangla in '.$spmDigit.' minutes</th>
                    <th colspan="7">English in '.$spmDigit.' minutes</th>
                    <th rowspan="2" class="no-border"> <span>AM</span> </th>
                    <th rowspan="2" class="no-border"> <span>Remarks</span> </th>
                </tr>
               
        
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>CWS</th>
                    <th>TW</th>
                    <th>WW</th>
                    <th>CW</th>
                    <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                    <th>T</th>
                    <th>M</th>
        
                    <th>CWS</th>
                    <th>TW</th>
                    <th>WW</th>
                    <th>CW</th>
                    <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                    <th>T</th>
                    <th>M</th>
                </tr>
                    </thead>

                    <tbody>';
                    $i = 0;
                    $passed = 0;
                    $failed = 0;
                    $expelled = 0;
                    $cancelled = 0;
                    $total = 0;
                    foreach($model as $values)
                    {
                        $i++; 

                        $values = collect($values);
                        
                        $grouped_by_exam_type = $values->groupBy('exam_type');
                
                        $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0]:StdClass::fromArray();
                        $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0]:StdClass::fromArray();

                        $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                        $bangla_typed_words = round($bangla_typed_characters/5);
                        $bangla_deleted_words = isset($bangla->deleted_words) ? round($bangla->deleted_words/5) : 0;
                        $bangla_corrected_words = isset($bangla->inserted_words) ? round($bangla->inserted_words/5) : 0;
                        $bangla_wpm = round($bangla_corrected_words/$spmDigit);
                        $bangla_tolerance = $bangla->typed_words == 0 ? 0 : round(($bangla_deleted_words / $bangla_typed_words ) * 100);
                        $bangla_round_marks = round((20/25)* $bangla_wpm);
                        $bangla_marks = $bangla_round_marks > 50 ? 50 : $bangla_round_marks;

                        $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                        $english_typed_words = round($english_typed_characters/5);
                        $english_deleted_words = isset($english->deleted_words) ? round($english->deleted_words/5) : 0;
                        $english_corrected_words = isset($english->inserted_words) ? round($english->inserted_words/5) : 0;
                        $english_wpm = round($english_corrected_words/$spmDigit);
                        $english_tolerance = $english->typed_words == 0 ? 0 : round(($english_deleted_words / $english_typed_words ) * 100);
                        $english_round_marks = round((20/25)* $english_wpm);
                        $english_marks = $english_round_marks > 50 ? 50 : $english_round_marks;
    
                        $average = round(($bangla_marks + $english_marks) / 2);                      
                        $total++;
                        if(! $values->lists('attended_typing_test')->contains('true')){
                            $remark = 'Absent';
                        }elseif($values->lists('typing_status')->contains('cancelled')) {
                            $remark = 'Cancelled'; $cancelled++;
                        }elseif($values->lists('typing_status')->contains('expelled')) {
                            $remark = 'Expelled'; $expelled++;
                        }elseif($bangla_wpm >= $bangla_speed && $bangla_tolerance <= 5 && $english_wpm >= $english_speed && $english_tolerance <= 5 && $average >= 25){
                            $remark = 'Pass'; $passed++;
                        }else{
                            $remark = 'Fail'; $failed++;
                        }                        

                        $html = $html . "
                        <tr class='gradeX'>
                                                   
                            <td>" . $i . "</td>
                            <td>" . $values[0]->roll_no . "</td>
                            <td class='table-name'>" . $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name . "</td>
                            <td>" . $bangla_typed_characters . "</td>
                            <td>" . $bangla_typed_words . "</td>
                            <td>" . $bangla_deleted_words . "</td>
                            <td>" . $bangla_corrected_words . "</td>
                            <td>" . $bangla_wpm . "</td>
                            <td>" . $bangla_tolerance . "</td>
                            <td>" . $bangla_marks . "</td>

                            <td>" . $english_typed_characters . "</td>
                            <td>" . $english_typed_words . "</td>
                            <td>" . $english_deleted_words . "</td>
                            <td>" . $english_corrected_words . "</td>
                            <td>" . $english_wpm . "</td>
                            <td>" . $english_tolerance . "</td>
                            <td>" . $english_marks . "</td>
                            <td>" . $average . "</td>
                            <td style='text-align: left !important;'>" . $remark . "</td>                           
                        </tr>";
                   }


                $html = $html.'</tbody></table>
                </div>
                <div style="text-align: center;">
                <table style="margin-top:20px;width:30%;" id="examples"  cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">
                    <tr>
                        <th>Pass</th>
                        <th>Fail</th>
                        <th>Expel</th>
                        <th>Cancel</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td>'.$passed.'</td>
                        <td>'.$failed.'</td>
                        <td>'.$expelled.'</td>
                        <td>'.$cancelled.'</td>
                        <td>'.$total.'</td>
                    </tr>
                </table>
                </div>
                    <footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>
                    </body>
                    </html>
                ';
            

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'potrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream($header->company_name . $header->designation_name . $header->exam_date .'.pdf',array('Attachment'=>0));


        }

        public function typing_test_report_pdf_without_remarks($company_id, $designation_id, $exam_date_from, $exam_date_to, $bangla_speed, $english_speed, $spmDigit){


            $header = DB::table( 'qselection_typing_test AS q' )
                        ->select('q.exam_date','c.company_name','c.address_one','c.address_two','c.address_three','c.address_four','d.designation_name')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id')
                        ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id');

                        

            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.username','u.middle_name','u.last_name','u.started_exam','u.attended_typing_test','u.typing_status', 't.id AS exam_id','t.user_id','u.company_id','u.designation_id','u.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.accuracy')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->orderBy('u.id'); 




            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('e.company_id','=',$company_id);
                $header = $header->where('e.company_id','=',$company_id);
            }


            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);
            }


            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }


            $model = collect($model->get())->groupBy('user_id');

            
            if (isset($model[''])) {

                foreach ($model[''] as $value) {

                    $array = [$value];

                    $model->push($array);
                }

            }

            unset($model['']);

            $header = $header->first();


            $html = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="http://sonnetdp.github.io/nikosh/css/nikosh.css" rel="stylesheet" type="text/css">
                <title>Result with Without Remarks</title>
    <style>

    th span{
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        line-height: 100vh;
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
        font-size: 13px;
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
                    <p class="header">' . $header->address_one . '</p>
                    <p class="header">' . $header->address_two . '</p>
                    <p class="header">' . $header->address_three . '</p>
                    <p class="header">' . $header->address_four . '</p>
                    <p class="header">Designation: ' . $header->designation_name . '</p>
                    <p class="header">Exam Date: ' . $header->exam_date . '</p>
                    <p class="header">Exam Taker: Bangladesh Computer Council (BCC)</p>
                </div>
                <table cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table tbl1" id="examples">
                <thead>
                    <tr>
                        <th colspan="8">Abbreviations</th>
                    </tr>
                    <tr>
                        <th class="no-border">CWS</th>
                        <th class="no-border">TW</th>
                        <th class="no-border">WW</th>
                        <th class="no-border">CW</th>
                        <th class="no-border">SPM</th>
                        <th class="no-border">T</th>
                        <th class="no-border">M</th>
                        <th class="no-border">AM</th>
                    </tr>
                </thead>
                <tbody>
                        <tr class="gradeX">  
                            <td class="table-name">Characters (with space)</td>
                            <td class="table-name">Total Words</td>
                            <td class="table-name">Wrong Words</td>
                            <td class="table-name">Correct Words</td>
                            <td class="table-name">Speed Per Mintues</td>
                            <td class="table-name">Tolerance (5%)</td>
                            <td class="table-name">Marks</td>
                            <td class="table-name">Average Marks</td>
                        </tr>
                </tbody>
            </table>
            <br/>
            <br/>
                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">

                    <thead>
                    <tr>
                    <th class="no-border"> <span>SL</span> </th>
                    <th class="no-border"> <span>Roll No</span> </th>
                    <th class="no-border"> <span>Name</span> </th>
                    <th colspan="7" style="border-right: 1.7px solid #8189fd !important">Bangla in '.$spmDigit.' minutes</th>
                    <th colspan="7">English in '.$spmDigit.' minutes</th>
                    <th rowspan="2" class="no-border"> <span>AM</span> </th>
                    <th rowspan="2" class="no-border"> <span>Remarks</span> </th>
                </tr>
               
        
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>CWS</th>
                    <th>TW</th>
                    <th>WW</th>
                    <th>CW</th>
                    <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                    <th>T</th>
                    <th>M</th>
        
                    <th>CWS</th>
                    <th>TW</th>
                    <th>WW</th>
                    <th>CW</th>
                    <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                    <th>T</th>
                    <th>M</th>
                </tr>
                    </thead>

                    <tbody>';
                    $i = 0;
                    $passed = 0;
                    $failed = 0;
                    $expelled = 0;
                    $cancelled = 0;
                    $total = 0;
                    foreach($model as $values)
                    {
                        $i++; 

                        $values = collect($values);
                        
                        $grouped_by_exam_type = $values->groupBy('exam_type');
                
                        $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0]:StdClass::fromArray();
                        $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0]:StdClass::fromArray();

                        $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                        $bangla_typed_words = round($bangla_typed_characters/5);
                        $bangla_deleted_words = isset($bangla->deleted_words) ? round($bangla->deleted_words/5) : 0;
                        $bangla_corrected_words = isset($bangla->inserted_words) ? round($bangla->inserted_words/5) : 0;
                        $bangla_wpm = round($bangla_corrected_words/$spmDigit);
                        $bangla_tolerance = $bangla->typed_words == 0 ? 0 : round(($bangla_deleted_words / $bangla_typed_words ) * 100);
                        $bangla_round_marks = round((20/25)* $bangla_wpm);
                        $bangla_marks = $bangla_round_marks > 50 ? 50 : $bangla_round_marks;

                        $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                        $english_typed_words = round($english_typed_characters/5);
                        $english_deleted_words = isset($english->deleted_words) ? round($english->deleted_words/5) : 0;
                        $english_corrected_words = isset($english->inserted_words) ? round($english->inserted_words/5) : 0;
                        $english_wpm = round($english_corrected_words/$spmDigit);
                        $english_tolerance = $english->typed_words == 0 ? 0 : round(($english_deleted_words / $english_typed_words ) * 100);
                        $english_round_marks = round((20/25)* $english_wpm);
                        $english_marks = $english_round_marks > 50 ? 50 : $english_round_marks;
    
                        $average = round(($bangla_marks + $english_marks) / 2);                      
                        $total++;                        

                        $html = $html . "
                        <tr class='gradeX'>
                                                   
                            <td>" . $i . "</td>
                            <td>" . $values[0]->roll_no . "</td>
                            <td class='table-name'>" . $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name . "</td>
                            <td>" . $bangla_typed_characters . "</td>
                            <td>" . $bangla_typed_words . "</td>
                            <td>" . $bangla_deleted_words . "</td>
                            <td>" . $bangla_corrected_words . "</td>
                            <td>" . $bangla_wpm . "</td>
                            <td>" . $bangla_tolerance . "</td>
                            <td>" . $bangla_marks . "</td>

                            <td>" . $english_typed_characters . "</td>
                            <td>" . $english_typed_words . "</td>
                            <td>" . $english_deleted_words . "</td>
                            <td>" . $english_corrected_words . "</td>
                            <td>" . $english_wpm . "</td>
                            <td>" . $english_tolerance . "</td>
                            <td>" . $english_marks . "</td>
                            <td>" . $average . "</td>                        
                            <td> </td>                        
                        </tr>";
                   }


                $html = $html.'</tbody></table>
                    <footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>
                ';
            

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'potrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream($header->company_name . $header->designation_name . $header->exam_date .'.pdf',array('Attachment'=>0));


        }




        public function typing_test_details($bangla_exam_id ,$english_exam_id){

            $page_title= 'Typing Test Information';

            $bangla = Examination::findOrNew($bangla_exam_id);
            $english = Examination::findOrNew($english_exam_id);

            // dd($bangla);

            $user_id = empty($bangla->user_id) ? $english->user_id : $bangla->user_id; 


            $user = User::with('relCompany','relDesignation')->find($user_id);


            return view('reports::typing_test_report.typing_test_details', compact('page_title','bangla','english','user'));

        }

        public function edit_typing_test_details($id){


            // $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name
            $data = User::with('typing_test_result','typing_exam_code')->where('id',$id)->first(); 



            $name = trim($data->username . ' ' . $data->middle_name . ' ' . $data->last_name);

            $exam_code = $data->typing_exam_code->exam_code_name;

            $roll_no = $data->roll_no;



            $bangla = $data->typing_test_result()->where('exam_type','bangla')->first();
            $english = $data->typing_test_result()->where('exam_type','english')->first();

                                // dd($bangla);

                                // $bangla_exam_id = $bangla->exam_id;

                                // $bangla_typed_words = $bangla->typed_words;

                                // $bangla_wrong_words = $bangla->inserted_words;

                                // $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;


                                // $english_typed_words = $english->typed_words;

                                // $english_wrong_words = $english->inserted_words;

                                // $english_corrected_words = $english->typed_words - $english->inserted_words;

                                // $data = collect(['bangla_typed_words'=>$bangla_typed_words,'id'=>'3','bangla_exam_id'=>$bangla_exam_id]);




            // $user_id = empty($bangla_text->user_id) ? $english_text->user_id : $bangla_text->user_id; 


            // $user = User::with('relCompany','relDesignation')->find($user_id);

                                // dd($dataz);
           return view('reports::typing_test_report.edit_typing_test_details', compact('data','bangla','english','name','exam_code','roll_no'));

        }

        public function update_typing_test_details(Requests\ExamRequest $request, $id){


            $bangla = collect($request->only('bangla_total_words','bangla_typed_words','bangla_corrected_words'));

            $english = collect($request->only('english_total_words','english_typed_words','english_corrected_words'));

            // dd($bangla);


            $bangla_input = $bangla->keys()->map(function ($item, $key) {
            
               return str_replace("bangla_","",$item);
               
           })->all();

            

            $bangla_input = array_combine($bangla_input,$bangla->all());    

            $bangla_data['typed_words'] = $bangla_input['typed_words'];

            $bangla_data['inserted_words'] = $bangla_input['typed_words'] - $bangla_input['corrected_words'];

            




            $english_input = $english->keys()->map(function ($item, $key) {
            
               return str_replace("english_","",$item);
               
           })->all();



            
            $english_input = array_combine($english_input,$english->all());    

            $english_data['typed_words'] = $english_input['typed_words'];

            $english_data['inserted_words'] = $english_input['typed_words'] - $english_input['corrected_words'];
            


            $bangla_exam_id = $request->only('bangla_exam_id');

            $english_exam_id = $request->only('english_exam_id');

           

            $bangla_model = Examination::where('id',$bangla_exam_id)->first();

            $english_model = Examination::where('id',$english_exam_id)->first();

            // $input = $request->all();
            // dd($model);
            /*$company_group_id= $request->get('company_group_id');
            $company_group = CompanyGroup::find($company_group_id);
            $company_group_name = $company_group->group_name;
            $input['company_group_name'] = $company_group_name;*/



            // $company_name = Input::get('company_name');
            // $company_name_upper_case = ucwords($company_name);
            // $input['company_name'] = $company_name_upper_case;

            DB::beginTransaction();
            try {
                $bangla_model->update($bangla_data);
                $english_model->update($english_data);
                DB::commit();
                Session::flash('message', "Successfully Updated");
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                //Session::flash('danger', $e->getMessage());
                Session::flash('danger', "Couldn't Update Successfully. Please Try Again.");
            }
            return redirect()->back();

            return redirect()->back();

            return view('reports::typing_test_report.update_typing_test_details', compact($id));

        }

        public function typing_test_manual_checking_details($bangla_exam_id, $english_exam_id){

            $page_title= 'Typing Test Information';

            $bangla = Examination::findOrNew($bangla_exam_id);
            $english = Examination::findOrNew($english_exam_id);

            $user_id = empty($bangla->user_id) ? $english->user_id : $bangla->user_id; 
            

            $user = User::with('relCompany','relDesignation')->find($user_id);


            return view('reports::typing_test_report.typing_test_manual_checking_details', compact('page_title','bangla','english','user'));

        }



        public function all_graph_report(){

            $page_title= 'All Graph Report';

            
            $exam_code = Input::get('exam_code');
            $company_id = Input::get('company_id');
            $designation_id = Input::get('designation_id');
            $exam_date_from = Input::get('exam_date_from');
            $exam_date_to = Input::get('exam_date_to');
            $bangla_speed = Input::get('bangla_speed');
            $english_speed = Input::get('english_speed');



            $header = DB::table( 'qselection_typing_test AS q' )
                        ->select('e.exam_date','c.company_name','c.address_one','c.address_two','c.address_three','c.address_four','d.designation_name')
                        ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id');
                        


            $model = DB::table( 'user AS u' )
                     ->select('u.roll_no','u.roll_no','u.started_exam','u.attended_typing_test','t.id AS exam_id','t.user_id','e.company_id','e.designation_id','e.exam_date','t.exam_time','t.exam_type','t.total_words','t.typed_words','t.deleted_words','t.inserted_words','t.original_text','t.answered_text')
                    ->leftJoin( 'typing_exam_result as t', 't.user_id', '=', 'u.id' )
                    ->leftJoin( 'qselection_typing_test as q', 't.qselection_typing_id', '=', 'q.id')
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->orderBy('u.roll_no'); 


        if ($exam_code != ''){

            $model = $model->where('e.exam_code_name','=',$exam_code);
            $header = $header->where('e.exam_code_name','=',$exam_code);

        }else{

            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('e.company_id','=',$company_id);
                $header = $header->where('e.company_id','=',$company_id);
            }

            if(isset($designation_id) && !empty($designation_id)){
                $model = $model->where('e.designation_id','=',$designation_id);
                $header = $header->where('e.designation_id','=',$designation_id);
            }

            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('e.exam_date','=',$exam_date_to);
                $header = $header->where('e.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('e.exam_date','=',$exam_date_from);
                $header = $header->where('e.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            }

        }

            $model = collect($model->get())->groupBy('user_id');

            unset($model['']);

            $model->each(function ($values, $key)use($bangla_speed,$english_speed) {

                // $values = collect($values);
                $null_object = StdClass::fromArray();
                

                $grouped_by_exam_type = $values->groupBy('exam_type');
                
                $bangla = $grouped_by_exam_type->get('bangla',[$null_object])[0];

                $english = $grouped_by_exam_type->get('english',[$null_object])[0];
                

                
                $exam_time = isset($bangla->exam_time) ? $bangla->exam_time: 1;
                $bangla_exam_time = $bangla_speed;

                //$english_exam_time = isset($english->exam_time) ? $english->exam_time: 1;
                $english_exam_time = $english_speed;

                $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;


                // dd($bangla_exam_time);

                $bangla_wpm = round($bangla_corrected_words/$exam_time,3);

                $english_corrected_words = $english->typed_words - $english->inserted_words;

                $english_wpm = round($english_corrected_words/$exam_time,3);

                $values->total_typing_speed = $bangla_wpm + $english_wpm;

                $values->roll_no = isset($values->first()->roll_no) ? $values->first()->roll_no : '';



                if(! $values->lists('attended_typing_test')->contains('true')){

                    $values->R = 'Absent';

                }elseif($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed){

                    $values->R = 'Pass';

                }else{

                    $values->R = 'Fail';
                    
                }

                // dd($values);

            });   


            $passed = $model->filter(function ($value) {
                return $value->R == "Pass";
            });


            $failed = $model->filter(function ($value) {
                return $value->R == "Fail";
            });


            $absent = $model->filter(function ($value) {
                return $value->R == "Absent";
            });





        $makeComparer = function($criteria) {

        $comparer = function ($first, $second) use ($criteria) {

            foreach ($criteria as $key => $orderType) {
                
        // normalize sort direction

              $orderType = strtolower($orderType);

            if ( (int) $first->{$key} < (int) $second->{$key}) {

                return $orderType === "asc" ? -1 : 1;

            } else if ( (int) $first->{$key} > (int) $second->{$key}) {

                return $orderType === "asc" ? 1 : -1;

            }
        }

        // all elements were equal
        return 0;

        };

        return $comparer;

        };




            $criteria = ["total_typing_speed" => "desc", "roll_no" => "asc"];
            $comparer = $makeComparer($criteria);
            $passed = $passed->sort($comparer);

            $comparer = $makeComparer($criteria);
            $failed = $failed->sort($comparer);

            $comparer = $makeComparer($criteria);
            $absent = $absent->sort($comparer);


        
            // $model = $passed->merge($failed);
            'C:\laragon\www\exam_system\modules\exam\Views\typing_exam\bnTypingExam.blade.php';
            'C:\laragon\www\exam_system\modules\exam\Views\typing_exam\bnTypingExamPreview.blade.php';
            'C:\laragon\www\exam_system\modules\exam\Views\typing_exam\enTypingExam.blade.php';
            'C:\laragon\www\exam_system\modules\exam\Views\typing_exam\enTypingExamPreview.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\typing_test_report\typing_test_details.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\aptitude_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\attendance_sheet_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\examination_summary_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\roll_wise_attendance_sheet_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\roll_wise_short_typing_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\roll_wise_typing_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\short_aptitude_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\short_typing_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Views\typing_test_report\index.blade.php';
            'C:\laragon\www\exam_system\modules\reports\Controllers\TypingTestReportController.php';
            

            return view('reports::typing_test_report.all_graph_report', compact('page_title','model','user'));

        }

}