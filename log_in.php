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
            <input type="text" placeholder="Username" name="name" maxlength="37" required autofocus>
          </div><br>

          <div>
            <label>Password</label><br>
            <input type="password" placeholder="Password" name="password" maxlength="72" required>
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
              <input type="email" placeholder="Email" name="email"
                <?php
                  if(isset($_SESSION["email_add"]))
                  {
                    echo "value=\"".htmlentities($_SESSION["email_add"])."\"";
                    unset($_SESSION["email_add"]);
                  }
                ?>
                maxlength="37">
              <br><span class="error">
                <?php
                if (isset($_SESSION["email_form"]))
                {
                  echo "* E-mail must be a valid CSUSM student address";
                  unset($_SESSION["email_form"]);
                  unset($_SESSION["email_exists"]);
                }
                else if (isset($_SESSION["email_exists"]))
                {
                  echo "* E-mail already in use";
                  unset($_SESSION["email_exists"]);
                }
                ?>
              </span><br>
            </div>

            <div>
              <label>Username</label><br>
              <input type="text" placeholder="Username" name="name" maxlength="15"
                <?php
                  if(isset($_SESSION["name_add"]))
                  {
                    echo "value=\"".htmlentities($_SESSION["name_add"])."\"";
                    unset($_SESSION["name_add"]);
                  }
                ?>
                required>
              <br><span class="error">
                <?php
                if (isset ($_SESSION["name_form"]))
                {
                  echo "* Username must be 3-15 characters long
                    <br>* Username must contain only letters, numbers, or underscores
                    <br>* Username must not start with a number";
                  unset($_SESSION["name_form"]);
                  unset($_SESSION["name_exists"]);
                  unset($_SESSION["name_avail"]);
                }
                else if (isset($_SESSION["name_exists"]))
                {
                  echo "* Username already in use";
                  unset($_SESSION["name_exists"]);
                  unset($_SESSION["name_avail"]);
                }
                ?>
              </span>
              <span class="success">
                <?php
                if (isset($_SESSION["name_avail"]) && !isset($_SESSION["name_form"]))
                {
                  echo "* Username available";
                  unset($_SESSION["name_avail"]);
                }
                ?>
              </span><br>
            </div>

            <div>
              <label>Password</label><br>
              <input type="password" placeholder="Password" name="password" maxlength="72" required>
            </div><br>

            <div>
              <label>Confirm Password</label><br>
              <input type="password" placeholder="Confirm Password" name="passConfirm" maxlength="72" required>
              <br><span class="error">
                <?php
                if (isset($_SESSION["pass_diff"]))
                {
                  echo "* Passwords do not match";
                  unset($_SESSION["pass_diff"]);
                }
                ?>
              </span><br>
            </div>

            <br>
            <button class="button1" type="submit">Sign Up</button>
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
