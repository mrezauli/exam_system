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
                <div class="adv-table">
                   
                    <p> &nbsp;</p>
                    <p> &nbsp;</p>
                    {{-------------- Filter :Ends ----------------------------------------- --}}

                    {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-qselection-typing-test', $data->id], 'class'=>'qselection-typing-test-form', 'novalidate']) !!}
                    
    
                    <?php 

                    $company_id = empty(Input::get('company_id')) ? Input::old('company_id') : Input::get('company_id'); 

                    $designation_id = empty(Input::get('designation_id')) ? Input::old('designation_id') : Input::get('designation_id'); 

                    $exam_code_id = empty(Input::get('exam_code_id')) ? Input::old('exam_code_id') : Input::get('exam_code_id'); 

                    $exam_date = empty(Input::get('exam_date')) ? Input::old('exam_date') : Input::get('exam_date'); 

                    $exam_type = empty(Input::get('exam_type')) ? Input::old('exam_type') : Input::get('exam_type'); 

                    $shift = empty(Input::get('shift')) ? Input::old('shift') : Input::get('shift');

                    ?>


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                    <div class="row">

                    <div class="col-sm-2">
                    {!! Form::label('exam_code_id', 'Exam Code:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($exam_code_list)>0)
                        {!! Form::select('exam_code_id', $exam_code_list, $exam_code_id, ['id'=>'exam_code_list','class' => 'form-control  js-select','required']) !!}
                        @else
                        {!! Form::text('exam_code_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required']) !!}
                        @endif
                    </div>

                    <div class="col-sm-2">
                    {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($company_list)>0)
                        {!! Form::select('company_id', $company_list, $company_id, ['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                        @else
                        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required']) !!}
                        @endif
                    </div>


                    <div class="col-sm-2">
                    {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                        @if(count($designation_list)>0)
                        {!! Form::select('designation_id', $designation_list, $designation_id,['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
                        @else
                        {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required']) !!}
                        @endif
                    </div>

                    <div class="col-sm-2">
                      {!! Form::label('exam_date', 'Exam Date', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                      {!! Form::text('exam_date', $exam_date, ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::select('exam_type', array(''=>'Select exam type','bangla'=>'Bangla', 'english'=>'English'),$exam_type,['class' => 'form-control','title'=>'select exam type','required']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::label('shift', 'Shift:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::select('shift', array(''=>'Select a shift','s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5'), $shift,['class' => 'form-control','title'=>'select a shift','required']) !!}
                    </div>


                    <div class="col-sm-1 pull-right">
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

                        @if(isset($questions))

                            @foreach($questions as $values)

      
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

                    <input type="hidden" name="checked_id" id="checked_id" class="form-control" value="{{$selected_questions_id}}">

                    <input type="hidden" name="validation_checked_id" id="validation_checked_id" class="form-control" value="">

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


$('select, #exam_date').not('#exam_code_list, #exam_type').prop('disabled', true);
                    
$('form').on('submit', function() {
    $('select, #exam_date').prop('disabled', false);
});


$('.datepicker').each(function(index, el) {
    
 $(el).datepicker({
     format: 'yyyy-mm-dd'
 });

});

var column_index = ['2'];
create_dropdown_column(column_index);




var selected_questions_id = {!! $selected_questions_id !!}

$('#checked_id').val(selected_questions_id);

$("select#exam_type").change(function() {


    var exam_type = $(this).val();

    var organization = $('#company_list').val();

    var position = $('#designation_list').val();

    var exam_date = $('#exam_date').val();

    var shift = $('#shift').val();

    var url_question_id = '';



    if ($('#checked_id').length != 0 ){

        url_question_id = $('#checked_id').val();

    }else{

        var url_question_id = $("input[name='question_id']:checked").val();

    }

    

    var url = '{!! Request::url() !!}';

    window.location = url + '?exam_type=' + exam_type + '&company_id=' + organization + '&designation_id=' + position + '&exam_date=' + exam_date + '&shift=' + shift + '&url_question_id=' + url_question_id;

    // window.location = $(this).val();
    
});


// $('.qselection-typing-test-form').submit(function(e) {
//     e.preventDefault();

//     $('.qselection-typing-test-form input,.qselection-typing-test-form select').removeAttr('disabled');

//     $('.qselection-typing-test-form input,.qselection-typing-test-form select').attr('readonly','readonly');

//     $(this)[0].submit();


// });

$('body').on('change','.radio',function(event) {
    
    var question_id = $(this).val();

    $('#checked_id').val(question_id);

    $('#validation_checked_id').val(question_id);

});

</script>

<style>

table.dataTable tfoot tr th:nth-child(2) select,.hidden-checkbox {
    visibility: hidden !important;
}

</style>


@stop
