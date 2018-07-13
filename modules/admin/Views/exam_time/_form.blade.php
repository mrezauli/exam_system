@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        
        <div class="col-sm-12">
            {!! Form::label('designation_name', 'Post Name:', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('designation_name', Input::old('designation_name'), ['id'=>'designation_name', 'class' => 'form-control', 'style'=>'text-transform:capitalize','required','designation_name'=>'enter post name, example :: air-conditioner']) !!}
        </div>

    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
<div class="row">
        <div class="col-sm-12">
            {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
            {!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','required',$disabled,'title'=>'select status of company']) !!}
        </div>
    </div>
</div>

<p> &nbsp; </p>

<div class="form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save post information']) !!}
    <a href="{{route('designation')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form" onclick="close_modal();">Close</a>
</div>




