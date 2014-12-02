<?php

include_once 'includes/db-connect.php';	// mysqlinects to the DB. DB variable ->>> $mysqli



$q = intval($_GET['q']);		// Gets 'q' variable passed,'q' is the ID 'question_id' sent when the user selects a question
$t = intval($_GET['t']);		// Gets 't' variable passed,'t' is the type of questioni selected. 'question_type' sent when the user selects a question

echo "Question type: $t " ;

//typeOne();

switch ($t) {
	case '1':
		typeOne($q,$mysqli);
		break;
	case '2':
		typeTwo($q,$t,$mysqli);
		break;
	
	default:
		echo "Error";
		break;
}

// The function to perform for questions of type one. 
function typeOne($q,$mysqli){



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
}// End of typeOne() 

// The function to perform for questions of type one. 
function typeTwo($q,$t,$mysqli){



// Get all answers for the question 
$sql="SELECT * FROM question_tbl WHERE question_type =".$t." AND question_id='" .$q."";

$sql = $mysqli->real_escape_string($sql);	// Helps prevent SQL inject by ignoring string literals
$result = $mysqli->query($sql);

echo "in type2";

if(! $result){
	echo "error getting answers data";
}

$row_count = $result->num_rows;		// Gets the number of rows/objects/ answers for this question

// Creating table for type 2
echo "
<h3> The Stats </h3>
<table border='1' align='right'>
<tr>
<th>Answers</th>

</tr>";

// Find numbers on above variables
while($row = mysqli_fetch_array($result)) {
	$answer = "";
	$qValue1 = "";
	$qValue2 = "";

	$qValue1 = $row['question_value1'];
	$qValue2 = $row['question_value2'];

	// Creating table 
  echo "<tr>";
  echo "<td>"."</td>";		// outputs the different answers given
  echo "<td>" .$stronglyAgree. "</td>";		// Outputs the number of times this answer was given	
  echo "</tr>";

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
}// End of typeOne() 

?> 