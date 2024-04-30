<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


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

        <div class="page-header text-center">
            <h1>Submitted Answer Script (Only for View)</h1>
        </div>

        <div class="question-answer-block">

            {!! Form::open([
                'route' => ['submit-typing-exam-bn-with-calculation', $exam_type],
                'id' => 'jq-validation-form',
                'class' => 'exam-form',
            ]) !!}

            <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">

                    <div class="">

                        {!! Form::label('original_text', 'Question:', [
                            'class' => 'control-label',
                            'style' => 'float:left; color: blue',
                        ]) !!}

                        {!! Form::textarea('original_text', $question, [
                            'id' => 'original_text_field',
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

                            {!! Form::label('answered_text', 'Answer:', ['class' => 'control-label', 'style' => 'float:left; color: blue']) !!}

                            <div style="color:red;font-size:20px;display:none;;position:relative;left:-45px;"
                                class="alert-flash-message">You have 2 minutes remaining.</div>

                        </div>


                        {!! Form::textarea('answered_text', $request['answered_text'], [
                            'id' => 'answered_text_field',
                            'class' => $font_size,
                            'size' => '10x10',
                            'readonly',
                        ]) !!}

                    </div>

                </div>
            </div>


            <div id="progressbar"></div>


            <div class="row">
                <div class="text-right">
                    {{-- add method to prevent submit --}}
                    {!! Form::submit('Go for Finish', [
                        'class' => 'btn btn-primary submit-button typing-exam-submit-button btn-sm',
                        'data-placement' => 'top',
                        'onclick' => 'calculate(event)',
                    ]) !!}
                </div>
            </div>



            {!! Form::close() !!}

        </div>
    @else
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-4"></div>
                <div class="col-sm-12 bangla-font" id="start_instruction">

                    <div class="username-roll-no-block">Roll No: {{ $roll_no }}<br>Name: {{ $username }}</div>
                    <div class="clearfix"></div>


                    <table style="max-width:1200px;margin:0 auto;" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <font size="+3"><b>নিম্নলিখিত নির্দেশনাবলী পরীক্ষা শুরু করার পূর্বে পড়ুনঃ</b>
                                </font><br>
                            </td>
                        </tr>
                        <tr style="height: 20px;">&nbsp;</tr>
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ১. পরীক্ষা শুরুর পূর্বে মোবাইল ফোন বন্ধ রাখুন। </b></td>
                        </tr>
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ২. বাংলা ও ইংরেজী উভয় টাইপিং এর জন্য ১০ (দশ) মিনিট করে সময় পাবেন। </b></td>
                        </tr>
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ৩. টাইপিং টেস্ট শুরু হলে আপনার মনিটরের ডানপাশে উপরের দিকে “Countdown Timer”
                                    দেখতে পারবেন। </b></td>
                        </tr>
                        {{-- <tr style="font-size: 22px!important;"><td><b>&nbsp; ৪.    ইংরেজী টাইপিং এর জন্য পূনরায় “Ctrl+Alt+B” দিয়ে ইংরেজী কিবোর্ড নির্বাচন করুন। </b></td></tr>
                <tr style="font-size: 22px!important;"><td><b>&nbsp; ৫.    বাংলা অথবা ইংরেজী যে কোন ০১(একটি) বাটনে “ক্লিক” করে টাইপিং শুরু করুন। </b></td></tr> --}}
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ৪. নির্ধারিত বক্স নির্বাচন করে ইংরেজী টাইপিং শুরু করুন। ইংরেজী টাইপিং সমাপ্ত
                                    হলে “Submit”
                                    বাটনে ক্লিক করুন। </b></td>
                        </tr>
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ৫. এরপর বাংলা টাইপিং এর জন্য “Ctrl+Alt+B” দিয়ে কিবোর্ড নির্বাচন করুন।
                                    নির্ধারিত বক্স বাংলা
                                    টাইপিং শুরু করুন। </b></td>
                        </tr>
                        <tr style="font-size: 22px!important;">
                            <td><b>&nbsp; ৬. বাংলা টাইপ শেষ হলে “Submit” বাটনে ক্লিক করে পরীক্ষা শেষ করুন। </b></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>


        @if (($first_exam_started && !$first_exam_completed) || ($last_exam_started && !$last_exam_completed))
        @elseif(empty($first_exam_type))
            <div class='text-center start-buttons'>
                {{-- <a href="{{route('start-typing-exam','bangla')}}" type="submit" class="btn btn-primary btn-sm start-button">Start Bangla</a> --}}

                <a href="{{ route('start-typing-exam', 'english') }}" type="submit"
                    class="btn btn-primary btn-sm start-button">Start English</a>

                <div class="clearfix"></div>
            </div>
        @elseif($first_exam_type == 'bangla' && $first_exam_completed == 1)
            <div class='text-center start-buttons'>

                <a href="{{ route('start-typing-exam', 'english') }}" type="submit"
                    class="btn btn-primary btn-sm start-button">Start English</a>

            </div>
        @elseif($first_exam_type == 'english' && $first_exam_completed == 1)
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
<script src="{{ URL::asset('assets/dist/diff.js') }}"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script>
    $('.typing-exam-submit-button').on("click", function() {
        $('#progressbar').progressbar({
            value: false
        });
        $('.typing-exam-submit-button').hide();
    });
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function() {
        history.pushState(null, null, document.URL);
    });



    function calculate(event) {
        event.preventDefault()
        // Get the form element
        const form = document.getElementById("jq-validation-form");
        // Bind the FormData object and the form element
        const FD = new FormData(form);

        // Run your JavaScript method here
        const question = document.getElementById('original_text_field').textContent,
            answer = document.getElementById('answered_text_field').textContent;

        let totalGivenCharacters = question.length,
            typedCharacters = answer.length,
            correctedCharacters = null,
            wrongCharacters = null;

        let createElementP = document.createElement('p');

        const diffWords = Diff.diffWords(question, answer);
        diffWords.forEach((part) => {
            if ((part.added === undefined) && (part.removed === undefined)) {
                correctedCharacters += part.value.length;
            }

            // white + goldenrod for additions, white + tomato for deletions & silver + snow for common parts
            const color = part.added ? "white" : part.removed ? "white" : "silver";
            const backgroundColor = part.added ? "goldenrod" : part.removed ? "tomato" : "snow";

            span = document.createElement('span');
            spanRemoved = document.createElement('span');
            span.style.color = color;
            spanRemoved.style.color = color;
            span.style.backgroundColor = backgroundColor;
            spanRemoved.style.backgroundColor = backgroundColor;
            if (part.removed) {
                spanRemoved.appendChild(document.createTextNode(part.value));
            } else {
                span.appendChild(document.createTextNode(part.value));
                createElementP.appendChild(span);
            }
        });
        wrongCharacters = typedCharacters - correctedCharacters;

        // Push our data into our FormData object
        FD.append('correctedCharacters', correctedCharacters);
        FD.append('wrongCharacters', wrongCharacters);
        FD.append('totalGivenCharacters', totalGivenCharacters);
        FD.append('typedCharacters', typedCharacters);
        FD.append('process_text', createElementP.innerHTML);

        for (const [key, value] of FD) {
            //console.log(`${key}: ${value}`);
        }

        // Alternatively, redirect the user to a server-side script to process the form data
        // Send the form data using Fetch API
        fetch(form.action, {
                method: 'POST',
                body: FD,
            })
            .then(response => response.json())
            .then(data => {
                // Work with the returned JSON data
                let redirectUrl = '/exam/typing-exams';
                if (data.success) {
                    window.location.assign(redirectUrl);
                }
            })
            .catch(function(error) {
                // Handle the error
                //console.error(error);
            });
    }
</script>
