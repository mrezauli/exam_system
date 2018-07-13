@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<div class="row company-index-page">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $page_title }}
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


            <div class="panel-body col-sm-offset-4 col-sm-4">
                <div class="adv-table">


                    <p> &nbsp;</p>
                    <p> &nbsp;</p>


                    {!! Form::open(['route' => ['update-exam-time'],'id' => 'jq-validation-form','class' => 'default-form mt-30']) !!}


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('typing_exam_time', 'Typing Exam Time in Minutes:', ['class' => 'control-label']) !!}
                                 <small class="required">*</small>
                                {!! Form::text('typing_exam_time', $typing_exam->exam_time, ['id'=>'typing_exam_time', 'class' => 'form-control', 'style'=>'text-transform:capitalize','required','typing_exam_time'=>'enter post name, example :: air-conditioner']) !!}
                            </div>

                        </div>
                    </div>


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('aptitude_exam_time', 'Aptitude Exam Time in Minutes:', ['class' => 'control-label']) !!}
                                 <small class="required">*</small>
                                {!! Form::text('aptitude_exam_time', $aptitude_exam->exam_time, ['id'=>'aptitude_exam_time', 'class' => 'form-control', 'style'=>'text-transform:capitalize','required','aptitude_exam_time'=>'enter post name, example :: air-conditioner']) !!}
                            </div>

                        </div>
                    </div>

                    <p> &nbsp; </p>

                    <div class="form-margin-btn text-right">
                        {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save post information']) !!}
                    </div>

                    {!! Form::close() !!}




                    {{--<span class="pull-right">{!! str_replace('/?', '?', $data->render()) !!} </span>--}}
                </div>
            </div>
        </section>
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
@if(Session::has('flash_message_error'))
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
    @endif

        <!--script for this page only-->
@stop

@section('custom-script')
    <script>

        /*var column_index = ['1','2'];
        create_dropdown_column(column_index);*/

    </script>
@stop