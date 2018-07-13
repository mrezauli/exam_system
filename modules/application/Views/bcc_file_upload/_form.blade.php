<ul class="alert alert-danger" style="margin-left: 30px;border-radius: 5px; display: none">
    <li class="msg"></li>
</ul>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
        {!! Form::label('company_list', 'Select organization', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            @if(count($company_list)>0)
            {!! Form::select('company_id', $company_list, Input::old('company_list'),['id'=>'company_list','class' => 'form-control js-select','required'=>'required']) !!}
            {{--<p id="msg_org" style="color: red"></p>
                ,'onchange'=>'if($(this).val().length > 0) {$("#msg_org").html("")} '--}}
            @else
            {!! Form::text('company_id', 'No Industry ID available',['id'=>'company_list','class' => 'form-control','required']) !!}
            @endif
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
            <div>
                <span class="input-group-addon">880</span>
            {!! Form::text('phone', '',['id' => 'phone','disabled'=>'disabled']) !!}
            </div>
        </div>

        <div class="col-sm-10">
            {!! Form::label('mobile', 'Mobile:', ['class' => 'control-label']) !!}
            <div>
                <span class="input-group-addon">880</span>
            {!! Form::text('mobile', '',['id' => 'mobile','disabled'=>'disabled']) !!}
            </div>
        </div>
    </div>
</div>



<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('address', 'Organization Address:', ['class' => 'control-label']) !!}
            {!! Form::textarea('address', '', ['id'=>'address', 'class' => 'form-control', 'size' => '12x3','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('subject', 'Subject:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('subject', Input::old('subject'),['id'=>'subject','required'=>'required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('letter_no', 'Letter No:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('letter_no', Input::old('letter_no'),['id'=>'letter_no','required'=>'required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('file_upload_attachment', 'Attachment:', ['class' => 'control-label']) !!}
            <small class="required">*</small>
            {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.pptx,.pptx']) !!}
            
        </div>

    </div>
</div>


<div class="form-margin-btn text-right col-sm-10">
    {!! Form::submit('Save', ['id'=>'submit_button','class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>

<div class="clearfix"></div>





