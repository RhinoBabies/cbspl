<?php
  session_start();

  //checks that user was logged in; if not, sends back to log in page
  if(empty($_SESSION["user"]))
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
    <title>Peer Library | Watchlist </title>
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
          <li class="current"><a href="watchlist.php">Watchlist</a></li>
          <li><a href="account.php">Account</a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </div>
      </nav>
    </header>

    <section id="searching">
      <div class="container">
        <h1>Search:</h1>
        <form>
          <div class="search">
            <input type="search" placeholder="Book Title or ISBN Number">
            <button class="button1" type="submit"><a href="search_positive.html">Search</a></button>
          </div>
        </form>
      </div>
    </section>

      <article id="main-col2">
          <h1 class="page-title">Watchlist</h1>
            <div>
              <a href="bookinformation.html"><img src="./images/Cookie Barney Software, LLC..jpg"></a>
              <a href="bookinformation.html"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></a>
            </div>
        </article>
        <article id="main-col2">
            <div>
              <a href="bookinformation.html"><img src="./images/Cookie Barney Software, LLC..jpg"></a>
              <a href="bookinformation.html"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></a>
            </div>
        </article>
        <article id="main-col2">
            <div>
              <a href="bookinformation.html"><img src="./images/Cookie Barney Software, LLC..jpg"></a>
              <a href="bookinformation.html"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></a>
            </div>
        </article>

      </div>
    </section>

    <div style="clear: both"></div>
    <footer>
      <p>Peer Library, Copyright &copy; 2017</p>
    </footer>

  </body>
</html>
