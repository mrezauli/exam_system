    @extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

<style>
    
form{
    padding-top: 0;
}

form .col-sm-12{
    margin-bottom: 20px;
}


form .col-sm-12:last-child{
    margin-bottom: 30px;
}

</style>

<!-- page start-->
<div class="row task-report-index report-index">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{ $page_title }}</span>
                <div class="clearfix"></div>
            </div>

          
            <div class="panel-body">

                <ul class="alert alert-danger" style="margin-left: 30px;border-radius: 5px; display: none">
                    <li class="msg"></li>
                </ul>

                {{-------------- Filter :Starts ------------------------------------------}}
                {!! Form::open(['method' =>'GET','route'=>'generate-aptitude-test-report','class'=>'report-form']) !!}
                <div class="col-sm-12">

                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('exam_code', 'Exam Code:', ['class' => 'control-label']) !!}
                        {!! Form::text('exam_code', @Input::get('exam_code')? Input::get('exam_code') : null,['id'=>'exam_code','class' => 'form-control','placeholder'=>'exam code', 'title'=>'exam code']) !!}
                    </div>
                
                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('company_id',$company_list, @Input::get('company_id')? Input::get('company_id') : null,['id'=>'company_list','class' => 'form-control js-select','placeholder'=>'select company', 'title'=>'select company','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('designation_id',$designation_list, @Input::get('designation_id')? Input::get('designation_id') : null,['id'=>'designation_list','class' => 'form-control js-select','placeholder'=>'select industry type', 'title'=>'select industry type','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_date_from', 'Exam Date From:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('exam_date_from', Input::get('exam_date_from')? Input::get('exam_date_from') : null, ['id'=>'exam_date_from', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_date_to', 'Exam Date To:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('exam_date_to', Input::get('exam_date_to')? Input::get('exam_date_to') : null, ['id'=>'exam_date_to', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>
  
                </div>


                <div class="col-sm-12">

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('bangla_speed', 'Total Pass Marks(%):', ['class' => 'control-label']) !!}
                        {{-- <small class="required">(Req.)</small> --}}
                        {!! Form::text('bangla_speed', Input::get('bangla_speed')? Input::get('bangla_speed') : null,['id'=>'bangla_speed','class' => 'form-control','placeholder'=>'pass marks %', 'title'=>'pass marks %']) !!}
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('word_pass_marks', 'Word Pass Marks(%):', ['class' => 'control-label']) !!}
                        <small class="required jprequired">(Req.)</small>
                        {!! Form::text('word_pass_marks', Input::get('word_pass_marks')? Input::get('word_pass_marks') : null,['id'=>'word_pass_marks','class' => 'form-control','placeholder'=>'pass marks %', 'title'=>'pass marks %']) !!}
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('excel_pass_marks', 'Excel Pass Marks(%):', ['class' => 'control-label']) !!}
                        <small class="required jprequired">(Req.)</small>
                        {!! Form::text('excel_pass_marks', Input::get('excel_pass_marks')? Input::get('excel_pass_marks') : null,['id'=>'excel_pass_marks','class' => 'form-control','placeholder'=>'pass marks %', 'title'=>'pass marks %']) !!}
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('ppt_pass_marks', 'PPT Pass Marks(%):', ['class' => 'control-label']) !!}
                        <small class="required jprequired">(Req.)</small>
                        {!! Form::text('ppt_pass_marks', Input::get('ppt_pass_marks')? Input::get('ppt_pass_marks') : null,['id'=>'ppt_pass_marks','class' => 'form-control','placeholder'=>'pass marks %', 'title'=>'pass marks %']) !!}
                    </div>
    
                    <div class="col-lg-2 col-md-3 col-sm-6 filter-btn">
  
                      {!! Form::submit('Generate Report', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div>

                    @if(isset($model) && ! $model->isEmpty())

                    {{-- <a href="{{ route('aptitude-test-report-pdf', [$company_id,$designation_id,$exam_date]) }}" class="pdf_report_button" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}

                    @endif

                </div>
                            
                <div class="pull-left pdf-report-button">

                    <a href="#" class="btn btn-danger print-button pdf_report_button">Print Result with Remarks</a>

                    <a href="#" class="btn btn-danger print-button-wr pdf_report_button">Print Result without Remarks</a>

                </div>

                </div>
                {!! Form::close() !!}


                
                <br><br><br>


                {{------------- Filter :Ends ------------------------------------------}}
                <div class="table-primary report-table-wrapper">


                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered report-table" id="examples_report">
                        <thead>
                        <tr>
                            <th class="no-border"> <span>SL.</span> </th>
                            <th class="no-border"> <span>Candidate SL.</span> </th>
                            <th class="no-border"> <span>Roll No.</span> </th>
                            <th class="no-border"> <span>Exam Code</span> </th>
                            <th class="no-border"> <span>Name</span> </th>

                            @if(isset($group['word']))

                            <th style="border-left: 1.7px solid #8189fd !important;border-right: 1.7px solid #8189fd !important;" colspan="{{$word_question_no}}">MS Word</th>
                            @endif


                            @if(isset($group['excel']))

                            <th style="border-right: 1.7px solid #8189fd !important;" colspan="{{$excel_question_no}}">MS Excel</th>
                            @endif


                            @if(isset($group['ppt']))

                            <th colspan="{{$ppt_question_no}}">MS PPT</th>
                            @endif
                            
            
                            <th class="no-border"> <span>Total Marks</span> </th>
                            <th class="no-border"> <span>Remarks</span> </th>
                            
                        </tr>
                       
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                            <?php $total_question_marks = 0; $j=0; $k=0; $l=0;?>

                            @if(! empty($group['word']))

                                @foreach($group['word'] as $word_question)
 
                                <?php 

                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                ->select('p.question_mark')
                                ->where( 'p.question_set_id', '=', $word_question->question_set_id)
                                ->where( 'p.qbank_aptitude_id', '=', $word_question->qbank_aptitude_id)
                                ->first();

                                $word_question_mark = $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $j++; ?>

                                <th style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;">Question {{$j}} ( {{$question_mark}} )</th>

                                @endforeach

                            @endif



                            @if(isset($group['excel']))

                                @foreach($group['excel'] as $excel_question)

                                <?php 

                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                ->select('p.question_mark')
                                ->where( 'p.question_set_id', '=', $excel_question->question_set_id)
                                ->where( 'p.qbank_aptitude_id', '=', $excel_question->qbank_aptitude_id)
                                ->first();

                                $excel_question_mark = $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $k++; ?>

                                <th style="border-right:1.7px solid #8189fd !important;">Question {{$k}} ( {{$question_mark}} )</th>

                                @endforeach

                            @endif



                            @if(isset($group['ppt']))

                                @foreach($group['ppt'] as $ppt_question)

                                <?php 

                                $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                                ->select('p.question_mark')
                                ->where( 'p.question_set_id', '=', $ppt_question->question_set_id)
                                ->where( 'p.qbank_aptitude_id', '=', $ppt_question->qbank_aptitude_id)
                                ->first();

                                $ppt_question_mark = $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

                                $total_question_marks += $question_mark;

                                $l++; ?>

                                <th style="border-right:1.7px solid #8189fd !important;">Question {{$l}} ( {{$question_mark}} )</th>

                                @endforeach

                            @endif
                        
                            <th></th>
                            <th></th>

                            
                        </tr>
                        </thead>
                        <tbody> 
                        
                        @if($status==2)

                        <?php 

                        $t =1;

                        $sl_no = isset($_GET['page']) ? ($_GET['page']-1)*2 + 0: 0;
                        
                        //$model = collect(['0' => $model->get('1')]);
                        
                        //dd($model);
                        ?>
                    
                            @foreach($model as $values)

                            <?php 

                            $sl_no++; 
 
                            // $values = collect($values);

                            $grouped_by_question_type = $values->groupBy('question_type')->sortBy('qselection_aptitude_id');

                            $exam_code_id = $values->groupBy('exam_code_id')->keys()->first();

                            $all_group = ! empty($exam_code_id) ? $header_all->groupBy('exam_code_id')->get($exam_code_id)->groupBy('question_type') : $all_group;



                            foreach ($all_group as $group_key => $value) {

                                foreach ($all_group[$group_key] as $key => $value) {

                                    //dd($all_group[$group_key]);

                                    if (isset($grouped_by_question_type[$group_key])) {

                                        $ddd = $grouped_by_question_type[$group_key]->pluck('qselection_aptitude_id')->all();

                                        //dd($ddd);

                                        if (! in_array($value->qselection_aptitude_id, $ddd)) {

                                        $grouped_by_question_type[$group_key]->push((object)(['qselection_aptitude_id'=>$value->qselection_aptitude_id,'exam_date'=>$value->exam_date,'question_marks'=>$value->question_marks,'answer_marks'=>'0']));
                                        }  
                                    }

                                }
                            }

                            //dd($grouped_by_question_type);

                            $total_answer_marks = 0;

                            $failed_in_any_exam = '';

                            $remarks = ''; 

                            $pass_percentage = $bangla_speed;    

                            unset($grouped_by_question_type['']);    



                            foreach ($grouped_by_question_type as $key => $question_group) {
                                  
                                $exam_date = $question_group->where('attended_aptitude_test','true')->first()->exam_date;

                                foreach ($question_group as $key => $value) {
                                    if ($value->exam_date != $exam_date) {
                                        unset($question_group[$key]);
                                    }
                                    
                                }

                                //dd($ddd);

                              }  

//dd($grouped_by_question_type);

// dd($grouped_by_question_type['word']->sortBy('qselection_aptitude_id'));
                            ?>

                                <tr class="gradeX">
                                                           
                                    <td>{{$sl_no}}</td>
                                    <td>{{$values[0]->sl}}</td>
                                    <td>{{$values[0]->roll_no}}</td>
                                    <td>{{$values[0]->exam_code_name}}</td>
                                    <td class="table-name">
 
                                    {{$values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name}}       
                                    </td>
                                  
                                    @if(isset($grouped_by_question_type['word']))
    
                                        @foreach($grouped_by_question_type['word']->sortBy('qselection_aptitude_id') as $data)

                                        <td style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;">{{$data->answer_marks + 0}}</td>

                                        <?php $total_answer_marks += $data->answer_marks + 0; 

                                        $pass_marks = ($data->question_marks*$pass_percentage)/100;

                                        if ($values->remarks == 'Fail') {

                                            $failed_in_any_exam = true;
                                        }

                                        ?>  

                                        @endforeach

                                    @else

                                        @for ($i = 1; $i <= $word_question_no; $i++)

                                        <td>0 <?php $failed_in_any_exam = true; ?></td>

                                        @endfor

                                    @endif


                                    @if(isset($grouped_by_question_type['excel']))

                                        @foreach($grouped_by_question_type['excel']->sortBy('qselection_aptitude_id') as $data)

                                        <td style="border-right:1.7px solid #8189fd !important;">{{$data->answer_marks + 0}}</td>

                                        <?php $total_answer_marks += $data->answer_marks + 0; 

                                        $pass_marks2 = ($data->question_marks*$pass_percentage)/100;

                                        if ($values->remarks == 'Fail') {
                                            $failed_in_any_exam = true;
                                        }

                                        ?>

                                        @endforeach

                                    @else

                                        @for ($i = 1; $i <= $excel_question_no; $i++)

                                        <td>0 <?php $failed_in_any_exam = true; ?></td>

                                        @endfor

                                    @endif


                                    @if(isset($grouped_by_question_type['ppt']))

                                        @foreach($grouped_by_question_type['ppt']->sortBy('qselection_aptitude_id') as $data)

                                        <td style="border-right:1.7px solid #8189fd !important;">{{$data->answer_marks + 0}}</td>

                                        <?php $total_answer_marks += $data->answer_marks + 0; 

                                        $pass_marks3 = ($data->question_marks*$pass_percentage)/100;

                                        if ($values->remarks == 'Fail') {
                                            $failed_in_any_exam = true;
                                        }

                                        ?>

                                        @endforeach

                                    @else

                                        @for ($i = 1; $i <= $ppt_question_no; $i++)

                                        <td>0  <?php $failed_in_any_exam = true; ?></td>

                                        @endfor

                                    @endif
                                    <td>{{$total_answer_marks}}</td>
                                    <td>


                                        <?php

                                        if(! $values->lists('attended_aptitude_test')->contains('true')){

                                            $remarks = 'Absent';

                                        }else{
 
                                            $remarks = $values->remarks;

                                        }

                                        ?>
                                        
                                    {{$remarks}}

                                   </td>
                                   
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>         
        
                    </div>
                </div>
                @if($status==2)
                    {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->render() ) !!} </span> --}}

                @endif
            </div>
        </div>
    </div>
</div>









<div class="table-primary print-report-table-wrapper">


<style>

    .print-show{
        display: none;
    }

    table thead tr th:last-child{
        border-right: 1px solid #333 !important;
    } 


    @media print{      

        *{
            text-align: center !important;
            font-size: 14px !important;
        }



        #examples * {
            border: none;
        }

        table#examples{
            border-collapse: collapse !important;
        }

        thead tr th, tbody tr td{
            border: 1px solid #333 !important;
        }

        thead tr th:empty{
            border-right:none !important;
            border-top:none !important;
        }

        thead:first-child tr, thead tr th.no-border{
            border-bottom:0 !important;
        }


        .no-border span{
            position: relative;
            top: 18px;
        }

        .print-hide{
            display: none !important;
        }

        .print-show{
            display: block !important;
        }

        .header{
            font-family: SolaimanLipi !important;
            font-size: 15px !important;
            text-align: center;
            max-width: 400px;
            margin: 5px auto;
        }

        .header-section{
            margin-bottom: 20px;
        }

        .table-primary thead tr th:empty {
            border-right: none !important;
            border-top: none !important;
        }

        .no-border span {
            position: relative;
            top: 18px;
        }

        table.report-table thead th {
            padding: 10px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }


        table thead th, table tfoot th {
            font-weight: 600 !important;
            color: #333 !important;
            padding-left: 0 !important;
        }

        footer{
            font-size: 16px !important;
        }

        table thead tr th:last-child{
            border-right: 1px solid #333 !important;
        }

        thead tr th, tbody tr td,tr th, tr td {
            border: 1px solid #333 !important;
        } 

    } 

</style>
                        

<div class="print-section print-show">
    <div class="header-section">
        <p class="header">{{ isset($header->company_name) ? $header->company_name : ''}}</p>
        <p class="header">{{ isset($header->address_one) ? $header->address_one : ''}}</p>
        <p class="header">{{ isset($header->address_two) ? $header->address_two : ''}}</p>
        <p class="header">{{ isset($header->address_three) ? $header->address_three : ''}}</p>
        <p class="header">{{ isset($header->address_four) ? $header->address_four : ''}}</p>
        <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : ''}}</p>
        <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
        <p class="header">পরীক্ষা গ্রহণে - বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
    </div>



    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr>
            <th class="no-border" rowspan="2"> SL. </th>
            <th class="no-border" rowspan="2"> Roll No. </th>
            <th class="no-border" rowspan="2"> Exam Code </th>
            <th class="no-border" rowspan="2"> Name </th>

            @if(isset($group['word']))

            <th colspan="{{$word_question_no}}">MS Word</th>
            @endif


            @if(isset($group['excel']))

            <th colspan="{{$excel_question_no}}">MS Excel</th>
            @endif


            @if(isset($group['ppt']))

            <th colspan="{{$ppt_question_no}}">MS PPT</th>
            @endif
            
            <th class="no-border" rowspan="2"> Total Marks </th>

            <th class="no-border" rowspan="2"> Remarks </th>
            
        </tr>
        
        <tr>
            
            <?php $total_question_marks = 0; $j=0; $k=0; $l=0; ?>

            @if(! empty($group['word']))

            @foreach($group['word'] as $word_question)


            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $word_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $word_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $j++; ?>

            <th>Question {{$j}} ( {{$question_mark}} )</th>

            @endforeach

            @endif



            @if(isset($group['excel']))

            @foreach($group['excel'] as $excel_question)

            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $excel_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $excel_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $k++; ?>

            <th>Question {{$k}} ( {{$question_mark}} )</th>

            @endforeach

            @endif



            @if(isset($group['ppt']))

            @foreach($group['ppt'] as $ppt_question)

            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $ppt_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $ppt_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $l++; ?>

            <th>Question {{$l}} ( {{$question_mark}} )</th>

            @endforeach

            @endif
     
        </tr>
        </thead>
        <tbody>
        
        @if($status==2)

        <?php 

        $t = 1;

       $sl_no = isset($_GET['page']) ? ($_GET['page']-1)*2 + 0: 0; 

            $total_pass = 0;
            $total_fail = 0;

            ?>

    
            @foreach($model_all as $values)


            <?php 

            $sl_no++; 

            

            // $values = collect($values);

            $grouped_by_question_type = $values->groupBy('question_type');

            $grouped_by_question_type = $values->groupBy('question_type')->sortBy('qselection_aptitude_id');

            $exam_code_id = $values->groupBy('exam_code_id')->keys()->first();

            $all_group = ! empty($exam_code_id) ? $header_all->groupBy('exam_code_id')->get($exam_code_id)->groupBy('question_type') : $all_group;



                            foreach ($all_group as $group_key => $value) {

                                foreach ($all_group[$group_key] as $key => $value) {

                                    if (isset($grouped_by_question_type[$group_key])) {

                                        $ddd = $grouped_by_question_type[$group_key]->pluck('qselection_aptitude_id')->all();

                                        if (! in_array($value->qselection_aptitude_id, $ddd)) {

                                         $grouped_by_question_type[$group_key]->push((object)(['qselection_aptitude_id'=>$value->qselection_aptitude_id,'exam_date'=>$value->exam_date,'question_marks'=>$value->question_marks,'answer_marks'=>'0']));
                                        }  
                                    }

                                }
                            }


                            unset($grouped_by_question_type['']);


                            $total_answer_marks = 0;

                            $failed_in_any_exam = '';

                            $remarks = ''; 

                            $pass_percentage = $bangla_speed;    

                            unset($grouped_by_question_type['']);    



                            foreach ($grouped_by_question_type as $key => $question_group) {
                                  
                                $exam_date = $question_group->where('attended_aptitude_test','true')->first()->exam_date;

                                foreach ($question_group as $key => $value) {
                                    if ($value->exam_date != $exam_date) {
                                        unset($question_group[$key]);
                                    }
                                    
                                }
 
                              }  
            

          
            ?>

                <tr class="gradeX">
                                           
                    <td>{{$sl_no}}</td>
                    <td>{{$values[0]->roll_no}}</td>
                    <td>{{$values[0]->exam_code_name}}</td>
                    <td class="table-name">

                    {{$values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name}}       
                    </td>

                    @if(isset($grouped_by_question_type['word']))

                        @foreach($grouped_by_question_type['word']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks4 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks4 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>

                        @endforeach

                    @else

                    <?php $failed_in_any_exam = true; ?>

                        @for ($i = 1; $i <= $word_question_no; $i++)

                        <td>0</td>

                        @endfor

                    @endif


                    @if(isset($grouped_by_question_type['excel']))

                        @foreach($grouped_by_question_type['excel']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks5 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks5 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>

                        @endforeach

                    @else

                    <?php $failed_in_any_exam = true; ?>


                        @for ($i = 1; $i <= $excel_question_no; $i++)

                        <td>0</td>

                        @endfor

                    @endif


                    @if(isset($grouped_by_question_type['ppt']))

                        @foreach($grouped_by_question_type['ppt']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks6 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks6 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>


                        @endforeach

                    @else

                    

                        @for ($i = 1; $i <= $ppt_question_no; $i++)

                        <td>0   <?php $failed_in_any_exam = true; ?></td>

                        @endfor

                    @endif

                    <td>{{$total_answer_marks}}</td>

                    <td>

                    <?php

                    if(! $values->lists('attended_aptitude_test')->contains('true')){

                        $remarks = 'Absent';

                    }else{
 
                        $remarks = $values->remarks;

                    }

                    ?>

                    {{$remarks}}

                   </td>
                   
                </tr>

            @endforeach
        @endif
        </tbody>
    </table>


    <table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Pass</th>
        <th>Fail</th>
        <th>Expel</th>
        <th>Cancel</th>
      </tr>
      <tr>
        <td>{{$passed_count}}</td>
        <td>{{$failed_count}}</td>
        <td>{{$expelled_count}}</td>
        <td>{{$cancelled_count}}</td>
      </tr>
    </table>

    </div>

    <footer class="print-show" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

</div>






<div class="table-primary print-report-table-wr-wrapper">


<style>

    .print-show{
        display: none;
    }

    table thead tr th:last-child{
        border-right: 1px solid #333 !important;
    } 


    @media print{      

        *{
            text-align: center !important;
            font-size: 14px !important;
        }



        #examples * {
            border: none;
        }

        table#examples{
            border-collapse: collapse !important;
        }

        thead tr th, tbody tr td{
            border: 1px solid #333 !important;
        }

        thead tr th:empty{
            border-right:none !important;
            border-top:none !important;
        }

        thead:first-child tr, thead tr th.no-border{
            border-bottom:0 !important;
        }


        .no-border span{
            position: relative;
            top: 18px;
        }

        .print-hide{
            display: none !important;
        }

        .print-show{
            display: block !important;
        }

        .header{
            font-family: SolaimanLipi !important;
            font-size: 15px !important;
            text-align: center;
            max-width: 400px;
            margin: 5px auto;
        }

        .header-section{
            margin-bottom: 20px;
        }

        .table-primary thead tr th:empty {
            border-right: none !important;
            border-top: none !important;
        }

        .no-border span {
            position: relative;
            top: 18px;
        }

        table.report-table thead th {
            padding: 10px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }


        table thead th, table tfoot th {
            font-weight: 600 !important;
            color: #333 !important;
            padding-left: 0 !important;
        }

        footer{
            font-size: 16px !important;
        }

        table thead tr th:last-child{
            border-right: 1px solid #333 !important;
        }

        thead tr th, tbody tr td,tr th, tr td {
            border: 1px solid #333 !important;
        } 

    } 

</style>
                        

<div class="print-section print-show">
    <div class="header-section">
        <p class="header">{{ isset($header->company_name) ? $header->company_name : ''}}</p>
        <p class="header">{{ isset($header->address_one) ? $header->address_one : ''}}</p>
        <p class="header">{{ isset($header->address_two) ? $header->address_two : ''}}</p>
        <p class="header">{{ isset($header->address_three) ? $header->address_three : ''}}</p>
        <p class="header">{{ isset($header->address_four) ? $header->address_four : ''}}</p>
        <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : ''}}</p>
        <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
        <p class="header">পরীক্ষা গ্রহণে - বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
    </div>



    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr>
            <th class="no-border" rowspan="2"> SL. </th>
            <th class="no-border" rowspan="2"> Roll No. </th>
            <th class="no-border" rowspan="2"> Exam Code </th>
            <th class="no-border" rowspan="2"> Name </th>

            @if(isset($group['word']))

            <th colspan="{{$word_question_no}}">MS Word</th>
            @endif


            @if(isset($group['excel']))

            <th colspan="{{$excel_question_no}}">MS Excel</th>
            @endif


            @if(isset($group['ppt']))

            <th colspan="{{$ppt_question_no}}">MS PPT</th>
            @endif
            
            <th class="no-border" rowspan="2"> Total Marks </th>

            <th class="no-border" rowspan="2"> Remarks </th>
            
        </tr>
        
        <tr>
           
            <?php $total_question_marks = 0; $j=0; $k=0; $l=0; ?>

            @if(! empty($group['word']))

            @foreach($group['word'] as $word_question)


            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $word_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $word_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $j++; ?>

            <th>Question {{$j}} ( {{$question_mark}} )</th>

            @endforeach

            @endif



            @if(isset($group['excel']))

            @foreach($group['excel'] as $excel_question)

            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $excel_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $excel_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $k++; ?>

            <th>Question {{$k}} ( {{$question_mark}} )</th>

            @endforeach

            @endif



            @if(isset($group['ppt']))

            @foreach($group['ppt'] as $ppt_question)

            <?php 

            $mark = DB::table( 'question_set_qbank_aptitude_test AS p' )
                    ->select('p.question_mark')
                    ->where( 'p.question_set_id', '=', $ppt_question->question_set_id)
                    ->where( 'p.qbank_aptitude_id', '=', $ppt_question->qbank_aptitude_id)
                    ->first();

            $question_mark = isset($mark->question_mark) ? $mark->question_mark : '0';    

            $total_question_marks += $question_mark;

             $l++; ?>

            <th>Question {{$l}} ( {{$question_mark}} )</th>

            @endforeach

            @endif
        
        </tr>
        </thead>
        <tbody>
        
        @if($status==2)

        <?php 

        $t = 1;

        $sl_no = isset($_GET['page']) ? ($_GET['page']-1)*2 + 0: 0; ?>

    
            @foreach($model_all as $values)


            <?php 

            $sl_no++; 

            // $values = collect($values);

            $grouped_by_question_type = $values->groupBy('question_type');

             $grouped_by_question_type = $values->groupBy('question_type')->sortBy('qselection_aptitude_id');

                            unset($grouped_by_question_type['']);

                            foreach ($all_group as $group_key => $value) {

                                foreach ($all_group[$group_key] as $key => $value) {

                                    if (isset($grouped_by_question_type[$group_key])) {

                                        $ddd = $grouped_by_question_type[$group_key]->pluck('qselection_aptitude_id')->all();

                                        if (! in_array($value->qselection_aptitude_id, $ddd)) {

                                        $grouped_by_question_type[$group_key]->push((object)(['qselection_aptitude_id'=>$value->qselection_aptitude_id,'exam_date'=>$value->exam_date,'question_marks'=>$value->question_marks,'answer_marks'=>'0']));
                                        }  
                                    }

                                }
                            }
                            

                            unset($grouped_by_question_type['']);
            
                            $total_answer_marks = 0;

                            $failed_in_any_exam = '';

                            $remarks = ''; 

                            $pass_percentage = $bangla_speed;    

                            unset($grouped_by_question_type['']);    



                            foreach ($grouped_by_question_type as $key => $question_group) {
                                  
                                $exam_date = $question_group->where('attended_aptitude_test','true')->first()->exam_date;

                                foreach ($question_group as $key => $value) {
                                    if ($value->exam_date != $exam_date) {
                                        unset($question_group[$key]);
                                    }
                                    
                                }
 
                            }
          

            ?>
                <tr class="gradeX">
                                           
                    <td>{{$sl_no}}</td>
                    <td>{{$values[0]->roll_no}}</td>
                    <td>{{$values[0]->exam_code_name}}</td>
                    <td class="table-name">

                    {{$values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name}}       
                    </td>

                    @if(isset($grouped_by_question_type['word']))

                        @foreach($grouped_by_question_type['word']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks7 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks7 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>

                        @endforeach

                    @else

                    <?php $failed_in_any_exam = true; ?>

                        @for ($i = 1; $i <= $word_question_no; $i++)

                        <td>0</td>

                        @endfor

                    @endif


                    @if(isset($grouped_by_question_type['excel']))

                        @foreach($grouped_by_question_type['excel']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks8 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks8 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>

                        @endforeach

                    @else

                    <?php $failed_in_any_exam = true; ?>


                        @for ($i = 1; $i <= $excel_question_no; $i++)

                        <td>0</td>

                        @endfor

                    @endif


                    @if(isset($grouped_by_question_type['ppt']))

                        @foreach($grouped_by_question_type['ppt']->sortBy('qselection_aptitude_id') as $data)

                        <td>{{$data->answer_marks + 0}}</td>

                        <?php $total_answer_marks += $data->answer_marks + 0; 

                        $pass_marks9 = ($data->question_marks*$pass_percentage)/100;

                        if ($pass_marks9 > $data->answer_marks) {
                            $failed_in_any_exam = true;
                        }

                        ?>


                        @endforeach

                    @else

                    

                        @for ($i = 1; $i <= $ppt_question_no; $i++)

                        <td>0  <?php $failed_in_any_exam = true; ?></td>

                        @endfor

                    @endif

                    <td>{{$total_answer_marks}}</td>

                    <td>

                    <?php

                    // if(! $values->lists('attended_aptitude_test')->contains('true')){

                    //     $remarks = 'Absent';

                    // }elseif(! $failed_in_any_exam){

                    //     $remarks = 'Pass';

                    // }else{

                    //     $remarks = 'Fail';

                    // }

                    ?>

                   </td>
                   
                </tr>

            @endforeach
        @endif
        </tbody>
    </table>
    
    </div>

    <footer class="print-show" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

</div>



















<!-- page end-->

<!--script for this page only-->


<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>
<script>

 
function report_exam_code(){

    var exam_code = $('#exam_code').val();

    var fields = '#company_list,#designation_list,#exam_date_from,#exam_date_to';

    if (exam_code != '') {

        $(fields).prop('disabled', true).val('').trigger('change').attr('required', false);

        $('.jrequired').hide();

    }else{

        $(fields).prop('disabled', false).attr('required', true);

        $('.jrequired').show();

    }

}



function report_pass_marks(){

    var bangla_speed = $('#bangla_speed').val();

    var fields = '#word_pass_marks,#excel_pass_marks,#ppt_pass_marks';

    if (bangla_speed != '') {

        $(fields).prop('disabled', true).val('').trigger('change').attr('required', false);

        $('.jprequired').hide();

    }else{

        $(fields).prop('disabled', false).attr('required', true);

        $('.jprequired').show();

    }

}



    report_exam_code();

    $('#exam_code').keyup(function(e) {
    
        report_exam_code();

    });

    $('#exam_code').bind('input',function(e) {
    
        report_exam_code();

    });



    report_pass_marks();

    $('#bangla_speed').keyup(function(e) {
    
        report_pass_marks();

    });

    $('#bangla_speed').bind('input',function(e) {
    
        report_pass_marks();

    });

    // $('select, #exam_date').not('#exam_code_list, #exam_type').prop('disabled', true);
                        
    $('form').on('submit', function(e) {
        $('select, #exam_date').prop('disabled', false);
    });


    // $('#button').click(function(e){
    //     var company_id = $('#company_id').val();
    //     var designation_id = $('#designation_id').val();
    //     var exam_date_from = $('#exam_date_from').val();
    //     var exam_date_to = $('#exam_date_to').val();

    //     if(company_id.length <= 0 || designation_id.length <= 0 || exam_date_from.length <= 0 || exam_date_to.length <= 0 ){
    //         $('.alert-danger').show();
    //         $('.msg').html('Please fill out all input field!');
    //     }else{
    //         $('.report-form').submit();
    //     }

    // })

    $('.print-button').click(function(event) {

    w=window.open();
    w.document.write(document.getElementsByClassName('print-report-table-wrapper')[0].outerHTML);
    w.print();
    w.close();

    });

    $('.print-button-wr').click(function(event) {

        w=window.open();
        w.document.write(document.getElementsByClassName('print-report-table-wr-wrapper')[0].outerHTML);
        w.print();
        w.close();

    });

</script>
@stop




@section('custom-script')
<script>
    
var table = $('#examples_report').DataTable( {
  "language": {
    "search": "Search Roll No:"
  },
  "aaSorting": [],
  "pageLength": 50,
} );


$('#examples_report_filter input').on('keyup', function(){

   table
   .column(1)
   .search(this.value)
   .draw();

 });

</script>
@stop