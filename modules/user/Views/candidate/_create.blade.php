{!! Form::open(['route' => 'create-candidate', 'id' => 'form_2', 'files'=>'true']) !!}

<div class="col-sm-12 form-group">
    {!!  Form::label('Organization Name :') !!}
     <small class="required">*</small>
    @if(count($company_list)>0)
        {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
    @else
        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
    @endif
</div>

<div class="col-sm-12 form-group">
    {!! Form::label('Name of the Post :') !!}
     <small class="required">*</small>
    @if(count($designation_list)>0)
        {!! Form::select('designation_id', $designation_list, Input::old('designation_id'),['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
    @else
        {!! Form::text('designation_id', 'No Designation ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
    @endif
</div>


<div class="col-sm-12 form-group">
    {!!  Form::label('Upload Candidate Excel Sheet') !!}
    {!! Form::file('excel_file',['class'=>'form-control','required'=>'required']) !!}
</div>


<div class="col-sm-12 form-group">
    {!!  Form::label('Exam Status') !!}
    {!! Form::select('exam_number', ['' => 'Select Exam Status','0' => 'Old Exam','1' => 'New Exam'], Input::old('exam_number'),['id'=>'exam_number','class' => 'form-control','required']) !!}
</div>

<div class="clearfix"></div>

<div class="col-sm-12 form-margin-btn text-right" style="float:none;">           
    <a href="{{route('candidate-list')}}" class=" btn btn-default mt-23" data-placement="top" data-content="click close button for close this entry form">Close</a>
    {!! Form::submit('Upload', ['id'=>'btn-disabled','class' => 'btn btn-primary mt-23','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}
</div>



{!! Form::close() !!}

<style>
    
.model#form_2 form{
    padding: 0 !important;
}

</style>