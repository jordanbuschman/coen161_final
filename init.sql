CREATE DATABASE IF NOT EXISTS kidzcamp;
USE kidzcamp;

DROP TABLE IF EXISTS user, item;

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	password VARCHAR(24) NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	lastName VARCHAR(32) NOT NULL,
	didEnroll BOOLEAN DEFAULT 0,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id));

CREATE TABLE item (
	id INT NOT NULL AUTO_INCREMENT,
	location VARCHAR(32) NOT NULL,
	name VARCHAR(32) NOT NULL,
	price FLOAT(24, 2) NOT NULL,
	discount INT DEFAULT 0,
	PRIMARY KEY (id));

INSERT INTO user (username, password, firstName, lastName, didEnroll) VALUES ("jbob93", "potato", "Jim", "Bob", 1);
INSERT INTO user (username, password, firstName, lastName) VALUES ("maryyyyyy32", "myname15Mary", "Mary", "Doe");
INSERT INTO user (username, password, firstName, lastName) VALUES ("josh123", "slimShady", "Josh", "Sims");
INSERT INTO user (username, password, firstName, lastName) VALUES ("hsolo", "starW4rz", "Han", "Solo");
INSERT INTO user (username, password, firstName, lastName) VALUES ("joshBrah", "jbh3ART", "Josh", "Mann");
INSERT INTO user (username, password, firstName, lastName) VALUES ("hKudz", "kudz4Lyfe", "Heywood", "Ukuddleme");

INSERT INTO item (location, name, price) VALUES ("potato.jpg", "potato", 29.99);
INSERT INTO item (location, name, price, discount) VALUES ("shirt.jpg", "shirt", 15.00, 10);
INSERT INTO item (location, name, price, discount) VALUES ("shotglass.jpg", "shot glass", 4.99, 5);
