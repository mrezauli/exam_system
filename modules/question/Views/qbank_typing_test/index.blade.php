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

                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-qbank-typing-test')}}">
                    <b>Add Questions</b>
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

                    
                    <table  class="display table table-bordered table-striped typing-bank-table" id="example">
                        <thead>
                        <tr> 
                            <th> Exam Type </th>
                            <th> Question </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </thead>
 

                        <tfoot class="search-section">
                        <tr> 
                            <th> Exam Type </th>
                            <th> Question </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody> 

                        @if(isset($data))
                            @foreach($data as $values)
                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">
                                    <td>{{ucfirst($values->exam_type)}}</td>
                                    <td>{{$values->typing_question}}</td>
                                    <td>{{ucfirst($values->status)}}</td>
                                    <td>
                                        <a href="{{ route('view-qbank-typing-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-qbank-typing-test', $values->id) }}" class="btn btn-primary btn-xs edit-meeting" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-qbank-typing-test', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
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

        var column_index = ['1'];
        create_dropdown_column(column_index);

    </script>
@stop