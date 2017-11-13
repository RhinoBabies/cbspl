<html>
<head>
<title>PeerLibrary | Welcome!</title>
<?php include("class_lib.php"); ?>
</head>
<body>

<?php
  $db_conn = new db_connection();
  $db_conn->check_user_credentials($_POST["name"], $_POST["password"]);
?>

<!-- WELCOMES THE RECOGNIZED USER
	 This should also be where 
	 "last login date" field is updated. -->
<br><br>
Welcome back, <?php echo $_POST["name"]; ?>!<br>
Your email address is: <?php echo $_POST["email"]; ?><br>
You typed in the password: "<?php echo $_POST["password"]; ?>"<br><br>

<a href="addBook.php">Add a Book</a><br><br>

<?php
	if($db_conn->get_logged_in() == true) //update user_login_date in table pl_User upon successful login
	{
		echo "You are logged in!<br><br>";
	}
?>

</body>
</html>

