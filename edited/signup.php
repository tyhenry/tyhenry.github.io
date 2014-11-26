<?php

		// define variables and set to empty values
		$fnameErr = $lnameErr = $emailErr = $passwordErr = "";
		$first_name = "first name";
		$last_name = "last name*";
		$email = "e-mail*";
		$password = "password";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
		       $nameErr = "Must have a minimum of 8 characters, 2 numbers, and the following characters: ! @ # $ % *"; 
		       $formCheck = 0;
		     }
		 }


		   	/*------ IF EVERYTHING PASSED THE TEST ------*/
			/*------ INSERT FORM DATA INTO MYSQL --------*/

			if ($formCheck == 1){

				$server = 'localhost';
				$db_un = 'root';
				$db_pw = 'root';
				$db = 'edited';


				/*These are variables for our redirect*/
				//$redirect = $_POST['redirect_to'];
				$redirect = "writer.html";
				$referred = $_SERVER['HTTP_REFERER'];
				$query = parse_url($referred, PHP_URL_QUERY);
				$referred = str_replace(array('?', $query), '', $referred);


				// Create connection
				$conn = new mysqli($server, $db_un, $db_pw, $db);
				// Check connection
				if ($conn->connect_error) {
			    	die("Connection failed: " . $conn->connect_error);
				}

				$sql = "INSERT INTO writers (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

				if ($conn->query($sql) === TRUE) {
					/*echo "New record created successfully";*/
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}

				$conn->close();

				
				//Redirect the user after a successful form submission!

				header("Location: writer.html");
				exit();

			}


		}

		function test_input($data) {
		   $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		}

?><!DOCTYPE html><html>

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

		<div class="cover-bg-ernest"></div>


		<section id="header" class="bg-ernest">

				<a href="index.html">
					<div id="logo"></div>
				</a>

				<nav id="nav-right">
					<ul>
						<li><a href="login.html">login</a></li>
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
					<!--form id="signup-form" method="post" action="signup-process.php"-->
					<form id="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						

						<input type="text" name="f-name" value="first name*">
						<input type="text" name="l-name" value="last name*">
						<?php echo $fnameErr;?></span>
						<?php echo $lnameErr;?></span>

						<input type="text" name="email" value="email*"><br><?php echo $emailErr;?></span>
						<input type="password" name="password" value="password*"><br><?php echo $passwordErr;?></span>
						<input type="submit" name="submit" value="sign up" class="btn" id="signup-button">
						<!--<button class="btn" id="signup-button">sign up</button>-->
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