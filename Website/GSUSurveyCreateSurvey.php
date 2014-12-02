<?php
include_once 'includes/db-connect.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>GSU Create Survey</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="GSUSurvey.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

		<script>

			var questionArray = new Array();
			var questionIndex = 0;

			var questionNum = 0; // add to the array at the end right before submittion
			function addQuestion(){
				questionNum++;
				var lineBreak = document.createElement("br");
				var div = document.createElement("div");
				div.id = "question"+ questionNum;
				div.className = "question";
				var question = prompt("What is your question?");

				questionArray[questionIndex] = question; // add the question to the question array
				questionIndex++;


				var text = document.createElement("input");
				text.type = "input";
				text.value = question;
				text.text = question;
				text.readOnly = true;
				text.size = "120";
				div.appendChild(text);


				div.appendChild(lineBreak);
				var lineBreak = document.createElement("br");
				div.appendChild(lineBreak);

				var numOfResponses = prompt("How many responses do you have?");

				questionArray[questionIndex] = numOfResponses; // add the number of responses for the question
				questionIndex++;
				

				for(var x = 0; x < numOfResponses; x++){
					var y = x; // ?
					y++;
					var response = prompt("Response # " + y + ":");

					questionArray[questionIndex] = response; // add the responses
					questionIndex++;
					
					var radio = document.createElement("input");
					radio.type = "radio";
					radio.value = response;
					radio.name = "question " + questionNum + "response";
					radio.id = "question " + questionNum + "response";
					 
					var label = document.createElement("Label");
					label.setAttribute("for", "question " + questionNum + "response");
					label.innerHTML = radio.value;

					div.appendChild(radio);
					div.appendChild(label);

					var lineBreak = document.createElement("br");
					div.appendChild(lineBreak);
					var lineBreak = document.createElement("br");
					div.appendChild(lineBreak);

				}

				document.getElementById('content').appendChild(div);
			}

			function submitQuestions(){
				questionArray[questionIndex] = String(questionNum); // we add the number of questions to the very end of the array right before submitting
				questionIndex++;
			}

			$(document).ready(function(){ 
		  		$('#btn').click(function(){ // prepare button inserts the JSON string in the hidden element 
		    		$('#str').val(JSON.stringify(questionArray)); 
		  		}); 
			});
		</script>

	</head>

	<body onload = "addQuestion()">
		<div id = "wrapper">
			<h1>GSU Survey</h1>
			<div id="nav">
			<ul>
			</ul>
			</div>
			<div id ="content">
				
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
					<span id = "buttons">
						<input type = "button" value="Create New Question" onclick="addQuestion()">
						<input type="hidden" id="str" name="str" value="" /> 
						<input type="submit" id="btn" name="submit" value="Finish Survey" onclick="submitQuestions()"/>
 					</form>

					<?php
                    
                    if(isset($_POST['submit'])){
                    	// For Testing
                    	$form = 1;
                    	$type = 3;
                    	//--------------------------
						$str = json_decode($_POST['str'], true);
						$numberOfQuestions = intval($str[count($str)-1]); // convert to int
						$questionNum = 0;
						$index = 0;
						//var_dump($str);

						// str holds all values

						while($questionNum < $numberOfQuestions){
							$question = $str[$index];
							$index++;
							$numOfAnswers = intval($str[$index]); // convert to int
							$index++;

							// enter question in db
							$insert_stmt = $mysqli->prepare("INSERT INTO question_tbl (question_type, question_form, question_ask) VALUES (?, ?, ?)");
                            $insert_stmt->bind_param('iis', $type, $form, $question);
                            // Execute the prepared query.
                            $insert_stmt->execute();


							// retreive question id

							$stmt_count = $mysqli->prepare("SELECT question_id FROM question_tbl WHERE question_ask = ? LIMIT 1");
                            $stmt_count->bind_param('s',$question);
                            $stmt_count->execute();    
                            $stmt_count->store_result();
                            // get variables from result.
                            $stmt_count->bind_result($question_id);
                            $stmt_count->fetch();

                            if ($stmt_count->num_rows == 1) {

							// loop through answers and enter in db
                            	for($i=0;$i<$numOfAnswers;$i++){
                            		$choice = $str[$index];
                            		$index++;

                            		$insert_stmt = $mysqli->prepare("INSERT INTO choices_tbl (choiceQuestion_id, choice) VALUES (?, ?)");
                            		$insert_stmt->bind_param('is', $question_id, $choice);
                            		// Execute the prepared query.
                            		$insert_stmt->execute();
                            	}
                            	
                            }


							// increment to next question
							$index+=$numOfAnswers;
							$questionNum++;
						}
						echo'<script>window.location.href = "GSUSurveyViewSurvey.php";</script>';
					}
						
  					
                    ?>
				</span>
				<br><br> 

			</div>
		</div>
	</body> 
</html>
