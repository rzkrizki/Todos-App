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

-- Dumping structure for table db_client.myclient
CREATE TABLE IF NOT EXISTS `myclient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE armscii8_bin NOT NULL,
  `slug` varchar(100) COLLATE armscii8_bin NOT NULL,
  `is_project` enum('0','1') COLLATE armscii8_bin NOT NULL DEFAULT '0',
  `self_capture` varchar(1) COLLATE armscii8_bin NOT NULL DEFAULT '1',
  `client_prefix` varchar(4) COLLATE armscii8_bin NOT NULL,
  `client_logo` varchar(255) COLLATE armscii8_bin NOT NULL DEFAULT 'no-image.jpg',
  `address` text COLLATE armscii8_bin NOT NULL,
  `phone_number` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `city` varchar(50) COLLATE armscii8_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table db_client.myclient: ~2 rows (approximately)
INSERT INTO `myclient` (`id`, `name`, `slug`, `is_project`, `self_capture`, `client_prefix`, `client_logo`, `address`, `phone_number`, `city`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, 'Rizkii', 'rizkii', '0', '1', 'okz', 'okz.jpg', 'Jakarta', '12346789', 'Rizkii', '2025-02-27 02:55:27', '2025-02-27 03:04:04', '2025-02-27 03:04:04'),
	(3, 'Ramadhan', 'ramadhan', '0', '1', 'okz', 'okz.jpg', 'Jakarta', '12346789', 'Ramadhan', '2025-02-27 02:55:40', '2025-02-27 02:55:40', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
