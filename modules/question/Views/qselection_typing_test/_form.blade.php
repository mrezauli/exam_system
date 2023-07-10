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

    <a href="{{route('qselection-typing-test')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

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

            <ul class="alert alert-danger" style="display: none">
                <li class="msg"></li>
            </ul>

                <div class="adv-table">

                    <p> &nbsp;</p>

                    {{-------------- Filter :Ends --------------------------------------------}}

                    {!! Form::open(['route' => ['store-qselection-typing-test','add'], 'id' => 'jq-validation-form', 'novalidate']) !!}

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                    <div class="row">

                    <div class="col-sm-2">
                    {!! Form::label('exam_code_id', 'Exam Code:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($exam_code_list)>0)
                        {!! Form::select('exam_code_id', $exam_code_list, Input::get('exam_code_list')? Input::get('exam_code_list') : null,['id'=>'exam_code_list','class' => 'form-control  js-select','required']) !!}
                        @else
                        {!! Form::text('exam_code_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                        @endif
                    </div>

                    <div class="col-sm-2">
                    {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($company_list)>0)
                        {!! Form::select('company_id', $company_list, Input::get('company_list')? Input::get('company_list') : null,['id'=>'company_list','class' => 'form-control  js-select','required','readonly']) !!}
                        @else
                        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                        @endif
                    </div>


                    <div class="col-sm-2">
                    {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($designation_list)>0)
                        {!! Form::select('designation_id', $designation_list, Input::get('designation_list')? Input::get('designation_list') : null,['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
                        @else
                        {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
                        @endif
                    </div>

                    <div class="col-sm-2">
                      {!! Form::label('exam_date', 'Exam Date', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                      {!! Form::text('exam_date', Input::get('exam_date')? Input::get('exam_date') : null, ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('shift', 'Shift:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::select('shift', array(''=>'Select a shift','s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5','s6'=>'Shift 6','s7'=>'Shift 7','s8'=>'Shift 8'),Input::get('shift')? Input::get('shift') : null,['class' => 'form-control','title'=>'select a shift','required']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::select('exam_type', array(''=>'Select exam type','bangla'=>'Bangla', 'english'=>'English'),Input::get('exam_type')? Input::get('exam_type') : null,['class' => 'form-control','title'=>'select exam type','required']) !!}
                    </div>


                    <div class="col-sm-1 pull-right text-right">
                      {!! Form::submit('Save', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                    </div>



                </div>
            </div>

                    <p> &nbsp;</p>

                    <table  class="display table table-bordered table-striped typing-select-table" id="example">
                        <thead>
                        <tr>
                            <th> Select Question </th>
                            <th> Exam Type </th>
                            <th> Question </th>
                            <th> Action </th>
                        </tr>
                        </thead>


                        <tfoot class="search-section">
                        <tr>
                            <th> Select Question </th>
                            <th> Exam Type </th>
                            <th> Question </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody>

                        @if(isset($data))
                            @foreach($data as $values)
                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">

                                    <td><input type="radio" name="question_id" class="btn radio" {{($values->id == $selected_questions_id)?'checked':''}} data-id="{{$values->id}}" value="{{$values->id}}"></td>
                                    <td>{{ucfirst($values->exam_type)}}</td>
                                    <td>{{$values->typing_question}}</td>
                                    <td>
                                        <a href="{{ route('view-qbank-typing-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <input type="hidden" name="checked_id" id="checked_id" class="form-control" value="">

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

<!-- modal -->
@stop
<!--script for this page only-->


@section('custom-script')


<script>


// $('#button').click(function(e){

//     var company_id = $('#company_id').val();
//     var designation_id = $('#designation_id').val();
//     var exam_date_from = $('#exam_date_from').val();
//     var exam_date = $('#exam_date').val();
//     var bangla_speed = $('#bangla_speed').val();
//     var english_speed = $('#english_speed').val();
//     if(company_id.length <= 0 || designation_id.length <= 0 || exam_date_from.length <= 0 || exam_date_to.length <= 0 || bangla_speed.length <= 0 || english_speed.length <= 0 ){
//         $('.alert-danger').show();
//         $('.msg').html('Please fill out all input field!');
//     }else{
//         $('.report-form').submit();
//     }

// })




$('select, #exam_date').not('#exam_code_list, #exam_type').prop('disabled', true);


$('form').on('submit', function(e) {
    $('select, #exam_date').prop('disabled', false);
});


// $('form').on('submit', function(e) {

//     e.preventDefault();

//     var today = new Date();
//     var formattedtoday = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();

//     var exam_date = $('#exam_date').val();


//     if(formattedtoday > exam_date){
//         $('.alert-danger').show();
//         $('.msg').html('Exam date must be equal or greater than current date.');
//     }else{

//         $('select, #exam_date').prop('disabled', false);
//         $('.form').submit();

//     }


// });


var column_index = ['2'];
create_dropdown_column(column_index);

$('.datepicker').each(function(index, el) {

 $(el).datepicker({
     format: 'yyyy-mm-dd'
 });

});

/*var column_index = ['2'];
create_dropdown_column(column_index);*/


var selected_questions_id = {!! $selected_questions_id !!}

$('#checked_id').val(selected_questions_id);




$("select#exam_type").change(function() {


    var exam_type = $(this).val();

    var organization = $('#company_list').val();

    var position = $('#designation_list').val();

    var exam_date = $('#exam_date').val();

    var shift = $('#shift').val();

    var exam_code = $('#exam_code_list').val();


    if ($('#checked_id').val().length != 0 ){

        question_id = $('#checked_id').val();

    }else{

        var question_id = $("input[name='question_id']:checked").val();

    }




    window.location = '{!! route('create-qselection-typing-test') !!}' + '?exam_type=' + exam_type + '&company_list=' + organization + '&designation_list=' + position + '&exam_date=' + exam_date + '&shift=' + shift + '&question_id=' + question_id+ '&exam_code_list=' + exam_code;


    // window.location = $(this).val();
});

$('body').on('change','.radio',function(event) {

    var question_id = $(this).val();

    $('#checked_id').val(question_id);


});

</script>


<style>

table.dataTable tfoot tr th:nth-child(2) select,.hidden-checkbox {
    visibility: hidden !important;
}

</style>

@stop

