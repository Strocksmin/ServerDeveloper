CREATE DATABASE IF NOT EXISTS appDB default charset utf8;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, UPDATE, INSERT ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
SET NAMES utf8;
CREATE TABLE IF NOT EXISTS users
(
    id       INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name     VARCHAR(100)    NOT NULL,
    password VARCHAR(100)    NOT NULL,
    role     VARCHAR(10)     NOT NULL
);
CREATE TABLE IF NOT EXISTS menu
(
    id     INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name   VARCHAR(100)    NOT NULL,
    weight VARCHAR(100)    NOT NULL,
    cost   INT             NOT NULL
);


INSERT INTO users (name, password, role)
VALUES ('Andrey', '12345', 'admin'),
       ('user', 'user', 'user');

INSERT INTO menu (name, weight, cost)
VALUES ('Американо', '250 мл', 100),
       ('Латте', '250 мл', 120),
       ('Капучино', '250 мл', 140),
       ('Айс Кофе', '250 мл', 160),
       ('Фильтр-кофе', '250 мл', 180),
       ('Эспрессо', '150 мл', 100),
       ('Фраппе', '250 мл', 200),
       ('Гляссе', '200 мл', 220);