# cbspl

### XAMPP local hosting of the PeerLibrary website.

#### These must be done only the first time a user pulls the repo in order to prepare the database and their repo for automagicks.

NOTE: Ensure the XAMPP control panel is active and at least Apache and MySQL services are running to open the localhost/phpMyAdmin service.

1) cbspl user must be created in phpMyAdmin. localhost, no password, all privileges.
2) my_cbspl database will have to be manually created.
3) Manually run contents of post-merge:
    c:/xampp/mysql/bin/mysql -u cbspl my_cbspl < C:/xampp/htdocs/cbspl/my_cbspl.sql
   
4) Before making any additional commits, run the copyHooks script or manually copy the pre-commit and post-merge hooks into your local .git/hooks folder for auto-updates of your SQL database. Please note that the MySQL commands will not work if the service is not running in XAMPP.
