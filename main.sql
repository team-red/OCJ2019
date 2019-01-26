-- MySQL dump 10.13  Distrib 5.7.22, for Win32 (AMD64)
--
-- Host: localhost    Database: main
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_qst` int(11) NOT NULL,
  `body` varchar(1024) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_qst` (`id_qst`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_qst`) REFERENCES `qst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (62,43,'2',1,2),(63,43,'1',0,0),(64,44,'6',1,3),(65,44,'5',0,1),(66,45,'0',0,0),(67,45,'infini',0,1),(68,45,'indéfini',1,5),(69,46,'2',1,2),(70,46,'1',0,0),(71,47,'6',1,3),(72,47,'5',0,1),(73,48,'0',0,0),(74,48,'infini',0,1),(75,48,'indéfini',1,5),(76,49,'2',1,2),(77,49,'1',0,0),(78,50,'6',1,3),(79,50,'5',0,1),(80,51,'0',0,0),(81,51,'infini',0,1),(82,51,'indéfini',1,5),(83,52,'2',1,2),(84,52,'1',0,0),(85,53,'6',1,3),(86,53,'5',0,1),(87,54,'0',0,0),(88,54,'infini',0,1),(89,54,'indéfini',1,5),(90,55,'2',1,2),(91,55,'1',0,0),(92,56,'6',1,3),(93,56,'5',0,1),(94,57,'0',0,0),(95,57,'infini',0,1),(96,57,'indéfini',1,5);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attempt`
--

DROP TABLE IF EXISTS `attempt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(64) NOT NULL,
  `answer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_id` (`answer_id`),
  KEY `user_login` (`user_login`),
  CONSTRAINT `attempt_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attempt_ibfk_3` FOREIGN KEY (`user_login`) REFERENCES `users` (`login`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attempt`
--

LOCK TABLES `attempt` WRITE;
/*!40000 ALTER TABLE `attempt` DISABLE KEYS */;
/*!40000 ALTER TABLE `attempt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qcm`
--

DROP TABLE IF EXISTS `qcm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qcm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_login` varchar(64) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration_seconds` int(11) DEFAULT NULL,
  `is_corrected` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL,
  `max_score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_login` (`author_login`),
  CONSTRAINT `qcm_ibfk_1` FOREIGN KEY (`author_login`) REFERENCES `users` (`login`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qcm`
--

LOCK TABLES `qcm` WRITE;
/*!40000 ALTER TABLE `qcm` DISABLE KEYS */;
INSERT INTO `qcm` VALUES (32,'admin','2019-01-26 13:58:53',60,0,'Test',10),(33,'admin','2019-01-26 13:59:00',60,0,'Test',10),(34,'admin','2019-01-26 13:59:02',60,0,'Test',10),(35,'admin','2019-01-26 13:59:04',60,0,'Test',10),(36,'admin','2019-01-26 13:59:07',60,0,'Test',10);
/*!40000 ALTER TABLE `qcm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qst`
--

DROP TABLE IF EXISTS `qst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_qcm` int(11) NOT NULL,
  `body` varchar(1024) NOT NULL,
  `max_score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_qcm` (`id_qcm`),
  CONSTRAINT `qst_ibfk_1` FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qst`
--

LOCK TABLES `qst` WRITE;
/*!40000 ALTER TABLE `qst` DISABLE KEYS */;
INSERT INTO `qst` VALUES (43,32,'1+1',2),(44,32,'2*3',3),(45,32,'1/0',5),(46,33,'1+1',2),(47,33,'2*3',3),(48,33,'1/0',5),(49,34,'1+1',2),(50,34,'2*3',3),(51,34,'1/0',5),(52,35,'1+1',2),(53,35,'2*3',3),(54,35,'1/0',5),(55,36,'1+1',2),(56,36,'2*3',3),(57,36,'1/0',5);
/*!40000 ALTER TABLE `qst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stamps`
--

DROP TABLE IF EXISTS `stamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stamps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_qcm` int(11) NOT NULL,
  `user_login` varchar(64) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_qcm` (`id_qcm`),
  KEY `user_login` (`user_login`),
  CONSTRAINT `stamps_ibfk_1` FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`),
  CONSTRAINT `stamps_ibfk_2` FOREIGN KEY (`user_login`) REFERENCES `users` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stamps`
--

LOCK TABLES `stamps` WRITE;
/*!40000 ALTER TABLE `stamps` DISABLE KEYS */;
/*!40000 ALTER TABLE `stamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `login` varchar(64) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(128) NOT NULL,
  `signature` varchar(256) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `school` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `grade` varchar(256) DEFAULT NULL,
  `role` varchar(256) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','e7cdb951fd184861f1d8fa5265948067acc9a639','admin','admin','2008-09-01','admin@qcm',NULL,NULL,NULL,NULL,NULL,'admin'),('user','a0b2b348bb41b00a90d5ea3db8a37028bd08cea3','user','user','2001-05-01','user@qcm',NULL,NULL,NULL,NULL,NULL,'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-26 14:59:42
