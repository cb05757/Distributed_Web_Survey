<?php
include_once 'includes/db-connect.php';	// mysqlinects to the DB. DB variable ->>> $mysqli
$q = intval($_GET['q']);		// Gets 'q' variable passed,'q' is the ID 'question_form' sent when the user selects a question. Gets the Survey chosen
// Get all questions from the form
$sql="SELECT * FROM question_tbl WHERE question_form=".$q." ";		// Get all of the questions from the selected form 

$sql = $mysqli->real_escape_string($sql);	// Helps prevent SQL inject by ignoring string literals
$result = $mysqli->query($sql); 

if(! $result){
	echo "error getting answers data";
}

$row_count = $result->num_rows;		// Gets the number of rows/objects/ Questions for this survey

echo " <h3> Your survey has $row_count questions. </h3>";

echo '<p>Here is a link to your survey <a href="http://localhost/GSUSurveyViewSurvey.php?survey='.$q.'">http://localhost/GSUSurveyViewSurvey.php?survey='.$q.'</a>';

echo "<h3> Here are your questions: </h3> <br/>";

// Gets the questions for this survey

while($row =mysqli_fetch_array($result)){
	
	$question = $row['question_ask'];
	$qID = $row['question_id'];
	
	echo "<h4><b> $question <b></h4> ";
	
	// Get all answers for the question 
	$query="SELECT * FROM answer_tbl WHERE answer_question=".$qID." ";		// Get all of the answers for this question
	

	$query = $mysqli->real_escape_string($query);	// Helps prevent SQL inject by ignoring string literals
	$answerResult = $mysqli->query($query); 
	
	
	if(! $answerResult){
		echo "error getting answers data";
	}
	
	
	// Get the number of choices a user had to choose from
	$choiceQuery = "SELECT * from choices_tbl WHERE choiceQuestion_id=".$qID."";
	$choiceQuery = $mysqli->real_escape_string($choiceQuery);
	$choiceResult = $mysqli->query($choiceQuery);
	
	$choice_count = $choiceResult->num_rows; 
	
	$array = array_fill(0,$choice_count,null);		// array array_fill ( int $start_index , int $num , mixed $value ) --> Fills an array with num entries of the value of the value parameter, keys starting at the start_index parameter.
	
	$arrlength = count($array);		// get array length
	
	$x = 0;
	while($choice = mysqli_fetch_array($choiceResult)){
		// put every choice into an array
			$array[$x] = $choice['choice'];
			$x++;
		}
		
	
	// Getting count for each answer 
	
	// This Seeks back to the first Row so we can go through the object again.
	mysqli_data_seek($answerResult,0);
	
	$answerCounter = array_fill(0,$choice_count,0);		// creates an array with '$choice_count' number of elements, all initialized to zero
	

	while($answer = mysqli_fetch_array($answerResult)){
		
			
		for($x = 0; $x < $arrlength; $x++) {
    		if($array[$x] == $answer['answer_value'] ){
			$answerCounter[$x]++;		// increment the counter for the x'th index in the array. Each index in $answerCounter array corresponds to it's answer in $array
			$x++;
    		}
		}
	
		
	}

	$answer_count = $answerResult->num_rows;
	
	
		echo " <table> 
		<tr>
		<th> Answers </th>
		<th> Times Answered </th>
		<th> % </th> </tr> ";
		
		
		// output answers and answer count
		for($x = 0; $x < $arrlength; $x++){
			echo "<tr>";
			echo "<td>" .$array[$x]. "</td>";		// outputs the answer answered
			echo "<td>" .$answerCounter[$x]. "</td>";	//outputs the number of times it was answered
			
			$percentage = ($answerCounter[$x] / $answer_count) * 100;
			
			echo "<td>" .$percentage. "</td>";		// outputs the percentage this answer was given
			echo "</tr>";
		
		}
		
	
	echo "</table>";



	
	echo "<br/> ---------------------------------------------------------------";
}

?> 