SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database selecteren (of aanmaken indien nodig)
CREATE DATABASE IF NOT EXISTS `trallo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `trallo`;

-- Tabel: `planning_board`
CREATE TABLE IF NOT EXISTS `planning_board` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `section` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL,
    `deadline` date DEFAULT NULL,
    `user_id` int NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: `user`
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
