CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHAR SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users (
  id         INT UNSIGNED    NOT NULL AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP       NOT NULL,
  email      VARCHAR(80)     NOT NULL UNIQUE,
  password   VARBINARY(1024) NOT NULL,
  name       VARCHAR(80)     NOT NULL,
  info       TEXT            NOT NULL,
  avatar_url VARCHAR(100)
);

EXPLAIN users;

DROP TABLE users;

CREATE TABLE categories (
  id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE
);

INSERT INTO categories (name)
VALUES ('Доски и лыжи'),
       ('Крепления'),
       ('Ботинки'),
       ('Одежда'),
       ('Инструменты'),
       ('Разное');

CREATE TABLE lots
(
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at  TIMESTAMP    NOT NULL,
  name        TEXT         NOT NULL,
  description LONGTEXT,
  image_url   TEXT,
  start_price INT UNSIGNED DEFAULT 0,
  closes_at   TIMESTAMP    NOT NULL,
  bid_step    INT, # Bid step. What it used for?

  author      INT UNSIGNED NOT NULL,
  winner      INT UNSIGNED,
  category    INT UNSIGNED NOT NULL,

  FOREIGN KEY (author) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (winner) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (category) REFERENCES categories (id)
    ON DELETE RESTRICT
);


CREATE TABLE bids (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP,

  owner      INT UNSIGNED NOT NULL,
  lot        INT UNSIGNED NOT NULL,

  FOREIGN KEY (owner) REFERENCES users (id),
  FOREIGN KEY (lot) REFERENCES lots (id)
);