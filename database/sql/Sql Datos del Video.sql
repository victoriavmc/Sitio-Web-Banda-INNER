-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: inner
-- ------------------------------------------------------
-- Server version	8.0.40

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
INSERT INTO `actividad` VALUES (2,11,3),(3,11,3),(4,11,3),(5,11,3),(6,11,3),(7,11,3),(8,11,3),(9,11,3),(10,11,3),(11,11,3),(19,18,2),(21,18,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumdatos`
--

LOCK TABLES `albumdatos` WRITE;
/*!40000 ALTER TABLE `albumdatos` DISABLE KEYS */;
INSERT INTO `albumdatos` VALUES (1,'Prueba1','2024-10-01'),(3,'Prueba83','2024-10-02'),(4,'jghj','2024-10-02'),(8,'Las Pastillas del Abuelo','2024-10-02');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albummusical`
--

LOCK TABLES `albummusical` WRITE;
/*!40000 ALTER TABLE `albummusical` DISABLE KEYS */;
INSERT INTO `albummusical` VALUES (4,8,33);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumvideo`
--

LOCK TABLES `albumvideo` WRITE;
/*!40000 ALTER TABLE `albumvideo` DISABLE KEYS */;
INSERT INTO `albumvideo` VALUES (1,3,1),(3,3,3),(4,3,4),(5,3,5),(6,4,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistas`
--

LOCK TABLES `artistas` WRITE;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
INSERT INTO `artistas` VALUES (1,60,10),(2,61,11),(3,62,12),(4,63,13);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancion`
--

LOCK TABLES `cancion` WRITE;
/*!40000 ALTER TABLE `cancion` DISABLE KEYS */;
INSERT INTO `cancion` VALUES (5,'La Casada','Ella ganaba bien, como telefonista\r\nYo laburaba mal, y ganaba peor\r\nYo con el primer papel y ella la protagonista\r\nDe la historia más triste\r\nDe todas las de amor\r\nLa fiché desde lejos moviendo su cintura\r\nY al ritmo de su cuerpo mi mirada bailó\r\nSe rompían los espejos reflejando su hermosura\r\nSe rompían los esquemas de mi pobre corazón\r\nNo, no, no\r\nDichoso si es que existe el dueño de esta perla\r\nDe esta obra de arte, de esta boca de miel\r\nLe dije y ahí no más a pesar que existía\r\nNi papel, ni biromes, derechito al hotel\r\nSupe que era casada con problemas de pareja\r\nY que no soportaba gente de mal humor\r\nSupe que enloquecía con los besos en la oreja\r\nQue en la cama y desnuda baila mucho mejor\r\nNo, no, no\r\nElla le caía bien a todos mis sentidos\r\nSalvo cuando el marido era el tema de hablar\r\nCuando su confesión lastimó mis oídos\r\nMe dije, no la escuches, no te ahogues en su mar\r\nYo abrí de par en par las puertas de mi alma\r\nY dejé que saliera mi secreto peor\r\nDisimulando lo triste y conservando la calma\r\nLe dije aunque no creas, estoy buscando amor\r\nNos rendimos los dos a fingir como tontos\r\nQue yo era su marido y que ella era mi mujer\r\nPero al cabo de un tiempo yo no quería ser su esposo\r\nElla quiso volver a ser la dama infiel\r\nAhora ella está feliz, volvió con el idiota\r\nYo recorro las calles buscando otra mujer\r\nY aprendí que mentirse tiene patas muy cortas\r\nQue siempre la costumbre va a matar al placer\r\nVa a matar al placer\r\nNo, no, no','aa','audio/PP3NlUpdVM5POK5wJb72Iwx3P9Xqo0ggBxJn1NOX.mp3','Sí',4),(6,'Princesa','Princesa de todos mis palacios\r\nSi me pudieran dar a elegir\r\nCómo y dónde yo quisiera morir\r\nContestaría, acostado\r\nFeliz de estar a tu lado\r\n\r\nVíctima de un sexo exagerado\r\nSonriendo\r\nMirando el techo\r\nCon tu cabeza en mi pecho\r\n\r\nSabés, me cuesta hacer este viaje\r\nNo, no, no es que no tenga esperanza\r\nYo confío mucho en tu enseñanza\r\nVos confiás, confía en mi aprendizaje\r\n\r\nY si, para nuestro amor\r\nNo encuentro un buen adjetivo\r\nEs porque te amo mucho, mucho más\r\nDel te amo que te digo\r\n\r\nEntre el alcohol y algo más, quedé moribundo\r\nCansado ya de soñar\r\nY, hoy, puedo hacer la canción más hermosa del mundo\r\nY besarte al despertar\r\n\r\nTengo un amigo en España que es cantautor\r\nNo me conoce, pero nos llevamos bien\r\nHizo una canción, se llama: Y, sin embargo\r\nDe esa canción, yo ya no me puedo hacer cargo\r\n\r\nPorque habla de ser infiel\r\nAun amando con locura\r\nLamento decir esto, pero, por fin\r\nSe equivocó Joaquín\r\n\r\nYo controlaba este juego\r\nAl principio, era el dueño\r\nFirmaba cualquier papel\r\nY hoy sois la protagonista de todos mis sueños\r\nSoy esclavo de tu piel','I dont speak','audio/b1E07g72dsBI4MJqJ3eXMXtzHCOPFcNOrIcyF55k.mp3','Sí',4),(7,'Ojos de Dragón!','En miércoles fríos\r\nLa estación oscura\r\nA poetas cobardes\r\nLes mete pavura\r\n\r\nSin embargo, cuando\r\nViene tu figura\r\nFirme y taconeando\r\nVos la hacés pintura\r\n\r\nTrompa de elefante, ojos de dragón\r\nPasti, volvés arte Constitución\r\n\r\nDesacreditan mi arte\r\nDe seducción, mis gomías\r\nEn noches de tanguerías\r\nY sin parar de mirarte\r\n\r\nCaen sentados de traste\r\nSus ratones no dan tregua\r\nMe dicen: guacho, robaste\r\n¿Qué hacés con tremenda yegua?\r\n\r\nTrompa de elefante, ojos de dragón\r\nPasti, flor del sur en Constitución\r\n\r\nEntonces yo les comento\r\nQue vos derrochás dulzura\r\nY ese rasgo en tu hermosura\r\nProduce una envidia sana\r\nImaginate si cuento\r\nLo que hacemos en la cama\r\n\r\nMe enloquece tu mirada\r\nMe atropello con tus labios\r\nY, entre salivas, resbala\r\nEl mensaje de los sabios\r\n\r\nTus ojos entrecerrados\r\nParecen mirar lo eterno\r\nRodando desaforados\r\nBurlamos noches de invierno\r\n\r\nEn este juego convexo\r\nTu espalda eclipsa mi ombligo\r\nTu sexo, para mi sexo\r\nEl más milagroso abrigo\r\n\r\nTu espalda contra mi pecho\r\nTus pechos en el espejo\r\nQue refleja desde el techo\r\nPecaminosos reflejos\r\n\r\nTrompa de elefante, ojos de dragón\r\nPasti, flor del sur en Constitución\r\n\r\nY entonces yo les comento\r\nQue vos derrochas dulzura\r\nY ese rasgo en tu hermosura\r\nProduce una envidia sana\r\nImaginate si cuento\r\nLo que hacemos en la cama',NULL,'audio/jhVXs592Yo70656AXFpZzqRqJzVPKIgzbfU4WpcP.mp3','Sí',4),(14,'Sabina y Piazzolla','aaa','aa','audio/NlTHsRQ2vtS5h69aKYLylF9PL85rKrpj0xhk9Yqg.mp3','No',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (4,'2024-10-31','Texto + Imagen',19,11,56);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenidos`
--

LOCK TABLES `contenidos` WRITE;
/*!40000 ALTER TABLE `contenidos` DISABLE KEYS */;
INSERT INTO `contenidos` VALUES (2,'2024-10-31','¡LA BANDA INNER ANUNCIA SU PRÓXIMO ÁLBUM!','La banda INNER ha confirmado el lanzamiento de su nuevo álbum titulado \'Ritmos del Futuro\', programado para el 15 de noviembre. Este álbum incluirá colaboraciones con artistas destacados y promete una mezcla única de géneros.',2,2),(3,'2024-09-30','¡GIRA MUNDIAL DE LA BANDA INNER COMIENZA EN ENERO!','Tras el éxito de su último tour, la banda Inner ha anunciado una nueva gira mundial que comenzará en enero de 2025. Los fanáticos podrán disfrutar de sus canciones en vivo en ciudades de todo el mundo, con fechas y lugares que se anunciarán próximamente.',2,3),(4,'2024-10-10','¡ENTREVISTA DISPONIBLE EN YOUTUBE!','¡La entrevista que nos realizo #LaEstructuraDelInfierno desde México ?? ya está disponible en su canal de YouTube! Disfruta de la nota completa y conoce más sobre nuestra banda, nuestro trabajo y nuestras últimas novedades. Puedes ver la entrevista en el siguiente enlace: https://www.youtube.com/watch?v=dg-WV5jh4Gc&feature=youtu.be ¡Gracias por su continuo apoyo y por acompañarnos en este viaje musical!',2,4),(5,'2024-10-31','¡LA BANDA INNER ANUNCIA SU PRÓXIMO ÁLBUM!','La banda INNER ha confirmado el lanzamiento de su nuevo álbum titulado \\\'Ritmos del Futuro\\\', programado para el 15 de noviembre. Este álbum incluirá colaboraciones con artistas destacados y promete una mezcla única de géneros.',2,5),(6,'2024-10-31','NoticiaExtra','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',2,6),(7,'2024-10-31','NoticiaExtra222','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',2,7),(9,'2024-10-31','Historia','Inner, una banda de metal originaria de la zona norte de Buenos Aires, está generando un impacto significativo en la escena musical con su potente combinación de subgéneros que abarcan el progresivo, thrash, death y groove metal, entre otros. Actualmente, la banda se encuentra en plena promoción de su álbum debut, titulado \\\"Journey\\\". Con una enérgica presencia en las redes sociales y una sólida trayectoria de shows en vivo, Inner ha logrado captar la atención y el apoyo de una base de seguidores creciente. Durante el último año, la banda se presentó en más de 20 shows en vivo en diversos lugares de Buenos Aires y provincias de Argentina, llevando su música contundente y emocionante a audiencias entusiastas en cada presentación. Además de la promoción de \\\"Journey\\\", Inner está trabajando arduamente en la creación de su segundo álbum, que se espera lanzar a mediados de 2024. Mediante su constante actividad en la escena, la banda demuestra su compromiso de mantenerse activa y evolucionar musicalmente. El nuevo material promete superar las expectativas de los seguidores de Inner y consolidar aún más su posición en la escena del metal. Inner invita a los amantes de la música a unirse a ellos en este emocionante viaje. La banda ha logrado crear un estilo muy personal, combinando una variada mezcla de subgéneros con letras que exploran pensamientos, reflexiones y temas actuales tanto individuales como colectivos del ser humano. \\\"Journey\\\" busca ser este viaje de pensamientos y sonidos. El álbum, compuesto por 9 canciones originales, representa el fruto de años de trabajo y dedicación por parte de los miembros de Inner. Integrantes: - Agustín Casalone en el Bajo - Hernán Ramírez en la Batería - Tomás Casalone en Guitarra y Voz - David Copa en Guitarra',3,9),(10,'2024-10-31','Historia','Modelo1',3,10),(11,'2024-10-20','Virtual Meet and Greet','¡¿Quieren conocer a los artistas de la banda?!\\r\\nEsta es tu oportunidad de conectarte directamente con los miembros de la banda. Si tienes alguna pregunta que siempre quisiste hacerles, ¡este es el momento! Comenta en este post y los artistas responderán desde sus cuentas oficiales. Ya sea sobre su música, influencias, o sus planes a futuro, ¡no te quedes con la duda!',1,11),(16,'2024-10-31','Modelo 1','aaaaa',1,21);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datospersonales`
--

LOCK TABLES `datospersonales` WRITE;
/*!40000 ALTER TABLE `datospersonales` DISABLE KEYS */;
INSERT INTO `datospersonales` VALUES (6,'Victoria Valentina','Maidana Corti','2002-02-16','Femenino',6,9),(7,'Victoria Valentina','Maidana Corti','2002-02-16','Femenino',7,9),(8,'Santiago Nicolas','Aranda','2004-06-14','Masculino',8,9),(9,'Santiago','Aranda','2004-06-14','Masculino',9,9),(11,'NombreStaff2','ApellidoStaff2','1998-08-12','Masculino',11,9),(12,'NombreStaff3','ApellidoStaff3','2000-04-07','Femenino',12,9),(13,'NombreArtista1','ApellidoArtista1','1999-07-07','Masculino',13,9),(14,'NombreArtista2','ApellidoArtista2','1987-12-14','Masculino',14,9),(15,'NombreArtista3','ApellidoArtista3','1978-03-09','Masculino',15,9),(16,'NombreArtista4','ApellidoArtista4','1944-02-12','Masculino',16,9),(17,'NombreFan1','ApellidoFan1','1999-07-08','Masculino',17,9),(18,'NombreFan2','ApellidoFan2','1988-07-08','Femenino',18,9),(19,'NombreFan3','ApellidoFan3','2024-10-03','Masculino',19,9),(20,'Kevin','Schneider','2004-06-14','Masculino',20,9);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historialusuario`
--

LOCK TABLES `historialusuario` WRITE;
/*!40000 ALTER TABLE `historialusuario` DISABLE KEYS */;
INSERT INTO `historialusuario` VALUES (6,'Activo','No','2024-10-31',NULL,6),(7,'Activo','No','2024-10-31',NULL,7),(8,'Activo','No','2024-10-31',NULL,8),(9,'Activo','No','2024-10-31',NULL,9),(11,'Activo','No','2024-10-31',NULL,11),(12,'Activo','No','2024-10-31',NULL,12),(13,'Activo','No','2024-10-31',NULL,13),(14,'Activo','No','2024-10-31',NULL,14),(15,'Activo','No','2024-10-31',NULL,15),(16,'Activo','No','2024-10-31',NULL,16),(17,'Inactivo','Si','2024-10-31','2024-10-31',17),(18,'Suspendido','No','2024-10-31','2024-11-09',18),(19,'Baneado','Si','2024-10-31',NULL,19),(20,'Activo','No','2024-10-31',NULL,20);
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (5,'img/6722ff5d10283.webp','2024-10-31','No'),(6,'img/672307b0968a8.webp','2024-10-31','No'),(7,'img/672307e868d37.webp','2024-10-31','No'),(8,'img/67230824d1609.webp','2024-10-31','No'),(9,'img/67230890806e5.webp','2024-10-31','No'),(10,'img/672308edea5dd.webp','2024-10-31','No'),(26,'img/672319c858ada.webp','2024-10-31','No'),(27,'img/672319f86a4cc.webp','2024-10-31','No'),(28,'img/67231a1e74291.webp','2024-10-31','No'),(29,'img/67231a91549bb.webp','2024-10-31','No'),(30,'img/67231b22f22ce.webp','2024-10-31','No'),(33,'img/672329fd7741c.webp','2024-10-31','No'),(35,'img/67232d8779fb3.webp','2024-10-31','No'),(38,'img/67232d9fb510f.webp','2024-10-31','No'),(41,'img/67232f95396c8.webp','2024-10-31','No'),(56,'img/67239d3706424.webp','2024-10-31','No'),(58,'img/67239d9171f38.webp','2024-10-31','No'),(60,'img/L8UBeKN0XmVHaNnXJz4zOdht8UdFKCOglEwD4Uhf.png','2024-10-31','No'),(61,'img/POxFPC3UX4CqO5Hd2IY92nivfUoZ9siXcTabzY7k.jpg','2024-10-31','No'),(62,'img/JtjWQPI1rIyQBQLNBdkBJxheCtPc7q17H7EvPfvO.png','2024-10-31','No'),(63,'img/LBf70dOOvaHBIA9G4RrOESnzrvnBsI6bT6u9zgYt.jpg','2024-10-31','No');
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenescontenido`
--

LOCK TABLES `imagenescontenido` WRITE;
/*!40000 ALTER TABLE `imagenescontenido` DISABLE KEYS */;
INSERT INTO `imagenescontenido` VALUES (4,26,2),(5,27,3),(6,28,4),(7,29,5),(8,30,7),(9,35,9),(12,38,9),(15,41,11),(28,58,16);
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interacciones`
--

LOCK TABLES `interacciones` WRITE;
/*!40000 ALTER TABLE `interacciones` DISABLE KEYS */;
INSERT INTO `interacciones` VALUES (1,11,11,1,0,0),(3,18,11,0,1,0),(14,11,21,1,0,0),(16,12,21,1,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugarlocal`
--

LOCK TABLES `lugarlocal` WRITE;
/*!40000 ALTER TABLE `lugarlocal` DISABLE KEYS */;
INSERT INTO `lugarlocal` VALUES (1,'Centenario','Formosa (Capital)','Av Italia y Trinidad González casa 20 mz',303),(2,'Cine Teatro Italia','Formosa (Capital)','Av Italia y Trinidad González casa 20 mz',303);
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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (54,6,1),(55,6,2),(56,6,3),(57,6,4),(58,6,5),(59,8,1);
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
  `emailComprador` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idordenpago`),
  KEY `fk_suscripcion_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_ordenpago_precioServicio1_idx` (`precioServicio_idprecioServicio`),
  CONSTRAINT `fk_ordenpago_precioServicio1` FOREIGN KEY (`precioServicio_idprecioServicio`) REFERENCES `precioservicio` (`idprecioServicio`),
  CONSTRAINT `fk_suscripcion_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenpago`
--

LOCK TABLES `ordenpago` WRITE;
/*!40000 ALTER TABLE `ordenpago` DISABLE KEYS */;
INSERT INTO `ordenpago` VALUES (4,'92071095436','Dinero en Cuenta','2024-11-01 01:15:25','Aprobado','Nombre no disponible','Apellido no disponible',20,6,'test_user_1956922157@testuser.com'),(5,'91751050635','Dinero en Cuenta','2024-11-01 01:23:24','Aprobado','Nombre no disponible','Apellido no disponible',20,7,'test_user_1956922157@testuser.com'),(6,'91751134509','Dinero en Cuenta','2024-11-01 01:27:09','Aprobado','Nombre no disponible','Apellido no disponible',6,7,'test_user_1956922157@testuser.com');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precios`
--

LOCK TABLES `precios` WRITE;
/*!40000 ALTER TABLE `precios` DISABLE KEYS */;
INSERT INTO `precios` VALUES (15,16,'Activo'),(16,2000,'Activo');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precioservicio`
--

LOCK TABLES `precioservicio` WRITE;
/*!40000 ALTER TABLE `precioservicio` DISABLE KEYS */;
INSERT INTO `precioservicio` VALUES (6,'Suscripción',0,15),(7,'Show',1,16);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redessociales`
--

LOCK TABLES `redessociales` WRITE;
/*!40000 ALTER TABLE `redessociales` DISABLE KEYS */;
INSERT INTO `redessociales` VALUES (2,'https://www.youtube.com/@Cell_officiall','11stafftwo'),(3,'https://www.youtube.com/@midulive','12staffthree'),(4,'https://www.instagram.com/_victoriavmc_/','7victoriavmc'),(6,'https://www.instagram.com/arandanosantiago/','9arandano'),(8,'https://youtube.com/@innermetal?si=TfUXBVELNsHrKZNX','Youtube'),(9,'https://www.instagram.com/inner.metal/','Instagram'),(10,'https://open.spotify.com/intl-es/artist/0Y9jAWMZF3ve6nxKdNFiWU','Spotify'),(16,'https://www.amazon.es/Songs-Forgotten-Inner-Voices/dp/B07BV5MLPN','Amazon Music'),(17,'https://www.deezer.com/es/show/2142682','Deezer'),(18,'https://music.apple.com/us/artist/inner/1581042144','iTunes'),(19,'https://www.instagram.com/david_b_copa/','13artista1'),(20,'https://www.instagram.com/hjernan/','14artista2'),(21,'https://www.instagram.com/agus.sauvage/','15artista3');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes`
--

LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
INSERT INTO `reportes` VALUES (24,18,NULL),(25,18,1),(26,18,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisionimagenes`
--

LOCK TABLES `revisionimagenes` WRITE;
/*!40000 ALTER TABLE `revisionimagenes` DISABLE KEYS */;
INSERT INTO `revisionimagenes` VALUES (5,6,5,1),(7,11,7,1),(8,12,8,1),(9,7,9,1),(10,9,10,1),(26,11,26,2),(27,11,27,2),(28,11,28,2),(29,11,29,2),(30,11,30,2),(33,11,33,6),(35,11,35,2),(38,11,38,2),(41,11,41,5),(56,18,56,5),(58,18,58,5),(60,13,60,6),(61,14,61,6),(62,15,62,6),(63,16,63,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `show`
--

LOCK TABLES `show` WRITE;
/*!40000 ALTER TABLE `show` DISABLE KEYS */;
INSERT INTO `show` VALUES (1,'2024-11-03 22:09:00','Activo','asd',1,NULL,1),(2,'2024-11-17 00:12:00','Activo','asdf',2,NULL,2),(3,'2024-10-16 22:52:00','Inactivo',NULL,1,NULL,2),(4,'2024-11-01 22:52:00','Activo','asd',1,NULL,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffextra`
--

LOCK TABLES `staffextra` WRITE;
/*!40000 ALTER TABLE `staffextra` DISABLE KEYS */;
INSERT INTO `staffextra` VALUES (1,4,7,6,NULL),(2,6,9,6,NULL),(4,2,11,11,NULL),(5,3,12,3,NULL),(10,19,13,1,NULL),(11,20,14,4,NULL),(12,21,15,7,NULL),(13,NULL,16,14,NULL);
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
INSERT INTO `tiponotificación` VALUES (1,'Shows','Próximos eventos y conciertos en vivo. No te pierdas las fechas, lugares y detalles de nuestras presentaciones para disfrutar la mejor música en directo.'),(2,'Noticias','Últimas novedades y actualizaciones sobre lanzamientos, colaboraciones y todo lo relacionado con nuestro proyecto musical y comunidad.'),(3,'Foro','Discute y comparte opiniones con otros usuarios. Únete a debates, resuelve dudas o participa en conversaciones sobre música, eventos y temas de interés.'),(4,'Nuevo Contenido de Galeria','Fotos y videos recientes añadidos a la galería. Revive momentos especiales y descubre material visual inédito de nuestros eventos y actividades.'),(5,'Nuevo álbum de Música','Escucha nuestro nuevo álbum. Explora las canciones recién lanzadas y disfruta de la evolución de nuestro sonido. ¡Disponible ahora en todas las plataformas!');
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
  `artista` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  PRIMARY KEY (`idtipoStaff`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipostaff`
--

LOCK TABLES `tipostaff` WRITE;
/*!40000 ALTER TABLE `tipostaff` DISABLE KEYS */;
INSERT INTO `tipostaff` VALUES (1,'Bass Guitar','Si'),(2,'Cameraman','No'),(3,'Designer','No'),(4,'Drummer','Si'),(5,'Filmmaker','No'),(6,'Gods of the Page','No'),(7,'Guitar','Si'),(8,'Lighting Technician','No'),(9,'Manages','No'),(10,'Photographer','No'),(11,'Press','No'),(12,'Sound Technician','No'),(13,'Stage Manager or Technician','No'),(14,'Vocalist and Guitar','Si');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacionshow`
--

LOCK TABLES `ubicacionshow` WRITE;
/*!40000 ALTER TABLE `ubicacionshow` DISABLE KEYS */;
INSERT INTO `ubicacionshow` VALUES (1,'Montevideo','Argentina'),(2,'Santiago','Chile');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (6,'amuquy','$2y$12$o1YtrMYEzOB4VILss7iTkOuZHHoKiAgt4k1LXI6FR9VFm8kyLT2Eq',NULL,'victoriavmcortitrabajos@gmail.com',4),(7,'victoriavmc','$2y$12$V8prLF8qhZGILqmfMOXcT.e0JFqcgnyl5jcZmhUR9sLrqUt7rDzQW',NULL,'victoriavmaidanacortitrabajos@hotmail.com',2),(8,'santi','$2y$12$QZ48uwgK27x8g51j2yvw0ONN36474oxzFogR8KWHPR4TDdTege9vS',NULL,'santiago.aranda.81@gmail.com',1),(9,'arandano','$2y$12$uQ2dYfrKfSPKB.pBtU59UeyVYhsbF8rFEpEPYrMwTcZk/KYDU2yGa',NULL,'santiago.aranda@gmail.com',2),(11,'stafftwo','$2y$12$/ysj6w.hswHmA1G4JjaTpuZSWAGj7hBKNF3PsTUXLIZFUQY.DZdmO',NULL,'staff2@example.com',2),(12,'staffthree','$2y$12$bkqOGt.s2KP.XI3ysXwG2ONF3fqZlU5sgEJQKOOfXJyCJlq.mSnNW',NULL,'staffthree@example.com',2),(13,'artista1','$2y$12$rKULeVSlbLOBvc8/oYD9iOGlXS6lxZPnJWUeM.DuOIzhPvHCujEi.',NULL,'artista1@example.com',2),(14,'artista2','$2y$12$u3zm4bneSQFi9LLPxNdequfDOMNBvEszpSoxqGGDVZKtZj5RQFbKO',NULL,'artista2@example.com',2),(15,'artista3','$2y$12$xgpRDq99BQfDSPxYjR6iluxIfr7najSGIpihjH3UqoZ/2zQbzhX8W',NULL,'artista3@example.com',2),(16,'artista4','$2y$12$96ako8ejfJmpMtwzcwSRZ.slvAFpnA791zAwIh45kxB9WF20MsmmS',NULL,'artista4@example.com',2),(17,NULL,NULL,'','fanone@example.com',3),(18,'fantwo','$2y$12$zZBfSt1..cUllHdj7zrIgu6JwIIQlhi4lY9TvHcSke8OKPJN66DqC','$2y$12$ePJSNbgnJ1UaPrqV//u/c.4LIFpYcnm332K33Sn6BaHYqF4Pero.C','fantwo@examplel.com',3),(19,NULL,NULL,NULL,'fan3@example.com',3),(20,'kevin','$2y$12$XSxcwfLkygkvO1V.wPe5Bemy4NJT3gOjzuG5atg/oo5DawC4v.ppm',NULL,'schneiderk985@gmail.com',3);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'video/MzOyt8WVWRKharIRzFcUskgxf9bPPYIqbTVBOCtk.mp4','2024-10-31','Sí'),(3,'video/tANxpfMN2oMRSRFkEdBUaXaLl80Mih4M8jslP1RG.mp4','2024-10-31','Sí'),(4,'video/ztrTSS3hkHeUmFrWO30VzsNOTS34pav9mTBXPvx3.mp4','2024-10-31','Sí'),(5,'video/rqZZ82nTnidfdTNH6biZ9AyueD2CNdVbwBMqwZ0P.mp4','2024-10-31','Sí'),(6,'video/OX6heVE3zvD5S0Qc1Xu2DuQsDYTdXEtKen6Nfeb6.mp4','2024-10-31','No');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtubeapi`
--

LOCK TABLES `youtubeapi` WRITE;
/*!40000 ALTER TABLE `youtubeapi` DISABLE KEYS */;
INSERT INTO `youtubeapi` VALUES (1,'INNER - Forgotten - Drum Playthrough by Hernan Ramirez','2024-07-22','https://www.youtube.com/watch?v=Zn33STtdNVo'),(2,'INNER - Black Trees - Drum Playthrough by Hernan Ramirez','2024-07-17','https://www.youtube.com/watch?v=EgAhuhtSFYk'),(3,'#shorts INNER - Resumen - Uniclub 10/02/24','2024-02-19','https://www.youtube.com/watch?v=l5jbhWafkvs'),(4,'#shorts INNER - Resumen - El teatrito 20/08/23','2023-09-01','https://www.youtube.com/watch?v=CNU3BgREl80'),(5,'#shorts INNER - Resumen - Salon Regional Leonesa 24/6/23','2023-07-09','https://www.youtube.com/watch?v=QTXad02TcSo'),(6,'INNER - Hill of the Seven Colors','2021-09-04','https://www.youtube.com/watch?v=ntev9lgyFe0'),(7,'INNER - Dying','2021-09-04','https://www.youtube.com/watch?v=JwcxshhJ9Zs'),(8,'INNER - Evolution','2021-09-04','https://www.youtube.com/watch?v=8PvPxBHzyvw'),(9,'INNER - The Journey','2021-09-04','https://www.youtube.com/watch?v=pt59HWnfaSo'),(10,'INNER - Focus','2021-09-04','https://www.youtube.com/watch?v=ynEBN2JN8tY'),(11,'INNER - Vicious Circle','2021-09-04','https://www.youtube.com/watch?v=enxO7xJIqYY'),(12,'INNER - Imploded Sun','2021-09-04','https://www.youtube.com/watch?v=7t0B85mYHxk'),(13,'INNER - Black Trees','2021-08-09','https://www.youtube.com/watch?v=BxCJKHj5b6w'),(14,'INNER - Forgotten','2021-04-27','https://www.youtube.com/watch?v=TPDVdPe3Gpo');
/*!40000 ALTER TABLE `youtubeapi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'inner'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-01  3:01:20
