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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.category : ~2 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Le bar'),
	(2, 'Les actualités');

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
  CONSTRAINT `FK_message_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_message_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.post : ~3 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `text`, `creationDate`, `user_id`, `topic_id`) VALUES
	(1, 'Perdu dans le vide infini, un astronome scrutait l\'obscurité. Soudain, son regard captura l\'impensable : un trou noir, une porte vers l\'inconnu. Tremblant d\'émerveillement et de peur, il contempla cet abîme dévorant, sa propre existence suspendue entre les étoiles. Ce bref instant lui offrit une perspective vertigineuse sur la fragilité de l\'humanité face aux mystères de l\'univers.', '2024-04-08 15:04:59', 1, 1),
	(2, 'It was a dark and stormy night...\r\n', '2024-04-10 14:21:03', 10, 1),
	(4, 'It was a dark and stormy night...\r\n', '2024-04-10 14:21:55', 10, 1);

-- Listage de la structure de table forummvc_v2. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `membre_id` (`user_id`) USING BTREE,
  KEY `categorie_id` (`category_id`) USING BTREE,
  CONSTRAINT `FK_topic_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.topic : ~0 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `closed`, `user_id`, `category_id`) VALUES
	(1, 'Trou noir', '2024-04-08 15:02:35', 1, 1, 1),
	(2, 'Ras-le-bol', '2024-04-08 16:25:56', 1, 1, 2);

-- Listage de la structure de table forummvc_v2. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forummvc_v2.user : ~5 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `pseudo`, `password`, `email`, `role`, `creationDate`) VALUES
	(1, 'gino', 'Gino67540//!', '1234@gmail.com', 'ROLE_ADMIN', '2024-04-10 11:03:20'),
	(6, 'gary', '$2y$10$a/HHyNhM4wi9SE9SgGcnueWFR1oC0I57ec.NB1fgMfM0ioKtK9YTa', 'gary@gmail.com', 'ROLE_USER', '2024-04-10 11:03:20'),
	(7, 'romane', '$2y$10$ji2XkXGlneufexANLYQ2AOCtfQ0FY7if0CYgnZgIoXstXl0mTbm/2', 'romane@gmail.com', 'ROLE_ADMIN', '2024-04-10 11:03:20'),
	(8, 'bla', '$2y$10$9Ny4xuudFOhbTSzaZiceK.IJXSINfDrWmkvtOia4WMklnn72x.P.K', 'bla@gmail.com', 'ROLE_USER', '2024-04-10 11:25:08'),
	(10, 'glad', '$2y$10$C.LElcGlGkotEUsaytNiFO256jfcv8SyPPod2w2LCjMiKFu66gzv6', 'glad@gmail.com', 'ROLE_ADMIN', '2024-04-10 11:33:56');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
