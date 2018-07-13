@extends('user::layouts.login')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-sm">
                <div id="logo-login" class="light-version">
                    <img src="{{URl('/assets/img/logo.png')}}" alt="SOP" class="bgm_logo_img">    
                    
                    <h3>Recruitment Exam Management System</h3>

                    <h3>Bangladesh Computer Council</h3>

                </div>
                <br clear="all" />
            </div>
            <div class="hpanel">
                <div class="panel-body">
                          
                    {!! Form::open(['route' => 'post-user-login','id'=>'form_2','class'=>'default-form admin-login-form']) !!}
                        <div class="form-group">
                            <label class="control-label" for="username">Email Address<span class="red">*</span></label>
                            {!! Form::text('email', Input::old('email'), ['class' => 'form-control','required','placeholder'=>'Username or email','autofocus','title'=>'Enter Email Address']) !!}
                            {{-- <span class="help-block small">Your unique username/email to app</span> --}}
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password<span class="red">*</span></label>
                            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required'=>'required','title'=>'Enter Password']) !!}
                            {{-- <span class="help-block small">Your strong password</span> --}}
                        </div>

                        <div class="form-group">
                           {{--<div class="g-recaptcha pull-right" data-sitekey="{{$site_key}}"></div>--}}
                        </div>

                        <div class="clearfix"></div>
                

                        <div class="checkbox">
                            {{-- <input type="checkbox" class="i-checks" checked>
                            Remember login --}}
                            {{--<p>
                                <a style="margin-bottom: 10px;" href="{{ route('forget-password-view') }}" class="pull-right" style="text-decoration: underline">Forgot your password?</a>
                            </p>--}}
                            {{-- <p class="help-block small">(if this is a private computer)</p> --}}

                        </div>


                        <div class="text-right">

                            <button class="btn btn-success mt-23">Login</button>                            

                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
