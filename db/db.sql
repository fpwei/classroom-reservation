-- MySQL dump 10.16  Distrib 10.1.13-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: WEB
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `APPLY`
--

DROP TABLE IF EXISTS `APPLY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `APPLY` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `PLACE_SEQNO` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `STATUS` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'U',
  `USER_SEQNO` int(11) NOT NULL,
  `CREATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `CREATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `UPDATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SEQNO`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `APPLY`
--

LOCK TABLES `APPLY` WRITE;
/*!40000 ALTER TABLE `APPLY` DISABLE KEYS */;
INSERT INTO `APPLY` VALUES (16,2,'2016-06-18','8,9,10','A',6,'TEST','2016-06-15 07:49:20','TEST','2016-06-15 07:50:07'),(17,4,'2016-06-25','14,15,16','U',6,'TEST','2016-06-15 07:49:32','TEST','2016-06-15 07:49:32'),(18,3,'2016-06-30','12','R',6,'TEST','2016-06-15 07:49:43','TEST','2016-06-15 07:50:14'),(19,1,'2016-06-16','9,10,11','U',7,'TEST','2016-06-15 07:54:42','TEST','2016-06-15 07:54:42'),(20,4,'2016-06-16','9,10,11','A',6,'TEST','2016-06-15 11:22:15','TEST','2016-06-15 11:25:00');
/*!40000 ALTER TABLE `APPLY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CATALOG`
--

DROP TABLE IF EXISTS `CATALOG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CATALOG` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `DISPLAY_NAME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `IS_ACTIVITY` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `CREATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `CREATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `UPDATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SEQNO`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CATALOG`
--

LOCK TABLES `CATALOG` WRITE;
/*!40000 ALTER TABLE `CATALOG` DISABLE KEYS */;
INSERT INTO `CATALOG` VALUES (1,'國秀樓','1','TEST','2016-06-06 07:15:52','admin','2016-06-15 11:25:51'),(2,'工程館','1','TEST','2016-06-06 07:22:01','TEST','2016-06-06 07:22:01'),(13,'test','1','admin','2016-06-15 11:26:00','admin','2016-06-15 11:26:00');
/*!40000 ALTER TABLE `CATALOG` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PLACE`
--

DROP TABLE IF EXISTS `PLACE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PLACE` (
  `SEQNO` int(11) NOT NULL AUTO_INCREMENT,
  `DISPLAY_NAME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `IS_ACTIVITY` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `CATALOG_SEQNO` int(11) DEFAULT NULL,
  `CREATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `CREATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TEST',
  `UPDATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SEQNO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PLACE`
--

LOCK TABLES `PLACE` WRITE;
/*!40000 ALTER TABLE `PLACE` DISABLE KEYS */;
INSERT INTO `PLACE` VALUES (1,'國秀樓301教室','1',1,'TEST','2016-06-06 07:27:17','TEST','2016-06-06 07:27:17'),(2,'國秀樓302教室','1',1,'TEST','2016-06-06 07:27:23','TEST','2016-06-06 07:27:23'),(3,'國秀樓303教室','1',1,'TEST','2016-06-06 07:27:28','TEST','2016-06-06 07:27:28'),(4,'E418','1',2,'TEST','2016-06-06 07:40:16','TEST','2016-06-06 07:40:16'),(5,'E420','1',2,'TEST','2016-06-06 07:40:21','TEST','2016-06-06 07:40:21');
/*!40000 ALTER TABLE `PLACE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SCHEDULE`
--

DROP TABLE IF EXISTS `SCHEDULE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SCHEDULE` (
  `PLACE_SEQNO` int(11) NOT NULL,
  `0000_0100` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0100_0200` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0200_0300` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0300_0400` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0400_0500` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0500_0600` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0600_0700` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0700_0800` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0800_0900` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `0900_1000` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1000_1100` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1100_1200` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1200_1300` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1300_1400` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1400_1500` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1500_1600` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1600_1700` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1700_1800` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1800_1900` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `1900_2000` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `2000_2100` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `2100_2200` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `2200_2300` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `2300_0000` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `CREATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `CREATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATE_USER` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `UPDATE_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DATE` date NOT NULL,
  PRIMARY KEY (`PLACE_SEQNO`,`DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SCHEDULE`
--

LOCK TABLES `SCHEDULE` WRITE;
/*!40000 ALTER TABLE `SCHEDULE` DISABLE KEYS */;
INSERT INTO `SCHEDULE` VALUES (1,'0','0','0','0','0','0','0','0','0','1','1','1','0','0','0','0','0','0','0','0','0','0','0','0','auto','2016-06-15 07:54:42','auto','2016-06-15 07:54:42','2016-06-16'),(2,'0','0','0','0','0','0','0','0','2','2','2','0','0','0','0','0','0','0','0','0','0','0','0','0','auto','2016-06-15 07:49:20','auto','2016-06-15 07:50:07','2016-06-18'),(3,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','auto','2016-06-15 07:49:43','auto','2016-06-15 07:50:14','2016-06-30'),(4,'0','0','0','0','0','0','0','0','0','2','2','2','0','0','0','0','0','0','0','0','0','0','0','0','auto','2016-06-15 11:22:15','auto','2016-06-15 11:25:00','2016-06-16'),(4,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','1','1','0','0','0','0','0','0','0','auto','2016-06-15 07:49:32','auto','2016-06-15 07:49:32','2016-06-25');
/*!40000 ALTER TABLE `SCHEDULE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCOUNT` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `IS_ADMIN` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES (5,'admin','e10adc3949ba59abbe56e057f20f883e','1'),(6,'zzz','f3abb86bd34cf4d52698f14c0da1dc60','0'),(7,'xxx','f561aaf6ef0bf14d4208bb46a4ccb3ad','0'),(8,'aaa','47bce5c74f589f4867dbd57e9ca9f808','0');
/*!40000 ALTER TABLE `USER` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-21 22:18:25
