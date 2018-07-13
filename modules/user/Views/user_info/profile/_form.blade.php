<script src="assets/bitd/js/jquery.min.js"></script>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    {!! Form::hidden('user_id',$user_id) !!}
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('first_name', Input::old('first_name'), ['id'=>'first_name', 'class' => 'form-control', 'required'=>'required','title'=>'Enter Your First Name']) !!}
        </div>

        <div class="col-sm-6">
            {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('last_name', Input::old('last_name'), ['id'=>'last_name', 'class' => 'form-control','required'=>'required','title'=>'Enter Your Last Name']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('telephone_number', 'Telephone Number:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('telephone_number', Input::old('telephone_number'), ['class' => 'form-control','required'=>'required','title'=>'Enter Telephone Number']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            <div class="input-group date">
                {!! Form::text('date_of_birth', Input::old('date_of_birth'), ['class' => 'form-control datepicker','required','title'=>'select birth date']) !!}
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address', ' Address:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
                {!! Form::textarea('address', Input::old('address'), ['id'=>'address', 'class' => 'form-control','size' => '12x3','title'=>'enter address of user','required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('image', 'Image:', ['class' => 'control-label']) !!}
            <p class="narration">System will allow these types of image(png,gif,jpeg,jpg Format) </p>
            @if(isset($user_image))
                <img src="{{ URL::to($user_image->thumbnail) }}" width="100px" height="100px">
            @endif
            {!! Form::file('image',Input::old('image'), [ 'class' => 'form-control','required','title'=>'Add Profile Image only png,gif,jpeg,jpg Format']) !!}
        </div>
    </div>
</div>

<div class="save-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save branch information']) !!}
    <a href="{{route('user-profile')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>


<script>

    //document.onload = function(e) {
    $(function () {
        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                password: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                max: {
                    required: true,
                    maxlength: 4
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
            errorPlacement: function (error, element) {
                $(element)
                        .closest("form")
                        .find("label[for='" + element.attr("id") + "']")
                        .append(error);
            },
            errorElement: "span",
        });
    });
    //}
</script>

@include('user::user_info.profile._script')

