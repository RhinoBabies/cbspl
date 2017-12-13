<?php
  include_once("class_lib.php");
  include_once("libraries".DIRECTORY_SEPARATOR."constants.php");
  session_start();
  
  //checks that user was logged in; if not, sends back to log in page
  if(empty($_SESSION["user"]))
  {
    $_SESSION["login_error"] = "You must be logged in to view that page.<br>";
    header("Location: ./log_in.php");
  }

  $db_conn = $_SESSION["db_conn"]; //recall the db_connection that was setup on login

  //Check for valid input from form
  $modifying = false;
  $updateBookError = false;
  $isbn10 = $title = $condition = $gbs = $description = "";
  $cost = 0;
  $conditionError = $gbsError = $descError = $sellCostError = "";

  //if this page was just POST'ed through HTTP and reaccessing itself, check all the inputs from the form for validity
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //unchanged fields don't have to be tested for improper input
    $isbn10 = $_POST["isbn10"];
    $title = $_POST["title"];

    if(isset($_POST["description"]))
      $description = test_input($_POST["description"]);

    if(isset($_POST["condition"]) && $_POST["condition"] != "None")
      $condition = test_input($_POST["condition"]);
    else {
      $conditionError = "Condition is a required field.";
      $updateBookError = true;
    }

    if(!empty($_POST["gbs"])) {
      $gbs = test_input($_POST["gbs"]);

      switch($gbs) {
        case "Give" :
          //incentive for users to give their book away for free?
          //make the user verify that they are just giving their book away?
          $cost = 0;
          $gbsVal = 1;
          break;
        case "Barter" :
          $cost = 0;
          $gbsVal = 2;
          if(empty($description))
          {
            $descError = "If you're bartering for something, describe what you're looking for in the description text box.";
            $updateBookError = true;
          }
          break;
        case "Sell" :
          $gbsVal = 3;
          if(empty($_POST["cost"]) || $_POST["cost"] == 0) {
            $sellCostError = "If you're selling your book, you need to set a minimum accepted price.";
            $updateBookError = true;
          }
          else
            $cost = $_POST["cost"];
          break;
        case "None" :
        default :
          $gbsError = "Please select whether you would like to Give, Barter, or Sell your book.";
          $updateBookError = true;
      }
    }

    //echo $isbn10 . $condition . $gbs . $cost . "<br>";
  }


  //trim extra characters, strip backslashes, and convert to HTML character represenation for an input string
  function test_input($data)
  {
    $data = trim($data); //strip unnecessary characters
    $data = stripslashes($data); //remove backslashes
    $data = htmlspecialchars($data); //puts any special characters into their HTML representation (&nbsp;)
    return $data;
  }

  function setBookInfo(Book &$book, $isbn, $condition, $gbs, $description, $cost)
  {
    $book->isbn10 = $isbn;
    $book->condition = $condition;
    $book->sellType = $gbs;
    $book->description = $description;
    $book->cost = $cost;
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
    <title>Peer Library | Update Listing</title>
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
        <h1>Update Book Information</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "GET"){
            $_SESSION["error"] = "The information on this page is no longer pertinent.
              Please use the links at the top of the page or click the button below to find your way again!<br>";
            header("Location: ./error.php");
          }

          if(empty($_SESSION["book"]))
          {
            $_SESSION["error"] = "There was an error updating your book. Please try again!<br>";
            header('Location: error.php');
          }

          $book = $_SESSION["book"];
          setBookInfo($book, $isbn10, $condition, $gbsVal, $description, $cost);
          //$book->printBookInfo();

          if($_SERVER["REQUEST_METHOD"] == "POST" && !$updateBookError)
          {
            $bookUpdated = $db_conn->update_book_in_nook($book, $_SESSION["user"]);

            if($bookUpdated)
            {
              echo "Your book's information is now updated!  <form action='./booknook.php'><button class='button1'>Back to Your Nook</button></form><br>";
              unset($_SESSION["book"]);
            }
            else
            {
              echo "There was an error updating the book information...<br>";            
              $modifying = true; //if there was an error with updating, user will try again
            }
          }

          if($updateBookError)
          {
            echo "<font color='red'>There is an error in the information you submitted. Please see the warnings in the form.</font>";
            $modifying = true;
          }
        ?>
        <div class="information">
          <?php
            if($modifying) {
                echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
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
            <?php if(!empty($descError)) echo "<font color='red'><b>" . $descError . "</b></font><br>"; ?>
            <textarea style="font-family: Arial; font-size: 12px" rows="2" cols="25" placeholder="Description" name="description" <?php if(!$modifying) echo "disabled";?> maxlength="300"><?php echo $book->description;?></textarea>
          </div>
          <label>Condition</label><br>
          <div class="select">
            <select name="condition" <?php if(!$modifying) { echo 'style="cursor: default"'; echo 'disabled'; } ?>>
              <option value="Like New" <?php if($book->condition == "Like New") echo "selected";?>>Like New</option>
              <option value="Lightly Used" <?php if($book->condition == "Lightly Used") echo "selected";?>>Lightly Used</option>
              <option value="Well Used" <?php if($book->condition == "Well Used") echo "selected";?>>Well Used</option>
              <option value="Poor" <?php if($book->condition == "Poor") echo "selected";?>>Poor</option>
            </select>
          </div>
          <label>Selling Option</label><br>
          <div class="select">
            <select name="gbs" <?php if(!$modifying) { echo 'style="cursor: default"'; echo "disabled"; } ?>>
              <option value="Give" <?php if($book->sellType == 1) echo "selected";?>>Give</option>
              <option value="Barter" <?php if($book->sellType == 2) echo "selected";?>>Barter</option>
              <option value="Sell" <?php if($book->sellType == 3) echo "selected";?>>Sell</option>
            </select>
          </div>
          <div>
            <label>Cost</label><br><?php if(!empty($sellCostError)) echo "<font color='red'><b>" . $sellCostError . "</b></font><br>";?>
            <input type="number" placeholder="0.00" name="cost" maxlength="3" min="0" max="300" value="<?php echo $book->cost; ?>" <?php if(!$modifying) echo "disabled";?>>
          </div>
          <?php
            if($modifying)
              echo '<button class="button1">Save Changes</button></form>';
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
