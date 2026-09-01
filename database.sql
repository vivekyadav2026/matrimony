-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: manglik_matrimony_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$OhtwEIzoD4ZhbV1Hcq32j.SJZN5A7K7JqBVYoa39RdrCKE6kdu/f2','2026-09-01 00:21:58');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` varchar(10) DEFAULT '',
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `age` int(11) NOT NULL,
  `religion` varchar(50) DEFAULT 'Hindu',
  `caste` varchar(50) NOT NULL,
  `state` varchar(50) DEFAULT 'New Delhi',
  `city` varchar(50) DEFAULT 'New Delhi',
  `education` varchar(100) DEFAULT 'Graduate',
  `occupation` varchar(100) DEFAULT 'Professional',
  `photo` varchar(255) DEFAULT 'shlini.jpg',
  `is_premium` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (7,'M101','Shlini Singh','Female',26,'Hindu','Rajput','Uttar Pradesh','Lucknow','B.Tech IT','Software Engineer','shlini.jpg',1,'active','2026-09-01 00:28:42'),(8,'M102','Rahul Sharma','Male',28,'Hindu','Brahmin','New Delhi','New Delhi','MBA Marketing','Business Analyst','rahul.jpg',1,'active','2026-09-01 00:28:42'),(9,'M103','Bhagyashree Chhetriya','Female',25,'Hindu','Chhetri','New Delhi','New Delhi','B.Des','Interior Designer','bhagyashree.jpg',1,'active','2026-09-01 00:28:42'),(10,'M104','Atul Gulati','Male',29,'Hindu','Punjabi','Delhi','New Delhi','M.Tech Architect','Senior Architect','atul.jpg',1,'active','2026-09-01 00:28:42'),(11,'M105','Ananya Verma','Female',24,'Hindu','Verma','Haryana','Gurugram','B.Com Honours','Financial Analyst','shlini.jpg',0,'active','2026-09-01 00:28:42'),(12,'M106','Rohan Gupta','Male',31,'Hindu','Gupta','Maharashtra','Mumbai','B.E Computer Science','Tech Lead','rahul.jpg',0,'active','2026-09-01 00:28:42'),(13,'M225','Ranjeet maurya','Male',25,'Shikh','NO CASTE','New Delhi','New Delhi','btech','sfy','1788223642_0ef94ea7bc087cd758080ef30c70150c.png',1,'active','2026-09-01 00:47:22'),(15,'M107','Priya Sharma','Female',26,'Hindu','Brahmin','Rajasthan','Jaipur','B.Tech Computer Science','Senior Software Engineer','PREETI.jpg',1,'active','2026-09-01 00:56:24'),(16,'M108','Vikramaditya Singh','Male',30,'Hindu','Rajput','Punjab','Chandigarh','MBA Finance','Investment Banker','Balvinder.jpg',1,'active','2026-09-01 00:56:24'),(17,'M109','Kavya Kulkarni','Female',27,'Hindu','Marathi Brahmin','Maharashtra','Pune','MBBS, MD','Pediatrician Doctor','t2.jpg',1,'active','2026-09-01 00:56:24'),(18,'M110','Aditya Kapoor','Male',28,'Hindu','Punjabi Khatri','Karnataka','Bengaluru','M.Tech Data Science','AI Product Manager','t4.jpg',1,'active','2026-09-01 00:56:24'),(19,'M111','Simran Kaur','Female',25,'Hindu','Sikh Jat','Punjab','Ludhiana','M.Sc Fashion Design','Apparel Brand Director','t3.jpg',0,'active','2026-09-01 00:56:24'),(20,'M112','Deepak Agarwal','Male',32,'Hindu','Agarwal Bania','Delhi','Delhi','Chartered Accountant (CA)','Senior Audit Manager','rahul.jpg',0,'active','2026-09-01 00:56:24'),(21,'M113','Neha Srivastava','Female',28,'Hindu','Kayastha','Uttar Pradesh','Lucknow','MBA Human Resources','Global HR Lead','shlini.jpg',0,'active','2026-09-01 00:56:24'),(22,'M114','Harshvardhan Jain','Male',29,'Hindu','Jain','Gujarat','Ahmedabad','B.E Chemical Engineering','Pharma Business Executive','atul.jpg',0,'active','2026-09-01 00:56:24');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `success_stories`
--

DROP TABLE IF EXISTS `success_stories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `success_stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `story` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `story_date` varchar(50) DEFAULT '',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `success_stories`
--

LOCK TABLES `success_stories` WRITE;
/*!40000 ALTER TABLE `success_stories` DISABLE KEYS */;
INSERT INTO `success_stories` VALUES (5,'ANIT & TRILOK','Found my soulmate through Sainmatrimony.in. The verified profiles made our matchmaking smooth and trustworthy.','story1.jpg','15 August 2024','active','2026-09-01 00:31:36'),(6,'DEVESH & POOJA','Best matrimony platform for mangliks! We connected easily and families agreed immediately.','story2.jpg','10 September 2024','active','2026-09-01 00:31:36'),(7,'PREETI & AMRIK','We got married with blessings of family and Sainmatrimony.in. Truly thankful for this wonderful platform.','story3.jpg','04 November 2024','active','2026-09-01 00:31:36'),(8,'BALVINDER & SAKSHI','Highly recommended site for finding genuine soulmates. Easy search & quick response.','story4.jpg','18 December 2024','active','2026-09-01 00:31:36');
/*!40000 ALTER TABLE `success_stories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-01  6:34:46
