<?php

	// include the configs / constants for the database connection
	require_once("config/db.php");

	// load the login class
	require_once("classes/Login.php");

	// create a login object. when this object is created, it will do all login/logout stuff automatically
	// so this single line handles the entire login process. in consequence, you can simply ...
	$login = new Login();

	/*These are variables for our redirect*/
	$redirect = $_POST['redirect_to'];
	$referred = $_SERVER['HTTP_REFERER'];
	$query = parse_url($referred, PHP_URL_QUERY);
	$referred = str_replace(array('?', $query), '', $referred);


	// Create connection
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 

	$doc_name = $_POST['doc_name'];
	$deadline = $_POST['deadline'];
	$edit_type = $_POST['edit_type'];
	
	$user_folder = $_SESSION['user_id']; //writer's user_id will be the folder in which to store their documents
	$targetfolder = "uploads/" . $user_folder . "/" ;

	if (!is_dir($targetfolder)) {
		mkdir($targetfolder); //makes the user folder in the "uploads" directory if it doesn't exist
	}

	$targetfile = $targetfolder . basename( $_FILES['file']['name']) ;

	$sql = "INSERT INTO documents (doc_name, deadline, edit_type) VALUES ('$doc_name', '$deadline', '$edit_type')";

	$file_type=$_FILES['file']['type'];
 
 	//test to make sure file type is pdf
	if ($file_type=="application/pdf"){

		if ($_FILES["fileToUpload"]["size"] > 20000000) {
		    echo "Sorry, your file is too large. Click your Back button and try again.";
		}

		//upload the pdf and test if successful
		if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)){

				//if file upload worked, insert the form info in mysql

				//insert mysql info and test if successful
				if ($conn->query($sql) === TRUE) {
					//it worked, do nothing here
				} else {
					echo "Database error: " . $sql . "<br>" . $conn->error;
				}

		} else {
			echo "Problem uploading file. Click your Back button and try again.";
		}
	} else {
		echo "You may only upload PDF files. Click your Back button and try again.";
	}


	$conn->close();


	/*Redirect the user after a successful form submission*/
	if ( !empty ( $redirect ) ) {
		header("Location: $redirect");
	} else {
		header("Location: $referred");
	}

?>