<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-12">
            {!! Form::label('words_count', 'Words Count:', ['class' => 'control-label']) !!}
            {!! Form::text('words_count', Input::old('words_count'),['class' => 'form-control words-count','disabled' => 'disabled']) !!}
        </div>

    </div>
</div>



<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-12">
            {!! Form::label('typing_question', 'Question:', ['class' => 'control-label']) !!}
            {!! Form::textarea('typing_question[]', Input::old('typing_question'), ['id'=>'typing_question', 'class' => 'form-control typing_question', 'style' => 'width:91.7% !important','size' => '12x18','title'=>'Please Insert Typing Text']) !!}
        </div>

    </div>
</div>






<p> &nbsp; </p>

<div class="form-margin-btn text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>


@include('question::qbank_typing_test._script')