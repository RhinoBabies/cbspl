<?php
session_start();
?>
<html>
<head>
  <title>PeerLibrary | Add a Book</title>
  <?php include("class_lib.php"); ?>
</head>
<body>

  <div>
    <div><b>Add a Book</b></div>
    <div style="text-align:right;">Welcome back, <?php echo $_SESSION["user"]; ?>!</div>
    <div style="text-align:right;">Your email address is: <?php echo $_SESSION["email"]; ?></div>
    <br><hr>
  </div>

  <?php
    //Check for valid input from form
    $isbn10 = $isbn13 = $title = $author = $condition = $gbs = "";
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
      if(!empty($_POST["condition"]))
        $condition = test_input($_POST["condition"]);
      else
        $conditionError = "Condition is a required field.";
    
      if(!empty($_POST["gbs"]))
      {
        switch($_POST["gbs"])
        {
          case "give" :
            //incentive for users to give their book away for free?
            //make the user verify that they are just giving their book away?
            break;
          case "barter" :
            //should the user insert a comment about what types of books/items they're bartering for? or leave it to the other student to make an offer?
            break;
          case "sell" :
            if(empty($_POST["cost"]))
              $sellCostError = "If you're selling your book, you need to set a minimum accepted price.";
            break;
          default :
            echo "This option is not one of Give, Barter, or Sell." . $_POST["gbs"] . "<br>";
        }
      }
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

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <u>Add this Book to my Nook</u><br><br>
    ISBN-10: <input type="text" name="isbn10" size="10" minlength="10" maxlength="10" required pattern="[0-9]{10}"><br><br>
    ISBN-13: <input type="text" name="isbn13" size="13" minlength="13" maxlength="13" pattern="[0-9]{13}"><br><br>
    Title: <input type="text" name="title" size="30" maxlength="30" required><br><br>
    Author: <input type="text" name="author" size="30" maxlength="30" required><br><br>
    Current condition: (e.g. excellent, great, good, fair, terrible)<br>
    <input type="text" name="condition" size="15" maxlength="15" required><br><br>
    GBS Type:<br><input type="radio" name="gbs" value="give">Give<br>
    <input type="radio" name="gbs" value="barter">Barter<br>
    <input type="radio" name="gbs" value="sell">Sell<br><br>
    Asking Price: <input type="number" name="cost" maxlength="3" min="0" max="300"><br><br>
    <input type="submit" value="Add Book"> <input type="reset" value="Clear Form">
  </form>

</body>
</html>