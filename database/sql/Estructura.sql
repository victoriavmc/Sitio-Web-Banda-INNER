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
  `tipoActividad_idtipoActividad` int NOT NULL,
  PRIMARY KEY (`idActividad`),
  KEY `fk_Actividad_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_actividad_tipoActividad1_idx` (`tipoActividad_idtipoActividad`),
  CONSTRAINT `fk_actividad_tipoActividad1` FOREIGN KEY (`tipoActividad_idtipoActividad`) REFERENCES `tipoactividad` (`idtipoActividad`),
  CONSTRAINT `fk_Actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `albumimagenes`
--

DROP TABLE IF EXISTS `albumimagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albumimagenes` (
  `albumImagenescol` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  PRIMARY KEY (`albumImagenescol`),
  KEY `fk_table1_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumImagenes_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumImagenes_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `albummusical`
--

DROP TABLE IF EXISTS `albummusical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albummusical` (
  `albumMusicalcol` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int DEFAULT NULL,
  PRIMARY KEY (`albumMusicalcol`),
  KEY `fk_albumMusical_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumMusical_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumMusical_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumMusical_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cancion`
--

DROP TABLE IF EXISTS `cancion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cancion` (
  `idcancion` int NOT NULL AUTO_INCREMENT,
  `tituloCancion` longtext,
  `letraEspCancion` longtext,
  `letraInglesCancion` longtext,
  `archivoDsCancion` longtext,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  `albumMusical_albumMusicalcol` int NOT NULL,
  PRIMARY KEY (`idcancion`),
  KEY `fk_cancion_albumMusical1_idx` (`albumMusical_albumMusicalcol`),
  CONSTRAINT `fk_cancion_albumMusical1` FOREIGN KEY (`albumMusical_albumMusicalcol`) REFERENCES `albummusical` (`albumMusicalcol`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `fechaInica` date DEFAULT NULL,
  `fechaFinaliza` date DEFAULT NULL,
  `datospersonales_idDatosPersonales` int NOT NULL,
  PRIMARY KEY (`idhistorialusuario`),
  KEY `fk_historialusuario_datospersonales1_idx` (`datospersonales_idDatosPersonales`),
  CONSTRAINT `fk_historialusuario_datospersonales1` FOREIGN KEY (`datospersonales_idDatosPersonales`) REFERENCES `datospersonales` (`idDatosPersonales`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `idnotificaciones` int NOT NULL AUTO_INCREMENT,
  `opcionNotificacion` varchar(45) DEFAULT NULL,
  `usuarios_idusuarios` int NOT NULL,
  PRIMARY KEY (`idnotificaciones`),
  KEY `fk_notificaciones_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_notificaciones_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reportes`
--

DROP TABLE IF EXISTS `reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes` (
  `idreportes` int NOT NULL AUTO_INCREMENT,
  `reportes` int DEFAULT '0',
  `usuarios_idusuarios` int NOT NULL,
  `motivos_idmotivos` int DEFAULT NULL,
  PRIMARY KEY (`idreportes`),
  KEY `fk_redsocial_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_reportes_motivos1_idx` (`motivos_idmotivos`),
  CONSTRAINT `fk_redsocial_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`),
  CONSTRAINT `fk_reportes_motivos1` FOREIGN KEY (`motivos_idmotivos`) REFERENCES `motivos` (`idmotivos`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `usuarioUser` varchar(45) NOT NULL,
  `contraseniaUser` varchar(100) DEFAULT NULL,
  `pinOlvidoUser` varchar(100) DEFAULT NULL,
  `correoElectronicoUser` varchar(45) NOT NULL,
  `rol_idrol` int NOT NULL,
  PRIMARY KEY (`idusuarios`),
  KEY `fk_usuarios_rol1_idx` (`rol_idrol`),
  CONSTRAINT `fk_usuarios_rol1` FOREIGN KEY (`rol_idrol`) REFERENCES `roles` (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `idvideos` int NOT NULL AUTO_INCREMENT,
  `subidaVideo` varchar(45) DEFAULT NULL,
  `fechaSubidoVideo` varchar(45) DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  PRIMARY KEY (`idvideos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-11 22:02:18
