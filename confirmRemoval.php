<?php
  include_once("class_lib.php");
  session_start();

  //make sure the user is logged in
  if(!empty($_SESSION["user"]))
    $db_conn = $_SESSION["db_conn"]; //recall the db_connection that was setup on login
  //otherwise, send them directly to log_in page
  else {
    $_SESSION["login_error"] = "You must be logged in to view that page.<br>";
    header("Location: ./log_in.php");
  }

  $deleted = false;

  $book = $_SESSION["book"];
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //delete book
    if($db_conn->delete_book($book, $_SESSION["user"]))
    {
      $deleted = true;
      unset($_SESSION["book"]);
    }
    else{
      $deleted = false;
      $deletionError = "<h4>There was a problem removing the book. Please contact <a href='mailto:support@peer-library.com'>support@peer-library.com</a>.</h4>";
    }
    //on fail, notify user to email admin
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Easier way to trade and sell textbooks">
    <meta name="keywords" content="web seller, affordable textbooks, peer-to-peer selling">
    <meta name="author" content="Cookie Barney Software">
    <title>Peer Library | Confirm Removal </title>
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

    <article id="main-col2">
      <?php
        if(!$deleted){
          if(isset($book))
          echo '<h1 class="page-title">Remove a Listing</h1>
            <div>
              <h3 style="color: red;">Are you sure you would like to remove this listing?</h3>
              <h3>' . $book->printBookInfo() . '</h3>
              <form action="" method="post"><button class="button2">Remove Listing</button></form>
            </div>';
          if(isset($deletionError)){
            echo $deletionError;
            unset($deletionError);
          }
        }
        else
          echo '<h1 class="page-title">Book successfully removed!</h1>';
      ?>
        </article>
        <article id="main-col2">
        <br><br><br><br>
        <a href="./logged_in_homepage.php"><button class="button1" type="submit">Return to Home</button></a>
    </article>

    </div>
  </section>

  <div style="clear: both"></div>
  <footer>
    <p>Peer Library, Copyright &copy; 2017</p>
  </footer>

  </body>
</html>'