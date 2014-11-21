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

	$first_name = $_POST['f-name'];
	$last_name = $_POST['l-name'];
	$email = $_POST['email'];
	$password = $_POST['password'];


	$sql = "INSERT INTO writers (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

	if ($conn->query($sql) === TRUE) {
		/*echo "New record created successfully";*/
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();


	/*Redirect the user after a successful form submission*/
	if ( !empty ( $redirect ) ) {
		header("Location: $redirect");
	} else {
		header("Location: $referred");
	}

?>