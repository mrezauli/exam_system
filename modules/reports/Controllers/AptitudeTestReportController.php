<?php

namespace Modules\Reports\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Helpers\LogFileHelper;
use App\Http\Requests;
use Session;
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


class AptitudeTestReportController extends Controller
{


    public function aptitude_test_report(){


        $page_title = 'Aptitude Test Report';

        $status = 1;

        $header = $passed_count = $failed_count = $expelled_count = $cancelled_count = $total_pass = $total_fail = $bangla_speed = '';

        $exam_dates_string = '';

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();

        return view('reports::aptitude_test_report.index', compact('page_title','company_list','designation_list','status','header','exam_dates_string','passed_count','failed_count','expelled_count','cancelled_count','total_pass','total_fail','bangla_speed'));


    }



    public function generate_aptitude_test_report(Request $request){


        $page_title = 'Aptitude Test Report';

        $status = 2;


        $exam_code = Input::get('exam_code');
        $company_id = Input::get('company_id');
        $designation_id = Input::get('designation_id');
        $exam_date_from = Input::get('exam_date_from');
        $exam_date_to = Input::get('exam_date_to');
        $bangla_speed = Input::get('bangla_speed');
        $word_pass_marks = Input::get('word_pass_marks');
        $excel_pass_marks = Input::get('excel_pass_marks');
        $ppt_pass_marks = Input::get('ppt_pass_marks');


        $validator = Validator::make($request->all(), [
            'bangla_speed' => 'integer',
        ]);
// dd($bangla_speed);


        if ($validator->fails()) {

            Session::flash('danger', "Pass Marks must be an integer.");
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $company_list =  [''=>'Select organization'] + Company::where('status','active')->orderBy('id','desc')->lists('company_name','id')->all();

        $designation_list =  [''=>'Select designation'] + Designation::where('status','active')->orderBy('id','desc')->lists('designation_name','id')->all();


        $header = DB::table( 'qselection_aptitude_test AS q' )
                    ->select('q.id as qselection_aptitude_id','e.company_id','e.designation_id','e.exam_date','q.question_type','q.shift','qa.question_mark','q.exam_code_id','q.question_set_id','q.qbank_aptitude_id','c.company_name','c.address','d.designation_name')
                    ->join('question_set_qbank_aptitude_test as qa', function ($join) {
                    $join->on('qa.qbank_aptitude_id', '=', 'q.qbank_aptitude_id')->on('qa.question_set_id', '=', 'q.question_set_id');    
                    })
                    ->leftJoin( 'exam_code as e', 'e.id', '=', 'q.exam_code_id')
                    ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                    ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id');

        // dd($header->get());


        $model = DB::table( 'user AS u' )
        ->select('u.sl','u.roll_no','u.username','u.middle_name','u.last_name','u.id as user_id','e.company_id','e.designation_id','e.exam_date','e.exam_code_name','e.id as exam_code_id','u.attended_typing_test','u.attended_aptitude_test','u.aptitude_status','q.id as qselection_aptitude_id','q.question_type','a.answer_marks','q.question_set_id','q.qbank_aptitude_id')
                ->leftJoin( 'exam_code as e', 'e.id', '=', 'u.aptitude_exam_code_id')
                ->leftJoin( 'aptitude_exam_result as a', 'a.user_id', '=', 'u.id')
                ->leftJoin( 'qselection_aptitude_test as q', 'a.qselection_aptitude_id', '=', 'q.id')
                ->orderBy('u.sl');    



    if ($exam_code != ''){

        $model = $model->where('e.exam_code_name','=',$exam_code);
        $header = $header_all = $header->where('e.exam_code_name','=',$exam_code);

    }else{

        if(isset($company_id) && !empty($company_id)){
            $model = $model->where('e.company_id','=',$company_id);
            $header = $header_all = $header->where('e.company_id','=',$company_id);
        }


        if(isset($designation_id) && !empty($designation_id)){
            $model = $model->where('e.designation_id','=',$designation_id);
            $header = $header_all = $header->where('e.designation_id','=',$designation_id);
        }

        if(isset($exam_date) && !empty($exam_date)){
            $model = $model->where('e.exam_date','=',$exam_date);
            $header = $header_all = $header->where('e.exam_date','=',$exam_date);
        }

        if($exam_date_from == '' && $exam_date_to != ''){

            $model = $model->where('e.exam_date','=',$exam_date_to);
            $header = $header_all = $header->where('e.exam_date','=',$exam_date_to);
        }

        if($exam_date_from != '' && $exam_date_to == ''){

            $model = $model->where('e.exam_date','=',$exam_date_from);
            $header = $header_all = $header->where('e.exam_date','=',$exam_date_from);

        }

        if($exam_date_from != '' && $exam_date_to != ''){

            $model = $model->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));

            $std = clone $header;

            $header_all = $std->whereBetween('e.exam_date', array($exam_date_from, $exam_date_to));


            $exam_dates = collect($header_all->get())->sortBy('exam_date')->groupBy('exam_date')->keys();

            $exam_date_from = isset($exam_dates['0']) ? $exam_dates['0'] : '';

            $header = $header->whereBetween('e.exam_date', array($exam_date_from, $exam_date_from));

        }

    }


    $question_marks = DB::table( 'question_set_qbank_aptitude_test' )->get();

    $question_marks = collect($question_marks);

    $model_collection = collect($model->get());




        $model = $model_collection->map(function ($values, $key)use($question_marks) {

             $question_mark = $question_marks->where('question_set_id',$values->question_set_id)->where('qbank_aptitude_id',$values->qbank_aptitude_id)->first();

             if (! empty($question_mark)) {

                 $values->question_marks = $question_mark->question_mark;

             }else{

                $values->question_marks = 0;

             }

              return $values;
        
        });


    
        $eee = clone $header;

        $ddd = collect($eee->get());

        $ddt = clone $header_all;


        
        $ddd = $ddd->isEmpty() ? collect($ddt->groupBy('exam_date')->get()) : $ddd;

         // dd($header->get());





        $header = $ddd->map(function ($values, $key) {

          if (! empty($values->question_mark)) {

             $values->question_marks = $values->question_mark;

         }else{

            $values->question_marks = 0;

        }

        return $values;

        });


        $group = ! $header->isEmpty() ? collect($header)->groupBy('shift')->first()->groupBy('question_type')->sortBy('qselection_aptitude_id') : collect($header_all)->groupBy('shift')->first()->groupBy('question_type')->sortBy('qselection_aptitude_id');



        $eee = clone $header_all;

        $ttt = collect($eee->get());

        $header_all = $ttt->map(function ($values, $key) {

          if (! empty($values->question_mark)) {

             $values->question_marks = $values->question_mark;

         }else{

            $values->question_marks = 0;

        }

        return $values;

        });


        $all_group = ! $header_all->isEmpty() ? collect($header_all)->groupBy('shift')->first()->groupBy('question_type')->sortBy('qselection_aptitude_id') : '';

        //dd($all_group);



        $exam_dates = $model_collection->groupBy('exam_date')->keys()->map(function ($values, $key) {

            return implode('-', array_reverse(explode('-', $values)));

        })->toArray();


        $exam_dates_string = implode(',',$exam_dates);

        


        
  
        // $all_headers = clone $header->get();


        //  $group = $group->map(function ($values, $key) {

        //     foreach ($values as $key => $value) {
        //         dd($values);
        //     }

        //     return $values->groupBy('exam_date');

        // });



        $header = $header->first();

        $model = $model->groupBy('user_id');
         
        
        //dd($header);



        if (isset($model[''])) {

            foreach ($model[''] as $value) {

               $array = [$value];

               $model->push($array);
           }
        }

        unset($model['']);



        $total_question_marks = 0;

        collect($model->first())->each(function ($item, $key)use(&$total_question_marks) {

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
            ->select('p.question_mark')
            ->where( 'p.question_set_id', '=', $item->question_set_id)
            ->where( 'p.qbank_aptitude_id', '=', $item->qbank_aptitude_id)
            ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

        });



        // dd($model);

        // $model->each(function ($values, $key)use(&$total_question_marks) {

        //     $remarks = '';
        //     $total_answer_marks = 0;


        //     $values->total_answer_marks = $total_answer_marks = $values->sum('answer_marks');


        //     if(! $values->lists('attended_aptitude_test')->contains('true')){

        //         $values->remarks = 'Absent';

        //     }elseif($total_answer_marks >= $total_question_marks*50/100){

        //         $values->remarks = 'Pass';

        //     }else{

        //         $values->remarks = 'Fail';
                
        //     }

        // });
        // $eee = $ddd->pluck('qselection_aptitude_id')->all();


// dd($eee);


        // dd($model);        

        foreach ($model as $key => $user) {

           $eee = $user->pluck('qselection_aptitude_id')->all();

           $exam_code_id = $user->groupBy('exam_code_id')->keys()->first();

           $exam_code_id = empty($exam_code_id) ? $header_all->groupBy('exam_code_id')->keys()->first() : $exam_code_id;

           $ggg = $ttt->groupBy('exam_code_id')->get($exam_code_id);

          


            foreach ($ggg as $group_key => $group_value) {

                if (! in_array($group_value->qselection_aptitude_id, $eee)) {

                    if ($user[0]->exam_date == $group_value->exam_date) {

                        $model[$key]->push((object)(['qselection_aptitude_id'=>$group_value->qselection_aptitude_id,'exam_code_id'=>$group_value->exam_code_id,'question_marks'=>$group_value->question_marks,'answer_marks'=>'0','absent'=>'1']));

                    }else {

                        //$model[$key]->push((object)(['qselection_aptitude_id'=>$group_value->qselection_aptitude_id,'question_marks'=>$group_value->question_marks,'answer_marks'=>'0','absent'=>'0']));

                    }

                }  
            }

        }
 

        

        $model->each(function ($values, $key)use($bangla_speed,$word_pass_marks,$excel_pass_marks,$ppt_pass_marks,$exam_dates) {

            $remarks = '';

            $failed_in_any_exam = false;

            $values->total_answer_marks = $total_answer_marks = $values->sum('answer_marks');

            $values->total_question_marks = $total_question_marks = $values->groupBy('exam_code_id')->first()->sum('question_marks');


            $values->roll_no = isset($values->first()->roll_no) ? $values->first()->roll_no : '';

            $values->each(function ($data, $key)use(&$failed_in_any_exam,$bangla_speed,$total_question_marks,$total_answer_marks,$word_pass_marks,$excel_pass_marks,$ppt_pass_marks) {


                if ($bangla_speed) {
      
                    if ( $total_question_marks*$bangla_speed/100 > $total_answer_marks) {
                        $failed_in_any_exam = true;
                    }

                }elseif(isset($data->question_type)){

                    if ($data->question_type == 'word' && $data->question_marks*$word_pass_marks/100 > $data->answer_marks) {
                        
                        $failed_in_any_exam = true;

                    } elseif($data->question_type == 'excel' && $data->question_marks*$excel_pass_marks/100 > $data->answer_marks) {
                      
                        $failed_in_any_exam = true;

                    }elseif($data->question_type == 'ppt' && $data->question_marks*$ppt_pass_marks/100 > $data->answer_marks){

                        $failed_in_any_exam = true;

                    }

                    if ($failed_in_any_exam == true && $data->answer_marks > 2) {
                        //dd($data->question_type == 'word' && $data->question_marks*$word_pass_marks/100 > $data->answer_marks);
                    }

                }elseif(isset($data->absent) && $data->absent == '1'){

                    $failed_in_any_exam = true;

                }else{

                    //$failed_in_any_exam = true;
                }

            });



            if(! $values->lists('attended_aptitude_test')->contains('true')){

                $values->remarks = 'Absent';

            }else{

                if(! $failed_in_any_exam){

                    $values->remarks = 'Pass';

                }else{

                    $values->remarks = 'Fail';

                }

                if($values->lists('aptitude_status')->contains('expelled')){

                $values->remarks = 'Expelled';

                }

                if($values->lists('aptitude_status')->contains('cancelled')){

                $values->remarks = 'Cancelled';

            }

            }

        });


// dd($model); 


        $makeComparer = function($criteria) {
          $comparer = function ($first, $second) use ($criteria) {
            foreach ($criteria as $key => $orderType) {
            // normalize sort direction

              $orderType = strtolower($orderType);

              if ($first->{$key} < $second->{$key}) {
                return $orderType === "asc" ? -1 : 1;
            } else if ($first->{$key} > $second->{$key}) {
                return $orderType === "asc" ? 1 : -1;
            }
        }
        // all elements were equal
        return 0;
        };
        return $comparer;
        };


        $passed = $model->filter(function ($value) {
            return $value->remarks == "Pass";
        });

        $failed = $model->filter(function ($value) {
            return $value->remarks == "Fail";
        });

        $absent = $model->filter(function ($value) {
            return $value->remarks == "Absent";
        });

        $expelled = $model->filter(function ($value) {
            return $value->remarks == "Expelled";
        });

        $cancelled = $model->filter(function ($value) {
            return $value->remarks == "Cancelled";
        });


        $criteria = ["total_answer_marks" => "desc", "roll_no" => "asc"];

        $comparer = $makeComparer($criteria);
        $passed = $passed->sort($comparer);

        $comparer = $makeComparer($criteria);
        $failed = $failed->sort($comparer);

        $comparer = $makeComparer($criteria);
        $absent = $absent->sort($comparer);

        $comparer = $makeComparer($criteria);
        $expelled = $expelled->sort($comparer);

        $comparer = $makeComparer($criteria);
        $cancelled = $cancelled->sort($comparer);



        $model = $passed->merge($failed)->merge($expelled)->merge($cancelled);

        $model_all = $model;



        $passed_count = $model->filter(function ($value) {

            if ($value->remarks == "Fail" && in_array($value['0']->aptitude_status, ['expelled','cancelled'])) {

                return false;

            }else{

                return $value->remarks == "Pass";
            }
        

        })->count();



        $failed_count = $model->filter(function ($value) {

            if ($value->remarks == "Fail" && in_array($value['0']->aptitude_status, ['expelled','cancelled'])) {

                return false;

            }else{

                return $value->remarks == "Fail";
            }

        })->count();


        $expelled_count = $expelled->count();

        $cancelled_count = $cancelled->count();



        $word_question_no = isset($group['word']) ? $group['word']->count() : 0;

        $excel_question_no = isset($group['excel']) ? $group['excel']->count() : 0;

        $ppt_question_no = isset($group['ppt']) ? $group['ppt']->count() : 0;

        $page = Input::get('page', 1);

        // dd($group);

        $perPage = 50;

        $offset = ($page * $perPage) - $perPage;




       // $model = new LengthAwarePaginator(array_slice($model->toArray(), $offset, $perPage, true), count($model->toArray()), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);


        return view('reports::aptitude_test_report.index', compact('page_title','status','company_id','designation_id','exam_date','company_list','designation_list','model','group','word_question_no','excel_question_no','ppt_question_no','model_all','header','all_group','exam_date_from','exam_date_to','exam_dates_string','question_marks','passed_count','failed_count','expelled_count','cancelled_count','bangla_speed','word_pass_marks','excel_pass_marks','ppt_pass_marks','header_all'));


    }







    
        public function aptitude_test_report_pdf($company_id, $designation_id, $exam_date_from, $exam_date_to){


            $header = DB::table( 'qselection_aptitude_test AS q' )
                        ->select('q.exam_date','c.company_name','c.address','d.designation_name')
                        ->leftJoin( 'company as c', 'q.company_id', '=', 'c.id')
                        ->leftJoin( 'designation as d', 'q.designation_id', '=', 'd.id');
                        

            $model = DB::table( 'user AS u' )
                    ->select('u.roll_no','u.username','u.middle_name','u.last_name','a.user_id','u.company_id','u.designation_id','u.exam_date','q.question_type','a.answer_marks','q.question_set_id','q.qbank_aptitude_id')
                    ->leftJoin( 'aptitude_exam_result as a', 'a.user_id', '=', 'u.id')
                    ->leftJoin( 'qselection_aptitude_test as q', 'a.qselection_aptitude_id', '=', 'q.id')
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


            if($exam_date_from == '' && $exam_date_to != ''){

                $model = $model->where('u.exam_date','=',$exam_date_to);
                $header = $header->where('q.exam_date','=',$exam_date_to);

            }

            if($exam_date_from != '' && $exam_date_to == ''){

                $model = $model->where('u.exam_date','=',$exam_date_from);
                $header = $header->where('q.exam_date','=',$exam_date_from);

            }

            if($exam_date_from != '' && $exam_date_to != ''){

                $model = $model->whereBetween('u.exam_date', array($exam_date_from, $exam_date_to));
                $header = $header->whereBetween('q.exam_date', array($exam_date_from, $exam_date_to));

            }


            $model = collect($model->get())->groupBy('user_id');


            if (isset($model[''])) {

                foreach ($model[''] as $value) {

                $array = [$value];

                $model->push($array);

                }

            }

             unset($model['']);

             $group = collect($model->first())->groupBy('question_type');


             $word_question_no = isset($group['word']) ? $group['word']->count() : 0;

             $excel_question_no = isset($group['excel']) ? $group['excel']->count() : 0;

             $ppt_question_no = isset($group['ppt']) ? $group['ppt']->count() : 0;


             $header = $header->first();


             $html = '

             <style>

             th span{
                 word-wrap:break-word !important;    
                 font-family: Arial, Helvetica, sans-serif;
             }

             tr th span{

             display:inline-block !important;
             margin-top:1px !important;
             margin-left:15px !important;

             }

             .table-name-header span{
             margin-left: 43% !important;
             

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
                 font-size:14px;
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
                 padding: 10px 5px;
                 font-weight: 500;
                 color: #000;
                 text-align: center !important;     
             }

             .tbl1 tbody td{
                 padding: 7px 3px;
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



                $html = $html . '

                <div class="header-section">
                    <p class="header">' . $header->company_name . '</p>
                    <p class="header">' . $header->address . '</p>
                    <p class="header">Designation: ' . $header->designation_name . '</p>
                    <p class="header">Exam Date: ' . $header->exam_date . '</p>
                </div>
                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-responsive no-spacing tbl1">


                    <thead>
                    <tr>
                        <th class="no-border"> <div>SL.</div> </th>
                        <th class="no-border"> <div>Roll No.</div> </th>
                        <th class="no-border table-name-header"> <div>Name</div> </th>';


                        if(isset($group['word'])){

                            $html = $html . '<th colspan="' . $word_question_no . '">MS Word</th>';

                        }


                        if(isset($group['excel'])){

                            $html = $html . '<th colspan="' . $excel_question_no . '">MS Excel</th>';

                        }


                        if(isset($group['ppt'])){

                            $html = $html . '<th colspan="' . $ppt_question_no . '">MS PPT</th>';
                            
                        }

                        
                        $html = $html . '<th class="no-border"> <div>Remarks</div> </th>
                        
                    </tr>
                    </thead>

                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>';

                        $total_question_marks = 0; $j=0; $k=0; $l=0; 

                        $j=0; $k=0; $l=0;

                        if(isset($group['word'])){

                            foreach($group['word'] as $word_question){


                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                        ->select('p.question_mark')
                                        ->where( 'p.question_set_id', '=', $word_question->question_set_id)
                                        ->where( 'p.qbank_aptitude_id', '=', $word_question->qbank_aptitude_id)
                                        ->first();

                                $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $j++;

                                $html = $html . '<th>Question' . ' ' . $j . ' ' . '(' . $question_mark . ')' . '</th>';

                            }

                        }

        
                        if(isset($group['excel'])){

                            foreach($group['excel'] as $excel_question){


                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                        ->select('p.question_mark')
                                        ->where( 'p.question_set_id', '=', $excel_question->question_set_id)
                                        ->where( 'p.qbank_aptitude_id', '=', $excel_question->qbank_aptitude_id)
                                        ->first();

                                $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $k++;

                                $html = $html . '<th>Question' . ' ' . $k . ' ' . '(' . $question_mark . ')' . '</th>';

                            }
                        }


                        if(isset($group['ppt'])){

                            foreach($group['ppt'] as $ppt_question){


                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                        ->select('p.question_mark')
                                        ->where( 'p.question_set_id', '=', $ppt_question->question_set_id)
                                        ->where( 'p.qbank_aptitude_id', '=', $ppt_question->qbank_aptitude_id)
                                        ->first();

                                $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $l++;

                                $html = $html . '<th>Question' . ' ' . $l . ' ' . '(' . $question_mark . ')' . '</th>';

                            }

                        }
                        
                        
                        $html = $html . '<th></th></tr></thead><tbody>';

                        $sl_no = 0;
                          
                        foreach($model as $values){

                            $sl_no++; 

                            $values = collect($values);

                            $grouped_by_question_type = $values->groupBy('question_type');

                            $html = $html . '<tr class="gradeX">

                            <td>' . $sl_no . '</td>
                            <td>' . $values[0]->roll_no . '</td>
                            <td class="table-name">';

                                $html = $html . $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name;

                                $html = $html . '</td>';

                                if(isset($grouped_by_question_type['word'])){

                                    foreach($grouped_by_question_type['word'] as $values){

                                        $html = $html . '<td>' . ($values->answer_marks + 0) . '</td>';

                                    }

                                }else{

                                    for ($i = 1; $i <= $word_question_no; $i++){

                                        $html = $html . '<td>0</td>';

                                    }

                                }


                                if(isset($grouped_by_question_type['excel'])){

                                    foreach($grouped_by_question_type['excel'] as $values){

                                        $html = $html . '<td>' . ($values->answer_marks + 0) . '</td>';

                                    }

                                }else{

                                    for ($i = 1; $i <= $excel_question_no; $i++){

                                        $html = $html . '<td>0</td>';

                                    }

                                }


                                if(isset($grouped_by_question_type['ppt'])){

                                    foreach($grouped_by_question_type['ppt'] as $values){

                                        $html = $html . '<td>' . ($values->answer_marks + 0) . '</td>';

                                    }

                                }else{

                                    for ($i = 1; $i <= $ppt_question_no; $i++){

                                        $html = $html . '<td>0</td>';

                                    }

                                }


                                $html = $html .  '<td>';
                                

                                if(! (isset($grouped_by_question_type['word']) || isset($grouped_by_question_type['excel']) || isset($grouped_by_question_type['ppt'])) ){

                                    $html = $html . 'Absent';

                                }else{

                                    $html = $html . 'Pass';
                                    
                                }

                                $html = $html . '</td></tr>';

                            }



                $html = $html.'</tbody></table>';
            

                //$html = CabinCrewController::show(1);

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream('exam_system.pdf',array('Attachment'=>0));





        }




    public function aptitude_test_details($bangla_exam_id,$english_exam_id){


        $page_title= '';


        $bangla_text = Examination::find($bangla_exam_id);
        $english_text = Examination::find($english_exam_id);


        return view('reports::aptitude_test_report.aptitude_test_details', compact('page_title','bangla_text','english_text'));

        

}


















}