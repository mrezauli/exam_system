@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="load-question" style="display:none">
    <img src="{{url('assets/img/loading.gif')}}"/>
</div>

<div class="inner-wrapper index-page qselection-aptitude-test-index-page">

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">

                {{ $page_title }}

                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-qselection-aptitude-test')}}">
                    <b>Select Question Set</b>
                </a>
            </header>

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
                   
                    <p> &nbsp;</p>
                    <p> &nbsp;</p>
                    {{-------------- Filter :Ends ----------------------------------------- --}}


                    <table  class="display table table-bordered table-striped meeting-table" id="example">
                        <thead>
                        <tr> 
                            <th> Exam Code </th>
                            <th> Question Set Title </th>
                            <th> Organization </th>
                            <th> Post Name </th>
                            <th> Exam Date </th>
                            <th> Shift </th>
                            <th> Actions </th>
                        </tr>
                        </thead>
 

                        <tfoot class="search-section">
                        <tr> 
                            <th> Exam Code </th>
                            <th> Question Set Title </th>
                            <th> Organization </th>
                            <th> Post Name </th>
                            <th> Exam Date </th>
                            <th> Shift </th>
                            <th> Actions </th>
                        </tr>
                        </tfoot>
                        <tbody> 

                        @if(isset($data))
                            @foreach($data as $values)

                       {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                            $area_name = $jobarea->area_name;  --}}
                                <tr class="gradeX">
                                    <td>{{ isset($values->exam_code()->first()->exam_code_name)?$values->exam_code()->first()->exam_code_name:''}}</td>
                                    <td>{{ isset($values->question_set->question_set_title)? $values->question_set->question_set_title:''}}</td>
                                    <td>{{ isset($values->exam_code()->first()->company->company_name)?$values->exam_code()->first()->company->company_name:''}}</td>
                                    <td>{{ isset($values->exam_code()->first()->designation->designation_name)?$values->exam_code()->first()->designation->designation_name:''}}</td>
                                    <td>{{ isset($values->exam_code()->first()->exam_date)?$values->exam_code()->first()->exam_date:''}}</td>
                                    <td>{{ isset($values->exam_code()->first()->shift)?ucfirst(\App\Helpers\ImageResize::shift($values->exam_code()->first()->shift)):''}}</td>
                                    <td>
                                        <a href="{{ route('edit-qselection-aptitude-test', $values->id) }}" class="btn btn-primary btn-xs edit-meeting"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-qselection-aptitude-test', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                        <a data-id={{$values->id}} class="btn btn-info btn-xs print-button" href="">print</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
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


$('.print-button').click(function(e) {
e.preventDefault();

    var id = $(this).data('id');
    ajax_print(id);

});


function ajax_print(id) {

  $_token = "{{ csrf_token() }}";

  $.ajax({
    url: "{{Route('ajax-print-qselection-aptitude-question')}}",
    type: 'POST',
    beforeSend:function(data){

        $('.load-question').show();
        $('.qselection-aptitude-test-index-page').hide();

    },
    data:{ id: id,_token: $_token },
    success: function(data){

console.log(data);

        $('.load-question').hide();
        $('.qselection-aptitude-test-index-page').show();

     //console.log(data);

    var  base_url=  '{!! URL::to('/') !!}';

   
    setTimeout(function() {

    //   ajax_delete_print_qselection_aptitude_question();

   }, 1000);

    var w = window.open(base_url + '/' + data); 
    w.print();
   
    }

  });

}


function ajax_delete_print_qselection_aptitude_question() {
    var data='';
      $.ajax({
        url: "{{Route('ajax-delete-print-qselection-aptitude-question')}}",
        type: 'POST',
        data: {data: data},
        success: function(data){
            //do nothing.
        }
      });

}


</script>
@stop

