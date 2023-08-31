CREATE DATABASE blog;

CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255),
    body TEXT
);

CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    name VARCHAR(255),
    email VARCHAR(255),
    body TEXT,
    FOREIGN KEY (post_id) REFERENCES posts (id)
);