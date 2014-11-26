
<?php
//Redirect the user after a successful form submission
					if ( !empty ( $redirect ) ) {
						header("Location: writer.html");
					} else {
						header("Location: $referred");
					}
?>