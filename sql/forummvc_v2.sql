-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forummvc_v2
CREATE DATABASE IF NOT EXISTS `forummvc_v2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forummvc_v2`;

-- Listage de la structure de table forummvc_v2. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.category : ~5 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Le bar'),
	(2, 'Les actualités'),
	(5, 'L&#039;&eacute;chap&eacute;e'),
	(6, 'Le bar'),
	(7, 'Le bar 2');

-- Listage de la structure de table forummvc_v2. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `topic_id` (`topic_id`),
  KEY `membre_id` (`user_id`) USING BTREE,
  CONSTRAINT `FK_message_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `FK_message_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.post : ~4 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `text`, `creationDate`, `user_id`, `topic_id`) VALUES
	(18, 'blaaaaaaaaaaaaaaaaaaaaaahhhh', '2024-04-15 13:46:35', 10, 30),
	(19, 'blablablabla', '2024-04-15 14:54:51', 10, 31),
	(20, 'blabla2', '2024-04-15 14:54:57', 10, 31),
	(21, 'que ferions nous ?', '2024-04-15 14:55:04', 10, 31),
	(24, 'oalla', '2024-04-16 16:25:29', 17, 33),
	(25, 'avez vous vu ?!', '2024-04-16 16:34:59', 17, 34),
	(26, 'ouiiii ', '2024-04-16 16:35:07', 17, 34),
	(27, 'que faire si cela arrive ?', '2024-04-16 16:35:19', 17, 34);

-- Listage de la structure de table forummvc_v2. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `membre_id` (`user_id`) USING BTREE,
  KEY `categorie_id` (`category_id`) USING BTREE,
  CONSTRAINT `FK_topic_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE,
  CONSTRAINT `FK_topic_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.topic : ~4 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `closed`, `user_id`, `category_id`) VALUES
	(30, 'Ras-le-bol 2023', '2024-04-15 13:46:35', 0, 10, 2),
	(31, 'trou blanc', '2024-04-15 14:54:51', 0, 10, 1),
	(33, 'il sont arriv&eacute;s !', '2024-04-16 16:25:29', 0, 17, 1),
	(34, 'koh lanta 2058 Claude en t&ecirc;te !', '2024-04-16 16:34:59', 0, 17, 1);

-- Listage de la structure de table forummvc_v2. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.user : ~4 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `pseudo`, `password`, `email`, `role`, `creationDate`) VALUES
	(6, 'gary', '$2y$10$a/HHyNhM4wi9SE9SgGcnueWFR1oC0I57ec.NB1fgMfM0ioKtK9YTa', 'gary@gmail.com', 'ROLE_USER', '2024-04-10 11:03:20'),
	(7, 'romane', '$2y$10$ji2XkXGlneufexANLYQ2AOCtfQ0FY7if0CYgnZgIoXstXl0mTbm/2', 'romane@gmail.com', 'ROLE_ADMIN', '2024-04-10 11:03:20'),
	(8, 'Gino67', '$2y$10$9Ny4xuudFOhbTSzaZiceK.IJXSINfDrWmkvtOia4WMklnn72x.P.K', 'gino67@gmail.com', 'ROLE_USER', '2024-04-10 11:25:08'),
	(10, 'glad', '$2y$10$C.LElcGlGkotEUsaytNiFO256jfcv8SyPPod2w2LCjMiKFu66gzv6', 'glad@gmail.com', 'ROLE_ADMIN', '2024-04-10 11:33:56'),
	(17, 'fred', '$2y$10$EQSq.vuWWzvloi1aOQcBZ.eVSsBgti9o1uqC3fmR23.PDDOsS1uxm', 'fred@gmail.com', 'ROLE_USER', '2024-04-16 13:53:39');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
