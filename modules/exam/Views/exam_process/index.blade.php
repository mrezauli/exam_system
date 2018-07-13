@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<style>
    table.dataTable.process-table tfoot tr th:last-child input,
    form table.dataTable tfoot tr th:first-child input{
        visibility: visible !important;
    }
</style>

        <!-- page start-->

<div class="inner-wrapper index-page">

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">

                    {{ $page_title }}

                    <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-process')}}">
                        <b>Examination Process</b>
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


                        <table  class="display table table-bordered table-striped process-table" id="example">
                            <thead>
                            <tr>
                                <th> Exam Code </th>
                                <th> Organization </th>
                                <th> Post Name </th>
                                <th> Exam Date </th>
                                <th> Shift </th>
                                <th> Exam Type </th>
                                <th> Sl No From </th>
                                <th> Sl No To </th>
                                <th> Exam Status </th>
                                <th> Activation </th>
                            </tr>
                            </thead>

                            <tfoot class="search-section">
                            <tr>
                                <th> Exam Code </th>
                                <th> Organization </th>
                                <th> Post Name </th>
                                <th> Exam Date </th>
                                <th> Shift </th>
                                <th> Exam Type </th>
                                <th> Sl No From </th>
                                <th> Sl No To </th>
                                <th> Exam Status </th>
                                <th> Activation </th>
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
                                        <td>{{ isset($values->exam_code->shift)?ucfirst(\App\Helpers\ImageResize::shift($values->exam_code->shift)):''}}</td>
                                        <td>{{ isset($values->exam_code->exam_type)?$values->exam_code->exam_type:''}}</td>
                                        <td>{{ isset($values->sl_from)? $values->sl_from : ''}}</td>
                                        <td>{{ isset($values->sl_to)? $values->sl_to : ''}}</td>
                                        <td>{{ isset($values->status)? $values->status : ''}}</td>
                                        <td>
                                        @if($values->status == 'active')
                                            <a href="{{ route('deactivate-process', $values->id) }}" class="btn btn-primary btn-xs edit-meeting">Deactivate</a>
                                        {{--@else
                                        <a href="{{ route('reactivate-process', $values->id) }}" class="btn btn-primary btn-xs edit-meeting">Activate</a>--}}

                                        @endif
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



@section('custom-script')
<script>
    
var column_index = [];
create_dropdown_column(column_index);

</script>
@stop