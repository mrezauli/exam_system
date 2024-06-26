<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title> {{isset($pageTitle)?$pageTitle:'User System'}} </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.ico') }}">

    <!-- Vendor styles -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/css/metisMenu.css" />
    <link rel="stylesheet" href="../assets/css/animate.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../assets/css/helper.css" />
    <link rel="stylesheet" href="../assets/css/style.css">--}}
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('assets/css/metisMenu.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('assets/css/pe-icon-7-stroke.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('assets/css/helper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" >

</head>
<body class="blank">

<!-- Simple splash screen-->
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>



<div class="register-container">
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{--set some message after action--}}
    @if (Session::has('message'))
        <div class="alert alert-success">{{Session::get("message")}}</div>

    @elseif(Session::has('error'))
        <div class="alert alert-warning">{{Session::get("error")}}</div>

    @elseif(Session::has('info'))
        <div class="alert alert-info">{{Session::get("info")}}</div>

    @elseif(Session::has('danger'))
        <div class="alert alert-danger">{{Session::get("danger")}}</div>
    @endif

        <div class="row">
            <div class="col-md-12">
                <div class="text-center m-b-md">
                    <h3><b>Forgot Password</b></h3>

                </div>
                <div class="hpanel">
                    <div class="panel-body">
                        <br>
                        {!! Form::open(['route' => 'user-save-new-password','id'=>'forgot-password-validation']) !!}
                        {!! Form::hidden('id', $id, array('class'=>'form-control')) !!}
                        <div class="row">

                            <div class="form-group col-lg-12">
                                <label>Password</label>
                                {!! Form::password('password',  array('id'=>'forgot-password','class'=>'form-control','required','name'=>'password','placeholder'=>'Password')) !!}
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Repeat Password</label>
                                {!! Form::password('confirm_password', array('id'=>'re-forgot-password','class'=>'form-control','required','name'=>'confirm_password','placeholder'=>'Confirm-password','onkeyup'=>"password_validation()")) !!}
                                <span id='er-show-msg'></span>
                            </div>

                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success">Submit</button>
                            <a href="{{route('admin')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        {{--<div class="col-md-12 text-center">
            <strong>HOMER</strong> - AngularJS Responsive WebApp <br/> 2015 Copyright Company Name
        </div>--}}
    </div>
</div>


<!-- Vendor scripts -->
{{--<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>--}}

<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>

{{--<script src="assets/js/jquery.flot.js"></script>--}}
{{--<script src="assets/js/jquery.flot.resize.js"></script>--}}
{{--<script src="assets/js/jquery.flot.pie.js"></script>
<script src="assets/js/curvedLines.js"></script>
<script src="assets/js/spline.index.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/icheck.min.js"></script>
<script src="assets/js/jquery.peity.min.js"></script>
<script src="assets/js/index.js"></script>
<script src="../assets/js/validation.js"></script>--}}
<!-- App scripts -->
{{--<script src="assets/js/homer.js"></script>
<script src="assets/js/charts.js"></script>--}}


<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.flot.pie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/curvedLines.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/spline.index.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/metisMenu.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.peity.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/index.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/validation.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/homer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/charts.js') }}"></script>



<script>

    //document.onload = function() {
    $(function () {
        $("#forgot-password-validation").validate({
            rules: {
                name: {
                    required: true,
                },
                password: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                max: {
                    required: true,
                    maxlength: 4
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#forgot-password-validation").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
            errorPlacement: function (error, element) {
                $(element)
                        .closest("form")
                        .find("label[for='" + element.attr("id") + "']")
                        .append(error);
            },
            errorElement: "span",
        });
    });

</script>

<script type="text/javascript">

    function password_validation() {

        $('#re-forgot-password').on('keyup', function () {
            if ($(this).val() == $('#forgot-password').val()) {

                $('#er-show-msg').html('');

            }
            else $('#er-show-msg').html('confirm password do not match with new password,please check.').css('color', 'red');

        });
    }

</script>
<style>
    .required {
        color: orangered;
    }
</style>
</body>
</html>