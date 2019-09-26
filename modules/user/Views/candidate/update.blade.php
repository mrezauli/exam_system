<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
        <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
        <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
    </div>


    <div class="modal-body">
            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-candidate', $data->id],'id'=>'user-jq-validation-form']) !!}
            {!! Form::hidden('id', $data->id) !!}
            {{--@include('user::user._form')--}}

            <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('username', 'Candidate Name:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::text('username',Input::old('username'),['class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter User Name']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('roll_no', 'Roll Number:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::text('roll_no',Input::old('roll_no'),['class' => 'form-control','placeholder'=>'Roll Number','required','autofocus', 'title'=>'Enter Roll Number']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('nid', 'NID:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::text('nid',Input::old('nid'),['class' => 'form-control','placeholder'=>'NID','required','autofocus', 'title'=>'Enter NID']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('dob', 'DOB:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>

                            @if(isset($data->dob))
                                {!! Form::text('dob', Input::old('dob'), ['class' => 'form-control datepicker','required','title'=>'select dob']) !!}
                            @else
                                {!! Form::text('dob', $days, ['class' => 'form-control bs-datepicker-component','required','title'=>'select dob']) !!}
                            @endif

                            <span class="input-group-btn add-on">
                                <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                            </span>

                    </div>
                </div>
            </div>

            <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('district', 'District:', ['class' => 'control-label']) !!}
                         <small class="required">*</small>
                        {!! Form::text('district',Input::old('district'),['class' => 'form-control','placeholder'=>'district','required', 'title'=>'Enter district']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('typing_status', 'Typing Status:', ['class' => 'control-label']) !!}
                        {!! Form::Select('typing_status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('typing_status'),['class'=>'form-control ','required','disabled']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('aptitude_status', 'Aptitude Status:', ['class' => 'control-label']) !!}
                        {!! Form::Select('aptitude_status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('aptitude_status'),['class'=>'form-control ','required','disabled']) !!}
                    </div>
                </div>
            </div>

            {{-- 'data-content'="click close button for close this entry form"
            'data-content'=>'click save changes button for save role information' --}}

            <div class="form-margin-btn">
                <a href="{{route('candidate-list')}}" class=" btn btn-default mt-23" data-placement="top">Close</a>
                {!! Form::submit('Save changes', ['id'=>'user-btn-disabled','class' => 'btn btn-primary mt-23','data-placement'=>'top']) !!}
            </div>

            <input type="hidden" name="typing_status" id="input" class="form-control" value="{{$data->typing_status}}">
            <input type="hidden" name="aptitude_status" id="input" class="form-control" value="{{$data->aptitude_status}}">

            {!! Form::close() !!}
        </div>
    </div>
</div>




<script>

$('.datepicker').each(function(index, el) {
    
 $(el).datepicker({
     format: 'yyyy-mm-dd',
     autoclose:true
 });

});

    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                }, 300);
            });


    $(".form-control").tooltip();
    $('input:disabled, button:disabled').after(function (e) {
        d = $("<div>");
        i = $(this);
        d.css({
            height: i.outerHeight(),
            width: i.outerWidth(),
            position: "absolute",
        })
        d.css(i.offset());
        d.attr("title", i.attr("title"));
        d.tooltip();
        return d;
    });

    function validation() {
        $('#user-re-password').on('keyup', function () {
            if ($(this).val() == $('#edit-user-password').val()) {

                $('#user-show-message').html('');
                document.getElementById("user-btn-disabled").disabled = false;
                return false;
            }
            else $('#user-show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("user-btn-disabled").disabled = true;
        });
    }
    //edit-user...........
    /*$("#user-jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'jq-validation-email': {
                required: true,
                email: true
            },
            'jq-validation-password': {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            'jq-validation-password-confirmation': {
                required: true,
                minlength: 6,
                equalTo: "#jq-validation-password"
            },
            'jq-validation-required': {
                required: true
            },
            'jq-validation-url': {
                required: true,
                url: true
            },
            'jq-validation-phone': {
                required: true,
                phone_format: true
            },
            'email': {
                required: true,
                email: true
            },
            'currency_id': {
                required: true
            },
            'status': {
                required: true
            },'pBranch': {
                required: true
            },

            'jq-validation-multiselect': {
                required: true,
                minlength: 2
            },
            'jq-validation-select2': {
                required: true
            },
            'jq-validation-select2-multi': {
                required: true,
                minlength: 2
            },
            'jq-validation-text': {
                required: true
            },
            'jq-validation-simple-error': {
                required: true
            },
            'jq-validation-dark-error': {
                required: true
            },
            'jq-validation-radios': {
                required: true
            },
            'jq-validation-checkbox1': {
                require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
            },
            'jq-validation-checkbox2': {
                require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
            },
            'jq-validation-policy': {
                required: true
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });*/
    //change password checkbox....
    $('#checkbox').change(function (){

        var check_value = $("#checkbox").is(":checked");
        if(check_value){
            $('#pass-old').hide();
            $('#re-pass').hide();
            $('#field-password').show();
            $('#field-con-password').show();
        }else{
            $('#pass-old').show();
            $('#re-pass').show();
            $('#field-password').hide();
            $('#field-con-password').hide();
        }

    })

</script>


