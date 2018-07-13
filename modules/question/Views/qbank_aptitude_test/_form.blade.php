<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

    <div class="col-sm-offset-1 col-sm-10">
      {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
       <small class="required">*</small>
      {!! Form::text('title', Input::old('title'), ['id'=>'title', 'class' => 'form-control title','required'=>'required']) !!}
    </div>


        {{--<div class="col-sm-6">
            {!! Form::label('question_type', 'Answer Type:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::select('question_type', array(''=>'Select exam type','word'=>'MS-Word', 'excel'=>'MS-Excel', 'ppt'=>'MS-PPT'),Input::old('question_type'),['class' => 'form-control','title'=>'select exam type','required']) !!}
        </div>--}}

    </div>
</div>




<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

    <div class="col-sm-offset-1 col-sm-10">
      {!! Form::label('file', 'Upload Questions', ['class' => 'control-label']) !!}
       <small class="required">*</small>
      {!! Form::file('file', ['name'=>'file[]','id'=>'file','class' => 'form-control','required'=>'required','accept'=>'.doc,.docx,.xls,.xlsx,.pptx,.pptx']) !!}
    </div>

    </div>
</div>



<p> &nbsp; </p>

<div class="form-margin-btn text-right">
    {!! Form::submit('Save', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>





@include('question::qbank_aptitude_test._script')


@section('custom-script')
<script>
    


</script>
@stop