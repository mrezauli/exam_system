<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/style_adnan.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.ico') }}">

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


<div class=" organization-login-form-block" id="form-block">


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

    {!! Form::open(['route' => 'post-organization-user-login','id' => 'jq-validation-form','class' => 'organization-user-form default-form','enctype'=>"multipart/form-data"]) !!}

                 

        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 company_div">
                    <label>Organization Name<span class="red">*</span></label>
                    @if(count($company_list)>0)
                    {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control js-select','required']) !!}
                    @else
                    {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                    @endif
                </div>               
            </div>
        </div>



        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <label>Email<span class="red">*</span></label>
                    {!! Form::text('email', Input::old('email')) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <label>Password<span class="red">*</span></label>
                    {!! Form::password('password',['id'=>'user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter User Password','minlength'=>'3']) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 mt20">
                    <div class="g-recaptcha pull-right" data-sitekey="{{$site_key}}"></div>
                </div>
            </div>
        </div>

        

        <input type="hidden" name="status" id="status" class="form-control" value="active">

        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 text-right">
                    {!! Form::submit('Login', ['class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}

                    <div class="text-left" style="font-size:85%">
                        Don't have an account?
                        <a href="{{route('registration')}}">
                            <span>Sign Up Here</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

            {!! Form::close() !!}

        </div>
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

    setTimeout(function() {

        $('.form-block').css('max-width', '507px');

    }, 10);

    setTimeout(function() {

        $('.form-block').css('max-width', '507.7px');

    }, 10);


});
    

</script>