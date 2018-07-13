@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<?php $user_role = Session::get('role_title'); ?>

        <!-- page start-->
<div class="row company-index-page">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading" class="bangla-font">
                {{ $pageTitle }}
                @if($user_role=='admin' || $user_role == 'super-admin')
                    <a class="btn-sm btn-success pull-right paste-blue-button-bg" data-toggle="modal" href="#addData">
                        <b>Add Organization</b>
                    </a>
                @endif
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
                    


                    
                    <table  class="display table table-bordered table-striped company-table" id="example">
                        <thead>
                        <tr>

                            <th> Organization Name </th>
                            <th> Head of Organization </th>
                            <th> Designation </th>
                            <th> Office Phone </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </thead>

                        <tfoot class="search-section">
                        <tr>
                            <th> Organization Name </th>
                            <th> Contact Person </th>
                            <th> Designation </th>
                            <th> Phone No. </th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">

                                    <td>{{$values->company_name}}</td>
                                    <td>{{$values->contact_person}}</td>
                                    <td>{{$values->designation}}</td>
                                    <td>{{$values->phone}}</td>
                                    <td>{{$values->status}}</td>
                                    <td>
                                        <a href="{{ route('view-company', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-company', $values->id) }}" class="btn btn-primary btn-xs edit-link" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="update"><i class="fa fa-edit"></i></a>
                                        @if($user_role=='admin' || $user_role == 'super-admin')
                                            <a href="{{ route('delete-company', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
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
<!-- page end-->

<div id="addData" class="modal fade company-modal" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="{{route('company')}}" class="close" type="button"> &times; </a>
                <h4 class="modal-title" id="myModalLabel">{{ $pageTitle }} <span style="color:#FF0000">( ই-মেইল ও ওয়েব সাইট ছাড়া প্রতিষ্ঠানের অন্যান্য তথ্যাবলি বাংলায় পূরন করুন )</span></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'store-company','id' => 'jq-validation-form']) !!}
                @include('admin::company._form')
                {!! Form::close() !!}
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<!-- modal -->

<!-- Modal  -->

<div class="modal fade company-modal" id="etsbModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>

<!-- modal -->




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

{{--@include('admin::company._script')--}}
@stop



@section('custom-script')
<script>
    
var column_index = ['1','2'];
create_dropdown_column(column_index);

</script>
@stop