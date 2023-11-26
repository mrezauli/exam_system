@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')

    <style>
        form {
            padding-top: 0;
        }

        form .col-sm-12 {
            margin-bottom: 20px;
        }


        form .col-sm-12:last-child {
            margin-bottom: 30px;
        }
    </style>

    <!-- page start-->
    <div class="row task-report-index report-index">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $page_title }}</span>
                    <div class="clearfix"></div>
                </div>


                <div class="panel-body">

                    <ul class="alert alert-danger" style="margin-left: 30px;border-radius: 5px; display: none">
                        <li class="msg"></li>
                    </ul>

                    {{-- ------------ Filter :Starts ---------------------------------------- --}}
                    {!! Form::open([
                        'method' => 'GET',
                        'route' => ['generate-short-aptitude-test-report', $roll_wise],
                        'class' => 'report-form',
                    ]) !!}
                    <div class="col-sm-12">

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('exam_code', 'Exam Code:', ['class' => 'control-label']) !!}
                            {!! Form::text('exam_code', @Input::get('exam_code') ? Input::get('exam_code') : null, [
                                'id' => 'exam_code',
                                'class' => 'form-control',
                                'placeholder' => 'exam code',
                                'title' => 'exam code',
                            ]) !!}
                        </div>

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::Select('company_id', $company_list, @Input::get('company_id') ? Input::get('company_id') : null, [
                                'id' => 'company_list',
                                'class' => 'form-control js-select',
                                'placeholder' => 'select company',
                                'title' => 'select company',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::Select(
                                'designation_id',
                                $designation_list,
                                @Input::get('designation_id') ? Input::get('designation_id') : null,
                                [
                                    'id' => 'designation_list',
                                    'class' => 'form-control js-select',
                                    'placeholder' => 'select industry type',
                                    'title' => 'select industry type',
                                    'required' => 'required',
                                ],
                            ) !!}
                        </div>

                    </div>


                    <div class="col-sm-12">

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('exam_date_from', 'Exam Date From:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::text('exam_date_from', Input::get('exam_date_from') ? Input::get('exam_date_from') : null, [
                                'id' => 'exam_date_from',
                                'class' => 'form-control datepicker',
                                'required' => 'required',
                            ]) !!}
                            <span class="input-group-btn add-on">
                                <button class="btn btn-danger calender-button" type="button"><i
                                        class="icon-calendar"></i></button>
                            </span>
                        </div>

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('exam_date_to', 'Exam Date To:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::text('exam_date_to', Input::get('exam_date_to') ? Input::get('exam_date_to') : null, [
                                'id' => 'exam_date_to',
                                'class' => 'form-control datepicker',
                                'required' => 'required',
                            ]) !!}
                            <span class="input-group-btn add-on">
                                <button class="btn btn-danger calender-button" type="button"><i
                                        class="icon-calendar"></i></button>
                            </span>
                        </div>

                        <div class="col-lg-25 col-md-3 col-sm-6">
                            {!! Form::label('remarks', 'Remarks:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::Select(
                                'remarks',
                                ['passed' => 'Pass', 'failed' => 'Fail', 'expelled' => 'Expelled', 'cancelled' => 'Cancelled', 'all' => 'All'],
                                @Input::get('remarks') ? Input::get('remarks') : null,
                                [
                                    'id' => 'remarks',
                                    'class' => 'form-control remarks',
                                    'placeholder' => 'select industry type',
                                    'title' => 'select industry type',
                                    'required' => 'required',
                                ],
                            ) !!}
                        </div>

                        {{--   <div class="col-lg-2 col-md-3 col-sm-6 filter-btn">

                      {!! Form::submit('Generate Report', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div> --}}

                    </div>

                    <div class="col-sm-12">

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('bangla_speed', 'Total Pass Marks(%):', ['class' => 'control-label']) !!}
                            {{-- <small class="required">(Req.)</small> --}}
                            {!! Form::text('bangla_speed', Input::get('bangla_speed') ? Input::get('bangla_speed') : null, [
                                'id' => 'bangla_speed',
                                'class' => 'form-control',
                                'placeholder' => 'pass marks %',
                                'title' => 'pass marks %',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('word_pass_marks', 'Word Pass Marks(%):', ['class' => 'control-label']) !!}
                            <small class="required jprequired">(Req.)</small>
                            {!! Form::text('word_pass_marks', Input::get('word_pass_marks') ? Input::get('word_pass_marks') : null, [
                                'id' => 'word_pass_marks',
                                'class' => 'form-control',
                                'placeholder' => 'pass marks %',
                                'title' => 'pass marks %',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('excel_pass_marks', 'Excel Pass Marks(%):', ['class' => 'control-label']) !!}
                            <small class="required jprequired">(Req.)</small>
                            {!! Form::text('excel_pass_marks', Input::get('excel_pass_marks') ? Input::get('excel_pass_marks') : null, [
                                'id' => 'excel_pass_marks',
                                'class' => 'form-control',
                                'placeholder' => 'pass marks %',
                                'title' => 'pass marks %',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('ppt_pass_marks', 'PPT Pass Marks(%):', ['class' => 'control-label']) !!}
                            <small class="required jprequired">(Req.)</small>
                            {!! Form::text('ppt_pass_marks', Input::get('ppt_pass_marks') ? Input::get('ppt_pass_marks') : null, [
                                'id' => 'ppt_pass_marks',
                                'class' => 'form-control',
                                'placeholder' => 'pass marks %',
                                'title' => 'pass marks %',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6 filter-btn">

                            {!! Form::submit('Generate Report', [
                                'class' => 'btn btn-primary btn-xs pull-left',
                                'id' => 'button',
                                'style' => 'padding:9px 17px!important',
                                'data-placement' => 'right',
                                'data-content' =>
                                    'type user name or select branch or both in specific field then click search button for required information',
                            ]) !!}
                        </div>

                        @if (isset($model) && !$model->isEmpty())
                            {{-- <a href="{{ route('aptitude-test-report-pdf', [$company_id,$designation_id,$exam_date]) }}" class="pdf_report_button" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}
                            <div class="clearfix"></div>
                            <div class="pull-left"><a href="#"
                                    class="btn btn-danger print-button pdf_report_button">Print</a>

                                <a href="#" class="btn btn-danger short-print-button pdf_report_button">Short Report
                                    Print</a>
                            </div>
                        @endif

                    </div>

                </div>
                {!! Form::close() !!}


                <p><br><br><br></p>
                <br><br><br>


                {{-- ----------- Filter :Ends ---------------------------------------- --}}
                <div class="table-primary report-table-wrapper">


                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                        class="table table-striped table-bordered report-table" id="examples_report">
                        <thead>
                            <tr>
                                <th> <span>SL.</span> </th>
                                <th> <span>Candidate SL.</span> </th>
                                <th> <span>Roll No.</span> </th>
                                <th> <span>Exam Code</span> </th>
                                <th> <span>Name</span> </th>
                                <th
                                    style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;">
                                    <span>Remarks</span> </th>

                            </tr>
                        </thead>
                        <tbody>

                            @if ($status == 2)

                                <?php
                                
                                $t = 1;
                                
                                $sl_no = isset($_GET['page']) ? ($_GET['page'] - 1) * 2 + 0 : 0;
                                
                                ?>


                                @foreach ($model_all as $values)
                                    <?php $sl_no++; ?>

                                    <tr class="gradeX">

                                        <td>{{ $sl_no }}</td>
                                        <td>{{ $values[0]->sl }}</td>
                                        <td>{{ $values[0]->roll_no }}</td>
                                        <td>{{ $values[0]->exam_code_name }}</td>
                                        <td class="table-name">

                                            {{ $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name }}
                                        </td>

                                        <td
                                            style="border-left:1.7px solid #8189fd !important;border-right:1.7px solid #8189fd !important;">
                                            {{ ucfirst($values->remarks) }}</td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($status == 2)
                {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->render() ) !!} </span> --}}
            @endif
        </div>
    </div>
    </div>
    </div>








    <div class="table-primary print-report-table-wrapper">


        <style>
            .print-show {
                display: none;
            }

            .table-name {
                text-align: left !important;
            }


            @media print {

                * {
                    text-align: center !important;
                    font-size: 14px !important;
                }

                .table-name {
                    text-align: left !important;
                }

                .report-table th {
                    vertical-align: top !important;
                }

                #examples * {
                    border: none;
                }

                table#examples {
                    border-collapse: collapse !important;
                }

                thead tr th,
                tbody tr td {
                    border: 1px solid #ccc !important;
                }

                thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }

                thead:first-child tr,
                thead tr th.no-border {
                    border-bottom: 0 !important;
                }

                .print-hide {
                    display: none !important;
                }

                .print-show {
                    display: block !important;
                }

                .header {
                    /*  font-family: SolaimanLipi !important;
                font-size: 15px !important;*/
                    text-align: center;
                    max-width: 400px;
                    margin: 5px auto;
                }

                .header-section {
                    margin-bottom: 20px;
                }

                .table-primary thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }


                table.report-table thead th {
                    padding: 10px;
                    font-weight: 600;
                    color: #333;
                    text-align: center;
                }


                table thead th,
                table tfoot th {
                    font-weight: 600 !important;
                    color: #333 !important;
                    padding-left: 0 !important;
                }

                footer {
                    font-size: 16px !important;
                }

                thead tr th,
                tbody tr td,
                table tr th,
                table tr td {
                    border: 1px solid #333 !important;
                    color: #333 !important;
                    /*font-weight: 500;*/
                }

            }
        </style>


        <div class="print-section print-show">
            <div class="header-section">
                <p class="header">{{ isset($header->company_name) ? $header->company_name : '' }}</p>
                <p class="header">{{ isset($header->address_one) ? $header->address_one : '' }}</p>
                <p class="header">{{ isset($header->address_two) ? $header->address_two : '' }}</p>
                <p class="header">{{ isset($header->address_three) ? $header->address_three : '' }}</p>
                <p class="header">{{ isset($header->address_four) ? $header->address_four : '' }}</p>
                <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : '' }}</p>
                <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
                <p class="header">পরীক্ষা গ্রহণে: বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
            </div>



            <table width="100%" cellpadding="3" cellspacing="0" border="1"
                class="table table-striped table-bordered report-table" id="examples">
                <thead>
                    <tr>
                        <th> <span>SL.</span> </th>
                        <th> <span>Roll No.</span> </th>
                        <th> <span>Exam Code</span> </th>
                        <th> <span>Name</span> </th>
                        <th> <span>Remarks</span> </th>

                    </tr>
                </thead>

                <tbody>

                    @if ($status == 2)

                        <?php
                        
                        $t = 1;
                        
                        $sl_no = isset($_GET['page']) ? ($_GET['page'] - 1) * 2 + 0 : 0; ?>


                        @foreach ($model_all as $values)
                            <?php $sl_no++; ?>
                            <tr class="gradeX">

                                <td>{{ $sl_no }}</td>
                                <td>{{ $values[0]->roll_no }}</td>
                                <td>{{ $values[0]->exam_code_name }}</td>
                                <td class="table-name">

                                    {{ $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name }}
                                </td>

                                <td>{{ ucfirst($values->remarks) }}</td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>




            {{--     @if ($remarks == 'all')

    <table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Pass</th>
        <th>Fail</th>
      </tr>
      <tr>
        <td>{{$passed_count}}</td>
        <td>{{$failed_count}}</td>
      </tr>
    </table>


    @elseif($remarks == 'passed')

    <table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Pass</th>
      </tr>
      <tr>
        <td>{{$passed_count}}</td>
      </tr>
    </table>


    @elseif($remarks == 'failed')

    <table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Fail</th>
      </tr>
      <tr>
        <td>{{$failed_count}}</td>
      </tr>
    </table>

    @endif --}}

        </div>

        <footer class="print-show" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System
            Generated.</footer>

    </div>













    <div class="table-primary print-short-report-table-wrapper">


        <style>
            .print-show {
                display: none;
            }


            @media print {

                * {
                    text-align: center !important;
                    font-size: 14px !important;
                }

                .report-table th {
                    vertical-align: top !important;
                }

                #examples * {
                    border: none;
                }

                table#examples {
                    border-collapse: collapse !important;
                }

                thead tr th,
                tbody tr td {
                    border: 1px solid #ccc !important;
                }

                thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }

                thead:first-child tr,
                thead tr th.no-border {
                    border-bottom: 0 !important;
                }

                .print-hide {
                    display: none !important;
                }

                .print-show {
                    display: block !important;
                }

                .header {
                    /*  font-family: SolaimanLipi !important;
                font-size: 15px !important;*/
                    text-align: center;
                    max-width: 400px;
                    margin: 5px auto;
                }

                .header-section {
                    margin-bottom: 20px;
                }

                .table-primary thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }


                table.report-table thead th {
                    padding: 10px;
                    font-weight: 600;
                    color: #333;
                    text-align: center;
                }


                table thead th,
                table tfoot th {
                    font-weight: 600 !important;
                    color: #333 !important;
                    padding-left: 0 !important;
                }

                footer {
                    font-size: 16px !important;
                }

                thead tr th,
                tbody tr td,
                table tr th,
                table tr td {
                    border: 1px solid #333 !important;
                    color: #333 !important;
                    /*font-weight: 500;*/
                }

            }
        </style>


        <div class="print-section print-show">
            <div class="header-section">
                <p class="header">{{ isset($header->company_name) ? $header->company_name : '' }}</p>
                <p class="header">{{ isset($header->address_one) ? $header->address_one : '' }}</p>
                <p class="header">{{ isset($header->address_two) ? $header->address_two : '' }}</p>
                <p class="header">{{ isset($header->address_three) ? $header->address_three : '' }}</p>
                <p class="header">{{ isset($header->address_four) ? $header->address_four : '' }}</p>
                <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : '' }}</p>
                <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
                <p class="header">পরীক্ষা গ্রহণে: বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
            </div>



            <table width="100%" cellpadding="3" cellspacing="0" border="1"
                class="table table-striped table-bordered report-table" id="examples">
                <thead>
                    <tr>
                        <th> <span>SL.</span> </th>
                        <th> <span>Roll No.</span> </th>
                        <th> <span>Remarks</span> </th>

                    </tr>
                </thead>

                <tbody>

                    @if ($status == 2)

                        <?php
                        
                        $t = 1;
                        
                        $sl_no = isset($_GET['page']) ? ($_GET['page'] - 1) * 2 + 0 : 0; ?>


                        @foreach ($model_all as $values)
                            <?php $sl_no++; ?>
                            <tr class="gradeX">

                                <td>{{ $sl_no }}</td>
                                <td>{{ $values[0]->roll_no }}</td>
                                <td>{{ $values->remarks }}</td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>




            {{--     @if ($remarks == 'all')

    <table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Pass</th>
        <th>Fail</th>
      </tr>
      <tr>
        <td>{{$passed_count}}</td>
        <td>{{$failed_count}}</td>
      </tr>
    </table>


    @elseif($remarks == 'passed')

    <table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Pass</th>
      </tr>
      <tr>
        <td>{{$passed_count}}</td>
      </tr>
    </table>


    @elseif($remarks == 'failed')

    <table style="margin:20px;width:17%;margin-left:83%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Fail</th>
      </tr>
      <tr>
        <td>{{$failed_count}}</td>
      </tr>
    </table>

    @endif --}}

        </div>

        <footer class="print-show" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System
            Generated.</footer>

    </div>

    <!-- page end-->

    <!--script for this page only-->


    <script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>
    <script>
        function report_exam_code() {

            var exam_code = $('#exam_code').val();

            var fields = '#company_list,#designation_list,#exam_date_from,#exam_date_to';

            if (exam_code != '') {

                $(fields).prop('disabled', true).val('').trigger('change').attr('required', false);

                $('.jrequired').hide();

            } else {

                $(fields).prop('disabled', false).attr('required', true);

                $('.jrequired').show();

            }

        }


        report_exam_code();

        $('#exam_code').keyup(function(e) {

            report_exam_code();

        });

        $('#exam_code').bind('input', function(e) {

            report_exam_code();

        });

        // $('select, #exam_date').not('#exam_code_list, #exam_type').prop('disabled', true);



        function report_pass_marks() {

            var bangla_speed = $('#bangla_speed').val();

            var fields = '#word_pass_marks,#excel_pass_marks,#ppt_pass_marks';

            if (bangla_speed != '') {

                $(fields).prop('disabled', true).val('').trigger('change').attr('required', false);

                $('.jprequired').hide();

            } else {

                $(fields).prop('disabled', false).attr('required', true);

                $('.jprequired').show();

            }

        }


        report_pass_marks();

        $('#bangla_speed').keyup(function(e) {

            report_pass_marks();

        });

        $('#bangla_speed').bind('input', function(e) {

            report_pass_marks();

        });

        var all_fields = '#bangla_speed,#word_pass_marks,#excel_pass_marks,#ppt_pass_marks';

        $('#remarks').change(function(e) {

            $value = $(this).val();

            if ($value == 'cancelled' || $value == 'expelled') {

                $(all_fields).prop('disabled', true).val('').trigger('change').attr('required', false);

                $('.jprequired').hide();

            } else {

                $(all_fields).prop('disabled', false);

                $('.jprequired').show();
            }

        });

        $('#remarks').trigger('change');



        $('form').on('submit', function(e) {
            $('select, #exam_date').prop('disabled', false);
        });


        // $('#button').click(function(e){
        //     var company_id = $('#company_id').val();
        //     var designation_id = $('#designation_id').val();
        //     var exam_date_from = $('#exam_date_from').val();
        //     var exam_date_to = $('#exam_date_to').val();

        //     if(company_id.length <= 0 || designation_id.length <= 0 || exam_date_from.length <= 0 || exam_date_to.length <= 0 ){
        //         $('.alert-danger').show();
        //         $('.msg').html('Please fill out all input field!');
        //     }else{
        //         $('.report-form').submit();
        //     }

        // })

        $('.print-button').click(function(event) {

            w = window.open();
            w.document.write(document.getElementsByClassName('print-report-table-wrapper')[0].outerHTML);
            w.print();
            w.close();

        });

        $('.short-print-button').click(function(event) {

            w = window.open();
            w.document.write(document.getElementsByClassName('print-short-report-table-wrapper')[0].outerHTML);
            w.print();
            w.close();

        });
    </script>
@stop


@section('custom-script')
    <script>
        var table = $('#examples_report').DataTable({
            "language": {
                "search": "Search:"
            },
            "aaSorting": [],
            "pageLength": 10000,
        });


        $('#examples_report_filter input').on('keyup', function() {

            table
                .column(1)
                .search(this.value)
                .draw();

        });
    </script>
@stop
