<?php

	$server = 'localhost';
	$user_name = 'root';
	$password = 'root';
	$database = 'edited';


	/*These are variables for our redirect*/
	$redirect = $_POST['redirect_to'];
	$referred = $_SERVER['HTTP_REFERER'];
	$query = parse_url($referred, PHP_URL_QUERY);
	$referred = str_replace(array('?', $query), '', $referred);


	// Create connection
	$conn = new mysqli($server, $user_name, $password, $database);
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 

	$title = $_POST['doc-name'];
	$deadline = $_POST['doc-deadline'];
	$edit_type = $_POST['doc-type'];

	$targetfolder = "uploads/";
	$targetfile = $targetfolder . basename( $_FILES['file']['name']) ;

	$sql = "INSERT INTO documents (title, deadline, edit_type) VALUES ('$title', '$deadline', '$edit_type')";

	$file_type=$_FILES['file']['type'];
 
 	//test to make sure file type is pdf
	if ($file_type=="application/pdf"){

		if ($_FILES["fileToUpload"]["size"] > 20000000) {
		    echo "Sorry, your file is too large.";
		}

		//upload the pdf and test if successful
		if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)){
			/*echo "The file ". basename( $_FILES['file']['name']). " is uploaded";*/

				//if file upload worked, insert the form info in mysql

				//insert mysql info and test if successful
				if ($conn->query($sql) === TRUE) {
					/*echo "New record created successfully";*/
				} else {
					echo "Database error: " . $sql . "<br>" . $conn->error;
				}

		} else {
			echo "Problem uploading file. Please click your Back button and try again.";
		}
	} else {
		echo "You may only upload PDF files.  Click your Back button and try again.";
	}


	$conn->close();


	/*Redirect the user after a successful form submission*/
	if ( !empty ( $redirect ) ) {
		header("Location: $redirect");
	} else {
		header("Location: $referred");
	}

?>