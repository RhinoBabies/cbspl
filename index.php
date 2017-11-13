<html>
<head>
<meta charset="UTF-8">

<title>PeerLibrary | Give, Barter, or Sell Your Used Textbooks</title>

<?php
	/*	index.php is the main landing page for the website. Even without navigating to index.php, this page will be loaded
		by default when going to just https://cbspl.altervista.org. Its contents are now just for testing certain things
		within PHP and passing information to another page.
	
	*/
	include("class_lib.php");
?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
}
</style>
</head>


<body>

<img src="logo.png" width=100>

<br><hr><br>

<!-- PRODUCT BACKLOG -->

Product Backlog
<table style="width:40%">
  <tr><th>Items</th><th>Priority</th></tr>
  <tr><td>Sign up</td><td>1</td></tr>
  <tr><td>Login</td><td>2</td></tr>
  <tr><td>Logout</td><td>2</td></tr>
  <tr><td>Add Book to Inventory</td><td>3</td></tr>
  <tr><td>Search Database</td><td>4</td></tr>
</table>

<!-- LOGIN CREDENTIALS
		This creates a form with the fields Name, E-mail, and Password where a user has to type in that information.
		It is using the HTTP method of "post" ("get" is a less secure method of passing information).
		See https://www.w3schools.com/php/php_forms.asp for more info.

		You can see that this form will pass its action to "welcome.php" once the user clicks Submit.
-->

<br><br>
<form action="welcome.php" method="post">
  <u>Login</u><br>
  Name: <input type="text" placeholder="Enter your username" name="name"><br>
  E-mail: <input type="email" placeholder="Enter your e-mail" name="email"><br>
  Password: <input type="password" placeholder="Enter your password" name="password"><br>
  <input type="submit" value="Login">
</form>

</body>

</html>





