<?php

include_once 'includes/db-connect.php';
include_once 'includes/functions.php';

sec_session_start();


?>
<!DOCTYPE html>
<html>
    <head>
        <title>GSU Survey: Log In</title>
        <link rel="stylesheet" href="GSUSurveyView.css">
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
        <div id = "wrapper">
                <h1>GSU Survey</h1>
                

        <div id ="content">
        <h2>Welcome to GSU Survey Creator</h2>
        <form class="login" action="includes/process_login.php" method="post" name="login_form"> 	
            <fieldset>
                <legend>Login</legend>		
                <label>Email: </label><input type="text" name="email" /><br>
                <label>Password: </label><input type="password" 
                                 name="password" 
                                 id="password"/><br>
                <input type="button" 
                       value="Submit" 
                       onclick="formhash(this.form, this.form.password);" /> 
            </fieldset>
        </form>
        <p>If you don't have a login, please <a href="register.php">register</a></p>
        <p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
        </div>
    </div>
    </body>
</html>
