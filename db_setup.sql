--Version 1.0.0
CREATE DATABASE todo_app;
USE todo_app;

CREATE TABLE todo_items (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO todo_items (name)
VALUES ('Clean House'), ('Build todo App'), ('Build Company');

--Version 1.1.0
ALTER TABLE todo_items
ADD COLUMN completed boolean DEFAULT FALSE;
