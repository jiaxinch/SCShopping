<?php
session_start();
require 'config/config.php';

// Check whether user is logged in.
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
	// User is not logged in.

	$login_error = false;

	// Check whether form was submitted
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		// Form was submitted

		if ( empty($_POST['username']) || empty($_POST['password']) ) {
			// Missing username or pass.
			$login_error = 'empty';
		} else {

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			// TODO: DB Connection Error Check.

			$password = hash('sha256', $_POST['password']);

			$sql = "SELECT * FROM user
							WHERE username = '"
							. $mysqli->real_escape_string($_POST['username'])
							."'
							AND password = '"
							. $mysqli->real_escape_string($password)
							."';";

			$results = $mysqli->query($sql);
			// TODO: Check for SQL Errors.

			if ( $results->num_rows == 1 ) {
				// Correct Credentials
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];

				if($row = $results->fetch_assoc()){
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['admin'] =$row['seller'];
				}

				header('Location: index.php');
			} else {
				// Invalid credentials
				$login_error = 'invalid';
			}
		}

	}

} else {
	// User is already logged in.
	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
	<style>
	.form-check-label {
		padding-top: calc(.5rem - 1px * 2);
		padding-bottom: calc(.5rem - 1px * 2);
		margin-bottom: 0;
	}
    .container{
        margin:auto;
    }
    .button{
        margin: auto;
    }
    label{
        font-weight: bold;
    }
</style>
</head>
<body>
    <?php include 'navigation.php'; ?>
	<div class="container">
		<div class="row">
			<h2 class="col-12 mt-4 text-center">User Login</h2>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container col-8 col-md-6 col-lg-4">

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">

		<?php if ( $login_error == 'empty' ) : ?>
			Please enter username and password.
		<?php endif; ?>

		<?php if ( $login_error == 'invalid' ) : ?>
			Invalid username or password.
		<?php endif; ?>

		<?php

if( isset($_GET['message']) && !empty($_GET['message'])){
echo $_GET['message'];
}

		?>

				</div>
			</div> <!-- .row -->

			<div class="form-group text-center">
				<label for="username-id">Username</label>
				<input type="text" class="form-control" id="username-id" name="username">
			</div> <!-- .form-group -->

            <div class="form-group text-center">
				<label for="password-id">Password</label>
				<input type="password" class="form-control" id="password-id" name="password">
			</div> <!-- .form-group -->


			<div class="form-group row">
				<button type="submit" class="btn btn-primary col-11 button">Login</button>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <a href="index.php" role="button" class="btn btn-light col-11 button">Cancel</a>
            </div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-9 ml-sm-auto">
					<a href="register.php">Create an account</a>
				</div>
			</div> <!-- .row -->
		</form>

	</div> <!-- .container -->
</body>
</html>
