<?php
	$msg = "";
	if( isset($_POST['register']) ) {
		$con = new mysqli('localhost', 'sitespec_test', 'testdb123!@#', 'sitespec_testdb');

		$user_name = $con->real_escape_string($_POST['user_name']);
		$user_email = $con->real_escape_string($_POST['user_email']);
		$password = $con->real_escape_string($_POST['password']);
		$confirm_password = $con->real_escape_string($_POST['confirm_password']);

		if($password !== $confirm_password) {
			$msg = "Please check your password.";
		} else {
			$sql = $con->query("SELECT id FROM users WHERE email='$user_email'");
			if($sql->num_rows > 0) {
				$msg = "This email already exists.";
			} else {
				$password = md5($password);
				// generate token
				$token = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!*()$";
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$con->query("INSERT INTO users (name, email, password, is_confirmed, token) VALUES ('$user_name', '$user_email', '$password', 0, '$token')");

				// send email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <info@sitespeck.com>' . "\r\n";

				$subject = "Verify your email";
				$message = '<p>Hi '.$user_name.',<br>Please <a href="http://sitespeck.com/register-login/confirm.php?email='.$user_email.'&token='.$token.'">click here</a> to confirm your email address.</p>';
				mail($user_email, $subject, $message, $headers);

				$msg = "You have been registered. Please confirm your email address.";
			}
		}

	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<div class="register-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					<img src="branding.png" alt="Logo">
					<?php
						if($msg != "") {
							echo '<div class="alert alert-success">'.$msg.'</div>';
						}
					?>
					<form action="index.php" method="post">
						
						<input type="text" name="user_name" placeholder="Name" class="form-control">
						<br>
						<input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<br>
						<input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control">
						<br>

						<input type="submit" name="register" value="Register" class="btn btn-primary">

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>