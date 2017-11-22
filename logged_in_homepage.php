<?php
  include("class_lib.php"); 
  session_start();
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
              <button class="button1" type="submit"><a href="watchlist.html">Watchlist</a></button>
            </div>
        </article>

        <article id="main-col2">
          <h1 class="page-title">Your Book Nook</h1>
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
              <button class="button1" type="submit"><a href="booknook.html">Nook</a></button>
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
