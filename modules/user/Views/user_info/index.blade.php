@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="hpanel hgreen">
                <div class="panel-body">
                    <div class="pull-right text-right">
                        {{--<div class="btn-group">
                            <i class="fa fa-facebook btn btn-default btn-xs"></i>
                            <i class="fa fa-twitter btn btn-default btn-xs"></i>
                            <i class="fa fa-linkedin btn btn-default btn-xs"></i>
                        </div>--}}
                    </div>
                    @if(isset($user_image))
                    <img alt="" class="img-circle" src="{{ URL::to($user_image->thumbnail) }}" width="100px" height="100px">
                    @else
                        <img class="img-circle" src="{{ URL::to('/assets/img/default.jpg') }}" width="40%" height="20%">
                     @endif
                    <h4>
                        <a href="">{{isset($profile_data->first_name)?$profile_data->first_name:''}} {{isset($profile_data->middle_name)?$profile_data->middle_name:''}} {{isset($profile_data->last_name)?$profile_data->last_name:''}}</a>
                        <br>
                        <br>
                    @if(isset($user_image))
                        <a href="{{route('edit-profile-image',$user_image->id)}}" class="btn btn-primary btn-xs" data-placement="top" data-toggle="modal" data-target="#editImageModal">Edit Picture</a>
                    @else
                        <a data-toggle="modal" href="#addImageModal" class="btn btn-primary btn-xs" data-placement="top" data-toggle="modal" >Add Picture</a>
                    @endif
                    <h6>Email Address :{{isset(Auth::user()->email)?Auth::user()->email:''}}</h6>
                    </h4>

                </div>
            </div>
        </div>

        <?php $role_name = Session::get('role_title'); ?>

        <div class="col-lg-9">
            <div class="hpanel">
                <div class="hpanel">

                    <ul class="nav nav-tabs">
                        @if($role_name != 'organization' && $role_name != 'candidate')
                            <li class="active"><a href="{{route('user-info',['value'=>'profile'])}}" data-target="#profile" class="media_node" id="new_tab" data-toggle="ajax-tab" rel="tooltip">Profile</a></li>
                        @endif
                        <li><a href="{{route('user-info',['value'=>'acc-settings'])}}" data-target="#acc-settings" class="media_node" id="replied_tab" data-toggle="ajax-tab" rel="tooltip">Account Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        @if($role_name != 'organization' && $role_name != 'candidate')
                            <div class="tab-pane active" id="profile">
                        @endif
                        </div>
                        <div class="tab-pane" id="acc-settings">

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
                $('[data-toggle="ajax-tab"]').click(function(e) {
                    //alert('hggfhgh');
                    var $this = $(this),
                            loadurl = $this.attr('href'),
                            targ = $this.attr('data-target');

                    $.get(loadurl, function(data) {
                        $(targ).html(data);
                    });
                    $this.tab('show');
                    return false;
                });

            $(window).load(function() {
                $.ajax({
                    url : 'user-info/profile',
                    dataType: 'json'
                }).done(function (data) {
                    $('#profile').html(data);
                }).fail(function () {
//                    alert('Posts could not be loaded.');
                    return false;
                });
            });
        });
</script>

    <div id="addProfile" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" style="z-index: 1050">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h6 class="modal-title" id="myModalLabel">Add Profile Informations <span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h6>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'store-user-profile','id' => 'form_2','files'=>'true']) !!}
                    @include('user::user_info.profile._form')
                    {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->

    <div id="passwordModal" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog" style="z-index: 1050">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Change Password<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field. <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'update-password','id' => 'change-pss']) !!}
                              @include('user::change_password._password_form')
                    {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>

    <!-- Modal  -->

    <div id="addImageModal" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog" style="z-index: 1050">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add/Edit Image<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'store-profile-image','id' => 'form_2','files'=>'true']) !!}
                         {!! Form::hidden('user_id',isset($user_id)?$user_id:'') !!}
                         @include('user::user_info.profile_image.add_image')
                    {!! Form::close() !!}
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>


    <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="z-index: 1050">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- modal -->

    <div class="modal fade" id="entsolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="z-index: 1050">
            <div class="modal-content">
            </div>
        </div>
    </div>
@stop


