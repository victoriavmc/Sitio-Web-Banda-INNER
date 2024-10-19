-- MySQL Workbench Forward Engineering
SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS,
  UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS,
  FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE,
  SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema inner
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema inner
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inner` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `inner`;
-- -----------------------------------------------------
-- Table `inner`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`roles` (
  `idrol` INT NOT NULL AUTO_INCREMENT,
  `rol` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`usuarios` (
  `idusuarios` INT NOT NULL AUTO_INCREMENT,
  `usuarioUser` VARCHAR(45) NOT NULL,
  `contraseniaUser` VARCHAR(100) NULL DEFAULT NULL,
  `pinOlvidoUser` VARCHAR(100) NULL DEFAULT NULL,
  `correoElectronicoUser` VARCHAR(45) NOT NULL,
  `rol_idrol` INT NOT NULL,
  PRIMARY KEY (`idusuarios`),
  INDEX `fk_usuarios_rol1_idx` (`rol_idrol` ASC),
  CONSTRAINT `fk_usuarios_rol1` FOREIGN KEY (`rol_idrol`) REFERENCES `inner`.`roles` (`idrol`)
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`tipoActividad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`tipoActividad` (
  `idtipoActividad` INT NOT NULL AUTO_INCREMENT,
  `nombreActividad` VARCHAR(45) NULL,
  PRIMARY KEY (`idtipoActividad`)
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `inner`.`actividad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`actividad` (
  `idActividad` INT NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` INT NOT NULL,
  `tipoActividad_idtipoActividad` INT NULL,
  PRIMARY KEY (`idActividad`),
  INDEX `fk_Actividad_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_actividad_tipoActividad1_idx` (`tipoActividad_idtipoActividad` ASC),
  CONSTRAINT `fk_Actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`),
  CONSTRAINT `fk_actividad_tipoActividad1` FOREIGN KEY (`tipoActividad_idtipoActividad`) REFERENCES `inner`.`tipoActividad` (`idtipoActividad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 43 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`albumdatos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`albumdatos` (
  `idalbumDatos` INT NOT NULL AUTO_INCREMENT,
  `tituloAlbum` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `fechaSubido` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`idalbumDatos`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`tipodefoto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`tipodefoto` (
  `idtipoDeFoto` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idtipoDeFoto`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- -----------------------------------------------------
-- Table `inner`.`imagenes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`imagenes` (
  `idimagenes` INT NOT NULL AUTO_INCREMENT,
  `subidaImg` VARCHAR(255) NULL DEFAULT NULL,
  `fechaSubidaImg` DATE NULL DEFAULT NULL,
  `contenidoDescargable` VARCHAR(45) NULL DEFAULT 'No',
  PRIMARY KEY (`idimagenes`)
) ENGINE = InnoDB AUTO_INCREMENT = 58 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`revisionimagenes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`revisionimagenes` (
  `idrevisionImagenescol` INT NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` INT NOT NULL,
  `imagenes_idimagenes` INT NOT NULL,
  `tipodefoto_idtipoDeFoto` INT NOT NULL,
  PRIMARY KEY (`idrevisionImagenescol`),
  INDEX `fk_usuarios_has_imagenes_imagenes1_idx` (`imagenes_idimagenes` ASC),
  INDEX `fk_usuarios_has_imagenes_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_revisionImagenes_tipodefoto1_idx` (`tipodefoto_idtipoDeFoto` ASC),
  CONSTRAINT `fk_revisionImagenes_tipodefoto1` FOREIGN KEY (`tipodefoto_idtipoDeFoto`) REFERENCES `inner`.`tipodefoto` (`idtipoDeFoto`),
  CONSTRAINT `fk_usuarios_has_imagenes_imagenes1` FOREIGN KEY (`imagenes_idimagenes`) REFERENCES `inner`.`imagenes` (`idimagenes`),
  CONSTRAINT `fk_usuarios_has_imagenes_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 58 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`albumimagenes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`albumimagenes` (
  `albumImagenescol` INT NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` INT NOT NULL,
  `revisionImagenes_idrevisionImagenescol` INT NOT NULL,
  PRIMARY KEY (`albumImagenescol`),
  INDEX `fk_table1_albumDatos1_idx` (`albumDatos_idalbumDatos` ASC),
  INDEX `fk_albumImagenes_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  CONSTRAINT `fk_albumImagenes_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `inner`.`albumdatos` (`idalbumDatos`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`albummusical`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`albummusical` (
  `albumMusicalcol` INT NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` INT NOT NULL,
  `revisionImagenes_idrevisionImagenescol` INT NULL DEFAULT NULL,
  PRIMARY KEY (`albumMusicalcol`),
  INDEX `fk_albumMusical_albumDatos1_idx` (`albumDatos_idalbumDatos` ASC),
  INDEX `fk_albumMusical_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  CONSTRAINT `fk_albumMusical_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `inner`.`albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumMusical_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`videos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`videos` (
  `idvideos` INT NOT NULL AUTO_INCREMENT,
  `subidaVideo` VARCHAR(45) NULL DEFAULT NULL,
  `fechaSubidoVideo` VARCHAR(45) NULL DEFAULT NULL,
  `contenidoDescargable` VARCHAR(45) NULL DEFAULT 'No',
  PRIMARY KEY (`idvideos`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`albumvideo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`albumvideo` (
  `idalbumVideo` INT NOT NULL AUTO_INCREMENT,
  `albumDatos_idalbumDatos` INT NOT NULL,
  `videos_idvideos` INT NOT NULL,
  PRIMARY KEY (`idalbumVideo`),
  INDEX `fk_albumVideo_albumDatos1_idx` (`albumDatos_idalbumDatos` ASC),
  INDEX `fk_albumVideo_videos1_idx` (`videos_idvideos` ASC),
  CONSTRAINT `fk_albumVideo_albumDatos1` FOREIGN KEY (`albumDatos_idalbumDatos`) REFERENCES `inner`.`albumdatos` (`idalbumDatos`),
  CONSTRAINT `fk_albumVideo_videos1` FOREIGN KEY (`videos_idvideos`) REFERENCES `inner`.`videos` (`idvideos`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`redessociales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`redessociales` (
  `idredesSociales` INT NOT NULL AUTO_INCREMENT,
  `linkRedSocial` VARCHAR(512) NULL DEFAULT NULL,
  `nombreRedSocial` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idredesSociales`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`tipostaff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`tipostaff` (
  `idtipoStaff` INT NOT NULL AUTO_INCREMENT,
  `nombreStaff` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`idtipoStaff`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`staffextra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`staffextra` (
  `idstaffExtra` INT NOT NULL AUTO_INCREMENT,
  `redesSociales_idredesSociales` INT NULL DEFAULT NULL,
  `usuarios_idusuarios` INT NOT NULL,
  `tipoStaff_idtipoStaff` INT NOT NULL,
  `revisionimagenes_idrevisionImagenescol` INT NULL,
  PRIMARY KEY (`idstaffExtra`),
  INDEX `fk_staffExtra_redesSociales_idx` (`redesSociales_idredesSociales` ASC),
  INDEX `fk_staffExtra_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_staffextra_tipoStaff1_idx` (`tipoStaff_idtipoStaff` ASC),
  INDEX `fk_staffextra_revisionimagenes1_idx` (`revisionimagenes_idrevisionImagenescol` ASC),
  CONSTRAINT `fk_staffExtra_redesSociales` FOREIGN KEY (`redesSociales_idredesSociales`) REFERENCES `inner`.`redessociales` (`idredesSociales`),
  CONSTRAINT `fk_staffextra_tipoStaff1` FOREIGN KEY (`tipoStaff_idtipoStaff`) REFERENCES `inner`.`tipostaff` (`idtipoStaff`),
  CONSTRAINT `fk_staffExtra_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`),
  CONSTRAINT `fk_staffextra_revisionimagenes1` FOREIGN KEY (`revisionimagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`artistas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`artistas` (
  `idartistas` INT NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` INT NULL DEFAULT NULL,
  `staffextra_idstaffExtra` INT NOT NULL,
  PRIMARY KEY (`idartistas`),
  INDEX `fk_artistas_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  INDEX `fk_artistas_staffextra1_idx` (`staffextra_idstaffExtra` ASC),
  CONSTRAINT `fk_artistas_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_artistas_staffextra1` FOREIGN KEY (`staffextra_idstaffExtra`) REFERENCES `inner`.`staffextra` (`idstaffExtra`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`cancion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`cancion` (
  `idcancion` INT NOT NULL AUTO_INCREMENT,
  `tituloCancion` LONGTEXT NULL DEFAULT NULL,
  `letraEspCancion` LONGTEXT NULL DEFAULT NULL,
  `letraInglesCancion` LONGTEXT NULL DEFAULT NULL,
  `archivoDsCancion` LONGTEXT NULL DEFAULT NULL,
  `contenidoDescargable` VARCHAR(45) NULL DEFAULT 'No',
  `albumMusical_albumMusicalcol` INT NOT NULL,
  PRIMARY KEY (`idcancion`),
  INDEX `fk_cancion_albumMusical1_idx` (`albumMusical_albumMusicalcol` ASC),
  CONSTRAINT `fk_cancion_albumMusical1` FOREIGN KEY (`albumMusical_albumMusicalcol`) REFERENCES `inner`.`albummusical` (`albumMusicalcol`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`tipocontenido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`tipocontenido` (
  `idtipoContenido` INT NOT NULL AUTO_INCREMENT,
  `tipoContenido` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`idtipoContenido`)
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`contenidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`contenidos` (
  `idcontenidos` INT NOT NULL AUTO_INCREMENT,
  `fechaSubida` DATE NULL DEFAULT NULL,
  `titulo` LONGTEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `descripcion` LONGTEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `tipoContenido_idtipoContenido` INT NOT NULL,
  `Actividad_idActividad` INT NOT NULL,
  PRIMARY KEY (`idcontenidos`),
  INDEX `fk_contenidos_tipoContenido1_idx` (`tipoContenido_idtipoContenido` ASC),
  INDEX `fk_contenidos_Actividad1_idx` (`Actividad_idActividad` ASC),
  CONSTRAINT `fk_contenidos_Actividad1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `inner`.`actividad` (`idActividad`),
  CONSTRAINT `fk_contenidos_tipoContenido1` FOREIGN KEY (`tipoContenido_idtipoContenido`) REFERENCES `inner`.`tipocontenido` (`idtipoContenido`)
) ENGINE = InnoDB AUTO_INCREMENT = 23 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`comentarios` (
  `idcomentarios` INT NOT NULL AUTO_INCREMENT,
  `fechaComent` DATE NULL DEFAULT NULL,
  `descripcion` LONGTEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `Actividad_idActividad` INT NOT NULL,
  `contenidos_idcontenidos` INT NOT NULL,
  `revisionImagenes_idrevisionImagenescol` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idcomentarios`),
  INDEX `fk_table1_Actividad1_idx` (`Actividad_idActividad` ASC),
  INDEX `fk_table1_contenidos1_idx` (`contenidos_idcontenidos` ASC),
  INDEX `fk_comentarios_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  CONSTRAINT `fk_comentarios_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_table1_Actividad1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `inner`.`actividad` (`idActividad`),
  CONSTRAINT `fk_table1_contenidos1` FOREIGN KEY (`contenidos_idcontenidos`) REFERENCES `inner`.`contenidos` (`idcontenidos`)
) ENGINE = InnoDB AUTO_INCREMENT = 21 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`paisnacimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`paisnacimiento` (
  `idPaisNacimiento` INT NOT NULL AUTO_INCREMENT,
  `nombrePN` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idPaisNacimiento`)
) ENGINE = InnoDB AUTO_INCREMENT = 195 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`datospersonales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`datospersonales` (
  `idDatosPersonales` INT NOT NULL AUTO_INCREMENT,
  `nombreDP` VARCHAR(45) NULL DEFAULT NULL,
  `apellidoDP` VARCHAR(45) NULL DEFAULT NULL,
  `fechaNacimiento` DATE NULL DEFAULT NULL,
  `generoDP` VARCHAR(45) NULL DEFAULT NULL,
  `usuarios_idusuarios` INT NOT NULL,
  `PaisNacimiento_idPaisNacimiento` INT NOT NULL,
  PRIMARY KEY (`idDatosPersonales`),
  INDEX `fk_datosPersonales_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_datosPersonales_PaisNacimiento1_idx` (`PaisNacimiento_idPaisNacimiento` ASC),
  CONSTRAINT `fk_datosPersonales_PaisNacimiento1` FOREIGN KEY (`PaisNacimiento_idPaisNacimiento`) REFERENCES `inner`.`paisnacimiento` (`idPaisNacimiento`),
  CONSTRAINT `fk_datosPersonales_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`historialusuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`historialusuario` (
  `idhistorialusuario` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT 'Activo',
  `eliminacionLogica` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT 'No',
  `fechaInica` DATE NULL DEFAULT NULL,
  `fechaFinaliza` DATE NULL DEFAULT NULL,
  `datospersonales_idDatosPersonales` INT NOT NULL,
  PRIMARY KEY (`idhistorialusuario`),
  INDEX `fk_historialusuario_datospersonales1_idx` (`datospersonales_idDatosPersonales` ASC),
  CONSTRAINT `fk_historialusuario_datospersonales1` FOREIGN KEY (`datospersonales_idDatosPersonales`) REFERENCES `inner`.`datospersonales` (`idDatosPersonales`)
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`imagenescontenido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`imagenescontenido` (
  `idimagenescontenido` INT NOT NULL AUTO_INCREMENT,
  `revisionImagenes_idrevisionImagenescol` INT NOT NULL,
  `contenidos_idcontenidos` INT NOT NULL,
  PRIMARY KEY (`idimagenescontenido`),
  INDEX `fk_revisionImagenes_has_contenidos_contenidos1_idx` (`contenidos_idcontenidos` ASC),
  INDEX `fk_revisionImagenes_has_contenidos_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_contenidos1` FOREIGN KEY (`contenidos_idcontenidos`) REFERENCES `inner`.`contenidos` (`idcontenidos`),
  CONSTRAINT `fk_revisionImagenes_has_contenidos_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`)
) ENGINE = InnoDB AUTO_INCREMENT = 27 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`interacciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`interacciones` (
  `idinteracciones` INT NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` INT NOT NULL,
  `actividad_idActividad` INT NOT NULL,
  `megusta` INT NULL DEFAULT '0',
  `nomegusta` INT NULL DEFAULT '0',
  `reporte` INT NULL DEFAULT '0',
  PRIMARY KEY (`idinteracciones`),
  INDEX `fk_usuarios_has_actividad_actividad1_idx` (`actividad_idActividad` ASC),
  INDEX `fk_usuarios_has_actividad_usuarios1_idx` (`usuarios_idusuarios` ASC),
  CONSTRAINT `fk_usuarios_has_actividad_actividad1` FOREIGN KEY (`actividad_idActividad`) REFERENCES `inner`.`actividad` (`idActividad`),
  CONSTRAINT `fk_usuarios_has_actividad_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`)
) ENGINE = InnoDB AUTO_INCREMENT = 42 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`lugarlocal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`lugarlocal` (
  `idlugarLocal` INT NOT NULL AUTO_INCREMENT,
  `nombreLugar` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `localidad` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `calle` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `numero` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idlugarLocal`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`notificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`notificaciones` (
  `idnotificaciones` INT NOT NULL AUTO_INCREMENT,
  `opcionNotificacion` VARCHAR(45) NULL DEFAULT NULL,
  `usuarios_idusuarios` INT NOT NULL,
  PRIMARY KEY (`idnotificaciones`),
  INDEX `fk_notificaciones_usuarios1_idx` (`usuarios_idusuarios` ASC),
  CONSTRAINT `fk_notificaciones_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`motivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`motivos` (
  `idmotivos` INT NOT NULL AUTO_INCREMENT,
  `descripcion` LONGTEXT NULL,
  PRIMARY KEY (`idmotivos`)
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `inner`.`reportes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`reportes` (
  `idreportes` INT NOT NULL AUTO_INCREMENT,
  `usuarios_idusuarios` INT NOT NULL,
  `motivos_idmotivos` INT NULL,
  PRIMARY KEY (`idreportes`),
  INDEX `fk_redsocial_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_reportes_motivos1_idx` (`motivos_idmotivos` ASC),
  CONSTRAINT `fk_redsocial_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`),
  CONSTRAINT `fk_reportes_motivos1` FOREIGN KEY (`motivos_idmotivos`) REFERENCES `inner`.`motivos` (`idmotivos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- -----------------------------------------------------
-- Table `inner`.`ubicacionshow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`ubicacionshow` (
  `idubicacionShow` INT NOT NULL AUTO_INCREMENT,
  `provinciaLugar` VARCHAR(255) NULL DEFAULT NULL,
  `paisLugar` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idubicacionShow`)
) ENGINE = InnoDB AUTO_INCREMENT = 25 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`precio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`precio` (
  `idprecio` INT NOT NULL AUTO_INCREMENT,
  `precio` DECIMAL NOT NULL,
  PRIMARY KEY (`idprecio`)
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `inner`.`ordenpago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`ordenpago` (
  `idordenpago` INT NOT NULL AUTO_INCREMENT,
  `factura` LONGTEXT NOT NULL,
  `metodoPago` LONGTEXT NOT NULL,
  `diaPago` DATETIME NOT NULL,
  `estadoPago` VARCHAR(255) NOT NULL,
  `precio_idprecio` INT NOT NULL,
  `usuarios_idusuarios` INT NOT NULL,
  PRIMARY KEY (`idordenpago`),
  INDEX `fk_suscripcion_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_suscripcion_precio1_idx` (`precio_idprecio` ASC),
  CONSTRAINT `fk_suscripcion_usuarios1` FOREIGN KEY (`usuarios_idusuarios`) REFERENCES `inner`.`usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_suscripcion_precio1` FOREIGN KEY (`precio_idprecio`) REFERENCES `inner`.`precio` (`idprecio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `inner`.`show`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`show` (
  `idshow` INT NOT NULL AUTO_INCREMENT,
  `fechashow` DATETIME NOT NULL,
  `estadoShow` VARCHAR(45) NULL DEFAULT 'Activo',
  `linkCompraEntrada` VARCHAR(255) NULL DEFAULT NULL,
  `ubicacionShow_idubicacionShow` INT NOT NULL,
  `revisionImagenes_idrevisionImagenescol` INT NULL DEFAULT NULL,
  `lugarLocal_idlugarLocal` INT NOT NULL,
  `ordenpago_idordenpago` INT NULL,
  PRIMARY KEY (`idshow`),
  INDEX `fk_show_ubicacionShow1_idx` (`ubicacionShow_idubicacionShow` ASC),
  INDEX `fk_show_revisionImagenes1_idx` (`revisionImagenes_idrevisionImagenescol` ASC),
  INDEX `fk_show_lugarLocal1_idx` (`lugarLocal_idlugarLocal` ASC),
  INDEX `fk_show_ordenpago1_idx` (`ordenpago_idordenpago` ASC),
  CONSTRAINT `fk_show_lugarLocal1` FOREIGN KEY (`lugarLocal_idlugarLocal`) REFERENCES `inner`.`lugarlocal` (`idlugarLocal`),
  CONSTRAINT `fk_show_revisionImagenes1` FOREIGN KEY (`revisionImagenes_idrevisionImagenescol`) REFERENCES `inner`.`revisionimagenes` (`idrevisionImagenescol`),
  CONSTRAINT `fk_show_ubicacionShow1` FOREIGN KEY (`ubicacionShow_idubicacionShow`) REFERENCES `inner`.`ubicacionshow` (`idubicacionShow`),
  CONSTRAINT `fk_show_ordenpago1` FOREIGN KEY (`ordenpago_idordenpago`) REFERENCES `inner`.`ordenpago` (`idordenpago`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARACTER SET = utf8mb3;
-- -----------------------------------------------------
-- Table `inner`.`youtubeapi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inner`.`youtubeapi` (
  `idYoutubeApi` INT NOT NULL AUTO_INCREMENT,
  `tituloYt` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `fecha` DATE NULL DEFAULT NULL,
  `linkYt` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`idYoutubeApi`)
) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- INSERTS
INSERT INTO `motivos`
VALUES (
    1,
    'Publicó múltiples mensajes de spam en diferentes temas'
  ),
  (
    2,
    'Utilizó lenguaje ofensivo y despectivo en sus comentarios'
  ),
  (
    3,
    'Acosó repetidamente a otros usuarios en el foro'
  ),
  (4, 'Publicó contenido inapropiado y ofensivo'),
  (5, 'Se hizo pasar por otro usuario o moderador'),
  (6, 'Violó repetidamente las reglas del foro'),
  (
    7,
    'Publicó enlaces a sitios web maliciosos o peligrosos'
  ),
  (
    8,
    'Incitó a la violencia o al odio hacia grupos específicos'
  ),
  (
    9,
    'Utilizó múltiples cuentas para manipular discusiones'
  ),
  (
    10,
    'Recibió múltiples denuncias de otros usuarios por conducta inapropiada'
  ),
  (11, 'Publicó imágenes inapropiadas');
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
INSERT INTO `roles`
VALUES (1, 'Administrador'),
  (2, 'Staff'),
  (3, 'SuperFan'),
  (4, 'FanBasic');
INSERT INTO `tipoactividad`
VALUES (1, 'Perfil'),
  (2, 'Comentarios'),
  (3, 'Contenidos');
INSERT INTO `tipocontenido`
VALUES (1, 'Foro'),
  (2, 'Noticias'),
  (3, 'Biografia');
INSERT INTO `tipodefoto`
VALUES (1, 'Usuarios'),
  (2, 'Contenido Staff'),
  (3, 'Multimedia General'),
  (4, 'Flyers'),
  (5, 'Contenido Foro'),
  (6, 'Portada'),
  (7, 'Fijas');
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
SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;