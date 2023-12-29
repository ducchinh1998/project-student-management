-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: db_student_management
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `position` enum('Student','Lecturer','Administrators') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'phong_dao_tao_1','20200001','17015750662023120303442670ZCnncVmzrxEJ45RKwWAOBBPkd3p5isxTW1jIah.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Huỳnh Quyết','Thắng','0336666789','test@example.com','Hà Nội','Male','1990-08-08','','Quản lý cấp cao',1,'Administrators',NULL,NULL,'2023-12-02 21:13:49'),(9,'HoangMinhAnh','20200019','170154013020231202180210sE3pPFnZ4ZB4joq7IbWfNKzxopsb10ZHAjBiG1MS.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Hoàng Minh','Anh','0331232341','minhanh@gmail.com','Cầu Giấy - Hà Nội','Male','2002-01-29','Khoa học vũ trụ','Tiến sĩ khoa học vũ trụ tại Liên Bang Nga',1,'Lecturer',NULL,'2023-12-02 07:45:01','2023-12-02 11:02:31'),(16,'NguyenVanA','20200016','170153301320231202160333lbxqa6SnaHlDi5fOR3z6Wenjz4M6ELS1MiFKCbyo.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Nguyễn Văn','A','0331112220','nguyenvana@gmail.com','Hà Nội','Male','2000-02-10','Sinh viên','Sinh viên K1',1,'Student',NULL,'2023-12-02 09:03:33','2023-12-02 09:03:33'),(19,'NguyenVanC','20200003','170154093020231202181530D7BRB0OLLGlxM0m7wLbIHvjBY82xlBPwtNOEaRsd.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Nguyễn Văn','C','033000112','nguyenvanc@gmail.com','Hòa Bình','','2000-03-10','Sinh viên','Sinh viên K2',1,'Student',NULL,'2023-12-02 11:15:30','2023-12-02 11:15:30'),(20,'NguyenVanD','20200004','170154096020231202181600PVqAHPrqzaaVEqCGTjUILa4Hczr2LSGXqFEGkOj6.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Nguyễn Văn','D','033000113','nguyenvand@gmail.com','Hòa Bình','Male','2000-03-10','Sinh viên','Sinh viên K2',1,'Student',NULL,'2023-12-02 11:16:00','2023-12-02 11:16:00'),(21,'BuiTrongHoang','20150002','170197160620231207175326epBjTGlADna6jGLhIrRjO5s5bzWZzirksUklItSS.png','$2y$10$4edleQ7FIcS8PthADtoE.uiy3SBXgEcRg0cNNLMbJKRudJkVsRMC2','Bùi Trọng','Hoàng','0981222456','buitronghoang@gmail.com','Thái Bình','Male','1980-07-10','Deep Learning','Giảng viên cao cấp',1,'Lecturer',NULL,'2023-12-07 10:53:26','2023-12-07 10:53:26');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classes_slug_unique` (`slug`),
  KEY `classes_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `classes_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'TĐH01','tdh01','TĐH01',3,'2023-12-01 10:42:05','2023-12-02 08:53:29'),(2,'TĐH02','tdh02','TĐH02',3,'2023-12-02 08:52:20','2023-12-02 08:52:45'),(3,'CNTT01','cntt01','CNTT01',1,'2023-12-02 08:52:34','2023-12-02 08:52:34'),(4,'CNTT02','cntt02','CNTT02',1,'2023-12-02 08:53:42','2023-12-02 08:53:42'),(5,'Khác CNTT','khac-cntt','Không chủ nhiệm lớp nào hoặc chủ nhiệm tạm thời theo sự phân công của nhà trường',1,'2023-12-07 10:54:46','2023-12-07 10:55:49'),(9,'Khác ĐTVT','khac-dtvt','Không chủ nhiệm lớp nào hoặc chủ nhiệm tạm thời theo sự phân công của nhà trường',3,'2023-12-07 10:55:40','2023-12-07 10:55:40');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credit_classes`
--

DROP TABLE IF EXISTS `credit_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `credit_classes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lecturer_id` int unsigned NOT NULL,
  `subject_id` int unsigned NOT NULL,
  `faculty_id` int unsigned NOT NULL,
  `school_year_id` int unsigned NOT NULL,
  `revise_weight` double(8,2) NOT NULL,
  `middle_test_weight` double(8,2) NOT NULL,
  `practice_weight` double(8,2) NOT NULL,
  `attendance_weight` double(8,2) NOT NULL,
  `finish_test_weight` double(8,2) NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credit_classes_code_unique` (`code`),
  KEY `credit_classes_subject_id_foreign` (`subject_id`),
  KEY `credit_classes_faculty_id_foreign` (`faculty_id`),
  KEY `credit_classes_school_year_id_foreign` (`school_year_id`),
  KEY `credit_classes_lecturer_id_foreign_idx` (`lecturer_id`),
  CONSTRAINT `credit_classes_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  CONSTRAINT `credit_classes_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `credit_classes_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`),
  CONSTRAINT `credit_classes_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credit_classes`
--

LOCK TABLES `credit_classes` WRITE;
/*!40000 ALTER TABLE `credit_classes` DISABLE KEYS */;
INSERT INTO `credit_classes` VALUES (13,'Hệ điều hành 2023A','L0003',9,2,1,2,0.10,0.20,0.15,0.05,0.50,'10AM Thứ 3','12AM Thứ 3','2023-12-03 04:19:34','2023-12-03 04:19:34'),(14,'Thuật toán ứng dụng','L0004',9,1,1,2,0.05,0.25,0.30,0.00,0.40,'14h15 PM Thứ 3','17h15 PM Thứ 3','2023-12-07 10:43:10','2023-12-07 10:43:10'),(15,'Lập trình hướng đối tượng','L0001',9,7,1,2,0.20,0.30,0.10,0.00,0.40,'13h PM Thứ 6','16h PM Thứ 6','2023-12-07 10:48:12','2023-12-07 10:48:12'),(16,'Xử lý tín hiệu số','L1000',9,4,3,2,0.20,0.20,0.30,0.00,0.30,'6h45 AM Thứ 2','10h15 AM Thứ 2','2023-12-07 10:49:37','2023-12-07 10:49:37'),(17,'Trí tuệ nhân tạo','L4030',21,8,3,2,0.05,0.15,0.30,0.10,0.40,'15h PM Thứ 4','15h PM Thứ 4','2023-12-11 11:05:25','2023-12-11 11:05:25'),(18,'Xử lý tín hiệu số Kỳ A','L0008',21,4,3,1,0.00,0.10,0.10,0.10,0.70,'14h PM Thứ 5','14h PM Thứ 5','2023-12-12 10:35:58','2023-12-12 10:35:58');
/*!40000 ALTER TABLE `credit_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faculties` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faculties_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES (1,'Khoa CNTT và Truyền thông','khoa-cntt-va-truyen-thong','Technology & Communication','2023-09-24 02:59:39','2023-09-24 02:59:39'),(3,'Khoa Điện tử viễn thông','khoa-dien-tu-vien-thong','Khoa Điện tử viễn thông','2023-12-01 08:14:04','2023-12-01 08:14:04');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `working_process` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` int unsigned NOT NULL,
  `class_id` int unsigned NOT NULL,
  `account_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lectures_faculty_id_foreign` (`faculty_id`),
  KEY `lectures_account_id_foreign` (`account_id`),
  CONSTRAINT `lectures_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `lectures_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

LOCK TABLES `lecturers` WRITE;
/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
INSERT INTO `lecturers` VALUES (1,'<p>Qu&aacute; tr&igrave;nh giảng dạy</p>',3,3,9,'2023-12-02 07:45:01','2023-12-02 11:02:10'),(3,'<p>UET: 2010-2015&nbsp;</p>\r\n\r\n<p>HUST: 2015 - nay&nbsp;</p>',1,4,21,'2023-12-07 10:53:26','2023-12-07 10:53:26');
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_years`
--

DROP TABLE IF EXISTS `school_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `school_years` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `school_years_slug_unique` (`slug`),
  UNIQUE KEY `school_years_session_unique` (`session`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_years`
--

LOCK TABLES `school_years` WRITE;
/*!40000 ALTER TABLE `school_years` DISABLE KEYS */;
INSERT INTO `school_years` VALUES (1,'2022-2023','2022-2023a','A','2022-09-05','2023-01-31','2023-09-16 03:50:12','2023-09-16 04:15:03'),(2,'2022-2023','2022-2023b','B','2023-02-01','2023-06-30','2023-09-16 03:51:51','2023-09-16 04:14:44');
/*!40000 ALTER TABLE `school_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_register_credit_classes`
--

DROP TABLE IF EXISTS `student_register_credit_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_register_credit_classes` (
  `student_id` int unsigned NOT NULL,
  `credit_class_id` int unsigned NOT NULL,
  `registered_at` timestamp NOT NULL,
  `revise_point` double(8,2) NOT NULL DEFAULT '0.00',
  `middle_test_point` double(8,2) NOT NULL DEFAULT '0.00',
  `practice_point` double(8,2) NOT NULL DEFAULT '0.00',
  `attendance_point` double(8,2) NOT NULL DEFAULT '0.00',
  `finish_test_point` double(8,2) NOT NULL DEFAULT '0.00',
  `avg_point` double(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`student_id`,`credit_class_id`),
  KEY `student_register_credit_classes_credit_class_id_foreign` (`credit_class_id`),
  CONSTRAINT `student_register_credit_classes_credit_class_id_foreign` FOREIGN KEY (`credit_class_id`) REFERENCES `credit_classes` (`id`),
  CONSTRAINT `student_register_credit_classes_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_register_credit_classes`
--

LOCK TABLES `student_register_credit_classes` WRITE;
/*!40000 ALTER TABLE `student_register_credit_classes` DISABLE KEYS */;
INSERT INTO `student_register_credit_classes` VALUES (1,14,'2023-12-09 15:44:48',0.00,0.00,0.00,0.00,0.00,0.00),(1,15,'2023-12-09 15:45:01',9.00,8.00,7.00,0.00,9.00,8.50),(1,17,'2023-12-11 18:05:42',8.00,9.00,8.00,8.00,9.00,8.55),(3,13,'2023-12-11 16:50:50',9.00,9.50,9.50,0.00,8.50,8.47),(3,14,'2023-12-11 16:50:56',10.00,10.00,10.00,10.00,10.00,10.00),(3,15,'2023-12-11 16:51:03',9.00,8.00,8.00,9.00,7.00,7.80),(3,17,'2023-12-11 18:05:38',9.00,8.00,9.00,9.00,8.00,8.45),(3,18,'2023-12-12 17:36:07',10.00,7.00,10.00,0.00,8.00,7.30),(4,13,'2023-12-09 15:44:27',0.00,0.00,0.00,0.00,0.00,0.00),(4,14,'2023-12-09 15:44:33',0.00,0.00,0.00,0.00,0.00,0.00),(4,15,'2023-12-09 15:44:40',10.00,10.00,10.00,0.00,9.50,9.80),(4,16,'2023-12-09 15:44:20',0.00,0.00,0.00,0.00,0.00,0.00),(4,17,'2023-12-11 18:05:33',0.00,0.00,0.00,0.00,0.00,0.00);
/*!40000 ALTER TABLE `student_register_credit_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cpa` double(8,2) NOT NULL DEFAULT '0.00',
  `tpa` double(8,2) NOT NULL DEFAULT '0.00',
  `warning_level` int NOT NULL DEFAULT '0',
  `faculty_id` int unsigned NOT NULL,
  `class_id` int unsigned NOT NULL,
  `account_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_faculty_id_foreign` (`faculty_id`),
  KEY `students_class_id_foreign` (`class_id`),
  KEY `students_account_id_foreign` (`account_id`),
  CONSTRAINT `students_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `students_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,0.00,0.00,0,1,3,16,'2023-12-02 09:03:33','2023-12-02 09:03:33'),(3,0.00,0.00,0,3,1,19,'2023-12-02 11:15:30','2023-12-02 11:15:30'),(4,0.00,0.00,0,3,1,20,'2023-12-02 11:16:00','2023-12-02 11:16:00');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_credits` double(8,2) NOT NULL,
  `faculty_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_code_unique` (`code`),
  KEY `subjects_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `subjects_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Cấu trúc dữ liệu và giải thuật','IT1011','Lớp học thuật toán',5.00,1,'2023-12-02 21:38:30','2023-12-02 21:42:07'),(2,'Hệ điều hành','IT1002','Lý thuyết Hệ điều hành',3.00,1,'2023-12-02 21:40:44','2023-12-02 21:40:44'),(4,'Xử lý tín hiệu số','ME1101','Xử lý tín hiệu số',3.00,3,'2023-12-07 10:43:54','2023-12-07 10:43:54'),(5,'Kỹ thuật lập trình','IT2012','Kỹ thuật lập trình',2.00,1,'2023-12-07 10:44:30','2023-12-07 10:44:30'),(6,'Kiến trúc máy tính','IT2013','Kiến trúc máy tính',4.00,1,'2023-12-07 10:44:53','2023-12-07 10:44:53'),(7,'Lập trình hướng đối tượng','IT3001','Lập trình hướng đối tượng',5.00,1,'2023-12-07 10:45:31','2023-12-07 10:45:31'),(8,'Trí tuệ nhân tạo','IT4030','Trí tuệ nhân tạo',4.00,1,'2023-12-11 11:03:36','2023-12-11 11:03:36');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-13 22:53:22
