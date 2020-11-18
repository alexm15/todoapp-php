CREATE DATABASE todo_app;
USE todo_app;

CREATE TABLE todo_items (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO todo_items (name)
VALUES ('Clean House'), ('Build todo App'), ('Build Company');
