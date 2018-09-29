# use mysql.server start/stop — to start/stop mysql server

drop database yeticave;

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

CREATE TABLE categories (
  id   INT UNSIGNED PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE
);

INSERT INTO categories (id, name)
VALUES (0, 'Доски и лыжи'),
       (1, 'Крепления'),
       (2, 'Ботинки'),
       (3, 'Одежда'),
       (4, 'Инструменты'),
       (5, 'Разное');

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

  author_id      INT UNSIGNED NOT NULL,
  winner_id      INT UNSIGNED,
  category_id    INT UNSIGNED NOT NULL,

  FOREIGN KEY (author_id) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (winner_id) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories (id)
    ON DELETE RESTRICT
);


CREATE TABLE bids (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP,

  owner_id      INT UNSIGNED NOT NULL,
  lot_id        INT UNSIGNED NOT NULL,

  FOREIGN KEY (owner_id) REFERENCES users (id),
  FOREIGN KEY (lot_id) REFERENCES lots (id)
);