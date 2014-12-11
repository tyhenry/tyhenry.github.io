<?php

/**
 * Class registration
 * handles the user registration
 */

class Upload
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
     
    public $f_nameErr;
    public $l_nameErr;
    public $emailErr;
    public $passwordErr;
    public $passwordRptErr;*/


    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["upload"])) {
            $this->uploadNewFile();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function uploadNewFile()
    {
        /*check for errors in registration form
        
        if (empty($_POST['user_password_new'])) {
            //$this->errors[] = "Empty Password";
            $this->passwordErr = "Password is required";

        } elseif (empty($_POST['user_password_repeat'])) {
            $this->passwordRptErr = "You need to repeat your password";

        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "The passwords provided do not match";
            $this->passwordRptErr = "Your passwords do not match";

        
        //} elseif (strlen($_POST['user_password_new']) < 6) {
        //    $this->errors[] = "Password has a minimum length of 6 characters";
        
            
        } elseif (!preg_match("/^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{8,}$/", $_POST['user_password_new'])) {
            $this->passwordErr = "Must have a minimum of 8 characters, 2 numbers, and the following characters: ! @ # $ % *"; 

        } elseif (empty($_POST['user_email'])) {
            //$this->errors[] = "Email cannot be empty";
            $this->emailErr = "E-mail is required";

        } elseif (strlen($_POST['user_email']) > 64) {
            //this->errors[] = "Email cannot be longer than 64 characters";
            $this->emailErr = "E-mail must be less than 64 characters";

        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            //$this->errors[] = "Your email address is not in a valid email format";
            $this->emailErr = "Invalid e-mail format";

        } elseif (empty($_POST['f_name'])) {
            $this->f_nameErr = "First name cannot be empty";

        } elseif (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
            $this->f_nameErr = "Only letters and whitespace allowed in your first name";

        } elseif (strlen($_POST['f_name']) > 64) {
            $this->f_nameErr = "First name cannot be longer than 64 characters";

        } elseif (empty($_POST['l_name'])) {
            $this->l_nameErr = "<br>Last name cannot be empty";

        } elseif (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
            $this->lnameErr = "<br>Only letters and whitespace allowed allowed in your last name";

        } elseif (strlen($_POST['l_name']) > 64) {
            $this->l_nameErr = "<br>Last name cannot be longer than 64 characters";

        }

        /*
        $formCheck = 1;

        //if form posted, check/get the input values

        if (empty($_POST["f-name"])) {
            $fnameErr = "First name is required";
            $formCheck = 0;
        } else {
            $first_name = test_input($_POST["f-name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
               $fnameErr = "Only letters and whitespace allowed in your first name"; 
               $formCheck = 0;
            }
        }

        if (empty($_POST["l-name"])) {
            $lnameErr = "<br>Last name is required";
            $formCheck = 0;
        } else {
            $last_name = test_input($_POST["l-name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
               $lnameErr = "<br>Only letters and whitespace allowed allowed in your last name";
               $formCheck = 0;
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $formCheck = 0;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format"; 
                $formCheck = 0;
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
            $formCheck = 0;
        } else {
            $password = test_input($_POST["password"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{8,}$/",$password)) {
                $passwordErr = "Must have a minimum of 8 characters, 2 numbers, and the following characters: ! @ # $ % *"; 
                $formCheck = 0;
            }
        }*/

        //if everything passes the test...

        /*elseif (!empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['f_name'])
            && strlen($_POST['f_name']) <= 64
            && !empty($_POST['l_name'])
            && strlen($_POST['l_name']) <= 64
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {*/
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $doc_name = $this->db_connection->real_escape_string(strip_tags($_POST['doc-name'], ENT_QUOTES));

                $deadline = $_POST['deadline'];
                $edit_type = $_POST['edit-type'];

                // These are variables for our redirect
                $redirect = $_POST['redirect_to'];
                $referred = $_SERVER['HTTP_REFERER'];
                $query = parse_url($referred, PHP_URL_QUERY);
                $referred = str_replace(array('?', $query), '', $referred);

                // check if doc_name already exists
                $sql = "SELECT * FROM documents WHERE doc_name = '" . $doc_name . "';";
                $query_check_doc_name = $this->db_connection->query($sql);

                if ($query_check_doc_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that document title already exists in your files. Try a different title if this is a new document.";
                } else {

                    //try to upload the file
                    $user_folder = $_SESSION['user_id']; //writer's user_id will be the folder in which to store their documents
                    $targetfolder = "uploads/" . $user_folder . "/" ;

                    if (!is_dir($targerfolder)) {
                        mkdir($targetfolder); //makes the user folder in the "uploads" directory if it doesn't exist
                    }

                    $targetfile = $targetfolder . basename( $_FILES['file']['name']) ;

                    $file_type=$_FILES['file']['type'];

                    //test to make sure file type is pdf
                    if ($file_type=="application/pdf"){

                        //test to make sure file is not too large
                        if ($_FILES['file']['size'] < 20000000) {

                            //upload the pdf and test if successful
                            if(move_uploaded_file($_FILES['file']['name'], $targetfile)){

                                //if file upload worked, insert the form info in mysql

                                // write new file's data into database
                                $sql = "INSERT INTO users (doc_name, deadline, edit_type)
                                        VALUES('" . $doc_name . "', '" . $deadline . "', '" . $edit_type . "');";
                                $query_new_file_insert = $this->db_connection->query($sql);

                                // if file has been added successfully
                                if ($query_new_file_insert) {
                                    $this->messages[] = "Your document has been added successfully.";
                                    $this->uploadSuccess = true;
                                } else {
                                    $this->errors[] = "Sorry, the database connection failed. Try again.";

                                    //NOTE:
                                    //should add code here that deletes the uploaded file since it's not in the database
                                }
                            } else {
                                $this->errors[] = "There was a problem uploading the file. Try again.";
                            }
                        } else {
                            $this->errors[] = "Sorry, your file is too large (max: 20 megabytes). Try again with a smaller file.";
                        }
                    } else {
                        $this->errors[] = "You may only upload PDF files. Try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection. Try again";
            }
        } else {
            $this->errors[] = "An unknown error occurred. Try again";
        }
    }

}
