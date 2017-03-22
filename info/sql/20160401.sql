-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: projecte
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.12.04.2

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

CREATE DATABASE IF NOT EXISTS projecte ;

--
-- Table structure for table `dashboards`
--

DROP TABLE IF EXISTS `dashboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboards` (
  `idUser` varchar(40) COLLATE utf8_bin NOT NULL,
  `id` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idUser`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboards`
--

LOCK TABLES `dashboards` WRITE;
/*!40000 ALTER TABLE `dashboards` DISABLE KEYS */;
INSERT INTO `dashboards` VALUES ('a160d95b-0de0-4e50-9f61-2cdd494c2623','8369a3fb-323e-4463-b5b5-5aa981bc3a86','a'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','
af6c972c-1d02-495b-a9ce-7610dd40ef99','realtime'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','d3a3b2b8-0a49-467c-a2c8-642d6c5931d1','Prueba'),('a160d95b-0de0-4e
50-9f61-2cdd494c2623','e8667308-a9cf-4255-96d9-a1a3ad520ebb','Prueba2');
/*!40000 ALTER TABLE `dashboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idUser` varchar(40) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `passw` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('038ed949-616b-4940-8422-e191984a35d4','aa@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdO.nElZ0Vuxz6BSazq5lPPfS6YL.BDnlm'),('735775e0-6
d1e-45f3-9d89-ebdd94b5c9d0','chefuri2@gmail.com','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('67ba168b-0af3-4447-8696-c34ec491bfca','edu
heredia2@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('8aec020e-a523-4d8a-af3d-ba380b8e4f22','eduheredia3@yahoo.es','$2y$10$ads
dgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('3369127f-9fb9-48b3-941c-24734aaf5034','eduheredia6@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOhogKkUqxBx/
2i0lsJED7ECAXx2aHye6'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','eduheredia@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets` (
  `id` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets`
--

LOCK TABLES `widgets` WRITE;
/*!40000 ALTER TABLE `widgets` DISABLE KEYS */;
INSERT INTO `widgets` VALUES ('1','clock'),('2','test'),('3','cpu'),('4','memory'),('5','text'),('6','other'),('7','weather'),('8','special');
/*!40000 ALTER TABLE `widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets_instances`
--

DROP TABLE IF EXISTS `widgets_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets_instances` (
  `id` varchar(40) COLLATE utf8_bin NOT NULL,
  `idWidget` varchar(40) COLLATE utf8_bin NOT NULL,
  `idDashboard` varchar(40) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `sizeX` smallint(3) NOT NULL,
  `sizeY` smallint(3) NOT NULL,
  `positionX` smallint(3) NOT NULL,
  `positionY` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets_instances`
--

LOCK TABLES `widgets_instances` WRITE;
/*!40000 ALTER TABLE `widgets_instances` DISABLE KEYS */;
INSERT INTO `widgets_instances` VALUES ('22216dee-ae87-4652-ab3c-86bb256a6079','3','e8667308-a9cf-4255-96d9-a1a3ad520ebb','',200,200,575,220),('2e29b843-99ee
-45d6-acf8-52f5a7bff8cf','3','af6c972c-1d02-495b-a9ce-7610dd40ef99','',200,200,399,93),('3ccb5148-0051-4626-9a59-fe3266e0c180','3','d3a3b2b8-0a49-467c-a2c8-6
42d6c5931d1','',269,264,547,24),('3da4273e-226f-465a-9849-00233a81b38f','4','e8667308-a9cf-4255-96d9-a1a3ad520ebb','',200,200,575,220),('5c5ab8a3-0934-42ac-9
6bd-b394afc466d7','4','af6c972c-1d02-495b-a9ce-7610dd40ef99','',200,200,422,272),('617ef346-5986-4095-9d29-b747bd373481','1','af6c972c-1d02-495b-a9ce-7610dd4
0ef99','',200,200,68,291),('6a7dbf8a-d481-4ad9-8603-e1a2faaea618','1','d3a3b2b8-0a49-467c-a2c8-642d6c5931d1','',200,200,61,7),('6f5a0234-4ec9-49b0-99f2-adeda
19e8699','1','8369a3fb-323e-4463-b5b5-5aa981bc3a86','',200,200,131,117),('a2dcf744-c116-4518-91c3-97a331deb605','3','e8667308-a9cf-4255-96d9-a1a3ad520ebb',''
,200,200,100,322),('b0e876b9-5293-4155-8894-2fbf4fee7b68','2','af6c972c-1d02-495b-a9ce-7610dd40ef99','',200,200,143,61),('e2712927-740e-48b2-a1eb-c2659330855
b','2','d3a3b2b8-0a49-467c-a2c8-642d6c5931d1','',251,158,78,318),('e8677064-6d99-4427-b8cf-41b0bd886af4','1','d3a3b2b8-0a49-467c-a2c8-642d6c5931d1','',200,20
0,540,226),('fb7b1826-24fe-40f6-baa3-83c5a487c972','4','d3a3b2b8-0a49-467c-a2c8-642d6c5931d1','',197,217,333,27);
/*!40000 ALTER TABLE `widgets_instances` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-04 19:55:47


DROP TABLE IF EXISTS `widget_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widget_type` (
  `idWidget` varchar(255) COLLATE utf8_bin NOT NULL,
  `data` BLOB,
  PRIMARY KEY (`idWidget`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

