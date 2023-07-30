<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.<div class="exam-page-wrapper container">

<style>

    #original_text {
        max-width: 100%;
        height: 200px;
        background: #efefef;
        cursor: initial;
    }

    .radios label:nth-child(2){
        margin-left: 10px;
    }

    input.exam_type{
        position: relative;
        top: 2.3px;
    }

    .green{
        color:green;
    }

    #test_check_box{
        display: none;
    }

    .form-group.image{

        background: url(http://localhost/exam_system/public/assets/img/k2.jpg);
        /* background-color: white; */
        background-size: 1133px;
        background-position-y: 500px;
        background-position-x: 460px;
        margin-bottom: 30px;
    }

    .form-group.image .row{
        background: #2681a3;
        opacity: .97;
    }

    .page-title {
        color: #fff;
        font-size: 18px;
        margin: 10px;
        position: relative;
    }

    .page-title span {
        position: absolute;
        right: 70px;
    }

    .form-group.image .btn, .submit-button{
        background: #333;
        color:#fff;
        border: none;
    }

    .form-group.image .btn:hover,  .submit-button:hover{
        background: #111;
        transition: 0.1s;
    }

    .start-buttons{
      margin: 40px;
    }

    .start-buttons .start-button {
        padding: 6px 10px;
        font-size: 16px;
        border-radius: 2px;
    }

    .start-buttons .start-button strong{
        font-weight: 500;
    }


    .submit-button{
        background: #2a8cb1;
        color:#fff;
        border: none;
    }

    .submit-button:hover{
        background: #237897;
        transition: 0.1s;
    }

    label {
        color: #18193c;
        font-size: 20px;
        font-weight: 500;
    }

    .time{
        color: #18193c;
        font-size: 30px;
        display: inline-block;
        position: relative;
        left: 45.7%;
        margin-bottom: 20px;
    }

    .btn-xs {
        padding: 10px 20px;
        font-size: 20px;
        border-radius: 10px;
    }

    .username-roll-no-block {
        float: right;
        margin-right: 20px;
        font-size: 14px;
        border: 1px solid #000;
        padding: 10px 15px;
        color: #000;
    }

    /*table {
        position: relative;
        right: -75px;
    }*/


</style>

<?php

$user = Auth::user();

$roll_no = $user->roll_no;
$username = $user->username;

?>

<div class="form-block">
    <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 radios">
                <h3 class="page-title text-center">RECRUITMENT EXAM MANAGEMENT SYSTEM V2</h3>

            </div>
        </div>
    </div>

    <!--<div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4"></div>
            <div class="col-sm-5" id="all_exam_button" style="display: none">
                {{--@if(isset($apt_test_question))
                    @foreach($apt_test_question as $values)
                        <?php
                            if($values->question_type == 'word'){$route = 'word-answer';}
                            elseif($values->question_type == 'excel'){$route = 'excel-answer';}
                            else{$route = 'ppt-answer';}
                        ?>
                        <a class="btn btn-primary btn-xs" href="{{ route($route, $values->id) }}" data-placement="top" data-content="view"><strong>Question ({{$values->question_type}})</strong></a>
                    @endforeach
                @endif--}}
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>-->

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4"></div>
            <div class="col-sm-12" id="start_instruction">

        <div class="username-roll-no-block">Roll No: {{$roll_no}}<br>Name: {{$username}}</div>

        <div class="clearfix"></div>

                <table style="max-width:1200px;margin:0 auto;" cellpadding="0" cellspacing="0" border="0">
                <tr><td><font size="+3"><b>নিম্নলিখিত নির্দেশনাবলী পরীক্ষা শুরু করার পূর্বে পড়ুনঃ</b></font><br></td></tr>
                <tr style="height: 20px;">&nbsp;</tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ১.    পরীক্ষা শুরুর পূর্বে মোবাইল ফোন বন্ধ রাখুন। </b></td></tr>
                <!-- <tr style="font-size: 22px!important;"><td><b>&nbsp; ২.    আ্যাপটিচিইট টেস্টের জন্য সর্বমোট ৩০ (ত্রিশ) মিনিট সময় পাবেন। </b></td></tr>-->
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ২.    পরীক্ষা শুরু হলে আপনি মনিটরের উপরে “Time Count-Down” দেখতে পারবেন। </b></td></tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ৩.    প্রতিটি প্রশ্নপত্রে আলাদা ক্লিক করে ডাউনলোড করুন এবং প্রশ্নপত্র আপনার নামে “Download” ফোল্ডারে “Automatically Save” হবে। </b></td></tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ৪.    এরপর আপনি “Download” ফোল্ডার অথবা “নিচের স্কীনে ক্লিক করে” আপনার নির্ধারিত ফাইলগুলো “Open” করে উক্ত ফাইলে উত্তর লিখতে শুরু করুন। </b></td></tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ৫.    উত্তরপত্র সম্পন্ন হলে নির্ধারিত সময়ের পূর্বেই “সব উত্তরপত্র” একত্রে নিচের স্কীনের মাধ্যমে আপলোডে করে “Submit” বাটনে ক্লিক করুন। </b></td></tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ৬.    নির্ধারিত সময়ের মধ্যে “সব উত্তরপত্র” একত্রে আপলোডে করতে ব্যর্থ হলে পরবর্তী স্কীনে আপলোড করার জন্য আরও ০৫ (পাঁচ) মিনিট সুযোগ পাবেন। উক্ত সময়ে “সব উত্তরপত্র” একত্রে আপলোড করে “Submit” বাটনে ক্লিক করে পরীক্ষা সমাপ্ত করুন। </b></td></tr>
            </table>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>

    <div class='text-center start-buttons'>

      <a class="btn btn-primary btn-lg start-button" href="{{ route('aptitude-question') }}" data-placement="top" data-content="view"><strong>Start Examination</strong></a>

    </div>



</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/samples/js/sample.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/typingtest.js') }}"></script>



<script>



    //Disabled Back Button ::

    window.history.forward();
    function noBack() { window.history.forward(); }


    //Exam Start


    /*$('.start-button').click(function(event) {

        $('#all_exam_button').show();
        $('.start-button').css('display', 'none');

        $('#start_instruction').show();


    });*/

</script>
