<?php
  include("class_lib.php"); 
  session_start();

  unset($_SESSION["book"]);

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
    <title>Peer Library | Home </title>
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
            <li class="current"><a href="logged_in_homepage.php">Home</a></li>
            <li><a href="booknook.php">Nook</a></li>
            <li><a href="watchlist.php">Watchlist</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </nav>
      </div>
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


    <section id="main">
      <div class="container">

        <aside id="sidebar">
          <div class="dark">
            <h3>Notifications</h3>
            <p>Fusce pretium risus neque, sit amet auctor tortor luctus ac.</p>
            <p>Nunc vel augue id purus consectetur luctus. Quisque vulputate eu diam quis vestibulum. Vivamus vel hendrerit lectus.</p>
            <p>Vivamus viverra sapien dui, et cursus sapien consectetur id. Praesent eu felis neque. Curabitur a varius neque.
            <p>Integer vitae quam id nulla lacinia dapibus. In hac habitasse platea dictumst. Duis pulvinar nulla ligula, et luctus metus interdum vitae.</p>
          </div>
        </aside>

        <article id="main-col2">
          <h1 class="page-title"><?php echo $_SESSION["user"]; ?>'s Recent Searches/Watchlist</h1>
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
        <article id="main-col2">
            <div>
              <a href="watchlist.php"><button class="button1" type="submit">See My Watchlist</button></a>
            </div>
        </article>

      <article id="main-col2">
          <h1 class="page-title">My Book Nook</h1>
          <?php
            $db_conn->list_my_books(3, $_SESSION["user_anon_email"]); //can change the argument # to print less/more recent book postings
          ?>
      <article id="main-col2">
        <div>
          <a href="booknook.php"><button class="button1">Go to My Book Nook</button></a>
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
