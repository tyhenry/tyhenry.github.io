<?php

	$server = 'localhost';
	$user_name = 'root';
	$password = 'root';
	$database = 'edited';

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
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
?>