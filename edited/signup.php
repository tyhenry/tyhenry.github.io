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
					<form id="signup-form" method="post" action="signup-process.php">
						<!--redirect value-->
						<input type="hidden" name="redirect_to" value ="writer.html">

						<input type="text" name="f-name" value="first name">
						<input type="text" name="l-name" value="last name"><br>
						<input type="text" name="email" value="e-mail"><br>
						<input type="password" name="password" value="password"><br>
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