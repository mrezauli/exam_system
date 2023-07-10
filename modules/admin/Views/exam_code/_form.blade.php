@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start-->
<style>

    form{
        max-width: 800px;
        margin: 0 auto;
    }

</style>
<div class="inner-wrapper index-page">

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">

                    {{ $page_title }}

                    <a href="{{route('exam-code')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

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

                        {!! Form::open(['route' => 'store-exam-code','id' => 'jq-validation-form','class' => 'default-form mt-30']) !!}


                        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                            <div class="row">

                                <div class="col-sm-6">
                                    {!! Form::label('company_id', 'Organization Name:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($company_list)>0)
                                    {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                    {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-6">
                                    {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                                    <small class="required">*</small>
                                    @if(count($designation_list)>0)
                                    {!! Form::select('designation_id', $designation_list, Input::old('designation_id'),['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                    {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                            </div>
                        </div>





                        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                            <div class="row">

                            <div class="col-sm-6">
                                  {!! Form::label('exam_date', 'Exam Date:', ['class' => 'control-label']) !!}
                                  <small class="required">*</small>
                                  {!! Form::text('exam_date', Input::old('exam_date'), ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                                  <span class="input-group-btn add-on">
                                    <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                </span>
                            </div>

                            <div class="col-sm-6">
                                {!! Form::label('shift', 'Shift:', ['class' => 'control-label']) !!}
                                <small class="required">*</small>
                                {!! Form::select('shift', array(''=>'Select a shift','s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5','s6'=>'Shift 6','s7'=>'Shift 7','s8'=>'Shift 8'),Input::get('shift')? Input::get('shift') : null,['class' => 'form-control','title'=>'select a shift','required']) !!}
                            </div>

                        </div>
                    </div>




                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">

                            <div class="col-sm-6">
                                {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
                                <small class="required">*</small>
                                {!! Form::select('exam_type', array(''=>'Select exam type','typing_test'=>'Typing Test', 'aptitude_test'=>'Aptitude Test'),Input::get('exam_type')? Input::get('exam_type') : null,['class' => 'form-control','title'=>'select exam type','required']) !!}
                            </div>

                            <div class="col-sm-6">
                                {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
                                {!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','required','disabled','title'=>'select status of company']) !!}
                            </div>

                        </div>
                    </div>


                    <p> &nbsp; </p>

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t text-right">
                        {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save post information']) !!}
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

    $('.datepicker').each(function(index, el) {

     $(el).datepicker({
         format: 'yyyy-mm-dd'
     });

 });

</script>

@stop