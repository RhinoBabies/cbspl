<?php
  include("class_lib.php");
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

  //Get the book's information
  $book = new Book;
  $book->isbn10 = $_REQUEST["b"]; //grab ISBN back down from URL
  $db_conn->fillBookInfo($book, $_SESSION["user"]); //get remainder of book's information
  
  if(empty($_SESSION["modifyBook"]))
    $modifying = false; //did the user click the "Modify Listing" button?
  else
    $modifying = true;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Easier way to trade and sell textbooks">
    <meta name="keywords" content="web seller, affordable textbooks, peer-to-peer selling">
    <meta name="author" content="Cookie Barney Software">
    <title>Peer Library | Book Information </title>
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
      </nav>
    </div>
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

    <section id="information">
      <div class="container">
        <h1>Book Information</h1>
          <div class="image">
            <img src="./images/money.png">
          </div>
          <div class="information">
            <div>
              <label>Title</label><br>
              <input type="text" placeholder="Title" value="<?php echo $book->title;?>" <?php if(!$modifying) echo "disabled";?>>
            </div>
            <div>
              <label>Description</label><br>
              <textarea rows="2" cols="25" placeholder="Description" <?php if(!$modifying) echo "disabled";?>></textarea>
            </div>
            <div>
              <label>Condition</label><br>
              <input type="text" placeholder="Condition" value="<?php echo $book->condition; ?>" <?php if(!$modifying) echo "disabled";?>>
            </div>
            <div>
              <label>Selling Option</label><br>
              <input type="text" placeholder="Selling Option" value="<?php echo $book->sellType; ?>" <?php if(!$modifying) echo "disabled";?>>
            </div>
            <?php
            //if: this book is this user's, display Modify and Remove buttons
            ?>
            <div>
              <?php
                if($modifying)
                  {
                    echo '<button class="button1">Save Changes</button>';
                  }
                else echo '<form action="" method="post"><button class="button1">Modify Listing</button></form>';
              ?>
              <button class="button2">Remove This Listing</button>
            </div>
            <?php
            //else: this book is another user's, display Contact Owner button
            ?>
            <div class="add">
              <button class="button1">Contact Owner</button>
            </div>
          </div>
        </div>
        </section>


    <div style="clear: both"></div>
    <footer>
      <p>Peer Library, Copyright &copy; 2017</p>
    </footer>

  </body>
</html>
