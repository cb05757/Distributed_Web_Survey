<?php

include_once 'includes/db-connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GSU Survey: Protected Page</title>
        <link rel="stylesheet" href="GSUSurveyView.css">
    </head>
    <body>
        <?php if (login_check($mysqli) == 1) : ?>
            <div id = "wrapper">
                <h1>GSU Survey</h1>
                <div id="nav">
                    <ul>
                    </ul>
                </div>

                <div id ="content">

                    <p>
                    <a href="GSUSurveyCreateSurvey.php">Create a Survey</a>
                    <br>
                    <a href="stats.php">View the Statistics</a>
                    <br>

                    Return to <a href="index.php">login page</a>
                    </p>
                </div>
            </div>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>
