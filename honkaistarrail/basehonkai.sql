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
-- Table structure for table `artefactos_recomendados`
--

DROP TABLE IF EXISTS `artefactos_recomendados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artefactos_recomendados` (
  `id_artefacto` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Cuerpo','Pies','Planar','Manos','Cabeza') NOT NULL,
  `conjunto` varchar(100) DEFAULT NULL,
  `estadistica_principal` varchar(100) DEFAULT NULL,
  `estadisticas_secundarias` text,
  `descripcion` text,
  `prioridad` enum('Alta','Media','Baja') DEFAULT 'Media',
  PRIMARY KEY (`id_artefacto`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `artefactos_recomendados_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artefactos_recomendados`
--

LOCK TABLES `artefactos_recomendados` WRITE;
/*!40000 ALTER TABLE `artefactos_recomendados` DISABLE KEYS */;
INSERT INTO `artefactos_recomendados` VALUES (1,9,'Longevus Discípulo','Cuerpo','Longevus Discípulo','Vida%','Prob. Crítica, Daño Crítico, Velocidad, ATQ%','Set principal para Blade. Aumenta la Vida Máx. y el daño basado en Vida.','Alta'),(2,9,'Rutilante Arena','Planar','Rutilante Arena','Viento%','Vida%, Prob. Crítica, Daño Crítico','Aumenta el Daño de Viento. Ideal para maximizar daño.','Alta'),(3,9,'Cuerpo - Longevus','Cuerpo','Longevus Discípulo','Prob. Crítica','Daño Crítico, Vida%, Velocidad','Principal: Prob. Crítica para activar set.','Media'),(4,9,'Pies - Longevus','Pies','Longevus Discípulo','Velocidad','Vida%, Prob. Crítica, Daño Crítico','Velocidad para más turnos.','Media'),(5,9,'Cabeza - Longevus','Cabeza','Longevus Discípulo','Vida%','Prob. Crítica, Daño Crítico, Velocidad','Aumenta supervivencia.','Media');
/*!40000 ALTER TABLE `artefactos_recomendados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comentario`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios_personaje`
--

DROP TABLE IF EXISTS `comentarios_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios_personaje` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_personaje` int NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comentario`),
  KEY `idx_personaje` (`id_personaje`),
  KEY `idx_usuario_personaje` (`id_usuario`,`id_personaje`),
  CONSTRAINT `comentarios_personaje_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_personaje_ibfk_2` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios_personaje`
--

LOCK TABLES `comentarios_personaje` WRITE;
/*!40000 ALTER TABLE `comentarios_personaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios_personaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conos_luz_recomendados`
--

DROP TABLE IF EXISTS `conos_luz_recomendados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conos_luz_recomendados` (
  `id_cono` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rareza` enum('3 estrellas','4 estrellas','5 estrellas') NOT NULL,
  `descripcion` text NOT NULL,
  `razon` text,
  `prioridad` enum('Óptimo','Alternativa','Temporal') DEFAULT 'Alternativa',
  PRIMARY KEY (`id_cono`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `conos_luz_recomendados_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conos_luz_recomendados`
--

LOCK TABLES `conos_luz_recomendados` WRITE;
/*!40000 ALTER TABLE `conos_luz_recomendados` DISABLE KEYS */;
INSERT INTO `conos_luz_recomendados` VALUES (1,9,'La Inaccesible Lado','5 estrellas','Aumenta la Prob. Crítica del portador en un 18%. Cuando el portador usa ATQ básico o habilidad, obtiene 1 acumulación de \"Dragón\". Cada acumulación aumenta el daño del ATQ básico y la habilidad en un 18%. Máximo 2 acumulaciones.','Perfecto para Blade. Aumenta daño de ATQ básico y Prob. Crítica.','Óptimo'),(2,9,'Al Alba','5 estrellas','Aumenta el Daño Crítico del portador en un 20%. Al usar la Definitiva, el daño del ATQ básico y la habilidad del portador aumentan en un 48% durante 2 turnos.','Buena alternativa si no tienes su firma.','Alternativa'),(3,9,'Algo Irreemplazable','5 estrellas','Aumenta el ATQ del portador en un 24%. Después de derrotar a un enemigo o recibir un ataque, el daño infligido aumenta en un 24% durante 3 turnos.','Funciona bien con su estilo de combate.','Alternativa'),(4,9,'Los Susurros en la Noche Cohesionante','4 estrellas','Cuando el portador usa ATQ básico, habilidad o definitiva, gana 1 acumulación de \"Bendición\". Cada acumulación aumenta el ATQ en un 12%. Máximo 3 acumulaciones.','Buen cono de 4 estrellas para Blade.','Temporal'),(5,9,'La Crueldad Muta en Armonía','4 estrellas','Cuando el portador es atacado o consume Vida, el daño que inflige aumenta en un 24% durante 2 turnos.','Ideal para Blade ya que se activa con su kit.','Temporal');
/*!40000 ALTER TABLE `conos_luz_recomendados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadisticas_personaje`
--

DROP TABLE IF EXISTS `estadisticas_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadisticas_personaje` (
  `id_estadistica` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `nivel` int DEFAULT '80',
  `ataque_base` int NOT NULL,
  `defensa_base` int NOT NULL,
  `vida_base` int NOT NULL,
  `velocidad_base` int NOT NULL,
  `probabilidad_critica` decimal(5,2) DEFAULT NULL,
  `danio_critico` decimal(5,2) DEFAULT NULL,
  `regeneracion_energia` decimal(5,2) DEFAULT NULL,
  `efecto_ruptura` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_estadistica`),
  UNIQUE KEY `unique_personaje_nivel` (`id_personaje`,`nivel`),
  CONSTRAINT `estadisticas_personaje_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadisticas_personaje`
--

LOCK TABLES `estadisticas_personaje` WRITE;
/*!40000 ALTER TABLE `estadisticas_personaje` DISABLE KEYS */;
INSERT INTO `estadisticas_personaje` VALUES (1,9,80,691,485,1337,97,5.00,100.00,5.00,30.00);
/*!40000 ALTER TABLE `estadisticas_personaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habilidades_personaje`
--

DROP TABLE IF EXISTS `habilidades_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habilidades_personaje` (
  `id_habilidad` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Básica','Habilidad','Definitiva','Talento','Técnica') NOT NULL,
  `descripcion` text NOT NULL,
  `nivel_max` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_habilidad`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `habilidades_personaje_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habilidades_personaje`
--

LOCK TABLES `habilidades_personaje` WRITE;
/*!40000 ALTER TABLE `habilidades_personaje` DISABLE KEYS */;
INSERT INTO `habilidades_personaje` VALUES (1,9,'Corte Forestal','Básica','Inflige Daño de Viento equivalente al 50%/60%/70%/80% del ATQ de Blade a un enemigo.','10'),(2,9,'Infusión Karma','Habilidad','Consume un 30% de la Vida Máxima de Blade para entrar en el estado \"Sacrificio\". En este estado, el ATQ de Blade aumenta y su ATQ básico se potencia. Dura 3 turnos.','15'),(3,9,'Calamidad Infernal','Definitiva','Consume toda la carga de \"Padecimiento\" para infligir Daño de Viento equivalente al 38% de la Vida Máxima de Blade + 96% de su ATQ a un enemigo, y Daño de Viento equivalente al 9,5% de la Vida Máxima de Blade + 24% de su ATQ a los enemigos adyacentes.','15'),(4,9,'Sangre Debida','Talento','Cuando Blade recibe daño o consume Vida, obtiene 1 carga de \"Padecimiento\". Al alcanzar 5 cargas, lanza un ataque de seguimiento a todos los enemigos, infligiendo Daño de Viento equivalente al 22% de la Vida Máxima de Blade + 55% de su ATQ.','15'),(5,9,'Aliento Shuhu','Técnica','Después de usar la Técnica, al comienzo de la siguiente batalla, Blade consume inmediatamente un 20% de su Vida Máxima.','15');
/*!40000 ALTER TABLE `habilidades_personaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes_comentarios`
--

DROP TABLE IF EXISTS `likes_comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes_comentarios` (
  `id_like` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_comentario` int NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_like`),
  UNIQUE KEY `unique_like` (`id_usuario`,`id_comentario`),
  KEY `id_comentario` (`id_comentario`),
  CONSTRAINT `likes_comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `likes_comentarios_ibfk_2` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id_comentario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes_comentarios`
--

LOCK TABLES `likes_comentarios` WRITE;
/*!40000 ALTER TABLE `likes_comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes_comentarios` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `relacion_personajes`
--

DROP TABLE IF EXISTS `relacion_personajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relacion_personajes` (
  `id_personaje1` int NOT NULL,
  `id_personaje2` int NOT NULL,
  `relacion` enum('amigo','enemigo') NOT NULL,
  PRIMARY KEY (`id_personaje1`,`id_personaje2`),
  KEY `id_personaje2` (`id_personaje2`),
  CONSTRAINT `relacion_personajes_ibfk_1` FOREIGN KEY (`id_personaje1`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE,
  CONSTRAINT `relacion_personajes_ibfk_2` FOREIGN KEY (`id_personaje2`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE,
  CONSTRAINT `relacion_personajes_chk_1` CHECK ((`id_personaje1` < `id_personaje2`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relacion_personajes`
--

LOCK TABLES `relacion_personajes` WRITE;
/*!40000 ALTER TABLE `relacion_personajes` DISABLE KEYS */;
INSERT INTO `relacion_personajes` VALUES (1,7,'amigo'),(1,10,'enemigo'),(2,3,'amigo'),(2,4,'amigo'),(3,4,'amigo'),(6,18,'amigo'),(7,9,'amigo'),(9,13,'enemigo'),(10,13,'enemigo'),(10,23,'amigo'),(18,26,'amigo');
/*!40000 ALTER TABLE `relacion_personajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews_personaje`
--

DROP TABLE IF EXISTS `reviews_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews_personaje` (
  `id_review` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `contenido` text NOT NULL,
  `autor` varchar(100) DEFAULT 'Administrador',
  `fecha_publicacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rating_overall` tinyint DEFAULT NULL,
  `rating_dps` tinyint DEFAULT NULL,
  `rating_supervivencia` tinyint DEFAULT NULL,
  `rating_utilidad` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_review`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `reviews_personaje_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE,
  CONSTRAINT `reviews_personaje_chk_1` CHECK ((`rating_overall` between 1 and 5)),
  CONSTRAINT `reviews_personaje_chk_2` CHECK ((`rating_dps` between 1 and 5)),
  CONSTRAINT `reviews_personaje_chk_3` CHECK ((`rating_supervivencia` between 1 and 5)),
  CONSTRAINT `reviews_personaje_chk_4` CHECK ((`rating_utilidad` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_personaje`
--

LOCK TABLES `reviews_personaje` WRITE;
/*!40000 ALTER TABLE `reviews_personaje` DISABLE KEYS */;
INSERT INTO `reviews_personaje` VALUES (1,9,'Análisis completo: Blade - El inmolador eterno','Blade es un DPS único que escala con VIDA en lugar de ATQ. Su kit se centra en sacrificar su propia vida para infligir daño masivo. Es extremadamente fuerte en equipos con soporte que no requieren muchos SP, ya que Blade usa principalmente su ATQ básico potenciado.\n\n**Fortalezas:**\n- Daño masivo escala con VIDA\n- Autocuración mediante talento\n- No consume muchos Puntos de habilidad (SP)\n- Excelente sinergia con Bronya\n\n**Debilidades:**\n- Requiere gestión de vida\n- Dependiente de soporte para máximo daño\n- Sin capacidad de romper escudos rápidamente\n\n**Conclusión:** Top tier DPS para contenido de un solo objetivo y AoE.','Admin HSR','2025-12-15 06:35:05',5,5,4,3);
/*!40000 ALTER TABLE `reviews_personaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sinergias_personaje`
--

DROP TABLE IF EXISTS `sinergias_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sinergias_personaje` (
  `id_sinergia` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `personaje_sinergia` varchar(100) NOT NULL,
  `rol_sinergia` enum('Soporte','DPS','Sustento','Utilidad') NOT NULL,
  `razon` text NOT NULL,
  `nivel_recomendacion` enum('S','A','B','C') DEFAULT 'A',
  PRIMARY KEY (`id_sinergia`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `sinergias_personaje_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sinergias_personaje`
--

LOCK TABLES `sinergias_personaje` WRITE;
/*!40000 ALTER TABLE `sinergias_personaje` DISABLE KEYS */;
INSERT INTO `sinergias_personaje` VALUES (1,9,'Bronya','Soporte','Bronya aumenta el daño de Blade y le da turnos extra. Perfecta para maximizar su daño.','S'),(2,9,'Luocha','Sustento','Luocha cura sin consumir turnos y remueve debuffs. Ideal ya que Blade se autocura.','S'),(3,9,'Silver Wolf','Utilidad','Aplica debilidad de Viento, permitiendo a Blade romper más fácilmente.','A'),(4,9,'Pela','Utilidad','Reduce DEF del enemigo, aumentando todo el daño de Blade.','A'),(5,9,'Fu Xuan','Sustento','Protege a Blade y aumenta su Prob. Crítica.','B');
/*!40000 ALTER TABLE `sinergias_personaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trazas_personaje`
--

DROP TABLE IF EXISTS `trazas_personaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trazas_personaje` (
  `id_traza` int NOT NULL AUTO_INCREMENT,
  `id_personaje` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Traza Menor','Traza Mayor','Traza Ascenso') NOT NULL,
  `descripcion` text NOT NULL,
  `efecto` text,
  `nivel_desbloqueo` int DEFAULT NULL,
  PRIMARY KEY (`id_traza`),
  KEY `idx_personaje` (`id_personaje`),
  CONSTRAINT `trazas_personaje_ibfk_1` FOREIGN KEY (`id_personaje`) REFERENCES `personajes` (`id_personaje`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trazas_personaje`
--

LOCK TABLES `trazas_personaje` WRITE;
/*!40000 ALTER TABLE `trazas_personaje` DISABLE KEYS */;
INSERT INTO `trazas_personaje` VALUES (1,9,'Ciclo de vida y muerte','Traza Ascenso','Aumenta la Probabilidad de Crítico en un 4% cuando la Vida está por debajo del 50%.','+4% Prob. Crítico',75),(2,9,'Espada de retribución','Traza Mayor','El ATQ básico potenciado inflige un 15% más de daño a enemigos con Vida por debajo del 50%.','+15% Daño',1),(3,9,'Destino sellado','Traza Mayor','Al ser atacado, tiene un 35% de probabilidad base de ganar 1 carga de Padecimiento.','35% Prob. carga extra',1),(4,9,'Pacto inmortal','Traza Menor','Aumenta RES a efecto en un 10%.','+10% RES efecto',1),(5,9,'Herida perpetua','Traza Menor','Aumenta el Daño de Viento en un 12,8%.','+12,8% Daño Viento',1);
/*!40000 ALTER TABLE `trazas_personaje` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (11,'admin','admin@honkai.com','$2y$10$59c3C.Kp7v5LvzaEG/NGJ.SrtcJB4SxJYOiK0UrhEL8TjUmwgRiqC','Admin','2025-12-04 05:34:57',NULL,'admin',1),(12,'usuario1','usuario1@honkai.com','$2y$10$L5LZq548PzxyihIg.vnHwe344ACFazz74ZnPmB4Fj4h09yFqxFUSW','Usuario1','2025-12-04 05:34:57',NULL,'usuario',1),(13,'trainer','trainer@honkai.com','$2y$10$1DTUhuzSObr47zGM.2mG3.F31jXZk8mYj2rVhK13LB2GTwboFfD8.','Trainer','2025-12-04 05:34:57',NULL,'usuario',1),(14,'seele_fan','seelefan@honkai.com','$2y$10$oBo/RI3SAONiD0Zl3E/GGOyKrYJHSJOOjgKrnq/cdn23BOb/qQ1E2','Seele fan','2025-12-04 05:34:57',NULL,'usuario',1),(15,'kafka_lover','kafkalover@honkai.com','$2y$10$E1i8.fgya2KBvt7rgEdgtubyd5YMYIhAsrLLFPuj1zKExCrWI2Nhi','Kafka lover','2025-12-04 05:34:57',NULL,'usuario',1),(16,'honkai','honkai@honkai.com','$2y$10$d/BkXWkANETJZ.bvlHqO0uX0I2AiYCKsUqBsmXHhpgd0IZ40QS64S','Honkai','2025-12-04 23:23:44',NULL,'usuario',1),(17,'jefazo_supremo','danirenk@gmail.com','$2y$10$85t6bIx2TVSgbT9xu4E56eh3TMaeg61npIJ4s8tX773IXwd989W6W','Ruben Ternero','2025-12-15 06:28:43',NULL,'usuario',1);
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

-- Dump completed on 2025-12-15  8:09:04
