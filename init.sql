CREATE DATABASE IF NOT EXISTS kidzcamp;
USE kidzcamp;

DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user (id int NOT NULL AUTO_INCREMENT, username VARCHAR(32) NOT NULL, password VARCHAR(32) NOT NULL, firstName VARCHAR(32) NOT NULL, lastName VARCHAR(32), PRIMARY KEY (id));

INSERT INTO user (username, password, firstName, lastName) VALUES ("jbob69", "potato", "Jim", "Bob");
