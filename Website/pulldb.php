<?php

// Kyle Conoly
// Adrian Marshall
// Patrick Marino
// Robert Myrick
// Chris Beyer
include_once 'includes/db-connect.php';
$count = 0;

// question value $question_id.A;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pull a Survey</title>
        <style type="text/css">
            td{
                text-align: center;
            }
        </style>
        
    </head>
<body>
     
    <div id = "content">
        <table width="1000" border="0" cellspacing="1" cellpadding="0" align = "center">
            <form name="survey" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <?php
                    $stmt = $mysqli->prepare("SELECT question_id, question_type, question_form, question_ask, question_value1, question_value2  FROM question_tbl");
                    //$stmt->bind_param('i',$store_id);
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
                                <td><? echo $question; ?></td>
                            <?php

                                for($i=$count + 1;$i<=$count+5;$i++){
                                    $radioValue = $question_id.'.'.$value;
                            ?>
                                    <td><input name = "<? echo $count; ?>" type="radio" id="<? echo $id; ?>" value = "<? echo $radioValue; ?>"></td>
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
                            <td></td><td><? echo $q1; ?></td><td><? echo $q2; ?></td><td></td><td></td><td></td>
                            </tr>
                            <tr>
                                <td><? echo $question; ?></td>
                            <?php

                                for($i=$count + 1;$i<=$count+2;$i++){
                                    $radioValue = $question_id.'.'.$value;
                                ?>
                                    <td><input name = "<? echo $count; ?>" type="radio" id="<? echo $id; ?>" value = "<? echo $radioValue; ?>"></td>
                            <?php
                                    $value++;
                                    $id++;
                                }
                            ?>
                            </tr>
                            <?php
                            $count++;
                            
                        } else if($type == 3){ // Not Used Right now
                            
                        }

                        
                    }
                    ?>

                    
                    <tr><td colspan="6" align="center"><input name = "submit" type = "submit" id = "submit" value = "Submit"></td></tr> <!-- rowspan = 6 -->
            </form>
        </table>

                    <?php

                    if(isset($_POST['submit'])) {
                        for($i = 0; $i <= $count; $i++){
                            $update_id = $_POST[(string)$i];

                            //get the question id
                            //$question_id = substr($update_id, 0, strrchr($update_id, ".")-1);

                            $question_id = substr($update_id, 0, strpos($update_id, '.'));

                            // get the value of the answer
                            //$value = 2;//substr($update_id, strrchr($update_id, "."));
                            $value = substr($update_id, strpos($update_id, '.')+1);

                            $form = 1;

                            
                            // get the form
                            
                            $insert_stmt = $mysqli->prepare("INSERT INTO answer_tbl (answer_question, answer_value, answer_form) VALUES (?, ?, ?)");
                            $insert_stmt->bind_param('sii', $question_id, $value, $form);

                            // Execute the prepared query.
                            $insert_stmt->execute();
 

                        }
                        //echo '<script type="text/javascript"> window.location = "pulldb.php";</script>';
                        echo $question_id;
                    }
                    
                    ?>

                    
            
            <?php echo $msg; ?>
        
    </body>
</html>
