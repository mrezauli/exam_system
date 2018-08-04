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

<div style="color:red;display:none;" class="alert-message">Corrected words must be a valid number and can't be greater than typed words.</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bangla_typed_words', 'Bangla Typed Words :', ['class' => 'control-label']) !!}
             {{-- <small class="required">*</small> --}}
            {!! Form::text('bangla_typed_words', $bangla->typed_words, ['id'=>'bangla_typed_words', 'class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('bangla_corrected_words', 'Bangla Corrected Words :', ['class' => 'control-label']) !!}
            <small class="required">*</small>
            {!! Form::text('bangla_corrected_words', $bangla->typed_words - $bangla->inserted_words, ['id'=>'bangla_corrected_words', 'class' => 'form-control','required'=>'required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

    <div class="col-sm-6">
        {!! Form::label('bangla_wrong_words', 'Bangla Wrong Words :', ['class' => 'control-label']) !!}
         {{-- <small class="required">*</small> --}}
        {!! Form::text('bangla_wrong_words', $bangla->inserted_words, ['id'=>'bangla_wrong_words', 'class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
    </div>
        
        <div class="col-sm-6">
            {!! Form::label('english_typed_words', 'English Typed Words :', ['class' => 'control-label']) !!}
             {{-- <small class="required">*</small> --}}
            {!! Form::text('english_typed_words', $english->typed_words, ['id'=>'english_typed_words', 'class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('english_corrected_words', 'English Corrected Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('english_corrected_words', $english->typed_words - $english->inserted_words, ['id'=>'english_corrected_words', 'class' => 'form-control','required'=>'required']) !!}
        </div>

        <div class="col-sm-6">
            {!! Form::label('english_wrong_words', 'English Wrong Words :', ['class' => 'control-label']) !!}
             {{-- <small class="required">*</small> --}}
            {!! Form::text('english_wrong_words', $english->inserted_words, ['id'=>'english_wrong_words', 'class' => 'form-control','required'=>'required','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>

<input type="hidden" name="bangla_exam_id" id="bangla_exam_id" class="form-control" value="{{$bangla->id}}">
<input type="hidden" name="english_exam_id" id="english_exam_id" class="form-control" value="{{$english->id}}">
<input type="hidden" name="bangla_total_words" id="bangla_total_words" class="form-control" value="{{$bangla->total_words}}">
<input type="hidden" name="english_total_words" id="english_total_words" class="form-control" value="{{$english->total_words}}">

<p> &nbsp; </p>

<div class="form-margin-btn">
    <a data-dismiss="modal" class="btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}
</div>



<script>
    
$('#bangla_corrected_words').keyup(function(e) {

    var bangla_corrected_words = parseInt($(this).val());

    var bangla_typed_words = parseInt($('#bangla_typed_words').val());

    var bangla_wrong_words = parseInt($('#bangla_wrong_words').val());

    var ddd = bangla_typed_words - bangla_corrected_words >= 0;

    $('#bangla_wrong_words').val(bangla_typed_words - bangla_corrected_words);



    if (! Number.isInteger(bangla_corrected_words) || ! ddd) {
        $('.alert-message').show();
        $('input[type="submit"]').attr('disabled', 'disabled');
    }else{
        
        $('.alert-message').hide();
        $('input[type="submit"]').removeAttr('disabled');

    }



});




$('#english_corrected_words').keyup(function(e) {

    var english_corrected_words = parseInt($(this).val());

    var english_typed_words = parseInt($('#english_typed_words').val());

    var english_wrong_words = parseInt($('#english_wrong_words').val());

    var ddd = english_typed_words - english_corrected_words >= 0;

    $('#english_wrong_words').val(english_typed_words - english_corrected_words);



    if (! Number.isInteger(english_corrected_words) || ! ddd) {
        $('.alert-message').show();
        $('input[type="submit"]').attr('`', 'disabled');
    }else{
        
        $('.alert-message').hide();
        $('input[type="submit"]').removeAttr('disabled');

    }

});


</script>