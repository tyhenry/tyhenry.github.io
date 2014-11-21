<!DOCTYPE html>

<html>

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


	<?php
		// define variables and set to empty values
		$fnameErr = $lnameErr = $emailErr = $passwordErr = "";
		$fname = "first name*";
		$lname = "last name*";
		$email = "e-mail*";
		$password = "password*";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

		   if (empty($_POST["f-name"])) {
		     $nameErr = "First name is required";
		   } else {
		     $fname = test_input($_POST["f-name"]);
		     // check if name only contains letters and whitespace
		     if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
		       $fnameErr = "Only letters and whitespace allowed"; 
		     }
		   }

		   if (empty($_POST["l-name"])) {
		     $lnameErr = "Last name is required";
		   } else {
		     $lname = test_input($_POST["l-name"]);
		     // check if name only contains letters and whitespace
		     if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
		       $lnameErr = "Only letters and whitespace allowed"; 
		     }
		   }
		   
		   if (empty($_POST["email"])) {
		     $emailErr = "Email is required";
		   } else {
		     $email = test_input($_POST["email"]);
		     // check if e-mail address is well-formed
		     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		       $emailErr = "Invalid email format"; 
		     }
		   }

		   if (empty($_POST["password"])) {
		     $passwordErr = "Password is required";
		   } else {
		     $password = test_input($_POST["password"]);
		     // check if name only contains letters and whitespace
		     if (!preg_match("/^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{8,}$/",$password)) {
		       $nameErr = "Must have a minimum of 8 characters, 2 numbers, and the following characters: ! @ # $ % *"; 
		     }
		   }

		}

		function test_input($data) {
		   $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		}
	?>

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
						<!--redirect value-->
						<input type="hidden" name="redirect_to" value ="writer.html">

						<input type="text" name="f-name" value="<?php echo $fname;?>"><span class="error"><?php echo $fnameErr;?></span>
						<input type="text" name="l-name" value="<?php echo $lname;?>"><br><span class="error"><?php echo $lnameErr;?></span>
						<input type="text" name="email" value="<?php echo $email;?>"><br><span class="error"><?php echo $emailErr;?></span>
						<input type="password" name="password" value="<?php echo $password;?>"><br><span class="error"><?php echo $passwordErr;?></span>
						<input type="submit" name="submit" value="sign up" class="btn" id="signup-button">
						<!--<button class="btn" id="signup-button">sign up</button>-->
					</form>
				</div>
				
			</div>

		</section>


		<footer>
			<h3>Connecting independent writers and freelance editors</h3>
		</footer>


	</body>

</html>