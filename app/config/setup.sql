-- create the databases
CREATE DATABASE IF NOT EXISTS camagru;

USE camagru;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`           int(11) NOT NULL AUTO_INCREMENT,
  `firstname`    varchar(20) NOT NULL,
  `lastname`     varchar(20) NOT NULL,
  `username`     varchar(30) NOT NULL,
  `email`        varchar(50) NOT NULL,
  `password`     varchar(255) NOT NULL,
  `image`        TEXT,
  `token`        varchar(32) DEFAULT NULL,
  `comment`      tinyint(1) DEFAULT 1,
  `verified`     tinyint(1) DEFAULT 0,
  `created`      datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE(`username`),
  UNIQUE(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id`            INT NOT NULL AUTO_INCREMENT,
  `user_id`       INT NOT NULL,
  `image_url`     TEXT NOT NULL,
  `created_at`    datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id`            INT NOT NULL AUTO_INCREMENT,
  `user_id`       INT NOT NULL,
  `post_id`       INT NOT NULL,
  `created_at`    datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(`id`),
  UNIQUE (`user_id`, `post_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`post_id`) REFERENCES posts(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id`            INT NOT NULL AUTO_INCREMENT,
  `user_id`       INT NOT NULL,
  `post_id`       INT NOT NULL,
  `comment`       TEXT,
  `created_at`    datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`post_id`) REFERENCES posts(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `forgotpassword`;
CREATE TABLE `forgotpassword` (
  `id`            INT NOT NULL AUTO_INCREMENT,
  `user_id`       INT NOT NULL UNIQUE,
  `token`         VARCHAR(32) DEFAULT NULL,
  `created_at`    datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- create the users for each database
CREATE USER 'camagru'@'%' IDENTIFIED BY 'password';
GRANT CREATE, ALTER, INDEX, LOCK TABLES, REFERENCES, UPDATE, DELETE, DROP, SELECT, INSERT ON `camagru`.* TO 'camagru'@'%';

FLUSH PRIVILEGES;