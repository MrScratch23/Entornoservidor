CREATE DATABASE  IF NOT EXISTS `honkai_star_rail` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `honkai_star_rail`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: honkai_star_rail
-- ------------------------------------------------------
-- Server version	8.0.40

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

--
-- Table structure for table `personajes`
--

DROP TABLE IF EXISTS `personajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personajes` (
  `id_personaje` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `rareza` enum('4 estrellas','5 estrellas') NOT NULL,
  `ruta` enum('Destrucción','Cacería','Erudición','Armonía','Nihilidad','Preservación','Abundancia') NOT NULL,
  `elemento` enum('Físico','Fuego','Hielo','Rayos','Viento','Cuantúm','Imaginario') NOT NULL,
  `descripcion` text,
  `imagen_url` varchar(500) NOT NULL,
  `fecha_lanzamiento` date DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_personaje`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personajes`
--

LOCK TABLES `personajes` WRITE;
/*!40000 ALTER TABLE `personajes` DISABLE KEYS */;
INSERT INTO `personajes` VALUES (1,'Kafka','Kafka','5 estrellas','Nihilidad','Rayos','Miembro de los Cazadores de Estelaron. Una cazarecompensas galáctica.','https://www.korosenai.es/wp-content/uploads/2023/08/kafka-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:04:03'),(2,'March 7th','March 7th','4 estrellas','Preservación','Hielo','Una joven alegre que fue encontrada en el hielo.','https://rerollcdn.com/STARRAIL/Characters/Full/1001.png','2023-04-26','2025-12-04 04:04:03'),(3,'Dan Heng','Dan Heng','4 estrellas','Destrucción','Viento','Un exiliado frío y reservado.','https://www.korosenai.es/wp-content/uploads/2023/05/dan-heng-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:04:03'),(4,'Himeko','Himeko','5 estrellas','Erudición','Fuego','Una científica aventurera a bordo del Expreso Astral.','https://www.korosenai.es/wp-content/uploads/2023/05/himeko-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:04:03'),(5,'Welt Yang','Welt Yang','5 estrellas','Nihilidad','Imaginario','Un hombre misterioso con un bastón que manipula la gravedad.','https://www.siliconera.com/wp-content/uploads/2023/05/screen-shot-2023-05-01-at-20127-pm.png?fit=2560%2C1420','2023-04-26','2025-12-04 04:04:03'),(6,'Seele','Seele','5 estrellas','Cacería','Cuantúm','Cazadora de Wildfire en Belobog. Veloz y letal.','https://assetsio.gnwcdn.com/Best-Seele-build-in-Honkai-Star-Rail.jpg?width=1200&height=1200&fit=crop&quality=100&format=png&enable=upscale&auto=webp','2023-04-26','2025-12-04 04:23:14'),(7,'Silver Wolf','Silver Wolf','5 estrellas','Nihilidad','Cuantúm','Hacker genio de los Cazadores de Estelaron.','https://www.korosenai.es/wp-content/uploads/2023/06/silver-wolf-honkai-star-rail.jpg','2023-06-07','2025-12-04 04:23:14'),(8,'Luocha','Luocha','5 estrellas','Abundancia','Imaginario','Médico misterioso con un ataúd a cuestas.','https://www.korosenai.es/wp-content/uploads/2023/06/luocha-honkai-star-rail.jpg','2023-06-28','2025-12-04 04:23:14'),(9,'Blade','Blade','5 estrellas','Destrucción','Viento','Espadachín inmortal con un pasado oscuro.','https://www.korosenai.es/wp-content/uploads/2023/07/blade-honkai-star-rail.jpg','2023-07-19','2025-12-04 04:23:14'),(10,'Jing Yuan','Jing Yuan','5 estrellas','Erudición','Rayos','General de la Alianza Xianzhou Luofu.','https://www.korosenai.es/wp-content/uploads/2023/05/jing-yuan-star-rail.jpg','2023-05-17','2025-12-04 04:23:14'),(11,'Fu Xuan','Fu Xuan','5 estrellas','Preservación','Cuantúm','Maestra de la Divinación de la Comisión.','https://www.korosenai.es/wp-content/uploads/2023/09/star-rail-fu-xuan.jpg','2023-09-20','2025-12-04 04:23:14'),(12,'Imbibitor Lunae','Dan Heng IL','5 estrellas','Destrucción','Imaginario','Forma desatada de Dan Heng con poder de dragón.','https://www.korosenai.es/wp-content/uploads/2023/08/imbibitor-lunae-honkai-star-rail.jpg','2023-08-30','2025-12-04 04:23:14'),(13,'Jingliu','Jingliu','5 estrellas','Destrucción','Hielo','Espadachín legendaria de la Xianzhou.','https://www.korosenai.es/wp-content/uploads/2023/10/jingliu-honkai-star-rail.jpg','2023-10-11','2025-12-04 04:23:14'),(14,'Topaz & Numby','Topaz','5 estrellas','Cacería','Fuego','Cazadora de la IPC con su mascota Numby.','https://www.korosenai.es/wp-content/uploads/2023/10/topaz-honkai-star-rail.jpg','2023-10-27','2025-12-04 04:23:14'),(15,'Huohuo','Huohuo','5 estrellas','Abundancia','Viento','Exorcista tímida de la Comisión de la Divinación.','https://www.korosenai.es/wp-content/uploads/2023/11/huohuo-honkai-star-rail.jpg','2023-11-15','2025-12-04 04:23:14'),(16,'Argenti','Argenti','5 estrellas','Erudición','Físico','Caballero de la Belleza de los Caballeros Puros.','https://www.korosenai.es/wp-content/uploads/2023/11/argenti-honkai-star-rail.jpg','2023-12-06','2025-12-04 04:23:14'),(17,'Asta','Asta','4 estrellas','Armonía','Fuego','Jefa del departamento de astronomía del Expreso Astral.','https://www.korosenai.es/wp-content/uploads/2023/05/asta-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:23:14'),(18,'Serval','Serval','4 estrellas','Erudición','Rayos','Mecánica y dueña de taller en Belobog. Amante del rock.','https://www.korosenai.es/wp-content/uploads/2023/05/serval-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:23:14'),(19,'Hook','Hook','4 estrellas','Destrucción','Fuego','Líder de \"The Moles\" en el Submundo de Belobog.','https://www.korosenai.es/wp-content/uploads/2023/05/hook-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:23:14'),(20,'Sampo','Sampo','4 estrellas','Nihilidad','Viento','Comerciante astuto con buen corazón.','https://www.korosenai.es/wp-content/uploads/2023/05/sampo-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:23:14'),(21,'Pela','Pela','4 estrellas','Nihilidad','Hielo','Oficial de inteligencia de Belobog. Fan del idolato.','https://www.korosenai.es/wp-content/uploads/2023/05/pela-honkai-star-rail.jpg','2023-04-26','2025-12-04 04:23:14'),(22,'Qingque','Qingque','4 estrellas','Erudición','Cuantúm','Empleada de la Comisión que prefiere jugar mahjong.','https://www.korosenai.es/wp-content/uploads/2023/06/qingque-honkai-star-rail.jpg','2023-05-17','2025-12-04 04:23:14'),(23,'Tingyun','Tingyun','4 estrellas','Armonía','Rayos','Representante de la Guilda de Comercio de la Xianzhou.','https://www.korosenai.es/wp-content/uploads/2023/05/tingyun-honkai-star-rail.jpg','2023-05-17','2025-12-04 04:23:14'),(24,'Yukong','Yukong','4 estrellas','Armonía','Imaginario','Comandante de la Flota Sky-Faring de la Xianzhou.','https://www.korosenai.es/wp-content/uploads/2023/06/yukong-honkai-star-rail.jpg','2023-07-19','2025-12-04 04:23:14'),(25,'Luka','Luka','4 estrellas','Destrucción','Físico','Luchador del Submundo de Belobog con brazo mecánico.','https://www.korosenai.es/wp-content/uploads/2023/08/luka-star-rail.jpg','2023-08-09','2025-12-04 04:23:14'),(26,'Lynx','Lynx','4 estrellas','Abundancia','Hielo','Hermana menor de Serval y Gepard. Exploradora.','https://www.korosenai.es/wp-content/uploads/2023/09/lynx-honkai-star-rail.jpg','2023-09-20','2025-12-04 04:23:14'),(27,'Guinaifen','Guinaifen','4 estrellas','Nihilidad','Fuego','Artista callejera y creadora de contenido.','https://www.korosenai.es/wp-content/uploads/2023/10/guinaifen-honkai-star-rail.jpg','2023-10-27','2025-12-04 04:23:14'),(28,'Xueyi','Xueyi','4 estrellas','Destrucción','Cuantúm','Asistente de la Comisión de la Divinación.','https://www.korosenai.es/wp-content/uploads/2023/12/xueyi-star-rail.jpg','2023-12-27','2025-12-04 04:23:14'),(29,'Hanya','Hanya','4 estrellas','Armonía','Físico','Jueza de la Comisión de la Divinación.','https://www.korosenai.es/wp-content/uploads/2023/11/hanya-honkai-star-rail.jpg','2023-12-06','2025-12-04 04:23:14');
/*!40000 ALTER TABLE `personajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (11,'admin','admin@honkai.com','$2y$10$59c3C.Kp7v5LvzaEG/NGJ.SrtcJB4SxJYOiK0UrhEL8TjUmwgRiqC','Admin','2025-12-04 05:34:57',NULL,'admin',1),(12,'usuario1','usuario1@honkai.com','$2y$10$L5LZq548PzxyihIg.vnHwe344ACFazz74ZnPmB4Fj4h09yFqxFUSW','Usuario1','2025-12-04 05:34:57',NULL,'usuario',1),(13,'trainer','trainer@honkai.com','$2y$10$1DTUhuzSObr47zGM.2mG3.F31jXZk8mYj2rVhK13LB2GTwboFfD8.','Trainer','2025-12-04 05:34:57',NULL,'usuario',1),(14,'seele_fan','seelefan@honkai.com','$2y$10$oBo/RI3SAONiD0Zl3E/GGOyKrYJHSJOOjgKrnq/cdn23BOb/qQ1E2','Seele fan','2025-12-04 05:34:57',NULL,'usuario',1),(15,'kafka_lover','kafkalover@honkai.com','$2y$10$E1i8.fgya2KBvt7rgEdgtubyd5YMYIhAsrLLFPuj1zKExCrWI2Nhi','Kafka lover','2025-12-04 05:34:57',NULL,'usuario',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04  6:37:15
