<?php

/**
 * Class registration
 * handles the user registration
 */

class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();


    /* added by tyler: 
     * form input specific error messages
     * global because they are defined outside of Registration object, object just modifies them
     */
    public $f_nameErr;
    public $l_nameErr;
    public $emailErr;
    public $passwordErr;
    public $passwordRptErr;

    public $regSuccess; //if TRUE, registration went through

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        //check for errors in registration form
        $formCheck = 1; //1 == form is good, 0 == form is bad
        $this->regSuccess = FALSE;
        
        if (empty($_POST['user_password_new'])) {
            //$this->errors[] = "Empty Password";
            $this->passwordErr = "Password is required";
            $formCheck = 0;
        } elseif (!preg_match("/^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{8,}$/", $_POST['user_password_new'])) {
            $this->passwordErr = "Password must have a minimum of 8 characters with 2 numbers, and at least one of the following characters: ! @ # $ % *"; 
            $formCheck = 0;
        } elseif (empty($_POST['user_password_repeat'])) {
            $this->passwordRptErr = "You need to repeat your password";
            $formCheck = 0;
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->passwordRptErr = "Your passwords do not match";
            $formCheck = 0;
        }

        if (empty($_POST['user_email'])) {
            //$this->errors[] = "Email cannot be empty";
            $this->emailErr = "E-mail is required";
            $formCheck = 0;
        } elseif (strlen($_POST['user_email']) > 64) {
            //this->errors[] = "Email cannot be longer than 64 characters";
            $this->emailErr = "E-mail must be less than 64 characters";
            $formCheck = 0;
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            //$this->errors[] = "Your email address is not in a valid email format";
            $this->emailErr = "Invalid e-mail format";
            $formCheck = 0;
        }

        if (empty($_POST['f_name'])) {
            $this->f_nameErr = "First name cannot be empty";
            $formCheck = 0;
        } elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST['f_name'])) {
            $this->f_nameErr = "Only letters and whitespace allowed in your first name";
            $formCheck = 0;
        } elseif (strlen($_POST['f_name']) > 64) {
            $this->f_nameErr = "First name cannot be longer than 64 characters";
            $formCheck = 0;
        }

        if (empty($_POST['l_name'])) {
            $this->l_nameErr = "<br>Last name cannot be empty";
            $formCheck = 0;
        } elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST['l_name'])) {
            $this->lnameErr = "<br>Only letters and whitespace allowed allowed in your last name";
            $formCheck = 0;
        } elseif (strlen($_POST['l_name']) > 64) {
            $this->l_nameErr = "<br>Last name cannot be longer than 64 characters";
            $formCheck = 0;
        }

        //if everything passes the test...

        if ($formCheck == 1
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['f_name'])
            && strlen($_POST['f_name']) <= 64
            && !empty($_POST['l_name'])
            && strlen($_POST['l_name']) <= 64
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
                $f_name = $this->db_connection->real_escape_string(strip_tags($_POST['f_name'], ENT_QUOTES));
                $l_name = $this->db_connection->real_escape_string(strip_tags($_POST['l_name'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_email = '" . $user_email . "';";
                $query_check_user_email = $this->db_connection->query($sql);

                if ($query_check_user_email->num_rows == 1) {
                    $this->errors[] = "Sorry, that e-mail address is already registered.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_email, user_password_hash, f_name, l_name)
                            VALUES('" . $user_email . "', '" . $user_password_hash . "', '" . $f_name . "','" . $l_name . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = 'Your account has been created successfully! <a href="login.php">Log in here.</a>';
                        $this->regSuccess = TRUE;
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, the database connection failed.  Try again.";
            }
        }
    }

}
