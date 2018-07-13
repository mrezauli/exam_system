@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="page-inner-wrapper create-contact-page">


    <div class="modal-header">
        <h4 class="modal-title pull-left" id="myModalLabel"> {{ $page_title }}</h4>
        <a href="{{route('organization-file-upload')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>
    </div>

        <br><br><br>

        <div class="col-sm-offset-2 col-sm-8 form-block organization-application-form-block">
            <div class="row form-header organization-form-header"></div>
            {!! Form::model($data,['method' => 'PATCH', 'route' => ['update-organization-file-upload',$data->id],'id' => 'jq-validation-form','class' => 'organization-application-form','files'=>true]) !!}
                @include('application::organization_file_upload.update_form')
            {!! Form::close() !!}
        </div>


</div>

@stop