<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >
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
   margin-bottom: 30px;
}

.form-group.image .row{
background: #2681a3;
opacity: .97;
}

.page-title{
  color: #18193c;
  font-weight: 600;
  font-size: 30px;
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
  color: #18193c;
  font-size: 30px;
  display: inline-block;
  position: relative;
  left: 45.7%;
  margin-bottom: 20px;
}

</style>
  
  
  
<div class="form-block">

  {!! Form::open(['route' => ['store-exam'],'id' => 'jq-validation-form','class' => 'exam-form']) !!}
  
  <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
      <div class="row">
  
      

      <div class="col-sm-offset-2 col-sm-8 radios">
      <h3 class="page-title text-center">BCC Online Exam</h3>
        <label class="label_radio r_on" for="exam_type">
          <input name="exam_type" id="exam_type_bangla" class="exam_type" value="bangla" type="radio" checked="checked"> Bangla
        </label>
        <label class="label_radio r_off" for="exam_type">
          <input name="exam_type" id="exam_type_english" class="exam_type" value="english" type="radio"> English
        </label>

        <button type="button" class="btn start-button pull-right">Start</button>

        <div class="time-block">
          <div class="time text-center"></div>
        </div>
  </div>

  
  
  
  </div>
  </div>
  
  
  
  <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
      <div class="row">
  
  <div class="col-sm-offset-2 col-sm-8">
      
  
      {!! Form::textarea('original_text', Input::old('original_text'), ['id'=>'original_text', 'class' => 'form-control', 'size' => '10x7','disabled']) !!}

  </div>
  
  
  </div>
  </div>
  
  

  
  <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
      <div class="row">
  
  <div class="col-sm-offset-2 col-sm-8">
      {!! Form::label('answered_text', 'Type here:', ['class' => 'control-label']) !!}
      {!! Form::textarea('answered_text', Input::old('answered_text'), ['id'=>'answered_text', 'class' => 'form-control', 'size' => '10x7','disabled']) !!}
  </div>
  
  
  </div>
  </div>
  
  
<input type="hidden" name="status" id="status" class="form-control" value="active">
  

<input type="hidden" name="typing_details_id" id="typing_details_id" class="form-control" value="">
<input type="hidden" name="typing_master_id" id="typing_master_id" class="form-control" value="">
<input type="hidden" name="wpm" id="wpm" class="form-control" value="">
<input type="hidden" name="accuracy" id="accuracy" class="form-control" value="">



<div class="row">
  <div class="form-margin-btn col-sm-offset-2 col-sm-8 text-right">
      {!! Form::submit('Submit', ['class' => 'btn btn-primary submit-button','data-placement'=>'top']) !!}
  </div>
</div>



  {!! Form::close() !!}</div>

	
<div id="test_check_box"></div>


	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/samples/js/sample.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/typingtest.js') }}"></script>



<script>



$('#answered_text').on('paste', function (e) {

  return false;

});

var answered_text_length = 0;

var answered_text = '';

$('#answered_text').on('keypress', function(event) {
  
  
  var diff = $('#answered_text').val().split('').length - answered_text_length;
 
  console.log(diff);

  var fff = '';



  if(diff > 3){

    $('#answered_text').val(answered_text);
  }


  answered_text = $('#answered_text').val();

  answered_text_length = $('#answered_text').val().split('').length;



});

















var first_exam_type = {!! json_encode($first_exam_type) !!};



if(first_exam_type == 'english'){

$("#exam_type_bangla").attr('checked', 'checked');

$("#exam_type_english").attr('disabled', 'disabled');


}else if(first_exam_type == 'bangla'){

$("#exam_type_english").attr('checked', 'checked');

$("#exam_type_bangla").attr('disabled', 'disabled');


}



$('.exam-form').submit(function(e) {
 
e.preventDefault();


$('#answered_text').trigger('keypress');

stopinterval();

});




var time = 10;




  function stopinterval(){

  var answered_text = $('#answered_text').val();


  


  var ttt = $('#test_check_box').diffString(answered_text);



  console.log(correct_words + " " + ins);




  del = del.length;
 

  if(ins[0] == 0){
    ins = 0;
  }else{
    ins = ins.length;
  }

  correct_words = correct_words.length;

  var total = correct_words + ins;


  var accuracy = correct_words/total*100;

  var wpm = total/time;

   console.log($('#test_check_box').text().split(' '));
   console.log(ins);
   console.log(del);
   console.log(correct_words);
   console.log(total);
   console.log(accuracy);

  $('#wpm').val(wpm);

  if(! isNaN(accuracy)){
    $('#accuracy').val(accuracy);
  }else{
    $('#accuracy').val(0);
  }


  if(! isNaN(wpm)){
    $('#wpm').val(wpm);
  }else{
    $('#wpm').val(0);
  }
  

  $('.exam-form')[0].submit();
  return false;
}










function ddd(){



    var x = time * 60 * 1000;

    var beforeTime = +new  Date();

    _intervalId = window.setInterval(function() {
    
    var diff = (+new Date() - beforeTime);
    //console.log(elapsedTime);
    
    var remainingTime = x - diff;

    remainingTime = Math.ceil(remainingTime / 1000);

    var minutes = Math.floor(remainingTime/60);
    var seconds = remainingTime % 60;
    
    if (minutes < 10) {
         minutes = "0" + minutes;
    }

    if (seconds < 10) {
         seconds = "0" + seconds;
    }

    if(diff >= 500) {
      $('.time').text(minutes + ':' + seconds);
    }



    if(remainingTime <= 0) {
      stopinterval(); // stop the interval


    //setTimeout(function() {}, 1000);

    }
       

  }, 20);



}                     



function eee(){

  var x = '10';

  $('.time').text(x + ':' + '00');

}



var english_question = {!! json_encode($english_question) !!};
var bangla_question = {!! json_encode($bangla_question) !!};





$('.start-button').click(function(event) {
  
$('#answered_text').removeAttr('disabled');


ddd();

if($( ".exam_type:checked" ).val() == 'english'){

  $( "#original_text" ).html(english_question.typing_question);
  $( "#test_check_box" ).text(english_question.typing_question);
  $( "#typing_master_id" ).val(english_question.type_mst_id);
  $( "#typing_details_id" ).val(english_question.id);

}else{

  $( "#original_text" ).html(bangla_question.typing_question);
  $( "#test_check_box" ).text(bangla_question.typing_question);
  $( "#typing_master_id" ).val(bangla_question.type_mst_id);
  $( "#typing_details_id" ).val(bangla_question.id);


}


$('.start-button').css('display', 'none');




});


eee();



</script>


