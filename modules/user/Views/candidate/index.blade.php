@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

        <style>
            .panel-heading #down
            {
                background-color: #5cb85c;
                border-color: #4cae4c;
            }

            .panel-heading #down:hover {
                background-color: #337ab7;
            }
        </style>

        <!-- page start-->
<div class="inner-wrapper index-page user-index-page">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{ $pageTitle }}</span>
                <a class="btn-primary btn-sm pull-right paste-blue-button-bg" data-toggle="modal" href="#createData" data-placement="left" data-content="click 'add user' button to add new user">
                    <strong>Import Candidate Data From Excel Sheet</strong>
                </a>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body">

                <p> &nbsp;</p>

                {!! Form::open(['method' =>'GET','route'=>'candidate-list','class'=>'report-form','']) !!}
                <div class="col-sm-12 ddd_margin">

                <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('company_id',$company_list, @Input::get('company_id')? Input::get('company_id') : null,['id'=>'company_list','class' => 'form-control js-select','placeholder'=>'select company', 'title'=>'select company','required'=>'required']) !!}
                    </div>

                <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                        <small class="required jrequired">(Required)</small>
                        {!! Form::Select('designation_id',$designation_list, @Input::get('designation_id')? Input::get('designation_id') : null,['id'=>'designation_list','class' => 'form-control js-select','placeholder'=>'select industry type', 'title'=>'select industry type','requiredz'=>'requiredz']) !!}
                    </div>

                <div class="col-lg-1 col-md-3 col-sm-6 filter-btn">

                      {!! Form::submit('Generate Result', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'submit-button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div>
                    
                </div>

                {!! Form::close() !!}  

                <p> &nbsp;</p>

                {{------------- Filter :Ends --------------------------------------------}}
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered no_paginationz" id="example">
                        <thead>
                        <tr>
                            <th> SL No </th>
                            <th> Organization </th>
                            <th> Name of the Post </th>
                            <th>Roll No</th>
                            <th> Name </th>
                            <th> DOB </th>
                            <th> NID </th>
                            <th> Typing Status </th>
                            <th> Apt. Status </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content=""></span></th>
                        </tr>
                        </thead>

                        <tfoot class="search-section">
                        <tr>
                            <th> SL No </th>
                            <th> Organization </th>
                            <th> Name of the Post </th>
                            <th>Roll No</th>
                            <th> Name </th>
                            <th> DOB </th>
                            <th> NID </th>
                            <th> Typing Status </th>
                            <th> Apt. Status </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content=""></span></th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @if(isset($model))
                            @foreach($model as $values)
                                <tr class="gradeX">
                                    <td>{{$values->sl}}</td>
                                    <td>{{isset($values->relCompany->company_name) ? $values->relCompany->company_name : ''}}</td>
                                    <td>{{isset($values->relDesignation->designation_name) ? $values->relDesignation->designation_name : ''}}</td>
                                    <td>{{$values->roll_no}}</td>
                                    <td>{{$values->username}}</td>
                                    <td>{{$values->dob}}</td>
                                    <td>{{$values->nid}}</td>
                                    <td>{{ucfirst($values->typing_status)}}</td>
                                    <td>{{ucfirst($values->aptitude_status)}}</td>
                                    <td>
                                        <a href="{{ route('show-candidate', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-candidate', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="update" onclick="open_modal();"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-candidate', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete" onclick="open_modal();"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span> --}}
            </div>
        </div>
    </div>
</div>
<!-- page end-->


<!-- modal -->


<div id="createData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg import-candidate-modal" style="z-index:1050">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                <h4 class="modal-title" id="myModalLabel">Create Candidate<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>
            </div>
            <div class="modal-body">

                @include('user::candidate._create')

            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>


<!-- Modal  -->

<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>

<style>
    
form.report-form .col-sm-12.ddd_margin{
    margin-bottom: 15px !important;
    margin-left: -15px !important;
    padding: 0;
}

</style>

<!-- modal -->

<script>

$(document).ready(function() {

$("form").submit(function(e) {

    $(this).submit(function() {

        return false;

    });

    return true;

});



$(".upload-button").one("click", function() {
    $(this).click(function () { return false; });
});

});


    function open_modal(){
        document.getElementById('load').style.visibility="visible";
    }

    $('#jq-validation-form').submit(function() {
        $('#gif').css('visibility', 'visible');
        //return true;
    });

</script>

<!--script for this page only-->
@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });

    </script>
@endif

@stop


@section('custom-script')
    <script>

        var column_index = ['2','3','8','9'];
        create_dropdown_column(column_index);

    </script>
@stop