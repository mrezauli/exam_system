<div class="modal-dialog modal-lg typing-test-modal" style="width:1280px;max-width:1280px;">
    <div class="modal-content">
        <div class="modal-header">
            <a type="button" class="close" data-dismiss="modal" title="click x button for close this entry form">×</a>
            <h4 class="modal-title" id="myModalLabel">Edit Typing test Question<span style="color:#A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>
        </div>
        <div class="modal-body" style="padding-top: 0;">

            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-qbank-typing-test', $data->id],'class' => 'update-typing-test-form','style' => 'max-width:1200px;']) !!}
            @include('question::qbank_typing_test.update_form')
            {!! Form::close() !!}
        </div> <!-- / .modal-body -->
    </div> <!-- / .modal-content -->
</div> <!-- / .modal-dialog -->
