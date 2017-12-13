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

  //Get the book's information
  $book = new Book;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $modifying = true; //did the user click the "Modify Listing" button?
    $book = $_SESSION["book"]; //get the book information from the session variable
    //unset($_SESSION["book"]);
  }
  else { //when page is first loaded, user is not yet modifying
    $modifying = false;
    $book->isbn10 = $_REQUEST["isbn"]; //grab ISBN back down from URL
    $book->ownersAnonEmail = $_REQUEST["owner"]; //grab owner's anon email from URL
    $db_conn->fillBookInfo($book); //get remainder of book's information
    $_SESSION["book"] = $book;
  }

  if($book->ownersAnonEmail === $_SESSION["user_anon_email"])
    $ownsBook = true; //allow modifications
  else
    $ownsBook = false; //show contact owner button
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
        <h1><?php if($ownsBook) echo "Your ";?>Book Information</h1>
          <div class="image">
            <img width=40% src="./images/money.png">
          </div>
          <?php
            $book->printBookInfo();
          ?>
          <div class="information">
            <?php
              if($ownsBook && $modifying) {
                  echo '<form action="./updateBook.php" method="post">';
              }
            ?>
            <div>
              <label>ISBN-10</label><br>
              <input type="text" placeholder="ISBN-10" value="<?php echo $book->isbn10;?>" disabled>
              <input type="hidden" placeholder="ISBN-10" name="isbn10" value="<?php echo $book->isbn10;?>">
            </div>
            <div>
              <label>Title</label><br>
              <input type="text" placeholder="Title" value="<?php echo $book->title;?>" disabled>
              <input type="hidden" placeholder="Title" name="title" value="<?php echo $book->title;?>">
            </div>
            <div>
              <label>Description</label><br>
              <textarea style="font-family: Arial; font-size: 12px" rows="2" cols="25" placeholder="Description" name="description" <?php if(!$modifying) echo "disabled";?> maxlength="300"><?php echo $book->description;?></textarea>
            </div>
            <label>Condition</label><br>
            <div class="select">
              <select name="condition" <?php if(!$modifying) { echo 'style="cursor: default" '; echo 'disabled'; } ?>>
                <option value="Like New" <?php if($book->condition == "Like New") echo "selected";?>>Like New</option>
                <option value="Lightly Used" <?php if($book->condition == "Lightly Used") echo "selected";?>>Lightly Used</option>
                <option value="Well Used" <?php if($book->condition == "Well Used") echo "selected";?>>Well Used</option>
                <option value="Poor" <?php if($book->condition == "Poor") echo "selected";?>>Poor</option>
              </select>
            </div>
            <label>Selling Option</label><br>
            <div class="select">
              <select name="gbs" <?php if(!$modifying) { echo 'style="cursor: default" '; echo "disabled"; } ?>>
                <option value="Give" <?php if($book->sellType == 1) echo "selected";?>>Give</option>
                <option value="Barter" <?php if($book->sellType == 2) echo "selected";?>>Barter</option>
                <option value="Sell" <?php if($book->sellType == 3) echo "selected";?>>Sell</option>
              </select>
            </div>
            <div>
              <label>Cost</label><br>
              <input type="number" placeholder="$0.00" name="cost" maxlength="3" min="0" max="300" value="<?php echo $book->cost; ?>" <?php if(!$modifying) echo "disabled";?>>
            </div>
              <?php
                if($ownsBook){
                  echo "<div>";
                  if($modifying)
                    {
                      echo '<button class="button1">Save Changes</button></form>';
                    }
                  else{
                    echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post"><button class="button1">Modify Listing</button></form>' . "\n";
                    echo '<form action="./confirmRemoval.php" method="get" style="float:right"><button class="button2">Remove This Listing</button></form>';
                  }
                  echo "</div>";
                }
                else //this book is another user's, display Contact Owner button
                  echo "<div class='add'>\n<button class='button1'>Contact Owner</button>\n</div>";
              ?>
          </div>
        </div>
      </section>


    <div style="clear: both"></div>
    <footer>
      <p>Peer Library, Copyright &copy; 2017</p>
    </footer>

  </body>
</html>
