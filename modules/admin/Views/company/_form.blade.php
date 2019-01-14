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
        <div class="col-sm-6">
            {!! Form::label('company_name', 'Organization Name :', ['class' => 'control-label']) !!}
             <small class="required">*</small>
            {!! Form::text('company_name', Input::old('company_name'), ['id'=>'company_name', 'class' => 'form-control','required','required', 'style'=>'text-transform:capitalize','required','company_name'=>'enter company name, example :: Main company']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('contact_person', 'Head of Organization :', ['class' => 'control-label']) !!}
            {!! Form::text('contact_person', Input::old('contact_person'), ['id'=>'contact_person', 'class' => 'form-control', 'style'=>'text-transform:capitalize','contact_person'=>'enter company name, example :: Main company']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('designation', 'Designation :', ['class' => 'control-label']) !!}
            {!! Form::text('designation', Input::old('designation'), ['id'=>'designation', 'class' => 'form-control', 'style'=>'text-transform:capitalize','contact_person'=>'enter designation, example :: Manager']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('email', 'E-Mail :', ['class' => 'control-label']) !!}
            {!! Form::email('email', Input::old('email'), ['id'=>'email', 'class' => 'form-control', 'email'=>'enter company name, example :: Main company']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6 input-group company-input-group">
            {!! Form::label('phone', 'Office Phone :', ['class' => 'control-label']) !!}

            <div><span class="input-group-addon">880</span>
                {!! Form::text('phone', Input::old('phone'), ['id'=>'phone', 'class' => 'form-control', 'phone'=>'enter company name, example :: Main company']) !!}
            </div>

        </div>
        <div class="col-sm-6 input-group company-input-group">
            {!! Form::label('mobile', 'Mobile :', ['class' => 'control-label']) !!}

            <div><span class="input-group-addon">880</span>
                {!! Form::text('mobile', Input::old('mobile'), ['id'=>'mobile', 'class' => 'form-control', 'mobile'=>'enter company name, example :: Main company']) !!}
            </div>
            
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('web_address', 'Website :', ['class' => 'control-label']) !!}
            {!! Form::text('web_address', Input::old('web_address'), ['id'=>'web_address', 'class' => 'form-control', 'mobile'=>'enter website address, example :: www.asretex.com']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('status', 'Status :', ['class' => 'control-label']) !!}
            {!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','title'=>'select status of company']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address_one', 'Address One:', ['class' => 'control-label']) !!}
            {!! Form::text('address_one', Input::old('address_one'), ['id'=>'address_one', 'class' => 'form-control','address_one'=>'enter company address one']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address_two', 'Address Two:', ['class' => 'control-label']) !!}
            {!! Form::text('address_two', Input::old('address_two'), ['id'=>'address_two', 'class' => 'form-control','address_two'=>'enter company address two']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address_three', 'Address Three:', ['class' => 'control-label']) !!}
            {!! Form::text('address_three', Input::old('address_three'), ['id'=>'address_three', 'class' => 'form-control','address_three'=>'enter company address three']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address_four', 'Address Four:', ['class' => 'control-label']) !!}
            {!! Form::text('address_four', Input::old('address_four'), ['id'=>'address_four', 'class' => 'form-control','address_four'=>'enter company address four']) !!}
        </div>
    </div>
</div>



<p> &nbsp; </p>

<div class="form-margin-btn">
    <a href="{{route('company')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}
</div>