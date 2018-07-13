<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
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
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('mobile', 'Mobile:', ['class' => 'control-label']) !!}
            <div>
                <span class="input-group-addon">880</span>
                {!! Form::text('mobile', $company->mobile,[]) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('letter_no', 'Letter No:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('letter_no', Input::old('letter_no'),['required'=>'required']) !!}
        </div>
    </div>
</div>


<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('subject', 'Subject:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('subject', Input::old('subject'),['required'=>'required']) !!}
        </div>
    </div>
</div>


<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="repeater-block col-sm-offset-1 col-sm-10">
            {!! Form::label('reference_no', 'Reference No:', ['class' => 'control-label']) !!}
            {!! Form::text('reference_no[]', Input::old('reference_no'), ['id'=>'reference_no', 'class' => 'form-control extra-information','title'=>'Please Insert Typing Text']) !!}
            <button type="button" id="addnew" class="btn btn-primary btn-sm add-button add-reference-button"><font>+</font></button>
        </div>
    </div>
</div>


<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('subject', 'Body:', ['class' => 'control-label']) !!}
            <textarea name="email_description" required="required" id="email_description" rows="1" cols="8"></textarea>
        </div>
    </div>
</div>



<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('company_name', 'From (Your Organization):', ['class' => 'control-label']) !!}

            {!! Form::text('company_name', $company->company_name,['required'=>'required','readonly']) !!}
        </div>
    </div>
</div>

<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('address', 'Address:', ['class' => 'control-label']) !!}
            {!! Form::textarea('address', $company->address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x3']) !!}
        </div>
    </div>
</div>

<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('web_address', 'Website:', ['class' => 'control-label']) !!}
            {!! Form::text('web_address', $company->web_address, ['id'=>'web_address', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>



<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('bcc_company_name', 'To:', ['class' => 'control-label']) !!}
            {!! Form::text('bcc_company_name', $bcc_company->company_name,['disabled'=>'disabled']) !!}
        </div>
    </div>
</div>



<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('bcc_address', 'Address:', ['class' => 'control-label']) !!}
            {!! Form::textarea('bcc_address', $bcc_company->address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x3','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>

<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('bcc_web_address', 'Website:', ['class' => 'control-label']) !!}
            {!! Form::text('bcc_web_address', $bcc_company->web_address, ['id'=>'web_address', 'class' => 'form-control','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>

                                                                                                 
<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="repeater-block col-sm-offset-1 col-sm-10">
            {!! Form::label('copy', 'Copy:', ['class' => 'control-label']) !!}
            {!! Form::textarea('copy[]', Input::old('copy'), ['id'=>'copy', 'class' => 'form-control extra-information','title'=>'Please Insert Typing Text','size' => '12x1']) !!}
            <button type="button" id="addnew" class="btn btn-primary btn-sm add-button add-reference-button"><font>+</font></button>
        </div>
    </div>
</div>



<br>        
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('template_extra_attachment', 'Attachment: (You can select multiple files if necessary.)', ['class' => 'control-label']) !!}
            {!! Form::file('file',['name'=>'template_extra_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.pptx']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('date_email',$date_email) !!}

<div class="form-margin-btn text-right">

    {{-- <a href="#" class="btn btn-danger trigger-link preview-button">Preview</a> --}}

    <a href="#" class="btn btn-danger trigger-link print-preview-button mt-23">Print Preview</a>

    {!! Form::submit('Save', ['class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
    
</div>







