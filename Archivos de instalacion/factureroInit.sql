CREATE DATABASE  IF NOT EXISTS `facturero` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `facturero`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: facturero
-- ------------------------------------------------------
-- Server version	5.5.8-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `idconfig` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `llave` varchar(255) NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'MIXED',
  PRIMARY KEY (`idconfig`),
  UNIQUE KEY `idconfig_UNIQUE` (`idconfig`),
  KEY `llave` (`llave`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Tabla de configuraciones. Si una configuración es array, se marca con la columna array. No se mantiene orden de claves.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--
-- ORDER BY:  `idconfig`

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'REMITENTE_NOMBRE','FactureroBF','MIXED'),(2,'REMITENTE_MAIL','fseckel@baufest.com','MIXED'),(3,'SMTPSERVER','outlook.office365.com','MIXED'),(4,'SMTPUSER','fseckel@baufest.com','MIXED'),(5,'SMTPPASS','NA','MIXED'),(6,'SMTPPORT','587','MIXED'),(7,'MAILDEBUG','2','MIXED'),(8,'ASUNTO_MAIL','Facturero','MIXED'),(9,'SMTPSECURE','tls','MIXED'),(10,'SMTPAUTH','TRUE','BOOLEAN'),(16,'INDEXURL','http://localhost/facturero/index.php','MIXED');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `idproyectos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `frecuencia` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'VI' COMMENT 'separado por ''|'': LU|MA|MI|JU|VI|SA|DO\nsi es número: cada cuantos días',
  `cantidadParticipantes` smallint(5) unsigned NOT NULL DEFAULT '1',
  `comentarios` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Comentarios del proyecto',
  `leyenda` text COLLATE utf8_spanish_ci COMMENT 'Agregar texto en los mensajes',
  PRIMARY KEY (`idproyectos`),
  KEY `NOMBRE` (`nombre`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--
-- ORDER BY:  `idproyectos`

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,'Prueba basica','1',0,'comentate','soy leyenda');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuarios` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ultimoLogin` datetime DEFAULT NULL,
  `loginenabled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `verificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`user`),
  UNIQUE KEY `idusuarios_UNIQUE` (`idusuarios`),
  UNIQUE KEY `mail_UNIQUE` (`mail`),
  KEY `NOMBRE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--
-- ORDER BY:  `user`

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','11ab89521352cd46a2f25f4d4f2f14a13b2e805f','2015-05-05 11:38:07',1,NULL,'',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariosenproyecto`
--

DROP TABLE IF EXISTS `usuariosenproyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariosenproyecto` (
  `idusuarios` int(10) unsigned NOT NULL,
  `idproyectos` int(10) unsigned NOT NULL,
  `orden` int(10) unsigned NOT NULL,
  KEY `PERSONAS` (`idusuarios`),
  KEY `PROYECTOS` (`idproyectos`),
  KEY `PROYECTOSORDEN` (`idproyectos`,`orden`),
  CONSTRAINT `PROYECTOS` FOREIGN KEY (`idproyectos`) REFERENCES `proyectos` (`idproyectos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `USUARIOS` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariosenproyecto`
--

LOCK TABLES `usuariosenproyecto` WRITE;
/*!40000 ALTER TABLE `usuariosenproyecto` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuariosenproyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'facturero'
--

--
-- Dumping routines for database 'facturero'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-06 12:57:06
