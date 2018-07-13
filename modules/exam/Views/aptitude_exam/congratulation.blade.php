<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >


<style>

/*quick-edit*/
body{
    height: 100%;
}

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

   background: url(http://localhost/exam_system/public/assets/img/k1.jpg);
   /* background-color: white; */
   /*background-size: 100% 100%;*/
   background-position-x:50%;  

   margin-bottom: 30px;
}

.form-group.image .row{
/*background: #2681a3;
opacity: .97;*/
height:20%;
}

.page-title{
  color: #18193c;
  font-weight: 600;
  font-size: 30px;
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

.logout-button{
  font-size: 14px;
}

</style>
  
  {{-- {{$first_exam_type}} --}}
  
<div class="form-block">


  
  <div class="form-group image no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">


    
      <div class="col-sm-offset-2 col-sm-8 radios">

      
      </div>

    </div>
  </div>

  <h1 class="page-title text-center">Congratulations, Exam completed successfully.</h1>


<div class="text-center"> <a class="btn btn-danger mt20 logout-button btn-sm" href="{{route('candidate-logout')}}">Log Out</a></div>
 
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery.js') }}"></script>

 <script>
    
 //Disabled Back Button ::

 window.history.forward();
 function noBack() { window.history.forward(); }

 setTimeout(function() {

    window.location = "{{route('candidate-logout')}}";

}, 10000);


 </script>