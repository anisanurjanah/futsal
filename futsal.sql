-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
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


-- Dumping database structure for futsal
DROP DATABASE IF EXISTS `futsal`;
CREATE DATABASE IF NOT EXISTS `futsal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `futsal`;

-- Dumping structure for table futsal.tbl_lapangan
DROP TABLE IF EXISTS `tbl_lapangan`;
CREATE TABLE IF NOT EXISTS `tbl_lapangan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `namalapangan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `hargaperjam` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table futsal.tbl_lapangan: ~2 rows (approximately)
DELETE FROM `tbl_lapangan`;
INSERT INTO `tbl_lapangan` (`id`, `namalapangan`, `hargaperjam`) VALUES
	(3, 'LAPANGAN A1', 200000),
	(4, 'LAPANGAN A2', 100000);

-- Dumping structure for table futsal.tbl_notifikasi
DROP TABLE IF EXISTS `tbl_notifikasi`;
CREATE TABLE IF NOT EXISTS `tbl_notifikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pesan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table futsal.tbl_notifikasi: ~3 rows (approximately)
DELETE FROM `tbl_notifikasi`;
INSERT INTO `tbl_notifikasi` (`id`, `pesan`, `is_read`) VALUES
	(1, 'test', 1),
	(2, 'Ada reservasi baru', 1),
	(3, 'Ada reservasi baru', 1),
	(4, 'Ada reservasi baru', 1);

-- Dumping structure for table futsal.tbl_pelanggan
DROP TABLE IF EXISTS `tbl_pelanggan`;
CREATE TABLE IF NOT EXISTS `tbl_pelanggan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table futsal.tbl_pelanggan: ~4 rows (approximately)
DELETE FROM `tbl_pelanggan`;
INSERT INTO `tbl_pelanggan` (`id`, `nama`, `no_telepon`) VALUES
	(6, 'test', '1231'),
	(7, 'dfsa', '123'),
	(8, 'test', '1231231'),
	(9, 'test', '1231231'),
	(10, 'ada', '464656');

-- Dumping structure for table futsal.tbl_reservasi
DROP TABLE IF EXISTS `tbl_reservasi`;
CREATE TABLE IF NOT EXISTS `tbl_reservasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_lapangan` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `waktu_selesai` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_lapangan` (`id_lapangan`),
  KEY `pelangganReservasi` (`id_pelanggan`),
  CONSTRAINT `id_lapangan` FOREIGN KEY (`id_lapangan`) REFERENCES `tbl_lapangan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `pelangganReservasi` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table futsal.tbl_reservasi: ~2 rows (approximately)
DELETE FROM `tbl_reservasi`;
INSERT INTO `tbl_reservasi` (`id`, `id_lapangan`, `id_pelanggan`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `status`) VALUES
	(12, 3, 10, '2025-05-25', '10:00:00', '11:00:00', 'Lunas');

-- Dumping structure for table futsal.tbl_role
DROP TABLE IF EXISTS `tbl_role`;
CREATE TABLE IF NOT EXISTS `tbl_role` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table futsal.tbl_role: ~0 rows (approximately)
DELETE FROM `tbl_role`;
INSERT INTO `tbl_role` (`id`, `nama_role`) VALUES
	(1, 'Admin'),
	(8, 'Kasir');

-- Dumping structure for table futsal.tbl_user
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_gender` int NOT NULL,
  `id_role` tinyint NOT NULL,
  `is_active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table futsal.tbl_user: ~2 rows (approximately)
DELETE FROM `tbl_user`;
INSERT INTO `tbl_user` (`id`, `nama_lengkap`, `email`, `password`, `id_gender`, `id_role`, `is_active`) VALUES
	(1, 'Admin', 'admin@localhost.com', '$2y$10$vIfeFoJAkJ8jSARMxYjN7.q006OGXZQEq91k7lEspGTnmdmqsnHfy', 1, 1, 1),
	(5, 'kasir', 'kasir@localhost.com', '$2y$10$3xE0.V2ftT63qohLQblTveUZBG6Aega86qwqk.P2sJv..W35GAmcG', 1, 8, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
