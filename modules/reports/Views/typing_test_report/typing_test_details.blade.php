@extends('admin::layouts.master')
@section('sidebar')
    @parent
    @include('admin::layouts.sidebar')
@stop


@section('content')

    <div class="inner-wrapper report-details-page task-detail-page">
        <div class="panel-heading" id="rep_btn">
            <span class="panel-title">{{ $page_title }}</span>

            <a href="#" class="btn btn-primary btn-sm print pull-right">Print</a>


            {{--             <a href="{{ route('company-details-pdf', ['task_id'=>$data[0]->task_id]) }}" class="report_pdf" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}
            {{-- <div class="clearfix"></div> --}}
        </div>

        {{-- <h3 style="text-align:center;" class="page-title text-center green">Typing Test Information</h3> --}}

        <div class="app-container col-sm-12">


            <style>
                p {
                    font-size: 14px;
                }

                .tomato-description span {
                    background: tomato !important;
                    color: tomato !important;
                }

                .snow-description span {
                    background: tomato !important;
                    color: tomato !important;
                }

                .goldenrod-description {
                    /*    position: relative;
                    left: 113px;*/
                    margin-right: 12px;
                }

                .goldenrod-description span {
                    background: goldenrod;
                    color: goldenrod;
                }

                .header-section>div:nth-child(2) {
                    display: inline-block;
                    margin-left: 80px;
                }

                header p {
                    font-family: SolaimanLipi !important;
                }

                header p:first-child {
                    font-size: 18px;
                    margin-bottom: 0;
                }

                header p:nth-child(2) {
                    font-size: 18px;
                }

                .bangla-font,
                .bangla-font * {
                    font-family: SolaimanLipi !important;
                    font-size: 18px !important;
                }

                .bangla-block {
                    float: left;
                    margin-right: 20px;
                }

                .bangla-english-block>div span:first-child b {
                    color: blue;
                }

                .color-description span {
                    background: goldenrod;
                    color: goldenrod;
                    width: 40px;
                    height: 17px;
                    display: inline-block;
                    position: relative;
                    top: 3px;
                }

                header {
                    padding: 5px;
                }

                .color-block {
                    float: left;
                    text-align: left;
                    margin-top: 0;
                }

                .color-description {
                    display: inline-block;
                    margin-bottom: 7px;
                }

                header+section {
                    padding-top: 5px !important;
                }

                @media print {

                    p {
                        font-size: 14px;
                    }

                    header+section {
                        padding-top: 5px !important;
                    }

                    header {
                        padding: 5px;
                        text-align: left !important;
                        height: 180px !important;
                    }

                    .color-block {
                        /*float:left;*/
                        text-align: left;
                        margin-top: 7px !important;
                    }

                    .color-description {
                        display: inline-block;
                        margin-bottom: 7px;
                    }

                    .bangla-font,
                    .bangla-font * {
                        font-family: SolaimanLipi !important;
                        font-size: 14px !important;
                    }

                    .hidden-paragraph {
                        display: none;
                    }

                    header p:first-child {
                        font-size: 18px !important;
                        margin-bottom: -10px;
                    }

                    header p:nth-child(2) {
                        font-size: 14px !important;
                    }

                    .tomato-description {
                        margin-bottom: 20px !important;
                    }

                    .snow-description {
                        margin-bottom: 20px !important;
                    }

                    .tomato-description span {
                        background: tomato !important;
                        color: tomato !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .snow-description span {
                        background: snow !important;
                        color: snow !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .goldenrod-description span {
                        background: goldenrod !important;
                        color: goldenrod !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .header-section>div:first-child {
                        margin-top: 20px;
                    }

                    .goldenrod {
                        background: goldenrod !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .tomato {
                        background: tomato !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .color-description {
                        margin-left: 10px;
                    }

                    .color-description span {
                        background: goldenrod;
                        color: goldenrod;
                        width: 40px;
                        height: 17px;
                        display: inline-block;
                        position: relative;
                        top: 3px;
                    }

                    /*.header-section > div:nth-child(2) {
                        display: inline-block;
                        margin-top: -10px;
                        margin-left: 80px;
                    }

                    .bangla-english-block{
                        margin-top: 10px;
                        width: auto !important;
                        margin-right: 10px;
                    }

                    .color-block + div{
                        margin-left: 27px !important;
                    }

                    .bangla-block {
                        float: none;
                        margin-right: 10px;
                        margin-bottom: 5px;
                    }

                    .english-block {
                        margin-right: 10px;
                    }*/



                    .header-section>div:nth-child(2) {
                        display: inline-block;
                        margin-top: -10px;
                        margin-left: 70px !important;
                    }

                    .bangla-english-block {
                        float: none !important;
                        width: 330px !important;
                        margin: -7px auto 10px !important;
                        padding-left: 80px;
                    }

                    .color-block+div {
                        margin-left: 27px !important;
                    }

                    .bangla-block {
                        float: left;
                        margin-right: 20px !important;
                    }

                    .english-block {
                        margin-right: 10px;
                    }

                    .bangla-english-block>div span:first-child b {
                        color: blue;
                    }

                }
            </style>

            <?php
            $bangla_total_characters = isset($bangla->total_words) ? $bangla->total_words : 0;
            $bangla_total_words = round($bangla_total_characters / 5);
            $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
            $bangla_typed_words = round($bangla_typed_characters / 5);
            $bangla_deleted_words = isset($bangla->deleted_words) ? round($bangla->deleted_words / 5) : 0;
            $bangla_corrected_words = isset($bangla->inserted_words) ? round($bangla->inserted_words / 5) : 0;
            
            $english_total_characters = isset($english->total_words) ? $english->total_words : 0;
            $english_total_words = round($english_total_characters / 5);
            $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
            $english_typed_words = round($english_typed_characters / 5);
            $english_deleted_words = isset($english->deleted_words) ? round($english->deleted_words / 5) : 0;
            $english_corrected_words = isset($english->inserted_words) ? round($english->inserted_words / 5) : 0;
            ?>

            <header style="text-align:center;font-size:14px;border:1px solid #577;" class="header-section text-center">

                <div class="color-block">

                    <span class="color-description goldenrod-description"><span></span> :: Added Characters (wrong)</span>
                    <br>
                    <span class="color-description tomato-description"><span></span> :: Removed Characters (wrong)</span>
                    <br>
                    <span class="color-description snow-description"><span></span> :: Corrected Characters (correct)</span>

                </div>


                <div>

                    <p>{{ $user->typing_exam_code->company->company_name }}</p>

                    <p><b>পদের নাম:</b> {{ $user->typing_exam_code->designation->designation_name }}<br><b>পরীক্ষার
                            তারিখ:</b> {{ Helper::revese_date_format($user->typing_exam_code->exam_date) }}<br><b>রোল
                            নং:</b> {{ $user->roll_no }}</p>

                </div>

                <div class="bangla-english-block" style="float:right;text-align:left;width:335px;">

                    <div class="bangla-block">

                        <span class=""><b>Bangla::</b></span><br>

                        <span class=""><b>Total Given Words: </b>{{ $bangla_total_words }}</span><br>

                        <span class=""><b>Typed Words: </b>{{ $bangla_typed_words }}</span><br>

                        <span class=""><b>Corrected Words:
                            </b>{{ $bangla_corrected_words }}</span><br>

                        <span class=""><b>Wrong Words: </b>{{ $bangla_deleted_words }}</span><br>

                    </div>


                    <div class="english-block">

                        <span class=""><b>English::</b></span><br>

                        <span class=""><b>Total Given Words: </b>{{ $english_total_words }}</span><br>

                        <span class=""><b>Typed Words: </b>{{ $english_typed_words }}</span><br>

                        <span class=""><b>Corrected Words:
                            </b>{{ $english_corrected_words }}</span><br>

                        <span class=""><b>Wrong Words: </b>{{ $english_deleted_words }}</span><br>

                    </div>

                </div>

                <div class="clearfix"></div>

            </header>


            <section style="border:1px solid #577;padding:20px;border-top:none;border-bottom:none;">

                <h3 style="font-size:18px;color:#0000dc;">Bangla Original Text</h3>

                <p id="bangla_web_question" class="bangla-font">
                    {!! $bangla->original_text !!}
                </p>

                <h3 style="font-size:18px;color:#0000dc">Bangla Answered Text</h3>

                <p id="displayBn" class="fs-1 bangla-font"></p>
                <p id="bangla_web_answer" class="bangla-font" hidden>
                    {!! !empty($bangla->answered_text) ? $bangla->answered_text : '<b>No answer is given.</b>' !!}
                </p>


                <p><br></p>

                <h3 style="font-size:18px;color:#0000dc">English Original Text</h3>
                <p class="bangla-font" id="english_web_question">
                    {!! $english->original_text !!}
                </p>

                <h3 style="font-size:18px;color:#0000dc">English Answered Text</h3>
                <p id="displayEn" class="fs-1 bangla-font"></p>
                <p id="english_web_answer" class="bangla-font" hidden>
                    {!! !empty($english->answered_text) ? $english->answered_text : '<b>No answer is given.</b>' !!}
                </p>

            </section>

            <footer style="border:1px solid #577;padding:10px;text-align:center;">N.B. This Report is System Generated.
            </footer>

        </div>
    </div>


    <style>
        * {
            color: #000;
        }

        b {
            font-weight: 600 !important;
        }

        header p:last-child {
            margin: 0;
        }

        header,
        article section,
        footer {
            padding: 10px;
        }
    </style>





    <div class="print-container print-show col-sm-12">


        <style>
            p {
                font-size: 14px;
            }

            .print-show {
                display: none;
            }

            .tomato-description span {
                background: tomato !important;
                color: tomato !important;
            }

            .snow-description span {
                background: snow !important;
                color: snow !important;
            }

            .goldenrod-description {
                /*    position: relative;
            left: 113px;*/
                margin-right: 12px;
            }

            .goldenrod-description span {
                background: goldenrod;
                color: goldenrod;
            }

            .header-section>div:nth-child(2) {
                display: inline-block;
                margin-left: 80px;
            }

            header p {
                font-family: SolaimanLipi !important;
            }

            header p:first-child {
                font-size: 18px;
                margin-bottom: 0;
            }

            header p:nth-child(2) {
                font-size: 18px;
            }

            .bangla-font,
            .bangla-font * {
                font-family: SolaimanLipi !important;
                font-size: 18px !important;
            }

            .bangla-block {
                float: left;
                margin-right: 20px;
            }

            .bangla-english-block>div span:first-child b {
                color: blue;
            }

            .color-description span {
                background: goldenrod;
                color: goldenrod;
                width: 40px;
                height: 17px;
                display: inline-block;
                position: relative;
                top: 3px;
            }

            header {
                padding: 5px;
            }

            .color-block {
                float: left;
                text-align: left;
                margin-top: 0;
            }

            .color-description {
                display: inline-block;
                margin-bottom: 7px;
            }

            header+section {
                padding-top: 5px !important;
            }


            @media print {

                p {
                    font-size: 14px;
                }

                header+section {
                    padding-top: 5px !important;
                }

                header {
                    padding: 5px;
                    text-align: left !important;
                    height: 185px !important;
                }

                .color-block {
                    /*float:left;*/
                    text-align: left;
                }

                .color-description {
                    display: inline-block;
                    margin-bottom: 7px;
                }

                header div p:first-child {
                    margin-bottom: -15px !important;
                }

                header {
                    /*margin-top: -10px !important;*/
                    padding: 0 !important;
                }

                header p:nth-child(2) {
                    font-size: 14px !important;
                }

                .print-show {
                    display: block !important;
                }

                .tomato-description {
                    margin-bottom: 20px !important;
                }

                .tomato-description span {
                    background: tomato !important;
                    color: tomato !important;
                    -webkit-print-color-adjust: exact;
                }

                .snow-description {
                    margin-bottom: 20px !important;
                }

                .snow-description span {
                    background: snow !important;
                    color: snow !important;
                    -webkit-print-color-adjust: exact;
                }


                .goldenrod-description span {
                    background: goldenrod !important;
                    color: goldenrod !important;
                    -webkit-print-color-adjust: exact;
                }

                .goldenrod {
                    background: goldenrod !important;
                    -webkit-print-color-adjust: exact;
                }

                .tomato {
                    background: tomato !important;
                    -webkit-print-color-adjust: exact;
                }

                .color-description span {
                    background: goldenrod;
                    color: goldenrod;
                    width: 40px;
                    height: 17px;
                    display: inline-block;
                    position: relative;
                    top: 3px;
                }

                /*.header-section > div:nth-child(2) {
                display: inline-block;
                margin-top: -10px;
                margin-left: 80px;
            }

            .bangla-english-block{
                margin-top: 10px;
                width: auto !important;
                margin-right: 10px;
            }

            .color-block + div{
                margin-left: 27px !important;
            }

            .bangla-block {
                float: none;
                margin-right: 10px;
                margin-bottom: 5px;
            }

            .english-block {
                margin-right: 10px;
            }*/



                .header-section>div:nth-child(1) {
                    float: none !important;
                }

                .bangla-english-block {
                    float: none !important;
                    width: 100% !important;
                    margin: 0px !important;
                    padding: 0px;
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                }

                .color-block+div {
                    /*margin-left: 27px !important;*/
                }

                .bangla-block {
                    float: left;
                    /*margin-right: 20px !important;*/
                }

                .english-block {
                    /*margin-right: 10px;*/
                }

                .bangla-english-block>div span:first-child b {
                    color: blue;
                }


                header p:nth-child(2) {
                    font-size: 14px !important;
                }

                header p {
                    display: block;
                }

            }
        </style>



        <header style="text-align:center;font-size:14px;border:1px solid #577;margin-top:-5px;"
            class="header-section text-center">


            <div style="text-align:center;margin-top:-15px;padding: 0;">

                <p>{{ $user->typing_exam_code->company->company_name }}</p>

                <p><b>পদের নাম:</b> {{ $user->typing_exam_code->designation->designation_name }}<br><b>পরীক্ষার তারিখ:</b>
                    {{ Helper::revese_date_format($user->typing_exam_code->exam_date) }}<br><b>রোল নং:</b>
                    {{ $user->roll_no }}</p>

            </div>

            <div class="clearfix"></div>

            <div class="bangla-english-block" style="text-align:left;padding:0 10px;">

                <div class="bangla-block">

                    <span class=""><b>Bangla::</b></span><br>

                    <span class=""><b>Total Given Words: </b>{{ $bangla_total_words }}</span><br>

                    <span class=""><b>Typed Words: </b>{{ $bangla_typed_words }}</span><br>

                    <span class=""><b>Corrected Words:
                        </b>{{ $bangla_corrected_words }}</span><br>

                    <span class=""><b>Wrong Words: </b>{{ $bangla_deleted_words }}</span><br>

                </div>


                <div class="color-block">

                    <span class="color-description goldenrod-description"><span></span> :: Added Characters (wrong)</span>
                    <br>
                    <span class="color-description tomato-description"><span></span> :: Removed Characters (wrong)</span>
                    <br>
                    <span class="color-description snow-description"><span></span> :: Corrected Characters (correct)</span>

                </div>


                <div class="english-block" style="padding-right:20px;">

                    <span class=""><b>English::</b></span><br>

                    <span class=""><b>Total Given Words: </b>{{ $english_total_words }}</span><br>

                    <span class=""><b>Typed Words: </b>{{ $english_typed_words }}</span><br>

                    <span class=""><b>Corrected Words:
                        </b>{{ $english_corrected_words }}</span><br>

                    <span class=""><b>Wrong Words: </b>{{ $english_deleted_words }}</span><br>

                </div>

            </div>

            <div class="clearfix"></div>
        </header>



        <section style="border:1px solid #577;padding:20px;border-top:none;border-bottom:none;">

            <h3 style="font-size:18px;color:#0000dc;">Bangla Original Text</h3>

            <p id="bangla_print_question" class="bangla-font">
                {!! $bangla->original_text !!}
            </p>

            <h3 style="font-size:18px;color:#0000dc">Bangla Answered Text</h3>

            <p id="displayBnPrint" class="fs-1 bangla-font"></p>
            <p id="bangla_print_answer" class="bangla-font" >
                {!! !empty($bangla->answered_text) ? $bangla->answered_text : '<b>No answer is given.</b>' !!}
            </p>


            <p><br></p>

            <h3 style="font-size:18px;color:#0000dc">English Original Text</h3>
            <p class="bangla-font" id="english_print_question">
                {!! $english->original_text !!}
            </p>

            <h3 style="font-size:18px;color:#0000dc">English Answered Text</h3>
            <p id="displayEnPrint" class="fs-1 bangla-font"></p>
            <p id="english_print_answer" class="bangla-font" hidden>
                {!! !empty($english->answered_text) ? $english->answered_text : '<b>No answer is given.</b>' !!}
            </p>

        </section>

        <footer style="border:1px solid #577;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

    </div>




@stop


@section('custom-script')

    <script src="{{ URL::asset('assets/dist/diff.js') }}"></script>

    <script>
        const questionEn = document.getElementById('english_web_question').textContent
        answerEn = document.getElementById('english_web_answer').textContent;

        const diffEn = Diff.diffChars(questionEn, answerEn),
            displayEn = document.getElementById('displayEn'),
            displayEnPrint = document.getElementById('displayEnPrint'),
            fragmentEn = document.createDocumentFragment();

        diffEn.forEach((part) => {
            // green for additions, red for deletions
            // grey for common parts
            const color = part.added ? "white" : part.removed ? "white" : "silver";
            const backgroundColor = part.added ? "goldenrod" : part.removed ? "tomato" : "snow";

            span = document.createElement('span');
            span.style.color = color;
            span.style.backgroundColor = backgroundColor;
            span.appendChild(document
                .createTextNode(part.value));
            fragmentEn.appendChild(span);
        });

        displayEn.appendChild(fragmentEn);
        displayEnPrint.appendChild(fragmentEn);

        const questionBn = document.getElementById('bangla_web_question').textContent
        answerBn = document.getElementById('bangla_web_answer').textContent;

        const diffBn = Diff.diffChars(questionBn, answerBn),
            displayBn = document.getElementById('displayBn'),
            displayBnPrint = document.getElementById('displayBnPrint'),
            fragmentBn = document.createDocumentFragment();

        diffBn.forEach((part) => {
            // green for additions, red for deletions
            // grey for common parts
            const color = part.added ? "white" : part.removed ? "white" : "silver";
            const backgroundColor = part.added ? "goldenrod" : part.removed ? "tomato" : "snow";

            span = document.createElement('span');
            span.style.color = color;
            span.style.backgroundColor = backgroundColor;
            span.appendChild(document
                .createTextNode(part.value));
            fragmentBn.appendChild(span);
        });

        displayBn.appendChild(fragmentBn);
        displayBnPrint.appendChild(fragmentBn);

        $('.print').click(function(event) {

            w = window.open('', '_top');
            w.document.write(document.getElementsByClassName('app-container')[0].innerHTML);
            w.print();
            w.close();

        });
    </script>

@stop
