@extends('user::layouts.login')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>FORGOT PASSWORD</h3>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    {!! Form::open(['route' => 'forget-password','id'=>'validate']) !!}
                    <div class="form-group">
                        <label class="control-label" for="username">Email Address</label>
                        {!! Form::email('email', null, ['class' => 'form-control','required','placeholder'=>'E-mail','title'=>'Enter Email Address']) !!}
                    </div>
                    <br>
                    <button class="btn btn-success btn-block">Reset Password</button>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop

<style>
    .required {
        color: orangered;
    }
</style>