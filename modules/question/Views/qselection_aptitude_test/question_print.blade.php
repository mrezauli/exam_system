<!DOCTYPE html >
<html ng-app lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    
img {
    -webkit-print-color-adjust: exact;
    width: 100%;
}

header{
    text-align: center;
}

.question-header{
    max-width: 1150px;
    margin: 0 auto;
}

h5{
    margin: 5px;
}


</style>
        
    </head>
    <body>
       

    <header>
        <h5>{{$company_name}}</h5>
        <h5><b>পদের নাম: </b>{{$designation_name}}</h5>
        <h5><b>Total Time: </b>{{$aptitude_exam_time}}</h5>
        <h5><b>Total Marks: </b>{{$total_question_marks}}</h5>
    </header>


@if(isset($question_array['word']))

@foreach ($question_array['word'] as $key => $value)

<?php 

$ddd = explode('_', $value);

$question = $ddd[0] . '_' . $ddd[1] . $ddd[3];

$question_title = $ddd[0] . '-' . $ddd[1];

$question_mark = $ddd[2];

?>


        <div class="question-header">
            <h5 style="float:left">{{$question_title}}</h5>
            <h5 style="float:right">{{$question_mark}}</h5>
        </div>

        <img src="{{URL::to('/') . '/temp_preview/' .$question}}" alt="No Question was Found.">

@endforeach

@endif



@if(isset($question_array['excel']))

@foreach ($question_array['excel'] as $key => $value)

<?php 

$ddd = explode('_', $value);

$question = $ddd[0] . '_' . $ddd[1] . $ddd[3];

$question_title = $ddd[0] . '-' . $ddd[1];

$question_mark = $ddd[2];

?>


        <div class="question-header">
            <h5 style="float:left">{{$question_title}}</h5>
            <h5 style="float:right">{{$question_mark}}</h5>
        </div>

        <img src="{{URL::to('/') . '/temp_preview/' .$question}}" alt="No Question was Found.">

@endforeach

@endif






@if(isset($question_array['ppt']))

@foreach ($question_array['ppt'] as $key => $value)

<?php 

$ddd = explode('_', $value);

$question = $ddd[0] . '_' . $ddd[1] . $ddd[3];

$question_title = $ddd[0] . '-' . $ddd[1];

$question_mark = $ddd[2];

?>


        <div class="question-header">
            <h5 style="float:left">{{$question_title}}</h5>
            <h5 style="float:right">{{$question_mark}}</h5>
        </div>

        <img src="{{URL::to('/') . '/temp_preview/' .$question}}" alt="No Question was Found.">

@endforeach

@endif


    </body>
</html>



