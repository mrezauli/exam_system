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

            {!! Form::open(['route' => ['create-question-paper-set'],'id' => 'jq-validation-form','class' => 'col-sm-7 date-filter-form']) !!}

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



            {!! Form::open(['route' => ['store-question-paper-set','add','id'],'id' => 'jq-validation-form']) !!}

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
                            <th> Question Mark </th>
                            <th> Question Title </th>
                            <th> Question Type </th>
                            <th> Created Date </th>
                            <th> Action </th>
                        </tr>
                        </thead>


                        <tfoot class="search-section">
                        <tr> 
                            <th> Select Question </th>
                            <th> Question Mark </th>
                            <th> Question Title </th>
                            <th> Question Type </th>
                            <th> Created Date </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody> 


                        @if(isset($data))

                            @foreach($data as $values)



                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">
                                    <td><input type="checkbox" name="checkbox[]" class="checkbox" value="{{$values->id}}"></td>
{{-- 
                                    <td>{!! Form::text('question_mark', '', ['id'=>'question_mark', 'class' => 'form-control question-mark']) !!}</td> --}}

                                    <td>
                                        <input id="question_mark" data-id="{{$values->id}}" class="form-control question-mark" name="question_marks[]" type="text" value="">
                                    </td>


                                    <td>{{ucfirst($values->title)}}</td>
                                    <td>{{ucfirst($values->question_type)}}</td>
                                    <td>{{ucfirst($values->created_at->toDateString())}}</td>
                                

            {{-- <iframe scrolling="no" style="width:100%;height:200px" src="{{URL::asset($values->image_file_path)}}"></iframe> --}}
           {{--  <object type="text/html" data="{{URL::asset($values->image_file_path)}}" style="width:100%; height:100%">
            <p>backup content</p>
            </object> --}}
                                    
                                    <td>
                                        <a href="{{ route('view-qbank-aptitude-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <input type="hidden" name="filtered_ids" id="input" class="form-control" value="{{implode(',',$data->lists('id')->toArray())}}">

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

<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>

<!-- modal -->
@stop
<!--script for this page only-->


@section('custom-script')

<script>




var column_index = ['4'];
create_dropdown_column(column_index);

var question_marks_id = {};

var checkbox_ids = [];

$('body').on('keyup input','.question-mark',function(event) {

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

    console.log(myJSON);

    $('#checked_ids').val(myJSON);


});



</script>
@stop
