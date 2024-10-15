CREATE DATABASE  IF NOT EXISTS `inner` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `inner`;
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
INSERT INTO `actividad` VALUES (1,5,3),(4,5,3),(6,5,3),(7,5,3),(19,6,3),(20,11,2),(22,12,2),(23,12,3),(24,11,2),(25,13,2),(27,13,2),(28,13,2),(29,14,2),(30,14,2),(33,15,2),(34,15,3),(35,15,3),(36,1,2),(37,1,2),(39,5,3),(40,5,3),(41,5,3),(42,5,3),(43,5,3),(44,15,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumdatos`
--

LOCK TABLES `albumdatos` WRITE;
/*!40000 ALTER TABLE `albumdatos` DISABLE KEYS */;
INSERT INTO `albumdatos` VALUES (1,'Journey','2021-09-04');
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
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
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
-- Dumping data for table `albummusical`
--

LOCK TABLES `albummusical` WRITE;
/*!40000 ALTER TABLE `albummusical` DISABLE KEYS */;
INSERT INTO `albummusical` VALUES (1,1,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistas`
--

LOCK TABLES `artistas` WRITE;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */;
INSERT INTO `artistas` VALUES (1,57,6),(2,53,7),(3,54,8),(4,55,9);
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
-- Dumping data for table `cancion`
--

LOCK TABLES `cancion` WRITE;
/*!40000 ALTER TABLE `cancion` DISABLE KEYS */;
INSERT INTO `cancion` VALUES (1,'BLACK TREES','Cómo puedo explicar Algo que ya se encuentra en mis huesos? Eso que me sostiene y me mantiene en pie Es fácil quejarse y no creer en el curso natural Cuando tomas el camino Bajo la sombra De los árboles negros Pero el río sabe mejor Va a llevarte Hacia el mar Hacia lo más grandes océanos Si tú sigues tus manos El cuerpo sabe el resto No se siente el aire, ni la gravedad Sonido de maestros, en cada latido del corazón Diciéndote La sabiduría es todo','How can I explain Something that\'s already in my bones That thing that holds me to keep me still It\'s easy to complain and don\'t believe in the natural course When you take the path Under the shade Of the black trees But the river knows better It\'s going to take you To the sea To the greatest oceans If you follow your hands The body knows the rest Don\'t feel the air, the gravitation Sounds of masters in every heartbeat Telling you Wisdom is everything',NULL,'No',1),(2,'DYING','Ella fue hecha para nosotros, y nosotros para ella Amor mutuo, pero se perdió en alguna parte Nos dió tanto que sin fuerzas se quedó Amor tóxico, muriéndo lentamente Devastado, profundamente desde adentro Quemándo todas las hojas en las llamas de infierno Ambición Sin empatía Incubado por un largo tiempo Esa cosa que no sabes que es Es un regalo o una enfermedad mortal Tus propios hijos devoramos tu carne Último aliento, porque nos desvaneceremos Ahora que el Sol toca el océano Sólo se verá ennegrecido Oculto como nuestras almas Suicidio masivo Inocente y constante Todos corremos un paso hacia el olvido','She was made for us and us for her Mutual love, but got lost somewhere She gave us so much and without strength she stayed Toxic love, dying slowly Devastated, deeply from inside Burning all leafs in flames of hell Ambition Without empathy Incubate for a long time This thing that you don\'t know what it is It\'s a gift or mortal sickness Your own sons we devorate your flesh Last breathe \'cause we\'ll fade away Now that the sun touchs the ocean Only it will be seen blackened Hidden like our souls Massive suicide Innocent and constantly We all rush one step to oblivion',NULL,'No',1),(3,'EVOLUTION','Apuñalando su propio útero\nOlvidando de dónde venimos\nLa avaricia domina el alma\n\nComenzando desde el interior de la herída\nAbierto sin final\n\nProceso innatural\nEl final se acerca\nEl cambio se hace notar\nNo hay vuelta atrás\n\nProceso innatural\nEl final se acerca\nEs inútil cerrar los ojos\nNo hay vuelta atrás\n\nComenzando desde el interior del útero\nAbierto sin final\n\nApuñalando su propio infierno\nNo podrás escuchar el llanto\nLa avaricia domina el alma\n\nComenzando desde el interior del útero\nAbierto sin final\n','Stabbing It\'s own womb Forgetting where we become The greed dominates the soul Starting from Inside the wound Open without end Unnatural process The end is closer The change make notice There\'s no turning back Unnatural process The end is closer Useless to close your eyes There is no turning back Starting from The inside the womb Open without end Stabbing It\'s own hell You won\'t hear the crying The greed dominates the soul Starting from Inside the wound Open without end',NULL,'No',1),(4,'FOCUS','Sé que la esperanza se está alejando\nNo podemos dejar que se vaya de aquí\nNuestro futuro está bajo nuestros pies\nCon cada paso que damos\n\nEsta tierra no es nuestra para reclamar\nCrecimos entre las mentiras del hombre\nComiendo árboles y cada vida\nDeberíamos querer nuestros propios sueños\n\nNo lo sabes todavía\nPero si tratas y te concentras\nTus ojos podrían ver más allá de nosotros\nY no lo que ellos quieren que veamos\n\nPuedes escuchar el grito?\nPuedes escuchar la plegaria?\nNo está pidiendo un final\nSolo quiere la vida que se merece\n','I know the hope is getting away We can\'t let it go from here Our future is under our feets With every step we take This land is not for us to claim We grown among the lies of men Eating trees and every life We should want our own dreams You don\'t know it yet But if you try hard and focus Your eyes could see more than us And not what they want us to see Can you hear the shout? Can you hear the pray? It\'s not calling for an end It just wants the life that deserves',NULL,'No',1),(5,'FORGOTTEN','Escondida en el núcleo\nYace una fuerza\nLista para consumir todo en su camino\n\nDentro, cuando algo está mal\nCuando alguien es lastimado\nPuede sacudir, escupir fuego y sangre\nLleno de ira, descepcionada\n\nEstá cansada de esperar, justicia masiva\nEstamos siendo cazados, y es demasiado tarde\n\nPor las buenas o por las malas\nTodo lo que hicimos, y los olvidamos\nToda la vida que ya no está\nTendrá un costo\n\nMiles en la tierra y simplemente no nos importa\nPero la verdad es que deberíamos haber sido nosotros\nEs el camino que el humano tomó\nQue lleva a la autodestrucción\n\nVenimos del polvo\nY polvo es lo único que hicimos\n','Hiding in the core Lies a force Ready to consume everything on it\'s way Inside, when something\'s wrong When someone gets hurt It can shake, spit fire and blood Full of anger, disappointed It\'s tired of waiting, massive justice We are hunted, and it\'s too late Through the good or the hard way All we did, and we forget them All the life that now it\'s gone Will have a cost Thousands on Earth and we just don\'t care But the truth is it should have been us Is the path the human took That leads to self-destruction We came from dust And dust is all we did',NULL,'No',1),(6,'HILL OF THE SEVEN COLORS','Peleé tan duro por esto y ahora\nNo se hacia dónde correr\nTomo impulso, muerdo las cadenas\nMi viaje en busca de tranquilidad comienza\nMi alma, mi sombra, necesitan descansar\n\nCerro de los Siete Colores\nLa piedra verde golpea mi frente\nMis ojos dejan de ver\nEl cóndor Andino me guía\nEsquivando árboles secos\nToco el agua pero no me inunda\nPuedo creér\n\nNo hay montaña que no pueda escalar\nEntrenando mi mente\nCapaz de todo\nEl calor seco quema mi piel, estoy listo\nEntierro mis piés, siendo parte de aquí\n\nCerro de los Siete Colores\nLas hojas cubren mi cuerpo\nHe renacido, he renacido\n','How can I explain Something that\'s already in my bones That thing that holds me to keep me still It\'s easy to complain and don\'t believe in the natural course When you take the path Under the shade Of the black trees But the river knows better It\'s going to take you To the sea To the greatest oceans If you follow your hands The body knows the rest Don\'t feel the air, the gravitation Sounds of masters in every heartbeat Telling you Wisdom is everything',NULL,'No',1),(7,'IMPLODED SUN','Profundo dentro del agujero negro\nCayendo, en busca de la oscuridad\nVeneno y miedo\nToda la ansiedad que las palabras pueden dar\nRecorriendo a través de tu cuerpo\nUna succión constante\nToca fondo\n\nSin descanso, siquiera dormido\nLas luces podrían apagarse\nPero aún no es el final\nEstá sucediendo, a toda velocidad\nBrillando\n\nLa verdad es más fuerte\nTu cabeza explota\nY se transforma en un sol implosionado\nCuerpo y alma, ardiendo\nBusca la fuerza para mantener el rumbo\n\nCientos de mundos vendran\nSigue el propósito más profundo\nY abraza la luz\nDel universo que eres\n','Deep inside the black hole Falling, seek for darkness Poison and fear All the anxiety the words can do Going through your back A constant suction Touch the ground No rest even slept The lights may be off But isn\'t over yet It\'s happening, full speed Shining The truth is stronger Your head explodes And become the imploded sun Body and soul, burned Find the strength to keep the course Hundred of worlds will come Follow the heaviest purpose And embrace the light Of the universe you are',NULL,'No',1),(8,'VICIOUS CIRCLE','Arrancado de un útero inorgánico\nAtado de pies y manos\nMi vida comienza a su propia manera\nOrdenado, un círculo vicioso\n\nUna parte de mi es extraída de raíz\nLa gente alrededor hace oídos sordos\nEscupiendo veneno dentro de mí\nLo sé al final del camino\n\nAlguien espera por mí\nEs imposible dar paso al costado\nNo estoy solo\nEl sufrimiento es colectivo\n\nMis lágrimas se convierten en ácido\nMi piel comienza a supurar\nRuego por arrancármela\nEl olor a muerte es constante\n\nFinalmente veo la luz\nEl final del camino\nAlgunos estarán de pié\nAlgunos sin piel\n\nY ahí están\nVestidos de blanco y guantes\nPreparados para darme\nMi único deseo en vida\n\nDecapitación \n','Tearing off from an inorganic womb Hand feet bandaged My life starts on it\'s own way Ordered, vicious circle A part of me extracts from the root People around make deaf ear Spitting venom inside of me I know at the end of the road Somebody awaits for me It\'s impossible step aside I\'m not alone The suffering is collective My tears turn to acid My skin starts supurating I beg for tear it off The smell of death is constantly I finally see the light The end of the road Some will stand up Some skinless And there they are Dressed in white and gloves Ready for gave me The only wish alive Decapitation',NULL,'No',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (8,'2024-10-10','Flamaaaaa!!!',22,13,NULL),(9,'2024-10-10','Estaba pensando ir, vos ya fuiste a alguno de sus shows?',24,15,NULL),(10,'2024-10-10','El mio mas copado compa jsjsjs',25,13,25),(12,'2024-10-10','Tocan todas generalmente, yo les vi la otra vez en el show *Anterior nomas*. Y pude saludarlos, unos capos, menos el negro..',27,15,NULL),(13,'2024-10-10','Ese se difumino en el show cada que apagan las luces... jsjs',28,15,NULL),(18,'2024-10-10','NOOOO MUY BUENOOOOOO!!!',33,13,NULL),(19,'2024-10-10','Me quedo mortal <3',36,13,NULL),(20,'2024-10-10','F',37,16,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenidos`
--

LOCK TABLES `contenidos` WRITE;
/*!40000 ALTER TABLE `contenidos` DISABLE KEYS */;
INSERT INTO `contenidos` VALUES (1,NULL,'Historia','Inner, una banda de metal originaria de la zona norte de Buenos Aires, está generando un impacto significativo en la escena musical con su potente combinación de subgéneros que abarcan el progresivo, thrash, death y groove metal, entre otros. Actualmente, la banda se encuentra en plena promoción de su álbum debut, titulado \"Journey\". Con una enérgica presencia en las redes sociales y una sólida trayectoria de shows en vivo, Inner ha logrado captar la atención y el apoyo de una base de seguidores creciente. Durante el último año, la banda se presentó en más de 20 shows en vivo en diversos lugares de Buenos Aires y provincias de Argentina, llevando su música contundente y emocionante a audiencias entusiastas en cada presentación. Además de la promoción de \\\\\\\"Journey\\\\\\\", Inner está trabajando arduamente en la creación de su segundo álbum, que se espera lanzar a mediados de 2024. Mediante su constante actividad en la escena, la banda demuestra su compromiso de mantenerse activa y evolucionar musicalmente. El nuevo material promete superar las expectativas de los seguidores de Inner y consolidar aún más su posición en la escena del metal. Inner invita a los amantes de la música a unirse a ellos en este emocionante viaje. La banda ha logrado crear un estilo muy personal, combinando una variada mezcla de subgéneros con letras que exploran pensamientos, reflexiones y temas actuales tanto individuales como colectivos del ser humano. \\\\\\\"Journey\\\\\\\" busca ser este viaje de pensamientos y sonidos. El álbum, compuesto por 9 canciones originales, representa el fruto de años de trabajo y dedicación por parte de los miembros de Inner. Integrantes: - Agustín Casalone en el Bajo - Hernán Ramírez en la Batería - Tomás Casalone en Guitarra y Voz - David Copa en Guitarra',3,1),(4,'2022-05-21','¡ENTREVISTA DISPONIBLE EN YOUTUBE!','¡La entrevista que nos realizo #LaEstructuraDelInfierno desde México ?? ya está disponible en su canal de YouTube! Disfruta de la nota completa y conoce más sobre nuestra banda, nuestro trabajo y nuestras últimas novedades. Puedes ver la entrevista en el siguiente enlace: https://www.youtube.com/watch?v=dg-WV5jh4Gc&feature=youtu.be ¡Gracias por su continuo apoyo y por acompañarnos en este viaje musical!',2,4),(6,'2024-10-10','¡LA BANDA INNER ANUNCIA SU PRÓXIMO ÁLBUM!','La banda INNER ha confirmado el lanzamiento de su nuevo álbum titulado \'Ritmos del Futuro\', programado para el 15 de noviembre. Este álbum incluirá colaboraciones con artistas destacados y promete una mezcla única de géneros.',2,6),(7,'2024-10-11','¡GIRA MUNDIAL DE LA BANDA INNER COMIENZA EN ENERO!','Tras el éxito de su último tour, la banda Inner ha anunciado una nueva gira mundial que comenzará en enero de 2025. Los fanáticos podrán disfrutar de sus canciones en vivo en ciudades de todo el mundo, con fechas y lugares que se anunciarán próximamente.',2,7),(13,'2024-10-10','¡Fan art y creatividad de los seguidores!','¿Alguien hace dibujos, covers o algo relacionado con Inner? ¡Me encantaría ver lo que han creado! Yo hice:',1,19),(15,'2024-08-10','Próxima Gira: ¿Quién irá al concierto?','La banda acaba de anunciar su nueva gira, y estoy súper emocionado. Ya compré mis boletos para el show en *Doxeado*. ¿Alguien más va a ir? ¿Qué canciones esperan que toquen en vivo, todas?',1,23),(16,'2024-10-08','Me quede sin ideas','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',1,34),(17,'2024-09-09','El guitarrista es Nword!','He sido fan de la banda por mucho tiempo, llegue a cruzarme con todos varias veces, y últimamente me ha molestado la actitud del guitarrista. Siento que no trata bien a los fans y eso afecta la imagen del grupo. Ojalá pueda cambiar su comportamiento y volver a ser un ejemplo positivo..',1,35),(19,'2024-10-10','Virtual Meet and Greet','¡¿Quieren conocer a los artistas de la banda?!\r\nEsta es tu oportunidad de conectarte directamente con los miembros de la banda. Si tienes alguna pregunta que siempre quisiste hacerles, ¡este es el momento! Comenta en este post y los artistas responderán desde sus cuentas oficiales. Ya sea sobre su música, influencias, o sus planes a futuro, ¡no te quedes con la duda!',1,39),(20,'2024-04-08','¡MAÑANA TENEMOS UNA CITA ESPECIAL!','Estaremos haciendo una entrevista este viernes 8 de abril en el  \"El Rincon de Nuria\" donde vamos a charlar sobre todo lo que hemos estado haciendo y lo que viene. Hablaremos de nuestro álbum *Journey* (2021), el proceso detrás de él, y lo que significa para nosotros. La cita es a las 16hs ARG, en vivo por IG Live con @nuria.bn. ¡No se lo pierdan! Mientras tanto, escuchen *Imploded Sun* y prepárense para lo que viene.',2,40),(21,'2023-10-10','¡¡¡SALIMOS EN LA PORTADA!!!','¡Gran noticia! Inner ha sido destacado en la revista Rev, una de las publicaciones más influyentes de la escena musical argentina. En un apartado especial, hablamos sobre nuestro álbum Journey, un viaje sonoro que refleja nuestras experiencias y emociones a lo largo de este último tiempo.\r\nEn Journey, exploramos diversos estilos y sonidos que nos representan, y estamos emocionados de compartirlo con ustedes. No se pierdan la entrevista completa y los detalles sobre cómo este álbum ha sido una parte fundamental de nuestro crecimiento como banda.\r\n ¡Agradecemos a Rev por esta increíble oportunidad! Pueden leer el artículo completo en su sitio web o en su próxima edición impresa. ¡Gracias por el apoyo!',2,41),(22,'2024-10-10','INNER EN RIZE UP!','La banda Inner de Buenos Aires ha sido destacada por Rize UP! Prensa debido al lanzamiento de su primer álbum de larga duración, titulado \"Journey\". Este trabajo incluye nueve temas que fusionan introspección y poderosas armonías dentro de las diferentes ramas del Metal, capturando la atención de los seguidores del género con su estilo cargado de groove.\r\n\r\nEn la publicación, Rize UP! Prensa resalta la profundidad de este proyecto, que lleva al oyente en un viaje interno acompañado de riffs pesados y letras intensas. \"Journey\" ha recibido gran recepción y se espera que impulse a Inner a nuevos niveles en la escena musical metalera.\r\n\r\nEste álbum fue lanzado en agosto de 2021 y ya está disponible en plataformas como YouTube, Spotify y Apple Music, donde los fans pueden disfrutar de la propuesta sonora de Inner.',2,42),(23,'2024-10-13','Modelo','Achu, eliminar de a uno.',2,43);
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datospersonales`
--

LOCK TABLES `datospersonales` WRITE;
/*!40000 ALTER TABLE `datospersonales` DISABLE KEYS */;
INSERT INTO `datospersonales` VALUES (1,'VictoriaV','MC','2002-02-16','Mujer',1,9),(2,'Victoria Valentina','Maidana Corti','2002-02-16','Mujer',2,9),(3,'SantiN','Aranda','2004-06-14','Hombre',3,9),(4,'Santiago Nicolas','Aranda','2004-06-14','Hombre',4,9),(5,'NombreStaff1','ApellidoStaff1','1997-04-02','Otro',5,9),(6,'NombreStaff2','ApellidoStaff2','1998-08-12','Mujer',6,9),(7,'NombreStaff3','ApellidoStaff3','1999-10-12','Hombre',7,9),(8,'NombreFan1','ApellidoFan1','2000-08-30','Hombre',8,9),(9,'NombreFan2','ApellidoFan2','1999-05-24','Hombre',9,9),(10,'NombreFan3','ApellidoFan3','2008-08-12','Mujer',10,9),(11,'NombreSuper1','ApellidoSuper1','1944-02-12','Hombre',11,9),(12,'NombreSuper2','ApellidoSuper2','1964-01-30','Mujer',12,9),(13,'NombreSuper3','ApellidoSuper3','2000-09-10','Mujer',13,9),(14,'NombreSuper4','ApellidoSuper4','1990-05-10','Hombre',14,9),(15,'NombreSuper5','ApellidoSuper5','1988-11-23','Hombre',15,9),(16,'NombreArtista1','ApellidoArtista1','2005-11-19','Hombre',16,9),(17,'NombreArtista2','ApellidoArtista2','1976-02-18','Hombre',17,9),(18,'NombreArtista3','ApellidoArtista3','1985-07-25','Hombre',18,9),(19,'NombreArtista4','ApellidoArtista3','2000-03-13','Hombre',19,9);
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
  `fechaInica` date DEFAULT NULL,
  `fechaFinaliza` date DEFAULT NULL,
  `datospersonales_idDatosPersonales` int NOT NULL,
  PRIMARY KEY (`idhistorialusuario`),
  KEY `fk_historialusuario_datospersonales1_idx` (`datospersonales_idDatosPersonales`),
  CONSTRAINT `fk_historialusuario_datospersonales1` FOREIGN KEY (`datospersonales_idDatosPersonales`) REFERENCES `datospersonales` (`idDatosPersonales`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historialusuario`
--

LOCK TABLES `historialusuario` WRITE;
/*!40000 ALTER TABLE `historialusuario` DISABLE KEYS */;
INSERT INTO `historialusuario` VALUES (1,'Activo','No',NULL,NULL,1),(2,'Activo','No',NULL,NULL,2),(3,'Activo','No',NULL,NULL,3),(4,'Activo','No',NULL,NULL,4),(5,'Activo','No',NULL,NULL,5),(6,'Activo','No',NULL,NULL,6),(7,'Activo','No',NULL,NULL,7),(8,'Activo','No',NULL,NULL,8),(9,'Activo','No',NULL,NULL,9),(10,'Activo','No',NULL,NULL,10),(11,'Activo','No',NULL,NULL,11),(12,'Activo','No',NULL,NULL,12),(13,'Activo','No',NULL,NULL,13),(14,'Activo','No',NULL,NULL,14),(15,'Activo','No',NULL,NULL,15),(16,'Activo','No',NULL,NULL,16),(17,'Activo','No',NULL,NULL,17),(18,'Activo','No',NULL,NULL,18),(19,'Activo','No',NULL,NULL,19);
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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,'img/rEilSSDCWmJ5mJw9PbJTAZ8VwPrprQ7JtkyWM8Dm.jpg','2024-10-08','No'),(2,'img/Vx5Vup6j7O2634SNLCEV8YwtAew4cwHMvGOvvsET.jpg','2024-10-08','No'),(3,'img/Sn4BplVT3g99yH9Mq7klNjzXdcwulCBffEttN45T.png','2024-10-08','No'),(4,'img/qgHACDepdbtFJbY8pnaw1kM9uimch296bRvVJa6m.jpg','2024-10-08','No'),(5,'img/CncyJjlW0KzT5wb71KeRQw3lVBmtNCy9anpktB9x.jpg','2024-10-08','No'),(7,'img/uDfTfKZaOPSKb6hZGU9q8jmewxNF40ccq6ECYXxr.jpg','2024-10-08','No'),(8,'img/C9m0iYCPN7gCKTwyktnYIeVECpS0yZxDOn9PpHie.jpg','2024-10-08','No'),(9,'img/Rh2514JTtsTicyYztrvBFemsdVNb0W25GUXUGI3F.png','2024-10-09','No'),(10,'img/zst5wi5VISilUXykfX5yrhtQAJTMjdigpjp1GYDj.jpg','2024-10-10','No'),(11,'img/XLmeRxjD9Z3gB2cZUeWFlMl9UEMzsn4h4vqawww7.jpg','2024-10-10','No'),(12,'img/lsqiPF9Mol8c265gcrLER0zklXo3Oz2R2woDPigx.jpg','2024-10-10','No'),(13,'img/9QBoPNZYGrx1NgHDaoFFh01J9HpuLkCw23ILoClT.jpg','2024-10-10','No'),(14,'img/rEwuOvauIPPEwS0VhR9gOXmmT4SpNbCxNuo8R7Xm.jpg','2024-10-10','No'),(25,'img/op9ZZegaflQewhDabC0LEd0ChIRJXMchCNuCX7oc.jpg','2024-10-10','No'),(37,'img/G7TtO4hkih8R0qZPmq6xKhHZ6VMil6P6IKgllVAJ.jpg','2024-10-10','No'),(40,'img/QkUyrj4FatGTGGCVgKIe2MgFGSD2mdKBoLDLeo69.jpg','2024-10-10','No'),(41,'img/TQbPLSGY4Z05VbhGfUcijumkdmc5pmPmPd4wxQuh.jpg','2024-10-10','No'),(42,'img/kaaQBNU9QLEi6A95Bs56oRA0WhqGMa5ddbumVqwS.jpg','2024-10-10','No'),(46,'img/Xg1OQZDdfwc4DEfPceDtOqfe9TadURsftEFqSzkL.jpg','2024-10-10','No'),(47,'img/fuuOuAjFzNecibYwi1w4cZDiObf0s6dDLR1eXxce.jpg','2024-10-10','No'),(48,'img/6y5yDbzdZQCiu1qF1zJjc95tBPVXQiAuoFSJcShe.jpg','2024-10-10','No'),(49,'img/asOqDLWsirZpz7ET3xDpYqFW4mvbRu051MJftZI3.jpg','2024-10-10','No'),(53,'img/ebnkuFPUVip2acw6wJb6x7xN2gBTYATLH84GXEvM.jpg','2024-10-10','No'),(54,'img/UA65XXn3OxGZc47BkQFGUJXOgnHi1EYyhZxCQIoK.png','2024-10-10','No'),(55,'img/g2SvLJbBwAi4UhU8ms4EEfBeXL8Zbpz797a0TKat.jpg','2024-10-10','No'),(57,'img/1LiQOreUV1aNDBQZZliEcAFcXjPlQwyCAS2jKGOt.png','2024-10-10','No'),(58,'img/X1XCpWmiUCUwzbgFCRRmJlqiEOJyPcE4afPMtLy3.jpg','2024-10-12','No'),(59,'img/ng0EYA6EJy2zS5W98oqdO6fxCFl0gSmD19cXDgRZ.jpg','2024-10-12','No'),(60,'img/PFSymQuQbM14DqUerpkp7ow5FOz9OauKatReYw5s.jpg','2024-10-12','No'),(61,'img/ckoV8Fl1DZApPTnIbJyXlhHrGovJMFE3OqZMKZea.jpg','2024-10-12','No'),(62,'img/ea1fEKu4ydC7VZk0PqYyacDrIEt5S8Fxx4bEzJp2.jpg','2024-10-12','No'),(63,'img/J9HwHMYdyVOF9BsAndp8l1WwFoIoXHARbb5nQ6JA.jpg','2024-10-12','No'),(64,'img/jhh3awECWsc2rhjb1YhVpIpOm3tIS1jeiSohAWW1.jpg','2024-10-12','No'),(65,'img/YRROhImPEEjQRCHxm5AVnAq7Kv0bYSwNNM0E4xM0.jpg','2024-10-13','No'),(66,'img/sN22JBGeJi0Ylmt73QLsqez8AUolpqx9mD09ZMkZ.jpg','2024-10-13','No'),(67,'img/5UhCvWX825mdhhMYlE2BptxGzjKPDrVet04scvK9.jpg','2024-10-13','No'),(68,'img/pJYDFqibjjrNNfPcwF1ayKelLYKeXaVZoTURT8Gz.jpg','2024-10-13','No'),(69,'img/ya72FszRlVRZnVH7NwVnJo7ckUvc4BGao4XRMSpK.jpg','2024-10-13','No'),(70,'img/EUrDcYjcUlWyTH7Gd0rNxneppOgd9ChkKj70aK1d.jpg','2024-10-13','No'),(71,'img/d9lCpmBrjzY9T2iDzw43g6UuxsUvXmmS7Ava4vSv.jpg','2024-10-13','No'),(72,'img/YZ8gR6SVJPgmG3nQ5KhCdaHitKzOCLT780hPDRWs.jpg','2024-10-13','No');
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenescontenido`
--

LOCK TABLES `imagenescontenido` WRITE;
/*!40000 ALTER TABLE `imagenescontenido` DISABLE KEYS */;
INSERT INTO `imagenescontenido` VALUES (17,40,7),(18,41,6),(19,42,4),(23,46,1),(24,47,20),(25,48,21),(26,49,22),(27,58,17),(28,59,17),(29,60,17),(30,61,17),(31,62,17),(32,63,17),(33,64,16),(34,65,13),(35,66,19),(36,67,23),(37,68,23),(38,69,23),(39,70,23),(40,71,23),(41,72,23);
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interacciones`
--

LOCK TABLES `interacciones` WRITE;
/*!40000 ALTER TABLE `interacciones` DISABLE KEYS */;
INSERT INTO `interacciones` VALUES (42,1,35,0,0,1),(52,1,34,0,0,1),(53,1,33,0,0,1),(54,1,44,0,0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugarlocal`
--

LOCK TABLES `lugarlocal` WRITE;
/*!40000 ALTER TABLE `lugarlocal` DISABLE KEYS */;
INSERT INTO `lugarlocal` VALUES (1,'Teatro de la Ciudad','Formosa','Avenida 25 de Mayo',NULL),(2,'Centro Cultural Municipal','Formosa','Pringles y Rivadavia',NULL),(3,'Club Independencia','Formosa','Calle San Martín',674);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivos`
--

LOCK TABLES `motivos` WRITE;
/*!40000 ALTER TABLE `motivos` DISABLE KEYS */;
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
  `opcionNotificacion` varchar(45) DEFAULT NULL,
  `usuarios_idusuarios` int NOT NULL,
  PRIMARY KEY (`idnotificaciones`),
  KEY `fk_notificaciones_usuarios1_idx` (`usuarios_idusuarios`),
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
-- Dumping data for table `redessociales`
--

LOCK TABLES `redessociales` WRITE;
/*!40000 ALTER TABLE `redessociales` DISABLE KEYS */;
INSERT INTO `redessociales` VALUES (1,'https://open.spotify.com/intl-es/artist/0Y9jAWMZF3ve6nxKdNFiWU','Spotify'),(2,'https://www.instagram.com/inner.metal/','Instagram'),(3,'https://www.youtube.com/channel/UCqb2lqhpvCyRQTikSRgAmUw','Youtube'),(4,'https://music.apple.com/us/album/journey/1581042877','iTunes'),(5,'https://music.amazon.com/albums/B09CKF3F5W','Amazon Music'),(6,'https://www.instagram.com/_victoriavmc_/','2amuquy'),(7,'https://www.instagram.com/arandanosantiago/','4arandano');
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
  `reportes` int DEFAULT '0',
  `usuarios_idusuarios` int NOT NULL,
  `motivos_idmotivos` int DEFAULT NULL,
  PRIMARY KEY (`idreportes`),
  KEY `fk_redsocial_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_reportes_motivos1_idx` (`motivos_idmotivos`),
  CONSTRAINT `fk_redsocial_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`),
  CONSTRAINT `fk_reportes_motivos1` FOREIGN KEY (`motivos_idmotivos`) REFERENCES `motivos` (`idmotivos`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes`
--

LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
INSERT INTO `reportes` VALUES (20,5,15,NULL),(21,1,10,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisionimagenes`
--

LOCK TABLES `revisionimagenes` WRITE;
/*!40000 ALTER TABLE `revisionimagenes` DISABLE KEYS */;
INSERT INTO `revisionimagenes` VALUES (1,1,1,1),(2,2,2,1),(3,3,3,1),(4,4,4,1),(5,5,5,1),(7,6,7,1),(8,7,8,1),(9,8,9,1),(10,1,10,4),(11,1,11,4),(12,1,12,4),(13,1,13,4),(14,11,14,1),(25,13,25,5),(37,15,37,1),(40,1,40,2),(41,1,41,2),(42,1,42,2),(46,5,46,2),(47,5,47,2),(48,5,48,2),(49,5,49,2),(53,17,53,6),(54,18,54,6),(55,19,55,6),(57,16,57,6),(58,15,58,5),(59,15,59,5),(60,15,60,5),(61,15,61,5),(62,15,62,5),(63,15,63,5),(64,15,64,5),(65,6,65,5),(66,5,66,5),(67,5,67,2),(68,5,68,2),(69,5,69,2),(70,5,70,2),(71,5,71,2),(72,5,72,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `show`
--

LOCK TABLES `show` WRITE;
/*!40000 ALTER TABLE `show` DISABLE KEYS */;
INSERT INTO `show` VALUES (1,'2023-09-16 19:00:00','Inactivo',NULL,1,13,1),(2,'2023-09-29 20:00:00','Inactivo',NULL,1,12,2),(3,'2024-10-14 21:00:00','pendiente',NULL,1,11,3),(4,'2024-10-21 18:00:00','pendiente',NULL,1,10,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffextra`
--

LOCK TABLES `staffextra` WRITE;
/*!40000 ALTER TABLE `staffextra` DISABLE KEYS */;
INSERT INTO `staffextra` VALUES (1,6,2,6,NULL),(2,7,4,6,NULL),(3,NULL,5,11,NULL),(4,NULL,6,3,NULL),(5,NULL,7,10,NULL),(6,NULL,16,1,NULL),(7,NULL,17,4,NULL),(8,NULL,18,7,NULL),(9,NULL,19,14,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacionshow`
--

LOCK TABLES `ubicacionshow` WRITE;
/*!40000 ALTER TABLE `ubicacionshow` DISABLE KEYS */;
INSERT INTO `ubicacionshow` VALUES (1,'Buenos Aires','Argentina'),(2,'Catamarca','Argentina'),(3,'Chaco','Argentina'),(4,'Chubut','Argentina'),(5,'Córdoba','Argentina'),(6,'Corrientes','Argentina'),(7,'Entre Ríos','Argentina'),(8,'Formosa','Argentina'),(9,'Jujuy','Argentina'),(10,'La Pampa','Argentina'),(11,'La Rioja','Argentina'),(12,'Mendoza','Argentina'),(13,'Misiones','Argentina'),(14,'Neuquén','Argentina'),(15,'Río Negro','Argentina'),(16,'Salta','Argentina'),(17,'San Juan','Argentina'),(18,'San Luis','Argentina'),(19,'Santa Cruz','Argentina'),(20,'Santa Fe','Argentina'),(21,'Santiago del Estero','Argentina'),(22,'Tierra del Fuego','Argentina'),(23,'Tucumán','Argentina'),(24,'Ciudad Autónoma de Buenos Aires','Argentina');
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
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'victoriavmc','$2y$12$WB2VuGYA/M/gPP3YYgsK2uBg6PW3.pnegYazaVZ3IM3l17SQwAFci',NULL,'victoriavmcortitrabajos@gmail.com',1),(2,'amuquy','$2y$12$ERVNaYyUVzJpJ0C1kH5Si.9H9gReKAtTB3RAyLOiXuWWgnAo2Du5S',NULL,'victoriavmaidanacortitrabajos@hotmail.com',2),(3,'santi','$2y$12$/v3KL0NUYa9NaaLpLx09lOWmCpUKck2mr06SXSEHTo2SbxqqCn.5y',NULL,'santiago.aranda.81@gmail.com',1),(4,'arandano','$2y$12$Qr7y9VnO0duYEGQ.qY7pTOnIDV75Tj2.vI3SSpY1nBHSH3nbgYzLW',NULL,'santi.aranda@example.com',2),(5,'staffone','$2y$12$y7Pf/nwcN86.r6avPDbc5uxsiBD1c/VR/2wYHX4F6LDd5GK3ZyJzC',NULL,'staff1@example.com',2),(6,'stafftwo','$2y$12$kcqmhzRU5qqVAf/lVFPOo.OG2lpkp.OOfRGewIqfZKAAeYc8JAuFy',NULL,'staff2@example.com',2),(7,'staffthree','$2y$12$sM6bhbLaXt0JeU6ZyXPQYeVM8cGEH4WhPoKcexE/0b9/8c0uTQ9Ta',NULL,'staff3@example.com',2),(8,'fanone','$2y$12$5yBSUlq82ETXqfHtKbu3GuKKhdDDeU9Zw1kW6r9rhAB0bS77UENrW',NULL,'fan1@example.com',4),(9,'fantwo','$2y$12$.UskaHn.KogdTCSsVeJZWO3nFF/w9Af/jYHprVfQosdVMlKaaKWmq',NULL,'fan2@example.com',4),(10,'fanthree','$2y$12$E.v0O0KheWJuMi8GgGBAje8iyS.FQr083DFcz8C5L5GWzmQT0EvqS',NULL,'fan3@example.com',4),(11,'superone','$2y$12$uBBAzv/C9FdNHOHBJaUnae841.7rsAG6uOD7vnZudrqf2twwFmF7m',NULL,'superfan1@example.com',3),(12,'supertwo','$2y$12$Kgoyou1sK/6VZjGFCXuPf.binJ4MItAzi18UYs/jgTwo7wvNRGGUm',NULL,'superfan2@example.com',3),(13,'superthree','$2y$12$DTRMEovcTjIZ5iPnhv84Jezfuf9EjvRcqqseajNBTtzLwVLYlOfFS',NULL,'superfan3@example.com',3),(14,'superfour','$2y$12$WhM1/VdUBJMtpdvru2rLBOjIfz/a2klHZgX9ZgftOa.YjdWYagTQ2',NULL,'superfan4@example.com',3),(15,'superfive','$2y$12$W5RAJFWbBHPoggSlNnItnuqmkkDqIqbflMHAr6gpE7LR7go6XznTy',NULL,'superfan5@example.com',3),(16,'artistaone','$2y$12$Z1tSBdsiLXQ21fFa7Sb3JuKKi0wBS9ypPkrYmCdNJY5ZMg5m1gwBy',NULL,'artista1@example.com',2),(17,'artistatwo','$2y$12$GGK3KdRux2f1wfvnFoRiX.T9MKiUiXkV3mNDw/oF3OzgYL6gq9XU6',NULL,'artista2@example.com',2),(18,'artistathree','$2y$12$kQl4AagKtUNmSBf2Ww8CNOUFb19hiPrDJj3ye34bBAeX4F640UpR2',NULL,'artista3@example.com',2),(19,'artistafourt','$2y$12$E9tYLkJeYXFf.Z24KMzYJOsGergJkT1qbDZFOGjp3srZ1UpLQE8Ni',NULL,'artista4@example.com',2);
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
  `subidaVideo` varchar(45) DEFAULT NULL,
  `fechaSubidoVideo` varchar(45) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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

-- Dump completed on 2024-10-14 23:18:29
