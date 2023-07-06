<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style_adnan.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.ico') }}">

<style>
    .content {
        text-align: center!important;
        display: inline-block;
    }
    .title {
        font-size: 25px;
        font-weight: bold;
        color: red;
    }

    .mt-50{
        width: 100px!important;
        font-size: 20px!important;
        font-weight: bold!important;
    }


</style>

<div class="container organization-register-page">


    <div class="clearfix"></div>
    <div class="row">
        <div class=" organization-login-form-block" id="form-block">
            <div class="form-header organization-login-form-header">
                <div class="text-center m-b-sm">
                    <div id="logo-login" class="light-version">
                        <img src="{{URl('/assets/img/logo.png')}}" alt="SOP" class="bgm_logo_img">
                        <h3>Recruitment Exam Management System V2</h3>
                        <h3>Bangladesh Computer Council</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div>
            <div class="content" style="width: 100%">
                <div class="title">You Are Typing Wrong URL, Click Back Button </div>
                <div class="title">OR, Type Right URL !! </div>
                <div class="title"><a href="{{URL('/')}}" class="btn btn-success mt-50" data-placement="top">Back</a></div>
            </div>
        </div>
    </div>

</div>

