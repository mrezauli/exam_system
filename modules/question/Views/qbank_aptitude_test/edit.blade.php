<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <a type="button" class="close" data-dismiss="modal" title="click x button for close this entry form">×</a>
            <h4 class="modal-title" id="myModalLabel">Edit Aptitude Test Questions<span style="color:#A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2">(?)</font> </span></h4>
        </div>
        <div class="modal-body">
            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-qbank-aptitude-test', $data->id]]) !!}
            @include('question::qbank_aptitude_test.update_form')
            {!! Form::close() !!}
        </div> <!-- / .modal-body -->
    </div> <!-- / .modal-content -->
</div> <!-- / .modal-dialog -->
