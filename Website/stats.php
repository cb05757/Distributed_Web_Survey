<?php
// @Authors: 
// Kyle Conoly
// Adrian Marshall
// Patrick Marino
// Robert Myrick
// Chris Beyer
include_once 'includes/db-connect.php';		// Connects to our database so we can use #mysqli
	// Query the Database for the data on the questions
	$result = $mysqli->query("SELECT * FROM question_tbl");
	// Create an array of objects for each returned row
	$array = array();
	if ($result) {
            
              while($array[] = $result->fetch_object());
              // Remove empty row in array 
              array_pop($array);
         }
         
        else {
            echo "Error with SQL";
        }
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title> Get the Statistics on your survey!  </title>
		<meta http-equiv="content-type" content="text/html" charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="GSUSurveyView.css" />

			<script>
		function showAnswers(str){
			if(str==""){
				document.getElementById("txtHint").innerHTML="";
				return;
			}
			if(window.XMLHttpRequest){
				// code for IE7+, Firefox, Chrome, Opera,Safari
				xmlhttp = new XMLHttpRequest();
			} else{ // code for IE6, IE5
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open("GET","getanswers.php?q="+str,true);		// Sends the question_id to the getanswers.php file
			xmlhttp.send();
		}
		</script>
	
</head>

<body>
	<div id = "wrapper">
	<h1> Here are the Stats! </h1>

	</div>

	<div id="content">

	<p id="paragraph">  Here we you can get some basic statistics on your survery. For instance, you can find out 
	 What percentage of people selected a certain answer and how many people have taken your survey. </p>

	 <p> <b> Please select from the drop down menu to get started: </b> </p>

	 <form>
	 <select name="questions" onchange="showAnswers(this.value)">
	 <option value=""> Select a question </option>

		<?php foreach ($array as $option) : ?> 
			<option value="<?php echo $option->question_id; ?>" > <?php echo $option->question_ask; ?> </option>
		<?php endforeach ?>

	 </select>

	 <div id="txtHint"><b>Statistics will be listed here.</b></div>

	</div>


	</form>

	<?php 
		// Free result set and close connection
		$result->close();
		$mysqli->close();
	?>

</body>



</html>