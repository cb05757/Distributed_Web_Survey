<?php

include_once 'includes/db-connect.php';	// mysqlinects to the DB. DB variable ->>> $mysqli



$q = intval($_GET['q']);		// Gets 'q' variable passed,'q' is the ID 'question_id' sent when the user selects a question

// Get all answers for the question 
$sql="SELECT * FROM answer_tbl WHERE answer_question =".$q." ";

$sql = $mysqli->real_escape_string($sql);	// Helps prevent SQL inject by ignoring string literals
$result = $mysqli->query($sql);

if(! $result){
	echo "error getting answers data";
}

$row_count = $result->num_rows;		// Gets the number of rows/objects/ answers for this question
$answer = "";

$stronglyAgree = 0;
$agree = 0;
$neither = 0;
$disagree = 0;
$stronglyDisagree = 0; 
// Find numbers on above variables
while($row = mysqli_fetch_array($result)) {
	$answer = "";
	if($row['answer_value'] == 1){
		$stronglyAgree++;
	}else if($row['answer_value'] == 2){
		$agree++;
	}else if($row['answer_value'] == 3){
		$neither++;
	} else if($row['answer_value'] == 4){
		$disagree++;
	} else if($row['answer_value'] == 5){
		$stronglyDisagree++;
	}
}
// Get percentages 
$stronglyAgreeP = ($stronglyAgree / $row_count ) * 100;
$agreeP = ($agree / $row_count ) * 100;

$neitherP = ($neither / $row_count ) * 100;
$disagreeP = ($disagree / $row_count ) * 100;
$stronglyDisagreeP = ($stronglyDisagree / $row_count ) * 100;


echo "
<h3> The Stats </h3>
<table border='1'>
<tr>
<th>Answers</th>
<th>Times Chosen </th>

</tr>";

// This Seeks back to the first Row so we can go through the object again.
mysqli_data_seek($result,0);
/*
while($row2 = mysqli_fetch_array($result)) {
	// Getting and setting the answer that the user gave
	$answer = "";
	$frequency = 0;

	if( $row2['answer_value'] == 1){
		$answer = "Strongly Agree";
		$frequency = $stronglyAgree;

	}else if($row2['answer_value'] == 2){
		$answer = "Agree";
		$frequency = $agree;

	}else if($row2['answer_value'] == 3){
		$answer = "Neither";
		$frequency = $neither;

	} else if($row2['answer_value'] == 4){
		$answer = "Disagree";
		$frequency = $disagree;

	} else if($row2['answer_value'] == 5){
		$answer = "Strongly Disagree";
		$frequency = $stronglyDisagree;
	}
	*/
  echo "<tr>";
  echo "<td>Strongly Agree</td>";		// outputs the different answers given
  echo "<td>" .$stronglyAgree. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";
  echo "<tr>";
  echo "<td> Agree</td>";		// outputs the different answers given
  echo "<td>" .$agree. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";
  echo "<tr>";
  echo "<td>Neither</td>";		// outputs the different answers given
  echo "<td>" .$neither. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";
  echo "<tr>";
  echo "<td>disagree</td>";		// outputs the different answers given
  echo "<td>" .$disagree. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";
  echo "<tr>";
  echo "<td>Strongly Disagree</td>";		// outputs the different answers given
  echo "<td>" .$stronglyDisagree. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";
//}
echo "</table>";

echo "<br> <br> <br>";
 // Here is the table that shows the percentages of what the answers were 

echo "<table border='1'>
<th> % Strongly Agrees </th>
<th> % Agrees </th>
<th> % Neither </th>
<th> % Disagree </th>
<th> % Strongly Disagrees <th>";

echo "<tr>";
echo "<td>" . $stronglyAgreeP . "</td>";
echo "<td>" . $agreeP . "</td>";
echo "<td>" . $neitherP . "</td>";
echo "<td>" . $disagreeP . "</td>";
echo "<td>" . $stronglyDisagreeP.  "</td>";
echo "</tr>";

echo "</table>";

mysqli_close($mysqli);

?> 