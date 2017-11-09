<?php
	class user {
		var $username;
		private $email;
		private $password;
		
		function __construct($username, $email, $password) { //notice that constructors have two underscores, not just one
			$this->username = $username;
			$this->email = $email;
			$this->password = $password;
		}
		
		function change_password() {
			$password_match = 0;
			echo "Please enter your old password: ";
			
			for($i = 0; $i < 3; $i++)
			{
				if($old_password == $this->$password)
				{
					echo "Enter your new password: ";
					$password_match = 1;
					break;
				}
				else
					echo "Your old password is not correct. Please try again.";
			}
		}

		public function get_username() {
			return $this->username;
		}
	  }


	//Handles user logins and password checking
	  class db_connection {
		private $db_server;
		private $db_username;
		private $db_password;
		private $db_name;
		private $logged_in;
		
		function __construct() {
			$this->db_server = "localhost";
			$this->db_username = "cbspl";
			$this->db_password = "";
			$this->db_name = "my_cbspl";
		}

		public function check_user_credentials($username, $password)
		{
			// Create connection to database
			$conn = new mysqli($this->db_server, $this->db_username, $this->db_password);

			// Check connection
			if ($conn->connect_error) {
				echo "Killing connection...<br><br>";
				die("Connection failed: " . $conn->connect_error);
			}
			else
				echo "Connected successfully to PeerLibrary database!<br><br>";

			//Set the default database that you want to use
			$conn->query("USE my_cbspl");

			/* return name of current default database */
			$result = $conn->query("SELECT DATABASE()");

			if ($result->num_rows > 0) {
				$row = $result->fetch_row();
				printf("Default database is %s.\n<br>", $row[0]);
				$result->close();
			}
			else
				echo "Did not connect to my_cbspl database...<br><br>";

			$sql = "SELECT * FROM pl_User";
			$result = $conn->query($sql);

			echo "Listing users... <br>";

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					echo "User: " . $row["Username"] . " Email: " . $row["Email"] . " Password: " . $row["Password"] . " Last Login Date: " . $row["LastLoginDate"] . "<br><br>";
				}
			}
			else
				echo "There are 0 results. " . $conn->error . "<br>";

			echo "Trying to login with " . $username . " and " . $password . "...<br>";
			$sql = "SELECT * FROM pl_User WHERE Username = \"" . $username . "\" AND Password = \"" . $password . "\"";
			$result = $conn->query($sql);

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$password_match = true;
				}
			}
			else
				echo "There was an error with the username and/or password.<br>";

			if($password_match == true)
			{
				echo "Matched " . $row["Username"] . "<br>";
				$logged_in = true;
			}

				$conn->close();
			}

			public function add_a_book($isbn, $title, $author)
			{

		}
	}
?>
