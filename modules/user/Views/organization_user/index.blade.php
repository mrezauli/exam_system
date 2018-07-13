@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->
<div class="inner-wrapper index-page user-index-page">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"> Organization User List </span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>we can show all user in this page<br> and add new user, update, delete from this page</em>"></span>

                @if($user_role=='admin' || $user_role=='super-admin')
                <a class="btn-primary btn-sm pull-right paste-blue-button-bg" data-toggle="modal" href="#addData" data-placement="left" data-content="click 'add user' button to add new user">
                    <strong>Add Organization User</strong>
                </a>
                @endif
                <div class="clearfix"></div>
            </div>

            <div class="panel-body">

                <p> &nbsp;</p>

                {{------------- Filter :Ends -------------------------------------------}}
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <thead>
                        <tr>
                            {{--<th> id </th>--}}
                            <th> First name </th>
                            <th> Email </th>
                            <th> Organization </th>
                            <th> Status </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content=""></span></th>
                        </tr>
                        </thead>

                        <tfoot class="search-section">
                        <tr>
                            <th> First name </th>
                            <th> Email </th>
                            <th> Organization </th>
                            <th> Status </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content=""></span></th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @if(isset($model))
                            @foreach($model as $values)
                                <tr class="gradeX">
                                    <td>{{ucfirst($values->username)}}</td>
                                    <td>{{$values->email}}</td>
                                    <td>{{isset($values->relCompany->company_name)?$values->relCompany->company_name:''}}</td>
                                    <td>{{$values->status}}</td>
                                    <td>
                                        <a href="{{ route('show-user', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-user', $values->id) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="update" onclick="open_modal();"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-user', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete" onclick="open_modal();"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span>
            </div>
        </div>
    </div>
</div>
<!-- page end-->

<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-md" style="z-index:1050">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                <h4 class="modal-title" id="myModalLabel">Add User Informations <span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2">(?)</font> </span></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'store-organization-user','id' => 'jq-validation-form']) !!}
                @include('user::organization_user._form')
                {!! Form::close() !!}
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>
<!-- modal -->


<!-- Modal  -->

<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>



<!-- modal -->

<script>
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
    
var column_index = [];
create_dropdown_column(column_index);

</script>
@stop