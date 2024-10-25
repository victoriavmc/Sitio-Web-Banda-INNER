-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: inner
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `idActividad` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `tipoActividad_idtipoActividad` int DEFAULT NULL,
  PRIMARY KEY (`idActividad`),
  KEY `fk_Actividad_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_actividad_tipoActividad1_idx` (`tipoActividad_idtipoActividad`),
  CONSTRAINT `fk_actividad_tipoActividad1` FOREIGN KEY (`tipoActividad_idtipoActividad`) REFERENCES `tipoactividad` (`idtipoActividad`),
  CONSTRAINT `fk_Actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albumdatos`
--

DROP TABLE IF EXISTS `albumdatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albumdatos` (
  `idalbumDatos` int NOT NULL AUTO_INCREMENT,
  `tituloAlbum` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaSubido` date DEFAULT NULL,
  PRIMARY KEY (`idalbumDatos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumdatos`
--

LOCK TABLES `albumdatos` WRITE;
/*!40000 ALTER TABLE `albumdatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `albumdatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albumimagenes`
--

DROP TABLE IF EXISTS `albumimagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albumimagenes` (
  `albumImagenescol` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int DEFAULT NULL,
  PRIMARY KEY (`albumImagenescol`),
  KEY `fk_table1_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumImagenes_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumImagenes_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumimagenes`
--

LOCK TABLES `albumimagenes` WRITE;
/*!40000 ALTER TABLE `albumimagenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `albumimagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albummusical`
--

DROP TABLE IF EXISTS `albummusical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albummusical` (
  `idalbumMusical` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionimagenes_idrevisionImagenescol` int DEFAULT NULL,
  PRIMARY KEY (`idalbumMusical`),
  KEY `fk_albumMusical_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albummusical_revisionimagenes1_idx` (`revisionimagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumMusical_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albummusical_revisionimagenes1` FOREIGN KEY (`revisionimagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albummusical`
--

LOCK TABLES `albummusical` WRITE;
/*!40000 ALTER TABLE `albummusical` DISABLE KEYS */;
/*!40000 ALTER TABLE `albummusical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albumvideo`
--

DROP TABLE IF EXISTS `albumvideo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albumvideo` (
  `idalbumVideo` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `videos_idvideos` int NOT NULL,
  PRIMARY KEY (`idalbumVideo`),
  KEY `fk_albumVideo_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumVideo_videos1_idx` (`videos_idvideos`),
  CONSTRAINT `fk_albumVideo_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumVideo_videos1` FOREIGN KEY (`videos_idvideos`) REFERENCES `videos` (`idvideos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumvideo`
--

LOCK TABLES `albumvideo` WRITE;
/*!40000 ALTER TABLE `albumvideo` DISABLE KEYS */;
/*!40000 ALTER TABLE `albumvideo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artistas`
--

DROP TABLE IF EXISTS `artistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artistas` (
  `idartistas` int NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` int DEFAULT NULL,
  `staffextra_idstaffExtra` int NOT NULL,
  PRIMARY KEY (`idartistas`),
  KEY `fk_artistas_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  KEY `fk_artistas_staffextra1_idx` (`staffextra_idstaffExtra`),
  CONSTRAINT `fk_artistas_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_artistas_staffextra1` FOREIGN KEY (`staffextra_idstaffExtra`) REFERENCES `staffextra` (`idstaffExtra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistas`
--

LOCK TABLES `artistas` WRITE;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
/*!40000 ALTER TABLE `artistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancion`
--

DROP TABLE IF EXISTS `cancion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cancion` (
  `idcancion` int NOT NULL AUTO_INCREMENT,
  `tituloCancion` longtext NOT NULL,
  `letraEspCancion` longtext,
  `letraInglesCancion` longtext,
  `archivoDsCancion` longtext,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  `albumMusical_idalbumMusical` int NOT NULL,
  PRIMARY KEY (`idcancion`),
  KEY `fk_cancion_albumMusical1_idx` (`albumMusical_idalbumMusical`),
  CONSTRAINT `fk_cancion_albumMusical1` FOREIGN KEY (`albumMusical_idalbumMusical`) REFERENCES `albummusical` (`idalbumMusical`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancion`
--

LOCK TABLES `cancion` WRITE;
/*!40000 ALTER TABLE `cancion` DISABLE KEYS */;
/*!40000 ALTER TABLE `cancion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `idcomentarios` int NOT NULL AUTO_INCREMENT,
  `fechaComent` date DEFAULT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Actividad_idActividad` int NOT NULL,
  `contenidos_idcontenidos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int DEFAULT NULL,
  PRIMARY KEY (`idcomentarios`),
  KEY `fk_table1_Actividad1_idx` (`Actividad_idActividad`),
  KEY `fk_table1_contenidos1_idx` (`contenidos_idcontenidos`),
  KEY `fk_comentarios_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_comentarios_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_Actividad1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`),
  CONSTRAINT `fk_table1_contenidos1` FOREIGN KEY (`contenidos_idcontenidos`) REFERENCES `contenidos` (`idcontenidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenidos`
--

DROP TABLE IF EXISTS `contenidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contenidos` (
  `idcontenidos` int NOT NULL AUTO_INCREMENT,
  `fechaSubida` date DEFAULT NULL,
  `titulo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipoContenido_idtipoContenido` int NOT NULL,
  `Actividad_idActividad` int NOT NULL,
  PRIMARY KEY (`idcontenidos`),
  KEY `fk_contenidos_tipoContenido1_idx` (`tipoContenido_idtipoContenido`),
  KEY `fk_contenidos_Actividad1_idx` (`Actividad_idActividad`),
  CONSTRAINT `fk_contenidos_Actividad1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`),
  CONSTRAINT `fk_contenidos_tipoContenido1` FOREIGN KEY (`tipoContenido_idtipoContenido`) REFERENCES `tipocontenido` (`idtipoContenido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenidos`
--

LOCK TABLES `contenidos` WRITE;
/*!40000 ALTER TABLE `contenidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datospersonales`
--

DROP TABLE IF EXISTS `datospersonales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datospersonales` (
  `idDatosPersonales` int NOT NULL AUTO_INCREMENT,
  `nombreDP` varchar(45) DEFAULT NULL,
  `apellidoDP` varchar(45) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `generoDP` varchar(45) DEFAULT NULL,
  `usuarios_idusuarios` int NOT NULL,
  `PaisNacimiento_idPaisNacimiento` int NOT NULL,
  PRIMARY KEY (`idDatosPersonales`),
  KEY `fk_datosPersonales_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_datosPersonales_PaisNacimiento1_idx` (`PaisNacimiento_idPaisNacimiento`),
  CONSTRAINT `fk_datosPersonales_PaisNacimiento1` FOREIGN KEY (`PaisNacimiento_idPaisNacimiento`) REFERENCES `paisnacimiento` (`idPaisNacimiento`),
  CONSTRAINT `fk_datosPersonales_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datospersonales`
--

LOCK TABLES `datospersonales` WRITE;
/*!40000 ALTER TABLE `datospersonales` DISABLE KEYS */;
/*!40000 ALTER TABLE `datospersonales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historialusuario`
--

DROP TABLE IF EXISTS `historialusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historialusuario` (
  `idhistorialusuario` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Activo',
  `eliminacionLogica` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  `fechaInicia` date DEFAULT NULL,
  `fechaFinaliza` date DEFAULT NULL,
  `datospersonales_idDatosPersonales` int NOT NULL,
  PRIMARY KEY (`idhistorialusuario`),
  KEY `fk_historialusuario_datospersonales1_idx` (`datospersonales_idDatosPersonales`),
  CONSTRAINT `fk_historialusuario_datospersonales1` FOREIGN KEY (`datospersonales_idDatosPersonales`) REFERENCES `datospersonales` (`idDatosPersonales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historialusuario`
--

LOCK TABLES `historialusuario` WRITE;
/*!40000 ALTER TABLE `historialusuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `historialusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `idimagenes` int NOT NULL AUTO_INCREMENT,
  `subidaImg` varchar(255) DEFAULT NULL,
  `fechaSubidaImg` date DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  PRIMARY KEY (`idimagenes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenescontenido`
--

DROP TABLE IF EXISTS `imagenescontenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenescontenido` (
  `idimagenescontenido` int NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  `contenidos_idcontenidos` int NOT NULL,
  PRIMARY KEY (`idimagenescontenido`),
  KEY `fk_revisionImagenes_has_contenidos_contenidos1_idx` (`contenidos_idcontenidos`),
  KEY `fk_revisionImagenes_has_contenidos_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_contenidos1` FOREIGN KEY (`contenidos_idcontenidos`) REFERENCES `contenidos` (`idcontenidos`),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenescontenido`
--

LOCK TABLES `imagenescontenido` WRITE;
/*!40000 ALTER TABLE `imagenescontenido` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagenescontenido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interacciones`
--

DROP TABLE IF EXISTS `interacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interacciones` (
  `idinteracciones` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `actividad_idActividad` int NOT NULL,
  `megusta` int DEFAULT '0',
  `nomegusta` int DEFAULT '0',
  `reporte` int DEFAULT '0',
  PRIMARY KEY (`idinteracciones`),
  KEY `fk_usuarios_has_actividad_actividad1_idx` (`actividad_idActividad`),
  KEY `fk_usuarios_has_actividad_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_usuarios_has_actividad_actividad1` FOREIGN KEY (`actividad_idActividad`) REFERENCES `actividad` (`idActividad`),
  CONSTRAINT `fk_usuarios_has_actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interacciones`
--

LOCK TABLES `interacciones` WRITE;
/*!40000 ALTER TABLE `interacciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `interacciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lugarlocal`
--

DROP TABLE IF EXISTS `lugarlocal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lugarlocal` (
  `idlugarLocal` int NOT NULL AUTO_INCREMENT,
  `nombreLugar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  PRIMARY KEY (`idlugarLocal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugarlocal`
--

LOCK TABLES `lugarlocal` WRITE;
/*!40000 ALTER TABLE `lugarlocal` DISABLE KEYS */;
/*!40000 ALTER TABLE `lugarlocal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivos`
--

DROP TABLE IF EXISTS `motivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivos` (
  `idmotivos` int NOT NULL AUTO_INCREMENT,
  `descripcion` longtext,
  PRIMARY KEY (`idmotivos`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivos`
--

LOCK TABLES `motivos` WRITE;
/*!40000 ALTER TABLE `motivos` DISABLE KEYS */;
INSERT INTO `motivos` VALUES (1,'Publicó múltiples mensajes de spam en diferentes temas'),(2,'Utilizó lenguaje ofensivo y despectivo en sus comentarios'),(3,'Acosó repetidamente a otros usuarios en el foro'),(4,'Publicó contenido inapropiado y ofensivo'),(5,'Se hizo pasar por otro usuario o moderador'),(6,'Violó repetidamente las reglas del foro'),(7,'Publicó enlaces a sitios web maliciosos o peligrosos'),(8,'Incitó a la violencia o al odio hacia grupos específicos'),(9,'Utilizó múltiples cuentas para manipular discusiones'),(10,'Recibió múltiples denuncias de otros usuarios por conducta inapropiada'),(11,'Publicó imágenes inapropiadas');
/*!40000 ALTER TABLE `motivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `idnotificaciones` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `tipoNotificación_idtipoNotificación` int NOT NULL,
  PRIMARY KEY (`idnotificaciones`),
  KEY `fk_notificaciones_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_notificaciones_tipoNotificación1_idx` (`tipoNotificación_idtipoNotificación`),
  CONSTRAINT `fk_notificaciones_tipoNotificación1` FOREIGN KEY (`tipoNotificación_idtipoNotificación`) REFERENCES `tiponotificación` (`idtipoNotificación`),
  CONSTRAINT `fk_notificaciones_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenpago`
--

DROP TABLE IF EXISTS `ordenpago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenpago` (
  `idordenpago` int NOT NULL AUTO_INCREMENT,
  `factura` longtext NOT NULL,
  `metodoPago` longtext NOT NULL,
  `diaPago` datetime NOT NULL,
  `estadoPago` varchar(255) NOT NULL,
  `nombreComprador` varchar(105) NOT NULL,
  `apellidoComprador` varchar(105) NOT NULL,
  `usuarios_idusuarios` int NOT NULL,
  `precioServicio_idprecioServicio` int NOT NULL,
  PRIMARY KEY (`idordenpago`),
  KEY `fk_suscripcion_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_ordenpago_precioServicio1_idx` (`precioServicio_idprecioServicio`),
  CONSTRAINT `fk_ordenpago_precioServicio1` FOREIGN KEY (`precioServicio_idprecioServicio`) REFERENCES `precioservicio` (`idprecioServicio`),
  CONSTRAINT `fk_suscripcion_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenpago`
--

LOCK TABLES `ordenpago` WRITE;
/*!40000 ALTER TABLE `ordenpago` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenpago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paisnacimiento`
--

DROP TABLE IF EXISTS `paisnacimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paisnacimiento` (
  `idPaisNacimiento` int NOT NULL AUTO_INCREMENT,
  `nombrePN` varchar(100) NOT NULL,
  PRIMARY KEY (`idPaisNacimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paisnacimiento`
--

LOCK TABLES `paisnacimiento` WRITE;
/*!40000 ALTER TABLE `paisnacimiento` DISABLE KEYS */;
INSERT INTO `paisnacimiento` VALUES (1,'Afganistán'),(2,'Albania'),(3,'Alemania'),(4,'Andorra'),(5,'Angola'),(6,'Antigua y Barbuda'),(7,'Arabia Saudita'),(8,'Argelia'),(9,'Argentina'),(10,'Armenia'),(11,'Australia'),(12,'Austria'),(13,'Azerbaiyán'),(14,'Bahamas'),(15,'Bangladés'),(16,'Barbados'),(17,'Baréin'),(18,'Bélgica'),(19,'Belice'),(20,'Benín'),(21,'Bielorrusia'),(22,'Birmania/Myanmar'),(23,'Bolivia'),(24,'Bosnia y Herzegovina'),(25,'Botsuana'),(26,'Brasil'),(27,'Brunéi'),(28,'Bulgaria'),(29,'Burkina Faso'),(30,'Burundi'),(31,'Bután'),(32,'Cabo Verde'),(33,'Camboya'),(34,'Camerún'),(35,'Canadá'),(36,'Catar'),(37,'Chad'),(38,'Chile'),(39,'China'),(40,'Chipre'),(41,'Ciudad del Vaticano'),(42,'Colombia'),(43,'Comoras'),(44,'Corea del Norte'),(45,'Corea del Sur'),(46,'Costa de Marfil'),(47,'Costa Rica'),(48,'Croacia'),(49,'Cuba'),(50,'Dinamarca'),(51,'Dominica'),(52,'Ecuador'),(53,'Egipto'),(54,'El Salvador'),(55,'Emiratos Árabes Unidos'),(56,'Eritrea'),(57,'Eslovaquia'),(58,'Eslovenia'),(59,'España'),(60,'Estados Unidos'),(61,'Estonia'),(62,'Etiopía'),(63,'Filipinas'),(64,'Finlandia'),(65,'Fiyi'),(66,'Francia'),(67,'Gabón'),(68,'Gambia'),(69,'Georgia'),(70,'Ghana'),(71,'Granada'),(72,'Grecia'),(73,'Guatemala'),(74,'Guyana'),(75,'Guinea'),(76,'Guinea ecuatorial'),(77,'Guinea-Bisáu'),(78,'Haití'),(79,'Honduras'),(80,'Hungría'),(81,'India'),(82,'Indonesia'),(83,'Irak'),(84,'Irán'),(85,'Irlanda'),(86,'Islandia'),(87,'Islas Marshall'),(88,'Islas Salomón'),(89,'Israel'),(90,'Italia'),(91,'Jamaica'),(92,'Japón'),(93,'Jordania'),(94,'Kazajistán'),(95,'Kenia'),(96,'Kirguistán'),(97,'Kiribati'),(98,'Kuwait'),(99,'Laos'),(100,'Lesoto'),(101,'Letonia'),(102,'Líbano'),(103,'Liberia'),(104,'Libia'),(105,'Liechtenstein'),(106,'Lituania'),(107,'Luxemburgo'),(108,'Macedonia del Norte'),(109,'Madagascar'),(110,'Malasia'),(111,'Malaui'),(112,'Maldivas'),(113,'Malí'),(114,'Malta'),(115,'Marruecos'),(116,'Mauricio'),(117,'Mauritania'),(118,'México'),(119,'Micronesia'),(120,'Moldavia'),(121,'Mónaco'),(122,'Mongolia'),(123,'Montenegro'),(124,'Mozambique'),(125,'Namibia'),(126,'Nauru'),(127,'Nepal'),(128,'Nicaragua'),(129,'Níger'),(130,'Nigeria'),(131,'Noruega'),(132,'Nueva Zelanda'),(133,'Omán'),(134,'Países Bajos'),(135,'Pakistán'),(136,'Palaos'),(137,'Panamá'),(138,'Papúa Nueva Guinea'),(139,'Paraguay'),(140,'Perú'),(141,'Polonia'),(142,'Portugal'),(143,'Reino Unido'),(144,'República Centroafricana'),(145,'República Checa'),(146,'República del Congo'),(147,'República Democrática del Congo'),(148,'República Dominicana'),(149,'República Sudafricana'),(150,'Ruanda'),(151,'Rumanía'),(152,'Rusia'),(153,'Samoa'),(154,'San Cristóbal y Nieves'),(155,'San Marino'),(156,'San Vicente y las Granadinas'),(157,'Santa Lucía'),(158,'Santo Tomé y Príncipe'),(159,'Senegal'),(160,'Serbia'),(161,'Seychelles'),(162,'Sierra Leona'),(163,'Singapur'),(164,'Siria'),(165,'Somalia'),(166,'Sri Lanka'),(167,'Suazilandia'),(168,'Sudán'),(169,'Sudán del Sur'),(170,'Suecia'),(171,'Suiza'),(172,'Surinam'),(173,'Tailandia'),(174,'Tanzania'),(175,'Tayikistán'),(176,'Timor Oriental'),(177,'Togo'),(178,'Tonga'),(179,'Trinidad y Tobago'),(180,'Túnez'),(181,'Turkmenistán'),(182,'Turquía'),(183,'Tuvalu'),(184,'Ucrania'),(185,'Uganda'),(186,'Uruguay'),(187,'Uzbekistán'),(188,'Vanuatu'),(189,'Venezuela'),(190,'Vietnam'),(191,'Yemen'),(192,'Yibuti'),(193,'Zambia'),(194,'Zimbabue');
/*!40000 ALTER TABLE `paisnacimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `precios`
--

DROP TABLE IF EXISTS `precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `precios` (
  `idprecios` int NOT NULL AUTO_INCREMENT,
  `precio` decimal(10,0) NOT NULL,
  `estadoPrecio` varchar(45) NOT NULL,
  PRIMARY KEY (`idprecios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precios`
--

LOCK TABLES `precios` WRITE;
/*!40000 ALTER TABLE `precios` DISABLE KEYS */;
/*!40000 ALTER TABLE `precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `precioservicio`
--

DROP TABLE IF EXISTS `precioservicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `precioservicio` (
  `idprecioServicio` int NOT NULL AUTO_INCREMENT,
  `tipoServicio` varchar(45) NOT NULL,
  `referenciaIdFicticio` int NOT NULL,
  `precios_idprecios` int NOT NULL,
  PRIMARY KEY (`idprecioServicio`),
  KEY `fk_precioServicio_precios1_idx` (`precios_idprecios`),
  CONSTRAINT `fk_precioServicio_precios1` FOREIGN KEY (`precios_idprecios`) REFERENCES `precios` (`idprecios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precioservicio`
--

LOCK TABLES `precioservicio` WRITE;
/*!40000 ALTER TABLE `precioservicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `precioservicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redessociales`
--

DROP TABLE IF EXISTS `redessociales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `redessociales` (
  `idredesSociales` int NOT NULL AUTO_INCREMENT,
  `linkRedSocial` varchar(512) DEFAULT NULL,
  `nombreRedSocial` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idredesSociales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redessociales`
--

LOCK TABLES `redessociales` WRITE;
/*!40000 ALTER TABLE `redessociales` DISABLE KEYS */;
/*!40000 ALTER TABLE `redessociales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportes`
--

DROP TABLE IF EXISTS `reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes` (
  `idreportes` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `motivos_idmotivos` int DEFAULT NULL,
  PRIMARY KEY (`idreportes`),
  KEY `fk_redsocial_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_reportes_motivos1_idx` (`motivos_idmotivos`),
  CONSTRAINT `fk_redsocial_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`),
  CONSTRAINT `fk_reportes_motivos1` FOREIGN KEY (`motivos_idmotivos`) REFERENCES `motivos` (`idmotivos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes`
--

LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
/*!40000 ALTER TABLE `reportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revisionimagenes`
--

DROP TABLE IF EXISTS `revisionimagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revisionimagenes` (
  `idrevisionImagenescol` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `imagenes_idimagenes` int NOT NULL,
  `tipodefoto_idtipoDeFoto` int NOT NULL,
  PRIMARY KEY (`idrevisionImagenescol`),
  KEY `fk_usuarios_has_imagenes_imagenes1_idx` (`imagenes_idimagenes`),
  KEY `fk_usuarios_has_imagenes_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_revisionImagenes_tipodefoto1_idx` (`tipodefoto_idtipoDeFoto`),
  CONSTRAINT `fk_revisionImagenes_tipodefoto1` FOREIGN KEY (`tipodefoto_idtipoDeFoto`) REFERENCES `tipodefoto` (`idtipoDeFoto`),
  CONSTRAINT `fk_usuarios_has_imagenes_imagenes1` FOREIGN KEY (`imagenes_idimagenes`) REFERENCES `imagenes` (`idimagenes`),
  CONSTRAINT `fk_usuarios_has_imagenes_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisionimagenes`
--

LOCK TABLES `revisionimagenes` WRITE;
/*!40000 ALTER TABLE `revisionimagenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `revisionimagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `idrol` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Staff'),(3,'SuperFan'),(4,'FanBasic');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `show`
--

DROP TABLE IF EXISTS `show`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `show` (
  `idshow` int NOT NULL AUTO_INCREMENT,
  `fechashow` datetime NOT NULL,
  `estadoShow` varchar(45) DEFAULT 'Activo',
  `linkCompraEntrada` varchar(255) DEFAULT NULL,
  `ubicacionShow_idubicacionShow` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int DEFAULT NULL,
  `lugarLocal_idlugarLocal` int NOT NULL,
  PRIMARY KEY (`idshow`),
  KEY `fk_show_ubicacionShow1_idx` (`ubicacionShow_idubicacionShow`),
  KEY `fk_show_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  KEY `fk_show_lugarLocal1_idx` (`lugarLocal_idlugarLocal`),
  CONSTRAINT `fk_show_lugarLocal1` FOREIGN KEY (`lugarLocal_idlugarLocal`) REFERENCES `lugarlocal` (`idlugarLocal`),
  CONSTRAINT `fk_show_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_show_ubicacionShow1` FOREIGN KEY (`ubicacionShow_idubicacionShow`) REFERENCES `ubicacionshow` (`idubicacionShow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `show`
--

LOCK TABLES `show` WRITE;
/*!40000 ALTER TABLE `show` DISABLE KEYS */;
/*!40000 ALTER TABLE `show` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffextra`
--

DROP TABLE IF EXISTS `staffextra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staffextra` (
  `idstaffExtra` int NOT NULL AUTO_INCREMENT,
  `redesSociales_idredesSociales` int DEFAULT NULL,
  `usuarios_idusuarios` int NOT NULL,
  `tipoStaff_idtipoStaff` int NOT NULL,
  `revisionimagenes_idrevisionImagenescol` int DEFAULT NULL,
  PRIMARY KEY (`idstaffExtra`),
  KEY `fk_staffExtra_redesSociales_idx` (`redesSociales_idredesSociales`),
  KEY `fk_staffExtra_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_staffextra_tipoStaff1_idx` (`tipoStaff_idtipoStaff`),
  KEY `fk_staffextra_revisionimagenes1_idx` (`revisionimagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_staffExtra_redesSociales` FOREIGN KEY (`redesSociales_idredesSociales`) REFERENCES `redessociales` (`idredesSociales`),
  CONSTRAINT `fk_staffextra_revisionimagenes1` FOREIGN KEY (`revisionimagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_staffextra_tipoStaff1` FOREIGN KEY (`tipoStaff_idtipoStaff`) REFERENCES `tipostaff` (`idtipoStaff`),
  CONSTRAINT `fk_staffExtra_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffextra`
--

LOCK TABLES `staffextra` WRITE;
/*!40000 ALTER TABLE `staffextra` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffextra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoactividad`
--

DROP TABLE IF EXISTS `tipoactividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipoactividad` (
  `idtipoActividad` int NOT NULL AUTO_INCREMENT,
  `nombreActividad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtipoActividad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoactividad`
--

LOCK TABLES `tipoactividad` WRITE;
/*!40000 ALTER TABLE `tipoactividad` DISABLE KEYS */;
INSERT INTO `tipoactividad` VALUES (1,'Perfil'),(2,'Comentarios'),(3,'Contenidos');
/*!40000 ALTER TABLE `tipoactividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocontenido`
--

DROP TABLE IF EXISTS `tipocontenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocontenido` (
  `idtipoContenido` int NOT NULL AUTO_INCREMENT,
  `tipoContenido` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idtipoContenido`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocontenido`
--

LOCK TABLES `tipocontenido` WRITE;
/*!40000 ALTER TABLE `tipocontenido` DISABLE KEYS */;
INSERT INTO `tipocontenido` VALUES (1,'Foro'),(2,'Noticias'),(3,'Biografia');
/*!40000 ALTER TABLE `tipocontenido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipodefoto`
--

DROP TABLE IF EXISTS `tipodefoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipodefoto` (
  `idtipoDeFoto` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtipoDeFoto`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipodefoto`
--

LOCK TABLES `tipodefoto` WRITE;
/*!40000 ALTER TABLE `tipodefoto` DISABLE KEYS */;
INSERT INTO `tipodefoto` VALUES (1,'Usuarios'),(2,'Contenido Staff'),(3,'Multimedia General'),(4,'Flyers'),(5,'Contenido Foro'),(6,'Portada'),(7,'Fijas');
/*!40000 ALTER TABLE `tipodefoto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiponotificación`
--

DROP TABLE IF EXISTS `tiponotificación`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiponotificación` (
  `idtipoNotificación` int NOT NULL AUTO_INCREMENT,
  `nombreNotificacion` varchar(75) DEFAULT NULL,
  `descripcionNotificacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtipoNotificación`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiponotificación`
--

LOCK TABLES `tiponotificación` WRITE;
/*!40000 ALTER TABLE `tiponotificación` DISABLE KEYS */;
INSERT INTO `tiponotificación` VALUES (1,'Shows','Próximos eventos y conciertos en vivo. No te pierdas las fechas, lugares y detalles de nuestras presentaciones para disfrutar la mejor música en directo.'),(2,'Noticias','Últimas novedades y actualizaciones sobre lanzamientos, colaboraciones y todo lo relacionado con nuestro proyecto musical y comunidad.'),(3,'Foro','Discute y comparte opiniones con otros usuarios. Únete a debates, resuelve dudas o participa en conversaciones sobre música, eventos y temas de interés.'),(4,'Nuevo Contenido Descargable','Descargas exclusivas disponibles para ti. Accede a nuevo material como partituras, fondos, videos, y más, diseñado especialmente para nuestra comunidad.'),(5,'Nuevo Contenido de Galeria','Fotos y videos recientes añadidos a la galería. Revive momentos especiales y descubre material visual inédito de nuestros eventos y actividades.'),(6,'Nuevo álbum de Música','Escucha nuestro nuevo álbum. Explora las canciones recién lanzadas y disfruta de la evolución de nuestro sonido. ¡Disponible ahora en todas las plataformas!');
/*!40000 ALTER TABLE `tiponotificación` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipostaff`
--

DROP TABLE IF EXISTS `tipostaff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipostaff` (
  `idtipoStaff` int NOT NULL AUTO_INCREMENT,
  `nombreStaff` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idtipoStaff`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipostaff`
--

LOCK TABLES `tipostaff` WRITE;
/*!40000 ALTER TABLE `tipostaff` DISABLE KEYS */;
INSERT INTO `tipostaff` VALUES (1,'Bass Guitar'),(2,'Cameraman'),(3,'Designer'),(4,'Drummer'),(5,'Filmmaker'),(6,'Gods of the Page'),(7,'Guitar'),(8,'Lighting Technician'),(9,'Manages'),(10,'Photographer'),(11,'Press'),(12,'Sound Technician'),(13,'Stage Manager or Technician'),(14,'Vocalist and Guitar');
/*!40000 ALTER TABLE `tipostaff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicacionshow`
--

DROP TABLE IF EXISTS `ubicacionshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ubicacionshow` (
  `idubicacionShow` int NOT NULL AUTO_INCREMENT,
  `provinciaLugar` varchar(255) DEFAULT NULL,
  `paisLugar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idubicacionShow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacionshow`
--

LOCK TABLES `ubicacionshow` WRITE;
/*!40000 ALTER TABLE `ubicacionshow` DISABLE KEYS */;
/*!40000 ALTER TABLE `ubicacionshow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `usuarioUser` varchar(45) DEFAULT NULL,
  `contraseniaUser` varchar(100) DEFAULT NULL,
  `pinOlvidoUser` varchar(100) DEFAULT NULL,
  `correoElectronicoUser` varchar(45) NOT NULL,
  `rol_idrol` int NOT NULL,
  PRIMARY KEY (`idusuarios`),
  KEY `fk_usuarios_rol1_idx` (`rol_idrol`),
  CONSTRAINT `fk_usuarios_rol1` FOREIGN KEY (`rol_idrol`) REFERENCES `roles` (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `idvideos` int NOT NULL AUTO_INCREMENT,
  `subidaVideo` longtext,
  `fechaSubidoVideo` date DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  PRIMARY KEY (`idvideos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `youtubeapi`
--

DROP TABLE IF EXISTS `youtubeapi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `youtubeapi` (
  `idYoutubeApi` int NOT NULL AUTO_INCREMENT,
  `tituloYt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `linkYt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idYoutubeApi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtubeapi`
--

LOCK TABLES `youtubeapi` WRITE;
/*!40000 ALTER TABLE `youtubeapi` DISABLE KEYS */;
/*!40000 ALTER TABLE `youtubeapi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-25 16:06:12
