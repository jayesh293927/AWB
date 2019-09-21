-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: AWB
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.16.04.1

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
-- Table structure for table `chorddetails`
--

DROP TABLE IF EXISTS `chorddetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chorddetails` (
  `chord_id` int(10) NOT NULL AUTO_INCREMENT,
  `chord_name` varchar(255) NOT NULL,
  `chord_path` varchar(255) NOT NULL,
  `chord_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`chord_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chorddetails`
--

LOCK TABLES `chorddetails` WRITE;
/*!40000 ALTER TABLE `chorddetails` DISABLE KEYS */;
INSERT INTO `chorddetails` VALUES (1,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 09:14:57'),(2,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 10:08:50'),(3,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 10:09:19'),(4,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 10:25:09'),(5,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 10:38:29'),(6,'django-rest-framework-tipstricks.pdf','./uploads/chords/','2019-09-21 10:52:31');
/*!40000 ALTER TABLE `chorddetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleryimagedetails`
--

DROP TABLE IF EXISTS `galleryimagedetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleryimagedetails` (
  `image_id` int(10) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleryimagedetails`
--

LOCK TABLES `galleryimagedetails` WRITE;
/*!40000 ALTER TABLE `galleryimagedetails` DISABLE KEYS */;
INSERT INTO `galleryimagedetails` VALUES (1,'img4.jpg','./uploads/gallery/','2019-09-21 10:11:07'),(2,'img4.jpg','./uploads/gallery/','2019-09-21 10:16:54'),(3,'img4.jpg','./uploads/gallery/','2019-09-21 10:24:18'),(4,'img4.jpg','./uploads/gallery/','2019-09-21 10:30:18'),(5,'img4.jpg','./uploads/gallery/','2019-09-21 10:35:56'),(6,'img4.jpg','./uploads/gallery/','2019-09-21 10:39:20'),(7,'img4.jpg','./uploads/gallery/','2019-09-21 10:39:43'),(8,'img4.jpg','./uploads/gallery/','2019-09-21 10:40:04'),(9,'img3.jpg','./uploads/gallery/','2019-09-21 10:40:10'),(10,'img4.jpg','./uploads/gallery/','2019-09-21 10:41:34'),(11,'img3.jpg','./uploads/gallery/','2019-09-21 10:42:06'),(12,'img3.jpg','./uploads/gallery/','2019-09-21 10:43:20'),(13,'img4.jpg','./uploads/gallery/','2019-09-21 10:43:58'),(14,'img4.jpg','./uploads/gallery/','2019-09-21 10:44:23'),(15,'img4.jpg','./uploads/gallery/','2019-09-21 10:47:55'),(16,'img4.jpg','./uploads/gallery/','2019-09-21 10:50:50'),(17,'img4.jpg','./uploads/gallery/','2019-09-21 10:51:28');
/*!40000 ALTER TABLE `galleryimagedetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdetails`
--

DROP TABLE IF EXISTS `userdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdetails` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `contact_number` decimal(10,0) DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdetails`
--

LOCK TABLES `userdetails` WRITE;
/*!40000 ALTER TABLE `userdetails` DISABLE KEYS */;
INSERT INTO `userdetails` VALUES (1,'dharmendra','456','abcd123@abc.com',9999999999,'2019-09-07 17:17:43'),(2,'alex','456','abcd123@abc.com',9999999999,'2019-09-07 17:17:43');
/*!40000 ALTER TABLE `userdetails` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-21 17:15:23
