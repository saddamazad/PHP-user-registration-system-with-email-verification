<?php
	$msg = "";
	if( isset($_POST['login']) ) {
		$con = new mysqli('localhost', 'sitespec_test', 'testdb123!@#', 'sitespec_testdb');

		$user_email = $con->real_escape_string($_POST['user_email']);
		$password = $con->real_escape_string($_POST['password']);
		$password = md5($password);

		$sql = $con->query("SELECT * FROM users WHERE email='$user_email' AND password='$password'");
		if($sql->num_rows > 0) {
			$results = $sql->fetch_array();
			if($results['is_confirmed'] == 0) {
				$msg = "Please verify your email.";
			} else {
				$msg = "You are logged in.";
			}
		} else {
			$msg = "Please check your inputs.";
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<div class="login-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					<img src="branding.png" alt="Logo">
					<?php
						if($msg != "") {
							echo '<div class="alert alert-success">'.$msg.'</div>';
						}
					?>
					<form action="login.php" method="post">
						
						<input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<br>

						<input type="submit" name="login" value="Login" class="btn btn-primary">

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>