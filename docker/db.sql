-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: smbstore
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cadastro`
--

DROP TABLE IF EXISTS `cadastro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cadastro` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(150) NOT NULL,
    `sobrenome` varchar(150) NOT NULL,
    `sexo` varchar(1) NOT NULL,
	`nascimento` date NOT NULL,
	`email` varchar(255) NOT NULL,
    `fone` varchar(20) NOT NULL,
    `foto` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadastro`
--

LOCK TABLES `cadastro` WRITE;
/*!40000 ALTER TABLE `cadastro` DISABLE KEYS */;
/*!40000 ALTER TABLE `cadastro` ENABLE KEYS */;
UNLOCK TABLES;

INSERT INTO cadastro (id,nome,sobrenome,sexo,nascimento,email,fone,foto) VALUES
  (1,'saskdjhg','kjashdklasd','F','1978-02-12','1a3s21d654','(36) 5423-4342','uploads/cbc1a63a48b703d4c2886bf75b976f30.jpg'),
  (2,'ajshgd','65as4d64','M','2000-11-01','asdasd','(36) 5423-4474','uploads/48b70a09e687b18b4853d38d86403905.jpg'),
  (3,'kjsdhflksdjfh','lkjahsd','M','2006-12-10','as4d56','(54) 6 5423-4234','uploads/646ad15795a32a7e32c85be72788dcb0.jpg'),
  (4,'gkahsgjdhas','lkjhaskjdh','F','1987-10-10','6a5s4d65a','(16) 5 4454-6546','uploads/d6742d889ab3102a9b6001131cb2be00.jpg');


--
-- Dumping routines for database 'smbstore'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-24 10:12:53
