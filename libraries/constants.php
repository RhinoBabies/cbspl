<?php

	// WEBSITE INFORMATION
	define("SITE_URL", "localhost/cbspl");
	define("EMAIL_DOMAIN", "peer-library.com");

	// DATABASE INFORMATION
	define("DB_SERVER", "localhost");
	define("DB_USERNAME", "cbspl");
	define("DB_PASSWORD", "");
	define("DB_NAME", "my_cbspl");

	// REGULAR EXPRESSIONS
	define("REGEX_EMAIL", "/^([a-zA-Z]|_)([a-zA-Z0-9]|_|-){0,18}(@cougars.csusm.edu)$/");
	define("REGEX_USERNAME", "/^([a-zA-Z]|_)([a-zA-Z0-9]|_){2,14}$/");

	// ADD BOOK ERROR CODES
	define("ADD_BOOK_SUCCESSFUL", 0);
	define("ADD_BOOK_DUP_ENTRY", 1062);
	define("ADD_BOOK_FAIL", -1);

?>
