<?php
include ("class_lib.php");
session_start();

//make sure the user is logged in
if(!empty($_SESSION["user"]))
    $db_conn = $_SESSION["db_conn"]; //recall the db_connection that was setup on login
//otherwise, send them directly to log_in page
else
{
    $_SESSION["login_error"] = "You must be logged in to view that page.<br>";
    header("Location: ./log_in.php");
}
?>

<html>
<head>
    <title>Search results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>


<?php
$query = $_GET['query'];
// gets value sent over search form

$min_length = 10;
// you can set minimum length of the query if you want

$sql = "SELECT * FROM 'pl_adds'";
$result = $db_conn->query_db($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ISBN_10_Added"]. " - Name: " . $row["Username"]. " " . $row["Cost"]. "<br>";
    }
} else {
    echo "0 results";
}

?>
</body>
</html>