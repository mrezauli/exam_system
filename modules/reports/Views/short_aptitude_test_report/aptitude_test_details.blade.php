@extends('admin::layouts.master')
@section('sidebar')
    @parent
    @include('admin::layouts.sidebar')
@stop



@section('content')

    <div class="inner-wrapper report-details-page task-detail-page">
        <div class="panel-heading" id="rep_btn">
            <span class="panel-title">{{ $page_title }}</span>
            <a href="{{route('typing-test-report')}}" class="btn btn-primary pull-right back_button" data-placement="top" data-content="click back button">Back To Index</a>


{{--             <a href="{{ route('company-details-pdf', ['task_id'=>$data[0]->task_id]) }}" class="report_pdf" target="_blank"><img src="{{ URL::asset('assets/img/pdf-icon.png') }}" alt=""></a> --}}
            <div class="clearfix"></div>
        </div>
        <div class="app-container col-sm-12">
            <h3 class="page-title text-center green">Typing Test Information</h3>

            <p><br></p>
  
            <h3>Bangla Original Text</h3>

            {!! $bangla_text->original_text !!}


            <h3>Bangla Answered Text</h3>

            {!! $bangla_text->answered_text !!}

            <p><br><br><br></p>

            <h3>English Original Text</h3>

            {!! $english_text->original_text !!}


            <h3>English Answered Text</h3>

            {!! $english_text->answered_text !!}

            {{-- {{$bangla_text->Original_text}} --}}

        </div>
    </div>


<style>
    

*{
    color: #000 !important;
}

</style>

@stop