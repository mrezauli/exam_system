@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start -->

        <style>
            

        .page-header, .panel-heading {
            padding: 5px;
            padding-right: 15px;
        }

        .btn:not(.calender-button) {
            padding: 6px 8px !important;
        }

        .h4, .h5, .h6, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .organization-application-form {
            padding: 10px 0;
        }

        .form-margin-btn.text-right {
            margin-top: 10px;
        }   

        .sending-procedure-select label:first-child {
            margin-top: 10px;
        }

        form input:not(.btn), .question-mark {
            height: 28px;
        }

        .email-page .input-group-addon {
            line-height: 14px !important;
        }

        input#attachment {
            height: 30px;
        }

        .form-control, form input {
            height: auto;
        }   

        </style>

<div class="page-inner-wrapper create-contact-page">

<div class="page-header">
    
    <a href="{{route('bcc-file-upload')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>
    <div class="clearfix"></div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <h4 class="title text-center" id="myModalLabel">Select your desired letter sending procedure:</h4>

        <div class="radio text-center sending-procedure-select">
            <label>
                <input type="radio" name="application_format" id="application_format" value="{{route('create-bcc-file-upload')}}" checked="checked">
                File Upload
            </label>

            <label>
                <input type="radio" name="application_format" id="application_format" value="{{route('create-bcc-template')}}">
                Template
            </label>
        </div>

    </div>
</div>


<div class="col-sm-offset-2 col-sm-8 form-block organization-application-form-block">
    {{-- <div class="row form-header organization-form-header"></div> --}}
    {!! Form::open(['route' => 'store-bcc-file-upload','id' => 'application-form','class' => 'organization-application-form file-upload-form default-form','files'=>true]) !!}
    @include('application::bcc_file_upload._form')
    {!! Form::close() !!}
</div>


</div> 

@stop


@section('custom-script')
<script>
   /* "use strict";
    $('#application-form').submit(function(e){
        var company_list = $('#company_list').val();
        var subject = $('#subject').val();
        var letter_no = $('#letter_no').val();
        var attachment = $('#attachment').val();

        if(company_list.length <= 0){
            $('#msg_org').html('Please select company!');
            $("html, body").animate({ scrollTop: 0 }, "slow");
           // alert('Please select company!');
            return false;
        }
        return false;
      /!*  if(company_list.length <= 0 || subject.length <= 0 || letter_no.length <= 0 || attachment.length <= 0){
            $('.alert-danger').show();
            $('.msg').html('Please fill out all input field!');
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }else{
            $('#application-form').submit();
        }*!/

    })*/
    
$("input[name='application_format']").change(function() {
    window.location = $(this).val();
});


$('#company_list').change(function(){
    
    var company_id = $('#company_list').val();

    var company_details_list = {!! json_encode($company_details_list) !!}

    function company(object) { 

        return parseInt(object.id) === parseInt(company_id);

    }


    var company = company_details_list.find(company); 

    $('#phone').val(company.phone);

    $('#mobile').val(company.mobile);

    $('#address').val(company.address);

});


</script>
@stop 