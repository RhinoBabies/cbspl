<?php
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
    <title>Peer Library | Account </title>
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
          <li class="current"><a href="account.php">Account</a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </div>
      </nav>
    </header>

    <section id="searching">
      <div class="container"></div>
    </section>

    <section id="account">
        <h3>Account Information</h3>
        <form class="information">
      <div>
        <label>Username</label><br>
        <input type="text" placeholder="Username">
      </div>
      <div>
        <label>Email</label><br>
        <input type="email" placeholder="Email">
      </div>
      <div>
        <label>New Email</label><br>
        <input type="email" placeholder="New Email">
        <button class="button1" type="submit">Update Email</button>
      </div>
      <div>
        <label>Password</label><br>
        <input type="password" placeholder="Password">
      </div>
      <div>
        <label>New Password</label><br>
        <input type="password" placeholder="New Password">
        <button class="button1" type="submit">Update Password</button>
      </div>
      </form>
    </section>

    <div style="clear: both"></div>
    <footer>
      <p>Peer Library, Copyright &copy; 2017</p>
    </footer>

  </body>
</html>
