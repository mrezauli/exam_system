<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style_adnan.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

<style>
    
.select2-hidden-accessible {
    top: 0;
    left: 180px;
}



</style>


<div class="container organization-register-page">


<div class="clearfix"></div>
    <div class="row">

    <div class="error-block">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        @if(Session::has('danger'))
        <div class="alert alert-danger">
            <p>{{ Session::get('danger') }}</p>
        </div>
        @endif
        
        @if(Session::has('message'))
        <div class="alert alert-success">
            <p>{{ Session::get('message') }}</p>
        </div>
        @endif
    </div>



    <div class="form-header organization-login-form-header">

    <div class="text-center m-b-sm">
        <div id="logo-login" class="light-version">
            <img src="{{URl('/assets/img/logo.png')}}" alt="SOP" class="bgm_logo_img">    
            
            <h3>Recruitment Exam Management System</h3>

            <h3>Bangladesh Computer Council</h3>

        </div>

    </div>

    <a class="forgot-password hidden" href="{{ route('forget-password-view') }}">Forgot password?</a>


    </div>







    {!! Form::open(['route' => 'store-organization-user','id' => 'jq-validation-form','class' => 'organization-user-form organization-user-registration-form default-form','enctype'=>"multipart/form-data"]) !!}
    <div class="row form-header organization-register-form-header" style="margin-left: -18px;margin-right: -18px;">Organization Registration</div>
        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6 company_div">
                    <label>Organization Name:<span class="red">*</span></label>
                    @if(count($company_list)>0)
                    {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                    @else
                    {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                    @endif
                </div>
                <div class="col-sm-6">
                    {!! Form::label('username', 'First Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::text('username',Input::old('username'),['class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter First Name']) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('middle_name',Input::old('middle_name'),['class' => 'form-control','placeholder'=>'Middle Name','autofocus', 'title'=>'Enter Middle Name']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::text('last_name',Input::old('last_name'),['class' => 'form-control','placeholder'=>'Last Name','autofocus', 'required', 'title'=>'Enter Last Name']) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
            <div class="col-sm-6 pull-right">
                    {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                    <small class="required">*(Organization Email Preffered)</small>
                    {!! Form::email('email',Input::old('email'),['class' => 'form-control','placeholder'=>'Email Address','required', 'title'=>'Enter User Email Address']) !!}
                </div>
            </div>
        </div>

        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::password('password',['id'=>'user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter User Password','minlength'=>'3']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('confirm_password', 'Confirm Password') !!}
                     <small class="required">*</small>
                    {!! Form::password('re_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','required','id'=>'re-password','name'=>'re_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.','minlength'=>'3']) !!}
                    <span id='show-message'></span>

                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-12 mt20">
                    <div class="g-recaptcha pull-right" data-sitekey="{{$site_key}}"></div>
                </div>
            </div>
        </div>


            <input type="hidden" name="status" id="status" class="form-control" value="active">


            <div class="form-margin-btn text-right mt40">

                {!! Form::submit('Register', ['class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}

                <div style="font-size:85%" class="text-left">
                    Already registered?
                    <a href="{{route('login')}}" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                        <span>Login</span>
                    </a>
                </div>

            </div>

            {!! Form::close() !!}

    </div>
</div>
</div>

<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/select2.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>



$(document).ready(function() {

    /* For dropdown searching */

    $(".js-select").select2();

    $('.js-select').closest('form').find('input.btn').click(function(event) {

     setTimeout(function() {

            $("select").removeAttr('required');
            $("select").attr('required','required');

     }, 1000);
           
        
    });


});



    function validation() {
        $('#re-password').on('keyup', function () {
            if ($(this).val() == $('#user-password').val()) {

                $('#show-message').html('');
                document.getElementById("btn-disabled").disabled = false;
                return false;
            }
            else $('#show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("btn-disabled").disabled = true;
        });
    }


    $(".company_div select option:first").removeAttr('selected');

</script>
