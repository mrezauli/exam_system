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
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                    <b>Add Post</b>
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


                    <table class="display table table-bordered table-striped company-table" id="example">
                        <thead>
                        <tr>
                            <th> Post Name </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </thead>

                        <tfoot class="search-section">
                        <tr>
                            <th> Post Name </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{$values->designation_name}}</td>
                                    <td>{{$values->status}}</td>
                                    <td>
                                        <a href="{{ route('view-designation', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-designation', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="update"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-designation', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
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

<!-- modal -->
<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <a href="{{route('designation')}}" class="close" type="button"> &times; </a>
                <h4 class="modal-title">{{ $page_title }} </h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'store-designation','id' => 'jq-validation-form']) !!}
                @include('admin::designation._form')
                {!! Form::close() !!}
            </div> <!-- / .modal-body -->

        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

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
@if(Session::has('flash_message_error'))
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

        var column_index = [];
        create_dropdown_column(column_index);

    </script>
@stop