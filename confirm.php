<?php
	$email = $_GET['email'];
	$token = $_GET['token'];

	$con = new mysqli('localhost', 'sitespec_test', 'testdb123!@#', 'sitespec_testdb');

	$sql = $con->query("SELECT id FROM users WHERE email='$email' AND token='$token' AND is_confirmed=0");
	if ($sql->num_rows > 0) {
		$con->query("UPDATE users SET is_confirmed=1, token='' WHERE email='$email'");
		echo 'Email address verified. You can <a href="http://sitespeck.com/register-login/login.php">login</a> now.';
	} else {
		echo 'Please <a href="http://sitespeck.com/register-login/login.php">login</a>';
	}
?>