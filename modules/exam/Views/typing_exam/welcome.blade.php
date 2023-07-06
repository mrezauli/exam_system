<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >


<style>

/*quick-edit*/


.form-control:focus, #focusedInput {
    border: 1px solid #e2e2e4;
    box-shadow: none;
}


/*quick-edit*/


.typing-exam-submit-button{
  display: none;
}

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
  font-size: 18px;
  width: 270px;
  margin-left: auto;
  margin-right: auto;
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
  margin-bottom: 20px;
}


.mt20{
  margin-top: 20px;
}

</style>

  {{-- {{$first_exam_type}} --}}

<div class="form-block">



  <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">



      <div class="col-sm-offset-2 col-sm-8 radios">

      <a class="btn btn-alert pull-right mt20" href="{{route('candidate-logout')}}">LogOut</a>

        <h3 class="page-title text-center">RECRUITMENT EXAM MANAGEMENT SYSTEM V2</h3>

          <a href="{{route('typing-exams')}}" type="submit" class="btn start-button">Start Typing Exam</a>

      </div>

    </div>
  </div>




  {!! Form::open(['route' => ['submit-typing-exam',$exam_type],'id' => 'jq-validation-form','class' => 'exam-form']) !!}

  <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

      <div class="col-sm-offset-2 col-sm-8">


        {!! Form::textarea('original_text', $question, ['id'=>'original_text', 'class' => 'form-control', 'size' => '10x7', 'readonly']) !!}

      </div>


    </div>
  </div>




  <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

      <div class="col-sm-offset-2 col-sm-8">
        {!! Form::label('answered_text', 'Type here:', ['class' => 'control-label']) !!}
        {!! Form::textarea('answered_text', Input::old('answered_text'), ['id'=>'answered_text', 'class' => 'form-control', 'size' => '10x7','read-only']) !!}
      </div>


    </div>
  </div>


<input type="hidden" name="status" id="status" class="form-control" value="active">


<input type="hidden" name="qselection_typing_id" id="qselection_typing_id" class="form-control" value="">
<input type="hidden" name="accuracy" id="accuracy" class="form-control" value="">
<input type="hidden" name="wpm" id="wpm" class="form-control" value="">


<div class="row">
  <div class="form-margin-btn col-sm-offset-2 col-sm-8 text-right">
      {!! Form::submit('Submit', ['class' => 'btn btn-primary submit-button typing-exam-submit-button','data-placement'=>'top']) !!}
  </div>
</div>



  {!! Form::close() !!}</div>


<div id="test_check_box"></div>


<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-3.2.0.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/cookie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/ckeditor/samples/js/sample.js') }}"></script>
<script type="text/javascript" src="http://localhost/exam_system/modules/exam/views/exams/typingtest.js"></script>



<script>

//Disable Back Button ::

// window.history.forward();
// function noBack() { window.history.forward(); }


//check for navigation time API support
if (window.performance) {
  console.info("window.performance work's fine on this browser");
}

if (performance.navigation.type == 1) {
  console.info( "This page is reloaded" );
} else {
  console.info( "This page is not reloaded");
}

$('#answered_text').on('paste', function (e) {

  return false;

});

var answered_text_length = 0;

var answered_text = '';

// $('#answered_text').on('keypress', function(event) {


//   var diff = $('#answered_text').val().split('').length - answered_text_length;

//   console.log(diff);

//   var fff = '';



//   if(diff > 3){

//     $('#answered_text').val(answered_text);
//   }


//   answered_text = $('#answered_text').val();

//   answered_text_length = $('#answered_text').val().split('').length;



// });









var first_exam_started = {!! json_encode($first_exam_started) !!};

var first_exam_completed = {!! json_encode($first_exam_completed) !!};

var last_exam_started = {!! json_encode($last_exam_started) !!};

var last_exam_completed = {!! json_encode($last_exam_completed) !!};

var typing_exam_default_time = {!! json_encode($typing_exam_time) !!};


if ( (! first_exam_started && ! last_exam_started) || (first_exam_completed && ! last_exam_started) ) {

  Cookies.remove('typing_exam_time');
  Cookies.remove('answered_text');

}



if( (first_exam_started && ! first_exam_completed ) || (last_exam_started && ! last_exam_completed) ){


$('.typing-exam-submit-button').show();

  var typing_exam_time = Cookies.get('typing_exam_time');

  var answered_text = Cookies.get('answered_text');


  if (typing_exam_time > 0) {

    var minute_second = convert_to_minute_second(typing_exam_time);

    $('.time').text(minute_second);

    $('#answered_text').text(answered_text);

    set_clock(typing_exam_time*1000);

  }else{

    console.log(typing_exam_default_time);

    set_clock(typing_exam_default_time*60*1000);

  }



}else{

  $('.time').text( typing_exam_default_time + ':' + '00');
}






var first_exam_type = {!! json_encode($first_exam_type) !!};



if(first_exam_type == 'english'){

$("#exam_type_bangla").attr('checked', 'checked');

$("#exam_type_english").attr('disabled', 'disabled');


}else if(first_exam_type == 'bangla'){

$("#exam_type_english").attr('checked', 'checked');

$("#exam_type_bangla").attr('disabled', 'disabled');


}



// $('.exam-form').submit(function(e) {

// e.preventDefault();


// $('#answered_text').trigger('keypress');

// stopinterval();

// });




  var time = 10;


  function stopinterval(){


  // var ttt = $('#test_check_box').diffString(answered_text);
  // question = question.split(/\s+/);
  // answer = answer.split(/\s+/);



  //   var question = createGroupedArray(question, 5);

  //   var answer = createGroupedArray(answer, 5);
  //   console.log(answer);

  //   $(answer).each(function(index, el) {

  //     diffString(question[index].join(' '), el.join(' '));

  //   });


  //   diffString(question, answer);

  // //console.log(correct_words + " " + ins);




  // del = del.length;


  // if(ins[0] == 0){
  //   ins = 0;
  // }else{
  //   ins = ins.length;
  // }

  // correct_words = correct_words.length;

  // var total = correct_words + ins;


  // var accuracy = correct_words/total*100;

  // var wpm = total/time;

  //  console.log($('#test_check_box').text().split(' '));
  //  console.log(ins);
  //  console.log(del);
  //  console.log(correct_words);
  //  console.log(total);
  //  console.log(accuracy);

  // $('#wpm').val(wpm);

  // if(! isNaN(accuracy)){
  //   $('#accuracy').val(accuracy);
  // }else{
  //   $('#accuracy').val(0);
  // }


  // if(! isNaN(wpm)){
  //   $('#wpm').val(wpm);
  // }else{
  //   $('#wpm').val(0);
  // }

  clearInterval(intervalId);

  $('.exam-form')[0].submit();
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

      Cookies.set('typing_exam_time',remainingTime,{ expires: 1 });

      var answered_text = $( "#answered_text" ).val();
      Cookies.set('answered_text',answered_text,{ expires: 1 });

      var minute_second = convert_to_minute_second(remainingTime);

      $('.time').text(minute_second);

    }




    if(remainingTime <= 0) {
      stopinterval(); // stop the interval

    }


  }, 20);



}




</script>
