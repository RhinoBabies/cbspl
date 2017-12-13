<?php
  session_start();

  if(empty($_SESSION["user"])) {
    $_SESSION["login_error"] = "You must be logged in to view that page.<br>";
    header("Location: ./log_in.php");
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Easier way to trade and sell textbooks">
    <meta name="keywords" content="web seller, affordable textbooks, peer-to-peer selling">
    <meta name="author" content="Cookie Barney Software">
    <title>Peer Library | Error! </title>
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
        <h1 class="page-title">Uh oh!</h1>
          <div>
            <h3><?php echo $_SESSION["error"]; unset($_SESSION["error1"]);?></h3>
          </div>
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