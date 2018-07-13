@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start-->

<style>
    
.page-header, .panel-heading {
    padding: 5px;
    padding-right: 15px;
}

.btn:not(.calender-button) {
    padding: 6px 8px !important;
}

.h4, .h5, .h6, h4, h5, h6 {
    margin-top: 0px;
    margin-bottom: 0;
}

.sending-procedure-select label:first-child {
    margin-top: 11px;
}

form {
    padding: 0;
}

.email-template-form-block .email-form-wrapper {
    margin-top: 10px;
}

.organization-form-body {
    padding: 5px 20px;
    margin-bottom: 10px;
}

br {
    display: none;
}

form input:not(.btn), .question-mark {
    height: 28px;
}   

form input:not(.btn), .question-mark {
    height: 28px;
}

.form-control, form input {
    height: auto;
}

.form-margin-btn.text-right {
    margin-top: 5px;
}

.email-page .input-group-addon {
    line-height: 11.7px !important;
}

.checkbox, .radio {
    margin-bottom: 0;
}

input#attachment {
    height: 30px;
}

</style>

<div class="page-inner-wrapper organization-template-page email-page">

    <div class="page-header">

    <a href="#" class="btn btn-danger trigger-link print-preview-button pull-right">Print Preview</a>

    {{-- <a href="#" class="btn btn-danger trigger-link preview-button pull-right">Preview</a> --}}


        <a href="{{route('organization-file-upload')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

        <div class="clearfix"></div>

    </div>

    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">

        <h4 class="title text-center" id="myModalLabel">Select your desired letter sending procedure:</h4>

            <div class="radio text-center sending-procedure-select">
                <label>
                    <input type="radio" name="application_format" id="application_format" value="{{route('create-organization-file-upload')}}">
                    File Upload
                </label>

                <label>
                    <input type="radio" name="application_format" id="application_format" value="{{route('create-organization-template')}}"  checked="checked">
                    Template
                </label>
            </div>

        </div>
    </div>

    

    <div class="col-sm-12 form-block organization-template-form-block email-template-form-block mt-23">
        
        {!! Form::open(['route' => 'store-organization-template','id' => 'jq-validation-form','class' => 'organization-template-form default-form','files'=>true]) !!}

        {{-- <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6 input-group">
                    {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
                    <div>
                        <span class="input-group-addon">880</span>
                        {!! Form::text('phone', $company->phone,[]) !!}
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
                        {!! Form::text('mobile', $company->mobile,[]) !!}
                    </div>
                </div>
            </div>
        </div> --}}

        <br>
        <div class="organization-form-wrapper email-form-wrapper">
            {{-- <div class="form-header organization-form-header"></div> --}}
            <div class="organization-form-body">
                @include('application::organization_template._form')
            </div>
        </div>

        {!! Form::close() !!}

    </div>


</div>


{{-- <div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"> --}}

{{-- {{ $ddd = Session::get('a1') }} --}}

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



CKEDITOR.replace( 'email_description', {
    uiColor: '#14B8C7',
    toolbar: [
    [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
    [ 'FontSize', 'TextColor', 'BGColor' ]
    ],
    height:['120px']

});




CKEDITOR.on('instanceReady', function(event) {
    var editor = event.editor;

    editor.on('change', function(event) {
        // Sync textarea
        this.updateElement();
    });
});


$(document).on("click",'#addnew',function(e) {

    var last_input_value = $(this).siblings(':input:last').val();

    if(last_input_value != "")
    {
    
        var block = $(this).closest(".repeater-block");

        var clone = $(this).siblings(':input:last').clone().val('');

        block.append(clone);
    }

});

$('.datepicker').each(function(index, el) {
    $(el).datepicker({
        format: 'yyyy-mm-dd'
    });
});


$('.preview-button').click(function(e) {

    ajax_preview();

     $('#preview-modal').modal('show');

});


function ajax_preview() {

  $.ajax({
    url: "{{Route('ajax-organization-preview-data')}}",
    type: 'POST',
    data: new FormData($("form")[0]),
    contentType: false,
    cache: false,
    processData: false,
    success: function(data){
      console.log(data);
      $('#preview-modal .modal-body').html(data);
    }
  });

}



$('.print-preview-button').click(function(e) {

     ajax_print_preview();

});


function ajax_print_preview() {

  $.ajax({
    url: "{{Route('ajax-organization-print-preview-data')}}",
    type: 'POST',
    data: new FormData($("form")[0]),
    contentType: false,
    cache: false,
    processData: false,
    success: function(data){

     var  base_url=  '{!! URL::to('/') !!}';

     setTimeout(function() {

        ajax_delete_print_preview(data);

    }, 1000);

      var w = window.open(base_url + '/' + data); 
      w.print();
      
    }

  });

}


function ajax_delete_print_preview(data) {

      $.ajax({
        url: "{{Route('ajax-organization-delete-print-preview-data')}}",
        type: 'POST',
        data: {data: data},
        success: function(data){

        }
      });

}


</script>
@stop