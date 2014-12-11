<!DOCTYPE html>

<html>

	<head>
		<title>Upload to edited.io</title>

		<meta charset="UTF-8">
		<meta type="description" content="the writer upload page of the edited.io social platform">
		<meta type="keywords" content="writing,writer,editing,editor,freelance,social">

		<link rel="stylesheet" href="style/portal.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">

		<!--quick JQuery UI fix for date picker in non-Chrome browsers-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<script>
			$(function() {
				$( "#datepicker" ).datepicker();
			});
		</script>


	</head>

	<body>

		<section id="header">

				<a href="writer.html#top">
					<div id="logo"></div>
				</a>

				<nav id="nav-right">
					<ul>
						<li><a href="index.html">log out</a></li>
					</ul>
				</nav>

		</section>

		<section id="main">

			<div id="writer-upload">

				<div id="tagline">
					<h2>Submit your writing to be edited.</h2>
				</div>

				<div class="form-container">
					<form id="signup-form" method="post" action="upload-process.php" enctype="multipart/form-data">
						<!--redirect value-->
						<input type="hidden" name="redirect_to" value ="login.php">
						
						<input type="text" name="doc_name" placeholder="document title"><br>
						<label for="doc_deadline">Edit deadline:</label>
						<!--input type="date" name="deadline" value="editing deadline (MM/DD/YYYY)"><br-->
						<input type="text" name="deadline" placeholder="editing deadline (MM/DD/YYYY)" id="datepicker"><br>
						<label for="edit_type">Type of edit:</label>
						<select name="edit_type" placeholder="type of edit">
							<option value="line-edit">Line Edit</option>
							<option value="proofread">Proofread</option>
							<option value="struc-edit">Structural Edit</option>
							<option value="fact-check">Fact Check</option>
						</select><br>
						<label for="fileselect">Files to upload:</label>
						<input type="file" id="fileselect" name="file" size="50" />
						<div id="submit-button">
							<button class="btn" id="submit-btn">submit document</button>
						</div>
					</form>
				</div>
				
			</div>

		</section>

	</body>

</html>