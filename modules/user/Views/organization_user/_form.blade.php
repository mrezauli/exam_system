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


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6 company_div">
                    <label>Organization Name:<span class="red">*</span></label>
                    @if(count($company_list)>0)
                    {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                    @else
                    {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                    @endif
                </div>
                <div class="col-sm-6">
                    {!! Form::label('username', 'First Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::text('username',Input::old('username'),['class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter First Name']) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('middle_name', 'Middle Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('middle_name',Input::old('middle_name'),['class' => 'form-control','placeholder'=>'Middle Name','autofocus', 'title'=>'Enter Middle Name']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::text('last_name',Input::old('last_name'),['class' => 'form-control','placeholder'=>'Last Name','autofocus', 'required', 'title'=>'Enter Last Name']) !!}
                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
            <div class="col-sm-6 pull-right">
                    {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                    <small class="required">*(Organization Email Preffered)</small>
                    {!! Form::email('email',Input::old('email'),['class' => 'form-control','placeholder'=>'Email Address','required', 'title'=>'Enter User Email Address']) !!}
                </div>
            </div>
        </div>

        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
                     <small class="required">*</small>
                    {!! Form::password('password',['id'=>'user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter User Password','minlength'=>'3']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('confirm_password', 'Confirm Password') !!}
                     <small class="required">*</small>
                    {!! Form::password('re_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','required','id'=>'re-password','name'=>'re_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.','minlength'=>'3']) !!}
                    <span id='show-message'></span>

                </div>
            </div>
        </div>


        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-12 mt20">
                    <div class="g-recaptcha pull-right" data-sitekey="{{$site_key}}"></div>
                </div>
            </div>
        </div>


            <input type="hidden" name="status" id="status" class="form-control" value="active">




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
         format: 'yyyy-mm-dd'
     });

    });
</script>
