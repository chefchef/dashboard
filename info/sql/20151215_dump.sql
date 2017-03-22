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
INSERT INTO `dashboards` VALUES ('a160d95b-0de0-4e50-9f61-2cdd494c2623','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','Dashboard 1'),('a160d95b-0d
e0-4e50-9f61-2cdd494c2623','66fea2ef-f3c7-4e46-8ad5-9bffec2ca00e','Dashboard 1'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','d5d4d431-f2db-4bd
6-8d40-ca755aa00ab0','Dashboard 1'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','ed306948-80bf-45cf-9603-26f44574df75','Dashboard 1');
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
INSERT INTO `users` VALUES ('038ed949-616b-4940-8422-e191984a35d4','aa@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdO.nElZ0Vuxz6BSazq5lPPfS6YL.BD
nlm'),('735775e0-6d1e-45f3-9d89-ebdd94b5c9d0','chefuri2@gmail.com','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('67ba16
8b-0af3-4447-8696-c34ec491bfca','eduheredia2@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('8aec020e-a523-4d8a
-af3d-ba380b8e4f22','eduheredia3@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG'),('3369127f-9fb9-48b3-941c-24734a
af5034','eduheredia6@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOhogKkUqxBx/2i0lsJED7ECAXx2aHye6'),('a160d95b-0de0-4e50-9f61-2cdd494c2623','edu
heredia@yahoo.es','$2y$10$adsdgasd5asd4asdafgsdOsR5ur/r5hUcQGu77K1WrDg/1OYmGzPG');
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
INSERT INTO `widgets` VALUES ('1','clock'),('2','test'),('3','cpu'),('4','memory'));
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
INSERT INTO `widgets_instances` VALUES ('3eb06714-00a0-46b6-a233-3c7e761da94a','2','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','',200,200,295,17
5),('7984f072-bf49-4d6d-9ec9-5b1a1131326c','2','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','',200,200,81,91),('89672936-b9c6-4d96-8d75-4974d63d7
f6a','1','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','',200,200,256,86),('a32471cd-9f42-434a-a178-e3a3e8fde323','3','11b9a0d2-4d6c-4f3a-b3fd-c5b
a4973e30f','',200,200,0,0),('ceb70114-b5ee-4468-bbfc-3f5343794e6b','1','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','',200,200,68,63),('ef6c65bf-
2043-425c-af3f-52cff0b1b677','3','11b9a0d2-4d6c-4f3a-b3fd-c5ba4973e30f','',200,200,0,0);
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

-- Dump completed on 2015-12-15 21:08:29