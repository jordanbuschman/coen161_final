CREATE DATABASE IF NOT EXISTS kidzcamp;
USE kidzcamp;

DROP TABLE IF EXISTS user, item;

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(32) NOT NULL,
	password VARCHAR(32) NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	lastName VARCHAR(32),
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id));

CREATE TABLE item (
	id INT NOT NULL AUTO_INCREMENT,
	location VARCHAR(32) NOT NULL,
	name VARCHAR(32) NOT NULL,
	price FLOAT(24, 2) NOT NULL,
	PRIMARY KEY (id));

INSERT INTO user (username, password, firstName, lastName) VALUES ("jbob69", "potato", "Jim", "Bob");

INSERT INTO item (location, name, price) VALUES ("images/potato.jpg", "potato", 29.99);
