<div class="modal-dialog modal-lg">
    <div class="modal-content">

<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">
    @section('content_update')
        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-role', $data->slug],'id'=>'update-role']) !!}
        {{--@include('user::role._form')--}}

        <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                    {!! Form::text('title',Input::old('title'),['class' => 'form-control','placeholder'=>'Role Name','required','autofocus', 'title'=>'Enter Role Name']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
                    <small class="narration">(Active status Selected)</small>
                    {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class'=>'form-control ','required']) !!}
                </div>
            </div>
        </div>

        <div class="footer-form-margin-btn">
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}&nbsp;
            <a href="{{route('role')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
        </div>
        {!! Form::close() !!}
</div>

    </div>
</div>

<script>
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
</script>

<script>


    $(function () {
        $("#user-update").validate({
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

        $("#user-update").validate({
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

</script>



<script>


    $(function () {
        $("#update-role").validate({
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

        $("#update-role").validate({
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

</script>