@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper index-page">

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">

                    {{ $page_title }}

                    <a href="{{route('exam-process')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

                </header>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('flash_message') }}</p>
                    </div>
                @endif

                <div class="panel-body">
                    <div class="adv-table">

                        <p> &nbsp;</p>
                        <p> &nbsp;</p>
                        {{-------------- Filter :Ends ----------------------------------------- --}}

                        {!! Form::open(['route' => 'start-process','id' => 'jq-validation-form','class' => 'default-form mt-30']) !!}

                        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                            <div class="row">

                                <div class="col-sm-25">
                                    {!! Form::label('exam_code_id', 'Exam Code:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($exam_code_list)>0)
                                    {!! Form::select('exam_code_id', $exam_code_list, Input::get('exam_code_list')? Input::get('exam_code_list') : null,['id'=>'exam_process_code_list','class' => 'form-control  js-select','required'=>'required']) !!}
                                    @else
                                    {!! Form::text('exam_code_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-25">
                                    {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($company_list)>0)
                                        {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-25">
                                    {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($designation_list)>0)
                                    {!! Form::select('designation_id', $designation_list, Input::old('designation_id'),['id'=>'designation_list','class' => 'form-control  js-select js-select','required']) !!}
                                    @else
                                        {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-25">
                                    {!! Form::label('exam_date', 'Exam Date', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    {!! Form::text('exam_date', Input::old('exam_date'), ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                    </span>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-sm-25">
                                    {!! Form::label('exam_type', 'Examination Type:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    {!! Form::select('exam_type', array(''=>'Select exam type','typing_test'=>'Typing Test', 'aptitude_test'=>'Aptitude Test'),Input::old('exam_type'),['class' => 'form-control','title'=>'select exam type','required']) !!}
                                </div>

                                <div class="col-sm-25">
                                    {!! Form::label('shift', 'Shift:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    {!! Form::select('shift', array(''=>'Select a shift','s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5','s6'=>'Shift 6','s7'=>'Shift 7','s8'=>'Shift 8'),Input::get('shift')? Input::get('shift') : null,['class' => 'form-control','title'=>'select a shift','required']) !!}
                                </div>

                                <div class="col-sm-25">
                                    {!! Form::label('sl_from', 'Candidate SL No From:', ['class' => 'control-label']) !!}
                                    <small class="required">(*)</small>
                                    {!! Form::text('sl_from', Input::old('sl_from'), ['id'=>'sl_from', 'class' => 'form-control', 'style'=>'width:100%;','required']) !!}
                                </div>
                                <div class="col-sm-25">
                                    {!! Form::label('sl_to', 'Candidate SL No To:', ['class' => 'control-label']) !!}
                                    <small class="required">(*)</small>
                                    {!! Form::text('sl_to', Input::old('sl_to'), ['id'=>'sl_to', 'class' => 'form-control', 'style'=>'width:100%;','required']) !!}
                                </div>

                                <div class="col-sm-2 text-right">
                                    {!! Form::submit('Process Start', ['class' => 'btn btn-primary selection-button process-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- page end-->


<!-- Modal  -->

<div class="modal fade" id="estbModal3" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

</div>



<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b*/b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
            </div>
            <div class="modal-body alert-body">

                <div class="alert-message" style="font-size: 18px;color: #333;">Total candidate number is <span class="total_candidate_number"></span>.</div><br>

                <div class="alert-message" style="font-size: 18px;color: #333;">Are you sure you want to set the last sl no. to <span class="add"></span>?</div>
                <div class="form-margin-btn text-right">
                    <button type="button" class="btn btn-default no-button" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary yes-button" data-dismiss="modal">Yes</button>
                </div>

            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>






<!-- modal -->
@stop
        <!--script for this page only-->


@section('custom-script')


<script>

// $('.process-button').click(function(e) {

// e.preventDefault();

// $("#addData").modal('show');

// var sl_to = $('#sl_to').val();

// $("#addData.add").html(sl_to);



// $('#addData').on('click', '.yes-button', function(e) {

//     $('select, #exam_date, #sl_from').prop('disabled', false);

//     $('form').submit();

// });

// });



$('#exam_process_code_list').change(function(event) {

    ajax_get_exam_process_code();

    ajax_get_total_candidate_number();

});


function ajax_get_total_candidate_number(){


    $.ajax({
      url: "{{Route('ajax-get-total-candidate-number')}}",
      type: 'POST',
      data: $('form').serialize(),
      success: function(data){


        var data = jQuery.parseJSON(data);

        var total_candidate_number = data[0]  != null ? data[0] : '';


        // var designation_id = exam_code[0]  != null ? exam_code[0].designation_id : '';

        // var exam_date = exam_code[0]  != null ? exam_code[0].exam_date : '';

        // var shift = exam_code[0]  != null ? exam_code[0].shift : '';

        // var exam_type = exam_code[0]  != null ? exam_code[0].exam_type : '';

        // var sl_from = exam_code[1][0]  != null ? exam_code[1][0].sl : '';

        // var sl_to = $(exam_code[1]).get(-1)  != null ? $(exam_code[1]).get(-1).sl : '';



        $('.total_candidate_number').html(total_candidate_number);

        // $('#designation_list').val(designation_id).trigger("change");

        // $('#exam_date').val(exam_date).trigger("change");

        // $('#shift').val(shift).trigger("change");

        // $('#exam_type option:last-child').val() == 'aptitude_test' ?  $('#exam_type').val(exam_type).trigger("change") : '';

        // $('#sl_from').val(sl_from);

        // $('#sl_to').val(sl_to);

        // $("#addData .add").html(sl_to);c x


      }


    });

}



function ajax_get_exam_process_code(){

    $.ajax({
      url: "{{Route('ajax-get-exam-process-code')}}",
      type: 'POST',
      data: $('form').serialize(),
      success: function(data){


        var exam_code = jQuery.parseJSON(data);

        //console.log(exam_code[1]);

        var company_id = exam_code[0]  != null ? exam_code[0].company_id : '';

        var designation_id = exam_code[0]  != null ? exam_code[0].designation_id : '';

        var exam_date = exam_code[0]  != null ? exam_code[0].exam_date : '';

        var shift = exam_code[0]  != null ? exam_code[0].shift : '';

        var exam_type = exam_code[0]  != null ? exam_code[0].exam_type : '';

        var sl_from = exam_code[1][0]  != null ? exam_code[1][0].sl : '';

        var sl_to = $(exam_code[1]).get(-1)  != null ? $(exam_code[1]).get(-1).sl : '';



        $('#company_list').val(company_id).trigger("change");

        $('#designation_list').val(designation_id).trigger("change");

        $('#exam_date').val(exam_date).trigger("change");

        $('#shift').val(shift).trigger("change");

        $('#exam_type option:last-child').val() == 'aptitude_test' ?  $('#exam_type').val(exam_type).trigger("change") : '';

        $('#sl_from').val(sl_from);

        $('#sl_to').val(sl_to);

        $("#addData .add").html(sl_to);


      }


    });


}




$('select, #exam_date, #sl_from').not('#exam_process_code_list').prop('disabled', true);

$('form').on('submit', function() {
    $('select, #exam_date, #sl_from').prop('disabled', false);
});


$('.datepicker').each(function(index, el) {

    $(el).datepicker({
        format: 'yyyy-mm-dd'
    });

});

var column_index = ['2'];
create_dropdown_column(column_index);

</script>


@stop
