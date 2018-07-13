@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="page-inner-wrapper create-contact-page">


<div class="page-header">

    <a href="#" class="btn btn-danger trigger-link pull-right preview-button">Preview</a>

    <a href="{{route('bcc-file-upload')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

    <div class="clearfix"></div>

</div>




    <div class="col-sm-offset-2 col-sm-8 form-block organization-template-form-block">
        
        {!! Form::model($data,['method' => 'PATCH', 'route' => ['update-bcc-template',$data->id],'id' => 'jq-validation-form','class' => 'organization-application-form','files'=>true]) !!}
        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6 input-group">
                    {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
                    <div>
                        <span class="input-group-addon">880</span>
                        {!! Form::text('phone', $bcc_company->phone,['id' => 'phone']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6 input-group">
                    {!! Form::label('mobile', 'Mobile:', ['class' => 'control-label']) !!}
                    <div>
                        <span class="input-group-addon">880</span>
                        {!! Form::text('mobile', $bcc_company->mobile,['id' => 'mobile']) !!}
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="organization-form-wrapper">
            <div class="form-header bcc-form-header"></div>
            <div class="organization-form-body">
                @include('application::bcc_template.update_form')
            </div>
        </div>

        {!! Form::close() !!}

    </div>


</div>




<div class="modal fade" id="preview-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      </div>
      <div class="modal-body">
        <p>Modal body</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop



@section('custom-script')
<script>
    
$("input[name='application_format']").change(function() {
    window.location = $(this).val();
});

CKEDITOR.replace( 'email_description' );

$(document).on("click",'#addnew',function(e) {

    var last_input_value = $(this).siblings(':input:last').val();

    if(last_input_value != "")
    {
    
        var block = $(this).closest(".repeater-block");

        var clone = $(this).siblings(':input:last').clone().val('');

        block.append(clone);
    }

});



$('.trigger-link').click(function(e) {

    ajax_preview();

     $('#preview-modal').modal('show');

});


function ajax_preview() {


  $.ajax({
    url: "{{Route('ajax-bcc-preview-data')}}",
    type: 'POST',
    data: $('form').serialize(),
    success: function(data){
      console.log(data);
      $('#preview-modal .modal-body').html(data);
      //$('header').html(data.name);
    }

    });
}


</script>
@stop