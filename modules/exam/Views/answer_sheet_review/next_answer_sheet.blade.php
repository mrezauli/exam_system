@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper index-page">

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('flash_message') }}</p>
                </div>
            @endif

            <div class="panel-body">
                <div class="adv-table">

                    {!! Form::open(['route' => ['start-review',$company_id, $designation_id, $exam_code_id, $exam_date, $shift],'id' => 'jq-validation-form']) !!}

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            <div class="col-sm-2">

                     
                                <input type="hidden" name="candidate_id" value="<?php echo isset($candidate_id) ? $candidate_id : ''; ?>"/>
                                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>"/>
                                <input type="hidden" name="designation_id" value="<?php echo $designation_id; ?>"/>
                                <input type="hidden" name="exam_code_id" value="<?php echo $exam_code_id; ?>"/>
                                <input type="hidden" name="exam_date" value="<?php echo $exam_date; ?>"/>
                                <input type="hidden" name="shift" value="<?php echo $shift; ?>"/>

                              {!! Form::submit('Next Answer Sheet', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
</div>
</div>
<!-- page end-->






<!-- Modal  -->

<div class="modal fade" id="estbModal3" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

</div>

<!-- modal -->
@stop
<!--script for this page only-->


@section('custom-script')

<script>
    
$('.datepicker').each(function(index, el) {
    
 $(el).datepicker({
     format: 'yyyy-mm-dd'
 });

});

var column_index = ['2'];
create_dropdown_column(column_index);




</script>


<style>

table.dataTable tfoot tr th:nth-child(2) select,.hidden-checkbox {
    visibility: hidden !important;
}

form{

    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 200px;
}

</style>

@stop
