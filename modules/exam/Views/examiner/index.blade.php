@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper index-page">

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">

                    {{ $page_title }}

                    <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-examiner')}}">
                        <b>Select Examiner</b>
                    </a>
                </header>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('flash_message') }}</p>
                    </div>
                @endif

                <div class="panel-body">
                    <div class="adv-table">

                        <p> &nbsp;</p>
                        <p> &nbsp;</p>
                        {{-------------- Filter :Ends ----------------------------------------- --}}


                        <table  class="display table table-bordered table-striped meeting-table" id="example">
                            <thead>
                            <tr>
                                <th> Exam Code </th>
                                <th> Organization </th>
                                <th> Post Name </th>
                                <th> Exam Date </th>
                                <th> Actions </th>
                            </tr>
                            </thead>


                            <tfoot class="search-section">
                            <tr>
                                <th> Exam Code </th>
                                <th> Organization </th>
                                <th> Post Name </th>
                                <th> Exam Date </th>
                                <th> Actions </th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @if(isset($data))
                                @foreach($data as $values)
                                    <tr class="gradeX">
                                        <td>{{ isset($values->exam_code->exam_code_name)?$values->exam_code->exam_code_name:''}}</td>
                                        <td>{{ isset($values->exam_code->company->company_name)?$values->exam_code->company->company_name:''}}</td>
                                        <td>{{ isset($values->exam_code->designation->designation_name)?$values->exam_code->designation->designation_name:''}}</td>
                                        <td>{{ isset($values->exam_code->exam_date)?$values->exam_code->exam_date:''}}</td>
                                        <td>
                                            <a href="{{ route('edit-examiner', $values->id) }}" class="btn btn-primary btn-xs edit-meeting"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete-examiner', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- page end-->


<!-- Modal  -->

<div class="modal fade" id="estbModal3" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

</div>

<!-- modal -->
@stop
        <!--script for this page only-->