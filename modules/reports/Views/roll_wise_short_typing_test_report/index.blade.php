@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

<?php use Modules\Exam\Helpers\StdClass; ?>

<!-- page start-->

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
                {!! Form::open(['method' =>'GET','route'=>'generate-roll-wise-short-typing-test-report','class'=>'report-form']) !!}
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
                      {!! Form::label('exam_date_from', 'Exam Date From:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Req.)</small>
                      {!! Form::text('exam_date_from', Input::get('exam_date_from')? Input::get('exam_date_from') : null, ['id'=>'exam_date_from', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_date_to', 'Exam Date To:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Req.)</small>
                      {!! Form::text('exam_date_to', Input::get('exam_date_to')? Input::get('exam_date_to') : null, ['id'=>'exam_date_to', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>


                    </div>

                <div class="col-sm-12">
    
                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('designation_id',$designation_list, @Input::get('designation_id')? Input::get('designation_id') : null,['id'=>'designation_list','class' => 'form-control js-select','placeholder'=>'select industry type', 'title'=>'select industry type','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('bangla_speed', 'Bangla Speed:', ['class' => 'control-label']) !!}
                        <small class="required">(Req.)</small>
                        {!! Form::text('bangla_speed', Input::get('bangla_speed')? Input::get('bangla_speed') : null,['id'=>'bangla_speed','class' => 'form-control','placeholder'=>'bangla speed', 'title'=>'bangla speed','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6">
                        {!! Form::label('english_speed', 'English Speed:', ['class' => 'control-label']) !!}
                        <small class="required">(Req.)</small>
                        {!! Form::text('english_speed', Input::get('english_speed')? Input::get('english_speed') : null,['english_speed'=>'english_speed','class' => 'form-control','placeholder'=>'english speed', 'title'=>'english speed','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('remarks', 'Remarks:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('remarks',['passed'=>'Pass','failed'=>'Fail','expelled'=>'Expelled','cancelled'=>'Cancelled','all'=>'All'], @Input::get('remarks')? Input::get('remarks') : null,['id'=>'remarks','class' => 'form-control remarks','placeholder'=>'select industry type', 'title'=>'select industry type','required'=>'required']) !!}
                    </div>

                    <div class="col-lg-1 col-md-3 col-sm-6 filter-btn">

                      {!! Form::submit('Generate Result', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'submit-button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div>

                </div>
                {!! Form::close() !!}
  
                @if(isset($model) && ! $model->isEmpty())
                <div class="col-lg-12 col-md-3 col-sm-6 all-graph-pdf-report-block">

                {{-- <a href="{{ route('typing-test-report-pdf', [$company_id,$designation_id,$exam_date_from,$exam_date_to,$bangla_speed,$english_speed]) }}" class="pdf_report_button pull-right" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}

                <?php  

                $ddd = URL('/') . '/reports/roll-wise-all-short-graph-report' . '?exam_code=' . $exam_code . '&company_id=' . $company_id . '&designation_id=' . $designation_id . '&exam_date_from='. $exam_date_from . '&exam_date_to=' . $exam_date_to . '&bangla_speed=' . $bangla_speed . '&english_speed=' . $english_speed . '&remarks=' . $remarks; ?>

                <div class="btn btn-primary btn-sm pull-right"><a target="_blank" style="color:white" href="{{ $ddd }}">View All Answer Scripts</a></div>

                <a href="#" class="btn btn-danger print-button pull-right">Print Result with Remarks</a>

                <a href="#" class="btn btn-danger print-button-wr pull-right">Print Result without Remarks</a>  


                </div>
                @endif

                <p><br><br><br></p>
                <br><br><br>

                <?php

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

                ?>


                {{------------- Filter :Ends ------------------------------------------}}
                <div class="table-primary report-table-wrapper">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered report-table" id="examples_report">
                        <thead>
                        <tr>
                            <th> <span>SL.</span> </th>
                            <th> <span>Candidate SL.</span> </th>
                            <th> <span>Roll No.</span> </th>
                            <th> <span>Exam Code</span> </th>
                            <th> <span>Name</span> </th>
                            <th style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;""> <span>Remarks</span> </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if($status==2)
                        <?php $i = isset($_GET['page']) ? ($_GET['page']-1)*1 + 0: 0; ?>

                            @foreach($model as $values)

                            <?php $i++; 
                            
                    
                            $values = collect($values);
                            $null_object = StdClass::fromArray();
                        

                            $grouped_by_exam_type = $values->groupBy('exam_type');
                   
                            $bangla = $grouped_by_exam_type->get('bangla',[$null_object])[0];

                            $english = $grouped_by_exam_type->get('english',[$null_object])[0];



                            $bangla_exam_time3 = isset($bangla->exam_time) ? $bangla->exam_time - 1: 1;

                            $english_exam_time3 = isset($english->exam_time) ? $english->exam_time - 1: 1;
  

                          
                            //$bangla_exam_time3 = isset($bangla->exam_time) ? $bangla->exam_time: 1;
                            $bangla_exam_time = $bangla_speed;

                            //$english_exam_time3 = isset($english->exam_time) ? $english->exam_time: 1;
                            $english_exam_time = $english_speed;

                            $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;

                            $bangla_wpm = round($bangla_corrected_words/$bangla_exam_time3,1);

                            $bangla_wpm = round_to_integer($bangla_wpm);

                            $english_corrected_words = $english->typed_words - $english->inserted_words;

                            $english_wpm = round($english_corrected_words/$english_exam_time3,1);

                            $english_wpm = round_to_integer($english_wpm);


                            ?>
                                <tr class="gradeX">
                                                           
                                    <td>{{$i}}</td>
                                    <td>{{$values[0]->sl}}</td>
                                    <td>{{$values[0]->roll_no}}</td>
                                    <td>{{$values[0]->exam_code_name}}</td>
                                    <td class="table-name">

                                        {{$values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name}}

                                    </td>

                                    <td style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;">
                                   
                                        @if(! $values->lists('attended_typing_test')->contains('true'))

                                        <?php $remarks = 'Absent'; ?>

                                        @else

                                        @if($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed)

                                        <?php $remarks = 'Pass'; ?>

                                        @else

                                        <?php $remarks = 'Fail'; ?>

                                        @endif

                                        @if($values->lists('typing_status')->contains('cancelled'))

                                        <?php $remarks = 'Cancelled'; ?>

                                        @endif

                                        @if($values->lists('typing_status')->contains('expelled'))

                                        <?php $remarks = 'Expelled'; ?>

                                        @endif

                                        @endif

                                        {{$remarks}} 

                                   </td>
                                  
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($status==2)
                    <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="modal fade company-modal" id="etsbModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">


  </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>



<div class="table-primary print-report-table-wrapper">


<style>

    table thead tr th:last-child{
        border-right: 1px solid #333 !important;
    }

    .print-show{
        display: none;
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

        thead tr th, tbody tr td {
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

        table, th, td {
            border: 1px solid #333 !important;
        }

        .table-primary thead tr th:empty {
            /*border-right: none !important;*/
            border-top: none !important;
        }

        table thead tr th:last-child{
            border-right: 1px solid #333 !important;
        }

        .no-border span {
            position: relative;
            top: 18px;
        }

        table.report-table thead th {
            padding: 10px;
            font-weight: 600;
            color: #377;
            text-align: center;
        }


        table thead th, table tfoot th {
            font-weight: 600 !important;
            color: #333 !important;
            padding-left: 0 !important;
        }

        .graph-button{
            color: inherit;
            text-decoration: none;
        }

        footer{
            font-size: 16px !important;
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

<div class="table-primary report-table-wrapper">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr>
            <th> <span>SL.</span> </th>
            <th> <span>Roll No.</span> </th>
            <th> <span>Exam Code</span> </th>
            <th> <span>Name</span> </th>
            <th> <span>Remarks</span> </th>
            
        </tr>
        </thead>

        <tbody>
        
        @if($status==2)
        <?php $i = isset($_GET['page']) ? ($_GET['page']-1)*1 + 0: 0; ?>

            @foreach($model_all as $values)

            <?php $i++; 



            $values = collect($values);
        
            $grouped_by_exam_type = $values->groupBy('exam_type');
   
            $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0]:StdClass::fromArray();

            $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0]:StdClass::fromArray();


            $bangla_exam_time3 = isset($bangla->exam_time) ? $bangla->exam_time - 1: 1;

            $english_exam_time3 = isset($english->exam_time) ? $english->exam_time - 1: 1;


            $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;

            $bangla_wpm = round($bangla_corrected_words/$bangla_exam_time3,1);

            $bangla_wpm = round_to_integer($bangla_wpm);            

            $english_corrected_words = $english->typed_words - $english->inserted_words;

            $english_wpm = round($english_corrected_words/$english_exam_time3,1);

            $english_wpm = round_to_integer($english_wpm);
        
            ?>
                <tr class="gradeX">
                                           
                    <td>{{$i}}</td>
                    <td>{{$values[0]->roll_no}}</td>
                    <td>{{$values[0]->exam_code_name}}</td>
                    <td class="table-name">

                        {{trim($values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name)}}

                    </td>
                    <td>
                   
                        @if(! $values->lists('attended_typing_test')->contains('true'))
                        
                        <?php $remarks = 'Absent'; ?>
                        
                        @else

                        @if($bangla_wpm >= $bangla_speed && $english_wpm >= $english_speed)

                        <?php $remarks = 'Pass'; ?>

                        @else

                        <?php $remarks = 'Fail'; ?>
                        
                        @endif

                        @if($values->lists('typing_status')->contains('cancelled'))
                        
                        <?php $remarks = 'Cancelled'; ?>
                        
                        @endif

                        @if($values->lists('typing_status')->contains('expelled'))
                        
                        <?php $remarks = 'Expelled'; ?>
                        
                        @endif

                        @endif

                        {{$remarks}}

                   </td>
                   
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>




{{-- @if ($remarks == 'all') 
    
<table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
  <tr>
    <th>Pass</th>
    <th>Fail</th>
  </tr>
  <tr>
    <td>{{$passed_count}}</td>
    <td>{{$failed_count}}</td>
  </tr>
</table>


@elseif($remarks == 'passed')

<table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
  <tr>
    <th>Pass</th>
  </tr>
  <tr>
    <td>{{$passed_count}}</td>
  </tr>
</table>


@elseif($remarks == 'failed')

<table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
  <tr>
    <th>Fail</th>
  </tr>
  <tr>
    <td>{{$failed_count}}</td>
  </tr>
</table>

@endif --}}


</div>

<footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

</div>




























<div class="table-primary print-report-table-wr-wrapper">


<style>

    table thead tr th:last-child{
        border-right: 1px solid #333 !important;
    }

    .print-show{
        display: none;
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

        thead tr th, tbody tr td {
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

        table, th, td {
            border: 1px solid #333 !important;
        }

        .table-primary thead tr th:empty {
            /*border-right: none !important;*/
            border-top: none !important;
        }

        table thead tr th:last-child{
            border-right: 1px solid #333 !important;
        }

        .no-border span {
            position: relative;
            top: 18px;
        }

        table.report-table thead th {
            padding: 10px;
            font-weight: 600;
            color: #377;
            text-align: center;
        }


        table thead th, table tfoot th {
            font-weight: 600 !important;
            color: #333 !important;
            padding-left: 0 !important;
        }

        .graph-button{
            color: inherit;
            text-decoration: none;
        }

        footer{
            font-size: 16px !important;
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

<div class="table-primary report-table-wrapper">
    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr>
            <th> <span>SL.</span> </th>
            <th> <span>Roll No.</span> </th>
            <th> <span>Exam Code</span> </th>
            <th> <span>Name</span> </th>
            <th> <span>Remarks</span> </th>
            
        </tr>
        </thead>

        <tbody>
        
        @if($status==2)
        <?php $i = isset($_GET['page']) ? ($_GET['page']-1)*1 + 0: 0; ?>

            @foreach($model_all as $values)

            <?php $i++; 



            $values = collect($values);
        
            $grouped_by_exam_type = $values->groupBy('exam_type');
   
            $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0]:StdClass::fromArray();

            $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0]:StdClass::fromArray();


            $bangla_exam_time3 = isset($bangla->exam_time) ? $bangla->exam_time - 1: 1;

            $english_exam_time3 = isset($english->exam_time) ? $english->exam_time - 1: 1;


            $bangla_corrected_words = $bangla->typed_words - $bangla->inserted_words;

            $bangla_wpm = round($bangla_corrected_words/$bangla_exam_time3,1);

            $bangla_wpm = round_to_integer($bangla_wpm);            

            $english_corrected_words = $english->typed_words - $english->inserted_words;

            $english_wpm = round($english_corrected_words/$english_exam_time3,1);

            $english_wpm = round_to_integer($english_wpm);
        
            ?>
                <tr class="gradeX">
                                           
                    <td>{{$i}}</td>
                    <td>{{$values[0]->roll_no}}</td>
                    <td>{{$values[0]->exam_code_name}}</td>
                    <td class="table-name">

                        {{trim($values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name)}}

                    </td>
                    <td></td>
                   
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

</div>

<footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

</div>









<!-- page end-->

<!--script for this page only-->

<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>

    <script>


function report_exam_code(){

    var exam_code = $('#exam_code').val();

    if (exam_code != '') {

        $('#company_list,#designation_list,#exam_date_from,#exam_date_to').prop('disabled', true);

        $('#company_list,#designation_list,#exam_date_from,#exam_date_to').val('').trigger('change');

        $('.jrequired').hide();

        $('#company_list,#designation_list,#exam_date_from,#exam_date_to').attr('required', false);


    }else{

        $('#company_list,#designation_list,#exam_date_from,#exam_date_to').prop('disabled', false);

        $('.jrequired').show();

        $('#company_list,#designation_list,#exam_date_from,#exam_date_to').attr('required', true);


    }

}


    report_exam_code();

    $('#exam_code').keyup(function(e) {
    
        report_exam_code();

    });

    $('#exam_code').bind('input',function(e) {
    
        report_exam_code();

    });

    // $('select, #exam_date').not('#exam_code_list, #exam_type').prop('disabled', true);
                        
    $('form').on('submit', function(e) {
        $('select, #exam_date').prop('disabled', false);
    });

        /* $('.report-form').submit(function(e){
                var company_id = $('#company_id').val();
                var designation_id = $('#designation_id').val();
                var exam_date = $('#exam_date').val();
                var bangla_speed = $('#bangla_speed').val();
                var english_speed = $('#english_speed').val();
             if(company_id.length <= 0 || designation_id.length <= 0 || exam_date.length <= 0 || bangla_speed.length <= 0 || english_speed.length <= 0 ){
                 $('.alert-danger').show();
                 $('.msg').html('Please fill out all input field!');
                 $( "#button" ).prop( "disabled", true );
                 return false;
             }
             $( "#button" ).prop( "disabled", false );
         })*/

        // $('#button').click(function(e){

        //     var company_id = $('#company_id').val();
        //     var designation_id = $('#designation_id').val();
        //     var exam_date_from = $('#exam_date_from').val();
        //     var exam_date_to = $('#exam_date_to').val();
        //     var bangla_speed = $('#bangla_speed').val();
        //     var english_speed = $('#english_speed').val();
        //     if(company_id.length <= 0 || designation_id.length <= 0 || exam_date_from.length <= 0 || exam_date_to.length <= 0 || bangla_speed.length <= 0 || english_speed.length <= 0 ){
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