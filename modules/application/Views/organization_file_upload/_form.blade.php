<?php 

    $company_name = isset($company->company_name)?$company->company_name:'';
    $phone = isset($company->phone)?$company->phone:'';
    $mobile = isset($company->mobile)?$company->mobile:'';
    $address = isset($company->address)?$company->address:''; 

?>  


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('company_name', 'Organization Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('company_name', $company_name,['required'=>'required','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-10">
            {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
            <div>
                <span class="input-group-addon">880</span>
                {!! Form::text('phone', $phone,[]) !!}
            </div>
        </div>

        <div class="col-sm-10">
            {!! Form::label('mobile', 'Mobile:', ['class' => 'control-label']) !!}
            <div>
                <span class="input-group-addon">880</span>
            {!! Form::text('mobile', $mobile,[]) !!}
            </div>
        </div>
    </div>
</div>



<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('address', 'Organization Address:', ['class' => 'control-label']) !!}
            {!! Form::textarea('address', $address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x3']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('subject', 'Subject:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('subject', Input::old('subject'),['required'=>'required']) !!}
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

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('file_upload_attachment', 'Attachment:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.pptx']) !!}
            
        </div>

    </div>
</div>



<div class="form-margin-btn text-right">

        <div class="col-sm-offset-1 col-sm-10">

    {!! Form::submit('Save', ['class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>
<div class="clearfix"></div>
</div>






