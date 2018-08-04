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
        <div class="col-sm-6">
            {!! Form::label('bangla_typed_words', 'Bangla Typed Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('bangla_typed_words', $bangla->typed_words, ['id'=>'bangla_typed_words', 'class' => 'form-control','required'=>'required']) !!}
        </div>
        {{-- <div class="col-sm-6">
            {!! Form::label('bangla_inserted_words', 'Bangla Wrong Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('bangla_inserted_words',$bangla->inserted_words, ['id'=>'bangla_inserted_words', 'class' => 'form-control','required'=>'required']) !!}
        </div> --}}
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bangla_corrected_words', 'Bangla Corrected Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('bangla_corrected_words', $bangla->typed_words - $bangla->inserted_words, ['id'=>'bangla_corrected_words', 'class' => 'form-control','required'=>'required']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('english_typed_words', 'English Typed Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('english_typed_words', $english->typed_words, ['id'=>'english_typed_words', 'class' => 'form-control','required'=>'required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        {{-- <div class="col-sm-6">
            {!! Form::label('english_inserted_words', 'English Wrong Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('english_inserted_words', $english->inserted_words, ['id'=>'english_inserted_words', 'class' => 'form-control','required'=>'required']) !!}
        </div> --}}
        <div class="col-sm-6">
            {!! Form::label('english_corrected_words', 'English Corrected Words :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('english_corrected_words', $english->typed_words - $english->inserted_words, ['id'=>'english_corrected_words', 'class' => 'form-control','required'=>'required']) !!}
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