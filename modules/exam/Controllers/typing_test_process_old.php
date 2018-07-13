<style>.mr3{margin-right: 3px;}</style>



<?php   


function find($question,$answer,$original_answer,$question_index,$i){

	// $value = 0;

	// 	if (isset($original_answer[$i-2]) && substr($original_answer[$i-2],1,4)=='span'){

	// 	$length = 10;

	// }else{

	// 	$length = 4;

	// }


	if(isset($question[$question_index - 2])) {

		$j=$question_index - 2;

	}elseif(isset($question[$question_index - 1])){

		$j=$question_index - 1;

	}else{

		$j = 0;

	}
	

	for ($j; $j <= $question_index + 2; $j++) { 

		
		$c = new Collator('bn_BD');

		if ( $c->compare($question[$j] ,$answer[0]) == 0) {

			return $value = $j;

		}
		
		$value =  null;

	}
	
		return $value;
	
	}



	function myfunction($num)
	{

	// $ignore = [',','.',';','|'];
	$ignore = [];

		if (! in_array($num, $ignore)) {

			return $num;
		}

	}


	function markup_map($num){

		if (substr($num, 1,4) == 'span') {

			return $num;
		}
	}

	function find_html_markup($content)
	{


		$html_markup = array_map("markup_map",$content);

		foreach ($html_markup as $key => $value) {
			if (empty($value) || $value==null) {

				unset($html_markup[$key]);

			}
		}

		return $html_markup;


	}


	function find_line_index($question,$answer,$question_length,$answer_length,$match){

		$question_key = 0;
		$line_index_key = null; 
		$question_sentence = [];
		$answer_sentence = [];
		

		$answer_length = $answer_length > count($answer) ? count($answer) : $answer_length;



		for ($i=0; $i <=$answer_length-1 ; $i++) { 
			$answer_sentence[] = $answer[$i];
		}



		foreach ($question as $key => $word) {

			$question_sentence = [];
	
			if ($word == $answer[0]) {


				for ($i=0; $i <=$question_length-1 ; $i++) { 
					$question_sentence[] = isset($question[$key + $i]) ? $question[$key + $i] : '';
					
				}


				$result=array_intersect($question_sentence,$answer_sentence);


				if (count($result) >= $match) {

					 $line_index_key = $key;

					 // return $key;
						break;
					
				}


			}

			

		}
	
		
		return $line_index_key;

	}



 



function answer_errors($process_answer,$process_index,$t,$d,$i){


// if (($i+$process_index-$d) == -1) {
	

// 	var_dump($i);
// 	var_dump($d);
// 	var_dump($process_index);
// 	exit('uuu');


// }

 
 
if(isset($process_answer[$i+$process_index-$d]) && substr($process_answer[$i+$process_index-$d], 1,4) == 'span'){

	$t++;

	$d++;
	return answer_errors($process_answer,$process_index,$t,$d,$i);
}

return $t;

}




function difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count){


if ($i != $count) {
	
	
	$i++;

	$c = new Collator('bn_BD');


	$index = find($question,$answer,$original_answer,$question_index,$i);


	if (isset($question[0]) && $c->compare($answer[0],$question[0])==0) {
	
		$question_index = 0;

		unset($question[0]);
		$question = array_values($question);

		unset($answer[0]);
		$answer = array_values($answer);


		return difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count);

	}elseif($index == null) {


		$index = find_line_index($question,$answer,5,5,2);


		if ($index != null) {

			$ddd = count($original_question) - count($question);


			for ($k=$index; $k > 0 ; $k--) { 

				unset($question[$k-1]);

				$original_question[$ddd+$k-1] = '<span class="yellowgreen" style="background:yellowgreen;">' . $original_question[$ddd+$k-1] . '</span>';

			}


			$question_index = 0;

			unset($question[$index]);
			$question = array_values($question);

			unset($answer[0]);
			$answer = array_values($answer);


			return difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count);

		}



		
        $original_answer[$i-1] = '<span class="orangered" style="background:orangered;">' . $original_answer[$i-1] . '</span>';

        if ($process_index > 0) {

        	$process_answer[$i+$process_index-1] = '<span class="orangered" style="background:orangered;">' . $process_answer[$i+$process_index-1] . '</span>';

        }else{

        	$process_answer[$i-1] = '<span class="orangered" style="background:orangered;">' . $process_answer[$i-1] . '</span>';

        }

       $question_index++;

		unset($answer[0]);
		$answer = array_values($answer);
	

		return difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count);
        

	}elseif ($index != null) {

		$t = 0;
		$d = 2;

		$answer_errors = answer_errors($process_answer,$process_index,$t,$d,$i);
		
		if ($answer_errors > $index) {
			
			
			array_splice( $process_answer, $i+$process_index-1, 0, '</span>' ); 

			array_splice( $process_answer, $i+$process_index-$answer_errors-1, 0, '<span class="mr3" class="orangered" style="background:orangered;">' . '' ); 
		
			$process_index += 2;



if ($index>0) {

	for ($g=0; $g < ($index - 1); $g++) { 
		array_splice( $process_answer, $i+$process_index-1, 0, '<span class="orangered" style="background:orangered;">null</span>' ); 
	}

	$process_index += $index - 1;

}

			
		}elseif ($answer_errors < $index) {
			


			
			for ($g=0; $g < ($index - $answer_errors); $g++) { 
				array_splice( $process_answer, $i+$process_index-1, 0, '<span class="orangered" style="background:orangered;">null</span>' ); 
			}

			$process_index += $index - $answer_errors;
		
		}



		$ddd = count($original_question) - count($question);


		for ($k=$index; $k > 0 ; $k--) { 

			unset($question[$k-1]);

	        $original_question[$ddd+$k-1] = '<span class="yellowgreen" style="background:yellowgreen;">' . $original_question[$ddd+$k-1] . '</span>';

		}
				
		unset($question[$index]);
		$question = array_values($question);

		unset($answer[0]);
		$answer = array_values($answer);

		 

		return difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count);

        

	}


}
	
return [$original_question,$original_answer,$process_answer];


}


// $original_question = implode($ddd[0],' ');

// echo 'Marked Question:';
// echo '<br>';
// echo $original_question;

// echo '<br>';
// echo '<br>';
// echo '<br>';

// echo 'Marked Answer:';
// echo '<br>';

// $original_answer = implode($ddd[1],' ');
// echo $original_answer;

// echo '<br>';
// echo '<br>';
// echo '<br>';

// echo 'Process Answer:';
// echo '<br>';


// $process_answer = implode($ddd[2],' ');
// echo $process_answer;


function test_answer($question,$answer){


	// $question = str_replace('  ', '', $question);

	$question = trim(preg_replace('/\s+/', ' ', $question));

	$question = $original_question = array_map('trim', explode(' ', $question));



	// $answer = str_replace('  ', '', $answer);

	$answer = trim(preg_replace('/\s+/', ' ', $answer));
	
	$answer = $original_answer = $process_answer = array_map('trim', explode(' ', $answer));


	$original_answer = array_map("myfunction",$original_answer);



	$total_words = count($original_question);

	$typed_words = count($original_answer);

	$answer = $original_answer = $process_answer = array_filter($original_answer, function($value) { return $value !== ''; });


	foreach ($original_answer as $key => $value) {
		if (empty($value)) {

			unset($original_answer[$key]);

		}
	}

	$answer = $original_answer = $process_answer = array_values($original_answer);

	$i = 0;
	$process_index = 0;
	$question_index = 0;

	$count = count($answer);

	$test_answer =  difference($original_question,$original_answer,$process_answer,$question,$answer,$i,$process_index,$question_index,$count);


	$question_html_markup = find_html_markup($test_answer[0]);
	

	$question_html_markup = count($question_html_markup);

	$answer_html_markup = find_html_markup($test_answer[1]);


	$answer_html_markup = count($answer_html_markup);


	$answer_array_count = count($test_answer[1]);

	$abs = $question_html_markup - $answer_html_markup;


	for ($p=0; $p <= count($test_answer[0]) - ($answer_array_count + $abs) -1; $p++) { 
		

		$test_answer[0][$answer_array_count + $p + $abs] = '<span class="yellowgreen" style="background:yellowgreen;">' . $test_answer[0][$answer_array_count + $p+$abs] . '</span>';

		$test_answer[2][$answer_array_count + $p] = '<span class="orangered" style="background:orangered;">' . 'null' . '</span>';


	}

// dd($test_answer[0]);

$deleted_words = count(find_html_markup($test_answer[0]));

$inserted_words = count(find_html_markup($test_answer[1]));


$test_answer[3] = $total_words;

$test_answer[4] = $typed_words;

$test_answer[5] = $inserted_words;

$test_answer[6] = $deleted_words;



return $test_answer;

}

?>