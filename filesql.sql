-- --------------------------------------------------------
-- Host:                         103.167.35.113
-- Server version:               8.0.35-0ubuntu0.22.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for webpro
CREATE DATABASE IF NOT EXISTS `webpro` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `webpro`;

-- Dumping structure for table webpro.jadwal_kelas
CREATE TABLE IF NOT EXISTS `jadwal_kelas` (
  `id_kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senin` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `selasa` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `rabu` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `kamis` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `jumat` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `sabtu` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  `minggu` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kosong/Tidak Tersedia',
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table webpro.jadwal_kelas: ~4 rows (approximately)
INSERT INTO `jadwal_kelas` (`id_kelas`, `senin`, `selasa`, `rabu`, `kamis`, `jumat`, `sabtu`, `minggu`) VALUES
	('aa301', '07:30 - 200 Menit', '12:30 - 300 Menit', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia'),
	('aa302', 'AA302 Senin', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', '23:00 - 300 Menit', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', '01:43 - 50'),
	('aa303', '00:00 - 100 Menit', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia'),
	('gsg201', 'GSG201 Senin', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia', 'Kosong/Tidak Tersedia');

-- Dumping structure for table webpro.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kapasitas_kelas` int NOT NULL,
  `jenis_kelas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Kelas',
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='anjaz kelass';

-- Dumping data for table webpro.kelas: ~8 rows (approximately)
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kapasitas_kelas`, `jenis_kelas`) VALUES
	('aa301', 'AA 301', 30, 'Kelas'),
	('aa302', 'AA 302', 30, 'Kelas'),
	('aa303', 'AA 303', 30, 'Kelas'),
	('gsg201', 'GSG 201', 53, 'Kelas'),
	('gsg210', 'GSG 210', 40, 'Kelas'),
	('gsg211', 'GSG 211', 30, 'Kelas'),
	('gsg212', 'GSG 212', 30, 'Kelas');

-- Dumping structure for table webpro.user
CREATE TABLE IF NOT EXISTS `user` (
  `kode_user` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_user` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_user` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`kode_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Pengguna siapa wae terserah';

-- Dumping data for table webpro.user: ~2 rows (approximately)
INSERT INTO `user` (`kode_user`, `nama_user`, `password_user`, `status_user`) VALUES
	(1, 'Admin', 'admin', 'Administrator'),
	(2, 'Mhsw', 'mhsw', 'User'),
	(3, 'Dosen', 'dosen', 'Dosen');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
