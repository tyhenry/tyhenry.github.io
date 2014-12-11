<!DOCTYPE html>

<html>

	<head>
		<title>login to edited.io</title>

		<meta charset="UTF-8">
		<meta type="description" content="login to edited.io, a social platform for writers and editors">
		<link rel="stylesheet" href="style/main.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>

	<body>

		<div class="cover-bg-ernest2"></div>


		<section id="header" class="bg-ernest2">

				<a href="index.html">
					<div id="logo"></div>
				</a>

				<nav id="nav-right">
					<ul>
						<li><a href="signup.php">sign up</a></li>
						<li><a href="index.html#about-edited">about</a></li>
					</ul>
				</nav>

			</div>

		</section>

		<section id="splash">

			<div id="splash-content">

				<div id="tagline">
					<h2>Connecting independent writers with freelance editors</h2>
				</div>

				<div class="form-container">
					<?php
						// show potential errors / feedback (from login object)
						if (isset($login)) {
						    if ($login->errors) {
						        foreach ($login->errors as $error) {
						            echo $error;
						        }
						    }
						    if ($login->messages) {
						        foreach ($login->messages as $message) {
						            echo $message;
						        }
						    }
						}
					?>
					<form id="login-form" method="post" action="login.php" name="loginform">
						<input type="text" placeholder="your@email.com" name="user_email" required><br>
						<input type="password" name="user_password" placeholder="password" autocomplete="off" required><br>
						<button type="submit" class="btn" id="login-button" name="login">login</button>
					</form>
				</div>
				
			</div>

		</section>


		<footer>
			<h3>Everyone needs an editor. Find yours.</h3>
		</footer>


	</body>

</html>