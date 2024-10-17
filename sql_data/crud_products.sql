-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (x86_64)
--
-- Host: 34.173.30.56    Database: crud
-- ------------------------------------------------------
-- Server version	8.0.31-google

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '27ac7df1-7bf7-11ef-8391-4201ac169002:1-415';

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1221234 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Lamborghini Aventador SVJ','The ultimate expression of Lamborghini, combining extreme performance with extreme aerodynamics.',51777.00,10,'2021-01-01'),(2,'Bugatti Chiron','A luxury sports car designed for high speed and elegance, powered by an 8.0L W16 engine.',2990000.00,4,'2017-01-01'),(3,'Brabus Rocket 900','One of the fastest luxury sedans in the world with a staggering 900 horsepower.',500000.00,3,'2020-01-01'),(4,'Mercedes-AMG One','A hypercar that brings Formula 1 technology to the road with a hybrid powertrain.',2740000.00,7,'2022-01-01'),(5,'Koenigsegg Jesko','A hypercar designed for extreme performance, with a 5.0L twin-turbo V8 engine.',2800000.00,5,'2021-01-01'),(6,'McLaren Speedtail','A hybrid hypercar with a focus on luxury and performance, featuring a unique elongated design.',2150000.00,6,'2020-01-01'),(7,'Pagani Huayra','A hypercar with a beautiful design and a powerful twin-turbo V12 engine.',3000000.00,3,'2016-01-01'),(8,'Ferrari LaFerrari','The first hybrid supercar from Ferrari, featuring a 950-horsepower V12 engine.',1400000.00,3,'2013-01-01'),(9,'Aston Martin Valkyrie','A hypercar designed for track performance with an incredible V12 engine.',3000000.00,2,'2021-01-01'),(10,'Lotus Evija','An all-electric hypercar that offers extreme performance with 2000 horsepower.',2000000.00,8,'2021-01-01'),(11,'Nissan GT-R Nismo','A high-performance version of the iconic Nissan GT-R, known for its power and handling.',210000.00,12,'2020-01-01'),(12,'Porsche 918 Spyder','A hybrid supercar that combines performance with efficiency, featuring a V8 engine.',845000.00,5,'2015-01-01'),(13,'BMW i8','A plug-in hybrid sports car that showcases BMW’s innovative engineering.',147500.00,10,'2014-01-01'),(14,'Bugatti Divo','A limited-edition hypercar designed for agility and performance.',5000000.00,3,'2019-01-01'),(15,'McLaren P1','A hybrid supercar with exceptional performance and advanced technology.',1150000.00,5,'2013-01-01'),(16,'Ferrari 488 Pista','A high-performance version of the 488 GTB, with an emphasis on track capability.',350000.00,7,'2018-01-01'),(17,'Lamborghini Huracán Performante','A track-focused version of the Huracán with enhanced aerodynamics.',274390.00,9,'2017-01-01'),(18,'Mercedes-Benz SLS AMG Black Series','A high-performance version of the SLS with a powerful V8 engine.',275000.00,4,'2013-01-01'),(19,'Audi R8 V10 Performance','A high-performance version of Audi’s iconic supercar with a powerful V10 engine.',208000.00,6,'2021-01-01'),(20,'McLaren 720S','A supercar that combines performance, luxury, and technology for an exhilarating driving experience.',299000.00,5,'2017-01-01'),(21,'Koenigsegg Regera','A hybrid hypercar that combines an internal combustion engine with an electric drivetrain.',2200000.00,3,'2016-01-01'),(22,'Lamborghini Urus','The first super SUV from Lamborghini that combines luxury and performance.',200000.00,15,'2018-01-01'),(23,'Ferrari F8 Tributo','A mid-engine sports car that combines performance and aesthetics with a turbocharged V8.',280000.00,7,'2019-01-01'),(24,'Porsche 911 GT2 RS','A high-performance version of the iconic Porsche 911, with a turbocharged flat-six engine.',300000.00,8,'2018-01-01'),(25,'Ford GT','An American supercar with a focus on lightweight design and aerodynamic performance.',500000.00,4,'2017-01-01'),(26,'Bugatti Centodieci','A limited-edition hypercar inspired by the Bugatti EB110, offering immense power and luxury.',9000000.00,1,'2022-01-01'),(27,'McLaren Sabre','A track-focused supercar with a powerful twin-turbo V8 engine and limited production.',3500000.00,0,'2021-01-01'),(28,'Mercedes-Benz EQS','The flagship electric sedan from Mercedes, combining luxury and technology.',120000.00,10,'2021-01-01'),(29,'Aston Martin DB11','A luxury grand tourer that combines performance with classic Aston Martin elegance.',205600.00,6,'2017-01-01'),(30,'Toyota Supra MK5','A modern sports car that pays homage to the classic Supra with impressive performance.',49990.00,20,'2019-01-01');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-17 13:44:16
