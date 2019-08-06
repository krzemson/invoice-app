-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for osx10.10 (x86_64)
--
-- Host: 127.0.0.1    Database: faktury
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `nip` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `regon` varchar(9) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,1,'Tomasz','Krzemiński','RciEx Tomasz Krzemiński','Wilcza 11','Słupno','583332211','532221923'),(2,2,'Mateusz','Bolec','Bolex','Czwartaków 8','Płock','533221232','532324554'),(3,1,'Jarosław','Krzemiński','TechTom','Wilcza 4','Szeligi','33223003','21223442'),(4,1,'Marek','Topa','ToPex','Topolowa 5','Brodnica','22333223','22212222'),(5,1,'Janusz','Korwin-Mikke','Korwix','Sienkiewicza 34','Warszawa','9992223339','222888855');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invnum` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `net_value` decimal(8,2) NOT NULL,
  `tax_value` decimal(8,2) NOT NULL,
  `gross_value` decimal(8,2) NOT NULL,
  `payment` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `term_payment` date NOT NULL,
  `inwords` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `date_issue` date NOT NULL,
  `date_service` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invnum` (`invnum`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (36,1,1,'FK/2019',238.33,54.81,293.14,'Gotówka','2019-02-08','dwieście dziewięćdziesiąt trzy złote czternaście groszy','2019-02-08','2019-02-08'),(37,1,1,'FK/2020',499.98,114.99,614.97,'Przelew - 14 dni','2019-02-22','sześćset czternaście złotych dziewięćdziesiąt siedem groszy','2019-02-08','2019-02-08'),(38,1,1,'FK/2032',199.12,135.22,344.21,'gotowka','2019-05-21','stopiecsietw','2018-06-01','2018-06-01');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoicesP`
--

DROP TABLE IF EXISTS `invoicesP`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoicesP` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `invnum` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `net_value` decimal(8,2) NOT NULL,
  `tax_value` decimal(8,2) NOT NULL,
  `gross_value` decimal(8,2) NOT NULL,
  `payment` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `term_payment` date NOT NULL,
  `inwords` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `date_issue` date NOT NULL,
  `date_service` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`supplier_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `invoicesp_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `invoicesp_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoicesP`
--

LOCK TABLES `invoicesP` WRITE;
/*!40000 ALTER TABLE `invoicesP` DISABLE KEYS */;
INSERT INTO `invoicesP` VALUES (1,1,1,'FK/2019',238.33,54.81,293.14,'Gotówka','2019-02-08','dwieście dziewięćdziesiąt trzy złote czternaście groszy','2019-02-08','2019-02-08');
/*!40000 ALTER TABLE `invoicesP` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `net` decimal(8,2) NOT NULL,
  `netv` decimal(8,2) NOT NULL,
  `tax` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `taxv` decimal(8,2) NOT NULL,
  `gross` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (47,36,'Hitman 2',1,'szt',238.33,238.33,'0.23',54.81,293.14),(48,37,'Arma 3',2,'szt',249.99,499.98,'0.23',114.99,614.97);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `nip` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `regon` varchar(9) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,1,'Tomasz','Krzemiński','RciEx Tomasz Krzemiński','Wilcza 11','Słupno','583332211','532221923'),(2,2,'Mateusz','Bolec','Bolex','Czwartaków 8','Płock','533221232','532324554'),(3,1,'Jarosław','Krzemiński','TechTom','Wilcza 4','Szeligi','33223003','21223442'),(4,1,'Marek','Topa','ToPex','Topolowa 5','Brodnica','22333223','22212222');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `nip` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `regon` varchar(9) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'kubson','Jakub','Krzemiński','Usługi informatyczne COLSPAN Jakub Krzemiński','Pohulanka 8F/6','Gdańsk','1112333999','222333662','krzeminiak10@gmail.com','$2y$10$JNaxY/ilQMQ4lhFfM2nLnu4zv.TRJrtpHTh6a56bzs/RexoND//RK'),(2,'maq','Maciek','Hol','','','','0','0','blabla@wp.pl','men123'),(3,'hit','Bartek','Koterski','','','','0','0','kot@onet.pl','kta123');
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

-- Dump completed on 2019-08-06 13:11:21
