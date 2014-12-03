<?php
// Kyle Conoly
// Adrian Marshall
// Patrick Marino
// Robert Myrick
// Chris Beyer
include_once 'includes/db-connect.php';
$count = 0;
// question value $question_id.A;

$question_form = filter_input(INPUT_GET, 'survey', $filter = FILTER_SANITIZE_STRING); // retrieve the question form
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>GSU Survey View</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="GSUSurveyView.css">
        <style>
            td, th{
                min-width: 300px;
            }

        </style>
    </head>

    <body>

        <div id = "wrapper">
            <h1>GSU Survey</h1>
            
            <div id ="content">

                <h2>GSU Survey View</h2>
<table id="survey" border="0" cellspacing="4" cellpadding="4" align = "center">
            <form name="survey" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <?php
                    $stmt = $mysqli->prepare("SELECT question_id, question_type, question_form, question_ask, question_value1, question_value2  FROM question_tbl WHERE question_form = ?");
                    $stmt->bind_param('i',$question_form);
                    $stmt->execute();    // Execute the prepared query.
                    $stmt->store_result();
                    // get variables from result.
                    $stmt->bind_result($question_id, $type, $form, $question, $q1, $q2);
                    $id = 0;
                    while($stmt->fetch()){
                        $value = 1;
                        if($type == 1){ // question type 1,2,3,4,5
                            ?>
                            <tr>
                                <td></td><td>Strongly Disagree</td><td>Disagree</td><td>Neutral</td><td>Agree</td><td>Strongly Agree</td>
                            </tr>
                            <tr>
                                <td><?php echo $question; ?></td>
                            <?php
                                for($i=$count + 1;$i<=$count+5;$i++){
                                    $radioValue = $question_id.'.'.$value;
                            ?>
                                    <td><input name = "<?php echo $count; ?>" type="radio" id="<?php echo $id; ?>" value = "<?php echo $radioValue; ?>"></td>
                            <?php
                                    $value++;
                                    $id++;
                                }
                            ?>
                            </tr>
                            <?php
                            $count++;
                            
                            
                        } else if($type == 2){ // option 1 or 2
                            ?>
                            <tr>
                            <td></td><td><?php echo $q1; ?></td><td><?php echo $q2; ?></td><td></td><td></td><td></td>
                            </tr>
                            <tr>
                                <td><?php echo $question; ?></td>
                            <?php
                                for($i=$count + 1;$i<=$count+2;$i++){
                                    $radioValue = $question_id.'.'.$value;
                                ?>
                                    <td><input name = "<?php echo $count; ?>" type="radio" id="<?php echo $id; ?>" value = "<?php echo $radioValue; ?>"></td>
                            <?php
                                    $value++;
                                    $id++;
                                }
                            ?>
                            </tr>
                            <?php
                            $count++;
                            
                        } else if($type == 3){ // make in to the unlimited answers type
                            // print the question 
                            // run another querry to determine how many choices that answer has
                            // loop through and print all the choices 
                            ?>
                            <tr>
                                <td><?php echo $question; ?></td>
                            </tr>
                            <?php
                            // finds out how many choices exist for the current question
                            $stmt_count = $mysqli->prepare("SELECT COUNT(*) FROM choices_tbl WHERE choiceQuestion_id = ?");
                            $stmt_count->bind_param('i',$question_id);
                            $stmt_count->execute();    
                            $stmt_count->store_result();
                            // get variables from result.
                            $stmt_count->bind_result($choice_count);
                            $stmt_count->fetch();
                            //-----------------------------------------
                            // loads the choices values and choice_id
                            $stmt_load = $mysqli->prepare("SELECT choice_id, choice FROM choices_tbl WHERE choiceQuestion_id = ? ORDER BY RAND()");
                            $stmt_load->bind_param('i',$question_id);
                            $stmt_load->execute();    
                            $stmt_load->store_result();
                            // get variables from result.
                            $stmt_load->bind_result($choice_id, $value); // dont need choice id -- remove later
                            ?>
                            
                           <tr><td><span class="choice">
                            <?php
                            while($stmt_load->fetch()){ // render the various choices
                                //for($i=$count + 1;$i<=$count+$choice_count;$i++){ // might need to change way of value
                                    $radioValue = $question_id.'.'.$value;
                                ?>
                                    <input name = "<?php echo $count; ?>" type="radio" id="<?php echo $id; ?>" value = "<?php echo $radioValue; ?>">
                                    <label for="<?php echo $id; ?>"><?php echo $value; ?></label><br>
                                <?php
                                    //$value++;
                                    $id++;
                                //}
                                
                                //---------------------------------------------
                            }
                            $count++;
                            ?>
                            </span></td></tr>
                            <?php
                        }
                        
                    }
                    //echo $count;
                    ?>
                    
                    <tr><td colspan="6" align="center"><input name = "submit" type = "submit" id = "submit" value = "Submit"><input type="hidden" id="str" name="str" value="<?php echo $count; ?>" /> </td></tr>

            </form>
        </table>

                    <?php
                    if(isset($_POST['submit'])) {
                        $count = $_POST['str'];
                        for($i = 0; $i <= $count; $i++){ // change to < and remove count++ from the end of all for loops
                            $update_id = $_POST[(string)$i];
                            //get the question id
                            //$question_id = substr($update_id, 0, strrchr($update_id, ".")-1);
                            $question_id = substr($update_id, 0, strpos($update_id, '.'));
                            // get the value of the answer
                            //$value = 2;//substr($update_id, strrchr($update_id, "."));
                            $value = substr($update_id, strpos($update_id, '.')+1);


                            $stmt_form = $mysqli->prepare("SELECT question_form FROM question_tbl WHERE question_id=?");
                            $stmt_form->bind_param('i',$question_id);
                            $stmt_form->execute();    
                            $stmt_form->store_result();
                            // get variables from result.
                            $stmt_form->bind_result($form);
                            $stmt_form->fetch();


                            //$form = $question_form; // change to be dynamic later
                            
                            // get the form
                            //$form = 12;
                            $insert_stmt = $mysqli->prepare("INSERT INTO answer_tbl (answer_question, answer_value, answer_form) VALUES (?, ?, ?)");
                            $insert_stmt->bind_param('ssi', $question_id, $value, $form);
                            // Execute the prepared query.
                            $insert_stmt->execute();
 
                        }
                        //echo '<script type="text/javascript"> window.location = "pulldb.php";</script>';
                        echo "Thank you for taking the survey";
                        echo "<script>document.getElementById('submit').style.visibility='hidden';</script>";
                    }
                    
                    ?>



                <div id="footer" >

                </div>

            </div>

        </div>

    </body> 

</html>