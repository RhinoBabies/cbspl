-- MySQL dump 10.16  Distrib 10.1.28-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: my_cbspl
-- ------------------------------------------------------
-- Server version	10.1.28-MariaDB

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
-- Table structure for table `pl_adds`
--

DROP TABLE IF EXISTS `pl_adds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_adds` (
  `Username` varchar(15) NOT NULL,
  `ISBN_10_Added` varchar(10) NOT NULL,
  `Quality` varchar(15) NOT NULL,
  `Cost` decimal(5,2) DEFAULT NULL,
  `SellType` int(1) NOT NULL,
  `Description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`Username`,`ISBN_10_Added`),
  KEY `FKBOOK` (`ISBN_10_Added`),
  CONSTRAINT `FKBOOK` FOREIGN KEY (`ISBN_10_Added`) REFERENCES `pl_book` (`ISBN_10`),
  CONSTRAINT `FKUSER` FOREIGN KEY (`Username`) REFERENCES `pl_user` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pl_adds`
--

LOCK TABLES `pl_adds` WRITE;
/*!40000 ALTER TABLE `pl_adds` DISABLE KEYS */;
/*!40000 ALTER TABLE `pl_adds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pl_book`
--

DROP TABLE IF EXISTS `pl_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_book` (
  `ISBN_10` varchar(10) NOT NULL,
  `ISBN_13` varchar(13) DEFAULT NULL,
  `TITLE` varchar(30) NOT NULL,
  `CATEGORY` varchar(15) DEFAULT NULL,
  `AUTHOR` varchar(30) NOT NULL,
  `EDITION` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`ISBN_10`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pl_book`
--

LOCK TABLES `pl_book` WRITE;
/*!40000 ALTER TABLE `pl_book` DISABLE KEYS */;
/*!40000 ALTER TABLE `pl_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pl_user`
--

DROP TABLE IF EXISTS `pl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pl_user` (
  `Username` varchar(15) NOT NULL,
  `EmailReal` varchar(37) NOT NULL,
  `EmailAnon` varchar(37) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `LastLoginDate` date NOT NULL,
  `Verified` tinyint(1) NOT NULL,
  `VerifyCode` varchar(60) NOT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `Email` (`EmailReal`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `EmailAnon` (`EmailAnon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pl_user`
--

LOCK TABLES `pl_user` WRITE;
/*!40000 ALTER TABLE `pl_user` DISABLE KEYS */;
INSERT INTO `pl_user` VALUES ('Kurt','shuma008@cougars.csusm.edu','user-Kurt@peer-library.com','$2y$10$ax52Z44crcD93hHFQWSdje3DEI15LJ2K6KTNghKw9fBTPmyntBGm6','0000-00-00',1,'$2y$10$Rh685DiYMwivl9Uyae6Q1uNM5sreGb1.LQ.cCEVmxn.12YHu5UVUK');
/*!40000 ALTER TABLE `pl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-13  6:55:52
