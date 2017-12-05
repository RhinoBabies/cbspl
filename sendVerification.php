<?php
	include_once("libraries".DIRECTORY_SEPARATOR."constants.php");

	session_start(); // return error codes

	// Variables from form
	$email = $_POST['email'];
	$username = $_POST['name'];
	$password = $_POST['password'];
	$passConfirm = $_POST['passConfirm'];
	$_SESSION['email_add'] = $email;
	$_SESSION['name_add'] = $username;

	// Redirect Boolean
	$redirect = false;



	// ================================
	// * SET ERROR FLAGS AND REDIRECT *
	// ================================

	// Redirect if passwords do not match
	if ($password !== $passConfirm) {
		$_SESSION['pass_diff'] ="";
		$redirect = true;
	}

	// Redirect if E-mail address does not fit regular expression
	if (!preg_match(REGEX_EMAIL, $email)) {
		$_SESSION['email_form'] = "";
		$redirect = true;
	}

	// Redirect if username is invalid
	if (!preg_match(REGEX_USERNAME, $username)) {
		$_SESSION['name_form'] = "";
		$redirect = true;
	}

	// Establish connection to database
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	// Redirect if E-mail address is in use
	$tempemail = $conn->real_escape_string($email);
	$sql = "SELECT * FROM pl_user WHERE EmailReal = '$tempemail'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$_SESSION['email_exists'] = "";
		$redirect = true;
	}

	// Redirect if Username is in use
	$tempname = $conn->real_escape_string($username);
	$sql = "SELECT * FROM pl_user WHERE Username = '$tempname'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$_SESSION['name_exists'] = "";
		$redirect = true;
	}
	else
		$_SESSION['name_avail'] = "";

	// Redirect if anything failed
	if ($redirect) {
		$conn->close();
		header('Location: log_in.php');
		exit();
	}



	// ========================
	// * ADD USER TO DATABASE *
	// ========================

	// Generate activation code
	$code = bin2hex(openssl_random_pseudo_bytes(72));
	$code_stored = password_hash($code, PASSWORD_BCRYPT);

	// Generate anonymous E-mail address
	$emailanon = 'user-'.$tempname.'@'.EMAIL_DOMAIN;

	// Hash password
	$temppass = password_hash($password, PASSWORD_BCRYPT);

	// Add user
	$conn->query("INSERT INTO pl_user (Username, EmailReal, EmailAnon, Password, VerifyCode)
		VALUES ('$tempname', '$tempemail', '$emailanon', '$temppass', '$code_stored')");

	echo $code;

	// ============================
	// * SEND VERIFICATION E-MAIL *
	// ============================

	// Send the e-mail to the following address
	$to = $email;

	// with the following subject line
	$subject = 'Peer Library - Account Verification';

	// the following message
	$message = '

Dear '.$username.',<br>
<br>
Welcome to Peer Library!<br>
You can log in with the following credentials after verifying your e-mail address.<br>
<br>
--------------------------------------<br>
Username: '.$username.'<br>
Password: '.$password.'<br>
--------------------------------------<br>
<br>
To verify your e-mail address, click the link below:<br>
<a href=\"'.SITE_URL.'/verify.php?name='.$username.'&code='.$code.'\">Verify Account</a><br>
<br>
Best wishes,<br>
Peer Library<br>
';

	// and the following headers
	$headers = 'From: noreply@'.EMAIL_DOMAIN."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Send the e-mail
	mail($to, $subject, $message, $headers);



	// ===========================
	// * DISPLAY MESSAGE TO USER *
	// ===========================

	echo 'Verification e-mail sent to your account.<br>Check your e-mail to verify your account.';

?>