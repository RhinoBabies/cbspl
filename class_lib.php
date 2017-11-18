<?php
	//Handles user logins and password checking
	class db_connection
	{ //connection to the database
		private $db_server; //name of the server we are connecting to
		private $db_username; //username of the user account that connects to the database
		private $db_password; //password for that user account to connect
		private $db_name; //name of the specific database to which we are connecting
		
		private $conn; //active mysql connection; SQL queries are sent here and return results
		
		private $logged_in; //status of the website user; updates when logging in with username/password match


		/*	(public) function __construct()

			Parameters: none

			Sets default values in order to log in to the database; these will work for both localhosting and altervista.
		*/
		function __construct() //NOTE: constructors in PHP have two underscores and not just one
		{
			$this->db_server = "localhost";
			$this->db_username = "cbspl";
			$this->db_password = "";
			$this->db_name = "my_cbspl";
			$this->logged_in = false;
		}


		/*	public function check_user_credentials($username, $password)

			Parameters: $username (string) - gets $_POST'd upon a user logging into the main landing page
						$password (string) - same as $username

			Creates a connection to the database server using the "cbspl" username on the "localhost" server. There is no password; this may be unsecure, but should be okay for our current purposes.
			Changes the default database to "my_cbspl" after connecting, 
		*/
		public function check_user_credentials($username, $password)
		{
			//Create connection to database
			$this->conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);

			//Return name of current default database
			$result = $this->conn->query("SELECT DATABASE()");

			if ($result->num_rows > 0) {
				$row = $result->fetch_row();
				//printf("Default database is %s.\n<br>", $row[0]);
				$result->close();
			}
			//else
			//	echo "Did not connect to any database...<br>";

			//echo "<br><hr><br>";


			//$this->list_all_users();

			$valid_user = $this->login($username, $password);

			$this->conn->close();

			return $valid_user;
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
				$username (string) - passed in from the main check_user_credentials(...) method, which had $username and $password input from the HTML form on the login page and $_POST'ed through
				$password (string) - same as $username
			
			Login to the database with the $username and $password. SQL statement checks the database for a specific match. Assuming there is only one case where the $username and $password match, since username is a primary key to the pl_user table (therefore, is unique across all usernames), then return true for the $password_match. When password is matched, set $logged_in flag to true.
		*/
		private function login($username, $password)
		{
			$password_match = false;
			//echo "Trying to login with " . $username . " and " . $password . "...<br>";

			//Run SQL query that checks username against password
			$sql = "SELECT * FROM pl_User WHERE Username = \"" . $username . "\" AND Password = \"" . $password . "\"";
			$result = $this->conn->query($sql);

			//If there are any results, password was matched
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$password_match = true;
				}
			}
			else
			{
				//echo "There was an error with the username and/or password.<br>";
				return false;
			}

			//On a password match, update the logged_in flag and user_login_date
			if($password_match == true)
			{
				//echo "Matched " . $row["Username"] . "<br>";
				$this->set_logged_in(true);
				$this->update_user_login_date($username);
				return true;
			}
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

	} //end of class db_connection
?>
