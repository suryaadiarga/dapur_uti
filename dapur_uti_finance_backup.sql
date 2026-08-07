-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dapur_uti_finance
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_transactions`
--

DROP TABLE IF EXISTS `expense_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `people_id` bigint unsigned NOT NULL,
  `category` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `description` text,
  `receipt_path` varchar(255) DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_transactions_created_by_foreign` (`created_by`),
  KEY `expense_transactions_transaction_date_category_index` (`transaction_date`,`category`),
  KEY `expense_transactions_people_id_transaction_date_index` (`people_id`,`transaction_date`),
  KEY `expense_transactions_store_name_index` (`store_name`),
  CONSTRAINT `expense_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `expense_transactions_people_id_foreign` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_transactions`
--

LOCK TABLES `expense_transactions` WRITE;
/*!40000 ALTER TABLE `expense_transactions` DISABLE KEYS */;
INSERT INTO `expense_transactions` VALUES (2,'2026-06-13',2,'transportasi',40000.00,'tunai','SPBU Surabaya','Bensin',NULL,1,'2026-06-23 16:31:39','2026-06-23 16:31:39'),(3,'2026-06-13',7,'peralatan_dapur',150500.00,'tunai','Pucang Jajar SBY','SENDOK STAINLESS NAGAKO 22 LUSIN',NULL,1,'2026-06-23 16:33:37','2026-06-23 16:33:37'),(4,'2026-06-13',7,'peralatan_dapur',707000.00,'transfer','SBY BARAT','PIRING BIRU MELAMIN 9 INCH 101PCS',NULL,1,'2026-06-23 16:34:21','2026-06-23 16:34:21'),(5,'2026-06-13',7,'peralatan_dapur',301000.00,'transfer','SBY BARAT','PIRING PUTIH MELAMIN 9 INCH 43PCS',NULL,1,'2026-06-23 16:34:51','2026-06-23 16:34:51'),(6,'2026-06-13',7,'packaging',28000.00,'tunai','Pucang Jajar SBY','KERTAS MINYAK 200 LBR',NULL,1,'2026-06-23 16:35:48','2026-06-23 16:35:48'),(7,'2026-06-13',7,'operasional',6000.00,'tunai','Pucang Jajar SBY','SARUNG TANGAN',NULL,1,'2026-06-23 16:36:40','2026-06-23 16:36:40'),(8,'2026-06-13',7,'packaging',10500.00,'tunai','Pucang Jajar SBY','KARET 100 GRAM',NULL,1,'2026-06-23 16:38:06','2026-06-23 16:38:55'),(9,'2026-06-13',2,'operasional',55000.00,'tunai','tambal ban','mojokerto prambon krian',NULL,1,'2026-06-23 16:39:55','2026-06-23 16:39:55'),(10,'2026-06-13',2,'operasional',45000.00,'tunai','SBY BARAT','ban baru',NULL,1,'2026-06-23 16:40:48','2026-06-23 16:40:48'),(11,'2026-06-13',2,'operasional',75000.00,'tunai','Jojoran Gubeng SBY','MAKAN MINUM JOJORAN  SURABAYA',NULL,1,'2026-06-23 16:42:15','2026-06-23 18:18:45'),(12,'2026-06-14',7,'operasional',15000.00,'tunai','PASAR SEPANJANG','MASKER ONE CARE',NULL,1,'2026-06-23 18:18:27','2026-06-23 18:18:27'),(13,'2026-06-14',2,'operasional',30000.00,'tunai','SPBU Surabaya',NULL,NULL,1,'2026-06-24 05:54:06','2026-06-24 05:54:06'),(14,'2026-06-14',2,'operasional',5000.00,'tunai','Pusat Grosir Surabaya','Parkir PGS',NULL,1,'2026-06-24 05:54:49','2026-06-24 05:54:49'),(15,'2026-06-14',7,'operasional',9900.00,'tunai','Toserba Palapa Taman','Hairnet Jaring',NULL,1,'2026-06-24 05:56:18','2026-06-24 05:56:18'),(16,'2026-06-14',7,'peralatan_dapur',28200.00,'tunai','Toserba Palapa Taman','Celemek Masak',NULL,1,'2026-06-24 05:57:20','2026-06-24 05:57:20'),(17,'2026-06-14',7,'operasional',52800.00,'tunai','Warung Sederhana STS Gubeng',NULL,NULL,1,'2026-06-24 06:14:25','2026-06-24 06:14:25'),(18,'2026-06-14',2,'peralatan_dapur',820650.00,'transfer','Shopee Toptree','Piring Melamin TopTree 120 pcs / 10 Lusin',NULL,1,'2026-06-24 06:15:37','2026-06-24 06:18:52'),(19,'2026-04-14',2,'packaging',316767.00,'transfer','Shopee','Box Container 15L,25L,30L,75L',NULL,1,'2026-06-24 06:17:28','2026-06-24 06:17:28'),(20,'2026-06-14',2,'packaging',316800.00,'transfer','Shopee','Box Container 15,25,30,75',NULL,1,'2026-06-24 06:18:34','2026-06-24 06:18:34'),(21,'2026-06-16',2,'lain_lain',70000.00,'transfer','Gamma Production Embong Malang SBY','Stemple Catering Dapur Uti',NULL,1,'2026-06-24 06:20:19','2026-06-24 06:20:19'),(22,'2026-06-16',9,'transportasi',175000.00,'tunai','Tundungan SDMJ Krian','Servis Mobil + Ganti Filter Bensin + Ongkos Pasang',NULL,1,'2026-06-24 06:21:46','2026-06-24 06:25:19'),(23,'2026-06-18',2,'peralatan_dapur',274300.00,'transfer','Shopee','Kompor 1 Tungku + Selang Regulator',NULL,1,'2026-06-24 06:27:01','2026-06-24 06:27:01'),(24,'2026-06-18',5,'lain_lain',83000.00,'tunai','Pasar Krian','Kantong Plastik + Kantong Kresek',NULL,1,'2026-06-24 06:28:57','2026-06-24 06:28:57'),(25,'2026-06-18',5,'belanja_bahan',50000.00,'tunai','Toko Krupuk','Krupuk 1',NULL,1,'2026-06-24 07:03:13','2026-06-24 07:03:13'),(26,'2026-06-18',5,'belanja_bahan',100000.00,'tunai','Toko Krupuk','Krupuk 2',NULL,1,'2026-06-24 07:04:19','2026-06-24 07:04:19'),(27,'2026-06-18',5,'belanja_bahan',95000.00,'tunai','Toko Krupuk','Krupuk 4',NULL,1,'2026-06-24 07:05:58','2026-06-24 07:05:58'),(28,'2026-06-19',9,'belanja_bahan',20000.00,'tunai','Pasar Baru Krian','Manisa 4 Kg',NULL,1,'2026-06-24 07:07:27','2026-06-24 07:07:27'),(29,'2026-06-19',9,'belanja_bahan',440000.00,'tunai','Pasar Baru Krian','Telur 2 Krat',NULL,1,'2026-06-24 07:08:40','2026-06-24 07:08:40'),(30,'2026-06-15',9,'belanja_bahan',325000.00,'tunai','Mas Ari Ayam','Beli Ayam 130 Potong @ 2500',NULL,1,'2026-06-24 07:11:38','2026-06-24 07:11:38'),(31,'2026-06-18',9,'belanja_bahan',662500.00,'tunai','Mas Ari Ayam','Beli Ayam 265 Potong @ 2500',NULL,1,'2026-06-24 07:12:31','2026-06-24 07:12:31'),(32,'2026-06-17',9,'belanja_bahan',460000.00,'tunai','Toko Telur','beli telur 2 krat @ 230000',NULL,1,'2026-06-24 07:15:46','2026-06-24 07:15:46'),(33,'2026-06-17',9,'belanja_bahan',230000.00,'tunai','Toko Telur','beli telur 1 krat @ 230000',NULL,1,'2026-06-24 07:16:21','2026-06-24 07:16:21'),(34,'2026-06-20',2,'operasional',42000.00,'tunai','Warung depan PT SIGK','Minuman',NULL,1,'2026-06-24 07:18:36','2026-06-24 07:18:36');
/*!40000 ALTER TABLE `expense_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `income_transactions`
--

DROP TABLE IF EXISTS `income_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `income_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `people_id` bigint unsigned NOT NULL,
  `category` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `description` text,
  `proof_path` varchar(255) DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `income_transactions_created_by_foreign` (`created_by`),
  KEY `income_transactions_transaction_date_category_index` (`transaction_date`,`category`),
  KEY `income_transactions_people_id_transaction_date_index` (`people_id`,`transaction_date`),
  CONSTRAINT `income_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `income_transactions_people_id_foreign` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `income_transactions`
--

LOCK TABLES `income_transactions` WRITE;
/*!40000 ALTER TABLE `income_transactions` DISABLE KEYS */;
INSERT INTO `income_transactions` VALUES (2,'2026-06-13',2,'modal_pemilik',1558900.00,'tunai','modal awal belanja piring, sendok, dll',NULL,1,'2026-06-23 15:49:52','2026-06-23 15:50:12'),(3,'2026-06-14',2,'modal_pemilik',500000.00,'tunai','modal produksi 1 transfer dana',NULL,1,'2026-06-23 15:51:10','2026-06-23 15:51:10'),(4,'2026-06-15',2,'modal_pemilik',3000000.00,'tunai','modal produksi 2',NULL,1,'2026-06-23 15:52:12','2026-06-23 15:52:12'),(5,'2026-06-16',8,'pembayaran_pelanggan',960000.00,'transfer','Katering 120 Porsi',NULL,1,'2026-06-23 16:10:07','2026-06-23 16:10:07'),(6,'2026-06-17',8,'pembayaran_pelanggan',2080000.00,'transfer','Katering 260 Porsi',NULL,1,'2026-06-23 16:10:58','2026-06-23 16:10:58'),(7,'2026-06-18',2,'modal_pemilik',1500000.00,'transfer','modal produksi 3',NULL,1,'2026-06-23 16:26:27','2026-06-23 16:26:27'),(8,'2026-06-18',8,'pembayaran_pelanggan',2080000.00,'transfer','Katering 260 Porsi',NULL,1,'2026-06-23 16:27:49','2026-06-23 16:27:49'),(9,'2026-06-18',2,'lain_lain',274281.00,'transfer',NULL,NULL,1,'2026-06-23 16:29:24','2026-06-23 16:29:24'),(10,'2026-06-18',2,'modal_pemilik',1000000.00,'tunai','modal produksi 4',NULL,1,'2026-06-23 16:29:53','2026-06-23 16:29:53');
/*!40000 ALTER TABLE `income_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `condition` varchar(30) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `people_id` bigint unsigned NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventories_category_condition_index` (`category`,`condition`),
  KEY `inventories_people_id_index` (`people_id`),
  CONSTRAINT `inventories_people_id_foreign` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES (4,'sendok stainless nagako 22 lusin','alat_makan','2026-06-13',150500.00,1,'baik','Dapur',1,NULL,'22 LUSIN / 264 PCS','2026-06-23 15:55:15','2026-06-23 16:05:35'),(5,'piring biru melamin biru 101pcs','alat_makan','2026-06-13',707000.00,1,'baik','dapur',7,NULL,NULL,'2026-06-23 15:57:40','2026-06-23 15:57:40'),(6,'piring putih melamin 43pcs','alat_makan','2026-06-13',301000.00,1,'baik','Dapur',7,NULL,NULL,'2026-06-23 15:58:41','2026-06-23 15:58:41'),(7,'celemek masak','alat_masak','2026-06-14',28200.00,1,'baik','Dapur',7,NULL,NULL,'2026-06-23 15:59:22','2026-06-23 15:59:22'),(8,'piring melamin online 120pcs','alat_makan','2026-06-14',820650.00,1,'baik','Dapur',2,NULL,NULL,'2026-06-23 16:00:11','2026-06-23 16:00:11'),(9,'box container online','peralatan_packing','2026-06-14',316767.00,1,'baik','Dapur',2,NULL,NULL,'2026-06-23 16:01:17','2026-06-23 16:01:17'),(10,'stempel','lain_lain','0001-07-16',70000.00,1,'baik','Dapur',1,NULL,NULL,'2026-06-23 16:02:06','2026-06-23 16:02:06'),(11,'kompor 1 tungku + selang regulator','alat_masak','2026-06-18',274281.00,1,'baik','Dapur',2,NULL,NULL,'2026-06-23 16:03:10','2026-06-24 05:44:13'),(12,'toples krupuk 1','peralatan_packing','2026-06-16',96000.00,1,'baik','Dapur',5,NULL,NULL,'2026-06-23 16:03:51','2026-06-23 16:03:51'),(13,'toples krupuk 2','peralatan_packing','2026-06-16',96000.00,1,'baik','Dapur',5,NULL,NULL,'2026-06-23 16:04:29','2026-06-23 16:04:29');
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_23_000100_create_people_table',1),(5,'2026_06_23_000200_create_income_transactions_table',1),(6,'2026_06_23_000300_create_expense_transactions_table',1),(7,'2026_06_23_000400_create_inventories_table',1),(8,'2026_06_23_000500_create_settings_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `role` varchar(30) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `people_role_name_index` (`role`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Uti','082231258553','pemilik','Pemilik Dapur Uti','2026-06-23 15:08:56','2026-06-24 06:23:39'),(2,'Surya Adi','082231258553','staff','Developer Dapur Uti','2026-06-23 15:15:02','2026-06-23 15:43:25'),(4,'Bu Murti','081232714794','keluarga','Chef','2026-06-23 15:44:21','2026-06-23 15:44:36'),(5,'Mas Prasetyo','082257737447','staff','Koordinator Lapangan','2026-06-23 15:45:37','2026-06-24 06:23:03'),(6,'Mas Isa','081230067769','lainnya','Koordinator Lapangan','2026-06-23 15:46:31','2026-06-23 15:46:31'),(7,'Mutiara Nur Lintang','085852759459','keluarga','Wakil Ketua Pelaksana','2026-06-23 15:56:09','2026-06-24 06:23:18'),(8,'PT SIGK',NULL,'lainnya','Pembeli','2026-06-23 16:09:09','2026-06-23 16:09:09'),(9,'Mahmudi','082331754063','pemilik','Ketua Pelaksana','2026-06-24 06:22:47','2026-06-24 06:22:47');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('MN3TAiUIeZePN8eQebztlbhEAeJfIvZklRvcZyle',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMXo3eUZZQ1RKalFGYThIUXlYVWwwRWt3ZlJjMnZ2TVVLd3dGbEJEdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXR0aW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1782297783);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_name` varchar(255) NOT NULL DEFAULT 'Dapur Uti',
  `business_address` text,
  `whatsapp_number` varchar(30) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'IDR',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'Dapur Uti','Dsn. Mojokemuning, RT 003 / RW 001, Ds. Sidomojo, Kec. Krian, Kab. Sidoarjo','082331754063',NULL,'IDR','2026-06-23 15:08:56','2026-06-23 16:14:10');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Dapur Uti','admin@dapuruti.test','2026-06-23 15:09:24','$2y$12$LRQea3QOjifNDjN5QW9DF.ZPELKYRW6s/6mEqdhQxL2Huz4yHuwiG','sTYMUuA91VnjdgliJUeDaIMLKlvCosGcivM1jLygr4484IsK34Ea3o71rCaO','2026-06-23 15:08:56','2026-06-23 15:09:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dapur_uti_finance'
--

--
-- Dumping routines for database 'dapur_uti_finance'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-24 18:18:30
