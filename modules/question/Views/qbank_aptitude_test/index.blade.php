@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<!-- page start-->

<div class="inner-wrapper index-page qbank-aptitude-test-page">
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <span>{{ $page_title }}</span> <a class="btn btn-primary conversion-button" target="_blank" href="https://cloudconvert.com/">HTML Conversion Link</a>
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

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs qbank-aptitude-nav-tabs" role="tablist">
                        <li role="presentation" class="@if(Session::has('tab')) @if(Session::get('tab') == 'word') {{'active'}}@endif @else {{'active'}} @endif"><a href="#ms-word" class="btn" aria-controls="ms-word" role="tab" data-toggle="tab">MS WORD({{count($ms_word_data)}})</a></li>
                        <li role="presentation" class="@if(Session::has('tab')) @if(Session::get('tab') == 'excel') {{'active'}}@endif @endif"><a href="#ms-excel" class="btn" aria-controls="ms-excel" role="tab" data-toggle="tab">MS EXCEL({{count($ms_excel_data)}})</a></li>
                        <li role="presentation" class="@if(Session::has('tab')) @if(Session::get('tab') == 'ppt') {{'active'}}@endif @endif"><a href="#ms-ppt" class="btn" aria-controls="ms-ppt" role="tab" data-toggle="tab">MS PPT({{count($ms_ppt_data)}})</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane @if(Session::has('tab')) @if(Session::get('tab') == 'word') {{'active'}}@endif @else {{'active'}} @endif" id="ms-word">
                            <header class="panel-heading text-center">
                                Aptitude Test Question Bank (MS WORD)
                                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-qbank-aptitude-test-word')}}" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view">
                                    <b>Add Word Questions</b>
                                </a>
                            </header>
                            <div class="panel-body">
                                <div class="adv-table">

                                    {{-------------- Filter :Ends ----------------------------------------- --}}


                                    <table class="display table table-bordered table-striped" id="example">
                                        <thead>
                                        <tr>
                                            <th> Question Name</th>
                                            <th> Action </th>
                                        </tr>
                                        </thead>

                                        <tfoot class="search-section">
                                        <tr>
                                            <th> <input type="text" placeholder="" /> </th>
                                            <th> Action </th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        @if(isset($ms_word_data))
                                            @foreach($ms_word_data as $values)
                                                {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                                                     $area_name = $jobarea->area_name;  --}}
                                                <tr class="gradeX">
                                                    <td>{{ucfirst($values->title)}}</td>
                                                    <td>
                                                        <a href="{{ route('view-qbank-aptitude-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                                        {{-- <a href="{{ route('edit-qbank-aptitude-test', $values->id) }}" class="btn btn-primary btn-xs edit-meeting" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-edit"></i></a> --}}
                                                        <a href="{{ route('delete-qbank-aptitude-test', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane @if(Session::has('tab')) @if(Session::get('tab') == 'excel') {{'active'}}@endif @endif" id="ms-excel">
                            <header class="panel-heading text-center">
                                Aptitude Test Question Bank (MS-EXCEL)
                                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-qbank-aptitude-test-excel')}}" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view">
                                    <b>Add Excel Questions</b>
                                </a>
                            </header>
                            <div class="panel-body">
                                <div class="adv-table">

                                    {{-------------- Filter :Ends ----------------------------------------- --}}


                                    <table class="display table table-bordered table-striped ms-excel" id="example">
                                        <thead>
                                        <tr>
                                            <th> Question Name </th>
                                            <th> Action </th>
                                        </tr>
                                        </thead>

                                        <tfoot class="search-section">
                                        <tr>
                                            <th> <input type="text" placeholder="" /> </th>
                                            <th> Action </th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        @if(isset($ms_excel_data))
                                            @foreach($ms_excel_data as $values)
                                                {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                                                     $area_name = $jobarea->area_name;  --}}
                                                <tr class="gradeX">
                                                    <td>{{ucfirst($values->title)}}</td>
                                                    <td>
                                                        <a href="{{ route('view-qbank-aptitude-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                                        {{-- <a href="{{ route('edit-qbank-aptitude-test', $values->id) }}" class="btn btn-primary btn-xs edit-meeting" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-edit"></i></a> --}}
                                                        <a href="{{ route('delete-qbank-aptitude-test', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane @if(Session::has('tab')) @if(Session::get('tab') == 'ppt') {{'active'}}@endif @endif" id="ms-ppt">
                            <header class="panel-heading text-center">
                                Aptitude Test Question Bank (MS-PPT)
                                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('create-qbank-aptitude-test-ppt')}}" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view">
                                    <b>Add PPT Questions</b>
                                </a>
                            </header>
                            <div class="panel-body">
                                <div class="adv-table">

                                    {{-------------- Filter :Ends ----------------------------------------- --}}


                                    <table class="display table table-bordered table-striped ms-ppt" id="example">
                                        <thead>
                                        <tr>
                                            <th>Question Name</th>
                                            <th> Action </th>
                                        </tr>
                                        </thead>

                                        <tfoot class="search-section">
                                        <tr>
                                            <th>  <input type="text" placeholder="" />   </th>
                                            <th> Action </th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        @if(isset($ms_ppt_data))
                                            @foreach($ms_ppt_data as $values)
                                                {{--  $jobarea = Modules\Admin\JobArea::find($values->job_area_id);
                                                     $area_name = $jobarea->area_name;  --}}
                                                <tr class="gradeX">
                                                    <td>{{ucfirst($values->title)}}</td>
                                                    <td>
                                                        <a href="{{ route('view-qbank-aptitude-test', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                                        {{-- <a href="{{ route('edit-qbank-aptitude-test', $values->id) }}" class="btn btn-primary btn-xs edit-meeting" data-toggle="modal" data-target="#estbModal" data-placement="top" data-content="view"><i class="fa fa-edit"></i></a> --}}
                                                        <a href="{{ route('delete-qbank-aptitude-test', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</div>
<!-- page end-->


<!-- Modal  -->

<div class="modal fade" id="estbModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

</div>


<style>
    
.panel-heading{
    display: flex;
    align-items: baseline;
    justify-content: space-between;

}

.conversion-button{
    background-color: #18b50eed !important;
    border-color:#18b50eed !important;
}

.conversion-button:hover{
    background-color: #299e23ed !important;
    border-color:#18b50eed !important;
}


</style>

<!-- modal -->
@stop
<!--script for this page only-->
@section('custom-script')
    <script>
        var column_index = [];
        create_dropdown_column(column_index);

        var ms_table =$('.ms-excel').DataTable({
            /* Disable initial sort */
            "aaSorting": []
        });
        // Apply the search
        ms_table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                            .search( this.value )
                            .draw();
                }
            } );
        } );
        var ms_ppt =$('.ms-ppt').DataTable({
            /* Disable initial sort */
            "aaSorting": []
        });
        // Apply the search
        ms_ppt.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                            .search( this.value )
                            .draw();
                }
            } );
        } );

        /*$('.nav-tabs').click('tabsselect', function (event, ui) {
//            alert("working");
            var selectedTab = $('.nav-tabs').tabs('option','active');
            console.log(selectedTab);
        });*/
    </script>
@stop