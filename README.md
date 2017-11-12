# cbspl

### XAMPP local hosting of the PeerLibrary website.

#### These must be done only the first time a user pulls the repo in order to prepare the database and their repo for automagicks.

NOTE: Ensure the XAMPP control panel is active and at least Apache and MySQL services are running to open the localhost/phpMyAdmin service.
NOTE: Please note that the MySQL commands will not work if the service is not running in XAMPP.


Instructions for Windows:
1) Add user to phpMyAdmin.
	1a) Load browser, go to localhost/phpMyAdmin.
	1b) On top bar, click: User accounts
	1c) Click: Add user account
	1d) In User name field enter: cbspl
	1e) In Host name dropdown, select: Local
	1f) In Password dropdown, select: No password
	1g) In Global Privileges area, click the checkbox: Check all
	1h) At bottom right corner of page, click the button: Go

2) Add database to phpMyAdmin.
	2a) At localhost/phpMyAdmin, click New at the top of the hierarchy on the left sidebar.
	2b) In database name field, enter: my_cbspl
	2c) To the right, click: Create

3) Manually run contents of post-merge in command prompt.
	3a) Open Command Prompt
	3b) Run the following command:
		c:/xampp/mysql/bin/mysql -u cbspl my_cbspl < C:/xampp/htdocs/cbspl/my_cbspl.sql
   
4) Run copyHooks.wsf by double-clicking it.
	Or manually copy the pre-commit and post-merge hooks into your local .git/hooks folder.

