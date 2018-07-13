@extends('user::layouts.login')

@section('content')

<style>
    
.add-on {
    top: -8px;
}

.icon-calendar{
    line-height: 2;
}

.btn-block {
    margin: 15px 0;
}

.btn.calender-button {
    padding: 0px 10px !important;
    position: relative;
    top: 10px;
}

</style>


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
                <div>
                    <br>
                    {!! Form::open(['route' => 'post-candidate-login','id'=>'form_2','class'=>'default-form candidate-login-form']) !!}
                        <div class="col-sm-12">
                            <label class="control-label" for="username">Exam Code</label>
                             <small class="required">*</small>
                            {!! Form::text('exam_code', Input::old('exam_code'), ['class' => 'form-control','required','placeholder'=>'Enter Candidate Exam Code','autofocus']) !!}
                        </div>

                        <div class="col-sm-12">
                            <label class="control-label" for="username">Candidate Roll Number</label>
                             <small class="required">*</small>
                            {!! Form::text('roll_no', Input::old('roll_no'), ['class' => 'form-control','required','placeholder'=>'Enter Candidate Roll Number','autofocus']) !!}
                        </div>

                      {{--   <div class="col-sm-12">
                            <label class="control-label" for="password">Date of Birth</label>
                             <small class="required">*</small>
                            {!! Form::text('dob', Input::old('dob'), ['id'=>'dob', 'class' => 'form-control datepicker','required','readonly','placeholder'=>'Enter Candidate Date of Birth']) !!}
                            <span class="input-group-btn add-on">
                            <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                            </span>
                        </div> --}}

                        <div class="clearfix"></div>

                        <div class="col-sm-12 text-right">
                            <button class="btn btn-success mt-23">Login</button>
                        </div>

                        <div class="clearfix"></div>

                    {!! Form::close() !!}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop

