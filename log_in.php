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
    <title>Peer Library | Log In </title>
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
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li class="current"><a href="">Log In</a></li>
        </ul>
      </div>
      </nav>
    </header>

  <section id="main">
    <article id="login">
      <?php
        if(!empty($_SESSION["login_error"]))
        {
          echo "<font color='red'><b>" . $_SESSION["login_error"] . "</b></font>";
          unset($_SESSION["login_error"]);
        }
      ?>
      <div class="dark">
        <h3>Log In</h3>
          <form class="log_in" method="post" action="checkLogin.php">
          <div>
            <label>Username</label><br>
            <input type="text" placeholder="Username" name="name" required autofocus>
          </div>
          <div>
            <label>Password</label><br>
            <input type="password" placeholder="Password" name="password" required>
          </div>
          <br>
          <button class="button1" type="submit">Log In</button>
        </form>
      </div>
    </article>

      <article id="signup">
        <div class="dark">
          <h3>Sign Up</h3>
          <form class="sign_up" method="post" action="sendVerification.php">
            <div>
              <label>Email</label><br>
              <input type="email" placeholder="Email" name="email" required>
            </div>
            <div>
              <label>Username</label><br>
              <input type="text" placeholder="Username" name="name" required>
            </div>
            <div>
              <label>Password</label><br>
              <input type="password" placeholder="Password" name="password" required>
            </div>
            <div>
              <label>Confirm Password</label><br>
              <input type="password" placeholder="Confirm Password" name="passConfirm" required>
            </div>
            <br>
            <button class="button1" type="submit"><!-- <a href="logged_in_homepage.html">Sign Up</a>-->Sign Up</button>
          </form>
        </div>
      </article>
    </section>

<div style="clear: both"></div>
<footer>
  <p>Peer Library, Copyright &copy; 2017</p>
</footer>


  </body>
</html>
