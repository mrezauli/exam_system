<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
{{-- <link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.<div class="exam-page-wrapper container"> --}}

<?php 

use Modules\Question\QuestionPaperSet;
use Modules\Exam\AptitudeExamResult;

?>

 
<style>


@media screen{.pc{display:block !important;}}

    body{
        margin-left: 15px;
        margin-bottom: 100px;
    }

    .form-group.image .row{
        background: #2681a3;
        opacity: .97;
    }

    button.btn {
        padding: 6px 18px;
        margin-left: 13px;
    }

    .page-title{
        color: #fff;
        font-size: 20px;
    }

/*    .btn-xs {
        padding: 5px 10px;
        font-size: 15px;
        border-radius: 8px;
    }*/

    .footer-form-margin-btn .btn
    {
        padding: 6px 10px;
        text-transform: uppercase;

        background: -moz-linear-gradient(top,  #267c99 50%, #007299 50%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,#267c99), color-stop(50%,#007299)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #267c99 50%,#007299 50%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #267c99 50%,#007299 50%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #267c99 50%,#007299 50%); /* IE10+ */
        background: linear-gradient(to bottom,  #267c99 50%,#007299 50%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#267c99', endColorstr='#007299',GradientType=0 ); /* IE6-9 */
    }

    #chrom .btn
    {
        padding: 3px 12px;
        font-weight: 400;
        border: none;
        margin-top: 5px;
        margin-left: 10px;

        background: -moz-linear-gradient(top,  #57aac3 50%, #54b3c7 50%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,#57aac3), color-stop(50%,#54b3c7)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #57aac3 50%,#54b3c7 50%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #57aac3 50%,#54b3c7 50%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #57aac3 50%,#54b3c7 50%); /* IE10+ */
        background: linear-gradient(to bottom,  #57aac3 50%,#54b3c7 50%) /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#57aac3', endColorstr='#54b3c7',GradientType=0 );
    }

    hr {
        display: block;
        height: 2px;
        border: 0;
        border-top: 2px solid #990055;
        margin: 1em 0;
        padding: 0;
    }

    .alert-message{
      text-align: center;
      padding: 10px 0 40px;
      font-weight: 700;
      font-size: 18px;
    }

    iframe {
        border: 3px solid #0a0031;
        margin: 20px;
        width: 941px;
        margin: 20px auto 0;
        display: block;
    }

    .time-block {
        position: fixed;
        right: 20px;
        color: #ffa020;
        top: 7px;
    }

    .time-block .time{
        display: inline-block;
    }

    .form-block .form-group{
        margin-bottom: 7px;
    }

    .page-title span {
        position: absolute;
        right: -100px;
    }  

    .ddd{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .username-span, .roll-no-span{
        color: #fff;
    } 

    #addData3 .btn, #addData7 .btn{
        padding: 6px 20px;
        margin: 0 5px;
    } 

</style>

<?php 

$user = Auth::user();
        
$roll_no = $user->roll_no;
$user_id = $user->id;
$username = $user->username;

?>


<div class="form-block">
    <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-2">
                
            <div class="row" id="chrom">
                <span style="color: #AA0055">
                    
                    <a href="https://chrome.google.com/webstore/detail/downloads-overwrite-exist/fkomnceojfhfkgjgcijfahmgeljomcfk?hl=en" target="_blank" class="btn btn-primary btn-xs" id="chrom" ata-placement="top" style="margin-right: 50px"><strong>Plugins</strong></a>
                </span>
            </div>  

            </div>

            <div class="col-sm-8 ddd">

            <span class="roll-no-span">Roll No. {{$roll_no}}</span>
                <h3 class="page-title text-center" style="margin:7px 0px !important;position:relative;right:5px">Exam Code: {{ $exam_code }}</h3>
            <span class="username-span">Name: {{$username}}</span>

            </div>

            <div class="col-sm-2 pull-right">
                <h3 class="page-title text-center time-block" style="margin-top: 5px!important;">

                    <div class="time-block pull-right">
                        Time Left: <div class="time text-center"></div>
                    </div>

                </h3>
            </div>
        </div>
    </div>

    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{--set some message after action--}}
    @if (Session::has('message'))
        <div class="alert alert-success">{{Session::get("message")}}</div>

    @elseif(Session::has('error'))
        <div class="alert alert-warning">{{Session::get("error")}}</div>

    @elseif(Session::has('info'))
        <div class="alert alert-info">{{Session::get("info")}}</div>

    @elseif(Session::has('danger'))
        <div>{{Session::get("danger")}}</div>
    @endif

<?php $total_question_marks = 0; ?>

    @if(isset($apt_test_questions))
        @foreach($apt_test_questions as $ques_values)

            <?php 

            $question_set_id = $ques_values->question_set_id;

            $qbank_aptitude_id = $ques_values->qbank_aptitude_question->id;
            
            $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$question_set_id)->where('status','active')->first();

            $total_question_marks += $question_mark = isset($question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark) ? $question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark : '0';

             ?>

        @endforeach
    @endif


    <div class="row text-center" id="chrom">
        

<div>
    <span class="page-title" style="color:#333">Question Paper</span>
</div>

<div>
    <span>Total Time: {{$default_time}} mins</span>
</div>

<div>
    <span>Total Marks: {{$total_question_marks}}</span>
</div>


    </div>
    <div style="height: 10px;">&nbsp;</div>
    <?php

        $i = 1;

        $count = count($apt_test_questions);

        $j = 0;

        $k = 0;

        $l = 0;

    ?>





    @if(isset($apt_test_questions))
        @foreach($apt_test_questions as $ques_values)
{{-- {{dd($ques_values)}} --}}
            <?php  


            if($ques_values->question_type == 'word'){

                $j++;

                $question_name = $ques_values->question_type . '-' . $j;

            }
            elseif($ques_values->question_type == 'excel'){

                $k++;

                $question_name = $ques_values->question_type . '-' . $k;

            }
            elseif($ques_values->question_type == 'ppt'){

                $l++;

                $question_name = $ques_values->question_type . '-' . $l;

            }


            $question_set_id = $ques_values->question_set_id;

            $qbank_aptitude_id = $ques_values->qbank_aptitude_question->id;
            
            $question_set = QuestionPaperSet::with('aptitude_questions')->where('id',$question_set_id)->where('status','active')->first();


            $question_mark = isset($question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark) ? $question_set->aptitude_questions->keyBy('id')->get($qbank_aptitude_id)->pivot->question_mark : '0';


?>
            
        <div class="row question-block">
            <div class="col-sm-12" style="position:static; color: blue; background-color:silver">
                {{-- <span><b>&nbsp;Question No :: &nbsp; {{$i}}</b></span>&nbsp;&nbsp;&nbsp; --}}
                <span><b>&nbsp;Q.{{$i}}</b></span>&nbsp;&nbsp;&nbsp;
                <span><b>&nbsp;Question Name: {{$ques_values->qbank_aptitude_question->title}}</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{-- <span><b>&nbsp;Marks: {{$question_mark}}</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}

                @if(isset($final_submit))
                    @if(count($final_submit)>0)

                        @foreach($final_submit as $values)
                            @if ($values->qsel_apt_test->qbank_aptitude_id == $qbank_aptitude_id && $values->re_submit_flag==0) 

                        <a href="{{ route('answer-redownload', [$values->id,$qbank_aptitude_id]) }}" class="btn btn-primary btn-xs disable-button re-ans-dow{{$values->id}}" onclick="re_ans_dow({{$values->id}})" data-placement="top"><strong>Review Answer Sheet</strong></a>

                            @endif
                        @endforeach

                    @endif
                @endif




                <?php

                    if($ques_values->question_type == 'word'){$route = 'down-new-doc';}
                    elseif($ques_values->question_type == 'excel'){$route = 'down-csv-file';}
                    else{$route = 'down-ppt-file';}

                    $btn_class = 'download_btn';

                ?>

                {{-- <a href="" style="visibility:hidden;margin:5px;" class="btn btn-primary btn-xs">ddd</a> --}}
                @if(isset($ques_values['file_download'][0]))
                    @if($ques_values['file_download'][0]['open_flag']==1)
                        <tr>
                            <td><a href="" style="visibility:hidden;margin:5px;" class="btn btn-primary btn-xs">ddd</a></td>
                        </tr>
                    @endif
                @else
                    <tr class="{{$btn_class.$i}}">
                        <td>
                            <a href="{{ route($route, [$ques_values->id,$ques_values->qbank_aptitude_question->id]) }}" class="btn btn-primary disable-button btn-xs {{$btn_class.$i}}" onclick="download_hide({{$i}})" data-placement="top" style="margin: 5px 5px;"><strong>Create Answer Sheet</strong></a>
                            <a href="" style="visibility:hidden;margin:5px;" class="btn btn-primary btn-xs">ddd</a>
                        </td>
                    </tr>
                @endif

                <span><b>&nbsp;Marks: {{$question_mark}}</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            
            <div class="col-sm-12" style="color: blue">
                <p><br><br><br></p>
                {{-- <iframe src="{{URL::asset($ques_values->qbank_aptitude_question->image_file_path)}}" width="100%;" height="600px;"></iframe> --}}
            </div>
        </div>
            <?php $i++; ?>
        @endforeach
    @endif



</div>

{{-- {{dd($final_submit)}} --}}

<hr/>
<div class="footer-form-margin-btn" style="text-align: center">
    @if(isset($final_submit))
        @if(count($final_submit)>0)
            <div class="table-primary">

                {!! Form::open(['route' => 'answer-re-submit','class' => 'form-horizontal','id' => 'form_2','files'=>true]) !!}

                <input type="hidden" id="q_no" name="q_no" value="<?php echo $count; ?>"/>
                

                <div class="col-sm-offset-15 col-sm-3" style="color: blue;">{!! Form::label('file_upload_attachment', 'Upload Answer Files:', ['class' => 'control-label','style'=>'color: blue; font; font-weight: bold']) !!}</div>
                <div class="col-sm-offset-15 col-sm-3">
                    <div class="image-center">
                        <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                            <div class="image-center">
                                {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.docx,.xlsx,.pptx','style'=>'color: blue']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-offset-15 col-sm-6">{!! Form::submit('Re-Submit', ['class' => 'btn btn-primary pull-left','data-placement'=>'top']) !!}
                <a style="margin-left:20px" href="#" class="btn btn-primary pull-right disable-button terminate_exam">Terminate Your Exam</a>
                </div>
                <div class="col-sm-offset-15 col-sm-3">&nbsp;</div>

                {!! Form::close() !!}

            </div>
        @else
            {!! Form::open(['route' => 'answer-submit','class' => 'form-horizontal','id' => 'form_2','files'=>true]) !!}

            <input type="hidden" id="q_no" name="q_no" value="<?php echo $count; ?>"/>

            <div class="col-sm-offset-15 col-sm-3" style="color: blue;">{!! Form::label('file_upload_attachment', 'Upload Answer Files:', ['class' => 'control-label','style'=>'color: blue; font; font-weight: bold']) !!}</div>
            <div class="col-sm-offset-15 col-sm-3">
                <div class="image-center">
                    <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                        <div class="image-center">
                            {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.docx,.xlsx,.pptx','style'=>'color: blue']) !!}

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-offset-15 col-sm-3">{!! Form::submit('Submit', ['class' => 'btn btn-primary','data-placement'=>'top']) !!}</div>
            <div class="col-sm-offset-15 col-sm-3">&nbsp;</div>

            {!! Form::close() !!}
        @endif
    @endif
</div>



<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field. <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
            </div>
            <div class="modal-body alert-body">

                <div class="alert-message">You have 2 minutes remaining.</div>
                <div class="form-margin-btn text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                                        
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>



<div id="addData3" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
            </div>
            <div class="modal-body alert-body">

                <div class="alert-message"> Are you sure you want to finish the exam? </div>
                <div class="form-margin-btn text-right">
                    <button type="button" class="btn btn-default no-button" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary yes-button" data-dismiss="modal">Yes</button>
                </div>
                                        
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>


<div id="addData7" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field. <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
            </div>
            <div class="modal-body alert-body">

                <div class="alert-message">আপনাকে সবগুলো Answer Sheet ডাউনলোড করে উওর লিখে অতপর সবগুলো Answer Sheet আপলোড করে Submit করতে হবে। Message টি পড়া হলে OK Click করুন।</div>
                <div class="form-margin-btn text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
                                        
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>


<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/cookie.js') }}"></script>



<script>


$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }
});


var upload_answer_alert = '{!! Session::get('ddd') !!}';


if (upload_answer_alert) {
    $("#addData7").modal('show');

}

$('.terminate_exam').click(function(e) {
    
    $("#addData3").modal('show');

});

    

$('#addData3').on('click', '.yes-button', function(e) {

    window.location = '{!! route('aptitude-congratulation') !!}';

});




    //Download Button Hide

    function download_hide(id){

        $('.download_btn'+id).css('display', 'none');

    }



    /*$('.doc_download_btn').click(function(event) {
        $('.doc_download_btn').css('display', 'none');
        //$('.doc_submit_btn').show();
    });

    $('.excel_download_btn').click(function(event) {
        $('.excel_download_btn').css('display', 'none');
        //$('.doc_submit_btn').show();
    });

    $('.ppt_download_btn').click(function(event) {
        $('.ppt_download_btn').css('display', 'none');
        //$('.doc_submit_btn').show();
    });*/

    //Re-Download Sheet and Re-Submit Answer Sheet

    function re_ans_dow(id)
    {
        $('.re-ans-dow'+id).css('display', 'none');
        $('.re-submit-sheet'+id).show();
    }

         

    /*function myFunction() {
     //var curr_id = $('select[id=curr]').val();
     $.ajax({
     url: "{{--{{Route('down-new-doc')}}--}}",
     type: 'POST',
     data: {_token: '{{--{!! csrf_token() !!}--}}',currency_id: null },
     success: function(data){alert(12312);
     window.location = '{{--{{ Route('down-new-doc') }}--}}';
     //$('#exchange_rate').val(data);
     }
     });

     }*/


     var remove_alert_cookie = {!! json_encode($remove_alert_cookie) !!};

     if (remove_alert_cookie == true) {

         Cookies.remove('aptitude_test_alerted');

     }


       function stopinterval(){

       clearInterval(intervalId);
       Cookies.remove('aptitude_exam_time');
       Cookies.remove('aptitude_test_alerted');


       var user_id = '{!! $user_id !!}';
       var question_no = '{!! $count !!}';


       var uploaded_all_files = ajax_get_file_upload_info(user_id,question_no);

       if (uploaded_all_files) {

        window.location = '{!! route('aptitude-congratulation') !!}';
        return false;

       }else{

        window.location = '{!! route('file-upload') !!}';
        return false;

       }

   
       } 



     function ajax_get_file_upload_info(user_id,question_no){

         $.ajax({
           url: "{{Route('ajax-get-file-upload-info')}}",
           type: 'POST',
           data: { user_id: user_id, question_no: question_no},
           success: function(file_upload_info){

            
             // var file_upload_info = jQuery.parseJSON(file_upload_info);

             
             if (file_upload_info == 'all_files_not_submitted') {

                 window.location = '{!! route('file-upload') !!}';
                 return false;

             }else{

              window.location = '{!! route('aptitude-congratulation') !!}';
              return false;

             }


           }


         });


     }











     function alert_message() {

       var alerted = Cookies.get('aptitude_test_alerted');

       if (! alerted) {

         Cookies.set('aptitude_test_alerted',1,{ expires: 1 });
         $("#addData").modal('show');

         setTimeout(function() {

           $("#addData").modal('hide');

         }, 3000);

       }
     }


     function convert_to_minute_second(remainingTime){

       var minutes = Math.floor(remainingTime/60);
       var seconds = remainingTime % 60;
       
       if (minutes < 10) {
            minutes = "0" + minutes;
       }

       if (seconds < 10) {
            seconds = "0" + seconds;
       }

     return minutes + ':' + seconds;

     }


     function set_clock(typing_exam_time){


         var x = typing_exam_time;

         var beforeTime = +new  Date();

         intervalId = window.setInterval(function() {
         
         var diff = (+new Date() - beforeTime);
         
         
         var remainingTime = x - diff;


         remainingTime = Math.ceil(remainingTime / 1000);


         if(diff >= 500) {

           Cookies.set('aptitude_exam_time',remainingTime,{ expires: 1 });

           var minute_second = convert_to_minute_second(remainingTime);

           $('.time').text(minute_second);

         }

         if(remainingTime/60 <= 2 ) {

              alert_message();
         }

         if(remainingTime <= 0) {
           stopinterval(); // stop the interval

         }
            
       }, 20);

}



var remaining_time = {!! json_encode($remaining_time) !!};

var aptitude_exam_time = Cookies.get('aptitude_exam_time');


var minute_second = convert_to_minute_second(remaining_time);

$('.time').text(minute_second);

set_clock(remaining_time*1000);



$(".disable-button").one("click", function() {
    $(this).click(function () { return false; });
});

$("form").submit(function(e) {

    $(this).submit(function() {
        return false;
    });
    return true;
});

</script>