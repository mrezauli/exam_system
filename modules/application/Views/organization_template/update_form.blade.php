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
        {!! Form::label('reference_no', 'Reference_no:', ['class' => 'control-label']) !!}

            @if(! $extra_reference_no_informations->isEmpty())

            @foreach($extra_reference_no_informations as $extra_reference_no_information)

            {!! Form::textarea('reference_no[]', $extra_reference_no_information->extra_information, ['id'=>'reference_no', 'class' => 'form-control extra-information','size' => '12x2','title'=>'Please Insert Typing Text']) !!}

            @endforeach
            
            @else

            {!! Form::textarea('reference_no[]', Input::old('reference_no'), ['id'=>'reference_no', 'class' => 'form-control extra-information','size' => '12x2','title'=>'Please Insert Typing Text']) !!}

            @endif    
            <button type="button" id="addnew" class="btn btn-primary btn-sm add-button add-reference-button"><font>+</font></button>     

        </div>
    </div>
</div>



<br>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('email_description', 'Body:', ['class' => 'control-label']) !!}
            {!! Form::textarea('email_description',Input::old('email_description'), ['id'=>'email_description', 'class' => 'form-control', 'size' => '12x5']) !!}
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
            {!! Form::textarea('address', $company->address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x5']) !!}
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
            {!! Form::textarea('bcc_address', $bcc_company->address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x5','disabled'=>'disabled']) !!}
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

            @if(isset($extra_copy_informations))

            @foreach($extra_copy_informations as $extra_copy_information)

            {!! Form::textarea('copy[]', $extra_copy_information->extra_information, ['id'=>'copy', 'class' => 'form-control extra-information','size' => '12x2','title'=>'Please Insert Typing Text']) !!}

            @endforeach
            
            @else

            {!! Form::textarea('copy[]', Input::old('extra_information'), ['id'=>'copy', 'class' => 'form-control extra-information','size' => '12x2','title'=>'Please Insert Typing Text']) !!}

            @endif    
            <button type="button" id="addnew" class="btn btn-primary btn-sm add-button add-reference-button"><font>+</font></button>     

        </div>
    </div>
</div>




<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

    @if(! $has_file)
        <div class="col-sm-offset-1 col-sm-10">
            {!! Form::label('template_extra_attachment', 'Attachment:', ['class' => 'control-label']) !!}
            <div class="image-center">
                <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                    <div class="image-center">
                        {!! Form::file('file',['name'=>'template_extra_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.pptx']) !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($has_file)
            <div class="col-sm-offset-1 col-sm-10">
                <br>
                {!! Form::label('attachment', 'Attachment:', ['class' => 'control-label']) !!}
                @foreach($file_data as $file)
                    <?php $expld = explode('/',$file->application_attachment_path); ?>
                    @if($file->status = 'active' && isset($file->application_attachment_path) && $file->attachment_type = 'template_extra')
                        <div>
                            {{ $expld[1] }}

                            <a href="{{ URL::to($file->application_attachment_path) }}" class="btn btn-primary btn-xs" data-placement="top" download="{{ $expld[1] }}">Download</a>

                            <a href="{{ route('delete-bcc-template-attachment',$file->id) }}" class="btn btn-danger btn-xs" data-placement="top">Delete</a><p><br></p>
                        </div>
                    @else
                        <div><span class="glyphicon glyphicon-remove-circle"></span> No Attachment Available</div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>
</div>                            

{!! Form::hidden('date_email',$date_email) !!}

{!! Form::hidden('app_org_mst_id',$data->id) !!}

<div class="form-margin-btn text-right">

    <a href="#" class="btn btn-danger trigger-link preview-button">Preview</a>

    {!! Form::submit('Save', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>







