<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">


<style>
    /*quick-edit*/


    .form-control:focus,
    #focusedInput {
        border: 1px solid #e2e2e4;
        box-shadow: none;
    }


    /*quick-edit*/

    .question-answer-block {
        max-width: 1350px;
        margin: 0 auto;
        padding: 0 50px;
    }


    .typing-exam-submit-button {
        display: none;
    }

    #original_text {
        max-width: 100%;
        height: 270px;
        background: #efefef;
        cursor: initial;
    }

    .radios label:nth-child(2) {
        margin-left: 10px;
    }

    input.exam_type {
        position: relative;
        top: 2.3px;
    }

    .green {
        color: green;
    }

    #test_check_box {
        display: none;
    }

    .form-group.image {

        background: url(http://localhost/exam_system/public/assets/img/k2.jpg);
        /* background-color: white; */
        background-size: 1133px;
        background-position-y: 500px;
        background-position-x: 460px;
        margin-bottom: 15px;
    }

    .form-group.image .row {
        background: #2681a3;
        opacity: .97;
    }

    .page-title {
        color: #fff;
        font-size: 18px;
        margin: 0;
        display: inline-block;
        padding: 10px;
        position: relative;
        /*left: 35px;*/
        /*left: 100px;*/
        margin-left: 185px;
    }

    .page-title span {
        position: absolute;
        right: -200px;
        top: 10px;
    }

    .form-group.image .btn,
    .submit-button {
        background: #333;
        color: #fff;
        border: none;
    }

    .form-group.image .btn:hover,
    .submit-button:hover {
        background: #111;
        transition: 0.1s;
    }


    .submit-button {
        background: #2a8cb1;
        color: #fff;
        border: none;
        margin-top: 20px;
    }

    .submit-button:hover {
        background: #237897;
        transition: 0.1s;
    }

    label {
        color: #18193c;
        font-size: 20px;
        font-weight: 500;
    }

    .radios {
        position: relative;
        max-width: 1380px;
        margin: 0 auto;
        text-align: center;
        padding: 0 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .radios span {
        color: #fff;
    }

    .time {
        color: #fff;
        font-size: 25px;
        display: inline-block;
        float: right;
    }


    .mt20 {
        margin-top: 20px;
    }

    .start-buttons {
        margin: 40px;
    }

    a.btn.btn-primary.btn-sm.start-button {
        margin: 0 10px;
        font-size: 16px;
        border-radius: 2px;
        /*font-weight: bold;*/
    }

    .btn-sm {
        font-size: 14px;
    }

    .alert-message {
        text-align: center;
        padding: 50px 0 40px;
        font-weight: 700;
        font-size: 20px;
    }

    @font-face {
        /*font-family: 'SolaimanLipi';
  src: url('http://localhost/exam_system/public/assets/fonts/SolaimanLipi.ttf')  format('truetype');
  font-family: 'NikoshBAN';
  src: url('http://localhost/exam_system/public/assets/fonts/NikoshBAN.ttf')  format('truetype');*/
    }

    .english-font {
        font-size: 16px;
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
    right: -100px;
}*/
</style>

{{-- {{$first_exam_type}} --}}

<div class="form-block">

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    @if (Session::has('danger'))
        <div class="alert alert-success">
            <p>{{ Session::get('danger') }}</p>
        </div>
    @endif

    <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">

            <?php
            if ($exam_type == 'bangla') {
                $font_size = 'form-control bangla-font';
            } else {
                $font_size = 'form-control english-font';
            }
            ?>



            @if (($first_exam_started && !$first_exam_completed) || ($last_exam_started && !$last_exam_completed))
                <div class="radios">

                    <span>Roll No: {{ $roll_no }}</span>
                    <h3 class="page-title text-center">RECRUITMENT EXAM MANAGEMENT SYSTEM V2</h3>
                    <span>Name: {{ $username }}</span>
                    <div class="time text-center time-block pull-right"></div>

                </div>
            @else
                <div class="radios" style="display:block;">

                    <h3 class="page-title text-center" style="margin-left:0;">RECRUITMENT EXAM MANAGEMENT SYSTEM V2</h3>

                </div>
            @endif






        </div>
    </div>


    @if (($first_exam_started && !$first_exam_completed) || ($last_exam_started && !$last_exam_completed))


        <div class="question-answer-block">

            {!! Form::open([
                'route' => ['submit-typing-exam', $exam_type],
                'id' => 'jq-validation-form',
                'class' => 'exam-form',
            ]) !!}

            <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">

                    <div class="">

                        {!! Form::textarea('original_text', $question, [
                            'id' => 'original_text',
                            'class' => $font_size,
                            'size' => '10x10',
                            'readonly',
                        ]) !!}

                    </div>


                </div>
            </div>


            <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">

                    <div>

                        <div style="text-align:center;">

                            {!! Form::label('answered_text', 'Type here:', ['class' => 'control-label', 'style' => 'float:left']) !!}

                            <div style="color:red;font-size:20px;display:none;;position:relative;left:-45px;"
                                class="alert-flash-message">You have 2 minutes remaining.</div>

                        </div>


                        {!! Form::textarea('answered_text', Input::old('answered_text'), [
                            'id' => 'answered_text',
                            'class' => $font_size,
                            'size' => '10x10',
                            'read-only',
                        ]) !!}

                    </div>

                </div>
            </div>


            <input type="hidden" name="status" id="status" class="form-control" value="active">


            <input type="hidden" name="qselection_typing_id" id="qselection_typing_id" class="form-control"
                value="">
            <input type="hidden" name="accuracy" id="accuracy" class="form-control" value="">
            <input type="hidden" name="wpm" id="wpm" class="form-control" value="">


            <div class="row">
                <div class="text-right">
                    {{-- add method to prevent submit --}}
                    {{-- {!! Form::submit('Submit', ['class' => 'btn btn-primary submit-button typing-exam-submit-button btn-sm','data-placement'=>'top', 'onclick'=>'submitForm(event)']) !!} --}}
                    {!! Form::submit('Submit', [
                        'class' => 'btn btn-primary submit-button typing-exam-submit-button btn-sm',
                        'data-placement' => 'top',
                    ]) !!}
                </div>
            </div>



            {!! Form::close() !!}

        </div>
    @else
        @if (($first_exam_started && !$first_exam_completed) || ($last_exam_started && !$last_exam_completed))
        @elseif(empty($first_exam_type))
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-12 bangla-font" id="start_instruction">

                        <div class="username-roll-no-block">Roll No: {{ $roll_no }}<br>Name: {{ $username }}
                        </div>
                        <div class="clearfix"></div>


                        <table style="max-width:1200px;margin:0 auto;" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <font size="+3"><i>নির্দেশনাবলীঃ</i></font><br>
                                </td>
                            </tr>
                            <tr style="height: 20px;">&nbsp;</tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ১. পরীক্ষা শুরুর পূর্বে মোবাইল ও অন্যান্য ইলেক্ট্রনিক্স ডিভাইস বন্ধ রাখুন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ২. ইংরেজী টাইপ করার জন্য ১০ (দশ) মিনিট সময় পাবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৩. টাইপ টেস্ট শুরু হলে আপনার মনিটরের ডানপাশে উপরের দিকে “Countdown Timer”
                                    দেখতে পারবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৪. নির্ধারিত টেক্সট এরিয়া ফিল্ড সিলেক্ট করে ইংরেজী টাইপ শুরু করুন।</td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৫. ইংরেজী টাইপ শেষ হলে “Submit English” বাটনে ক্লিক করুন। এতে আপনার টাইপ শেষ
                                    হয়েছে বলে গণ্য হবে। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৬. উত্তর সাবমিট চলাকালীন প্রগ্রেসবার দেখা যাবে। <span style="color: blue;">এই
                                        অবস্থায় অন্য কিছু (ক্লিক, রিফ্রেশ) না করে অপেক্ষা করুন। </span></td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৭. উত্তর সাবমিট শেষ হলে প্রশ্ন ও আপনার টাইপ করা উত্তর দেখতে পাবেন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৮. এই অবস্থায় এডিট করার সুযোগ নেই। বাংলা টাইপ শুরু করার জন্য “Go for Bangla”
                                    বাটনে ক্লিক করে নির্দেশাবলী অনুসরণ করুন। </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
            <div class='text-center start-buttons'>
                {{-- <a href="{{route('start-typing-exam','bangla')}}" type="submit" class="btn btn-primary btn-sm start-button">Start Bangla</a> --}}

                <a href="{{ route('start-typing-exam', 'english') }}" type="submit"
                    class="btn btn-primary btn-sm start-button">Start English</a>

                <div class="clearfix"></div>
            </div>
        @elseif($first_exam_type == 'bangla' && $first_exam_completed == 1)
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-12 bangla-font" id="start_instruction">

                        <div class="username-roll-no-block">Roll No: {{ $roll_no }}<br>Name: {{ $username }}
                        </div>
                        <div class="clearfix"></div>


                        <table style="max-width:1200px;margin:0 auto;" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <font size="+3"><i>নির্দেশনাবলীঃ</i></font><br>
                                </td>
                            </tr>
                            <tr style="height: 20px;">&nbsp;</tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ১. পরীক্ষা শুরুর পূর্বে মোবাইল ও অন্যান্য ইলেক্ট্রনিক্স ডিভাইস বন্ধ রাখুন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ২. ইংরেজী টাইপ করার জন্য ১০ (দশ) মিনিট সময় পাবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৩. টাইপ টেস্ট শুরু হলে আপনার মনিটরের ডানপাশে উপরের দিকে “Countdown Timer”
                                    দেখতে পারবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৪. নির্ধারিত টেক্সট এরিয়া ফিল্ড সিলেক্ট করে ইংরেজী টাইপ শুরু করুন।</td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৫. ইংরেজী টাইপ শেষ হলে “Submit English” বাটনে ক্লিক করুন। এতে আপনার টাইপ শেষ
                                    হয়েছে বলে গণ্য হবে। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৬. উত্তর সাবমিট চলাকালীন প্রগ্রেসবার দেখা যাবে। <span style="color: blue;">এই
                                        অবস্থায় অন্য কিছু (ক্লিক, রিফ্রেশ) না করে অপেক্ষা করুন। </span></td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৭. উত্তর সাবমিট শেষ হলে প্রশ্ন ও আপনার টাইপ করা উত্তর দেখতে পাবেন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৮. এই অবস্থায় এডিট করার সুযোগ নেই। বাংলা টাইপ শুরু করার জন্য “Go for Bangla”
                                    বাটনে ক্লিক করে নির্দেশাবলী অনুসরণ করুন। </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
            <div class='text-center start-buttons'>

                <a href="{{ route('start-typing-exam', 'english') }}" type="submit"
                    class="btn btn-primary btn-sm start-button">Start English</a>

            </div>
        @elseif($first_exam_type == 'english' && $first_exam_completed == 1)
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-12 bangla-font" id="start_instruction">

                        <div class="username-roll-no-block">Roll No: {{ $roll_no }}<br>Name: {{ $username }}
                        </div>
                        <div class="clearfix"></div>


                        <table style="max-width:1200px;margin:0 auto;" cellpadding="0" cellspacing="0"
                            border="0">
                            <tr>
                                <td>
                                    <font size="+3"><i>নির্দেশনাবলীঃ</i></font><br>
                                </td>
                            </tr>
                            <tr style="height: 20px;">&nbsp;</tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ১. পরীক্ষা শুরুর পূর্বে মোবাইল ও অন্যান্য ইলেক্ট্রনিক্স ডিভাইস বন্ধ রাখুন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ২. বাংলা টাইপ করার জন্য ১০ (দশ) মিনিট সময় পাবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৩. বাংলায় লিখার জন্য "বিজয় কীবোর্ড" হলে "Ctrl+Alt+U" অথবা "অভ্র কীবোর্ড" হলে "F12" দিয়ে ইউনিকোড লেয়াউট সিলেক্ট করুন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৪. টাইপ টেস্ট শুরু হলে আপনার মনিটরের ডানপাশে উপরের দিকে “Countdown Timer”
                                    দেখতে পারবেন। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৫. নির্ধারিত টেক্সট এরিয়া ফিল্ড সিলেক্ট করে বাংলা টাইপ শুরু করুন।</td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৬. বাংলা টাইপ শেষ হলে “Submit Bangla” বাটনে ক্লিক করুন। এতে আপনার টাইপ শেষ
                                    হয়েছে বলে গণ্য হবে। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৭. উত্তর সাবমিট চলাকালীন প্রগ্রেসবার দেখা যাবে। <span
                                        style="color: blue;">এই অবস্থায় অন্য কিছু (ক্লিক, রিফ্রেশ) না করে অপেক্ষা করুন।
                                    </span></td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ৮. উত্তর সাবমিট শেষ হলে প্রশ্ন ও আপনার টাইপ করা উত্তর দেখতে পাবেন।
                                </td>
                            </tr>
                            <tr style="font-size: 22px!important; color: blue;">
                                <td>&nbsp; ৯. এই অবস্থায় এডিট করার সুযোগ নেই। “Go for Finish” বাটনে ক্লিক করে পরবর্তী
                                    পেজে যান। </td>
                            </tr>
                            <tr style="font-size: 22px!important;">
                                <td>&nbsp; ১০. “Log Out” বাটনে ক্লিক করে পরীক্ষা শেষ করুন। </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
            <div class='text-center start-buttons'>

                <a href="{{ route('start-typing-exam', 'bangla') }}" type="submit"
                    class="btn btn-primary btn-sm start-button">Start Bangla</a>

            </div>
        @endif

    @endif
</div>

<div id="test_check_box"></div>



<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span style="color: #A54A7B" class="user-guideline"
                        data-content="<em>Must Fill <b>Required</b> Field. <b>*</b> Put cursor on input field for more informations</em>"></span>
                </h4>
            </div>
            <div class="modal-body alert-body">

                <div class="alert-message" style="color:red">You have 2 minutes remaining.</div>
                <div class="form-margin-btn text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-3.2.0.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/cookie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/samples/js/sample.js') }}"></script>
{{-- <script type="text/javascript" src="http://localhost/exam_system/modules/exam/views/exams/typingtest.js"></script> --}}



<script>
    $(document).ready(function() {

        setTimeout(function() {

            $('#answered_text').focus();

        }, 300);


        $("form").submit(function(e) {

            $(this).submit(function() {

                return false;
            });

            return true;

        });



        $(".start-button").one("click", function() {
            $(this).click(function() {
                return false;
            });
        });


    });
    //Disable Back Button ::

    window.history.forward();

    function noBack() {
        window.history.forward();
    }


    // $('#original_text').bind('cut copy paste drop', function(e) {

    //     return false;

    // });


    // $('#answered_text').bind('cut copy paste drop', function(e) {

    //     return false;

    // });

    var answered_text_length = 0;

    var answered_text = '';

    // $('#answered_text').on('keypress', function(event) {


    //   var diff = $('#answered_text').val().split('').length - answered_text_length;

    //   console.log(diff);

    //   var fff = '';



    //   if(diff > 3){

    //     $('#answered_text').val(answered_text);
    //   }


    //   answered_text = $('#answered_text').val();

    //   answered_text_length = $('#answered_text').val().split('').length;



    // });





    var first_exam_started = {!! json_encode($first_exam_started) !!};

    var first_exam_completed = {!! json_encode($first_exam_completed) !!};

    var last_exam_started = {!! json_encode($last_exam_started) !!};

    var last_exam_completed = {!! json_encode($last_exam_completed) !!};

    var typing_exam_default_time = {!! json_encode($typing_exam_time) !!};


    if ((!first_exam_started && !last_exam_started) || (first_exam_completed && !last_exam_started)) {

        Cookies.remove('typing_exam_time');
        Cookies.remove('answered_text');
        Cookies.remove('typing_test_alerted');

    }



    if ((first_exam_started && !first_exam_completed) || (last_exam_started && !last_exam_completed)) {


        $('.typing-exam-submit-button').show();

        var typing_exam_time = Cookies.get('typing_exam_time');

        var typing_exam_time = Cookies.get('typing_exam_time');

        var answered_text = Cookies.get('answered_text');


        if (typing_exam_time > 0) {

            var minute_second = convert_to_minute_second(typing_exam_time);

            $('.time').text(minute_second);

            $('#answered_text').text(answered_text);

            set_clock(typing_exam_time * 1000);

        }

        if (typing_exam_time == undefined) {

            set_clock(typing_exam_default_time * 60 * 1000);

        }

        if (typing_exam_time <= 0) {

            $('#answered_text').text(answered_text);

            console.log(typing_exam_default_time);

            $('.time').text('00:00');

            $('#answered_text').on('keypress', function(e) {

                return false;

            });

            $('#answered_text').attr('readonly', 'readonly');

        }


    } else {

        $('.time').text(typing_exam_default_time + ':' + '00');

    }






    var first_exam_type = {!! json_encode($first_exam_type) !!};



    if (first_exam_type == 'english') {

        $("#exam_type_bangla").attr('checked', 'checked');

        $("#exam_type_english").attr('disabled', 'disabled');


    } else if (first_exam_type == 'bangla') {

        $("#exam_type_english").attr('checked', 'checked');

        $("#exam_type_bangla").attr('disabled', 'disabled');

    }



    // $('.exam-form').submit(function(e) {

    // e.preventDefault();


    // $('#answered_text').trigger('keypress');

    // stopinterval();

    // });




    var time = 10;


    function stopinterval() {


        // var ttt = $('#test_check_box').diffString(answered_text);
        // question = question.split(/\s+/);
        // answer = answer.split(/\s+/);



        //   var question = createGroupedArray(question, 5);

        //   var answer = createGroupedArray(answer, 5);
        //   console.log(answer);

        //   $(answer).each(function(index, el) {

        //     diffString(question[index].join(' '), el.join(' '));

        //   });


        //   diffString(question, answer);

        // //console.log(correct_words + " " + ins);




        // del = del.length;


        // if(ins[0] == 0){
        //   ins = 0;
        // }else{
        //   ins = ins.length;
        // }

        // correct_words = correct_words.length;

        // var total = correct_words + ins;


        // var accuracy = correct_words/total*100;

        // var wpm = total/time;

        //  console.log($('#test_check_box').text().split(' '));
        //  console.log(ins);
        //  console.log(del);
        //  console.log(correct_words);
        //  console.log(total);
        //  console.log(accuracy);

        // $('#wpm').val(wpm);

        // if(! isNaN(accuracy)){
        //   $('#accuracy').val(accuracy);
        // }else{
        //   $('#accuracy').val(0);
        // }


        // if(! isNaN(wpm)){
        //   $('#wpm').val(wpm);
        // }else{
        //   $('#wpm').val(0);
        // }

        clearInterval(intervalId);

        // $('.exam-form')[0].submit();
        return false;

    }





    function alert_message() {

        var typing_test_alerted = Cookies.get('typing_test_alerted');

        if (!typing_test_alerted) {

            Cookies.set('typing_test_alerted', 1, {
                expires: 1
            });

            // $("#addData").modal('show');
            $(".alert-flash-message").show();


            function blinker() {
                $('.alert-flash-message').fadeOut(500);
                $('.alert-flash-message').fadeIn(500);
            }

            var flash_message = setInterval(blinker, 1000);


            setTimeout(function() {

                // $("#addData").modal('hide');
                clearInterval(flash_message);
                $(".alert-flash-message").hide();


            }, 9500);

            setTimeout(function() {

                $(".alert-flash-message").hide();

            }, 10000);

        }
    }



    function convert_to_minute_second(remainingTime) {

        var minutes = Math.floor(remainingTime / 60);
        var seconds = remainingTime % 60;

        if (minutes < 10) {
            minutes = "0" + minutes;
        }

        if (seconds < 10) {
            seconds = "0" + seconds;
        }

        return minutes + ':' + seconds;

    }



    function set_clock(typing_exam_time) {


        var x = typing_exam_time;

        var beforeTime = +new Date();

        intervalId = window.setInterval(function() {

            var diff = (+new Date() - beforeTime);

            var remainingTime = x - diff;

            remainingTime = Math.ceil(remainingTime / 1000);



            if (diff >= 500) {

                Cookies.set('typing_exam_time', remainingTime, {
                    expires: 1
                });
                var answered_text = $("#answered_text").val();
                Cookies.set('answered_text', answered_text, {
                    expires: 1
                });

                var minute_second = convert_to_minute_second(remainingTime);

                $('.time').text(minute_second);

            }


            if (remainingTime / 60 <= 2) {

                alert_message();

            }

            if (remainingTime <= 0) {

                stopinterval(); // stop the interval

                $('#answered_text').on('keypress', function(e) {

                    return false;

                });

                $('#answered_text').attr('readonly', 'readonly');

            }

        }, 20);



    }
</script>
