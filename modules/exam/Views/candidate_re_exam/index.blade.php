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


            <div class="panel-body col-sm-offset-3 col-sm-6">
                <div class="adv-table">


                    <p> &nbsp;</p>
                    <p> &nbsp;</p>


                    {!! Form::open(['route' => ['update-candidate-re-exam'],'id' => 'jq-validation-form','class' => 'default-form mt-30']) !!}


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('exam_code_id', 'Exam Code:', ['class' => 'control-label']) !!}
                                <small class="required">*</small>
                                @if(count($exam_code_list)>0)
                                {!! Form::select('exam_code_id', $exam_code_list, Input::get('exam_code_list')? Input::get('exam_code_list') : null,['id'=>'exam_process_code_list','class' => 'form-control  js-select','required'=>'required']) !!}
                                @else
                                {!! Form::text('exam_code_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                @endif
                            </div>

                        </div>
                    </div>


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('roll_no', 'Candidate Roll No:', ['class' => 'control-label']) !!}
                                 <small class="required">*</small>
                                {!! Form::text('roll_no', Input::get('roll_no')? Input::get('roll_no') : null, ['id'=>'roll_no', 'class' => 'form-control','required']) !!}
                            </div>

                        </div>
                    </div>


                    {{-- <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-6">
                                  {!! Form::label('dob', 'Date of Birth:', ['class' => 'control-label']) !!}
                                  <small class="required">*</small>
                                  {!! Form::text('dob', Input::get('dob')? Input::get('dob') : null, ['id'=>'dob', 'class' => 'form-control datepicker','required']) !!}
                                  <span class="input-group-btn add-on">
                                    <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                                </span>
                            </div>

                        </div>
                    </div> --}}


                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('exam_type', 'Exam Type:', ['class' => 'control-label']) !!}
                                <small class="required">*</small>
                                {!! Form::select('exam_type', array(''=>'Select exam type'),Input::get('exam_type')? Input::get('exam_type') : null,['class' => 'form-control','title'=>'select exam type','required']) !!}
                            </div>

                        </div>
                    </div>

                    <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                        <div class="row">
                            
                            <div class="col-sm-12">
                                {!! Form::label('status', 'Status :', ['class' => 'control-label']) !!}
                                {!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','title'=>'select status of company']) !!}
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

<input type="hidden" name="exam_type_previous" id="exam_type_previous" class="form-control" value="">

<?php $exam_type = Session::has('exam_type') ? Session::get('exam_type') : ''; ?>


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

        $('.datepicker').each(function(index, el) {

         $(el).datepicker({
             format: 'yyyy-mm-dd'
         });

     });


        $('#exam_process_code_list').change(function(event) {

            ajax_get_main_exam_type();

        });


       var exam_type = "{!! $exam_type !!}";

       if(exam_type == 'aptitude_test'){
           $('#exam_type').append('<option value="aptitude_test" selected="selected">Aptitude Test</option>');

       }

       if(exam_type == 'bangla'){

           $('#exam_type').append('<option value="bangla" selected="selected">Bangla</option>');
           $('#exam_type').append('<option value="english">English</option>');
           $('#exam_type').append('<option value="all">All</option>');

       }

       if(exam_type == 'english'){

           $('#exam_type').append('<option value="bangla">Bangla</option>');
           $('#exam_type').append('<option value="english" selected="selected">English</option>');
           $('#exam_type').append('<option value="all">All</option>');

       }

       if(exam_type == 'all'){

           $('#exam_type').append('<option value="bangla">Bangla</option>');
           $('#exam_type').append('<option value="english">English</option>');
           $('#exam_type').append('<option value="all" selected="selected">All</option>');

       }


        function ajax_get_main_exam_type(){

            $.ajax({
              url: "{{Route('ajax-get-main-exam-type')}}",
              type: 'POST',
              data: $('form').serialize(),
              success: function(exam_type){
                

                // var exam_code = jQuery.parseJSON(data);


                 var exam_type_previous = $('#exam_type_previous').val();

                 if (exam_type == exam_type_previous) {
                    return false;
                 }

                if(exam_type == ''){

                   $("#exam_type option[value='aptitude_test']").remove();
                   $("#exam_type option[value='bangla']").remove();
                   $("#exam_type option[value='english']").remove();
                   $("#exam_type option[value='all']").remove();

                }



                if(exam_type == 'typing_test'){

                 $("#exam_type option[value='aptitude_test']").remove();
                 $("#exam_type option[value='bangla']").remove();
                 $("#exam_type option[value='english']").remove();
                 $("#exam_type option[value='all']").remove();

                 $('#exam_type').append('<option value="bangla">Bangla</option>');
                 $('#exam_type').append('<option value="english">English</option>');
                 $('#exam_type').append('<option value="all">All</option>');

                 // $("#exam_type option[value='aptitude_test']").removeAttr('selected');
                 // $('#exam_type').removeAttr('readonly');

                }


                if(exam_type == 'aptitude_test'){

                 $("#exam_type option[value='aptitude_test']").remove();
                 $("#exam_type option[value='bangla']").remove();
                 $("#exam_type option[value='english']").remove();
                 $("#exam_type option[value='all']").remove();


                 $('#exam_type').append('<option value="aptitude_test" selected="selected">Aptitude Test</option>');
                    // $('#exam_type').attr('readonly', 'readonly');

                 $("#exam_type option[value='aptitude_test']").prop('selected', 'selected');

                }

                $('#exam_type_previous').val(exam_type);

              }


            });


        }

    </script>
@stop



