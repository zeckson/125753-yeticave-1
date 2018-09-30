# use mysql.server start/stop — to start/stop mysql server

DROP DATABASE yeticave;

CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHAR SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;


CREATE TABLE users (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,

  name       VARCHAR(80)  NOT NULL,
  email      VARCHAR(80)  NOT NULL UNIQUE,
  password   VARCHAR(40)  NOT NULL,

  info       TEXT,
  avatar_url VARCHAR(100)
);

CREATE TABLE categories (
  id   INT UNSIGNED PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE
);

CREATE TABLE lots
(
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP            NOT NULL,

  name        TEXT                                           NOT NULL,
  image_url   VARCHAR(100)                                   NOT NULL,
  start_price INT UNSIGNED                                   NOT NULL,
  author_id   INT UNSIGNED                                   NOT NULL,
  category_id INT UNSIGNED                                   NOT NULL,

  description LONGTEXT,
  bid_step    INT          DEFAULT 1000,
  closes_at   TIMESTAMP,
  winner_id   INT UNSIGNED,

  FOREIGN KEY (author_id) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (winner_id) REFERENCES users (id)
    ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories (id)
    ON DELETE RESTRICT
);


CREATE TABLE bids (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

  amount     INT UNSIGNED                        NOT NULL,
  owner_id   INT UNSIGNED                        NOT NULL,
  lot_id     INT UNSIGNED                        NOT NULL,

  FOREIGN KEY (owner_id) REFERENCES users (id),
  FOREIGN KEY (lot_id) REFERENCES lots (id)
);