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

p{
    display: block !important;
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
                {!! Form::open(['method' =>'GET','route'=>'generate-attendance-sheet-report','class'=>'report-form']) !!}

                <div class="col-sm-12">

                    <div class="col-lg-25 col-md-3 col-sm-6">
                    {!! Form::label('exam_code', 'Exam Code:', ['class' => 'control-label']) !!}
                        {!! Form::text('exam_code', @Input::get('exam_code')? Input::get('exam_code') : null,['id'=>'exam_code','class' => 'form-control','placeholder'=>'exam code', 'title'=>'exam code']) !!}
                    </div>

                    {{-- <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('aptitude_exam_code', 'Aptitude Exam Code:', ['class' => 'control-label']) !!}
                        {!! Form::text('aptitude_exam_code', @Input::get('aptitude_exam_code')? Input::get('aptitude_exam_code') : null,['id'=>'aptitude_exam_code','class' => 'form-control','placeholder'=>'exam code', 'title'=>'exam code']) !!}
                    </div> --}}
                
                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('company_id',$company_list, @Input::get('company_id')? Input::get('company_id') : null,['id'=>'company_list','class' => 'form-control js-select','placeholder'=>'select company', 'title'=>'select company']) !!}
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('designation_id',$designation_list, @Input::get('designation_id')? Input::get('designation_id') : null,['id'=>'designation_list','class' => 'form-control js-select','placeholder'=>'select industry type', 'title'=>'select industry type']) !!}
                    </div>

                </div>

                <div class="col-sm-12">

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_date_from', 'Exam Date From:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('exam_date_from', Input::get('exam_date_from')? Input::get('exam_date_from') : null, ['id'=>'exam_date_from', 'class' => 'form-control datepicker']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_date_to', 'Exam Date To:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('exam_date_to', Input::get('exam_date_to')? Input::get('exam_date_to') : null, ['id'=>'exam_date_to', 'class' => 'form-control datepicker']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::select('exam_type', array(''=>'Select exam type','typing_test'=>'Typing Test', 'aptitude_test'=>'Aptitude Test'),Input::get('exam_type'),['id'=>'exam_type','class' => 'form-control','title'=>'select exam type']) !!}
                    </div>

            
                    <div class="col-lg-2 col-md-3 col-sm-6 filter-btn">

                      {!! Form::submit('Generate Report', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div>

                    @if(isset($model_all) && ! empty($model_all))

                          {{-- <a href="{{ route('attendance-sheet-report-pdf', [$company_id,$exam_date_from,$designation_id,$exam_date_to]) }}" class="pdf_report_button" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}

                          <a href="#" class="btn btn-danger print-button pdf_report_button">Print</a>

                    @endif

                </div>
                {!! Form::close() !!}
  


                <p><br><br><br><br><br></p>
                <br><br><br>
            
                


                {{------------- Filter :Ends ------------------------------------------}}
                <div class="table-primary report-table-wrapper">

                    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples_report">
                        <thead>
                        <tr>

                            <th> SL. </th>
                            <th> Roll No. </th>
                            <th> Name </th>
                            <th> Exam Type </th>
                            <th style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;"> Presence </th>

                        </tr>
                        </thead>


                        <tbody>

                        <?php  
        
                        function presence($attendence){
                          return $attendence ? '<td style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;"> Present </td>' : '<td style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;"> Absent </td>';
                        }

                        $sl_no = 0;
                     
                        ?>
                        
                        @if($status==2)
                      
                            @foreach($model as $values)
                     
                            <?php $sl_no++; ?>

                                <tr class="gradeX">
                                                           
                                    <td>{{$sl_no}}</td>
                                    <td>{{$values->roll_no}}</td>
                                    <td class="table-name">
                                        {{$values->username . ' ' . $values->middle_name . ' ' . $values->last_name}}
                                    </td>
                                    <td>{{$values->exam_type == 'typing_test' ? 'Typing Test' : 'Aptitude Test'}}</td>
                                      
                                    <?php 


                                    if ($values->exam_type == 'typing_test') {

                                      echo presence($values->attended_typing_test); 

                                    }

                                    if ($values->exam_type == 'aptitude_test') {

                                      echo presence($values->attended_aptitude_test); 

                                    }


                                    // if (($values->attended_typing_test == 'true' || $values->attended_aptitude_test == 'true')) {

                                    //     echo '<td> Present </td>';

                                    // }else{

                                    //     echo '<td> Absent </td>';

                                    // }


                                    ?>
                                    
                                   
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($status==2)
                
                    {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span> --}}
                    
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


    @media print{      

        *{
            text-align: center !important;
            font-size: 14px !important;
        }

        table#examples{
            border-collapse: collapse !important;
        }

        .print-hide{
            display: none !important;
        }

        .print-show{
            display: block !important;
        }

        .header{
            /*font-family: SolaimanLipi !important;
            font-size: 15px !important;*/
            text-align: center;
            max-width: 400px;
            margin: 5px auto;
        }

        .header-section{
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #333s;
        }

    }

</style>


                                

<div class="print-section print-show">
    <div class="header-section">
        <p class="header"> {{ isset($header->company_name) ? $header->company_name : ''}}</p>
        <p class="header">{{ isset($header->address) ? $header->address : ''}}</p>
        <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : ''}}</p>
        <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
        <p class="header">পরীক্ষা গ্রহণে - বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
    </div>
    
    
    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr> 
    
            <th> ক্রমিক নং </th>
            <th> পরীক্ষার্থীর রোল নং </th>
            <th> পরীক্ষার্থীর নাম </th>
            <th> পরীক্ষার ধরন </th>            
            <th> মন্তব্য </th>
    
        </tr>
        </thead>

        <tbody>

           <?php   

           if(isset($model_all) && ! empty($model_all)){

            $count_model = collect($model_all);
            
            $total = $count_model->count();

            if ($count_model->first()->exam_type == 'typing_test') {

                $present = collect($model_all)->lists('attended_typing_test')->filter(function ($value) {
                    return $value == 'true';
                })->count();

                $absent = $total - $present;

            }

            if ($count_model->first()->exam_type == 'aptitude_test') {

                $present = collect($model_all)->lists('attended_aptitude_test')->filter(function ($value) {
                    return $value == 'true';
                })->count();

                $absent = $total - $present;

            }

            $present_percentage = round($present/$total * 100,2);

            $absent_percentage = round($absent/$total * 100,2);

           }

           $sl_no = 0;

           ?>
        
        @if($status==2 && isset($model_all) && ! empty($model_all))
       
            @foreach($model_all as $values)

            <?php $sl_no++; ?>
           
                <tr class="gradeX">
                                           
                    <td>{{$sl_no}}</td>
                    <td>{{$values->roll_no}}</td>
                    <td class="table-name">
                        {{$values->username . ' ' . $values->middle_name . ' ' . $values->last_name}}
                    </td>

                    <td>{{$values->exam_type == 'typing_test' ? 'Typing Test' : 'Aptitude Test'}}</td>

                      
                    <?php 
    
                    if (($values->attended_typing_test == 'true' || $values->attended_aptitude_test == 'true')) {
    
                        echo '<td> উপস্থিত </td>';
    
                    }else{
    
                        echo '<td> অনুপস্থিত </td>';
    
                    }
                    
                    ?>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top:20px;width:50%;margin-left: 50%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>উপস্থিত</th>
        <th>উপস্থিত (%)</th>
        <th>অনুপস্থিত</th>
        <th>অনুপস্থিত (%)</th> 
        <th>মোট</th>
      </tr>
      <tr>
        <td>{{$present}}</td>
        <td>{{$present_percentage}}</td>
        <td>{{$absent}}</td>
        <td>{{$absent_percentage}}</td>
        <td>{{$total}}</td>
      </tr>
    </table>
    @endif
    <div class="float:none;clear:both;"></div>


    




</div>

<footer class="float:none;clear:both;" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

<!-- page end-->

<!--script for this page only-->

<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>

<script>


function report_exam_code(ddd){


    // var typing_exam_code = $('#typing_exam_code').val();

    // var aptitude_exam_code = $('#aptitude_exam_code').val();

    if ($(ddd).val() != '' && $(ddd).val() != undefined) {
        $('#typing_exam_code,#aptitude_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').not(ddd).prop('disabled', true);
        $('#typing_exam_code,#aptitude_exam_code').not(ddd).val('');

        $('#exam_date_from,#exam_date_to,#exam_type').val([]);

        $('#company_list,#designation_list').select2('val','ALL');

    }else{

        $('#typing_exam_code,#aptitude_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').prop('disabled', false);
    }

// if (aptitude_exam_code != 0) {
//     $('.report-form input,.report-form select').not(ddd).prop('disabled', true);
// }else{
//     $('.report-form input,.report-form select').prop('disabled', false);
// }



    // if (typing_exam_code != '') {

    //    $('#aptitude_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').prop('disabled', true);

    //    $('#aptitude_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').val('').trigger('change');

    //    $('.jrequired').hide();

    //    $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').attr('required', false);
      

    // }else if(aptitude_exam_code != ''){

    //     $('#typing_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').prop('disabled', true);

    //     $('#typing_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').val('').trigger('change');

    //     $('.jrequired').hide();

    //     $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').attr('required', false);


    // }else{

    //     $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').prop('disabled', true);

    //     $('.jrequired').show();

    //     $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').attr('required', false);

    // }

}


//$('.report-form input,.report-form select').not('#typing_exam_code,#aptitude_exam_code,.btn').prop('disabled', true);

$('.required').css('visibility', 'hidden');







function report_exam_code_3(ddd){

        if ($(ddd).val() != '' && $(ddd).val() != undefined) {
            $('#exam_code,#aptitude_exam_code').prop('disabled', true);
            $('#exam_code,#aptitude_exam_code').val('');

            $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').attr('required', 'required');
            $('.required').css('visibility', 'visible');
        }


        var exam_code = $('#company_list').val();
        var designation_list = $('#designation_list').val();
        var exam_date_from = $('#exam_date_from').val();
        var exam_date_to = $('#exam_date_to').val();
        var exam_type = $('#exam_type').val();


        if(exam_code == '' && designation_list == '' && exam_date_from == '' && exam_date_to == '' && exam_type == ''){

            $('#exam_code,#aptitude_exam_code,#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').prop('disabled', false);

            $('#company_list,#designation_list,#exam_date_from,#exam_date_to,#exam_type').removeAttr('required');
            $('.required').css('visibility', 'hidden');


        }
}






    $('#exam_code,#aptitude_exam_code').keyup(function(e) {

        var ddd = $(this);

        report_exam_code(ddd);

    });
    

    $('#exam_code,#aptitude_exam_code').bind('input',function(e) {
    
        var ddd = $(this);

        report_exam_code(ddd);

    });


    $('#company_list,#designation_list,#exam_type').on('change',function(e) {

        var ddd = $(this);

        report_exam_code_3(ddd);

    });


    $('#exam_date_from,#exam_date_to').on('changeDate',function(e) {
        // alert('qqq');

        var ddd = $(this);

        report_exam_code_3(ddd);

    });

    $('#exam_date_from,#exam_date_to').bind('input',function(e) {
        // alert('ttt');

        var ddd = $(this);

        report_exam_code_3(ddd);

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

