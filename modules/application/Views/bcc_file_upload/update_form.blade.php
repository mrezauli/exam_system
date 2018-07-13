<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-15 col-sm-9">
            {!! Form::label('company_name', 'Organization Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('company_name', $company->company_name,['required'=>'required','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-15 col-sm-45">
            {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
            {!! Form::text('phone', $company->phone,['disabled'=>'disabled']) !!}
        </div>

        <div class="col-sm-45">
            {!! Form::label('mobile', 'Mobile:', ['class' => 'control-label']) !!}
            {!! Form::text('mobile', $company->mobile,['disabled'=>'disabled']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-15 col-sm-9">
            {!! Form::label('address', 'Organization Address:', ['class' => 'control-label']) !!}
            {!! Form::textarea('address', $company->address, ['id'=>'address', 'class' => 'form-control', 'size' => '12x5','disabled'=>'disabled']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-15 col-sm-9">
            {!! Form::label('subject', 'Subject:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('subject', Input::old('subject'),['required'=>'required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-offset-15 col-sm-9">
            {!! Form::label('letter_no', 'Letter No:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('letter_no', Input::old('letter_no'),['required'=>'required']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        
        @if(! $has_file)
            <div class="col-sm-offset-15 col-sm-9">
                {!! Form::label('file_upload_attachment', 'Attachment:', ['class' => 'control-label']) !!}
                <div class="image-center">
                    <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                        <div class="image-center">
                           {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.pptx,.pptx']) !!}
                        </div>       
                    </div>
                </div>
            </div>
        @endif

        @if($has_file)
            <div class="col-sm-offset-15 col-sm-9">
                <br>
                {!! Form::label('attachment', 'Attachment:', ['class' => 'control-label']) !!}
                @foreach($file_data as $file)

                    <?php $expld = explode('/',$file->application_attachment_path); ?>
                    @if($file->status = 'active' && isset($file->application_attachment_path))
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

<input type="hidden" name="company_id" id="company_id" class="form-control" value="{{$company->id}}">



<div class="form-margin-btn text-right">
    {!! Form::submit('Save', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
</div>