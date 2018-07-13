@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

<style>
    hr {
        display: block;
        height: 2px;
        border: 0;
        border-top: 2px solid #990055;
        margin: 1em 0;
        padding: 0;
    }
</style>

        <!-- page start-->

<div class="inner-wrapper index-page">

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

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                
                    {{ $page_title }}

                    <a href="{{route('answer-checking')}}" class="btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>
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


                <ul class="alert alert-danger" style="display: none">
                    <li id="alert-message" class="alert-message"></li>
                </ul>


                <div class="col-lg-12" style="padding-top: 10px; padding-bottom: 10px">
                    
                        @if($data !=null)

                           <b>Name of the Post :  &nbsp;&nbsp;   {{ucfirst($data['relDesignation']['designation_name'])}}</b><br>
                           <b>Total Answer Sheet :  &nbsp;&nbsp;   {{$answer_sheet_array['total_answer_sheet']}}</b><br>
                           <b>Checked Answer Sheet :  &nbsp;&nbsp;   {{$answer_sheet_array['checked_answer_sheet']}}</b><br>
                           <b>Checked by Me :  &nbsp;&nbsp;   {{$answer_sheet_array['my_answer_sheet']}}</b><br>
                        @endif
                    

                <div class="clearfix"></div>

                </div>

                <div class="clearfix"></div>

                {!! Form::open(['route' => 'store-marks','id' => 'jq-validation-form']) !!}

                <?php $i = 1; ?>


                @if(! empty($answer_html_files))
                    @foreach($answer_html_files as $ques_values)


                        {{-- {{dd($ques_values)}} --}}
                          {{-- $question_selection_id[] = $ques_values->id; --}}
 
                        <div class="row">
                            <div class="col-sm-12" style="color: blue; background-color:silver">
                                <span><b>&nbsp;Answer No :: &nbsp; {{$i}}</b></span>&nbsp;&nbsp;&nbsp;
                                <span><b>&nbsp;Question Mark :: &nbsp; {{$ques_values['mark']}}</b></span>&nbsp;&nbsp;&nbsp;
                                @if(1)
                                <tr>
                                    <td>
                                        <a href="{{ route('download-candidate-answersheet', $ques_values['id']) }}" class="btn btn-primary btn-sm" data-placement="top" style="margin: 5px 5px;"><strong>Download Answer Sheet (if required)</strong></a>
                                    </td>
                                </tr>
                                @else
                                <a href="" class="btn btn-primary btn-sm" data-placement="top" style="margin: 5px 5px;visibility:hidden"><strong>Download Answer Sheet</strong></a>
                                @endif
                            </div>


                            <div class="clearfix"></div>

                        
                                <div class="col-sm-105 answer-sheet-block" style="color: blue">

                                    @if($ques_values['type']=='word')
                                        <iframe width="100%" height="600px" src="https://docs.google.com/gview?url=http://qpands.com/exam_system/public/answer_files/image_doc_files/<?php echo $ques_values['file']; ?>&embedded=true" frameborder="0"></iframe>
                                    @elseif($ques_values['type']=='excel')
                                        <iframe width="100%" height="600px" src="{{URL::asset('answer_files/image_excel_files/'. $ques_values['file'])}}" frameborder="0"></iframe>
                                    @elseif($ques_values['type']=='ppt')
                                        <iframe width="100%" height="600px" src="https://docs.google.com/gview?url=http://qpands.com/exam_system/public/answer_files/image_ppt_files/<?php echo $ques_values['file']; ?>&embedded=true" frameborder="0"></iframe>
                                    @endif
                                </div>

                                <div class="col-sm-1 put-marks-block" style="color: blue;padding-right:0;">
                                    <b>Put Marks ::</b> <br>
                                    <input type="hidden" name="marks_id_<?php echo $i; ?>" value="<?php echo $ques_values['id']; ?>" style="width: 50px;" />

                                    <input type="text" class="answer-marks" name="marks_<?php echo $i; ?>" required style="width: 100px;height: 50px;border: double" />

                                    <input type="hidden"  class="question-marks" name="question_marks_<?php echo $i; ?>" value="<?php echo $ques_values['mark']; ?>" style="width: 50px;" />

                                    <div class="alert-message" style="display:none;color:red;">Answer mark must be a valid number and can't be greater than the question mark.</div>
                                </div>

                        </div>
                        <?php $i++; ?>
                    @endforeach

                @else

                <h3 class="text-center">Candidate Answer Sheet Not Available !!!</h3>


                @endif


                <input type="hidden" name="count" value="<?php echo $i-1; ?>"/>
                <input type="hidden" name="candidate_id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"/>
                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>"/>
                <input type="hidden" name="designation_id" value="<?php echo $designation_id; ?>"/>
                <input type="hidden" name="exam_code_id" value="<?php echo $exam_code_id; ?>"/>
                <input type="hidden" name="exam_date" value="<?php echo $exam_date; ?>"/>
                <input type="hidden" name="shift" value="<?php echo $shift; ?>"/>
               
                <div class="col-sm-offset-15 col-sm-3">&nbsp;</div>
                @if($data !=null)
                    <div class="col-sm-11">{!! Form::submit('Submit Marks', ['class' => 'btn btn-primary pull-right','data-placement'=>'top']) !!}</div>
                @endif
                <div class="col-sm-offset-15 col-sm-5">&nbsp;</div>

                {!! Form::close() !!}

            </section>
        </div>
    </div>
</div>
<!-- page end-->

@stop
<!--script for this page only-->


@section('custom-script')

<script>

$('.answer-marks').keyup(function(e) {

    var answer_mark = parseInt($(this).val());

    var question_mark = parseInt($(this).siblings('.question-marks').val());

if (! Number.isInteger(answer_mark) || answer_mark > question_mark) {

    $('.alert-message').show();
}else{
    $('.alert-message').hide();
}

});

// $('form').on('submit', function(e) {
  

//    var data =  $(this).serializeArray();

//    var count_data = data.find(function (item) { 
//        return item.name === 'count';
//    }); 



//    var lookup = {};
//    for (var i=0; i <= data.length - 1; i++) {

//        var ggg = data[i].name;

//        var kkk = data[i];

//        lookup[ggg] = kkk;
//    }

//    function ddd(){

//         var offset = $('#alert-message').offset().top - 100;

//         $('html, body').animate({scrollTop:offset}, 500);

//         setTimeout(function() {
//             $('input[type="submit"]').removeAttr('disabled');

//         }, 10);

//     };



//    for (var i=1; i <= count_data.value; i++)
//    {


//        aptitude_exam_result_id = lookup['marks_id_' + i].value;

//        marks = parseInt(lookup['marks_' + i].value);

//        question_marks = parseInt(lookup['question_marks_' + i].value);


      
//        if( marks > question_marks || ! Number.isInteger(marks) ){

//          $('.alert-danger').show();

//          $('.alert-message').html("Answer mark must be a valid number and can't be greater than the question mark.");

//          ddd();

//          e.preventDefault();

//          break;

//      }

//    }

    
// });







</script>

@stop

        
