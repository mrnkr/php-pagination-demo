-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: random_gym
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB-0+deb9u1

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
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `picture_url` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,'Casin','images/casin.png'),(2,'Futbol','images/soccer.png'),(3,'Bochas','images/bochas.png'),(4,'Truco','images/truco.png');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  KEY `id` (`id`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `affiliate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (7),(21);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `affiliate`
--

DROP TABLE IF EXISTS `affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliate` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliate`
--

LOCK TABLES `affiliate` WRITE;
/*!40000 ALTER TABLE `affiliate` DISABLE KEYS */;
INSERT INTO `affiliate` VALUES (1,'Frank','Borer','2018-04-17','7566 Dorothy Spurs','064.983.1102','007d83e389a6b966f9ccf6d87933d87f','Deon9@yahoo.com','http://lorempixel.com/640/480'),(2,'Kyra','Green','2018-06-09','Avenida de la Merluza 123','099123345','1d00adbcf86ffc7d12b33c92abc4d590','Keaton_Nienow0@yahoo.com','http://lorempixel.com/640/480'),(3,'Oren','Bins','2018-12-25','48415 Ida Course','524.454.1870 x8682','351c0e11c5859ace8bd5acde5375d000','Elinor73@hotmail.com','http://lorempixel.com/640/480'),(4,'Karelle','Crist','2018-08-15','7614 Sim Brook','1-339-668-3229 x7872','44e3437e62543c1ca29f36d8e787db5e','Alejandrin.Ward@hotmail.com','http://lorempixel.com/640/480'),(5,'Barney','Swaniawski','2018-03-07','341 Mayert Terrace','1-185-256-2096','d52cf50b4c3fff653fb8f388229959bc','Lessie.Bogisich@hotmail.com','http://lorempixel.com/640/480'),(6,'Buster','Mante','2018-09-22','6775 Jaskolski Corners','(397) 079-0802 x6602','286379fb280556f8673563a9df7ded96','Imelda.Mann36@gmail.com','http://lorempixel.com/640/480'),(7,'Breana','Corwin','2018-05-20','7162 Schumm Rapids','305-298-2311 x180','35020a52942f83eed0272673e0f3bb0e','Kitty_Barrows@hotmail.com','http://lorempixel.com/640/480'),(8,'Jody','Reynolds','2018-03-09','530 Goodwin Trail','1-370-710-0895 x588','00d24a7d7d236829db50b78904398483','Rasheed_Towne20@gmail.com','http://lorempixel.com/640/480'),(9,'Kylee','Mohr','2018-09-20','2069 Hand Creek','(112) 672-5778 x4539','8508d0bfba40481b84379ffb3bde5b11','Monroe.Runolfsson11@hotmail.com','http://lorempixel.com/640/480'),(10,'Joanne','Barton','2018-06-13','3618 Toy Rapids','539.204.3229','d75d4a8c894132fdc8faae5a0c0f81a8','Caitlyn.Jakubowski66@gmail.com','http://lorempixel.com/640/480'),(11,'Talon','Dicki','2018-06-04','890 Fadel Cove','1-772-283-2321','e6cb6e420d5fbf6a48b7ef49c291e85c','Israel.Connelly@hotmail.com','http://lorempixel.com/640/480'),(12,'Marshall','Schuppe','2018-11-21','389 Wolff Stream','1-216-620-7482 x615','495006818cc0b9e71d55265ee652c2de','Zack.Langosh@yahoo.com','http://lorempixel.com/640/480'),(13,'Edwina','Harvey','2018-12-10','4201 Larkin Camp','(044) 488-7362 x788','6aef56a17455424edf9b98c6837ffba6','Joanny.Mann8@hotmail.com','http://lorempixel.com/640/480'),(14,'Fausto','Stoltenberg','2018-12-05','260 Keara Common','1-497-508-5530 x1459','bb8d16f4097cb84eb0594457fcdd1a87','Armani.Hansen49@yahoo.com','http://lorempixel.com/640/480'),(15,'Lamont','Huels','2018-09-06','870 Luz Drive','542-531-1234 x967','15664537058ceb6f2b3ec5e53425b398','Reilly_Kerluke@yahoo.com','http://lorempixel.com/640/480'),(16,'Juliet','Vandervort','2018-04-06','895 Misty Forge','(068) 932-8874','b3f55c9ea1f1db69b7988c281e5f6443','Lonie68@gmail.com','http://lorempixel.com/640/480'),(17,'Kyra','Zieme','2018-05-16','5021 Crystel Rapid','162-974-9761','50f1fa94c464661fcb4b07bf8a49188e','Kaycee46@yahoo.com','http://lorempixel.com/640/480'),(18,'Donnie','Reynolds','2018-04-28','607 Kutch Trace','061-516-4513 x156','6b006658aca8843d2e041bde209dd4bb','Amanda33@hotmail.com','http://lorempixel.com/640/480'),(19,'Ellis','Barton','2018-07-30','916 Emery Crossroad','884.755.1132 x92021','d14eeb9f5558d9fda3be71ecf574284d','Hollis_Kuhlman73@yahoo.com','http://lorempixel.com/640/480'),(20,'Chance','Heidenreich','2018-07-17','45942 Hegmann Parks','1-473-098-7373 x8863','039420af57dd01d713ac13fdee5ad692','Otto7@yahoo.com','http://lorempixel.com/640/480'),(21,'Jaycee','Klein','2018-06-13','76715 Russel Hill','(396) 886-0750 x0683','f174ee710ab8ff3e7f58f8cbe59bda9a','Manley_Hauck@hotmail.com','http://lorempixel.com/640/480'),(22,'Evelyn','Boyle','2018-10-24','10551 Hartmann Loaf','230.967.5419','29060c32969c727918717e774481ddcf','London88@gmail.com','http://lorempixel.com/640/480'),(23,'Brady','Reichel','2018-07-12','5713 Myriam Mews','(862) 199-5492 x85216','6bd8881316c56372d15e4b1e11c4c814','Roman_Kuvalis@gmail.com','http://lorempixel.com/640/480'),(24,'Isai','Streich','2018-07-08','62908 Ashlynn Street','885-834-4905 x4254','32afd47b53de1ca2d15e5fef30ea7cac','Matteo88@hotmail.com','http://lorempixel.com/640/480'),(25,'Dusty','Ratke','2018-04-01','6041 Stracke Viaduct','1-952-150-9776','26740207cb309f92ef6237245e523290','Earl.Beer@hotmail.com','http://lorempixel.com/640/480'),(26,'Aubrey','Runolfsson','2018-04-06','6582 Bayer Park','145-770-6287','5fe607b508dec274a374ec4b03775b3f','Maud_Crona@hotmail.com','http://lorempixel.com/640/480'),(27,'Vincenzo','Schuppe','2018-04-23','428 Johnson Oval','566-109-8764','6a1431c0439a7bafed088209151b1e83','Daron.Johnson98@hotmail.com','http://lorempixel.com/640/480'),(28,'Lora','Littel','2018-08-18','8034 Vicky Brook','488-872-0642 x463','cb6cb6f09aa2218df8eeaa445be44a1c','Cleo.Watsica@gmail.com','http://lorempixel.com/640/480'),(29,'Samantha','Sauer','2018-08-11','878 Green Village','029.005.6026','0abc7619b7c8a34921664c0312c4b573','Kevin32@gmail.com','http://lorempixel.com/640/480'),(30,'Hilario','Durgan','2018-08-28','479 Erik Dale','(193) 700-5949','54d760993d383e5ab794017de532a12b','Salvador.Graham91@hotmail.com','http://lorempixel.com/640/480');
/*!40000 ALTER TABLE `affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  KEY `id` (`id`),
  CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id`) REFERENCES `affiliate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1),(2),(3),(4),(5),(6),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20),(22),(23),(24),(25),(26),(27),(28),(29),(30);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partake`
--

DROP TABLE IF EXISTS `partake`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partake` (
  `member_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`member_id`,`activity_id`),
  KEY `id_socio` (`member_id`),
  KEY `id_actividad` (`activity_id`),
  CONSTRAINT `FK_Activity` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  CONSTRAINT `FK_Associate` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partake`
--

LOCK TABLES `partake` WRITE;
/*!40000 ALTER TABLE `partake` DISABLE KEYS */;
INSERT INTO `partake` VALUES (1,1),(1,2),(2,3),(3,2),(4,1),(5,1),(5,4),(6,2),(6,3),(6,4),(8,1),(8,4),(9,2),(10,1),(10,2),(10,4),(11,1),(11,2),(11,3),(12,3),(14,2),(15,1),(16,1),(17,4),(18,4),(20,3),(20,4),(24,4),(25,1),(25,3),(26,1),(27,4),(28,1),(28,4),(29,2),(29,3),(30,1),(30,2),(30,3);
/*!40000 ALTER TABLE `partake` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-04 21:36:04
