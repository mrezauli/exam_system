@extends('admin::layouts.master')
@section('sidebar')
    @parent
    @include('admin::layouts.sidebar')
@stop
@section('content')

    <?php use Modules\Exam\Helpers\StdClass;
    use App\User;
    ?>

    <div class="inner-wrapper all-graph-report-page">
        <div class="panel-heading" id="rep_btn">
            {{-- <span class="panel-title"><h3 class="page-title text-center">All Graph Report </h3> --}}
            <span class="panel-title">{{ $page_title }}</span>

            <a href="#" class="btn btn-primary btn-sm print pull-right">Print</a>

        </div>


        <div class="app-container col-sm-12">


            <style>
                p {
                    font-size: 14px;
                }

                .print-show {
                    display: none;
                }

                .orangered-description span {
                    background: orangered !important;
                    color: orangered !important;
                }

                .yellowgreen-description {
                    /*    position: relative;
                    left: 113px;*/
                    margin-right: 12px;
                }

                .yellowgreen-description span {
                    background: yellowgreen;
                    color: yellowgreen;
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

                header {
                    padding: 5px;
                }

                .color-block {
                    float: left;
                    text-align: left;
                    margin-top: 0;
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
                        margin-left: 10px !important;
                    }


                    header p:first-child {
                        font-size: 18px !important;
                        margin-bottom: 5px;
                    }

                    header p:nth-child(2) {
                        font-size: 14px !important;
                    }

                    .print-show {
                        display: block !important;
                    }

                    .orangered-description {
                        margin-bottom: 20px !important;
                    }

                    .orangered-description span {
                        background: orangered !important;
                        color: orangered !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .yellowgreen-description span {
                        background: yellowgreen !important;
                        color: yellowgreen !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .yellowgreen {
                        background: yellowgreen !important;
                        -webkit-print-color-adjust: exact;
                    }

                    .orangered {
                        background: orangered !important;
                        -webkit-print-color-adjust: exact;
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
                        width: 100% !important;
                        margin: 0px !important;
                        padding: 0px;
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

                    .bangla-font,
                    .bangla-font * {
                        font-family: SolaimanLipi !important;
                        font-size: 14px !important;
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

                    .goldenrod-description {
                        /*    position: relative;
                                    left: 113px;*/
                        margin-right: 12px;
                        background: goldenrod;
                        color: goldenrod;
                    }

                    .color-description {
                        margin-left: 10px;
                        display: inline-block;
                        margin-bottom: 7px;
                    }

                    .color-description span {
                        width: 40px;
                        height: 17px;
                        display: inline-block;
                        position: relative;
                        top: 3px;
                    }

                }
            </style>


            @foreach ($model as $values)
                <?php

                $values = collect($values);

                $grouped_by_exam_type = $values->groupBy('exam_type');

                $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0] : StdClass::fromArray();

                $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0] : StdClass::fromArray();

                $user = User::with('relCompany', 'relDesignation')->find($values->first()->user_id);

                $bangla_total_characters = isset($bangla->total_words) ? $bangla->total_words : 0;
                $bangla_total_words = round($bangla_total_characters / 5);
                $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                $bangla_typed_words = round($bangla_typed_characters / 5);
                $bangla_deleted_characters = isset($bangla->deleted_words) ? $bangla->deleted_words : 0;
                $bangla_deleted_words = round($bangla_deleted_characters / 5);
                $bangla_corrected_characters = isset($bangla->inserted_words) ? $bangla->inserted_words : 0;
                $bangla_corrected_words = round($bangla_corrected_characters / 5);

                $english_total_characters = isset($english->total_words) ? $english->total_words : 0;
                $english_total_words = round($english_total_characters / 5);
                $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                $english_typed_words = round($english_typed_characters / 5);
                $english_deleted_characters = isset($english->deleted_words) ? $english->deleted_words : 0;
                $english_deleted_words = round($english_deleted_characters / 5);
                $english_corrected_characters = isset($english->inserted_words) ? $english->inserted_words : 0;
                $english_corrected_words = round($english_corrected_characters / 5);

                // dd($bangla);

                // if ($values[0]->user_id == 15) {
                //     var_dump('ddd');
                //    dd(empty($english->answered_text));
                // }

                ?>

                <article>

                    <header style="text-align:center;font-size:14px;border:1px solid #577;"
                        class="header-section text-center">

                        <div class="color-block">
                            <span class="color-description goldenrod-description"><span></span> :: Typed Characters (wrong in count)</span>
                            <br>
                            <span class="color-description snow-description"><span></span> :: Typed Characters (correct in count)</span>
                            <br>
                            <span class="color-description tomato-description"><span></span> :: Untyped Characters (no count)</span>
                        </div>

                        <div>

                            <p>{{ $user->typing_exam_code->company->company_name }}</p>

                            <p><b>পদের নাম:</b> {{ $user->typing_exam_code->designation->designation_name }}<br><b>পরীক্ষার
                                    তারিখ:</b>
                                {{ Helper::revese_date_format($user->typing_exam_code->exam_date) }}<br><b>রোল নং:</b>
                                {{ $user->roll_no }}</p>

                        </div>


                        <div class="bangla-english-block" style="float:right;text-align:left;width:335px;">

                            <div class="bangla-block">

                                <span class=""><b>Bangla::</b></span><br>

                                <span class=""><b>Given Words: </b>{{ $bangla_total_words }}</span><br>
                                <span class=""><b>Given Characters: </b>{{ $bangla_total_characters }}</span><br>

                                <span class=""><b>Typed Words: </b>{{ $bangla_typed_words }}</span><br>
                                <span class=""><b>Typed Characters: </b>{{ $bangla_typed_characters }}</span><br>

                                <span class=""><b>Corrected Words: </b>{{ $bangla_corrected_words }}</span><br>
                                <span class=""><b>Corrected Characters:
                                    </b>{{ $bangla_corrected_characters }}</span><br>

                                <span class=""><b>Wrong Words: </b>{{ $bangla_deleted_words }}</span><br>
                                <span class=""><b>Wrong Characters: </b>{{ $bangla_deleted_characters }}</span><br>

                            </div>


                            <div class="english-block">

                                <span class=""><b>English::</b></span><br>

                                <span class=""><b>Given Words: </b>{{ $english_total_words }}</span><br>
                                <span class=""><b>Given Characters: </b>{{ $english_total_characters }}</span><br>

                                <span class=""><b>Typed Words: </b>{{ $english_typed_words }}</span><br>
                                <span class=""><b>Typed Characters: </b>{{ $english_typed_characters }}</span><br>

                                <span class=""><b>Corrected Words: </b>{{ $english_corrected_words }}</span><br>
                                <span class=""><b>Corrected Characters:
                                    </b>{{ $english_corrected_characters }}</span><br>

                                <span class=""><b>Wrong Words: </b>{{ $english_deleted_words }}</span><br>
                                <span class=""><b>Wrong Characters: </b>{{ $english_deleted_characters }}</span><br>

                            </div>

                        </div>

                        <div class="clearfix"></div>
                    </header>




                    <section style="border:1px solid #577;padding:20px;border-top:none;border-bottom:none;">
                        <h3 style="font-size:18px;color:#0000dc">Bangla Original Text</h3>
                        {!! !empty($bangla->original_text)
                            ? '<p class="bangla-font" style="font-size:14px;">' . $bangla->original_text . '</p>'
                            : '<p class="bangla-font">No question is given.</p>' !!}


                        <h3 style="font-size:18px;color:#0000dc">Bangla Answered Text</h3>
                        {!! !empty($bangla->answered_text)
                            ? '<p class="bangla-font" style="font-size:14px;">' . $bangla->process_text . '</p>'
                            : '<p class="bangla-font">No answer is given.</p>' !!}

                        <h3 style="font-size:18px;color:#0000dc">English Original Text</h3>
                        {!! !empty($english->original_text)
                            ? '<p class="bangla-font" style="font-size:14px;">' . $english->original_text . '</p>'
                            : '<p class="bangla-font">No question is given.</p>' !!}


                        <h3 style="font-size:18px;color:#0000dc">English Answered Text</h3>
                        {!! !empty($english->answered_text) ? '<p class="bangla-font">' . $english->process_text . '</p>' : '<p class="bangla-font">No answer is given.</p>' !!}
                    </section>

                    {{-- <footer style="border:1px solid #577;padding:10px;text-align:center;">This script evaluated by system (Bangladesh Computer Council)</footer> --}}


                    <footer style="border:1px solid #577;padding:10px;text-align:center;">N.B. This Report is System
                        Generated.</footer>

                </article>

                <div class="space" style="margin:50px;"></div>

                <div style="page-break-after:always"> </div>
            @endforeach

        </div>
    </div>


    <style>
        * {
            color: #000;
        }

        b {
            font-weight: 600 !important;
        }

        header,
        article section,
        footer {
            border: 1px solid #577;
            padding: 10px;
        }

        header p:last-child {
            margin: 0;
        }

        section {
            border-top: none;
            border-bottom: none;
        }

        @media print {

            .space {
                display: none !important;
            }

            header {
                padding: 0;
            }

            footer {
                padding: 10px;
            }

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

            .orangered-description span {
                background: orangered !important;
                color: orangered !important;
            }

            .yellowgreen-description {
                /*    position: relative;
                    left: 113px;*/
                margin-right: 12px;
            }

            .yellowgreen-description span {
                background: yellowgreen;
                color: yellowgreen;
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
                    height: 250px !important;
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

                .orangered-description {
                    margin-bottom: 20px !important;
                }

                .orangered-description span {
                    background: orangered !important;
                    color: orangered !important;
                    -webkit-print-color-adjust: exact;
                }

                .yellowgreen-description span {
                    background: yellowgreen !important;
                    color: yellowgreen !important;
                    -webkit-print-color-adjust: exact;
                }

                .yellowgreen {
                    background: yellowgreen !important;
                    -webkit-print-color-adjust: exact;
                }

                .orangered {
                    background: orangered !important;
                    -webkit-print-color-adjust: exact;
                }

                .color-description span {
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


        @foreach ($model as $values)
            <?php

            $values = collect($values);

            $grouped_by_exam_type = $values->groupBy('exam_type');

            $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0] : StdClass::fromArray();

            $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0] : StdClass::fromArray();

            $user = User::with('relCompany', 'relDesignation')->find($values->first()->user_id);

            $bangla_total_characters = isset($bangla->total_words) ? $bangla->total_words : 0;
                $bangla_total_words = round($bangla_total_characters / 5);
                $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                $bangla_typed_words = round($bangla_typed_characters / 5);
                $bangla_deleted_characters = isset($bangla->deleted_words) ? $bangla->deleted_words : 0;
                $bangla_deleted_words = round($bangla_deleted_characters / 5);
                $bangla_corrected_characters = isset($bangla->inserted_words) ? $bangla->inserted_words : 0;
                $bangla_corrected_words = round($bangla_corrected_characters / 5);

                $english_total_characters = isset($english->total_words) ? $english->total_words : 0;
                $english_total_words = round($english_total_characters / 5);
                $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                $english_typed_words = round($english_typed_characters / 5);
                $english_deleted_characters = isset($english->deleted_words) ? $english->deleted_words : 0;
                $english_deleted_words = round($english_deleted_characters / 5);
                $english_corrected_characters = isset($english->inserted_words) ? $english->inserted_words : 0;
                $english_corrected_words = round($english_corrected_characters / 5);



            // dd($bangla);

            // if ($values[0]->user_id == 15) {
            //     var_dump('ddd');
            //    dd(empty($english->answered_text));
            // }

            ?>

            <article>

                <header style="text-align:center;font-size:14px;border:1px solid #577;margin-top:-5px;"
                    class="header-section text-center">


                    <div style="text-align:center;margin-top:-15px;padding: 0;">

                        <p>{{ $user->typing_exam_code->company->company_name }}</p>

                        <p><b>পদের নাম:</b> {{ $user->typing_exam_code->designation->designation_name }}<br><b>পরীক্ষার
                                তারিখ:</b>
                            {{ Helper::revese_date_format($user->typing_exam_code->exam_date) }}<br><b>রোল নং:</b>
                            {{ $user->roll_no }}</p>

                    </div>

                    <div class="clearfix"></div>

                    <div class="bangla-english-block" style="float:right;text-align:left;width:335px;">

                        <div class="bangla-block">

                            <span class=""><b>Bangla::</b></span><br>

                            <span class=""><b>Given Words: </b>{{ $bangla_total_words }}</span><br>
                            <span class=""><b>Given Characters: </b>{{ $bangla_total_characters }}</span><br>

                            <span class=""><b>Typed Words: </b>{{ $bangla_typed_words }}</span><br>
                            <span class=""><b>Typed Characters: </b>{{ $bangla_typed_characters }}</span><br>

                            <span class=""><b>Corrected Words: </b>{{ $bangla_corrected_words }}</span><br>
                            <span class=""><b>Corrected Characters:
                                </b>{{ $bangla_corrected_characters }}</span><br>

                            <span class=""><b>Wrong Words: </b>{{ $bangla_deleted_words }}</span><br>
                            <span class=""><b>Wrong Characters: </b>{{ $bangla_deleted_characters }}</span><br>

                        </div>


                        <div class="english-block">

                            <span class=""><b>English::</b></span><br>

                            <span class=""><b>Given Words: </b>{{ $english_total_words }}</span><br>
                            <span class=""><b>Given Characters: </b>{{ $english_total_characters }}</span><br>

                            <span class=""><b>Typed Words: </b>{{ $english_typed_words }}</span><br>
                            <span class=""><b>Typed Characters: </b>{{ $english_typed_characters }}</span><br>

                            <span class=""><b>Corrected Words: </b>{{ $english_corrected_words }}</span><br>
                            <span class=""><b>Corrected Characters:
                                </b>{{ $english_corrected_characters }}</span><br>

                            <span class=""><b>Wrong Words: </b>{{ $english_deleted_words }}</span><br>
                            <span class=""><b>Wrong Characters: </b>{{ $english_deleted_characters }}</span><br>

                        </div>

                    </div>

                    <div class="clearfix"></div>
                </header>




                <section style="border:1px solid #577;padding:20px;border-top:none;border-bottom:none;">
                    <h3 style="font-size:18px;color:#0000dc">Bangla Answered Text</h3>

                    {!! !empty($bangla->answered_text)
                        ? '<p class="bangla-font" style="font-size:14px;">' . $bangla->answered_text . '</p>'
                        : '<p class="bangla-font">No answer is given.</p>' !!}

                    <h3 style="font-size:18px;color:#0000dc">English Answered Text</h3>

                    {!! !empty($english->answered_text) ? '<p class="bangla-font">' . $english->answered_text . '</p>' : '<p class="bangla-font">No answer is given.</p>' !!}
                </section>

                {{-- <footer style="border:1px solid #577;padding:10px;text-align:center;">This script evaluated by system (Bangladesh Computer Council)</footer> --}}


                <footer style="border:1px solid #577;padding:10px;text-align:center;">N.B. This Report is System Generated.
                </footer>

            </article>

            <div class="space" style="margin:50px;"></div>

            <div style="page-break-after:always"> </div>
        @endforeach

    </div>








@stop



@section('custom-script')

    <script>
        $('.print').click(function(event) {

            w = window.open('', '_blank');
            w.document.write(document.getElementsByClassName('print-container')[0].innerHTML);
            w.print();
            w.close();

        });
    </script>


@stop
