<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-12">
            {!! Form::label('aptitude_question', 'Question:', ['class' => 'control-label']) !!}
            {!! Form::textarea('aptitude_question[]', Input::old('aptitude_question'), ['id'=>'aptitude_question', 'class' => 'form-control','size' => '12x5','title'=>'Please Insert Typing Text']) !!}
        </div>

    </div>
</div>

<p> &nbsp; </p>

<div class="form-margin-btn text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>


@section('custom-script')
<script>
    


</script>
@stop