@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif



<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('username', 'First Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('username',Input::old('username'),['class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter First Name']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) !!}
            {!! Form::text('middle_name',Input::old('middle_name'),['class' => 'form-control','placeholder'=>'Middle Name','autofocus', 'title'=>'Enter Middle Name']) !!}
        </div>
    </div>
</div>

<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
            {!! Form::text('last_name',Input::old('last_name'),['class' => 'form-control','placeholder'=>'Last Name','autofocus', 'title'=>'Enter Last Name']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::email('email',Input::old('email'),['class' => 'form-control','placeholder'=>'Email Address','required', 'title'=>'Enter User Email Address']) !!}
        </div>
    </div>
</div>

<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::password('password',['id'=>'user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter User Password']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('confirm_password', 'Confirm Password') !!}
             <small class="required">*</small>
            {!! Form::password('re_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','required','id'=>'re-password','name'=>'re_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.']) !!}
            <span id='show-message'></span>

        </div>
    </div>
</div>
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('role_id', 'User Role:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::Select('role_id',$role, Input::old('role_id'),['style'=>'text-transform:capitalize','class' => 'form-control','required','title'=>'select role name']) !!}
        </div>

        <div class="col-sm-6">
            {!! Form::label('company_id', 'Organization Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            @if(isset($data->company_id))
                {!! Form::text('company_name',isset($data->relCompany->company_name)?$data->relCompany->company_name:'' ,['class' => 'form-control','required','title'=>'select company name','readonly']) !!}
                {!! Form::hidden('company_id', $data->relCompany->id) !!}
            @else
                {!! Form::Select('company_id', $branch_data, Input::old('company_id'),['class' => 'form-control  js-select','required','title'=>'select company name']) !!}
            @endif
        </div>
    </div>
</div>


<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('expire_date', 'Expire Date:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
         
                @if(isset($data->expire_date))
                    {!! Form::text('expire_date', Input::old('expire_date'), ['class' => 'form-control datepicker','required','title'=>'select expire date']) !!}
                @else
                    {!! Form::text('expire_date', $days, ['class' => 'form-control datepicker','required','title'=>'select expire date']) !!}
                @endif

                <span class="input-group-btn add-on">
                    <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                </span>
        
        </div>
        <div class="col-sm-6">
            {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
            {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['class'=>'form-control ','required']) !!}
        </div>
    </div>
</div>

<div class="form-margin-btn">
    <a href="{{route('user-list')}}" class=" btn btn-default mt-23" data-placement="top" data-content="click close button for close this entry form" onclick="close_modal();">Close</a>
    {!! Form::submit('Save changes', ['id'=>'btn-disabled','class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}
</div>

<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>


<script>

    function validation() {
        $('#re-password').on('keyup', function () {
            if ($(this).val() == $('#user-password').val()) {

                $('#show-message').html('');
                document.getElementById("btn-disabled").disabled = false;
                return false;
            }
            else $('#show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("btn-disabled").disabled = true;
        });
    }

    $('.datepicker').each(function(index, el) {
        
     $(el).datepicker({
         format: 'yyyy-mm-dd',
         autoclose:true
     });

    });
</script>
