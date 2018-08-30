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

                    {!! Form::open(['route' => 'store-qselection-typing-test','id' => 'jq-validation-form']) !!}

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            <div class="col-sm-2">
                              {!! Form::submit('Save', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
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



$("select#exam_type").change(function() {


    var exam_type = $(this).val();

    var organization = $('#company_list').val();

    var position = $('#designation_list').val();

    var exam_date = $('#exam_date').val();

    var question_id = $("input[name='question_id']:checked").val();


    window.location = '{!! route('create-qselection-typing-test') !!}' + '?exam_type=' + exam_type + '&company_list=' + organization + '&designation_list=' + position + '&exam_date=' + exam_date + '&question_id=' + question_id;


    // window.location = $(this).val();
});

</script>


<style>

table.dataTable tfoot tr th:nth-child(2) select,.hidden-checkbox {
    visibility: hidden !important;
}

</style>

@stop
