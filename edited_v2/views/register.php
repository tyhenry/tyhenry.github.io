 <?php

    // define variables and set to empty values
    $f_nameErr = $l_nameErr = $emailErr = $passwordErr = $passwordRptErr = "";

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        //set default values for form inputs
        $f_name = "";
        $l_name = "";
        $email = "";
    } else {

        //grab posted values for form inputs
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['user_email'];
    }
?>

<!DOCTYPE html><html>

    <head>
        <title>sign up for edited.io</title>

        <meta charset="UTF-8">
        <meta type="description" content="sign up for edited.io, a social platform for writers and editors">
        <link rel="stylesheet" href="style/main.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>

    <body>

        <div class="cover-bg-maya"></div>

        <section id="header" class="bg-maya">

                <a href="index.html">
                    <div id="logo"></div>
                </a>

                <nav id="nav-right">
                    <ul>
                        <li><a href="login.php">login</a></li>
                        <li><a href="index.html#about-edited">about</a></li>
                    </ul>
                </nav>

            </div>

        </section>

        <section id="splash">

            <div id="splash-content">

                <div id="tagline">
                    <h2>Everyone needs an editor. Find yours.</h2>
                </div>

                <div class="form-container">
                    <?php
                        // show potential errors / feedback (from registration object)
                        if (isset($registration)) {
                            if ($registration->errors) {
                                foreach ($registration->errors as $error) {
                                    echo $error;
                                }
                            }
                            if ($registration->messages) {
                                foreach ($registration->messages as $message) {
                                    echo $message;
                                }
                            }
                        }
                    ?>

                    <form id="signup-form" method="post" action="signup.php" name="registerform">

                        <input type="text" name="f_name" placeholder="first name*" value="<?php echo $f_name;?>">
                        <input type="text" name="l_name" placeholder="last name*" value="<?php echo $l_name;?>">
                        <span class="error"><?php echo $registration->f_nameErr;?></span>
                        <span class="error"><?php echo $registration->l_nameErr;?></span>

                        <input type="email" name="user_email" placeholder="your@email.com*" value="<?php echo $email;?>" required>
                        <span class="error"><?php echo $registration->emailErr;?></span>

                        <input type="password" id="login_input_password_new" name="user_password_new" placeholder="password*" required autocomplete="off">
                        <span class="error"><?php echo $registration->passwordErr;?></span>
                        <input type="password" id="login_input_password_repeat" name="user_password_repeat" placeholder="repeat password*" required autocomplete="off">
                        <span class="error"><?php echo $registration->passwordRptErr;?></span>
                        
                        <input type="submit" name="register" value="sign up" class="btn" id="signup-button">
                        <!--redirect value-->
                        <input type="hidden" name="redirect_to" value ="writer.html">

                    </form>
                </div>
                
            </div>

        </section>


        <footer>
            <h3>Connecting independent writers and freelance editors</h3>
        </footer>


    </body>

</html>
