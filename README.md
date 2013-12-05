coen161_final file descriptions
================================

YOU MUST BE LOGGED IN AS ROOT TO CONNECT TO SQL SERVER!

/images: Where all the image files for the website are located.

mystyles.css: Self-explanatory. All of the CSS for the website.

javascript.js: Also, self-explanatory. All of the JavaScript for the website.

index.php: Homepage for the website. Supports logging in/out and registering.

shop.php: The KidzCamp shop. Lists items available for purchace.

camp.php: Calendar and registration for classes.

init.sql: Run to set up the kidzcamp database for the first time. Will create database kidzcamp and all necessary tables, as well as populate the tables with test cases. To run, type "mysql -h localhost -u root < init.sql".

login.php: A php script that handles logging in. Passes on the form results to check.php.

addUser.php: Add a new user to the user table and starts a session for that user. (Make sure you already know that the fields are valid for entry!)

check.php: Find a user with given username and password in the user table and return it as an array. Start a new session for that user. 

checkForUsername.php: To be used with AJAX. If a username (supplied in $_POST) is already in the user table, return F. Otherwise, return T.

fetchItems.php: Returns an array containing all of the rows in the item table. To be accessed by from shop.php.

addToCart.php: Takes in a user id, item id, and item count to add to a user's cart.

getCartCount.php: Takes in a user id and outputs total items in that user's cart (or 0, if user id is not valid).

fetchCart: Takes in a user id and returns all items in that user's cart, count of those items, and number of items in the cart.
