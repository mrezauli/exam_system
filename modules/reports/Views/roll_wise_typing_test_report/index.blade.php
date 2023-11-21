@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')

    <?php use Modules\Exam\Helpers\StdClass; ?>

    <!-- page start-->

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

        .table-primary tbody tr td:nth-child(6) {
            border-left: 1.7px solid #8189fd !important;
        }


        .table-primary thead tr th:nth-child(6) {
            border-left: 1.7px solid #8189fd !important;
        }





        .table-primary tbody tr td:nth-child(10) {
            border-left: 1.7px solid #8189fd !important;
        }


        .table-primary thead tr:first-child th:nth-child(7) {
            border-left: 1.7px solid #8189fd !important;
        }

        .table-primary thead tr:last-child th:nth-child(10) {
            border-left: 1.7px solid #8189fd !important;
        }





        .table-primary tbody tr td:nth-child(13) {
            border-right: 1.7px solid #8189fd !important;
        }


        .table-primary thead tr:first-child th:nth-child(7) {
            border-right: 1.7px solid #8189fd !important;
        }

        .table-primary thead tr:last-child th:nth-child(13) {
            border-right: 1.7px solid #8189fd !important;
        }
    </style>


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
                        'route' => ['generate-roll-wise-typing-test-report'],
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

                    </div>

                    <div class="col-sm-12">
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
                            {!! Form::label('exam_date_from', 'Exam Date From:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Req.)</small>
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
                            <small class="required jrequired">(Req.)</small>
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
                            {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                            <small class="required jrequired">(Required)</small>
                            {!! Form::Select(
                                'designation_id',
                                $designation_list,
                                Input::get('designation_id') ? Input::get('designation_id') : null,
                                [
                                    'id' => 'designation_list',
                                    'class' => 'form-control js-select',
                                    'placeholder' => 'select industry type',
                                    'title' => 'select industry type',
                                    'required' => 'required',
                                ]
                            ) !!}
                        </div>


                    </div>

                    <div class="col-sm-12">

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('spmDigit', 'Calculation Digit (SPM):', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('spmDigit', Input::get('spmDigit') ? Input::get('spmDigit') : null, [
                                'class' => 'form-control',
                                'placeholder' => 'spm digit',
                                'title' => 'spm digit',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('bangla_speed', 'Minimum Bangla Speed:', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('bangla_speed', Input::get('bangla_speed') ? Input::get('bangla_speed') : null, [
                                'id' => 'bangla_speed',
                                'class' => 'form-control',
                                'placeholder' => 'bangla speed',
                                'title' => 'bangla speed',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('english_speed', 'Minimum English Speed:', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('english_speed', Input::get('english_speed') ? Input::get('english_speed') : null, [
                                'english_speed' => 'english_speed',
                                'class' => 'form-control',
                                'placeholder' => 'english speed',
                                'title' => 'english speed',
                                'required' => 'required',
                            ]) !!}
                        </div>

                    </div>

                    <div class="col-sm-12">

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('passMark', 'Pass Mark for Remarks:', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('passMark', Input::get('passMark') ? Input::get('passMark') : null, [
                                'class' => 'form-control',
                                'placeholder' => 'pass mark',
                                'title' => 'pass mark',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('tolerance', 'Tolerance for Remarks:', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('tolerance', Input::get('tolerance') ? Input::get('tolerance') : null, [
                                'class' => 'form-control',
                                'placeholder' => 'tolerance',
                                'title' => 'tolerance',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6">
                            {!! Form::label('averageMark', 'Average Mark for Remarks:', ['class' => 'control-label']) !!}
                            <small class="required">(Req.)</small>
                            {!! Form::text('averageMark', Input::get('averageMark') ? Input::get('averageMark') : null, [
                                'class' => 'form-control',
                                'placeholder' => 'average mark',
                                'title' => 'average mark',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-lg-1 col-md-3 col-sm-6 filter-btn">

                            {!! Form::submit('Generate Result', [
                                'class' => 'btn btn-primary btn-xs pull-left',
                                'id' => 'submit-button',
                                'style' => 'padding:9px 17px!important',
                                'data-placement' => 'right',
                                'data-content' =>
                                    'type user name or select branch or both in specific field then click search button for required information',
                            ]) !!}
                        </div>

                    </div>
                    {!! Form::close() !!}

                    @if (isset($model) && !$model->isEmpty())
                        <div class="col-lg-12 col-md-3 col-sm-6 all-graph-pdf-report-block">

                            <?php $ddd = URL('/') . '/reports/roll-wise-all-graph-report' . '?exam_code=' . $exam_code . '&company_id=' . $company_id . '&designation_id=' . $designation_id . '&exam_date_from=' . $exam_date_from . '&exam_date_to=' . $exam_date_to . '&bangla_speed=' . $bangla_speed . '&english_speed=' . $english_speed; ?>

                            <div class="btn btn-primary btn-sm pull-right">
                                <a target="_blank" style="color:white" href="{{ $ddd }}">View All Answer
                                    Scripts</a>
                            </div>

                            <a class="btn btn-danger print-button pull-right">Print Result with Remarks</a>
                            <a class="btn btn-danger print-button-wr pull-right">Print Result without Remarks</a>

                            {{-- <div class="col-lg-3 col-sm-6 input-group">

                    <input type="text" class="form-control search_roll_no" value="Search Roll No." id="search_roll_no" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search Roll No.';}">

                    <span class="input-group-btn">
                        <button class="btn btn-primary search-button" type="button"></button>
                    </span>
                </div> --}}


                        </div>

                        <style>
                            .search-button,
                            .search-button:active {
                                background: url("{{ URL::asset('/assets/img/search.png') }}") no-repeat 0px -5px;
                                width: 40px;
                                height: 31.7px;
                                border: none;
                                padding: 0;
                                border: none;
                                outline: none;
                                color: #FFFFFF;
                                left: -32px;
                                background-size: cover;
                                z-index: 1000 !important;
                            }
                        </style>
                    @endif

                    <p><br><br><br></p>
                    <br><br><br>

                    <?php

                    $spmDigit = isset($spmDigit) ? $spmDigit : '';

                    $averageMark = isset($averageMark) ? $averageMark : '';

                    ?>


                    {{-- ----------- Filter :Ends ---------------------------------------- --}}
                    <div class="table-primary report-table-wrapper">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                            class="table table-striped table-bordered report-table" id="examples_report">
                            <thead>
                                <tr>

                                    <th class="no-border"> <span>SL.</span> </th>
                                    <th class="no-border"> <span>Candidate SL.</span> </th>
                                    <th class="no-border"> <span>Roll No.</span> </th>
                                    <th class="no-border"> <span>Exam Code</span> </th>
                                    <th class="no-border"> <span>Name</span> </th>
                                    <th class="no-border" style="border-right: 1.7px solid #8189fd !important"> <span>Answer
                                            Scripts View</span> </th>
                                    <th colspan="7" style="border-right: 1.7px solid #8189fd !important">Bangla in
                                        {{ $spmDigit }} minutes</th>
                                    <th colspan="7">English in {{ $spmDigit }} minutes</th>
                                    <th class="no-border"> <span>Average Mark</span> </th>
                                    <th class="no-border"> <span>Remarks</span> </th>
                                    <th class="no-border"> <span>Update</span> </th>
                                </tr>


                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="border-right: 1.7px solid #8189fd !important"></th>
                                    <th>Characters (with space)</th>
                                    <th>Total Words</th>
                                    <th>Wrong Words</th>
                                    <th>Correct Words</th>
                                    <th style="border-right: 1.7px solid #8189fd !important">Speed Per Mintues</th>
                                    <th>Tolerance (5%)</th>
                                    <th>Marks</th>

                                    <th>Characters (with space)</th>
                                    <th>Total Words</th>
                                    <th>Wrong Words</th>
                                    <th>Correct Words</th>
                                    <th style="border-right: 1.7px solid #8189fd !important">Speed Per Mintues</th>
                                    <th>Tolerance (5%)</th>
                                    <th>Marks</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($status == 2)
                                    <?php $i = isset($_GET['page']) ? ($_GET['page'] - 1) * 1 + 0 : 0;

                                    function round_to_integer($number)
                                    {
                                        if (is_integer($number)) {
                                            return $number;
                                        }

                                        $parts = explode('.', $number);

                                        if (isset($parts[1]) && (int) $parts[1] >= 5) {
                                            return $parts[0] + 1;
                                        } else {
                                            return $number;
                                        }
                                    }

                                    ?>

                                    @foreach ($model as $values)
                                    <?php $i++;

                                    $values = collect($values);

                                    $grouped_by_exam_type = $values->groupBy('exam_type');

                                    $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0] : StdClass::fromArray();

                                    $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0] : StdClass::fromArray();

                                        //revamped calculation from mopa
                                        $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                                        $bangla_typed_words = ceil($bangla_typed_characters / 5);
                                        $bangla_deleted_words = isset($bangla->deleted_words) ? floor($bangla->deleted_words / 5) : 0;
                                        $bangla_corrected_words = isset($bangla->inserted_words) ? ceil($bangla->inserted_words / 5) : 0;
                                        $bangla_wpm = ceil($bangla_corrected_words / $spmDigit);
                                        $bangla_tolerance = $bangla_typed_words == 0 ? 0 : floor(($bangla_deleted_words / $bangla_typed_words) * 100);
                                        $bangla_round_marks = ceil((20 / $bangla_speed) * $bangla_wpm);
                                        $bangla_marks = $bangla_round_marks > 50 ? 50 : $bangla_round_marks;

                                        $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                                        $english_typed_words = ceil($english_typed_characters / 5);
                                        $english_deleted_words = isset($english->deleted_words) ? floor($english->deleted_words / 5) : 0;
                                        $english_corrected_words = isset($english->inserted_words) ? ceil($english->inserted_words / 5) : 0;
                                        $english_wpm = ceil($english_corrected_words / $spmDigit);
                                        $english_tolerance = $english_typed_words == 0 ? 0 : floor(($english_deleted_words / $english_typed_words) * 100);
                                        $english_round_marks = ceil((20 / $english_speed) * $english_wpm);
                                        $english_marks = $english_round_marks > 50 ? 50 : $english_round_marks;

                                        $average = ceil(($bangla_marks + $english_marks) / 2);

                                        ?>
                                        <tr class="gradeX">

                                            <td>{{ $i }}</td>
                                            <td>{{ $values[0]->sl }}</td>
                                            <td>{{ $values[0]->roll_no }}</td>
                                            <td>{{ $values[0]->exam_code_name }}</td>
                                            <td class="table-name">

                                                {{ $values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name }}

                                            </td>

                                            <td style="border-right: 1.7px solid #8189fd !important">

                                                <?php

                                                $bangla_exam_id = !empty($bangla->exam_id) ? $bangla->exam_id : 0;

                                                $english_exam_id = !empty($english->exam_id) ? $english->exam_id : 0;

                                                ?>

                                                @if ($bangla->exam_id != 0 || $english->exam_id != 0)
                                                    <a target="_blank"
                                                        href="{{ route('typing-test-details', [$bangla_exam_id, $english_exam_id]) }}"
                                                        class="btn btn-info btn-xs" data-placement="top"
                                                        data-content="view">View</a>

                                                    <a target="_blank"
                                                        href="{{ route('typing-test-manual-checking-details', [$bangla_exam_id, $english_exam_id]) }}"
                                                        class="btn btn-primary btn-xs" data-placement="top"
                                                        data-content="view">Manual Checking</a>
                                                @else
                                                    {{ 'View' }}

                                                    {{ 'Manual Checking' }}
                                                @endif


                                            </td>


                                            <td>{{ $bangla_typed_characters }}</td>
                                            <td>{{ $bangla_typed_words }}</td>
                                            <td>{{ $bangla_deleted_words }}</td>
                                            <td>{{ $bangla_corrected_words }}</td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $bangla_wpm }}
                                            </td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $tolerance >= 0 ? $bangla_tolerance : '' }}
                                            </td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $passMark >= 0 ? $bangla_marks : '' }}
                                            </td>

                                            <td>{{ $english_typed_characters }}</td>
                                            <td>{{ $english_typed_words }}</td>
                                            <td>{{ $english_deleted_words }}</td>
                                            <td>{{ $english_corrected_words }}</td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $english_wpm }}
                                            </td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $tolerance >= 0 ? $english_tolerance : '' }}
                                            </td>
                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $passMark >= 0 ? $english_marks : '' }}
                                            </td>

                                            <td style="border-right: 1.7px solid #8189fd !important">
                                                {{ $averageMark >= 0 ? $average : '' }}
                                            </td>

                                            <td>
                                                @if ($values->lists('attended_typing_test')->contains('true'))
                                                    @if ($values->lists('typing_status')->contains('cancelled'))
                                                        <?php $remarks = 'Cancelled'; ?>
                                                    @elseif($values->lists('typing_status')->contains('expelled'))
                                                        <?php $remarks = 'Expelled'; ?>
                                                    @else
                                                        @if ($averageMark >= 0)
                                                            @if ($passMark >= 0)
                                                                @if ($tolerance >= 0)
                                                                    @if (
                                                                        $bangla_marks >= $passMark &&
                                                                            $bangla_tolerance <= $tolerance &&
                                                                            $english_marks >= $passMark &&
                                                                            $english_tolerance <= $tolerance &&
                                                                            $average >= $averageMark)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @else
                                                                    @if ($bangla_marks >= $passMark && $english_marks >= $passMark && $average >= $averageMark)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if ($tolerance >= 0)
                                                                    @if ($bangla_tolerance <= $tolerance && $english_tolerance <= $tolerance && $average >= $averageMark)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @else
                                                                    @if ($average >= $averageMark)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if ($passMark >= 0)
                                                                @if ($tolerance >= 0)
                                                                    @if (
                                                                        $bangla_marks >= $passMark &&
                                                                            $bangla_tolerance <= $tolerance &&
                                                                            $english_marks >= $passMark &&
                                                                            $english_tolerance <= $tolerance)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @else
                                                                    @if ($bangla_marks >= $passMark && $english_marks >= $passMark)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if ($tolerance >= 0)
                                                                    @if ($bangla_tolerance <= $tolerance && $english_tolerance <= $tolerance)
                                                                        <?php $remarks = 'Pass'; ?>
                                                                    @else
                                                                        <?php $remarks = 'Fail'; ?>
                                                                    @endif
                                                                @else
                                                                    <?php $remarks = $bangla_wpm + $english_wpm; ?>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($values->lists('typing_status')->contains('cancelled'))
                                                        <?php $remarks = 'Cancelled'; ?>
                                                    @elseif($values->lists('typing_status')->contains('expelled'))
                                                        <?php $remarks = 'Expelled'; ?>
                                                    @else
                                                        <?php $remarks = 'Absent'; ?>
                                                    @endif
                                                @endif
                                                {!! $remarks !!}
                                            </td>
                                            <td>
                                                @if ($bangla->exam_id != 0 || $english->exam_id != 0)
                                                    {{-- <a class="btn btn-xs btn-success" data-toggle="modal" href="#addData">Update</a> --}}
                                                    {{-- {{dd($values[0])}} --}}
                                                    <?php
                                                    $role_name = Session::get('role_title');
                                                    ?>
                                                    @if ($role_name == 'super-admin')
                                                        <a href="{{ route('edit-roll-wise-typing-test-details', $values[0]->id) }}"
                                                            class="btn btn-primary btn-xs edit-link" data-toggle="modal"
                                                            data-target="#etsbModal" data-placement="top"
                                                            data-content="update"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                @else
                                                    {{-- {{'Update'}} --}}
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($status == 2)
                        {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade company-modal" id="etsbModal" tabindex="" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static">


    </div> <!-- / .modal-body -->
    </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
    </div>



    <div class="table-primary print-report-table-wrapper">


        <style>
            .print-show {
                display: none;

            }

            table thead tr th:last-child {
                border-right: 1px solid #333 !important;
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
                    border: 1px solid #333 !important;
                }

                thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }

                thead:first-child tr,
                thead tr th.no-border {
                    border-bottom: 0 !important;
                }


                .no-border span {
                    position: relative;
                    top: 18px;
                }

                .print-hide {
                    display: none !important;
                }

                .print-show {
                    display: block !important;
                }

                .header {
                    font-family: SolaimanLipi !important;
                    font-size: 15px !important;
                    text-align: center;
                    max-width: 400px;
                    margin: 5px auto;
                }

                .header-section {
                    margin-bottom: 20px;
                }

                table,
                th,
                td {
                    border: 1px solid #333 !important;
                }

                .table-primary thead tr th:empty {
                    /*border-right: none !important;*/
                    border-top: none !important;
                }

                table thead tr th:last-child {
                    border-right: 1px solid #333 !important;
                }

                .no-border span {
                    position: relative;
                    top: 18px;
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

                .graph-button {
                    color: inherit;
                    text-decoration: none;
                }

                footer {
                    font-size: 16px !important;
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
                <br />

                <table dxcf="100%" width="100%" cellpadding="3" cellspacing="0" border="1"
                    class="table table-striped table-bordered report-table" id="examples">
                    <thead>
                        <tr>
                            <th class="no-border" colspan="8">Abbreviations</th>
                        </tr>
                        <tr>
                            <th class="no-border">CWS</th>
                            <th class="no-border">TW</th>
                            <th class="no-border">WW</th>
                            <th class="no-border">CW</th>
                            <th class="no-border">SPM</th>
                            <th class="no-border">T</th>
                            <th class="no-border">M</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gradeX">
                            <td class="table-name">Characters (with space)</td>
                            <td class="table-name">Total Words</td>
                            <td class="table-name">Wrong Words</td>
                            <td class="table-name">Correct Words</td>
                            <td class="table-name">Speed Per Mintues</td>
                            <td class="table-name">Tolerance (5%)</td>
                            <td class="table-name">Marks</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-primary report-table-wrapper">
                <table dxcf="100%" cellpadding="3" cellspacing="0" border="1"
                    class="table table-striped table-bordered report-table" id="examples">
                    <thead>
                        <tr>
                            <th class="no-border"> <span>SL.</span> </th>
                            <th class="no-border"> <span>Candidate SL.</span> </th>
                            <th class="no-border"> <span>Roll No.</span> </th>
                            <th class="no-border"> <span>Name</span> </th>
                            <th class="no-border"> <span>Exam Code</span> </th>
                            <th colspan="7" style="border-right: 1.7px solid #8189fd !important">Bangla in
                                {{ $spmDigit }} minutes</th>
                            <th colspan="7">English in {{ $spmDigit }} minutes</th>
                            <th class="no-border"> <span>Average Mark</span> </th>
                            <th class="no-border"> <span>Remarks</span> </th>
                        </tr>


                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>CWS</th>
                            <th>TW</th>
                            <th>WW</th>
                            <th>CW</th>
                            <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                            <th>T</th>
                            <th>M</th>

                            <th>CWS</th>
                            <th>TW</th>
                            <th>WW</th>
                            <th>CW</th>
                            <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                            <th>T</th>
                            <th>M</th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>

                        <?php $passed = 0; ?>
                        <?php $failed = 0; ?>
                        <?php $expelled = 0; ?>
                        <?php $cancelled = 0; ?>
                        <?php $absented = 0; ?>
                        <?php $total = 0; ?>
                        @if ($status == 2)
                            <?php $i = isset($_GET['page']) ? ($_GET['page'] - 1) * 1 + 0 : 0; ?>

                            @foreach ($model as $values)
                                <?php $i++;

                                $values = collect($values);

                                $grouped_by_exam_type = $values->groupBy('exam_type');

                                $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0] : StdClass::fromArray();

                                $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0] : StdClass::fromArray();

                                //revamped calculation from mopa
                                $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                                $bangla_typed_words = ceil($bangla_typed_characters / 5);
                                $bangla_deleted_words = isset($bangla->deleted_words) ? floor($bangla->deleted_words / 5) : 0;
                                $bangla_corrected_words = isset($bangla->inserted_words) ? ceil($bangla->inserted_words / 5) : 0;
                                $bangla_wpm = ceil($bangla_corrected_words / $spmDigit);
                                $bangla_tolerance = $bangla_typed_words == 0 ? 0 : floor(($bangla_deleted_words / $bangla_typed_words) * 100);
                                $bangla_round_marks = ceil((20 / $bangla_speed) * $bangla_wpm);
                                $bangla_marks = $bangla_round_marks > 50 ? 50 : $bangla_round_marks;

                                $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                                $english_typed_words = ceil($english_typed_characters / 5);
                                $english_deleted_words = isset($english->deleted_words) ? floor($english->deleted_words / 5) : 0;
                                $english_corrected_words = isset($english->inserted_words) ? ceil($english->inserted_words / 5) : 0;
                                $english_wpm = ceil($english_corrected_words / $spmDigit);
                                $english_tolerance = $english_typed_words == 0 ? 0 : floor(($english_deleted_words / $english_typed_words) * 100);
                                $english_round_marks = ceil((20 / $english_speed) * $english_wpm);
                                $english_marks = $english_round_marks > 50 ? 50 : $english_round_marks;

                                $average = ceil(($bangla_marks + $english_marks) / 2);

                                ?>
                                <tr class="gradeX">
                                    <?php $total++; ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $values[0]->sl }}</td>
                                    <td>{{ $values[0]->roll_no }}</td>

                                    <td class="table-name">

                                        {{ trim($values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name) }}

                                    </td>
                                    <td>{{ $values[0]->exam_code_name }}</td>

                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $bangla_typed_characters }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_typed_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_deleted_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_corrected_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_wpm }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $tolerance >= 0 ? $bangla_tolerance : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $passMark >= 0 ? $bangla_marks : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $english_typed_characters }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_typed_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_deleted_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $english_corrected_words }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_wpm }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $tolerance >= 0 ? $english_tolerance : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $passMark >= 0 ? $english_marks : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $averageMark >= 0 ? $average : '' }}
                                    </td>

                                    <td>
                                        @if ($values->lists('attended_typing_test')->contains('true'))
                                            @if ($values->lists('typing_status')->contains('cancelled'))
                                                <?php $remarks = 'Cancelled'; $cancelled++; ?>
                                            @elseif($values->lists('typing_status')->contains('expelled'))
                                                <?php $remarks = 'Expelled'; $expelled++; ?>
                                            @else
                                                @if ($averageMark >= 0)
                                                    @if ($passMark >= 0)
                                                        @if ($tolerance >= 0)
                                                            @if (
                                                                $bangla_marks >= $passMark &&
                                                                    $bangla_tolerance <= $tolerance &&
                                                                    $english_marks >= $passMark &&
                                                                    $english_tolerance <= $tolerance &&
                                                                    $average >= $averageMark)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail'; $failed++; ?>
                                                            @endif
                                                        @else
                                                            @if ($bangla_marks >= $passMark && $english_marks >= $passMark && $average >= $averageMark)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail'; $failed++; ?>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($tolerance >= 0)
                                                            @if ($bangla_tolerance <= $tolerance && $english_tolerance <= $tolerance && $average >= $averageMark)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail'; $failed++; ?>
                                                            @endif
                                                        @else
                                                            @if ($average >= $averageMark)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail';  $failed++; ?>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($passMark >= 0)
                                                        @if ($tolerance >= 0)
                                                            @if (
                                                                $bangla_marks >= $passMark &&
                                                                    $bangla_tolerance <= $tolerance &&
                                                                    $english_marks >= $passMark &&
                                                                    $english_tolerance <= $tolerance)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail'; $failed++; ?>
                                                            @endif
                                                        @else
                                                            @if ($bangla_marks >= $passMark && $english_marks >= $passMark)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail';  $failed++; ?>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($tolerance >= 0)
                                                            @if ($bangla_tolerance <= $tolerance && $english_tolerance <= $tolerance)
                                                                <?php $remarks = 'Pass'; $passed++; ?>
                                                            @else
                                                                <?php $remarks = 'Fail';  $failed++; ?>
                                                            @endif
                                                        @else
                                                            <?php $remarks = $bangla_wpm + $english_wpm; ?>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            @if ($values->lists('typing_status')->contains('cancelled'))
                                                <?php $remarks = 'Cancelled'; $cancelled++; ?>
                                            @elseif($values->lists('typing_status')->contains('expelled'))
                                                <?php $remarks = 'Expelled'; $expelled++; ?>
                                            @else
                                                <?php $remarks = 'Absent'; $absented++; ?>
                                            @endif
                                        @endif
                                        {!! $remarks !!}
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @if ($passMark < 0 && $tolerance < 0 && $averageMark < 0)
                @else
                    <table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1"
                        class="table table-striped table-bordered report-table" id="examples">
                        <tr>
                            <th>Pass</th>
                            <th>Fail</th>
                            <th>Expellled</th>
                            <th>Cancelled</th>
                            <th>Absent</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>{{ $passed }}</td>
                            <td>{{ $failed }}</td>
                            <td>{{ $expelled }}</td>
                            <td>{{ $cancelled }}</td>
                            <td>{{ $absented }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    </table>
                @endif

            </div>

            <footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

        </div>

    </div>




















    <div class="table-primary print-report-table-wr-wrapper">


        <style>
            .print-show {
                display: none;
            }

            table thead tr th:last-child {
                border-right: 1px solid #333 !important;
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
                    border: 1px solid #333 !important;
                }

                thead tr th:empty {
                    border-right: none !important;
                    border-top: none !important;
                }

                thead:first-child tr,
                thead tr th.no-border {
                    border-bottom: 0 !important;
                }


                .no-border span {
                    position: relative;
                    top: 18px;
                }

                .print-hide {
                    display: none !important;
                }

                .print-show {
                    display: block !important;
                }

                .header {
                    font-family: SolaimanLipi !important;
                    font-size: 15px !important;
                    text-align: center;
                    max-width: 400px;
                    margin: 5px auto;
                }

                .header-section {
                    margin-bottom: 20px;
                }

                table,
                th,
                td {
                    border: 1px solid #333 !important;
                }

                .table-primary thead tr th:empty {
                    /*border-right: none !important;*/
                    border-top: none !important;
                }

                table thead tr th:last-child {
                    border-right: 1px solid #333 !important;
                }

                .no-border span {
                    position: relative;
                    top: 18px;
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

                .graph-button {
                    color: inherit;
                    text-decoration: none;
                }

                footer {
                    font-size: 16px !important;
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
                <br />
                <table width="100%" cellpadding="3" cellspacing="0" border="1"
                    class="table table-striped table-bordered report-table" id="examples">
                    <thead>
                        <tr>
                            <th class="no-border" colspan="8">Abbreviations</th>
                        </tr>
                        <tr>
                            <th class="no-border">CWS</th>
                            <th class="no-border">TW</th>
                            <th class="no-border">WW</th>
                            <th class="no-border">CW</th>
                            <th class="no-border">SPM</th>
                            <th class="no-border">T</th>
                            <th class="no-border">M</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gradeX">
                            <td class="table-name">Characters (with space)</td>
                            <td class="table-name">Total Words</td>
                            <td class="table-name">Wrong Words</td>
                            <td class="table-name">Correct Words</td>
                            <td class="table-name">Speed Per Mintues</td>
                            <td class="table-name">Tolerance (5%)</td>
                            <td class="table-name">Marks</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-primary report-table-wrapper">
                <table dxcf="100%" cellpadding="3" cellspacing="0" border="1"
                    class="table table-striped table-bordered report-table" id="examples">
                    <thead>
                        <tr>
                            <th class="no-border"> <span>SL.</span> </th>
                            <th class="no-border"> <span>Candidate SL.</span> </th>
                            <th class="no-border"> <span>Roll No.</span> </th>
                            <th class="no-border"> <span>Name</span> </th>
                            <th class="no-border"> <span>Exam Code</span> </th>
                            <th colspan="7" style="border-right: 1.7px solid #8189fd !important">Bangla in
                                {{ $spmDigit }} minutes</th>
                            <th colspan="7">English in {{ $spmDigit }} minutes</th>
                            <th class="no-border"> <span>Average Mark</span> </th>
                            <th class="no-border"> <span>Remarks</span> </th>
                        </tr>


                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>CWS</th>
                            <th>TW</th>
                            <th>WW</th>
                            <th>CW</th>
                            <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                            <th>T</th>
                            <th>M</th>

                            <th>CWS</th>
                            <th>TW</th>
                            <th>WW</th>
                            <th>CW</th>
                            <th style="border-right: 1.7px solid #8189fd !important">SPM</th>
                            <th>T</th>
                            <th>M</th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>

                        @if ($status == 2)
                            <?php $i = isset($_GET['page']) ? ($_GET['page'] - 1) * 1 + 0 : 0; ?>

                            @foreach ($model as $values)
                                <?php $i++;

                                $values = collect($values);

                                $grouped_by_exam_type = $values->groupBy('exam_type');

                                $bangla = isset($grouped_by_exam_type['bangla']) ? $grouped_by_exam_type['bangla'][0] : StdClass::fromArray();

                                $english = isset($grouped_by_exam_type['english']) ? $grouped_by_exam_type['english'][0] : StdClass::fromArray();

                                //revamped calculation from mopa
                                $bangla_typed_characters = isset($bangla->typed_words) ? $bangla->typed_words : 0;
                                $bangla_typed_words = ceil($bangla_typed_characters / 5);
                                $bangla_deleted_words = isset($bangla->deleted_words) ? floor($bangla->deleted_words / 5) : 0;
                                $bangla_corrected_words = isset($bangla->inserted_words) ? ceil($bangla->inserted_words / 5) : 0;
                                $bangla_wpm = ceil($bangla_corrected_words / $spmDigit);
                                $bangla_tolerance = $bangla_typed_words == 0 ? 0 : floor(($bangla_deleted_words / $bangla_typed_words) * 100);
                                $bangla_round_marks = ceil((20 / $bangla_speed) * $bangla_wpm);
                                $bangla_marks = $bangla_round_marks > 50 ? 50 : $bangla_round_marks;

                                $english_typed_characters = isset($english->typed_words) ? $english->typed_words : 0;
                                $english_typed_words = ceil($english_typed_characters / 5);
                                $english_deleted_words = isset($english->deleted_words) ? floor($english->deleted_words / 5) : 0;
                                $english_corrected_words = isset($english->inserted_words) ? ceil($english->inserted_words / 5) : 0;
                                $english_wpm = ceil($english_corrected_words / $spmDigit);
                                $english_tolerance = $english_typed_words == 0 ? 0 : floor(($english_deleted_words / $english_typed_words) * 100);
                                $english_round_marks = ceil((20 / $english_speed) * $english_wpm);
                                $english_marks = $english_round_marks > 50 ? 50 : $english_round_marks;

                                $average = ceil(($bangla_marks + $english_marks) / 2);

                                ?>
                                <tr class="gradeX">

                                    <td>{{ $i }}</td>
                                    <td>{{ $values[0]->sl }}</td>
                                    <td>{{ $values[0]->roll_no }}</td>
                                    <td class="table-name">

                                        {{ trim($values[0]->username . ' ' . $values[0]->middle_name . ' ' . $values[0]->last_name) }}

                                    </td>
                                    <td>{{ $values[0]->exam_code_name }}</td>

                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $bangla_typed_characters }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_typed_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_deleted_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_corrected_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $bangla_wpm }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $tolerance >= 0 ? $bangla_tolerance : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $passMark >= 0 ? $bangla_marks : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $english_typed_characters }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_typed_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_deleted_words }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $english_corrected_words }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">{{ $english_wpm }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $tolerance >= 0 ? $english_tolerance : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $passMark >= 0 ? $english_marks : '' }}</td>
                                    <td style="border-right: 1.7px solid #8189fd !important">
                                        {{ $averageMark >= 0 ? $average : '' }}
                                    </td>
                                    <td style="border-right: 1.7px solid #8189fd !important"></td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>

            <footer style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

        </div>

    </div>

    <!-- page end-->

    <!--script for this page only-->

    <script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>

    <script>
        $('.search_roll_no').keyup(function(event) {





        });

        function report_exam_code() {

            var exam_code = $('#exam_code').val();

            if (exam_code != '') {

                $('#company_list,#designation_list,#exam_date_from,#exam_date_to').prop('disabled', true);

                $('#company_list,#designation_list,#exam_date_from,#exam_date_to').val('').trigger('change');

                $('.jrequired').hide();

                $('#company_list,#designation_list,#exam_date_from,#exam_date_to').attr('required', false);


            } else {

                $('#company_list,#designation_list,#exam_date_from,#exam_date_to').prop('disabled', false);

                $('.jrequired').show();

                $('#company_list,#designation_list,#exam_date_from,#exam_date_to').attr('required', true);


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

        $('form').on('submit', function(e) {
            $('select, #exam_date').prop('disabled', false);
        });

        /* $('.report-form').submit(function(e){
                var company_id = $('#company_id').val();
                var designation_id = $('#designation_id').val();
                var exam_date = $('#exam_date').val();
                var bangla_speed = $('#bangla_speed').val();
                var english_speed = $('#english_speed').val();
             if(company_id.length <= 0 || designation_id.length <= 0 || exam_date.length <= 0 || bangla_speed.length <= 0 || english_speed.length <= 0 ){
                 $('.alert-danger').show();
                 $('.msg').html('Please fill out all input field!');
                 $( "#button" ).prop( "disabled", true );
                 return false;
             }
             $( "#button" ).prop( "disabled", false );
         })*/

        // $('#button').click(function(e){

        //     var company_id = $('#company_id').val();
        //     var designation_id = $('#designation_id').val();
        //     var exam_date_from = $('#exam_date_from').val();
        //     var exam_date_to = $('#exam_date_to').val();
        //     var bangla_speed = $('#bangla_speed').val();
        //     var english_speed = $('#english_speed').val();
        //     if(company_id.length <= 0 || designation_id.length <= 0 || exam_date_from.length <= 0 || exam_date_to.length <= 0 || bangla_speed.length <= 0 || english_speed.length <= 0 ){
        //         $('.alert-danger').show();
        //         $('.msg').html('Please fill out all input field!');
        //     }else{
        //         $('.report-form').submit();
        //     }

        // })




        $('.print-button').click(function(event) {

            w = window.open('', '_blank');
            w.document.write(document.getElementsByClassName('print-report-table-wrapper')[0].outerHTML);
            w.print();
            w.close();

        });


        $('.print-button-wr').click(function(event) {

            w = window.open('', '_blank');
            w.document.write(document.getElementsByClassName('print-report-table-wr-wrapper')[0].outerHTML);
            w.print();
            w.close();

        });
    </script>

@stop



@section('custom-script')
    <script>
        // var column_index = ['1','2'];
        // create_dropdown_column(column_index);
        // var table = $('#examples3').DataTable();


        var table = $('#examples_report').DataTable({
            "language": {
                "search": "Search:"
            },
            "aaSorting": [
                [1, 'asc']
            ],
            "pageLength": 1000,
        });



        $('#examples_report_filter input').on('keyup', function() {

            table
                .column(2)
                .search(this.value)
                .draw();

        });
    </script>
@stop
