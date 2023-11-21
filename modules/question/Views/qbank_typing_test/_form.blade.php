<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-12">
            {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
            <small class="required">*</small>
            {!! Form::select(
                'exam_type',
                ['' => 'Select exam type', 'bangla' => 'Bangla', 'english' => 'English'],
                Input::old('exam_type'),
                ['class' => 'form-control', 'title' => 'select exam type', 'required']
            ) !!}
        </div>

    </div>
</div>

<div class="repeater-block">

    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">

            <div class="col-sm-12">
                {!! Form::label('words_count', 'Characters Count:', ['class' => 'control-label']) !!}
                {!! Form::text('words_count[]', Input::old('words_count'), ['class' => 'form-control words-count', 'readonly']) !!}
            </div>

        </div>
    </div>

    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-12">
                {!! Form::label('reference_no', 'Question:', ['class' => 'control-label']) !!}
                {!! Form::textarea('typing_question[]', Input::old('typing_question'), [
                    'id' => 'typing_question',
                    'class' => 'typing_question form-control',
                    'size' => '12x18',
                    'title' => 'Please Insert Typing Text',
                ]) !!}
                <button type="button" id="addnew" class="btn btn-primary btn-sm add-button add-typing-test-button">
                    <font>+</font>
                </button>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).on("click", '#addnew', function(e) {

        var last_input_value = $(this).siblings('.typing_question:last').val();

        var last_input_value = $(".repeater-block:last").find('.typing_question').val();


        if (last_input_value != "") {

            var block = $(".repeater-block:last");

            var clone = $(".repeater-block:last").clone();

            $(clone).find('.typing_question,#words_count').val('');

            block.after(clone);
        }

    });
</script>

<p> &nbsp; </p>

<div class="form-margin-btn text-right">

    {!! Form::submit('Save', [
        'class' => 'btn btn-primary',
        'data-placement' => 'top',
        'data-content' => 'click save changes button for save Typing Text',
    ]) !!}

</div>




@include('question::qbank_typing_test._script')


@section('custom-script')
    <script></script>
@stop
