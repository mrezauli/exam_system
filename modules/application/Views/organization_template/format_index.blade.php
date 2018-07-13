@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')

    <style>
        .panel-body #down
        {
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .panel-body  #down:hover {
            background-color: #337ab7;
        }
    </style>

    <!-- page start-->
    <div class="row user-index-page">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body" style="padding-top: 50px">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <a class="btn-success btn-lg paste-blue-button-bg" id="down" href="{{ route('download-user-excel') }}">
                                    <strong>Download Candidate Excel Format</strong>
                                </a>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page end-->


    <!--script for this page only-->
    @if($errors->any())
        <script type="text/javascript">
            $(function(){
                $("#addData").modal('show');
            });
        </script>
    @endif

@stop