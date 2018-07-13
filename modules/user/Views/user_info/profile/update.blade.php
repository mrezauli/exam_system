<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ URL::asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css" >



<div class="modal-dialog modal-lg">
    <div class="modal-content">


<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">
        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-user-profile', $data->id],'files'=>'true','id'=>'user-profile']) !!}
    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        {!! Form::hidden('user_id',$user_id) !!}
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
                {!! Form::text('first_name', Input::old('first_name'), ['id'=>'first_name', 'class' => 'form-control', 'required'=>'required','title'=>'Enter Your First Name']) !!}
            </div>

            <div class="col-sm-6">
                {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
                {!! Form::text('last_name', Input::old('last_name'), ['id'=>'last_name', 'class' => 'form-control','required'=>'required','title'=>'Enter Your Last Name']) !!}
            </div>
        </div>
    </div>


    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('telephone_number', 'Telephone Number:', ['class' => 'control-label']) !!}
                {!! Form::text('telephone_number', Input::old('telephone_number'), ['class' => 'form-control','required'=>'required','title'=>'Enter Telephone Number']) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'control-label']) !!}
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
        {!! Form::close() !!}
</div>

    </div>
</div>

{{-- <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
 --}}

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

    // $('.datepicker').each(function(index, el) {
        
    //  $(el).datepicker({
    //      format: 'yyyy-mm-dd'
    //  });

    // });

    
</script>




