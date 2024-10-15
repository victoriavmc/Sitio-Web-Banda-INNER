-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bandavacaciones
-- ------------------------------------------------------
-- Server version	8.0.39
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;
--
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `actividad` (
  `idActividad` int NOT NULL AUTO_INCREMENT,
  `contadorMg` int DEFAULT '0',
  `contadorNM` int DEFAULT '0',
  `reporte` int DEFAULT '0',
  `usuarios_idusuarios` int NOT NULL,
  PRIMARY KEY (`idActividad`),
  KEY `fk_Actividad_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_Actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 59 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */
;
INSERT INTO `actividad`
VALUES (1, 0, 0, 0, 1),
  (2, 0, 0, 0, 2),
  (3, 0, 0, 0, 2),
  (4, 0, 0, 0, 2),
  (5, 0, 0, 0, 2),
  (6, 0, 0, 0, 2),
  (7, 0, 0, 0, 2),
  (8, 0, 0, 0, 2),
  (9, 0, 0, 0, 2),
  (10, 0, 0, 0, 2),
  (11, 0, 0, 0, 2),
  (12, 0, 0, 0, 2),
  (13, 0, 0, 0, 2),
  (14, 2, 1, 0, 12),
  (15, 7, 3, 0, 11),
  (16, 4, 0, 0, 12),
  (17, 8, 5, 0, 34),
  (18, 4, 1, 0, 3),
  (19, 0, 0, 0, 34),
  (20, 0, 0, 0, 12),
  (21, 0, 0, 0, 34),
  (22, 0, 0, 0, 2),
  (23, 0, 0, 0, 45),
  (24, 0, 0, 0, 11),
  (25, 0, 0, 0, 12),
  (34, 0, 0, 0, 2);
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `albumdatos`
--

DROP TABLE IF EXISTS `albumdatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `albumdatos` (
  `idalbumDatos` int NOT NULL AUTO_INCREMENT,
  `tituloAlbum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechaSubido` date DEFAULT NULL,
  PRIMARY KEY (`idalbumDatos`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `albumdatos`
--

LOCK TABLES `albumdatos` WRITE;
/*!40000 ALTER TABLE `albumdatos` DISABLE KEYS */
;
INSERT INTO `albumdatos`
VALUES (1, 'Journey', '2021-09-04'),
  (2, 'Recital 1', '2021-09-04'),
  (4, 'Recital 2', '2021-09-15'),
  (5, 'Recital 3', '2021-10-04'),
  (6, 'Recital 4', '2023-11-24');
/*!40000 ALTER TABLE `albumdatos` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `albumimagenes`
--

DROP TABLE IF EXISTS `albumimagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `albumimagenes` (
  `albumImagenescol` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  PRIMARY KEY (`albumImagenescol`),
  KEY `fk_table1_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumImagenes_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumImagenes_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `albumimagenes`
--

LOCK TABLES `albumimagenes` WRITE;
/*!40000 ALTER TABLE `albumimagenes` DISABLE KEYS */
;
/*!40000 ALTER TABLE `albumimagenes` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `albummusical`
--

DROP TABLE IF EXISTS `albummusical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `albummusical` (
  `albumMusicalcol` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  PRIMARY KEY (`albumMusicalcol`),
  KEY `fk_albumMusical_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumMusical_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_albumMusical_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumMusical_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `albummusical`
--

LOCK TABLES `albummusical` WRITE;
/*!40000 ALTER TABLE `albummusical` DISABLE KEYS */
;
INSERT INTO `albummusical`
VALUES (1, 1, 82);
/*!40000 ALTER TABLE `albummusical` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `albumvideo`
--

DROP TABLE IF EXISTS `albumvideo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `albumvideo` (
  `idalbumVideo` int NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` int NOT NULL,
  `videos_idvideos` int NOT NULL,
  PRIMARY KEY (`idalbumVideo`),
  KEY `fk_albumVideo_albumDatos1_idx` (`albumDatos_idalbumDatos`),
  KEY `fk_albumVideo_videos1_idx` (`videos_idvideos`),
  CONSTRAINT `fk_albumVideo_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumVideo_videos1` FOREIGN KEY (`videos_idvideos`) REFERENCES `videos` (`idvideos`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `albumvideo`
--

LOCK TABLES `albumvideo` WRITE;
/*!40000 ALTER TABLE `albumvideo` DISABLE KEYS */
;
/*!40000 ALTER TABLE `albumvideo` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `artistas`
--

DROP TABLE IF EXISTS `artistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `artistas` (
  `idartistas` int NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  `staffextra_idstaffExtra` int NOT NULL,
  PRIMARY KEY (`idartistas`),
  KEY `fk_artistas_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  KEY `fk_artistas_staffextra1_idx` (`staffextra_idstaffExtra`),
  CONSTRAINT `fk_artistas_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_artistas_staffextra1` FOREIGN KEY (`staffextra_idstaffExtra`) REFERENCES `staffextra` (`idstaffExtra`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `artistas`
--

LOCK TABLES `artistas` WRITE;
/*!40000 ALTER TABLE `artistas` DISABLE KEYS */
;
INSERT INTO `artistas`
VALUES (1, 78, 3),
  (2, 79, 4),
  (3, 80, 5),
  (4, 81, 6);
/*!40000 ALTER TABLE `artistas` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `cancion`
--

DROP TABLE IF EXISTS `cancion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `cancion` (
  `idcancion` int NOT NULL AUTO_INCREMENT,
  `tituloCancion` varchar(45) DEFAULT NULL,
  `letraEspCancion` longtext,
  `letraInglesCancion` longtext,
  `archivoDsCancion` varchar(255) DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  `albumMusical_albumMusicalcol` int NOT NULL,
  PRIMARY KEY (`idcancion`),
  KEY `fk_cancion_albumMusical1_idx` (`albumMusical_albumMusicalcol`),
  CONSTRAINT `fk_cancion_albumMusical1` FOREIGN KEY (`albumMusical_albumMusicalcol`) REFERENCES `albummusical` (`albumMusicalcol`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `cancion`
--

LOCK TABLES `cancion` WRITE;
/*!40000 ALTER TABLE `cancion` DISABLE KEYS */
;
INSERT INTO `cancion`
VALUES (
    1,
    'BLACK TREES',
    'Cómo puedo explicar Algo que ya se encuentra en mis huesos? Eso que me sostiene y me mantiene en pie Es fácil quejarse y no creer en el curso natural Cuando tomas el camino Bajo la sombra De los árboles negros Pero el río sabe mejor Va a llevarte Hacia el mar Hacia lo más grandes océanos Si tú sigues tus manos El cuerpo sabe el resto No se siente el aire, ni la gravedad Sonido de maestros, en cada latido del corazón Diciéndote La sabiduría es todo',
    'How can I explain Something that\'s already in my bones That thing that holds me to keep me still It\'s easy to complain and don\'t believe in the natural course When you take the path Under the shade Of the black trees But the river knows better It\'s going to take you To the sea To the greatest oceans If you follow your hands The body knows the rest Don\'t feel the air, the gravitation Sounds of masters in every heartbeat Telling you Wisdom is everything',
    NULL,
    'No',
    1
  ),
  (
    2,
    'DYING',
    'Ella fue hecha para nosotros, y nosotros para ella Amor mutuo, pero se perdió en alguna parte Nos dió tanto que sin fuerzas se quedó Amor tóxico, muriéndo lentamente Devastado, profundamente desde adentro Quemándo todas las hojas en las llamas de infierno Ambición Sin empatía Incubado por un largo tiempo Esa cosa que no sabes que es Es un regalo o una enfermedad mortal Tus propios hijos devoramos tu carne Último aliento, porque nos desvaneceremos Ahora que el Sol toca el océano Sólo se verá ennegrecido Oculto como nuestras almas Suicidio masivo Inocente y constante Todos corremos un paso hacia el olvido',
    'She was made for us and us for her Mutual love, but got lost somewhere She gave us so much and without strength she stayed Toxic love, dying slowly Devastated, deeply from inside Burning all leafs in flames of hell Ambition Without empathy Incubate for a long time This thing that you don\'t know what it is It\'s a gift or mortal sickness Your own sons we devorate your flesh Last breathe \'cause we\'ll fade away Now that the sun touchs the ocean Only it will be seen blackened Hidden like our souls Massive suicide Innocent and constantly We all rush one step to oblivion',
    NULL,
    'No',
    1
  ),
  (
    3,
    'EVOLUTION',
    'Apuñalando su propio útero\nOlvidando de dónde venimos\nLa avaricia domina el alma\n\nComenzando desde el interior de la herída\nAbierto sin final\n\nProceso innatural\nEl final se acerca\nEl cambio se hace notar\nNo hay vuelta atrás\n\nProceso innatural\nEl final se acerca\nEs inútil cerrar los ojos\nNo hay vuelta atrás\n\nComenzando desde el interior del útero\nAbierto sin final\n\nApuñalando su propio infierno\nNo podrás escuchar el llanto\nLa avaricia domina el alma\n\nComenzando desde el interior del útero\nAbierto sin final\n',
    'Stabbing It\'s own womb Forgetting where we become The greed dominates the soul Starting from Inside the wound Open without end Unnatural process The end is closer The change make notice There\'s no turning back Unnatural process The end is closer Useless to close your eyes There is no turning back Starting from The inside the womb Open without end Stabbing It\'s own hell You won\'t hear the crying The greed dominates the soul Starting from Inside the wound Open without end',
    NULL,
    'No',
    1
  ),
  (
    4,
    'FOCUS',
    'Sé que la esperanza se está alejando\nNo podemos dejar que se vaya de aquí\nNuestro futuro está bajo nuestros pies\nCon cada paso que damos\n\nEsta tierra no es nuestra para reclamar\nCrecimos entre las mentiras del hombre\nComiendo árboles y cada vida\nDeberíamos querer nuestros propios sueños\n\nNo lo sabes todavía\nPero si tratas y te concentras\nTus ojos podrían ver más allá de nosotros\nY no lo que ellos quieren que veamos\n\nPuedes escuchar el grito?\nPuedes escuchar la plegaria?\nNo está pidiendo un final\nSolo quiere la vida que se merece\n',
    'I know the hope is getting away We can\'t let it go from here Our future is under our feets With every step we take This land is not for us to claim We grown among the lies of men Eating trees and every life We should want our own dreams You don\'t know it yet But if you try hard and focus Your eyes could see more than us And not what they want us to see Can you hear the shout? Can you hear the pray? It\'s not calling for an end It just wants the life that deserves',
    NULL,
    'No',
    1
  ),
  (
    5,
    'FORGOTTEN',
    'Escondida en el núcleo\nYace una fuerza\nLista para consumir todo en su camino\n\nDentro, cuando algo está mal\nCuando alguien es lastimado\nPuede sacudir, escupir fuego y sangre\nLleno de ira, descepcionada\n\nEstá cansada de esperar, justicia masiva\nEstamos siendo cazados, y es demasiado tarde\n\nPor las buenas o por las malas\nTodo lo que hicimos, y los olvidamos\nToda la vida que ya no está\nTendrá un costo\n\nMiles en la tierra y simplemente no nos importa\nPero la verdad es que deberíamos haber sido nosotros\nEs el camino que el humano tomó\nQue lleva a la autodestrucción\n\nVenimos del polvo\nY polvo es lo único que hicimos\n',
    'Hiding in the core Lies a force Ready to consume everything on it\'s way Inside, when something\'s wrong When someone gets hurt It can shake, spit fire and blood Full of anger, disappointed It\'s tired of waiting, massive justice We are hunted, and it\'s too late Through the good or the hard way All we did, and we forget them All the life that now it\'s gone Will have a cost Thousands on Earth and we just don\'t care But the truth is it should have been us Is the path the human took That leads to self-destruction We came from dust And dust is all we did',
    NULL,
    'No',
    1
  ),
  (
    6,
    'HILL OF THE SEVEN COLORS',
    'Peleé tan duro por esto y ahora\nNo se hacia dónde correr\nTomo impulso, muerdo las cadenas\nMi viaje en busca de tranquilidad comienza\nMi alma, mi sombra, necesitan descansar\n\nCerro de los Siete Colores\nLa piedra verde golpea mi frente\nMis ojos dejan de ver\nEl cóndor Andino me guía\nEsquivando árboles secos\nToco el agua pero no me inunda\nPuedo creér\n\nNo hay montaña que no pueda escalar\nEntrenando mi mente\nCapaz de todo\nEl calor seco quema mi piel, estoy listo\nEntierro mis piés, siendo parte de aquí\n\nCerro de los Siete Colores\nLas hojas cubren mi cuerpo\nHe renacido, he renacido\n',
    'How can I explain Something that\'s already in my bones That thing that holds me to keep me still It\'s easy to complain and don\'t believe in the natural course When you take the path Under the shade Of the black trees But the river knows better It\'s going to take you To the sea To the greatest oceans If you follow your hands The body knows the rest Don\'t feel the air, the gravitation Sounds of masters in every heartbeat Telling you Wisdom is everything',
    NULL,
    'No',
    1
  ),
  (
    7,
    'IMPLODED SUN',
    'Profundo dentro del agujero negro\nCayendo, en busca de la oscuridad\nVeneno y miedo\nToda la ansiedad que las palabras pueden dar\nRecorriendo a través de tu cuerpo\nUna succión constante\nToca fondo\n\nSin descanso, siquiera dormido\nLas luces podrían apagarse\nPero aún no es el final\nEstá sucediendo, a toda velocidad\nBrillando\n\nLa verdad es más fuerte\nTu cabeza explota\nY se transforma en un sol implosionado\nCuerpo y alma, ardiendo\nBusca la fuerza para mantener el rumbo\n\nCientos de mundos vendran\nSigue el propósito más profundo\nY abraza la luz\nDel universo que eres\n',
    'Deep inside the black hole Falling, seek for darkness Poison and fear All the anxiety the words can do Going through your back A constant suction Touch the ground No rest even slept The lights may be off But isn\'t over yet It\'s happening, full speed Shining The truth is stronger Your head explodes And become the imploded sun Body and soul, burned Find the strength to keep the course Hundred of worlds will come Follow the heaviest purpose And embrace the light Of the universe you are',
    NULL,
    'No',
    1
  ),
  (
    8,
    'VICIOUS CIRCLE',
    'Arrancado de un útero inorgánico\nAtado de pies y manos\nMi vida comienza a su propia manera\nOrdenado, un círculo vicioso\n\nUna parte de mi es extraída de raíz\nLa gente alrededor hace oídos sordos\nEscupiendo veneno dentro de mí\nLo sé al final del camino\n\nAlguien espera por mí\nEs imposible dar paso al costado\nNo estoy solo\nEl sufrimiento es colectivo\n\nMis lágrimas se convierten en ácido\nMi piel comienza a supurar\nRuego por arrancármela\nEl olor a muerte es constante\n\nFinalmente veo la luz\nEl final del camino\nAlgunos estarán de pié\nAlgunos sin piel\n\nY ahí están\nVestidos de blanco y guantes\nPreparados para darme\nMi único deseo en vida\n\nDecapitación \n',
    'Tearing off from an inorganic womb Hand feet bandaged My life starts on it\'s own way Ordered, vicious circle A part of me extracts from the root People around make deaf ear Spitting venom inside of me I know at the end of the road Somebody awaits for me It\'s impossible step aside I\'m not alone The suffering is collective My tears turn to acid My skin starts supurating I beg for tear it off The smell of death is constantly I finally see the light The end of the road Some will stand up Some skinless And there they are Dressed in white and gloves Ready for gave me The only wish alive Decapitation',
    NULL,
    'No',
    1
  );
/*!40000 ALTER TABLE `cancion` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `comentarios` (
  `idcomentarios` int NOT NULL AUTO_INCREMENT,
  `fechaComent` date DEFAULT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
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
) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */
;
INSERT INTO `comentarios`
VALUES (
    1,
    '2024-09-10',
    'A mí me cuesta elegir, pero el solo en \\\"Imploded Sun\\\" es una locura.',
    19,
    14,
    NULL
  ),
  (
    4,
    '2024-09-10',
    'Los vi hace un año y ahora siento que suenan aún más sólidos',
    20,
    15,
    NULL
  ),
  (
    5,
    '2024-09-11',
    'Fui al último en Buenos Aires y ese solo de Herni fue brutal...',
    21,
    15,
    NULL
  ),
  (
    6,
    '2024-09-12',
    'Flaamaaaaaaa que buena imagennnn',
    22,
    16,
    NULL
  ),
  (
    7,
    '2024-09-13',
    'Mortal ese Collage, yo quisiera hacer un dibujo pero me queda dibujado como palitos... jaja',
    23,
    16,
    NULL
  ),
  (
    8,
    '2024-09-18',
    'Sirius tatto simpre me tatuo ahi, y me cruce con Tomi, es re buena ondaaaaa!!!',
    24,
    18,
    NULL
  ),
  (
    9,
    '2024-09-20',
    'Hermosos tatuajeeeeeeesssss, quiero hacerme uno!!!!',
    25,
    18,
    NULL
  );
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `contenidos`
--

DROP TABLE IF EXISTS `contenidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `contenidos` (
  `idcontenidos` int NOT NULL AUTO_INCREMENT,
  `fechaSubida` date DEFAULT NULL,
  `titulo` longtext COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `tipoContenido_idtipoContenido` int NOT NULL,
  `Actividad_idActividad` int NOT NULL,
  PRIMARY KEY (`idcontenidos`),
  KEY `fk_contenidos_tipoContenido1_idx` (`tipoContenido_idtipoContenido`),
  KEY `fk_contenidos_Actividad1_idx` (`Actividad_idActividad`),
  CONSTRAINT `fk_contenidos_Actividad1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`),
  CONSTRAINT `fk_contenidos_tipoContenido1` FOREIGN KEY (`tipoContenido_idtipoContenido`) REFERENCES `tipocontenido` (`idtipoContenido`)
) ENGINE = InnoDB AUTO_INCREMENT = 51 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `contenidos`
--

LOCK TABLES `contenidos` WRITE;
/*!40000 ALTER TABLE `contenidos` DISABLE KEYS */
;
INSERT INTO `contenidos`
VALUES (
    1,
    '2024-09-11',
    'Historia',
    'Inner, una banda de metal originaria de la zona norte de Buenos Aires, está generando un impacto significativo en la escena musical con su potente combinación de subgéneros que abarcan el progresivo, thrash, death y groove metal, entre otros. Actualmente, la banda se encuentra en plena promoción de su álbum debut, titulado \\\"Journey\\\". Con una enérgica presencia en las redes sociales y una sólida trayectoria de shows en vivo, Inner ha logrado captar la atención y el apoyo de una base de seguidores creciente. Durante el último año, la banda se presentó en más de 20 shows en vivo en diversos lugares de Buenos Aires y provincias de Argentina, llevando su música contundente y emocionante a audiencias entusiastas en cada presentación. Además de la promoción de \\\"Journey\\\", Inner está trabajando arduamente en la creación de su segundo álbum, que se espera lanzar a mediados de 2024. Mediante su constante actividad en la escena, la banda demuestra su compromiso de mantenerse activa y evolucionar musicalmente. El nuevo material promete superar las expectativas de los seguidores de Inner y consolidar aún más su posición en la escena del metal. Inner invita a los amantes de la música a unirse a ellos en este emocionante viaje. La banda ha logrado crear un estilo muy personal, combinando una variada mezcla de subgéneros con letras que exploran pensamientos, reflexiones y temas actuales tanto individuales como colectivos del ser humano. \\\"Journey\\\" busca ser este viaje de pensamientos y sonidos. El álbum, compuesto por 9 canciones originales, representa el fruto de años de trabajo y dedicación por parte de los miembros de Inner. Integrantes: - Agustín Casalone en el Bajo - Hernán Ramírez en la Batería - Tomás Casalone en Guitarra y Voz - David Copa en Guitarra',
    3,
    1
  ),
  (
    2,
    '2022-02-20',
    '¡MAÑANA TENEMOS UNA CITA ESPECIAL!',
    'Estaremos haciendo una entrevista de fin de semana donde vamos a charlar sobre todo lo que hemos estado haciendo y lo que viene. Hablaremos de nuestro álbum *Journey* (2021), el proceso detrás de él, y lo que significa para nosotros. La cita es a las 16hs ARG, en vivo por IG Live con @metal.infection. ¡No se lo pierdan! Mientras tanto, escuchen *Imploded Sun* y prepárense para lo que viene. ',
    2,
    2
  ),
  (
    3,
    '2022-03-16',
    'RESEÑA DE @AMONG.THE.REVIEWS',
    'Nos llena de orgullo compartir la reseña de nuestro álbum *Journey* (2021) hecha por @among.the.reviews, un reconocido crítico especializado en reseñar álbumes. Aquí, nos deja su opinión detallada sobre lo que fue para él nuestro primer trabajo de estudio. Introducción: Inner es una banda bastante reciente, formada en 2018, y que tan solo 3 años después sacan su primer disco titulado *The Journey*, un álbum que a simple vista no parece súper complejo, pero la realidad es que trae muchas sorpresas y cosas interesantes. Agradezco a David Copa por pasarme el material y la información de la banda, muy amable y amistoso. El álbum en cuestión: Comienza el álbum con \\\"Imploded Sun\\\", un tema que define el sonido de la banda, con guitarras machaconas, bajo distorsionado y polirritmos. Desde los detalles en el minuto 0:53 hasta el breakdown final, el tema ofrece una experiencia intensa y dinámica. La voz rasposa y brutal de Tomás Casalone aporta la fuerza necesaria. Le sigue \\\"Vicious Circles\\\", con tintes progresivos y cambios de ritmo marcados por los redobles de batería. El riff machacón y las disonancias lo convierten en uno de los temas más destacables del álbum. Luego llega \\\"Forgotten\\\", la canción más larga del disco, que ofrece una atmósfera más melancólica y oscura, acompañada de riffs llenos de fuerza. En \\\"Focus\\\", la banda mezcla secciones más calmadas con potentes blast beats, manteniendo una energía implacable. Finalmente, \\\"Hill of the Seven Colors\\\" cierra el álbum con un breakdown memorable, haciendo un cierre perfecto. Letras: Las letras de este álbum abarcan varios temas como la evolución humana, la superación personal, y luchas internas, representadas en temas como \\\"Evolution\\\", \\\"Forgotten\\\" y \\\"The Hill of the Seven Colors\\\". Portada: La portada del álbum representa visualmente el viaje introspectivo que plantea el concepto de *Journey*, con fragmentos de la naturaleza que emergen de la cabeza de una persona, lo que refleja el proceso de superación personal. Concluyendo: Este álbum es muy completo tanto musical como conceptualmente. La banda pensó cada detalle de este trabajo, que sobresale incluso siendo realizado de manera independiente. Mi único comentario negativo sería que la producción podría tener más fuerza para acompañar las composiciones, pero eso no le resta mérito a este gran trabajo. Pueden leer la reseña completa en el siguiente https://www.instagram.com/p/CaswuA3uik2/?img_index=5',
    2,
    3
  ),
  (
    4,
    '2022-03-16',
    '¡INNER HA SIDO DESTACADA EN LA PÁGINA DE RIZE UP!',
    'Nos emociona compartir con ustedes que INNER ha sido destacada en la plataforma RizeUp!. Nuestra banda, que nació en Buenos Aires, Argentina, y ha recorrido un intenso camino desde su formación en 2018, sigue llevando su música más allá de las fronteras. En esta ocasión, ¡la página RizeUp! publicó una reseña de nuestro primer álbum de larga duración, \\\"Journey\\\", lanzado en 2021 de manera independiente. El artículo resalta la evolución musical que hemos tenido desde nuestros inicios como banda, y los shows realizados en Vade (Morón) y Primer Piso (CABA) durante 2022. \\\"Journey\\\" es una obra introspectiva, con nueve poderosos temas que exploran la crudeza y complejidad humana a través de potentes riffs y armonizaciones características del metal, mientras nuestras letras viajan por lo más profundo del ser. Canciones como \\\"Imploded Sun\\\", \\\"Focus\\\" y \\\"Hill of the Seven Colors\\\" han sido muy bien recibidas tanto por los fans como por los críticos. ¡Agradecemos a Rize Up! por destacar nuestro trabajo y ayudarnos a compartir nuestra música con un público más amplio. ¡Pueden leer la reseña completa en el sitio de RizeUp!  https://www.delta80.com.ar/inner-presenta-su-disco-debut/ o seguir los detalles de nuestra mención en su Instagram. https://www.instagram.com/stories/highlights/17922016733248413/',
    2,
    4
  ),
  (
    5,
    '2022-03-21',
    'INNER DESTACA SU DEBUT EN KULTURA_ROCK!',
    '¡Estamos emocionados de compartir que INNER ha sido destacada en la página de Kultura_Rock! En este artículo, se celebra nuestro debut con el álbum Journey, y se resalta el impacto de nuestra música en el mundo del metal. INNER, originaria de la provincia de Buenos Aires, Argentina, está formada actualmente por Tomás Casalone (voz/guitarra), Agustín Casalone (bajo), David Copa (guitarra) y Hernán Ramírez (batería). La banda comenzó como Revealed, un proyecto inicial de los hermanos Casalone. En 2017, lanzaron un EP de tres canciones que recibió una gran acogida, lo que les permitió evolucionar musicalmente y sumar a Hernán Ramírez como batería definitivo. En 2018, el grupo adoptó el nombre de INNER. En agosto de 2021, lanzamos nuestro primer álbum de larga duración, Journey. Este trabajo presenta nueve temas que combinan riffs pesados y potentes, explorando estilos como el metal extremo y el death metal, con voces duras y aceleradas que se integran perfectamente en este estilo musical. Agradecemos a Kultura_Rock por destacar nuestro trabajo y ayudarnos a llegar a más oyentes. Puedes leer el artículo completo y disfrutar de nuestro álbum Journey en el siguiente enlace: https://www.instagram.com/p/CbXfVJvIhQw/ ¡Gracias por su apoyo continuo y por acompañarnos en este viaje!',
    2,
    5
  ),
  (
    6,
    '2022-03-21',
    '¡INNER EN SKORPIOMETAL!',
    '¡Nos complace anunciar que INNER ha sido presentado en Skorpiometal! En una reciente publicación, Skorpiometal destaca nuestro viaje musical y el impacto de nuestro álbum Journey. INNER, originaria de la provincia de Buenos Aires, Argentina, está formada por Tomás Casalone (voz/guitarra), Agustín Casalone (bajo), David Copa (guitarra) y Hernán Ramírez (batería). Comenzamos como Revealed, un proyecto de los hermanos Casalone, y tras un exitoso EP en 2017, evolucionamos musicalmente y adoptamos el nombre INNER en 2018. En agosto de 2021, lanzamos nuestro primer álbum de larga duración, Journey. Este trabajo de nueve canciones nos lleva a una travesía interna, con riffs pesados y armonizaciones que exploran diferentes facetas del metal, complementadas con voces con mucho groove. Agradecemos a Skorpiometal por la cobertura y el apoyo. Puedes leer el artículo completo en el siguiente enlace: https://skorpiometal.blogspot.com/2022/03/te-presentamos-inner-argentina.html?m=1 ¡Gracias por seguirnos y apoyarnos en esta aventura musical!',
    2,
    6
  ),
  (
    7,
    '2022-03-30',
    '¡CONTINÚA LA DIFUSIÓN DE \\\"JOURNEY\\\" EN SOUNDS OF THE SOUTH!',
    '¡Estamos emocionados de anunciar que INNER ha sido destacada en Sounds of the South! En esta publicación, Claudia Poyo nos presenta y resalta el impacto de nuestro primer álbum completo, Journey. Publicado en agosto de 2021, Journey es nuestro primer disco de larga duración y está disponible en Amazon Music, iTunes, Spotify y YouTube. Con una duración de 38 minutos, el álbum cuenta con nueve canciones que nos llevan a una travesía interna llena de introspección y crudeza. Combinamos riffs y armonizaciones que exploran diferentes facetas del metal, junto con voces llenas de groove. Todo el material musical y las letras fueron creados por INNER, mientras que la grabación, mezcla y mastering fueron realizados por Juan Soria en In Waves Studio. El arte de tapa fue diseñado por Marianela Casalone. Agradecemos a Sounds of the South por su apoyo en la difusión de nuestro trabajo. Puedes leer el artículo completo en el siguiente enlace: https://soundsofthesouth01.blogspot.com/2022/03/inner-continua-la-difusion-de-su-primer.html?m=1 ¡Gracias por seguirnos y por todo el apoyo continuo!',
    2,
    7
  ),
  (
    8,
    '2022-04-04',
    '¡INNER EN REV!',
    '¡Nos complace anunciar que INNER ha sido destacada en el último número de REV, la revista digital de Canción Argentina! Esta publicación mensual gratuita ofrece noticias, notas, novedades y lanzamientos del mundo musical argentino. En esta edición, se resalta nuestro trabajo y presencia en la escena del metal argentino, incluyendo detalles sobre nuestro álbum Journey y nuestras próximas actividades. Puedes encontrar el número completo de REV en https://www.instagram.com/p/Cb8-4PYsqQq/ Agradecemos a REV y a Canción Argentina por el apoyo y la visibilidad. ¡No te pierdas esta publicación llena de noticias y novedades del mundo musical argentino!',
    2,
    8
  ),
  (
    9,
    '2022-04-06',
    'HOY ENTREVISTA EN \\\"QUE SE PUDRA\\',
    '¡No te pierdas la entrevista que nos harán con Damián Piriz para el programa \\\"Que Se Pudra\\\"! Sintoniza hoy a las 21hs en vivo a través de quesepudra.radio12345.com para escuchar todo sobre nuestra música, el proceso de creación de Journey y mucho más. ¡Te esperamos para compartir esta emocionante charla!\',72),(35,\'2022-04-05\',\'¡INNER EN METALPEDIA MX!\',\'¡Estamos emocionados de anunciar que INNER ha sido destacado en Metalpedia MX! En esta publicación, se resalta nuestro álbum más reciente, Journey, lanzado en 2021. Accede desde https://www.instagram.com/p/Cb-9He1Bxzb/ ¡Gracias a Metalpedia MX por el apoyo y a nuestros fans por su continuo respaldo! STAY METAL!!! STAY SAFE!!! @inner.metal @prensarizeup',
    2,
    9
  ),
  (
    10,
    '2022-04-19',
    '¡INNER EN CULTURA INFERNAL TV!',
    '¡Estamos emocionados de compartir que INNER ha sido destacado en Cultura Infernal TV! En esta publicación, se presenta a nuestra banda en el inicio de los audiogramas. INNER es una banda de Metal originaria de la provincia de Buenos Aires, Argentina, actualmente integrada por Tomás Casalone (voz/guitarra), Agustín Casalone (bajo), David Copa (guitarra) y Hernán Ramírez (batería). Comenzamos como Revealed, un proyecto formado por los hermanos Casalone, y tras el éxito de nuestro EP de 2017, evolucionamos musicalmente y adoptamos el nombre INNER en 2018. En agosto de 2021, lanzamos nuestro primer álbum de larga duración, Journey. También realizamos dos shows importantes en Vade (Morón) y Primer Piso (CABA) a lo largo de 2022. Agradecemos a Cultura Infernal TV por el apoyo y por destacar nuestro trabajo en sus audiogramas. Puedes ver la publicación completa https://www.instagram.com/p/CciE6WrLIfm/',
    2,
    10
  ),
  (
    11,
    '2022-04-19',
    '¡ENTREVISTA EN VIVO CON ESTANDARTES_METALICOS!',
    '¡Nos complace anunciar que INNER estuvimos en una entrevista en vivo a través de Instagram Live! Este miércoles 20 de abril, tuvimos una charla increíble sobre cómo estamos trabajando, nuestros proyectos y nuestro reciente álbum Journey. ¡Gracias a todos por su apoyo y por acompañarnos en esta conversación! Estandartes Metálicos | En un par de minutos estaremos compartiendo una agradable entrevista con la banda @inner.metal de la provincia de Buenos Aires.… | Instagram',
    2,
    11
  ),
  (
    12,
    '2022-05-21',
    '¡ENTREVISTA DISPONIBLE EN YOUTUBE!',
    '¡La entrevista que nos realizo #LaEstructuraDelInfierno desde México ?? ya está disponible en su canal de YouTube! Disfruta de la nota completa y conoce más sobre nuestra banda, nuestro trabajo y nuestras últimas novedades. Puedes ver la entrevista en el siguiente enlace: https://www.youtube.com/watch?v=dg-WV5jh4Gc&feature=youtu.be ¡Gracias por su continuo apoyo y por acompañarnos en este viaje musical!',
    2,
    12
  ),
  (
    13,
    '2022-05-26',
    '¡INNER DESTACANDO EN UN NUEVO ARTÍCULO!',
    '¡Estamos emocionados de compartir que INNER ha sido destacado en un reciente artículo sobre nuestro primer álbum, Journey! El artículo explora a fondo nuestro disco Journey, lanzado en agosto de 2021, y cómo ha sido recibido por los fans y la crítica. También se menciona nuestra evolución desde el proyecto Revealed hasta convertirnos en INNER, y nuestros próximos pasos, incluyendo shows y nuevos proyectos. Puedes leer el artículo completo aquí: https://metal2012.blogspot.com/2022/05/inner-y-su-primer-disco-journey-un.html?m=1 ¡Gracias por su continuo apoyo y por seguirnos en esta travesía musical!',
    2,
    13
  ),
  (
    14,
    '2024-09-10',
    '¿Cuál es tu canción favorita de Journey y por qué?',
    '¡Vamos, gente! ¿Cuál les voló la cabeza de su álbum debut? ¿Alguna que no puedan dejar de escuchar? A mi me gusto \\\"Forgotten\\\" por como es la musica y luego como entra Tomi... uffff flama',
    1,
    14
  ),
  (
    15,
    '2024-09-10',
    '¿Alguien más estuvo en el último show?',
    '¡Tremendo! ¿Qué les pareció? ¿Cuál fue su momento favorito? Yo todavía sigo con la adrenalina.',
    1,
    15
  ),
  (
    16,
    '2024-09-12',
    '¡Fan art y creatividad de los seguidores!',
    '¿Alguien más hace dibujos, covers o algo relacionado con Inner? ¡Me encantaría ver lo que han creado! Yo hice:',
    1,
    16
  ),
  (
    17,
    '2024-09-14',
    'Si pudieras preguntarles algo a los chicos de la banda, ¿qué sería?',
    'Las letras son muy profundas y cargadas de emoción. ¿En qué se inspiran para escribirlas? ¿Se basan en experiencias o situaciones más universales?',
    1,
    17
  ),
  (
    18,
    '2024-09-16',
    'Vieron los Tatuajes??!!!',
    'Que cantidad de tatuajes que tienen los chicos, fuaaaaa mortal, tienen re buenos diseños y recomiendan mucho de Sirius Tatto!!! ',
    1,
    18
  ),
  (
    27,
    '2024-09-27',
    'El guitarrista es Nword!',
    'He sido fan de la banda por mucho tiempo, pero últimamente me ha molestado la actitud del guitarrista. Siento que no trata bien a los fans y eso afecta la imagen del grupo. Ojalá pueda cambiar su comportamiento y volver a ser un ejemplo positivo.',
    1,
    34
  );
/*!40000 ALTER TABLE `contenidos` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `datospersonales`
--

DROP TABLE IF EXISTS `datospersonales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
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
) ENGINE = InnoDB AUTO_INCREMENT = 50 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `datospersonales`
--

LOCK TABLES `datospersonales` WRITE;
/*!40000 ALTER TABLE `datospersonales` DISABLE KEYS */
;
INSERT INTO `datospersonales`
VALUES (
    3,
    'Santiago',
    'Arandano',
    '2004-06-14',
    'Masculino',
    1,
    9
  ),
  (
    4,
    'VictoriaV',
    'MaidanaC',
    '2002-02-16',
    'Femenino',
    2,
    9
  ),
  (
    5,
    'KevinA',
    'Schneider',
    '1997-04-02',
    'Masculino',
    3,
    9
  ),
  (
    6,
    'Carlos',
    'Gómez',
    '1990-05-10',
    'Masculino',
    4,
    9
  ),
  (
    7,
    'Lucía',
    'Pérez',
    '1988-11-23',
    'Femenino',
    5,
    9
  ),
  (
    8,
    'Andrés',
    'Fernández',
    '1995-07-14',
    'Masculino',
    6,
    9
  ),
  (
    9,
    'María',
    'Rodríguez',
    '1993-03-30',
    'Femenino',
    9,
    9
  ),
  (
    10,
    'Javier',
    'López',
    '1992-09-18',
    'Masculino',
    10,
    9
  ),
  (
    11,
    'Juana',
    'Martinez',
    '1999-03-30',
    'Femenino',
    11,
    9
  ),
  (
    12,
    'Camila',
    'Paz',
    '2000-09-18',
    'Femenino',
    12,
    9
  ),
  (
    34,
    'Fan Sin Sub',
    'Fan Basico',
    '2012-04-05',
    'Masculino',
    33,
    9
  ),
  (
    35,
    'Fan Con Sub',
    'SuperFan',
    '1990-04-08',
    'Femenino',
    34,
    9
  ),
  (
    36,
    'Fan Prueba',
    'vemos',
    '1990-09-08',
    'Otro',
    35,
    9
  ),
  (
    46,
    'David',
    'Copa',
    '1990-10-09',
    'Masculino',
    45,
    9
  ),
  (
    47,
    'Tomas',
    'Casalone',
    '1996-02-29',
    'Masculino',
    46,
    9
  ),
  (
    48,
    'Agustin',
    'Casalone',
    '2002-01-12',
    'Masculino',
    47,
    9
  ),
  (
    49,
    'Hernan',
    'Ramirez',
    '1995-03-27',
    'Masculino',
    48,
    9
  );
/*!40000 ALTER TABLE `datospersonales` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `historialusuario`
--

DROP TABLE IF EXISTS `historialusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `historialusuario` (
  `idhistorialusuario` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Activo',
  `eliminacionLogica` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  `fechaInica` date DEFAULT NULL,
  `fechaFinaliza` date DEFAULT NULL,
  `datospersonales_idDatosPersonales` int NOT NULL,
  PRIMARY KEY (`idhistorialusuario`),
  KEY `fk_historialusuario_datospersonales1_idx` (`datospersonales_idDatosPersonales`),
  CONSTRAINT `fk_historialusuario_datospersonales1` FOREIGN KEY (`datospersonales_idDatosPersonales`) REFERENCES `datospersonales` (`idDatosPersonales`)
) ENGINE = InnoDB AUTO_INCREMENT = 75 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `historialusuario`
--

LOCK TABLES `historialusuario` WRITE;
/*!40000 ALTER TABLE `historialusuario` DISABLE KEYS */
;
INSERT INTO `historialusuario`
VALUES (62, 'Activo', 'No', NULL, NULL, 3),
  (63, 'Activo', 'No', NULL, NULL, 4),
  (64, 'Activo', 'No', NULL, NULL, 5),
  (65, 'Activo', 'No', NULL, NULL, 6),
  (66, 'Activo', 'No', NULL, NULL, 7),
  (67, 'Activo', 'No', NULL, NULL, 8),
  (68, 'Activo', 'No', NULL, NULL, 9),
  (69, 'Activo', 'No', NULL, NULL, 10),
  (70, 'Activo', 'No', NULL, NULL, 11),
  (71, 'Activo', 'No', NULL, NULL, 12),
  (72, 'Activo', 'No', NULL, NULL, 34),
  (73, 'Activo', 'No', NULL, NULL, 35),
  (74, 'Activo', 'No', NULL, NULL, 36);
/*!40000 ALTER TABLE `historialusuario` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `imagenes` (
  `idimagenes` int NOT NULL AUTO_INCREMENT,
  `subidaImg` varchar(255) DEFAULT NULL,
  `fechaSubidaImg` date DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  PRIMARY KEY (`idimagenes`)
) ENGINE = InnoDB AUTO_INCREMENT = 230 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */
;
INSERT INTO `imagenes`
VALUES (
    57,
    'public/img/8OoGY3EZhOTi64S0yjW4mQcuojRnlQYpOxRzZPsM.jpg',
    '2024-09-06',
    'No'
  ),
  (
    68,
    'public/img/ApxORMh4KuAbxPeTJQo0wdbHWuR2LmTX2c69egIq.jpg',
    '2024-09-07',
    'No'
  ),
  (
    72,
    'public/img/XCuROAP4IbLZsBpQdaCy7plLTnb8YuCDDUQBq0uX.jpg',
    '2024-09-07',
    'No'
  ),
  (
    73,
    'public/img/YReLeukDzS6rsd9q0c51hESmsLVDmNO63onSxpdl.jpg',
    '2024-09-07',
    'No'
  ),
  (
    74,
    'public/img/aWSqDUk0gQ3SMRWlnmAlhOAwgZsqWKColHBDKAmv.jpg',
    '2024-09-07',
    'No'
  ),
  (
    75,
    'public/img/NU4TzS2TnCfXi5kjRdo7sXfTc5truyq7IfzC8UJH.jpg',
    '2024-09-07',
    'No'
  ),
  (
    77,
    'public/img/bYtJBQGdKczsgq3SE8nuGqfdAgVUXzpkthIaaUps.png',
    '2024-09-07',
    'No'
  ),
  (
    78,
    'public/img/DVEFJP7RALkK0a6TiwSCRpyjZ3BZQ6D5DfJtEaJC.png',
    '2024-09-12',
    'No'
  ),
  (
    79,
    'public/img/H3GPWXzFkicxjerzDcMUrwZuCRGVQKpA78drQx4s.png',
    '2024-09-12',
    'No'
  ),
  (
    80,
    'public/img/OJQ1nwIwNaIawKvxr1b50XblAKKYXoB8Uvn54PoN.png',
    '2024-09-12',
    'No'
  ),
  (
    81,
    'public/img/g1CJmeigHox9jYZ5BzO7PAFrlnSU7Q43I8v1JR2F.png',
    '2024-09-12',
    'No'
  ),
  (
    82,
    'public/img/UuvC4lj6fYaXGnHO5Uz5SI4WpsCwX1HFzgP5Ze00.png',
    '2024-09-12',
    'No'
  ),
  (
    83,
    'public/img/tyJ1DCCKZYDSRE3W8ZWqHjgkwrPT1QAsL9Lg5yBz.png',
    '2024-09-12',
    'No'
  ),
  (
    84,
    'public/img/fETdDWcltxO6JHCsYpdLpGxubztdzNLBSjBiPdRn.png',
    '2024-09-12',
    'No'
  ),
  (
    85,
    'public/img/MwN00jiHuBylyCphYUxck3RXjb26Avo3mW3C02kE.png',
    '2024-09-12',
    'No'
  ),
  (
    86,
    'public/img/BD8k8XuGpuiWyGGuRfsWPmxoRVCEXH4AH2ZJc016.png',
    '2024-09-12',
    'No'
  ),
  (
    87,
    'public/img/qcYrtJvo2sH9dDRqNIsTJ0vTphxd7DsxyLFxxT2q.png',
    '2024-09-12',
    'No'
  ),
  (
    88,
    'public/img/oIps0FyHOFOSvSymkhdZ3IF4Sdg1pMKldI4KuEq5.png',
    '2024-09-12',
    'No'
  ),
  (
    89,
    'public/img/K10r2x0NCfbUYNEUCJneDTbXl64nVZ2VeUz15kL5.png',
    '2024-09-12',
    'No'
  ),
  (
    90,
    'public/img/rqKuOY0GuoM3qZtYgLAacTxP6bZdMdkMQLfq7vIq.png',
    '2024-09-12',
    'No'
  ),
  (
    91,
    'public/img/KUWYWRthdTJQAc3ImPuETV9ON8Q9t9ky5Bcl6pRn.png',
    '2024-09-12',
    'No'
  ),
  (
    92,
    'public/img/kaVtMN5uy6xfZc8DwmQQK29yYl8r4QB36Zz7il0d.png',
    '2024-09-12',
    'No'
  ),
  (
    93,
    'public/img/Cxxuo6gIb4jkKfpSngLurtSaxm94X9TKWgntcNfy.png',
    '2024-09-12',
    'No'
  ),
  (
    94,
    'public/img/vi7tR0xtLS0TOE8XxHUoDRwtz5mWWchUIJPUyVEu.png',
    '2024-09-12',
    'No'
  ),
  (
    95,
    'public/img/snvtHHOvwX1DH7HlZdAXEC8ZXFx0i9EAfu1Pbb2o.png',
    '2024-09-12',
    'No'
  ),
  (
    96,
    'public/img/4OQHNe2yRXnqcmRkMhcbaWLtJQnWkkFTtf7LQICO.jpg',
    '2024-09-12',
    'No'
  ),
  (
    97,
    'public/img/Dzairg2KlBXvH8DTsxJPf5VhG7xOEW2mZVSMU4RI.jpg',
    '2024-09-12',
    'No'
  ),
  (
    99,
    'public/img/eiMZJisKzjMasedfPEHLU8L6VtTOKnkmztwK97NF.png',
    '2024-09-12',
    'No'
  ),
  (
    100,
    'public/img/oxmUiGJ6yZejTgbmhEf46s2hZIaIEaBJiCXUpsnf.jpg',
    '2024-09-12',
    'No'
  ),
  (
    101,
    'public/img/lRSYDH9SZcvCwI3YCzctnQNBrccm8uDLgFwCcard.jpg',
    '2024-09-12',
    'No'
  ),
  (
    102,
    'public/img/mMsDsC2wCab6i0NBowqgagKGww1UV1PJocwDFQSv.jpg',
    '2024-09-12',
    'No'
  ),
  (
    103,
    'public/img/lklljuSkAgsyRTGpOpCEE9xrT6QFFNinbSttH1dS.jpg',
    '2024-09-12',
    'No'
  ),
  (
    104,
    'public/img/qyL3OBazzxxu6jclcbZZQDPtC72vzgiTDfKSfXb4.jpg',
    '2024-09-12',
    'No'
  ),
  (
    105,
    'public/img/eOyzBBT0modphquBgwdjLHMRZgJe4vjVnZbEGBOh.jpg',
    '2024-09-12',
    'No'
  ),
  (
    106,
    'public/img/9oFpR2yRbPfWYhTcLy0rFH0VYx4BtmGERslC19wS.jpg',
    '2024-09-12',
    'No'
  ),
  (
    107,
    'public/img/Z8r5mh211pvO0Ql1LEzk3xZmDUqonSF6TzY46jeH.jpg',
    '2024-09-12',
    'No'
  ),
  (
    108,
    'public/img/BgJkGYKdNHFd9cfCWCkJObE31bxyUxI4eRgdx8MG.png',
    '2024-09-12',
    'No'
  ),
  (
    109,
    'public/img/lzTf8U2U6DtWv9GFtb4MxCj0RvHtZvlca5PulqhS.png',
    '2024-09-12',
    'No'
  ),
  (
    110,
    'public/img/O3LVmJCLZLPNyOY2lFLxoHe2MwXGg6WEHvfuJO3c.jpg',
    '2024-09-12',
    'No'
  ),
  (
    111,
    'public/img/E3aIqQDiP8TQLuD5YcRlq7OHOoz5pQuIqZ152iCR.jpg',
    '2024-09-12',
    'No'
  ),
  (
    112,
    'public/img/ED0fkUvyi3osbiVLGQZoquu1jsGb9R6befsrwRV4.jpg',
    '2024-09-12',
    'No'
  ),
  (
    113,
    'public/img/FIFCjJ8RYC4SN8qde4C5Sf4TSF38C4TGQQTSonZU.jpg',
    '2024-09-12',
    'No'
  ),
  (
    114,
    'public/img/QxzhyoOnJqyFTQ5sMt24p6sE0fkwFylQmKOGujlK.jpg',
    '2024-09-12',
    'No'
  ),
  (
    115,
    'public/img/vFcU1X8S6BurKAT40YhWrXI2rzOq0qDQ2a0NOlHH.jpg',
    '2024-09-12',
    'No'
  ),
  (
    116,
    'public/img/8AU3f7Bb260c6L8qJHM6LDhrC1q7J3EqQLNCX8Gh.jpg',
    '2024-09-12',
    'No'
  ),
  (
    117,
    'public/img/osoNduzG2QTnd0RHbyx9z9GLu9eOJqUKokIqgjy8.jpg',
    '2024-09-12',
    'No'
  ),
  (
    118,
    'public/img/umMSULlAMWK6yvPosq7JvXmA1LbXtTIYlk9rz6sc.jpg',
    '2024-09-12',
    'No'
  ),
  (
    119,
    'public/img/a0Tm8S28dzcsEKWDPeegjFOfODoZtoxXR5gXS5dB.jpg',
    '2024-09-12',
    'No'
  ),
  (
    120,
    'public/img/XkAywPYcL7m7aiC6TTvLN7F0mjFWnJgqb9PLpAew.jpg',
    '2024-09-12',
    'No'
  ),
  (
    121,
    'public/img/qMDB8epID1DY0qIpiQspdEpJx4d6vU0IzZNie105.jpg',
    '2024-09-12',
    'No'
  ),
  (
    122,
    'public/img/czoKuatvnycuPWz3rcQrODIBCqiM2XB0EEV2U7d4.jpg',
    '2024-09-12',
    'No'
  ),
  (
    123,
    'public/img/PW5ffjKT4qTVmH2QjV7kawYGeSDXDQPVaXCxVNDq.jpg',
    '2024-09-12',
    'No'
  ),
  (
    124,
    'public/img/TZBOr6YofSH648iJgf6l1vYw9fQJpraPANbOm2Hg.jpg',
    '2024-09-12',
    'No'
  ),
  (
    125,
    'public/img/Pe7kSeEYYsONARNudXEbLPlViFdk5WmASuGStblK.jpg',
    '2024-09-12',
    'No'
  ),
  (
    126,
    'public/img/KgrLj73Y9c0zxKfxyow4ml2oS0psk2Hyg0EtPGct.jpg',
    '2024-09-12',
    'No'
  ),
  (
    127,
    'public/img/LRwZ3dQRG6KiAN22U6sXo9deOuZ7muYLnLeeIEVx.jpg',
    '2024-09-12',
    'No'
  ),
  (
    128,
    'public/img/58ksqdRm06kYTB1kb92FgG6WzMD2fQCAN4bRCSdS.jpg',
    '2024-09-12',
    'No'
  ),
  (
    129,
    'public/img/KtTMWy27n08GItz8IGPa8kWLMQ1G1q9hWv1X2QKH.jpg',
    '2024-09-12',
    'No'
  ),
  (
    130,
    'public/img/M23FKYjE831HmUXy7vgYrUTe7oQkXp3rYUmet2kM.jpg',
    '2024-09-12',
    'No'
  ),
  (
    131,
    'public/img/7CCnMP7yUZa12G91zlI0fChpTen2ynsMwkmJW5vn.jpg',
    '2024-09-12',
    'No'
  ),
  (
    132,
    'public/img/DspE1cKxlYjrIJ7K6HIaKN5zNEjDUq1RWUGNJp90.jpg',
    '2024-09-12',
    'No'
  ),
  (
    134,
    'public/img/SFT8qUxog0xzhh4baw5BPFU9fdudIDeaa9EI4Hi6.jpg',
    '2024-09-12',
    'No'
  ),
  (
    135,
    'public/img/0JFgNDcsd2vTV3S56YVcxKKl4NLURtEGuFm2LIa6.jpg',
    '2024-09-12',
    'No'
  ),
  (
    136,
    'public/img/GSmft4jmx3c37SJ4fHSjcCLxXlhf1t51pgo2Sc3q.jpg',
    '2024-09-12',
    'No'
  ),
  (
    137,
    'public/img/5Y52L6jJMdosa2H2JgaqDdkmXKkgfduaV1jlC8cL.jpg',
    '2024-09-12',
    'No'
  ),
  (
    138,
    'public/img/OyW0KnPFESxEtT5RrsyKFaIW8HdULTBuInzKQq9E.jpg',
    '2024-09-12',
    'No'
  ),
  (
    139,
    'public/img/qcRwhgCv5Fxn9bqTklZpLtseJgEnbPfZQZmYbhWm.jpg',
    '2024-09-12',
    'No'
  ),
  (
    140,
    'public/img/SQOApbFkPXxq4TtlYy5FFJMGeMM5JkDYVDe5yFWs.jpg',
    '2024-09-12',
    'No'
  ),
  (
    141,
    'public/img/IcFqvOlbRJIkdGhIOSoM4dyd7IPnSLYBLOOVWjKA.jpg',
    '2024-09-12',
    'No'
  ),
  (
    142,
    'public/img/KZ9PjHcIzMjybmRokwyZeWQ5VTdn4Rcb7t0ErQdV.jpg',
    '2024-09-12',
    'No'
  ),
  (
    143,
    'public/img/8lxSVyVKqhZKN1XkCMyrJwWv1l1vJqXsSHo0zHxE.jpg',
    '2024-09-12',
    'No'
  ),
  (
    144,
    'public/img/G3vvC30l5MBxhBjQmW9ZtkBcM2Ra5KhdtcA5g00M.jpg',
    '2024-09-12',
    'No'
  ),
  (
    145,
    'public/img/EdNUXnjgq3YVmbdoteFfab7wJnEpSQDcTtjHOMoR.jpg',
    '2024-09-12',
    'No'
  ),
  (
    146,
    'public/img/KaGM500OvYMLSdtsyF5OuOaAkeUPyauSmh5sxZma.jpg',
    '2024-09-13',
    'No'
  ),
  (
    147,
    'public/img/nQVSHUIT8T6Z3SKjK07svtZtAn6OE5aTJvC6xm7c.jpg',
    '2024-09-13',
    'No'
  ),
  (
    148,
    'public/img/2cpz9hd19dTM1kNZAS6iOumzz3kGbqVOgnwDMYf5.jpg',
    '2024-09-13',
    'No'
  ),
  (
    149,
    'public/img/54hOYXPtV19Es8qWVp4mRCEqywzIFpZ2abWRnWMJ.jpg',
    '2024-09-13',
    'No'
  ),
  (
    150,
    'public/img/BL238QtCesbtHx0aEwqGEk77NCJqRS0BwQaBQ1rh.jpg',
    '2024-09-13',
    'No'
  );
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `imagenescontenido`
--

DROP TABLE IF EXISTS `imagenescontenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `imagenescontenido` (
  `idimagenescontenido` int NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  `contenidos_idcontenidos` int NOT NULL,
  PRIMARY KEY (`idimagenescontenido`),
  KEY `fk_revisionImagenes_has_contenidos_contenidos1_idx` (`contenidos_idcontenidos`),
  KEY `fk_revisionImagenes_has_contenidos_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_contenidos1` FOREIGN KEY (`contenidos_idcontenidos`) REFERENCES `contenidos` (`idcontenidos`),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`)
) ENGINE = InnoDB AUTO_INCREMENT = 92 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `imagenescontenido`
--

LOCK TABLES `imagenescontenido` WRITE;
/*!40000 ALTER TABLE `imagenescontenido` DISABLE KEYS */
;
INSERT INTO `imagenescontenido`
VALUES (1, 77, 1),
  (2, 66, 3),
  (3, 67, 4),
  (4, 69, 6),
  (5, 70, 7),
  (6, 71, 8),
  (7, 73, 9),
  (8, 75, 11),
  (9, 74, 12),
  (10, 118, 16),
  (11, 119, 17),
  (12, 120, 18);
/*!40000 ALTER TABLE `imagenescontenido` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `lugarlocal`
--

DROP TABLE IF EXISTS `lugarlocal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `lugarlocal` (
  `idlugarLocal` int NOT NULL AUTO_INCREMENT,
  `nombreLugar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` int DEFAULT NULL,
  PRIMARY KEY (`idlugarLocal`)
) ENGINE = InnoDB AUTO_INCREMENT = 27 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `lugarlocal`
--

LOCK TABLES `lugarlocal` WRITE;
/*!40000 ALTER TABLE `lugarlocal` DISABLE KEYS */
;
INSERT INTO `lugarlocal`
VALUES (1, 'Vade', NULL, 'Av. Eva Peron', 1372),
  (2, 'Salas Ciro', NULL, NULL, NULL),
  (
    3,
    'City Bar Martinez',
    NULL,
    'Av. Fondo de la legua',
    2550
  ),
  (
    4,
    'Parador Metal Rock',
    NULL,
    'Ruta 205 (Dardo Rocha)',
    2324
  ),
  (5, 'Rincon de Milberg', NULL, 'Yagan Yagan', 290),
  (
    6,
    'Solifest',
    NULL,
    'Dr. Joaquin Zabala y Av. Chorrdarin',
    NULL
  ),
  (
    7,
    'Gier Music Club',
    NULL,
    'Alvarez Thomas',
    1078
  ),
  (8, 'Tabaco', NULL, 'Estados Unidos', 265),
  (9, 'The Other Place', NULL, 'Cascon', 108),
  (
    10,
    'Demos Centro Cultural',
    NULL,
    '9 de julio',
    2239
  ),
  (11, 'Melonio Bar', NULL, 'Montevideo', 175),
  (12, 'Kuervo Estudio', NULL, 'Zepellin', 6871),
  (
    13,
    'Salón Pueyrredón',
    NULL,
    'Av. Santa Fe',
    4560
  ),
  (14, 'Cemento Cultural', NULL, 'San Martin', 4750),
  (15, 'Barra Restobar', NULL, '197 y Trejo', NULL),
  (
    16,
    'Montana',
    NULL,
    'Republica de Portugal',
    3214
  ),
  (
    17,
    'CENTRO REGION LEONESA',
    NULL,
    'Humberto 1°',
    1462
  ),
  (18, 'El Teatrito', NULL, 'Sarmiento', 1752),
  (
    19,
    'Comedor del Complejo Deportivo',
    NULL,
    'Calle 25 de mayo',
    1921
  ),
  (20, 'Six Bar', NULL, 'Tribulato', 235),
  (21, 'Zardar Club', NULL, 'Av. Mitre', 6675),
  (22, 'Club Cultural Bula', NULL, 'Bulnes', 998),
  (23, 'Amparo', NULL, 'Carlos Pellegrini', 788),
  (24, 'Casa Rincon', NULL, 'Rincon', 1330),
  (25, 'Club V', NULL, 'Av. Corrientes', 5008),
  (
    26,
    'Teatro René Favaloro',
    NULL,
    'Calle 67 Entre 116 y 117',
    NULL
  );
/*!40000 ALTER TABLE `lugarlocal` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `notificaciones` (
  `idnotificaciones` int NOT NULL AUTO_INCREMENT,
  `opcionNotificacion` varchar(45) DEFAULT NULL,
  `usuarios_idusuarios` int NOT NULL,
  PRIMARY KEY (`idnotificaciones`),
  KEY `fk_notificaciones_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_notificaciones_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */
;
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `paisnacimiento`
--

DROP TABLE IF EXISTS `paisnacimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `paisnacimiento` (
  `idPaisNacimiento` int NOT NULL AUTO_INCREMENT,
  `nombrePN` varchar(100) NOT NULL,
  PRIMARY KEY (`idPaisNacimiento`)
) ENGINE = InnoDB AUTO_INCREMENT = 195 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `paisnacimiento`
--

LOCK TABLES `paisnacimiento` WRITE;
/*!40000 ALTER TABLE `paisnacimiento` DISABLE KEYS */
;
INSERT INTO `paisnacimiento`
VALUES (1, 'Afganistán'),
  (2, 'Albania'),
  (3, 'Alemania'),
  (4, 'Andorra'),
  (5, 'Angola'),
  (6, 'Antigua y Barbuda'),
  (7, 'Arabia Saudita'),
  (8, 'Argelia'),
  (9, 'Argentina'),
  (10, 'Armenia'),
  (11, 'Australia'),
  (12, 'Austria'),
  (13, 'Azerbaiyán'),
  (14, 'Bahamas'),
  (15, 'Bangladés'),
  (16, 'Barbados'),
  (17, 'Baréin'),
  (18, 'Bélgica'),
  (19, 'Belice'),
  (20, 'Benín'),
  (21, 'Bielorrusia'),
  (22, 'Birmania/Myanmar'),
  (23, 'Bolivia'),
  (24, 'Bosnia y Herzegovina'),
  (25, 'Botsuana'),
  (26, 'Brasil'),
  (27, 'Brunéi'),
  (28, 'Bulgaria'),
  (29, 'Burkina Faso'),
  (30, 'Burundi'),
  (31, 'Bután'),
  (32, 'Cabo Verde'),
  (33, 'Camboya'),
  (34, 'Camerún'),
  (35, 'Canadá'),
  (36, 'Catar'),
  (37, 'Chad'),
  (38, 'Chile'),
  (39, 'China'),
  (40, 'Chipre'),
  (41, 'Ciudad del Vaticano'),
  (42, 'Colombia'),
  (43, 'Comoras'),
  (44, 'Corea del Norte'),
  (45, 'Corea del Sur'),
  (46, 'Costa de Marfil'),
  (47, 'Costa Rica'),
  (48, 'Croacia'),
  (49, 'Cuba'),
  (50, 'Dinamarca'),
  (51, 'Dominica'),
  (52, 'Ecuador'),
  (53, 'Egipto'),
  (54, 'El Salvador'),
  (55, 'Emiratos Árabes Unidos'),
  (56, 'Eritrea'),
  (57, 'Eslovaquia'),
  (58, 'Eslovenia'),
  (59, 'España'),
  (60, 'Estados Unidos'),
  (61, 'Estonia'),
  (62, 'Etiopía'),
  (63, 'Filipinas'),
  (64, 'Finlandia'),
  (65, 'Fiyi'),
  (66, 'Francia'),
  (67, 'Gabón'),
  (68, 'Gambia'),
  (69, 'Georgia'),
  (70, 'Ghana'),
  (71, 'Granada'),
  (72, 'Grecia'),
  (73, 'Guatemala'),
  (74, 'Guyana'),
  (75, 'Guinea'),
  (76, 'Guinea ecuatorial'),
  (77, 'Guinea-Bisáu'),
  (78, 'Haití'),
  (79, 'Honduras'),
  (80, 'Hungría'),
  (81, 'India'),
  (82, 'Indonesia'),
  (83, 'Irak'),
  (84, 'Irán'),
  (85, 'Irlanda'),
  (86, 'Islandia'),
  (87, 'Islas Marshall'),
  (88, 'Islas Salomón'),
  (89, 'Israel'),
  (90, 'Italia'),
  (91, 'Jamaica'),
  (92, 'Japón'),
  (93, 'Jordania'),
  (94, 'Kazajistán'),
  (95, 'Kenia'),
  (96, 'Kirguistán'),
  (97, 'Kiribati'),
  (98, 'Kuwait'),
  (99, 'Laos'),
  (100, 'Lesoto'),
  (101, 'Letonia'),
  (102, 'Líbano'),
  (103, 'Liberia'),
  (104, 'Libia'),
  (105, 'Liechtenstein'),
  (106, 'Lituania'),
  (107, 'Luxemburgo'),
  (108, 'Macedonia del Norte'),
  (109, 'Madagascar'),
  (110, 'Malasia'),
  (111, 'Malaui'),
  (112, 'Maldivas'),
  (113, 'Malí'),
  (114, 'Malta'),
  (115, 'Marruecos'),
  (116, 'Mauricio'),
  (117, 'Mauritania'),
  (118, 'México'),
  (119, 'Micronesia'),
  (120, 'Moldavia'),
  (121, 'Mónaco'),
  (122, 'Mongolia'),
  (123, 'Montenegro'),
  (124, 'Mozambique'),
  (125, 'Namibia'),
  (126, 'Nauru'),
  (127, 'Nepal'),
  (128, 'Nicaragua'),
  (129, 'Níger'),
  (130, 'Nigeria'),
  (131, 'Noruega'),
  (132, 'Nueva Zelanda'),
  (133, 'Omán'),
  (134, 'Países Bajos'),
  (135, 'Pakistán'),
  (136, 'Palaos'),
  (137, 'Panamá'),
  (138, 'Papúa Nueva Guinea'),
  (139, 'Paraguay'),
  (140, 'Perú'),
  (141, 'Polonia'),
  (142, 'Portugal'),
  (143, 'Reino Unido'),
  (144, 'República Centroafricana'),
  (145, 'República Checa'),
  (146, 'República del Congo'),
  (147, 'República Democrática del Congo'),
  (148, 'República Dominicana'),
  (149, 'República Sudafricana'),
  (150, 'Ruanda'),
  (151, 'Rumanía'),
  (152, 'Rusia'),
  (153, 'Samoa'),
  (154, 'San Cristóbal y Nieves'),
  (155, 'San Marino'),
  (156, 'San Vicente y las Granadinas'),
  (157, 'Santa Lucía'),
  (158, 'Santo Tomé y Príncipe'),
  (159, 'Senegal'),
  (160, 'Serbia'),
  (161, 'Seychelles'),
  (162, 'Sierra Leona'),
  (163, 'Singapur'),
  (164, 'Siria'),
  (165, 'Somalia'),
  (166, 'Sri Lanka'),
  (167, 'Suazilandia'),
  (168, 'Sudán'),
  (169, 'Sudán del Sur'),
  (170, 'Suecia'),
  (171, 'Suiza'),
  (172, 'Surinam'),
  (173, 'Tailandia'),
  (174, 'Tanzania'),
  (175, 'Tayikistán'),
  (176, 'Timor Oriental'),
  (177, 'Togo'),
  (178, 'Tonga'),
  (179, 'Trinidad y Tobago'),
  (180, 'Túnez'),
  (181, 'Turkmenistán'),
  (182, 'Turquía'),
  (183, 'Tuvalu'),
  (184, 'Ucrania'),
  (185, 'Uganda'),
  (186, 'Uruguay'),
  (187, 'Uzbekistán'),
  (188, 'Vanuatu'),
  (189, 'Venezuela'),
  (190, 'Vietnam'),
  (191, 'Yemen'),
  (192, 'Yibuti'),
  (193, 'Zambia'),
  (194, 'Zimbabue');
/*!40000 ALTER TABLE `paisnacimiento` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `redessociales`
--

DROP TABLE IF EXISTS `redessociales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `redessociales` (
  `idredesSociales` int NOT NULL AUTO_INCREMENT,
  `linkRedSocial` varchar(255) DEFAULT NULL,
  `nombreRedSocial` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idredesSociales`)
) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `redessociales`
--

LOCK TABLES `redessociales` WRITE;
/*!40000 ALTER TABLE `redessociales` DISABLE KEYS */
;
INSERT INTO `redessociales`
VALUES (
    3,
    'https://open.spotify.com/intl-es/artist/0Y9jAWMZF3ve6nxKdNFiWU',
    'Spotify'
  ),
  (
    4,
    'https://www.instagram.com/inner.metal/',
    'Instagram'
  ),
  (
    5,
    'https://www.youtube.com/channel/UCqb2lqhpvCyRQTikSRgAmUw',
    'Youtube'
  ),
  (
    6,
    'https://music.apple.com/us/album/journey/1581042877',
    'iTunes'
  ),
  (
    7,
    'https://music.amazon.com/albums/B09CKF3F5W',
    'Amazon Music'
  ),
  (
    8,
    'https://www.instagram.com/_victoriavmc_/',
    '2victoriavmc'
  ),
  (
    9,
    'https://key-drop.com/es/user/profile/76561198933462556',
    '3kevin'
  ),
  (
    10,
    'https://www.instagram.com/david_b_copa/',
    '45davidcop'
  ),
  (
    11,
    'https://www.instagram.com/tomi.inner/',
    '46atomize29'
  ),
  (
    12,
    'https://www.instagram.com/agus.sauvage/',
    '47agustin12'
  ),
  (
    13,
    'https://www.instagram.com/hjernan/',
    '48hernirami'
  ),
  (
    18,
    'https://www.deezer.com/es/show/2142682',
    'Deezer'
  );
/*!40000 ALTER TABLE `redessociales` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `redsocial`
--

DROP TABLE IF EXISTS `redsocial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `redsocial` (
  `idredsocial` int NOT NULL AUTO_INCREMENT,
  `seguidores` int DEFAULT '0',
  `reportes` int DEFAULT '0',
  `seguidos` int DEFAULT '0',
  `usuarios_idusuarios` int NOT NULL,
  PRIMARY KEY (`idredsocial`),
  KEY `fk_redsocial_usuarios1_idx` (`usuarios_idusuarios`),
  CONSTRAINT `fk_redsocial_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 109 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `redsocial`
--

LOCK TABLES `redsocial` WRITE;
/*!40000 ALTER TABLE `redsocial` DISABLE KEYS */
;
INSERT INTO `redsocial`
VALUES (92, 0, 0, 0, 1),
  (93, 0, 0, 0, 2),
  (94, 0, 0, 0, 3),
  (95, 0, 0, 0, 4),
  (96, 0, 0, 0, 5),
  (97, 0, 0, 0, 6),
  (98, 0, 0, 0, 9),
  (99, 0, 0, 0, 10),
  (100, 0, 0, 0, 11),
  (101, 0, 0, 0, 12),
  (102, 0, 0, 0, 33),
  (103, 0, 0, 0, 34),
  (104, 0, 0, 0, 35),
  (105, 0, 0, 0, 45),
  (106, 0, 0, 0, 46),
  (107, 0, 0, 0, 47),
  (108, 0, 0, 0, 48);
/*!40000 ALTER TABLE `redsocial` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `revisionimagenes`
--

DROP TABLE IF EXISTS `revisionimagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
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
) ENGINE = InnoDB AUTO_INCREMENT = 200 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `revisionimagenes`
--

LOCK TABLES `revisionimagenes` WRITE;
/*!40000 ALTER TABLE `revisionimagenes` DISABLE KEYS */
;
INSERT INTO `revisionimagenes`
VALUES (27, 2, 57, 1),
  (38, 6, 68, 1),
  (42, 9, 72, 1),
  (43, 33, 73, 1),
  (44, 34, 74, 1),
  (45, 35, 75, 1),
  (47, 1, 77, 1),
  (48, 1, 78, 7),
  (49, 1, 79, 7),
  (50, 1, 80, 7),
  (51, 1, 81, 7),
  (52, 1, 82, 7),
  (53, 1, 83, 7),
  (54, 1, 84, 7),
  (55, 1, 85, 7),
  (56, 1, 86, 7),
  (57, 1, 87, 7),
  (58, 1, 88, 7),
  (59, 1, 89, 7),
  (60, 1, 90, 7),
  (61, 1, 91, 7),
  (62, 1, 92, 7),
  (63, 1, 93, 7),
  (64, 1, 94, 7),
  (65, 1, 95, 7),
  (66, 4, 96, 2),
  (67, 4, 97, 2),
  (69, 4, 99, 2),
  (70, 4, 100, 2),
  (71, 4, 101, 2),
  (72, 4, 102, 2),
  (73, 4, 103, 2),
  (74, 4, 104, 2),
  (75, 4, 105, 2),
  (76, 4, 106, 2),
  (77, 4, 107, 2),
  (78, 1, 108, 2),
  (79, 1, 109, 2),
  (80, 1, 110, 2),
  (81, 1, 111, 2),
  (82, 2, 112, 6),
  (83, 2, 113, 4),
  (84, 2, 114, 4),
  (85, 2, 115, 4),
  (86, 2, 116, 4),
  (87, 2, 117, 4),
  (88, 2, 118, 4),
  (89, 2, 119, 4),
  (90, 2, 120, 4),
  (91, 2, 121, 4),
  (92, 2, 122, 4),
  (93, 2, 123, 4),
  (94, 2, 124, 4),
  (95, 2, 125, 4),
  (96, 2, 126, 4),
  (97, 2, 127, 4),
  (98, 2, 128, 4),
  (99, 2, 129, 4),
  (100, 2, 130, 4),
  (101, 2, 131, 4),
  (102, 2, 132, 4),
  (104, 2, 134, 4),
  (105, 2, 135, 4),
  (106, 2, 136, 4),
  (107, 2, 137, 4),
  (108, 2, 138, 4),
  (109, 2, 139, 4),
  (110, 2, 140, 4),
  (111, 2, 141, 4),
  (112, 2, 142, 4),
  (113, 2, 143, 4),
  (114, 2, 144, 4),
  (115, 2, 145, 4),
  (116, 2, 146, 4),
  (117, 2, 147, 4),
  (118, 11, 148, 5),
  (119, 9, 149, 5),
  (120, 34, 150, 5);
/*!40000 ALTER TABLE `revisionimagenes` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `roles` (
  `idrol` int NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */
;
INSERT INTO `roles`
VALUES (1, 'Administrador'),
  (2, 'Staff'),
  (3, 'SuperFan'),
  (4, 'FanBasic');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `show`
--

DROP TABLE IF EXISTS `show`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `show` (
  `idshow` int NOT NULL AUTO_INCREMENT,
  `fechashow` datetime DEFAULT NULL,
  `estadoShow` varchar(45) DEFAULT NULL,
  `linkGoogleMaps` longtext NOT NULL,
  `linkCompraEntrada` varchar(255) DEFAULT NULL,
  `revisionImagenes_idrevisionImagenescol` int NOT NULL,
  `ubicacionShow_idubicacionShow` int NOT NULL,
  `lugarLocal_idlugarLocal` int NOT NULL,
  PRIMARY KEY (`idshow`),
  KEY `fk_show_ubicacionShow1_idx` (`ubicacionShow_idubicacionShow`),
  KEY `fk_show_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol`),
  KEY `fk_show_lugarLocal1_idx` (`lugarLocal_idlugarLocal`),
  CONSTRAINT `fk_show_lugarLocal1` FOREIGN KEY (`lugarLocal_idlugarLocal`) REFERENCES `lugarlocal` (`idlugarLocal`),
  CONSTRAINT `fk_show_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_show_ubicacionShow1` FOREIGN KEY (`ubicacionShow_idubicacionShow`) REFERENCES `ubicacionshow` (`idubicacionShow`)
) ENGINE = InnoDB AUTO_INCREMENT = 35 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `show`
--

LOCK TABLES `show` WRITE;
/*!40000 ALTER TABLE `show` DISABLE KEYS */
;
INSERT INTO `show`
VALUES (
    1,
    '2021-01-08 20:00:00',
    'Inactivo',
    '',
    NULL,
    83,
    1,
    1
  ),
  (
    2,
    '2022-03-19 23:30:00',
    'Inactivo',
    '',
    NULL,
    84,
    1,
    2
  ),
  (
    3,
    '2022-05-29 18:30:00',
    'Inactivo',
    '',
    NULL,
    85,
    1,
    3
  ),
  (
    4,
    '2022-06-25 21:00:00',
    'Inactivo',
    '',
    NULL,
    86,
    1,
    4
  ),
  (
    5,
    '2022-08-13 19:00:00',
    'Inactivo',
    '',
    NULL,
    87,
    1,
    5
  ),
  (
    6,
    '2022-08-21 13:00:00',
    'Inactivo',
    '',
    NULL,
    88,
    1,
    6
  ),
  (
    7,
    '2022-08-26 23:30:00',
    'Inactivo',
    '',
    NULL,
    89,
    1,
    7
  ),
  (
    8,
    '2022-09-10 21:30:00',
    'Inactivo',
    '',
    NULL,
    90,
    1,
    8
  ),
  (
    9,
    '2022-10-15 21:00:00',
    'Inactivo',
    '',
    NULL,
    91,
    1,
    9
  ),
  (
    10,
    '2022-11-12 21:00:00',
    'Inactivo',
    '',
    NULL,
    92,
    1,
    10
  ),
  (
    11,
    '2022-12-10 18:30:00',
    'Inactivo',
    '',
    NULL,
    93,
    1,
    11
  ),
  (
    12,
    '2023-02-11 21:00:00',
    'Inactivo',
    '',
    NULL,
    94,
    1,
    12
  ),
  (
    13,
    '2023-03-18 19:00:00',
    'Inactivo',
    '',
    NULL,
    95,
    1,
    13
  ),
  (
    14,
    '2023-04-01 18:30:00',
    'Inactivo',
    '',
    NULL,
    96,
    1,
    14
  ),
  (
    15,
    '2023-04-21 21:00:00',
    'Inactivo',
    '',
    NULL,
    97,
    1,
    15
  ),
  (
    16,
    '2023-05-06 19:00:00',
    'Inactivo',
    '',
    NULL,
    98,
    1,
    16
  ),
  (
    17,
    '2023-05-19 22:00:00',
    'Inactivo',
    '',
    NULL,
    99,
    1,
    17
  ),
  (
    18,
    '2023-05-20 21:00:00',
    'Inactivo',
    '',
    NULL,
    100,
    1,
    18
  ),
  (
    19,
    '2023-06-24 19:00:00',
    'Inactivo',
    '',
    NULL,
    101,
    1,
    19
  ),
  (
    20,
    '2023-07-16 18:00:00',
    'Inactivo',
    '',
    NULL,
    102,
    1,
    20
  ),
  (
    21,
    '2023-08-20 19:00:00',
    'Inactivo',
    '',
    NULL,
    104,
    1,
    21
  ),
  (
    22,
    '2023-09-02 20:00:00',
    'Inactivo',
    '',
    NULL,
    105,
    1,
    22
  ),
  (
    23,
    '2023-10-14 18:00:00',
    'Inactivo',
    '',
    NULL,
    106,
    1,
    23
  ),
  (
    24,
    '2023-11-10 23:59:00',
    'Inactivo',
    '',
    NULL,
    107,
    1,
    24
  ),
  (
    25,
    '2023-12-08 21:00:00',
    'Inactivo',
    '',
    NULL,
    108,
    1,
    25
  ),
  (
    26,
    '2023-12-23 17:00:00',
    'Inactivo',
    '',
    NULL,
    109,
    1,
    26
  ),
  (
    27,
    '2023-12-30 21:00:00',
    'Inactivo',
    '',
    NULL,
    110,
    1,
    1
  ),
  (
    28,
    '2024-04-26 21:00:00',
    'Inactivo',
    '',
    NULL,
    111,
    1,
    2
  ),
  (
    29,
    '2024-05-31 21:00:00',
    'Inactivo',
    '',
    NULL,
    112,
    1,
    3
  ),
  (
    30,
    '2024-05-18 19:00:00',
    'Inactivo',
    '',
    NULL,
    113,
    1,
    4
  ),
  (
    31,
    '2024-06-07 21:00:00',
    'Inactivo',
    '',
    NULL,
    114,
    1,
    5
  ),
  (
    32,
    '2024-07-20 21:00:00',
    'Inactivo',
    '',
    NULL,
    115,
    1,
    6
  ),
  (
    33,
    '2024-08-30 21:00:00',
    'Inactivo',
    '',
    NULL,
    116,
    1,
    7
  ),
  (
    34,
    '2024-09-20 18:00:00',
    'Inactivo',
    '',
    NULL,
    117,
    1,
    8
  );
/*!40000 ALTER TABLE `show` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `staffextra`
--

DROP TABLE IF EXISTS `staffextra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `staffextra` (
  `idstaffExtra` int NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` int NOT NULL,
  `tipoStaff_idtipoStaff` int NOT NULL,
  `redesSociales_idredesSociales` int DEFAULT NULL,
  `imagenes_idimagenes` int NOT NULL DEFAULT '78',
  PRIMARY KEY (`idstaffExtra`),
  KEY `fk_staffExtra_redesSociales_idx` (`redesSociales_idredesSociales`),
  KEY `fk_staffExtra_usuarios1_idx` (`usuarios_idusuarios`),
  KEY `fk_staffextra_tipoStaff1_idx` (`tipoStaff_idtipoStaff`),
  KEY `fk_staffextra_imagenes` (`imagenes_idimagenes`),
  CONSTRAINT `fk_staffextra_imagenes` FOREIGN KEY (`imagenes_idimagenes`) REFERENCES `imagenes` (`idimagenes`),
  CONSTRAINT `fk_staffExtra_redesSociales` FOREIGN KEY (`redesSociales_idredesSociales`) REFERENCES `redessociales` (`idredesSociales`),
  CONSTRAINT `fk_staffextra_tipoStaff1` FOREIGN KEY (`tipoStaff_idtipoStaff`) REFERENCES `tipostaff` (`idtipoStaff`),
  CONSTRAINT `fk_staffExtra_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `staffextra`
--

LOCK TABLES `staffextra` WRITE;
/*!40000 ALTER TABLE `staffextra` DISABLE KEYS */
;
INSERT INTO `staffextra`
VALUES (1, 2, 6, 8, 78),
  (2, 3, 3, 9, 78),
  (3, 45, 7, 10, 78),
  (4, 46, 14, 11, 78),
  (5, 47, 1, 12, 78),
  (6, 48, 4, 13, 78),
  (7, 34, 5, NULL, 78);
/*!40000 ALTER TABLE `staffextra` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `tipocontenido`
--

DROP TABLE IF EXISTS `tipocontenido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `tipocontenido` (
  `idtipoContenido` int NOT NULL AUTO_INCREMENT,
  `tipoContenido` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idtipoContenido`)
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `tipocontenido`
--

LOCK TABLES `tipocontenido` WRITE;
/*!40000 ALTER TABLE `tipocontenido` DISABLE KEYS */
;
INSERT INTO `tipocontenido`
VALUES (1, 'Foro'),
  (2, 'Noticias'),
  (3, 'Biografia');
/*!40000 ALTER TABLE `tipocontenido` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `tipodefoto`
--

DROP TABLE IF EXISTS `tipodefoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `tipodefoto` (
  `idtipoDeFoto` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtipoDeFoto`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `tipodefoto`
--

LOCK TABLES `tipodefoto` WRITE;
/*!40000 ALTER TABLE `tipodefoto` DISABLE KEYS */
;
INSERT INTO `tipodefoto`
VALUES (1, 'Usuarios'),
  (2, 'Contenido'),
  (3, 'MultimediaGeneral'),
  (4, 'Flyers'),
  (5, 'Foro'),
  (6, 'Portada'),
  (7, 'Fijas');
/*!40000 ALTER TABLE `tipodefoto` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `tipostaff`
--

DROP TABLE IF EXISTS `tipostaff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `tipostaff` (
  `idtipoStaff` int NOT NULL AUTO_INCREMENT,
  `nombreStaff` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idtipoStaff`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `tipostaff`
--

LOCK TABLES `tipostaff` WRITE;
/*!40000 ALTER TABLE `tipostaff` DISABLE KEYS */
;
INSERT INTO `tipostaff`
VALUES (1, 'Bass Guitar'),
  (2, 'Cameraman'),
  (3, 'Designer'),
  (4, 'Drummer'),
  (5, 'Filmmaker'),
  (6, 'Gods of the Page'),
  (7, 'Guitar'),
  (8, 'Lighting Technician'),
  (9, 'Manages'),
  (10, 'Photographer'),
  (11, 'Press'),
  (12, 'Sound Technician'),
  (13, 'Stage Manager or Technician'),
  (14, 'Vocalist and Guitar');
/*!40000 ALTER TABLE `tipostaff` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `ubicacionshow`
--

DROP TABLE IF EXISTS `ubicacionshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `ubicacionshow` (
  `idubicacionShow` int NOT NULL AUTO_INCREMENT,
  `provinciaLugar` varchar(255) DEFAULT NULL,
  `paisLugar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idubicacionShow`)
) ENGINE = InnoDB AUTO_INCREMENT = 25 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `ubicacionshow`
--

LOCK TABLES `ubicacionshow` WRITE;
/*!40000 ALTER TABLE `ubicacionshow` DISABLE KEYS */
;
INSERT INTO `ubicacionshow`
VALUES (1, 'Buenos Aires', 'Argentina'),
  (2, 'Catamarca', 'Argentina'),
  (3, 'Chaco', 'Argentina'),
  (4, 'Chubut', 'Argentina'),
  (5, 'Córdoba', 'Argentina'),
  (6, 'Corrientes', 'Argentina'),
  (7, 'Entre Ríos', 'Argentina'),
  (8, 'Formosa', 'Argentina'),
  (9, 'Jujuy', 'Argentina'),
  (10, 'La Pampa', 'Argentina'),
  (11, 'La Rioja', 'Argentina'),
  (12, 'Mendoza', 'Argentina'),
  (13, 'Misiones', 'Argentina'),
  (14, 'Neuquén', 'Argentina'),
  (15, 'Río Negro', 'Argentina'),
  (16, 'Salta', 'Argentina'),
  (17, 'San Juan', 'Argentina'),
  (18, 'San Luis', 'Argentina'),
  (19, 'Santa Cruz', 'Argentina'),
  (20, 'Santa Fe', 'Argentina'),
  (21, 'Santiago del Estero', 'Argentina'),
  (22, 'Tierra del Fuego', 'Argentina'),
  (23, 'Tucumán', 'Argentina'),
  (
    24,
    'Ciudad Autónoma de Buenos Aires',
    'Argentina'
  );
/*!40000 ALTER TABLE `ubicacionshow` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `usuarioUser` varchar(45) NOT NULL,
  `contraseniaUser` varchar(255) NOT NULL,
  `pinOlvidoUser` varchar(255) DEFAULT NULL,
  `correoElectronicoUser` varchar(45) NOT NULL,
  `rol_idrol` int NOT NULL,
  PRIMARY KEY (`idusuarios`),
  UNIQUE KEY `usuarioUser_UNIQUE` (`usuarioUser`),
  UNIQUE KEY `correoElectronicoUser_UNIQUE` (`correoElectronicoUser`),
  KEY `fk_usuarios_rol1_idx` (`rol_idrol`),
  CONSTRAINT `fk_usuarios_rol1` FOREIGN KEY (`rol_idrol`) REFERENCES `roles` (`idrol`)
) ENGINE = InnoDB AUTO_INCREMENT = 49 DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */
;
INSERT INTO `usuarios`
VALUES (
    1,
    'santi',
    '$2y$12$a9zXQi0oOvUv/T.wmQwlyOxi6Fwd8Y9/hytgCdO5bcTrlmFQkcuj2',
    NULL,
    'santiago.aranda.81@gmail.com',
    1
  ),
  (
    2,
    'victoriavmc',
    '$2y$12$Dc9/phLfRbTAyQIoOBnsQedG55Y4fuExRtNc8TCTyNNlIwL41TSSy',
    NULL,
    'victoriavmcortitrabajos@gmail.com',
    2
  ),
  (
    3,
    'kevin',
    '$2y$12$olp4BtsXUrFo2AKOsLnnPO30IFIDfGfE/r0A0dvBFDQXlBoAbnbUG',
    NULL,
    'schneiderk985@gmail.com',
    2
  ),
  (
    4,
    'carlosg',
    '$2y$12$iwRj0ZEs94NTP0Y4ynctGO4hIWvXMRRSlxATQ.OcUmoVdZM5T3a6a',
    NULL,
    'carlitog@example.com',
    4
  ),
  (
    5,
    'luciap',
    '$2y$12$qtp9cYv1EYVSRzUOOigbouiXKOoNgqEdwMOIgEHmXhmBB.N.b4czy',
    NULL,
    'lucia.perez@example.com',
    4
  ),
  (
    6,
    'andresf',
    '$2y$12$txmh19CQkTibu5I0vV8g0eXqUiod5J0s20iWRhWLQTHIn69ybivym',
    NULL,
    'andres.fernandez@example.com',
    4
  ),
  (
    9,
    'mariar',
    '$2y$12$FGyg/yHJx.zoOkrWoLbKvO30wuBPdH2YdkxYbZzK4YgHhjJho1N3.',
    NULL,
    'maria.rodriguez@example.com',
    4
  ),
  (
    10,
    'javierl',
    '$2y$12$X4lJZfdbSkXu2AMERQJJquQBRPzEVP6MppVKRBrIxo3wuIZvcIfyy',
    NULL,
    'javier.lopez@example.com',
    4
  ),
  (
    11,
    'juana',
    '$2y$12$FGyg/yHJx.zoOkrWoLbKvO30wuBPdH2YdkxYbZzK4YgHhjJho1N3.',
    NULL,
    'juani@example.com',
    3
  ),
  (
    12,
    'cami',
    '$2y$12$X4lJZfdbSkXu2AMERQJJquQBRPzEVP6MppVKRBrIxo3wuIZvcIfyy',
    NULL,
    'campaz@example.com',
    3
  ),
  (
    33,
    'fansinsub',
    '$2y$12$v7uuy1s.KH/DILck0QOSyusmTJYzKBrgBSt/IlYWMyUf.CUO/CUDC',
    NULL,
    'fanbasico@example.com',
    4
  ),
  (
    34,
    'fanconsub',
    '$2y$12$w8fetCl/aSq8WQ9jiFquX.IOl3f5fac8lkC5AK6o5SKzoJh9KXuGK',
    NULL,
    'superfan@examle.com',
    3
  ),
  (
    35,
    'fanprueba',
    '$2y$12$2KehDx82zSwEIYOq/TsqzOX8uQRiOn7Q9c7hmcJEgvpmJKMQaGTVa',
    NULL,
    'dasdada@example.com',
    4
  ),
  (
    45,
    'davidcop',
    '$2y$12$W6FP0TAcwYiJEWiWJjQM/uE0cQ9EuNlFICRUipRnZbm6bIXumC0O2',
    NULL,
    'copadavid1@hotmail.com',
    2
  ),
  (
    46,
    'atomize29',
    '$2y$12$wbJ7A5ThDxQ/6q7KN91PBeQREWKM.btR6ELUR0y82S789KyNDKfLm',
    NULL,
    'tomascasalone@example',
    2
  ),
  (
    47,
    'agustin12',
    '$2y$12$YkG6RQy71389AKGDq8aKWOgEgVSD764lrqKZb6AuKCl8dqU.Ozyym',
    NULL,
    'aguscasalone@example',
    2
  ),
  (
    48,
    'hernirami',
    '$2y$12$XI2g1GJ2BYtjFztDMOJLTuciH9EVcVA5z4IjFHI19h5b/msPv1pb.',
    '$2y$12$18yQDc.mEXXT67ehksGsSuq//y42Q97O5hPt8hgzWz6svnek7b3WK',
    'herniramirez@example.com',
    2
  );
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `videos` (
  `idvideos` int NOT NULL AUTO_INCREMENT,
  `subidaVideo` varchar(45) DEFAULT NULL,
  `fechaSubidoVideo` varchar(45) DEFAULT NULL,
  `contenidoDescargable` varchar(45) DEFAULT 'No',
  `albumRecital_idalbumRecital` int NOT NULL,
  PRIMARY KEY (`idvideos`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */
;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `youtubeapi`
--

DROP TABLE IF EXISTS `youtubeapi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `youtubeapi` (
  `idYoutubeApi` int NOT NULL AUTO_INCREMENT,
  `tituloYt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `linkYt` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`idYoutubeApi`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `youtubeapi`
--

LOCK TABLES `youtubeapi` WRITE;
/*!40000 ALTER TABLE `youtubeapi` DISABLE KEYS */
;
INSERT INTO `youtubeapi`
VALUES (
    1,
    'INNER - Forgotten - Drum Playthrough by Hernan Ramirez',
    '2024-07-22',
    'https://www.youtube.com/watch?v=Zn33STtdNVo'
  ),
  (
    2,
    'INNER - Black Trees - Drum Playthrough by Hernan Ramirez',
    '2024-07-17',
    'https://www.youtube.com/watch?v=EgAhuhtSFYk'
  ),
  (
    3,
    '#shorts INNER - Resumen - Uniclub 10/02/24',
    '2024-02-19',
    'https://www.youtube.com/watch?v=l5jbhWafkvs'
  ),
  (
    4,
    '#shorts INNER - Resumen - El teatrito 20/08/23',
    '2023-09-01',
    'https://www.youtube.com/watch?v=CNU3BgREl80'
  ),
  (
    5,
    '#shorts INNER - Resumen - Salon Regional Leonesa 24/6/23',
    '2023-07-09',
    'https://www.youtube.com/watch?v=QTXad02TcSo'
  ),
  (
    6,
    'INNER - Hill of the Seven Colors',
    '2021-09-04',
    'https://www.youtube.com/watch?v=ntev9lgyFe0'
  ),
  (
    7,
    'INNER - Dying',
    '2021-09-04',
    'https://www.youtube.com/watch?v=JwcxshhJ9Zs'
  ),
  (
    8,
    'INNER - Evolution',
    '2021-09-04',
    'https://www.youtube.com/watch?v=8PvPxBHzyvw'
  ),
  (
    9,
    'INNER - The Journey',
    '2021-09-04',
    'https://www.youtube.com/watch?v=pt59HWnfaSo'
  ),
  (
    10,
    'INNER - Focus',
    '2021-09-04',
    'https://www.youtube.com/watch?v=ynEBN2JN8tY'
  ),
  (
    11,
    'INNER - Vicious Circle',
    '2021-09-04',
    'https://www.youtube.com/watch?v=enxO7xJIqYY'
  ),
  (
    12,
    'INNER - Imploded Sun',
    '2021-09-04',
    'https://www.youtube.com/watch?v=7t0B85mYHxk'
  ),
  (
    13,
    'INNER - Black Trees',
    '2021-08-09',
    'https://www.youtube.com/watch?v=BxCJKHj5b6w'
  ),
  (
    14,
    'INNER - Forgotten',
    '2021-04-27',
    'https://www.youtube.com/watch?v=TPDVdPe3Gpo'
  );
/*!40000 ALTER TABLE `youtubeapi` ENABLE KEYS */
;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;
-- Dump completed on 2024-09-27 16:35:10