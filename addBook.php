<html>
<head>
<title>PeerLibrary | Add a Book</title>
<?php include("class_lib.php"); ?>
</head>
<body>

<br><br>

Welcome back, <?php echo $_POST["name"]; ?>!<br>
Your email address is: <?php echo $_POST["email"]; ?><br>
You typed in the password: "<?php echo $_POST["password"]; ?>"<br><br>

<?php
	//Since action="" is used in the form creation, it reloads the same page with the new POST information
	//Check for valid input from form
	if(!empty($_POST["isbn"]))
		echo "The isbn you added was: " . $_POST["isbn"] . "<br><br>";
	else
		echo "You did not add a book.<br><br>";
?>

<form action="" method="post">
  <u>Add this Book to my Nook</u><br>
  ISBN: <input type="text" name="isbn"><br>
  Title: <input type="text" name="title"><br>
  Author: <input type="text" name="author"><br>
  GBS Type:<br><input type="radio" name="gbs">Give<br>
  <input type="radio" name="gbs">Barter<br>
  <input type="radio" name="gbs">Sell<br>
  <input type="submit" value="Add Book"> <input type="reset" value="Reset">
</form>

</body>
</html>