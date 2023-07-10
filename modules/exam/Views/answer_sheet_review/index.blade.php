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

                    {{--<a href="{{route('exam-process')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>--}}

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
                        {{-------------- Filter :Ends --------------------------------------------}}

                        {!! Form::open(['route' => 'start-review','id' => 'jq-validation-form','class' => 'default-form mt-30']) !!}

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
                                        {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control js-select','required']) !!}
                                    @else
                                        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::label('designation_id', 'Name of the Post:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($designation_list)>0)
                                        {!! Form::select('designation_id', $designation_list, Input::old('designation_id'),['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                        {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::label('exam_date', 'Exam Date', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    {!! Form::text('exam_date', Input::old('exam_date'), ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                    </span>
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::label('shift', 'Shift:', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    {!! Form::select('shift', array(''=>'Select a shift','s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5','s6'=>'Shift 6','s7'=>'Shift 7','s8'=>'Shift 8'),Input::get('shift')? Input::get('shift') : null,['class' => 'form-control','title'=>'select a shift','required']) !!}
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::label('roll_no', 'Roll No.:', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    {!! Form::text('roll_no', Input::get('roll_no')? Input::get('roll_no') : null,['class' => 'form-control','title'=>'select a roll no.','required']) !!}
                                </div>


                                <div class="col-sm-2 text-right">
                                    {!! Form::submit('Start Answer Sheet Review', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
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

<!-- modal -->
@stop
        <!--script for this page only-->


@section('custom-script')

    <script>

        $('select, #exam_date').not('#exam_code_list').prop('disabled', true);

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
    </script>

@stop
