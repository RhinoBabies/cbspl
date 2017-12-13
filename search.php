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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Easier way to trade and sell textbooks">
    <meta name="keywords" content="web seller, affordable textbooks, peer-to-peer selling">
    <meta name="author" content="Cookie Barney Software">
    <title>Peer Library | Search Results </title>
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
          <li><a href="logged_in_homepage.php">Home</a></li>
          <li><a href="booknook.php">Nook</a></li>
          <li><a href="watchlist.php">Watchlist</a></li>
          <li><a href="account.php">Account</a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </div>
      </nav>
    </header>

    <section id="searching">
      <div class="container">
        <h1>Search:</h1>
        <form action="./search.php" method="get">
          <div class="search">
            <input type="search" placeholder="Book Title or ISBN Number" name="query">
            <button class="button1" type="submit">Search</button></div></form>
          </div>
        </form>
      </div>
    </section>

      <article id="main-col2">
          <h1 class="page-title">Search Results</h1>      <article id="main-col2">
        <div>
        <?php
            $query = $_GET['query'];
            // gets value sent over search form

            $db_conn->search($query);
        ?>
        </div>
    </article>

    </body>
</html>