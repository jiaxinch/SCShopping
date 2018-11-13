<?php
require 'config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

<?php

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password'])
) :

// Error. Required Input Empty.
?>

<div class="text-danger">Please fill out all required fields.</div>

<?php


else :

// All required fields provided.

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) :
		echo $mysqli->connect_error;
	else:
		// Connection successful

		// $mysqli->real_escape_string() escapes special characters like apostrophes.

		$sql = "SELECT * FROM user
						WHERE email = '"
						.$mysqli->real_escape_string($_POST['email'])
						."'
						OR username = '"
						.$mysqli->real_escape_string($_POST['username'])
						."';";

		$results = $mysqli->query($sql);
		// TODO: Check for SQL Error.

		if ($results->num_rows > 0) :
			// Found email or username in the DB.
			echo "Username or email already registered.";
		else :

		$password = hash('sha256', $_POST['password']);

		$sql = "INSERT INTO user (email, username, password,seller)
						VALUES ('"
						. $mysqli->real_escape_string($_POST['email'])
						. "', '"
						. $mysqli->real_escape_string($_POST['username'])
						. "', '"
						. $mysqli->real_escape_string($password)
                        . "', '"
						. "0"
						. "');";

		// echo $sql;
		$results = $mysqli->query($sql);

		if (!$results) :
			echo $mysqli->error;
		else :

			$to = $_POST['email'];
			$subject = "Welcome to Song DB!";
			$msg = "<h1>Hello!</h1>
							<div>You successfully registered.</div>";
			$headers = "Content-Type: text/html"
								."\r\n"
								."From: no-reply@usc.edu";

			mail($to, $subject, $msg, $headers);

?>
	<div class="text-success">
		User <?php echo $_POST['username']; ?> was successfully registered.
	</div>
<?php
			endif; /* ELSE for INSERT SQL Error */
		endif; /* ELSE for duplicate email/username error. */
		$mysqli->close();
	endif; /* ELSE for DB Connection Error */

endif; /* ELSE for empty input validation */
?>

		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>
