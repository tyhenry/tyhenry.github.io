<!DOCTYPE html>

<html>

	<head>
		<title>welcome to edited.io</title>

		<meta charset="UTF-8">
		<meta type="description" content="the writer portal of the edited.io social platform">
		<meta type="keywords" content="writing,writer,editing,editor,freelance,social">

		<link rel="stylesheet" href="style/portal.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>

	<body>

		<span id="top" class="anchor"></span>

		<section id="header">

				<a href="#top">
					<div id="logo"></div>
				</a>

				<nav id="nav-right">
					<ul>
						<li><a href="login.php?logout">log out</a></li>
					</ul>
				</nav>

		</section>

		<section id="main">

			<div id="welcome">
				<h2>Welcome back, <?php echo $_SESSION['f_name']; ?>.</h2>
			</div>

			<div id="submit-work">
				<a id="submit" class="btn" href="upload.php">upload new writing</a>
			</div>

			<?php

				$user_id = $_SESSION['user_id']; //writer's user_id will be the folder in which to store their documents
				$folder = "uploads/" . $user_id . "/" ;

				if (is_dir($folder)) {

					if (scandir($folder) !== FALSE){
	
						//retrieve files and remove the "." and ".." from linux folders
						$files = array_diff(scandir($folder), array('..', '.'));
						$files = array_values($files); //reset array indices
						$filesLength = count($files); //count the items in the array


						$filesJSON = json_encode($files); //create json version of file array

						$consoleFiles = "<script>
											docArray = JSON.parse('" . $filesJSON . "');
											console.log(docArray);
										 </script>";
						echo $consoleFiles; //creates js docArray array of files for show_docs.js to use
					}
				}

				// PHP js console debug script
				/*function debug_to_console( $data ) {

				    if ( is_array( $data ) )
				        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
				    else
				        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

				    echo $output;
				}*/
			?>

			<div id="documents">

				<h2 id="my-documents">My Documents</h2>

				<?php

					//display the documents one by one
					for($i = 0; $i < $filesLength; $i++) {

						$doc_display =
						   	'<div class="document">
								<a href="ViewerJS/#../' . $folder . $files[$i] . '">
									<iframe id="viewer" src = "ViewerJS/#../' . $folder . $files[$i] . '" width="300" height="388" allowfullscreen webkitallowfullscreen></iframe>
									<div class="doc-data">
										<div class="doc-name">Sample Document</div>
										<div class="doc-date">Oct. 14, 2014</div>
										<div class="doc-status">Edit in progress</div>
									</div>
								</a>
							</div>
							';

						echo $doc_display;
					}
				?>

			</div>

		</section>

	</body>

</html>