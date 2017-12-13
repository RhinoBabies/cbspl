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

	// Success in all fields. Unset associated session variables
	unset($_SESSION['email_add']);
	unset($_SESSION['name_add']);
	unset($_SESSION['name_avail']);



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
	$conn->query("INSERT INTO pl_user (Username, EmailReal, EmailAnon, Password, VerifyCode, Verified)
		VALUES ('$tempname', '$tempemail', '$emailanon', '$temppass', '$code_stored', 0)");



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
<a href="'.SITE_URL.'/verify.php?name='.$username.'&code='.$code.'">Verify Account</a><br>
<br>
Best wishes,<br>
Peer Library<br>
';

	// and the following headers
	$headers = 'From: noreply@'.EMAIL_DOMAIN."\r\n";
	$headers .= 'Content-type: text/html'."\r\n";

	// Send the e-mail
	mail($to, $subject, $message, $headers);



	// ===========================
	// * DISPLAY MESSAGE TO USER *
	// ===========================

	echo '<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Easier way to trade and sell textbooks">
    <meta name="keywords" content="web seller, affordable textbooks, peer-to-peer selling">
    <meta name="author" content="Cookie Barney Software">
    <title>Peer Library | Register </title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div id="branding">
          <img src="./images/PeerLibrary logo.png">
        </div>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li  class="current"><a href="log_in.php">Log In</a></li>
        </ul>
      </div>
      </nav>
    </header>

    <article id="main-col2">
        <h1 class="page-title">You\'ve been registered!</h1>
          <div>
            <h3>An email has been sent to your account.</h3>
            <h3>Please check your email and verify your account.</h3>
          </div>
        <a href="index.html"><button class="button1" type="submit">Return to Home</a></button>
    </article>


    </div>
  </section>

  <div style="clear: both"></div>
  <footer>
    <p>Peer Library, Copyright &copy; 2017</p>
  </footer>

  </body>
</html>';

?>
