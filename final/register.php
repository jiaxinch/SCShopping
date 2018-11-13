<?php
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
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
			<h2 class="col-12 mt-4 text-center">User Registration</h2>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container col-8 col-md-6 col-lg-4">

		<form action="registration.php" method="POST">

			<div class="row mb-3">
				<div id="form-error" class="col-sm-9 ml-sm-auto font-italic text-danger">
				</div>
			</div> <!-- .row -->

			<div class="form-group text-center">
				<label for="email-id">Email: <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email-id" name="email">
			</div> <!-- .form-group -->

			<div class="form-group text-center">
				<label for="username-id">Username: <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="username-id" name="username">
			</div> <!-- .form-group -->

			<div class="form-group text-center">
				<label for="password-id">Password: <span class="text-danger">*</span></label>
				<input type="password" class="form-control" id="password-id" name="password">
			</div> <!-- .form-group -->

			<div class="form-group">
				<span class="text-danger font-italic">* Required</span>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<button type="submit" class="btn btn-primary button col-11">Register</button>
			</div> <!-- .form-group -->

            <div class="form-group row">
                <a href="index.php" role="button" class="btn btn-light col-11 button">Cancel</a>
            </div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-9 ml-sm-auto">
					<a href="login.php">Already have an account</a>
				</div>
			</div> <!-- .row -->

		</form>

	</div> <!-- .container -->

	<script>

		document.querySelector('form').onsubmit = function(){

			if ( document.querySelector('#email-id').value.trim().length == 0
				|| document.querySelector('#username-id').value.trim().length == 0
				|| document.querySelector('#password-id').value.trim().length == 0 ) {

				document.querySelector('#form-error').innerHTML = 'Please fill out all required fields.';

				return false;

			}
		}

	</script>

</body>
</html>
