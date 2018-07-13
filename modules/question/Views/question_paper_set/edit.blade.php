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

    <a href="{{route('question-paper-set')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

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
                    
                    {{-------------- Filter :Ends ----------------------------------------- --}}

                    {!! Form::open(['route' => ['edit-question-paper-set',$data->id],'id' => 'jq-validation-form','class' => 'col-sm-7 date-filter-form']) !!}

                            <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                                <div class="row">

                                    <div class="col-lg-4 col-md-3 col-sm-6">
                                      {!! Form::label('created_date_from', 'Created Date From:', ['class' => 'control-label']) !!}
                                      {!! Form::text('created_date_from', Input::get('created_date_from')? Input::get('created_date_from') : null, ['id'=>'created_date_from', 'class' => 'form-control datepicker']) !!}
                                      <span class="input-group-btn add-on">
                                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                    </span>
                                </div>

                                <div class="col-lg-4 col-md-3 col-sm-6">
                                  {!! Form::label('created_date_to', 'Created Date To:', ['class' => 'control-label']) !!}
                                  {!! Form::text('created_date_to', Input::get('created_date_to')? Input::get('created_date_to') : null, ['id'=>'created_date_to', 'class' => 'form-control datepicker']) !!}
                                  <span class="input-group-btn add-on">
                                    <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                </span>
                            </div>

                            <div class="col-sm-2">
                              {!! Form::submit('Filter', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                            </div>

                            </div>
                            </div>

                    {!! Form::close() !!}

                    {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-question-paper-set', $data->id]]) !!}

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t col-sm-5">
                    <div class="row">

                    <div class="col-sm-5">
                      {!! Form::label('question_set_title', 'Question Set Title', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                      {!! Form::text('question_set_title', Input::old('question_set_title'), ['id'=>'question_set_title', 'class' => 'form-control','required']) !!}
                    </div>


                    <div class="col-sm-2">
                      {!! Form::submit('Save', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                    </div>

                    

                </div>
            </div>

                    <p> &nbsp;</p>

                    <table  class="display table table-bordered table-striped question-paper-set-table" id="example">
                        <thead>
                        <tr> 
                            <th> Select Question </th>
                            <th> Question Mark</th>
                            <th> Question Title </th>
                            <th> Question Type </th>
                            <th> Created Date </th>
                            <th> Action </th>
                        </tr>
                        </thead>
 

                        <tfoot class="search-section">
                        <tr> 
                            <th> Select Question </th>
                            <th> Question Mark</th>
                            <th> Question Title </th>
                            <th> Question Type </th>
                            <th> Created Date </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody> 
<?php 

$question_marks_id = [];

foreach ($selected_questions_id as $id) {

    $question_mark = isset($data->aptitude_questions->keyBy('id')->get($id)->pivot->question_mark) ? $data->aptitude_questions->keyBy('id')->get($id)->pivot->question_mark : '0';


    if ($question_mark !=0) {

        $question_marks_id[$id] = $question_mark;

    }

}

 ?>
                        @if(isset($questions))

                        <?php $all_question_marks = []; ?>
                            @foreach($questions as $values)


<?php

$id = $values->id;

$question_mark = isset($data->aptitude_questions->keyBy('id')->get($id)->pivot->question_mark) ? $data->aptitude_questions->keyBy('id')->get($id)->pivot->question_mark : '0';

?>




                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">
                                    <td><input type="checkbox" name="checkbox[]" class="checkbox" {{in_array($values->id,$selected_questions_id)?'checked':''}} value="{{$values->id}}"></td>
                                    
                                    <td>
                                        <input id="question_mark" data-id="{{$values->id}}" class="form-control question-mark" name="question_marks[]" type="text" value="{{$question_mark}}">
                                    </td>

                                    <td>{{ucfirst($values->title)}}</td> 
                                    <td>{{ucfirst($values->question_type)}}</td>
                                    <td>{{ucfirst($values->created_at->toDateString())}}</td>
                                    <input type="hidden" name="filtered_ids[]" id="filtered_ids" class="form-control" value="{{$values->id}}">
                                    <td>
                                        <a href="{{ route('view-qbank-aptitude-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                      
                        </tbody>
                    </table>

                    {{-- <input type="hidden" name="filtered_ids" id="input" class="form-control" value="{{implode(',',$questions->lists('id')->toArray())}}"> --}}

                    <input type="hidden" name="all_question_marks" id="input" class="form-control" value="{{implode(',',$all_question_marks)}}">

                    <input type="hidden" name="question_marks_id" id="question_marks_id" class="form-control" value="">

                    <input type="hidden" name="checked_ids" id="checked_ids" class="form-control" value="">

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

<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>

@stop
<!--script for this page only-->


@section('custom-script')

<script>

var column_index = ['3'];
create_dropdown_column(column_index);




var question_marks_id = {!! json_encode($question_marks_id) !!};

$('#question_marks_id').val(JSON.stringify(question_marks_id));


var checkbox_ids =   {!! json_encode($selected_questions_id) !!};

$('#checked_ids').val(JSON.stringify(checkbox_ids));



$('body').on('keyup input click','.question-mark',function(event) {

    var question_id = $(this).data('id');

    var question_mark = $(this).val();

    question_marks_id[question_id] = question_mark;

    var myJSON = JSON.stringify(question_marks_id);

    console.log(myJSON);

    $('#question_marks_id').val(myJSON);


});




$('body').on('change','.checkbox',function(event) {

    var checked = $(this).is(":checked");

    var question_id = $(this).val();


    if (checked) {

        checkbox_ids.push(question_id);

    }else{

        checkbox_ids = checkbox_ids.filter(function(e){
           return e != question_id;
        });

    }
    

    var myJSON = JSON.stringify(jQuery.unique( checkbox_ids ));

    $('#checked_ids').val(myJSON);


});








</script>
@stop
