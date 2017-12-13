<?php
	include_once("libraries".DIRECTORY_SEPARATOR."constants.php");

	//Handles user logins and password checking
	class db_connection
	{ //connection to the database
		private $db_server; //name of the server we are connecting to
		private $db_username; //username of the user account that connects to the database
		private $db_password; //password for that user account to connect
		private $db_name; //name of the specific database to which we are connecting
		
		private $conn; //active mysql connection; SQL queries are sent here and it returns results
		
		private $logged_in; //status of the website user; updates when logging in with username/password match
		private $valid_username;


		/*	(public) function __construct()

			Parameters: none

			Sets default values in order to log in to the database; these will work for both localhosting and altervista.
		*/
		function __construct() //NOTE: constructors in PHP have two underscores and not just one
		{
			$this->db_server = DB_SERVER;
			$this->db_username = DB_USERNAME;
			$this->db_password = DB_PASSWORD;
			$this->db_name = DB_NAME;
			$this->logged_in = false;
		}


		/*	public function check_user_credentials($username, $password)

			Parameters: &$username (string) - gets $_POST'd upon a user logging into the main landing page
							becomes the username from table if it is passed as the e-mail address
						$password (string) - same as $username

			Creates a connection to the database server using the "cbspl" username on the "localhost" server. There is no password; this may be unsecure, but should be okay for our current purposes.
			Changes the default database to "my_cbspl" after connecting, 
		*/
		public function check_user_credentials(&$username, $password)
		{
			//Create connection to database
			$this->conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);

			//Return name of current default database
			$result = $this->conn->query("SELECT DATABASE()");

			if ($result->num_rows > 0) {
				$row = $result->fetch_row();
				$result->close();
			}

			$valid_user = $this->login($username, $password);

			return $valid_user;
		}


    
		public function login_db()
		{
			$this->conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);
		}


		public function logout_db()
		{
			$this->conn->close();
		}


		public function query_db($sql)
		{
			return $this->conn->query($sql);
		}



		/*	private function list_all_users()

			Parameters: none

			Runs a SQL statement that selects all (*) of the users from the pl_user table. Then parses the results one row at a time and prints the corresponding information with its rows. Note that the $row["attribute"] columns headers are case-sensitive and must match with the specific tables of the database.
		*/
		private function list_all_users()
		{
			echo "Listing all users... <br>";

			$sql = "SELECT * FROM pl_User";
			$result = $this->conn->query($sql);

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					echo "User: " . $row["Username"] . " Email: " . $row["Email"] . " Password: " . $row["Password"] . " Last Login Date: " . $row["LastLoginDate"] . "<br>";
				}
			}
			else
				echo "There are 0 results. " . $this->conn->error . "<br>";

			echo "<br><hr><br>";
		}


		/*	private function login($username, $password)
			
			Parameters:
				&$username (string) - passed in from the main check_user_credentials(...) method, which had $username and $password input from the HTML form on the login page and $_POST'ed through
					gets changed to username from table if it is passed as the e-mail address
				$password (string) - same as $username
			
			Login to the database with the $username and $password. SQL statement checks the database for a specific match. Assuming there is only one case where the $username and $password match, since username is a primary key to the pl_user table (therefore, is unique across all usernames), then return true for the $password_match. When password is matched, set $logged_in flag to true.
		*/
		private function login(&$username, $password)
		{
			// Initialize variables
			$tempname = $this->conn->real_escape_string($username);
			$tempname = '\''.$tempname.'\'';
			$user_found = false;
			$row;

			//Run SQL query that checks for username
			$sql = "SELECT * FROM pl_user WHERE Username = $tempname";
			$result = $this->conn->query($sql);

			//If there are any results, username was found
			if($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$user_found = true;
			}
			else // username was not found
			{
				// Run SQL query that checks for e-mail address
				$sql = "SELECT * FROM pl_user WHERE EmailReal = $tempname";
				$result = $this->conn->query($sql);

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$username = $row["Username"]; // change username to actual username
					$user_found = true;
				}
			}

			//On a password match, update the logged_in flag and user_login_date
			if($user_found == true)
			{
				// check password
				if(password_verify($password, $row["Password"]) && $row["Verified"] == true) {
					$this->set_logged_in(true);
					$this->update_user_login_date($username);
					$this->valid_username = $username;
					return true;
				}
			}
			else // no match
				return false;
		} //end of login()


		private function set_logged_in($value)
		{
			$this->logged_in = $value;
		}


		public function get_logged_in()
		{
			return $this->logged_in;
		}
 

		private function update_user_login_date($username)
		{
			//Find previous last login date and print it
			$sql = "SELECT `LastLoginDate` FROM `pl_user` WHERE `Username` = '" . $username ."'";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_row();
			//	printf("Last Login Date was: %s", $row[0]);
				$result->close();
			}
			//else
			//	echo "Error printing last_login_date!<br>";

			//Run SQL query that will update the user's current last_login_date to today's date
			$sql = "UPDATE `my_cbspl`.`pl_User` SET `LastLoginDate` = CURRENT_DATE() WHERE `pl_User`.`Username` = '" . $username . "'";
			$this->conn->query($sql);
		}

	    //$_SESSION["user_anon_email"] = $db_conn->getUserAnonEmail($_SESSION["user"]);
	    public function get_user_anon_email($user)
		{
			$this->login_db();
			$sql = "SELECT `EmailAnon` FROM `pl_user` WHERE `Username` = '" . $user . "'";
			//echo $sql;

			$result = $this->query_db($sql);
			if(empty($result->num_rows))
			{
				echo "No anon email for user: " . $user . "<br>\n";
				echo $result->errno . "\n";
				echo $result->error . "\n";
			}
			else{
				$row = $result->fetch_row();
				return $row[0];
			}
		}


		public function list_my_books($output_num = 0, $user_anon_email)
		{
			$this->conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);
			$sql = "SELECT `ISBN_10_Added`,`Condition`,`Cost`,`SellType` FROM `pl_adds` WHERE Username = '" . $this->valid_username . "'";

			$result = $this->conn->query($sql);

			if(empty($result->num_rows)) //there were no results in the SQL query
			{
				//echo "No rows in result.<br>";
				echo "You haven't added any books yet... <br>Help other students save money by <a href='addBook.php'>Adding a Book</a> now!</p>";
				echo "</article>";
			}
			else if($result->num_rows > 0) //there are books posted by this user
			{
				$bFirstBook = true; //passed to properly output HTML on first book listing

				//if no output number is specifed for how many books to print, set output to total books
				//this happens in the Book Nook
				if($output_num == 0)
				{
					$output_num = $result->num_rows;
					if($output_num == 1)
						echo "You have one book posted!<br><br>";
					else
						echo "You have " . $output_num . " books posted!<br><br>";
				}
				else //calling page specifies how many books to output; output is > 0 here
				{
					if($output_num > $result->num_rows)
						$output_num = $result->num_rows;

					if($output_num == 1) //singular printing; special grammar
					{
						echo "Here is your most recent book posting!<br><br>";
					}
					else //calling pages is printing more than one; check for total books
					{
						echo "Here are your " . $output_num . " most recent book postings!<br><br>";
					}
				}

				//now that total books needed to output has been determined, parse their info and print them
				for($i = 0; $i < $output_num; $i++)
				{
					if($row = $result->fetch_array())
					{
						$book = new Book;

						$this->getBookInfo($row, $book);

						$this->HTMLforNookEntry($book, $bFirstBook, $user_anon_email);

						if($bFirstBook)
							$bFirstBook = false;
					}
				}
			}
			else
				echo "Whoops! Barney error! Email the <a href='mailto:admin@peer-library.com'>admin@peer-library.com</a>.<br>";
		} //end of list_my_books()


		private function getBookInfo(&$row, &$book)
		{
			$book->isbn10 = $row["ISBN_10_Added"];
			$book->condition = $row["Condition"];
			$book->sellType = $row["SellType"];

			if($book->sellType == 3)
				$book->cost = $row["Cost"];
			else
				$book->cost = "FREE!";

			$this->getBookTitle($book);
		}

		private function getBookTitle(&$book) //different table has to be accessed for title
		{
			$this->conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);
			$sql = "SELECT `Title` FROM `pl_book` WHERE ISBN_10 = '" . $book->isbn10 . "'";

			$result = $this->conn->query($sql);
			$row = $result->fetch_assoc();
			$book->title = $row['Title'];
		}


		private function HTMLforNookEntry($book, $firstBook = true, $ownersAnonEmail)
		{
			if(!$firstBook) //if this is not the first book, create new article tag
				echo "<article id=\"main-col2\">\n";
			else //otherwise the book info is already inside an article HTML tag
				$firstBook = false;
			echo "<div><a href='bookinformation.php?isbn=" . $book->isbn10 . "&owner=" . $ownersAnonEmail . "'><img width=70 src='./images/covers/" . $book->isbn10 . ".jpg' onerror=\"this.src='./images/covers/nocover.jpg';\" />\n</div>";
			echo "<div class='bookTitle'>\n<u>" . $book->title . "</u></a>\n</div>";
			echo "<div class='bookTitle'>For \n" . $book->cost . " in " . $book->condition . " condition</div>";
			echo "</article>\n";
		}


		public function add_book_to_nook($isbn, $title, $author, $condition, $gbsVal, $cost)
		{
			$this->login_db();

			$sql = "SELECT * FROM `pl_book` WHERE `ISBN_10` = '" . $isbn . "' ";

			$result = $this->query_db($sql);

			if($result->num_rows > 0)
				//book is already in the table;
				echo "numrows: " . $result->num_rows;
			else{
				//add book to pl_book
				echo $this->conn->error;
				$sql = "INSERT INTO pl_book (ISBN_10, TITLE, AUTHOR) VALUES ('$isbn', '$title', '$author')";

				if($this->query_db($sql))
					echo "Adding book to nook...<br>";
				else{
					echo "Unable to add to nook...";
					return $this->conn->error;
				}

			}

			$result->close();

			//then add book to pl_adds table with username

			$sql = "INSERT INTO `pl_adds` (`Username`, `ISBN_10_Added`, `Condition`, `Cost`, `SellType`) VALUES ('". $this->valid_username . "', '" . $isbn . "', '". $condition . "', '" . $cost . "', '" . $gbsVal . "')";
			
			//echo $sql . "<br>";

			if($this->conn->query($sql) === TRUE)
			{
				return ADD_BOOK_SUCCESSFUL; //book successfully added for user
			}
			else
			{
				echo $this->conn->errno . "<br>";
				echo $this->conn->error . "<br>";

				//Possible errors: https://dev.mysql.com/doc/refman/5.5/en/error-messages-server.html
				return $this->conn->errno;
			}
		} //end of add_book_to_nook()

		public function update_book_in_nook(Book $book, $username)
		{
			$this->login_db();

			$sql = "UPDATE `pl_adds` SET `Condition` = '" . $book->condition . "', `Cost` = " . $book->cost . ", `SellType` = " . $book->sellType . ", Description = '" . $book->description . "' WHERE `pl_adds`.`Username` = '" . $username . "' AND `pl_adds`.`ISBN_10_Added` = " . $book->isbn10;
			
			//echo $sql . "<br>";

			if($this->conn->query($sql) === TRUE)
			{
				return true; //book successfully added for user
			}
			else
			{
				echo $this->conn->error . "<br>";

				//Possible errors: https://dev.mysql.com/doc/refman/5.5/en/error-messages-server.html
				return false;
			}
		}


		/*	Passed in parameter, $book, should have its ISBN already as part of the class.
			The function uses this existing ISBN and Username to grab their posted book's information.
		*/
		public function fillBookInfo(&$book)
		{
			$this->login_db();

			$sql = "SELECT Username FROM pl_User WHERE EmailAnon = '" . $book->ownersAnonEmail . "'";
			$result = $this->query_db($sql);

			$row = $result->fetch_array();
			$username = $row[0];

			$sql = "SELECT * FROM pl_adds WHERE Username = '" . $username . "' AND ISBN_10_Added = '" . $book->isbn10 . "'";
			$result = $this->query_db($sql);

			if($result->num_rows > 0) //this SHOULD happen since the user is clicking a book they have currently listed
			{
				$row = $result->fetch_assoc();
				$book->condition = $row["Condition"];
				$book->sellType = $row["SellType"];
				$book->cost = $row["Cost"];
				$book->description = $row["Description"];
			}
			//else condition? book was removed on a separate tab while user was editing this book?

			//title must be retrieved from the pl_book table since it is not stored in the pl_adds table (3rd normal form rule)
			$sql = "SELECT * FROM pl_book WHERE ISBN_10 = '" . $book->isbn10 . "'";
			$result = $this->conn->query($sql);

			if($result->num_rows > 0) //this SHOULD happen since the user is clicking a book they have currently listed
			{
				$row = $result->fetch_assoc();
				$book->title = $row["TITLE"];
			}
		} //end of fillBookInfo


		public function delete_book($book, $user)
		{
			$this->login_db();

			$sql = "DELETE FROM pl_adds WHERE ISBN_10_Added = " . $book->isbn10 . " AND Username = '" . $user . "'";
			
			if($this->query_db($sql) === TRUE)
				return true;
			else
				return false;
		}


		public function search($isbn)
		{
			$this->login_db();

	        $sql = "SELECT * FROM pl_adds WHERE ISBN_10_Added = '$isbn'";
	        //echo $sql;

	        $result = $this->query_db($sql);

	        if ($result->num_rows > 0) {
	            // output data of each row
				for($i = 0; $i < $result->num_rows; $i++)
				{
					if($row = $result->fetch_array())
					{
						$book = new Book;

						$this->getBookInfo($row, $book);
						$user_anon_email = $this->get_user_anon_email($row['Username']);
						$this->HTMLforNookEntry($book, false, $user_anon_email);
					}
				}
	        }
	        else
	            echo "There were no matches for ". $isbn ."...<br>";

		} //end of class db_connection
	}


	class Book
	{
		public $isbn10;
		public $title;
		public $condition;
		public $sellType;
		public $cost;
		public $description;
		public $ownersAnonEmail;

		public function printBookInfo()
		{
			echo "ISBN-10: " . $this->isbn10 . "<br>
			TITLE: " . $this->title . "<br>
			CONDITION: " . $this->condition ."<br>
			SELL TYPE: " . $this->sellType ."<br>
			COST: " . $this->cost . "<br>";
		}
	}

?>
