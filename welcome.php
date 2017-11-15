<?php
//=======================//=======================//
//session_start() must come before any HTML code!!//
//=======================//=======================//
	session_start();
?>
<html>
<head>
<title>PeerLibrary | Welcome!</title>
<?php 
	include("class_lib.php");
?>
</head>
<body>

<?php
	//should check date of last cookie here; if cookie is older than a week, reset cookie after user logs in
	//if cookie is still edible, then don't require the user to login and just read the cookie for their username.
	//"Not username?" Logout link.
	$db_conn = new db_connection();
	$valid_user = $db_conn->check_user_credentials($_POST["name"], $_POST["password"]);

	//checks if the user credentials passed; if so, store the current username and e-mail in the session information
	//then print the array of session information to the page
	if($valid_user)
	{
		$_SESSION["user"] = $_POST["name"];
		$_SESSION["email"] = $_POST["email"];
		print_r($_SESSION);
	}
?>

<!-- WELCOMES THE RECOGNIZED USER
	 This should also be where 
	 "last login date" field is updated. -->
<br><br>
Welcome back, <?php echo $_POST["name"]; ?>!<br>
Your email address is: <?php echo $_POST["email"]; ?><br>
You typed in the password: "<?php echo $_POST["password"]; ?>"<br><br>

<!-- Menu of options upon logging in -->
<a href="addBook.php">Add a Book</a><br><br>

<?php
	if($db_conn->get_logged_in() == true) //update user_login_date in table pl_User upon successful login
	{
		echo "You are logged in!<br><br>";
	}
?>

</body>
</html>

