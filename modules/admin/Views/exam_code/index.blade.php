@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<div class="row company-index-page">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $page_title }}
               {{--  <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <b>Generate Exam Code</b>
                </a> --}}

                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-exam-code')}}">
                    <b>Generate Exam Code</b>
                </a>

            </header>


{{--             @if($errors->any())
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
            @endif --}}


            <div class="panel-body">
                <div class="adv-table">


                    <p> &nbsp;</p>
                    <p> &nbsp;</p>


                    <table class="display table table-bordered table-striped company-table" id="example">
                        <thead>
                        <tr>
                            <th> Exam Code Number</th>
                            <th> Organization Name</th>
                            <th> Post Name</th>
                            <th> Exam Date</th>
                            <th> Shift</th>
                            <th> Exam Type</th>
                            <th> Action</th>
                        </tr>
                        </thead>

                        <tfoot class="search-section">
                        <tr>
                            <th> Exam Code Number</th>
                            <th> Organization Name</th>
                            <th> Post Name</th>
                            <th> Exam Date</th>
                            <th> Shift</th>
                            <th> Exam Type</th>
                            <th> Action</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{$values->exam_code_name}}</td>
                                    <td>{{isset($values->company->company_name) ? $values->company->company_name : ''}}</td>
                                    <td>{{isset($values->designation->designation_name) ? $values->designation->designation_name : ''}}</td>
                                    <td>{{$values->exam_date}}</td>
                                    <td>{{$values->shift}}</td>
                                    <td>{{$values->exam_type}}</td>

                                    <td>
                                        <a href="{{ route('view-exam-code', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-exam-code', $values->id) }}" class="btn btn-primary btn-xs edit-meeting"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-exam-code', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                        @endforeach
                        @endif
                    </table>
                    {{--<span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>--}}
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->


<!-- Modal  -->
<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>

<!-- modal -->


<!--script for this page only-->



@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif
@if(Session::has('danger'))
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
@endif

        <!--script for this page only-->
@stop

@section('custom-script')

    <script>

        $('.datepicker').each(function(index, el) {

            $(el).datepicker({
                format: 'yyyy-mm-dd'
            });

        });

        var column_index = ['2','6'];
        create_dropdown_column(column_index);
        
    </script>
    
@stop