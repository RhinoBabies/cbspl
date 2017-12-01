<?php
  include("class_lib.php"); 
  session_start();
  
  //checks that user was logged in; if not, sends back to log in page
  if(empty($_SESSION["user"]))
  {
    $_SESSION["login_error"] = "You must be logged in to view that page.<br>";
    header("Location: ./log_in.php");
  }

  $db_conn = $_SESSION["db_conn"]; //recall the db_connection that was setup on login

  //Check for valid input from form
  $addBookError = false;
  $isbn10 = $isbn13 = $title = $author = $condition = $gbs = "";
  $isbn10Error = $titleError = $authorError = $conditionError = $gbsError = "";

  //if this page was just POST'ed through HTTP and reaccessing itself, check all the inputs from the form for validity
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST["isbn10"]))
      $isbn10 = test_input($_POST["isbn10"]);
    else
      $isbn10Error = "ISBN-10 is a required field.";

    if(!empty($_POST["$isbn13"]))
      $isbn13 = test_input($_POST["isbn13"]);

    if(!empty($_POST["title"]))
      $title = test_input($_POST["title"]);
    else
      $titleError = "Title is a required field.";

    if(!empty($_POST["author"]))
      $author = test_input($_POST["author"]);
    else
      $authorError = "Author is a required field.";

    if(!empty($_POST["condition"]) && $_POST["condition"] != "None")
      $condition = test_input($_POST["condition"]);
    else
    {
      $conditionError = "Condition is a required field.";
      $addBookError = true;
    }

    if(!empty($_POST["gbs"]))
    {
      $gbs = test_input($_POST["gbs"]);
      switch($gbs)
      {
        case "Give" :
          //incentive for users to give their book away for free?
          //make the user verify that they are just giving their book away?
          $cost = NULL;
          $gbsVal = 1;
          break;
        case "Barter" :
          //should the user insert a comment about what types of books/items they're bartering for? or leave it to the other student to make an offer?
          $cost = NULL;
          $gbsVal = 2;
          break;
        case "Sell" :
          $gbsVal = 3;
          if(empty($_POST["cost"]))
          {  $sellCostError = "If you're selling your book, you need to set a minimum accepted price.";
            $addBookError = true;
          }
          else
            $cost = $_POST["cost"];
          break;
        case "None" :
        default :
          $gbsError = "Please select whether you would like to Give, Barter, or Sell your book.";
          $addBookError = true;
      }
    }

    //echo $isbn10 . $title . $author . $condition . $gbs . "<br>";
  }


  //trim extra characters, strip backslashes, and convert to HTML character represenation for an input string
  function test_input($data)
  {
    $data = trim($data); //strip unnecessary characters
    $data = stripslashes($data); //remove backslashes
    $data = htmlspecialchars($data); //puts any special characters into their HTML representation (&nbsp;)
    return $data;
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
    <title>Peer Library | Add a Book </title>
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
        <h1>Add a Book to the Nook</h1>
          <?php
            if($_SERVER["REQUEST_METHOD"] == "POST" && !$addBookError)
            {
              $bookAdded = $db_conn->add_book_to_nook($isbn10, $title, $author, $condition, $gbsVal, $cost);

              if($bookAdded)
                echo "<u>" . $title . "</u> was successfully added to your <a href=\"booknook.php\">Nook</a>!";
              else
                echo "<font color='red'>There was a database error when adding <u>" . $title ."</u> to your Nook. Please be sure to fill out all of the fields correctly.</font>";
            }

            if($addBookError)
              echo "<font color='red'>There is an error in the information you submitted. Please see the warnings in the form.</font>";
          ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="image">
            <input type="file" placeholder="Image file">
          </div>
          <div>
            <pre id="fileDisplayArea"><pre>
          </div>
          <div class="information">
            <div>
              <label>ISBN-10</label><br>
              <input type="text" placeholder="10-digit ISBN" name="isbn10" minlength="10" maxlength="10" required pattern="[0-9]{10}" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST")
                echo $isbn10; ?>">
            </div>
            <div>
              <label>Title</label><br>
              <input type="text" placeholder="Title" name="title" value ="<?php if($_SERVER["REQUEST_METHOD"] == "POST")
                echo $title; ?>" required>
            </div>
            <div>
              <label>Author</label><br>
              <input type="text" placeholder="Author" name="author" value ="<?php if($_SERVER["REQUEST_METHOD"] == "POST")
                echo $author; ?>" required>
            </div>
            <div>
              <label>Description</label><br>
              <textarea rows="2" cols="25" placeholder="Book Description"></textarea>
            </div>
            <div>
              <label>Condition</label><br>
              <?php if(!empty($conditionError)) echo "<font color='red'><b>" . $conditionError . "</b></font>"; ?>
            </div>
            <div class="select">
              <select name="condition">
                <option value="None">None</option>
                <option value="Like New" <?php if($condition == "Like New") echo "selected";?>>Like New</option>
                <option value="Lightly Used" <?php if($condition == "Lightly Used") echo "selected";?>>Lightly Used</option>
                <option value="Well Used" <?php if($condition == "Well Used") echo "selected";?>>Well Used</option>
                <option value="Poor" <?php if($condition == "Poor") echo "selected";?>>Poor</option>
              </select>
            </div>
            <div>
              <label>Selling Option</label><br>
              <?php if(!empty($gbsError)) echo "<font color='red'><b>Please choose an option below.</b></font>"; ?>
            </div>
            <div class="select">
              <select name="gbs">
                <option value="None">None</option>
                <option value="Give" <?php if($gbs == "Give") echo "selected";?>>Give</option>
                <option value="Barter" <?php if($gbs == "Barter") echo "selected";?>>Barter</option>
                <option value="Sell" <?php if($gbs == "Sell") echo "selected";?>>Sell</option>
              </select>
            </div>
            <div>
              <label>Cost</label><br><?php if(!empty($sellCostError)) echo "<font color='red'><b>Need price if selling.</b></font>";?>
              <input type="number" placeholder="$0.00" name="cost" maxlength="3" min="0" max="300">
            </div>
            <div class="add">
              <button class="button1" type="submit">Add to Nook</button>
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
