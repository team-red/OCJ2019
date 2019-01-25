-- MySQL dump 10.14  Distrib 5.5.60-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: main
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (2,8,'Ahmed',0,1),(3,8,'Taha',0,2),(4,8,'Ahmed Taha',1,3),(5,9,'1997',0,1),(6,9,'111997',0,2),(7,9,'10111997',1,3);
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
  `start_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_id` (`answer_id`),
  KEY `user_login` (`user_login`),
  CONSTRAINT `attempt_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attempt_ibfk_3` FOREIGN KEY (`user_login`) REFERENCES `users` (`login`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qcm`
--

LOCK TABLES `qcm` WRITE;
/*!40000 ALTER TABLE `qcm` DISABLE KEYS */;
INSERT INTO `qcm` VALUES (16,'example','2019-01-25 15:08:50',5,0,'Test 1',6);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qst`
--

LOCK TABLES `qst` WRITE;
/*!40000 ALTER TABLE `qst` DISABLE KEYS */;
INSERT INTO `qst` VALUES (8,16,'What\'s my name?',3),(9,16,'When was I born?',3);
/*!40000 ALTER TABLE `qst` ENABLE KEYS */;
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
INSERT INTO `users` VALUES ('ayoub','132b19de24d66d2ab7d33b39bcf84bb222b9618e','Foussoul','Ayoub','1997-03-02','ayoubfoussoul@gmail.com',NULL,NULL,NULL,NULL,NULL,'admin'),('example','56ce215889eda6e7409cea0406c849e85742ed54','example','example','2011-01-01','example@exmaple',NULL,NULL,NULL,NULL,NULL,'admin'),('test','2aebbebe071f7013a59a6d2beda337a5514a2a69','test','test','2005-01-01','test@test',NULL,NULL,NULL,NULL,NULL,'admin'),('test2','14b6d99a50e875a6798b1aec06c4574c9bcfd233','test2','test2','2014-01-01','test2@test',NULL,NULL,NULL,NULL,NULL,'user');
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

-- Dump completed on 2019-01-25 17:40:07
