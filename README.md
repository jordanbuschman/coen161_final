coen161_final file descriptions
================================

YOU MUST BE LOGGED IN AS ROOT TO CONNECT TO SQL SERVER!

/images: Where all the image files for the website are located

init.sql: Run to set up the kidzcamp database for the first time. Will create database kidzcamp and all necessary tables, as well as populate the tables with test cases. To run, type "mysql -h localhost -u root < init.sql".

login.php: A php script that handles logging in. Passes on the form results to check.php.

check.php: Checks whether or not login data is valid. 

checkForUsername.php: To be used with AJAX. If a username (supplied in $_POST) is already in the user table, return F. Otherwise, return T.
