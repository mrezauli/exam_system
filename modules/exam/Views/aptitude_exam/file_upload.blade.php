<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.<div class="exam-page-wrapper container">

<style>

    #original_text {
        max-width: 100%;
        height: 200px;
        background: #efefef;
        cursor: initial;
    }

    .radios label:nth-child(2){
        margin-left: 10px;
    }

    input.exam_type{
        position: relative;
        top: 2.3px;
    }

    .green{
        color:green;
    }

    #test_check_box{
        display: none;
    }

    .form-group.image{
        background: url(http://localhost/exam_system/public/assets/img/k2.jpg);
        /* background-color: white; */
        background-size: 1133px;
        background-position-y: 500px;
        background-position-x: 460px;
        margin-bottom: 0;
    }

    .form-group.image .row{
        background: #2681a3;
        opacity: .97;
    }

    .page-title {
        color: #fff;
        font-size: 18px;
        margin: 10px;
        position: relative;
    }

    .page-title span {
        position: absolute;
        right: 70px;
    }

    .form-group.image .btn, .submit-button{
        background: #333;
        color:#fff;
        border: none;
    }

    .form-group.image .btn:hover,  .submit-button:hover{
        background: #111;
        transition: 0.1s;
    }

    .start-buttons{
      margin: 40px;
    }

    .start-buttons .start-button {
        padding: 6px 10px;
        font-size: 14px;
        border-radius: 2px; 
    }

    .start-buttons .start-button strong{
        font-weight: 500; 
    }


    .submit-button{
        background: #2a8cb1;
        color:#fff;
        border: none;
    }

    .submit-button:hover{
        background: #237897;
        transition: 0.1s;
    }

    label {
        color: #18193c;
        font-size: 20px;
        font-weight: 500;
    }

    .time{
        color: #ffa020  ;
        display: inline-block;
        position: relative;
        left: 0;
        margin-bottom: 0;
    }

    .btn-xs {
        padding: 10px 20px;
        font-size: 20px;
        border-radius: 10px;
    }

    #file_upload_section{
        margin-top: 300px;
        max-width: 1000px;
        margin: 200px auto !important;
        float: none;
    }

    .alert-message{
      text-align: center;
      padding: 10px 0 40px;
      font-weight: 700;
      font-size: 18px;
    }

    .ddd{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .username-span, .roll-no-span{
        color: #fff;
    }

    .time-block {
        position: relative;
        top: 1.7px;
    }

    #addData3 .btn, #addData7 .btn{
        padding: 6px 20px;
        margin: 0 5px;
    }

</style>

<?php 

$user = Auth::user();
        
$roll_no = $user->roll_no;
$username = $user->username;

?>

<div class="form-block">
    <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
            <div class="row">
                <div class="col-sm-2">
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

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4"></div>
            <div class="col-sm-12" id="file_upload_section">
               

            <div class="footer-form-margin-btn" style="text-align: center">
                @if(isset($submitted_files))
                    @if(count($submitted_files)>0)
                        <div class="table-primary">

                            {!! Form::open(['route' => 'answer-re-submit','class' => 'form-horizontal','id' => 'form_2','files'=>true]) !!}

                            <input type="hidden" id="q_no" name="q_no" value="<?php echo $apt_test_questions; ?>"/>

                            <div class="col-sm-offset-15 col-sm-3" style="color: blue;">{!! Form::label('file_upload_attachment', 'Upload Answer Files:', ['class' => 'control-label','style'=>'color: blue; font; font-weight: bold']) !!}</div>
                            <div class="col-sm-offset-15 col-sm-4">
                                <div class="image-center">
                                    <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                                        <div class="image-center">
                                            {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.docx,.xlsx,.pptx','style'=>'color: blue']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-15 col-sm-5">{!! Form::submit('Re-Submit', ['class' => 'btn btn-primary pull-left','data-placement'=>'top']) !!}
                            <a style="margin-left:20px" href="#" class="btn btn-primary pull-right terminate_exam">Terminate Your Exam</a>
                            </div>
                    
                            <div class="clearfix"></div>

                            {!! Form::close() !!}

                        </div>
                    @else
                        {!! Form::open(['route' => 'answer-submit','class' => 'form-horizontal','id' => 'form_2','files'=>true]) !!}

                        <input type="hidden" id="q_no" name="q_no" value="<?php echo $apt_test_questions; ?>"/>

                        <div class="col-sm-offset-15 col-sm-4" style="color:blue;line-height:1;">{!! Form::label('file_upload_attachment', 'Upload Answer Files:', ['class' => 'control-label','style'=>'color: blue; font; font-weight: bold']) !!}</div>
                        <div class="col-sm-offset-15 col-sm-4">
                            <div class="image-center">
                                <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
                                    <div class="image-center">
                                        {!! Form::file('file',['name'=>'file_upload_attachment[]','id'=>'attachment','class' => 'form-control','multiple'=>'multiple','required'=>'required','accept'=>'.docx,.xlsx,.pptx','style'=>'color: blue']) !!}

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-15 col-sm-3">{!! Form::submit('Submit', ['class' => 'btn btn-primary','data-placement'=>'top']) !!}</div>
        
                        <div class="clearfix"></div>


                        {!! Form::close() !!}
                    @endif
                @endif
            </div>
               
            </div>
            <div class="col-sm-3"></div>
        </div>
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

                    <div class="alert-message">আপনাকে সবগুলো Answer Sheet ডাউনলোড করে উওর লিখে অতপর সবগুলো Answer Sheet আপলোড করে Submit করতে হবে । Message টি পড়া হলে OK Click করুন ।</div>
                    <div class="form-margin-btn text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                                            
                </div> <!-- / .modal-body -->
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>

</div>



<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/cookie.js') }}"></script>

<script>



    $('.terminate_exam').click(function(e) {
        
        $("#addData3").modal('show');

    });

    $('#addData3').on('click', '.yes-button', function(e) {

        window.location = '{!! route('aptitude-congratulation') !!}';

    });



    var upload_answer_alert = '{!! Session::get('ddd') !!}';

    if (upload_answer_alert) {

        $("#addData7").modal('show');

    }




    function stopinterval(){

        clearInterval(intervalId);
        Cookies.remove('aptitude_exam_time');
        Cookies.remove('aptitude_test_alerted');

        window.location = '{!! route('aptitude-congratulation') !!}';
        return false;

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


</script>
