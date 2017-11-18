<?php
//=======================//=======================//
//session_start() must come before any HTML code!!//
//=======================//=======================//
	session_start();

  include("class_lib.php"); 

  $db_conn = new db_connection();
  $is_valid_user = $db_conn->check_user_credentials($_POST["name"], $_POST["password"]);
  
  if($is_valid_user)
  {
  	//set session variables for username to remember their log-in information
  	$_SESSION["user"] = $_POST["name"];
  	header('Location: logged_in_homepage.php');
  	exit();
  }
  else
  {
  	//send the user back to the log-in page with an error message
  	$_SESSION["login_error"] = "There was an error with the username and/or password.<br>";
  	header('Location: log_in.php');
  	exit();
  }

?>