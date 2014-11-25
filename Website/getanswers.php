<?php

include_once 'includes/db-connect.php';	// mysqlinects to the DB. DB variable ->>> $mysqli



$q = intval($_GET['q']);		// Gets 'q' variable passed,'q' is the ID 'question_id' sent when the user selects a question

// Get all answers for the question 
$sql="SELECT * FROM answer_tbl WHERE answer_question =".$q." ";
echo "{$sql}";
$sql = $mysqli->real_escape_string($sql);
$result = $mysqli->query($sql);

if(! $result){
	echo "error getting answers data";
}
echo "
<h3> The Stats </h3>
<table border='1'>
<tr>
<th># of times this question was answered</th>
<th>The Answers</th>
</tr>";

$row_count = $result->num_rows;

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row_count. "</td>";
  echo "<td>" . $row['answer_value'] . "</td>";
  echo "</tr>";
}
echo "</table>";

mysqli_close($mysqli);

?> 