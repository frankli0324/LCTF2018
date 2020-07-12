CREATE DATABASE ctf;

CREATE USER 'lctf2018' @'localhost' IDENTIFIED BY 'mysql-upgrade-best-practices';
GRANT ALL PRIVILEGES ON ctf.* TO 'lctf2018' @'localhost';

USE ctf;

CREATE TABLE user_posts (
    id int primary key auto_increment,
    username text not null,
    message text not null,
    datetime datetime,
    ip text
);

CREATE TABLE users (
    id int primary key auto_increment,
    username text not null,
    password text not null,
    motto text,
    datetime datetime
);

INSERT INTO
    users (`username`, `password`, `motto`)
values
    ('admin', md5(RAND()), "I'm admin!");

CREATE TABLE fllll12tw1llllag (flag text)