SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database selecteren (of aanmaken indien nodig)
CREATE DATABASE IF NOT EXISTS `trallo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `trallo`;

-- Tabel: `users` (moved this first since it's referenced by planning_board)
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: `sections`
DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sections` (`id`, `name`) VALUES
(1, 'Parkbeheer'),
(2, 'Gastenservice'),
(3, 'Horeca'),
(4, 'Commercieel'),
(5, 'Veiligheid');

-- Tabel: `planning_board`
DROP TABLE IF EXISTS `planning_board`;
CREATE TABLE IF NOT EXISTS `planning_board` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `section_id` int(11) NOT NULL,
    `status` varchar(255) NOT NULL,
    `deadline` date DEFAULT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`section_id`) REFERENCES `sections`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;