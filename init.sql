CREATE DATABASE IF NOT EXISTS kidzcamp;
USE kidzcamp;

DROP TABLE IF EXISTS user, item, cart, enrollment, forum, orderHistory;

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	password VARCHAR(24) NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	lastName VARCHAR(32) NOT NULL,
	didEnroll BOOLEAN DEFAULT 0,
	numEnrolled INT DEFAULT 0,
	PRIMARY KEY (id));
	
CREATE TABLE enrollment (
	id INT NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL,
	childNum INT NOT NULL,
	firstName varchar(32) NOT NULL,
	lastName varchar(32) NOT NULL,
	birth varchar(32) NOT NULL,
	grade INT NOT NULL,
	school VARCHAR(32) NOT NULL,
	sessionNum INT NOT NULL,
	sessionLength INT NOT NULL,
	phone VARCHAR(32) NOT NULL,
	email VARCHAR(32) NOT NULL,
	cost FLOAT NOT NULL,
	cardtype VARCHAR(32) NOT NULL,
	csv INT NOT NULL,
	expiration VARCHAR(32) NOT NULL,
	cardholder VARCHAR(40) NOT NULL,
	cardnumber VARCHAR(16) NOT NULL,
	PRIMARY KEY (id));


CREATE TABLE item (
	id INT NOT NULL AUTO_INCREMENT,
	location VARCHAR(32) NOT NULL,
	name VARCHAR(32) NOT NULL,
	price FLOAT(24, 2) NOT NULL,
	discount INT DEFAULT 0,
	PRIMARY KEY (id));

CREATE TABLE cart (
	id INT NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL, /* Refers to id of user */
	itemId INT NOT NULL, /* Refers to id of item */
	count INT NOT NULL DEFAULT 1,
	PRIMARY KEY (id));
	
CREATE TABLE forum (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	rating INT NOT NULL,
	review VARCHAR(512) NOT NULL,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id));

CREATE TABLE orderHistory (
	id INT NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL,
	total FLOAT(24, 2) NOT NULL,
	cardnumber int NOT NULL,
	CSV INT NOT NULL,
	PRIMARY KEY (id));

INSERT INTO user (username, password, firstName, lastName, didEnroll) VALUES ("jbob93", "potato", "Jim", "Bob", 1);
INSERT INTO user (username, password, firstName, lastName) VALUES ("maryyyyyy32", "myname15Mary", "Mary", "Doe");
INSERT INTO user (username, password, firstName, lastName) VALUES ("josh123", "slimShady", "Josh", "Sims");
INSERT INTO user (username, password, firstName, lastName) VALUES ("hsolo", "starW4rz", "Han", "Solo");
INSERT INTO user (username, password, firstName, lastName) VALUES ("joshBrah", "jbh3ART", "Josh", "Mann");
INSERT INTO user (username, password, firstName, lastName) VALUES ("hKudz", "kudz4Lyfe", "Heywood", "Ukuddleme");
INSERT INTO user (username, password, firstName, lastName) VALUES ("adeartola", "Ioe45682", "Andy", "de Artola");
INSERT INTO user (username, password, firstName, lastName) VALUES ("achung", "asdASD123", "Aaron", "Chung");

INSERT INTO item (location, name, price) VALUES ("mousepad.jpg", "Mouse Pad", 9.99);
INSERT INTO item (location, name, price, discount) VALUES ("shirt.jpg", "Shirt", 15.00, 10);
INSERT INTO item (location, name, price, discount) VALUES ("shotglass.jpg", "Shot Glass", 4.99, 5);
INSERT INTO item (location, name, price, discount) VALUES ("sweatpants.jpg", "Sweatpants", 4.99, 15);
INSERT INTO item (location, name, price, discount) VALUES ("backpack.jpg", "Backpack", 24.99, 15);
INSERT INTO item (location, name, price, discount) VALUES ("keychain.jpg", "Keychain", 4.99, 15);
INSERT INTO item (location, name, price) VALUES ("laptopbag.jpg", "Laptop Case", 19.99);
INSERT INTO item (location, name, price, discount) VALUES ("pencils.jpg", "Pencils", 1.99, 15);

INSERT INTO forum (username, rating, review) VALUES ("achung", 5, "Wow. Such Camp. Much Website.");
INSERT INTO forum (username, rating, review) VALUES ("adeartola", 4, "Kidz Camp is a great place to learn about computers. The staff is great and really take an interest in all the kids.");
INSERT INTO forum (username, rating, review) VALUES ("hsolo", 3, "I can't complain when it comes to Kidz Camp. However my only suggestion is that they add more emphasis on space and other worlds.");
INSERT INTO forum (username, rating, review) VALUES ("joshBrah", 4, "Dude, this camp is totally cool. Learned some great stuff from the raddest camp counselors out there! Right on brah!");
INSERT INTO forum (username, rating, review) VALUES ("jbob93", 5, "Kidz Camp really knows how to please parents and kids. They offer the most interactive activities and allow for kids to express themselves. Keep it up Kidz Camp.");
