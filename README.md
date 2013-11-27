coen161_final file descriptions
================================

YOU MUST BE LOGGED IN AS ROOT TO CONNECT TO SQL SERVER!

/images: Where all the image files for the website are located.

mystyles.css: Self-explanatory. All of the CSS for the website.

javascript.js: Also, self-explanatory. All of the JavaScript for the website.

index.html: Main page for kidzcamp website.

init.sql: Run to set up the kidzcamp database for the first time. Will create database kidzcamp and all necessary tables, as well as populate the tables with test cases. To run, type "mysql -h localhost -u root < init.sql".

login.php: A php script that handles logging in. Passes on the form results to check.php.

check.php: Find a user with given username and password in the user table and return it as an array. Start a new session for that user. 

checkForUsername.php: To be used with AJAX. If a username (supplied in $_POST) is already in the user table, return F. Otherwise, return T.
