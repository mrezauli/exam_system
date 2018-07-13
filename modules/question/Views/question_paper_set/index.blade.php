@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper index-page question-paper-page">

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">

                {{ $page_title }}

                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-question-paper-set')}}">
                    <b>Create Question Paper</b>
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
                            <th> Question Set Title </th>
                            <th> Actions </th>
                        </tr>
                        </thead>
 

                        <tfoot class="search-section">
                        <tr> 
                            <th> Question Set Title </th>
                            <th> Actions </th>
                        </tr>
                        </tfoot>
                        <tbody> 

                        @if(isset($data))
                            @foreach($data as $values)
                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">
                                    <td>{{ isset($values->question_set_title)?ucfirst($values->question_set_title):''}}</td>
                                    <td>
                                    <a href="{{ route('view-question-paper-set', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-question-paper-set', $values->id) }}" class="btn btn-primary btn-xs edit-meeting"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-question-paper-set', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
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