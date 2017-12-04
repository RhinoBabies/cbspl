<?php
	include_once("libraries".DIRECTORY_SEPARATOR."constants.php");

	// If variables are not set, just exit
	if (!isset($_GET['name']) || !isset($_GET['code']))
		exit();

	// ==========================
	// * GET CODE FROM DATABASE *
	// ==========================

	// Establish database connection
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	// Get user from database
	$username = $conn->real_escape_string($_GET['name']);
	$sql = "SELECT * FROM pl_user WHERE Username = '$username'";
	$result = $conn->query($sql);

	// Get user's code
	if ($result->num_rows > 0) {
		$result = $result->fetch_assoc();
		$code_stored = $result['VerifyCode'];
	}
	else {
		$conn->close();
		exit();
	}

	// ========================
	// * VERIFY THE USER CODE *
	// ========================

	if (password_verify($_GET['code'], $code_stored)) {
		$sql = "UPDATE pl_user SET Verified = 1 WHERE Username = '$username'";
		if ($conn->query($sql) === true) {
			echo 'User '.$username.' successfully verified.<br>
				You can now <a href=log_in.php>Log In</a> to Peer Library.';
		}
		else {
			echo 'Error verifying user: '.$conn->error;
		}
	}
	else
		echo 'Invalid code';

	$conn->close();

?>
