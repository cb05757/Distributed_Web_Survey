<?php

include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>GSU Survey: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="GSUSurveyView.css">
    </head>
    <body>
        <div id="wrapper">
            <!-- Registration form to be output if the POST variables are not
            set or if the registration script caused an error. -->
            <h1>GSU Survey</h1>
            <div id="content">
                <h2>Register with GSU Survey</h2>
                <?php
                if (!empty($error_msg)) {
                    echo $error_msg;
                }
                ?>
                <ul>
                    <li>Emails must have a valid email format</li>
                    <li>Passwords must be at least 6 characters long</li>
                    <li>Passwords must contain
                        <ul>
                            <li>At least one upper case letter (A..Z)</li>
                            <li>At least one lower case letter (a..z)</li>
                            <li>At least one number (0..9)</li>
                        </ul>
                    </li>
                    <li>Your password and confirmation must match exactly</li>
                </ul>
                <form class="login" method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
                    <fieldset>
                        <legend>Register</legend>
                        <label>Email: </label><input type="text" name="email" id="email" /><br>
                        <label>Password: </label><input type="password"
                                         name="password" 
                                         id="password"/><br>
                        <label>Confirm password: </label><input type="password" 
                                                 name="confirmpwd" 
                                                 id="confirmpwd" /><br>
                        <input type="button" 
                               value="Register" 
                               onclick="return regformhash(this.form,
                                               this.form.email,
                                               this.form.password,
                                               this.form.confirmpwd);" /> 
                    </fieldset>
                </form>
                <p>Return to the <a href="index.php">login page</a>.</p>
            </div>
        </div>
    </body>
</html>
