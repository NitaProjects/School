-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dani
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

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
-- Current Database: `dani`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dani` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `dani`;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `assigned_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES
(82,36,11,'2025-01-27'),
(84,43,10,'2025-01-27');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES
(34,'Álgebra','Curso de Álgebra en el departamento de Matemáticas.',9),
(35,'Cálculo','Curso de Cálculo en el departamento de Matemáticas.',9),
(36,'Estadística','Curso de Estadística en el departamento de Matemáticas.',9),
(37,'Geometría','Curso de Geometría en el departamento de Matemáticas.',9),
(38,'Matemáticas Aplicadas','Curso de Matemáticas Aplicadas en el departamento de Matemáticas.',9),
(39,'Biología','Curso de Biología en el departamento de Ciencias.',10),
(40,'Física','Curso de Física en el departamento de Ciencias.',10),
(42,'Ecología','Curso de Ecología en el departamento de Ciencias.',10),
(43,'Astronomía','Curso de Astronomía en el departamento de Ciencias.',10),
(44,'Historia Mundial','Curso de Historia Mundial en el departamento de Historia.',11),
(45,'Historia Moderna','Curso de Historia Moderna en el departamento de Historia.',11),
(46,'Antigüedad','Curso de Antigüedad en el departamento de Historia.',11),
(47,'Historiografía','Curso de Historiografía en el departamento de Historia.',11),
(48,'Historia de América','Curso de Historia de América en el departamento de Historia.',11),
(49,'Inglés','Curso de Inglés en el departamento de Idiomas.',12),
(50,'Español','Curso de Español en el departamento de Idiomas.',12),
(51,'Francés','Curso de Francés en el departamento de Idiomas.',12),
(52,'Alemán','Curso de Alemán en el departamento de Idiomas.',12),
(53,'Italiano','Curso de Italiano en el departamento de Idiomas.',12);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES
(9,'Matemáticas','Departamento de Matemáticas.'),
(10,'Ciencias','Departamento de Ciencias.'),
(11,'Historia','Departamento de Historia.'),
(12,'Idiomas','Departamento de Idiomas.');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
INSERT INTO `enrollments` VALUES
(38,29,52,'2025-01-27'),
(39,29,49,'2025-01-27');
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `enrollment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
(10,30,'2023-03-02'),
(11,31,'2020-09-19'),
(12,32,'2022-05-10'),
(13,33,'2021-10-24'),
(14,34,'2022-12-18'),
(15,35,'2022-09-21'),
(16,36,'2021-06-03'),
(17,37,'2020-01-29'),
(18,38,'2024-03-29'),
(20,40,'2024-09-09'),
(21,41,'2023-11-23'),
(22,42,'2024-01-31'),
(23,43,'2022-05-21'),
(24,44,'2023-11-30'),
(25,45,'2024-08-23'),
(26,46,'2022-12-14'),
(27,47,'2024-03-11'),
(28,48,'2020-04-23'),
(29,49,'2021-05-15'),
(30,50,'2025-09-23'),
(31,51,'2025-04-28'),
(32,52,'2021-11-08'),
(33,53,'2025-08-17'),
(34,54,'2024-09-26'),
(35,55,'2022-10-07'),
(36,56,'2023-03-21'),
(37,57,'2023-11-19'),
(38,58,'2023-08-01');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hire_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES
(19,59,'2025-08-29'),
(20,60,'2023-07-16'),
(21,61,'2018-07-16'),
(22,62,'2025-10-12'),
(23,63,'2016-12-10'),
(24,64,'2016-12-27'),
(25,65,'2017-07-21'),
(26,66,'2025-08-05'),
(27,67,'2021-05-04'),
(28,68,'2025-11-13'),
(29,69,'2023-10-08'),
(30,70,'2022-10-05'),
(32,72,'2019-11-02'),
(33,73,'2023-07-03'),
(34,74,'2017-01-03'),
(35,75,'2021-04-16'),
(36,76,'2018-09-16'),
(37,77,'2020-12-05'),
(38,78,'2023-03-29'),
(39,79,'2017-07-04'),
(40,80,'2018-09-21'),
(41,81,'2022-06-18'),
(42,82,'2019-05-29'),
(43,83,'2016-10-29'),
(44,84,'2016-08-14'),
(45,85,'2015-08-03'),
(46,86,'2019-02-22'),
(48,88,'2019-10-03'),
(49,89,'2025-01-25'),
(51,91,'2025-01-26');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','teacher') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(30,'María Rodríguez','maría.rodríguez58@example.com','$2y$10$KKGo3Ti9PXR4/k0.q8VAzeHjHtNccy8fCaGo98Mqhp.So6gcDgBIm','student'),
(31,'Carmen González','carmen.gonzález8@yahoo.com','$2y$10$7/Nkg1LwGauiwDv6KDm2fOdIqvFYghNTG7ZKJ5csuskeSxl6cG6i.','student'),
(32,'María Rodríguez','maría.rodríguez71@example.com','$2y$10$2Mt8NtRiv0vQSoeg2oWZluPlqdmU03ju2awHSBHN6jSzK8IO81ezy','student'),
(33,'Carlos Sánchez','carlos.sánchez34@yahoo.com','$2y$10$rhJd8tH81eBZZqGpaS8fR.6o7gwDXzuJ3dt9zgYlyQG8n8x.vKDVm','student'),
(34,'Carlos González','carlos.gonzález17@hotmail.com','$2y$10$a6PNwiBhJF7N5pg0PmA5LetcA6MxWqIEzpPQyq4PifklblD3tk5ei','student'),
(35,'Carmen Hernández','carmen.hernández53@example.com','$2y$10$KopKCPBHoYfQ5Fb4ZXmNueEOLD3MSxXYOdvrZ.pgombh8G7RcVshW','student'),
(36,'Ana Rodríguez','ana.rodríguez48@yahoo.com','$2y$10$26huZN9MUALMAAe.PWdFdeyX5EneM4SVV6MzwBl5yKcDXaSwy4oPu','student'),
(37,'Ana Pérez','ana.pérez73@hotmail.com','$2y$10$4R/xZPYYm6HYP15/LgQXAOsW8BRHmyJpUVZ4rxrV42qaFFmbj0n3S','student'),
(38,'María Sánchez','maría.sánchez69@yahoo.com','$2y$10$N3/nIc/aUNnBcNdJQRbJn.o/EnRX5HybgRMGu17svHJDSjttTGTES','student'),
(40,'Daniel Sánchez','daniel.sánchez42@example.com','$2y$10$cJw0PbZA5VRUFlEQTFF5uuuSqXijbaAKdoXpz.od/B7nFz5BTlUIC','student'),
(41,'Carlos Sánchez','carlos.sánchez43@yahoo.com','$2y$10$oJ09DwJbVpK9/BH9GOQuNOsigHKhBdbzYd2NWZbjtX4L9EstGU1da','student'),
(42,'Daniel González','daniel.gonzález64@example.com','$2y$10$N34pZMJG3f7A4E9cBNZwdu7SfbAQibCfc6UOkmH6OZF2TgJ2atw3u','student'),
(43,'Carmen González','carmen.gonzález68@example.com','$2y$10$Rw9Nrgy8/6z7fE8Vz9o7n.iw37qUYw5xm7dBdXk7CgTcfVfR7Eh4e','student'),
(44,'Luis García','luis.garcía42@gmail.com','$2y$10$mekgQBnxCldL6qMf.2K5LOCc4rHRo6oRAeWpY/tFYmFYwDmwV.STe','student'),
(45,'Daniel López','daniel.lópez8@gmail.com','$2y$10$C1CSgQkEnfUKiabvpZWqXuy3SSFeuJT0W0.Y859MPZnSiuHy3e2Yq','student'),
(46,'Luis Ramírez','luis.ramírez54@yahoo.com','$2y$10$m3WAbUM3wXraKeXcrxU0BOUc/LzPpAxRDz5PAPC0Wfo7vaTvarWiK','student'),
(47,'Miguel Sánchez','miguel.sánchez43@example.com','$2y$10$shnLq83QluzHsnB3C/BcZO0eHY8Yusyql/hE5foJ1XX/jq.7dT1Se','student'),
(48,'Luis Hernández','luis.hernández51@gmail.com','$2y$10$eEqIYma7Z7ZrOsccFbK2w.6U/THigo95XgVYpwIrgqiM.Z3pda/1S','student'),
(49,'Ana Hernández','ana.hernández50@gmail.com','$2y$10$0O1at9ING9Hm/E7GUVG20O4M4KPYYexK4hW/ulG7YWWx1THQ1RMpK','student'),
(50,'Laura Sánchez','laura.sánchez19@yahoo.com','$2y$10$GSXdSxUMJJCUogKwEROTnexvOXaRFs7BU3d916QA889WCXhIJ33Q.','student'),
(51,'Luis Sánchez','luis.sánchez4@gmail.com','$2y$10$cAH3w/KbZlpyZZyL99kQL.r8a8PgHpGcNRtNYE.F5GEm4r4.ZnwHG','student'),
(52,'María Rodríguez','maría.rodríguez37@hotmail.com','$2y$10$ZAQ/HNvPAWYMAQArsPRyzuNY93bjDPbbO73nP/1LGy4VOPiTPST06','student'),
(53,'Carmen Ramírez','carmen.ramírez96@gmail.com','$2y$10$XQPuarhfZS1U5xvwyhBayed771bVEqyGSabr8i08BtARDbw4ZDIyG','student'),
(54,'Elena Díaz','elena.díaz71@gmail.com','$2y$10$/AlKRuc5Yt3KNwDDIpjN9OG4g5uXjRknKkwqnTMUTd8vnybwQWSHC','student'),
(55,'Daniel Díaz','daniel.díaz46@yahoo.com','$2y$10$ySQZN9l9wQrrlGw19nhcseyHv8hUq8ZpAgrsZvbYaaG7ML8q3JZfe','student'),
(56,'Luis Martínez','luis.martínez87@yahoo.com','$2y$10$GTtlLj2o4yApXFPD6l.5vu1knuk4DuOenjIjFPNRxXB4gs/HQc9.S','student'),
(57,'José Pérez','josé.pérez72@example.com','$2y$10$RRIIFInB3pkojTbRu35Wke0Iat7fV9lcvDrE8AwhI.kterhozij6G','student'),
(58,'María Hernández','maría.hernández14@hotmail.com','$2y$10$X2JK3Eb/Jl9ZNFCgmnH0Tux.QpfmxxCoZeCWvSml7RyKSw87GMQV2','student'),
(59,'José García','josé.garcía77@hotmail.com','$2y$10$cwUnYJmWPcFTb1.IvMlRbOjMru7ObRYdqtJJl5vd1fgCotnT4uKHm','teacher'),
(60,'María García','maría.garcía37@example.com','$2y$10$/8TU4mm4gk3orzU7xVI/qum4ShzVpYNr7ELu74nAyFZeJ8gOp0UnC','teacher'),
(61,'Ana Hernández','ana.hernández65@hotmail.com','$2y$10$fxoWIITTN1z4dbHFSK2oZuQ.nmL6vkp6X25.20GZLfsno53NDh8jS','teacher'),
(62,'Carlos Ramírez','carlos.ramírez46@example.com','$2y$10$RoflFq2LpgKClL5QNm8bWOw2SLXpyAp/pgpzt9fzmFbYL2aLZLtc.','teacher'),
(63,'Ana Sánchez','ana.sánchez51@gmail.com','$2y$10$7G02oCsXU8P4b8KYX4prNuCGCOBX5uiMj/9.Iktp3PUjRsd7rGacO','teacher'),
(64,'José Ramírez','josé.ramírez50@gmail.com','$2y$10$PLdl/EPRzaFhT9QcfmJ4FOa9EUuIbzmGod1jHuYjIJwbPDmuhFl02','teacher'),
(65,'José Pérez','josé.pérez77@hotmail.com','$2y$10$QoGIb0bX/75..oluR6hF1uORDaj7DgYrdML3cmcxiAMmapkxTv0Sy','teacher'),
(66,'Elena Hernández','elena.hernández65@gmail.com','$2y$10$Yco/7T.4hgDuCXz9/8fQgeuF21Sw4EsJsssO3ayBSD5hduZ/RR.ZK','teacher'),
(67,'Laura García','laura.garcía84@gmail.com','$2y$10$2hXUITlYDMWwXR0upuZQYOZaIm8euhBtRzJUSV4FD6xYOqyeOTQcW','teacher'),
(68,'Laura García','laura.garcía34@example.com','$2y$10$7ug79FckdUZw0y.7v9AbVeOSDD37yOqfwS5.0amiXg2tWaooSNSlq','teacher'),
(69,'Luis Hernández','luis.hernández37@hotmail.com','$2y$10$ZUEJXF9TQaqs7ltkwaOG0.iR6/.lcXskH3LbnqjyxJI9lZg0ENPBG','teacher'),
(70,'Carlos Pérez','carlos.pérez25@example.com','$2y$10$sc7hBFsksyCjBbVGWIcFpux12RJGOkexnWnRz5x3pJARY5Lbblu32','teacher'),
(72,'Elena López','elena.lópez70@example.com','$2y$10$XLVGrpdFur.W9ilnFLvw8ODO02MFTx6jGDzmw8HiL.h62ebYcSlqC','teacher'),
(73,'Carlos Martínez','carlos.martínez35@gmail.com','$2y$10$nXzaP7nn4hpp1CFGLdqYNeoavWlAlSPhXCIlM3PjxWY1P9Y88vPHS','teacher'),
(74,'María García','maría.garcía36@gmail.com','$2y$10$cyf1120ZftxMxLvK3TefvO7gQ278cz6Oxz0HzgYweNxwnd01jWmZu','teacher'),
(75,'Carmen González','carmen.gonzález30@gmail.com','$2y$10$oxHopbbunibFrzWG0ipS7ufHkM40ELp4htLxOiFj7ZToDOa8XIhSi','teacher'),
(76,'Ana García','ana.garcía76@hotmail.com','$2y$10$sVs8H/RKnFbVBLUN4wEzPOYjbFMW9SvM.0MqoHrQtppwvoY9pMWdW','teacher'),
(77,'Elena Hernández','elena.hernández75@gmail.com','$2y$10$76.DoQvHwSHn0A/C45AMTeQdMmVMYwFcGcRnWc/AdZAnK5FeJwzEm','teacher'),
(78,'Ana García','ana.garcía6@hotmail.com','$2y$10$sZ24TkZ6SH1h9./vm79jge3lJlW4c4PxohEp957olRLyve8OeQ0lS','teacher'),
(79,'José Sánchez','josé.sánchez73@hotmail.com','$2y$10$/WJoujaK2uBuhVo6Vtglr.DSFlGl8BRIO2sQbdm5SuMczBCiy.w66','teacher'),
(80,'Ana Ramírez','ana.ramírez46@example.com','$2y$10$kPpWyW8OqXM4VVutFKSD0.mApoXUECfCjLUfCU9B04JE4h9bVJeVe','teacher'),
(81,'Carmen García','carmen.garcía64@yahoo.com','$2y$10$8jvrywmreYu4jT/7NTQadeKZP1jgRBgI13wdsz8ZP4NG1TfBOHK.q','teacher'),
(82,'Elena Martínez','elena.martínez56@hotmail.com','$2y$10$Hswl8Q6woxElHT6OGJ0e2O7kmDHUynzy0.S6P7WkKlver2VgxXFf.','teacher'),
(83,'Carlos López','carlos.lópez76@yahoo.com','$2y$10$RvyeWiyY/5yPqMFVEZqdgeth03LIxNsxKE3tWqbIY1eAb/xSd88Pu','teacher'),
(84,'Ana Pérez','ana.pérez35@yahoo.com','$2y$10$7gfNZ31E1x6dmtZRl92ZM.eD/GsOZQC/zAiZEqYEKxYRWvXqJDAHO','teacher'),
(85,'Laura Rodríguez','laura.rodríguez64@hotmail.com','$2y$10$x2a5wEVPE9yqQSWdH/3pROxHliE6LV1PLTz3srXz8qfqXYYo9y4Je','teacher'),
(86,'Carlos López','carlos.lópez21@example.com','$2y$10$NRSfkqULf0zxPY.GFrrQAukhvOmWjkJmlEC4PH9jlK/LosMW9xSLW','teacher'),
(88,'José Pérez','josé.pérez34@yahoo.com','$2y$10$qTIy50fC2Ttkysngwdidd.tXumamfW0nHBfH1ZCGZpeVG5OOtUhNG','teacher'),
(89,'Jose Antonio Piqueras','jpiqueras@hotmail.com','$2y$10$5vj7AlkUQE4WdjhjXDvMOeehorfsbew.SFGmu8WQHxlnoMMR82eXa','teacher'),
(91,'Jose Antonio Piqueras','jpiqueraasdasdasIX@hotmail.com','$2y$10$qQAuHv8WszeT37xNVPnHNun22Z3rIDA587u7GG4tBL7Ay162/fQne','teacher');
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

-- Dump completed on 2025-01-28 18:59:31
