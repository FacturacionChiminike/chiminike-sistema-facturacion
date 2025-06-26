-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: factura_chiminike
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `adicionales`
--

DROP TABLE IF EXISTS `adicionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adicionales` (
  `cod_adicional` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cod_adicional`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adicionales`
--

LOCK TABLES `adicionales` WRITE;
/*!40000 ALTER TABLE `adicionales` DISABLE KEYS */;
INSERT INTO `adicionales` VALUES (2,'Parque Vial','Acceso al parque vial por persona',80.00),(3,'Merienda actualizada','Nueva descripción',60.00),(7,'FDJSDFHSFDJH','45345341',3123.00);
/*!40000 ALTER TABLE `adicionales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bitacora` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_usuario` int NOT NULL,
  `objeto` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `descripcion` text,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (1,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 06:57:04'),(2,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 19:17:42'),(3,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 19:29:28'),(4,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 20:33:21'),(5,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 20:41:36'),(6,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 20:43:21'),(7,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 20:45:58'),(8,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-15 21:18:36'),(9,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-17 04:54:09'),(12,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-17 05:27:43'),(13,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-17 05:43:06'),(14,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-17 05:52:06'),(15,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 15:42:12'),(16,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 16:00:17'),(17,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 16:07:54'),(18,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 16:58:07'),(19,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 17:01:28'),(20,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 17:02:54'),(21,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 17:21:28'),(22,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 21:07:29'),(23,4,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 21:52:10'),(24,4,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 21:52:39'),(25,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 22:10:50'),(26,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 22:11:50'),(27,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-20 23:12:51'),(28,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 01:33:37'),(29,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 01:39:46'),(30,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 02:29:17'),(31,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:13:44'),(32,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:21:13'),(33,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:26:11'),(34,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:44:30'),(35,7,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:46:39'),(36,7,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:49:21'),(37,7,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 05:51:03'),(38,13,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 16:45:33'),(39,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 16:57:11'),(40,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:03:32'),(41,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:08:49'),(42,7,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:10:13'),(43,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:12:52'),(44,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:13:59'),(45,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:19:11'),(46,15,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:23:16'),(47,15,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-21 17:24:03'),(48,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 04:56:36'),(49,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:04:06'),(50,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:05:17'),(51,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:13:18'),(52,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:19:17'),(53,5,'Cliente','Eliminar','Eliminación de Cliente desde IP ::1','2025-06-22 05:19:57'),(54,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:23:32'),(55,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-22 05:38:25'),(56,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 01:23:32'),(57,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 03:42:59'),(60,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 15:22:45'),(61,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 15:32:22'),(62,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 15:52:02'),(63,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 16:04:28'),(64,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-23 16:55:54'),(65,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-24 03:40:16'),(66,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-24 05:53:41'),(67,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-24 06:24:20'),(68,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-24 06:44:55'),(69,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-24 07:05:22'),(70,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:01:20'),(71,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:14:54'),(72,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:17:27'),(73,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:39:15'),(74,5,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:43:17'),(75,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 04:44:57'),(76,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 05:14:34'),(78,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 14:23:01'),(79,1,'Login','Acceso','Inicio de sesión exitoso desde IP ::1','2025-06-25 17:02:36');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cai`
--

DROP TABLE IF EXISTS `cai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cai` (
  `cod_cai` int NOT NULL AUTO_INCREMENT,
  `cai` varchar(100) NOT NULL,
  `rango_desde` varchar(25) NOT NULL,
  `rango_hasta` varchar(25) NOT NULL,
  `fecha_limite` date NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_cai`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cai`
--

LOCK TABLES `cai` WRITE;
/*!40000 ALTER TABLE `cai` DISABLE KEYS */;
INSERT INTO `cai` VALUES (3,'CAI-TEST-123456-Ulmate','00020001','00150000','2025-12-19',0,'2025-06-13 16:34:02'),(4,'CAI-2025-009-actualizado','00020001','00150000','2025-10-15',1,'2025-06-15 21:20:49');
/*!40000 ALTER TABLE `cai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `cod_cliente` int NOT NULL AUTO_INCREMENT,
  `rtn` varchar(20) DEFAULT NULL,
  `tipo_cliente` enum('Individual','Empresa') DEFAULT NULL,
  `cod_persona` int DEFAULT NULL,
  PRIMARY KEY (`cod_cliente`),
  KEY `cod_persona` (`cod_persona`),
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'08011990123456','Empresa',7),(3,'0801199912345','Individual',16),(4,'0801199345','Individual',17),(5,'0801199912345','Individual',21),(6,'777653425','Individual',26),(12,'3232332','Individual',32),(13,'345222211','Individual',33),(14,'65372333','Individual',34),(15,'77222425','Individual',35),(17,'342872211','Individual',37),(22,'242334','Individual',52),(23,'234567342','Individual',55);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correos`
--

DROP TABLE IF EXISTS `correos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `correos` (
  `cod_correo` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) DEFAULT NULL,
  `cod_persona` int DEFAULT NULL,
  PRIMARY KEY (`cod_correo`),
  KEY `cod_persona` (`cod_persona`),
  CONSTRAINT `correos_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correos`
--

LOCK TABLES `correos` WRITE;
/*!40000 ALTER TABLE `correos` DISABLE KEYS */;
INSERT INTO `correos` VALUES (6,'michitogarcia.mg@gmail.com',6),(7,'carlos.mendoza@gmail.com',7),(8,'carlos.rivera@gmail.com',10),(9,'guerraclanes65@gmail.com',14),(11,'juanperez@gmail.com',16),(12,'jua453rez@gmail.com',17),(13,'camila@example.com',21),(14,'ju222ez@gmail.com',26),(20,'myke_mg@correo.com',32),(21,'myke_mg@correo.com',33),(22,'myke_mg@correo.com',34),(23,'ju222e22z@gmail.com',35),(25,'hackerputos2@gmail.com',37),(26,'probandocosas@gmail.com',38),(27,'hackerputos2@gmail.com',39),(28,'michitogarcia12@gmail.com',40),(29,'miguelbarahona718@gmail.com',41),(33,'narutoizumaki265@gmail.com',46),(34,'narutoizumaki265@gmail.com',47),(35,'momobellaco@gmail.com',49),(36,'momobellaco@gmail.com',50),(38,'momobellaco@gmail.com',52),(39,'paseguerra@gmail.com',53),(40,'miguelgarcia9647@gmail.com',54),(41,'holamundo@gmail.com',55),(42,'holamundo@gmail.com',56),(43,'hipernova504@gmail.com',57),(44,'msucles3288@gmail.com',58),(45,'vivam88978@decodewp.com',59),(46,'narutoizumaki265@gmail.com',60),(47,'narutoizumaki265@gmail.com',61),(48,'miguelgarcia9647@gmail.com',62);
/*!40000 ALTER TABLE `correos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion`
--

DROP TABLE IF EXISTS `cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizacion` (
  `cod_cotizacion` int NOT NULL AUTO_INCREMENT,
  `cod_cliente` int NOT NULL,
  `fecha` date NOT NULL DEFAULT (curdate()),
  `fecha_validez` date NOT NULL,
  `estado` enum('pendiente','confirmada','expirada','completada') DEFAULT 'pendiente',
  PRIMARY KEY (`cod_cotizacion`),
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion`
--

LOCK TABLES `cotizacion` WRITE;
/*!40000 ALTER TABLE `cotizacion` DISABLE KEYS */;
INSERT INTO `cotizacion` VALUES (2,3,'2025-06-07','2025-06-12','pendiente'),(3,4,'2025-06-07','2025-06-12','pendiente'),(4,5,'2025-06-07','2025-06-12','pendiente'),(5,6,'2025-06-07','2025-06-12','pendiente'),(11,12,'2025-06-07','2025-06-12','pendiente'),(12,13,'2025-06-07','2025-06-12','pendiente'),(13,14,'2025-06-07','2025-06-12','pendiente'),(14,15,'2025-06-07','2025-06-12','pendiente'),(16,17,'2025-06-07','2025-06-12','pendiente'),(18,22,'2025-06-15','2025-06-20','pendiente'),(19,23,'2025-06-20','2025-06-25','pendiente');
/*!40000 ALTER TABLE `cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento_empresa`
--

DROP TABLE IF EXISTS `departamento_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento_empresa` (
  `cod_departamento_empresa` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY (`cod_departamento_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento_empresa`
--

LOCK TABLES `departamento_empresa` WRITE;
/*!40000 ALTER TABLE `departamento_empresa` DISABLE KEYS */;
INSERT INTO `departamento_empresa` VALUES (1,'Dirección General'),(2,'Facturación'),(3,'Eventos'),(4,'Recorridos Escolares');
/*!40000 ALTER TABLE `departamento_empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamentos` (
  `cod_departamento` int NOT NULL AUTO_INCREMENT,
  `departamento` varchar(60) NOT NULL,
  PRIMARY KEY (`cod_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'Atlántida'),(2,'Choluteca'),(3,'Colón'),(4,'Comayagua'),(5,'Copán'),(6,'Cortés'),(7,'El Paraíso'),(8,'Francisco Morazán'),(9,'Gracias a Dios'),(10,'Intibucá'),(11,'Islas de la Bahía'),(12,'La Paz'),(13,'Lempira'),(14,'Ocotepeque'),(15,'Olancho'),(16,'Santa Bárbara'),(17,'Valle'),(18,'Yoro');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_cotizacion`
--

DROP TABLE IF EXISTS `detalle_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_cotizacion` (
  `cod_detallecotizacion` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `descripcion` text NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cod_cotizacion` int NOT NULL,
  PRIMARY KEY (`cod_detallecotizacion`),
  KEY `cod_cotizacion` (`cod_cotizacion`),
  CONSTRAINT `detalle_cotizacion_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`cod_cotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_cotizacion`
--

LOCK TABLES `detalle_cotizacion` WRITE;
/*!40000 ALTER TABLE `detalle_cotizacion` DISABLE KEYS */;
INSERT INTO `detalle_cotizacion` VALUES (6,5,'Silla VIP',35.00,175.00,2),(7,1,'Pantalla gigante',1800.00,1800.00,2),(19,10,'Silla blanca',25.00,250.00,3),(20,2,'Proyector HD',500.00,1000.00,3),(21,1,'Equipo de sonido',1000.00,1000.00,3),(22,5,'Mesa redonda',150.00,750.00,3),(23,10,'Mantel blanco',35.00,350.00,3),(24,10,'probando json 200',5000.00,50000.00,3),(26,2,'Tour Guiado',250.00,500.00,4),(27,1,'Paquete Familiar',950.00,950.00,4),(29,10,'Silla blnca',25.00,250.00,5),(30,2,'Proyector HD',500.00,1000.00,5),(31,1,'Equipo de sonido',1000.00,1000.00,5),(32,4,'espero que funcione esta vez',2343.00,9372.00,11),(33,2,'pruebita',213.00,426.00,12),(34,234,'sera que si funciona',23.00,5382.00,13),(35,10,'Silla blnca',75.00,750.00,14),(36,2,'Proyector HD',500.00,1000.00,14),(37,1,'Equipo de sonido',1000.00,1000.00,14),(41,1,'dffdf',232.00,232.00,16),(42,1,'vfvfdd',234.00,234.00,16),(46,1,'Sin descripción',234.00,234.00,18),(47,34,'Sin descripción',567.00,19278.00,18),(48,1,'ertghgfd',435.00,435.00,19),(49,1,'dfghgfdsdfg',45323.00,45323.00,19),(50,1,'dfghjkhgfdfgh',543.00,543.00,19),(51,1,'dfghgfdfg',453.00,453.00,19);
/*!40000 ALTER TABLE `detalle_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_factura`
--

DROP TABLE IF EXISTS `detalle_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_factura` (
  `cod_detalle_factura` int NOT NULL AUTO_INCREMENT,
  `cod_factura` int NOT NULL,
  `cantidad` int NOT NULL,
  `descripcion` text NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo` enum('Evento','Entrada','Paquete','Adicional','Inventario','Otro') NOT NULL,
  `referencia` int DEFAULT NULL,
  PRIMARY KEY (`cod_detalle_factura`),
  KEY `cod_factura` (`cod_factura`),
  CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`cod_factura`) REFERENCES `facturas` (`cod_factura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_factura`
--

LOCK TABLES `detalle_factura` WRITE;
/*!40000 ALTER TABLE `detalle_factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direcciones` (
  `cod_direccion` int NOT NULL AUTO_INCREMENT,
  `direccion` text,
  `cod_persona` int DEFAULT NULL,
  `cod_municipio` int DEFAULT NULL,
  PRIMARY KEY (`cod_direccion`),
  KEY `cod_persona` (`cod_persona`),
  KEY `cod_municipio` (`cod_municipio`),
  CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `direcciones_ibfk_2` FOREIGN KEY (`cod_municipio`) REFERENCES `municipios` (`cod_municipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
INSERT INTO `direcciones` VALUES (6,'Zambrano actualizado',6,3),(7,'Col. El Sauce, Tegucigalpa',7,2),(8,'Barrio Abajo, Tegucigalpa',10,3),(9,'Col. Las Brisas, Tegucigalpa',14,3),(11,'Col. Las Uvas',16,1),(12,'Colonia Las Uvas',17,1),(13,'Col. Palmira, Tegucigalpa',21,1),(14,'Colonia Las Uvas',26,1),(20,'sdfghgfd',32,1),(21,'gguhhhhuhubuu',33,1),(22,'hola prueba',34,1),(23,'Colonia Las Uvas',35,1),(25,'dcsdcdscs',37,1),(26,'Canaán',38,2),(27,'Col. El Prado, Casa 15',39,2),(28,'Col. Las Brisas, Tegucigalpa',40,3),(29,'Canaán',41,2),(33,'Col. Las Brisas, Tegucigalpa',46,3),(34,'Zambrano',47,2),(35,'Siguatepeque',49,1),(36,'hjasjsjasjajsajsa',50,1),(38,'Siguatepeque',52,3),(39,'Aldea Zambrano',53,109),(40,'Prueba exotica',54,13),(41,'JAJAJAJAJAAJA',55,2),(42,'JAJAJAJAJAAJA',56,79),(43,'LA UNAH',57,110),(44,'zambrano',59,102),(45,'pueblito del olvido',60,17),(46,'Barrio Abajo, Tegucigalpa',61,12),(47,'Prueba exotica',62,13);
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `cod_empleado` int NOT NULL AUTO_INCREMENT,
  `cargo` varchar(50) DEFAULT NULL,
  `salario` decimal(10,2) NOT NULL,
  `fecha_contratacion` datetime DEFAULT NULL,
  `cod_persona` int DEFAULT NULL,
  `cod_departamento_empresa` int DEFAULT NULL,
  PRIMARY KEY (`cod_empleado`),
  KEY `cod_persona` (`cod_persona`),
  KEY `cod_departamento_empresa` (`cod_departamento_empresa`),
  CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`cod_departamento_empresa`) REFERENCES `departamento_empresa` (`cod_departamento_empresa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (6,'Admin total',95000.00,'2025-05-07 00:00:00',6,1),(7,'Coordinador de Eventos',22000.00,'2025-06-07 00:00:00',10,2),(8,'Técnico audiovisual',16000.00,'2025-06-10 00:00:00',14,2),(9,'La Bonita del Grupo',89000.00,'2025-06-18 00:00:00',38,2),(10,'The Best',56897.00,'2024-12-25 00:00:00',39,3),(11,'Técnico audiovisual',15000.00,'2025-06-10 00:00:00',40,1),(12,'La Bonita del Grupo',23451.00,'2025-06-18 00:00:00',41,2),(13,'Técnico audiovisual',15000.00,'2025-06-10 00:00:00',46,1),(14,'solo se que ya no',12000.00,'2024-10-09 00:00:00',47,2),(15,'Barcelona',12345.00,'2025-02-12 00:00:00',49,1),(16,'probando valiaaciones',89999.00,'2025-03-04 00:00:00',50,1),(17,'Jefe Inmediato',30900.00,'2025-06-18 00:00:00',53,2),(18,'Jefe del Mejor',90000.00,'2004-12-27 00:00:00',54,1),(19,'Jefe Inmediato',5454.00,'2025-01-08 00:00:00',56,2),(20,'Coordinador de Eventos',23000.00,'2024-06-12 00:00:00',57,1),(21,'informatica',10000.00,'2025-06-16 00:00:00',58,1),(22,'guapo',23888.00,'2025-06-26 00:00:00',59,2),(23,'Jefe Departamento',456000.00,'2025-06-25 00:00:00',60,1),(24,'Coordinador de Eventos',22000.00,'2025-06-11 00:00:00',61,1),(25,'miguel el guapo',34873.00,'2025-06-18 00:00:00',62,1);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entradas`
--

DROP TABLE IF EXISTS `entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entradas` (
  `cod_entrada` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cod_entrada`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradas`
--

LOCK TABLES `entradas` WRITE;
/*!40000 ALTER TABLE `entradas` DISABLE KEYS */;
INSERT INTO `entradas` VALUES (1,'Entrada General funciona',150.00),(3,'myke mejor',1234.00),(4,'jhsdahjsad',3432.00);
/*!40000 ALTER TABLE `entradas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `cod_evento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `fecha_programa` date NOT NULL,
  `hora_programada` time NOT NULL,
  `cod_cotizacion` int NOT NULL,
  PRIMARY KEY (`cod_evento`),
  KEY `cod_cotizacion` (`cod_cotizacion`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`cod_cotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (2,'Cumpleaños de Sofía','2025-07-10','15:30:00',2),(3,'Cumpleos de Sofía','2025-07-10','15:30:00',3),(4,'Evento Educativo','2025-07-01','09:30:00',4),(5,'Cum de Sofía','2025-07-10','19:30:00',5),(11,'ya que se poner','2025-06-17','22:22:00',11),(12,'probado alertas','2025-06-16','21:29:00',12),(13,'alertas si?','2025-06-15','23:39:00',13),(14,'Cum de Sofía','2025-07-10','19:30:00',14),(16,'dfsdcdsvd','2025-06-09','22:45:00',16),(18,'probando con todos','2025-06-25','17:31:00',18),(19,'zungas','2025-06-25','22:05:00',19);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `cod_factura` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(30) NOT NULL,
  `fecha_emision` date NOT NULL,
  `cod_cliente` int NOT NULL,
  `direccion` text NOT NULL,
  `rtn` varchar(20) DEFAULT NULL,
  `cod_cai` int NOT NULL,
  `rango_desde` varchar(25) DEFAULT NULL,
  `rango_hasta` varchar(25) DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `tipo_factura` enum('Evento','Recorrido Escolar','Taquilla General','Libros') NOT NULL,
  `descuento_otorgado` decimal(10,2) DEFAULT '0.00',
  `rebajas_otorgadas` decimal(10,2) DEFAULT '0.00',
  `importe_exento` decimal(10,2) DEFAULT '0.00',
  `importe_gravado_18` decimal(10,2) DEFAULT '0.00',
  `importe_gravado_15` decimal(10,2) DEFAULT '0.00',
  `impuesto_15` decimal(10,2) DEFAULT '0.00',
  `impuesto_18` decimal(10,2) DEFAULT '0.00',
  `importe_exonerado` decimal(10,2) DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `total_pago` decimal(10,2) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`cod_factura`),
  UNIQUE KEY `numero_factura` (`numero_factura`),
  KEY `cod_cliente` (`cod_cliente`),
  KEY `cod_cai` (`cod_cai`),
  CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`cod_cai`) REFERENCES `cai` (`cod_cai`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventario` (
  `cod_inventario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad_disponible` int NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`cod_inventario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (2,'Laptop Gamer Actualizada','Asus ROG Strix 2025',1599.99,13,0);
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipios`
--

DROP TABLE IF EXISTS `municipios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `municipios` (
  `cod_municipio` int NOT NULL AUTO_INCREMENT,
  `municipio` varchar(60) NOT NULL,
  `cod_departamento` int DEFAULT NULL,
  PRIMARY KEY (`cod_municipio`),
  KEY `cod_departamento` (`cod_departamento`),
  CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`cod_departamento`) REFERENCES `departamentos` (`cod_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipios`
--

LOCK TABLES `municipios` WRITE;
/*!40000 ALTER TABLE `municipios` DISABLE KEYS */;
INSERT INTO `municipios` VALUES (1,'La Ceiba',1),(2,'El Porvenir',1),(3,'Tela',1),(4,'Jutiapa',1),(5,'La Masica',1),(6,'San Francisco',1),(7,'Arizona',1),(8,'Esparta',1),(9,'Choluteca',2),(10,'Apacilagua',2),(11,'Concepción de María',2),(12,'Duyure',2),(13,'El Corpus',2),(14,'El Triunfo',2),(15,'Marcovia',2),(16,'Morolica',2),(17,'Namasigüe',2),(18,'Orocuina',2),(19,'Pespire',2),(20,'San Antonio de Flores',2),(21,'San Isidro',2),(22,'San José',2),(23,'San Marcos de Colón',2),(24,'Santa Ana de Yusguare',2),(25,'Trujillo',3),(26,'Balfate',3),(27,'Iriona',3),(28,'Limón',3),(29,'Sabá',3),(30,'Santa Fe',3),(31,'Santa Rosa de Aguán',3),(32,'Sonaguera',3),(33,'Tocoa',3),(34,'Bonito Oriental',3),(35,'Comayagua',4),(36,'Ajuterique',4),(37,'El Rosario',4),(38,'Esquías',4),(39,'Humuya',4),(40,'La Libertad',4),(41,'Lamaní',4),(42,'La Trinidad',4),(43,'Lejamaní',4),(44,'Meámbar',4),(45,'Minas de Oro',4),(46,'Ojos de Agua',4),(47,'San Jerónimo',4),(48,'San José de Comayagua',4),(49,'San José del Potrero',4),(50,'San Luis',4),(51,'San Sebastián',4),(52,'Siguatepeque',4),(53,'Villa de San Antonio',4),(54,'Las Lajas',4),(55,'Taulabé',4),(56,'Santa Rosa de Copán',5),(57,'Cabañas',5),(58,'Concepción',5),(59,'Copán Ruinas',5),(60,'Corquín',5),(61,'Cucuyagua',5),(62,'Dolores',5),(63,'Dulce Nombre',5),(64,'El Paraíso',5),(65,'Florida',5),(66,'La Jigua',5),(67,'La Unión',5),(68,'Nueva Arcadia',5),(69,'San Agustín',5),(70,'San Antonio',5),(71,'San Jerónimo',5),(72,'San José',5),(73,'San Juan de Opoa',5),(74,'San Nicolás',5),(75,'San Pedro',5),(76,'Santa Rita',5),(77,'Trinidad de Copán',5),(78,'Veracruz',5),(79,'San Pedro Sula',6),(80,'Choloma',6),(81,'Omoa',6),(82,'Pimienta',6),(83,'Potrerillos',6),(84,'Puerto Cortés',6),(85,'San Antonio de Cortés',6),(86,'San Francisco de Yojoa',6),(87,'San Manuel',6),(88,'Santa Cruz de Yojoa',6),(89,'Villanueva',6),(90,'La Lima',6),(91,'Yuscarán',7),(92,'Alauca',7),(93,'Danlí',7),(94,'El Paraíso',7),(95,'Güinope',7),(96,'Jacaleapa',7),(97,'Liure',7),(98,'Morocelí',7),(99,'Oropolí',7),(100,'Potrerillos',7),(101,'San Antonio de Flores',7),(102,'San Lucas',7),(103,'San Matías',7),(104,'Soledad',7),(105,'Teupasenti',7),(106,'Texiguat',7),(107,'Vado Ancho',7),(108,'Yauyupe',7),(109,'Trojes',7),(110,'Distrito Central',8),(111,'Alubarén',8),(112,'Cedros',8),(113,'Curarén',8),(114,'El Porvenir',8),(115,'Guaimaca',8),(116,'La Libertad',8),(117,'La Venta',8),(118,'Lepaterique',8),(119,'Maraita',8),(120,'Marale',8),(121,'Nueva Armenia',8),(122,'Ojojona',8),(123,'Orica',8),(124,'Reitoca',8),(125,'Sabanagrande',8),(126,'San Antonio de Oriente',8),(127,'San Buenaventura',8),(128,'San Ignacio',8),(129,'Cantarranas',8),(130,'San Miguelito',8),(131,'Santa Ana',8),(132,'Santa Lucía',8),(133,'Talanga',8),(134,'Tatumbla',8),(135,'Valle de Ángeles',8),(136,'Villa de San Francisco',8),(137,'Vallecillo',8),(138,'Puerto Lempira',9),(139,'Brus Laguna',9),(140,'Ahuas',9),(141,'Juan Francisco Bulnes',9),(142,'Villeda Morales',9),(143,'Wampusirpe',9),(144,'La Esperanza',10),(145,'Camasca',10),(146,'Colomoncagua',10),(147,'Concepción',10),(148,'Dolores',10),(149,'Intibucá',10),(150,'Jesús de Otoro',10),(151,'Magdalena',10),(152,'Masaguara',10),(153,'San Antonio',10),(154,'San Isidro',10),(155,'San Juan',10),(156,'San Marcos de la Sierra',10),(157,'San Miguel Guancapla',10),(158,'Santa Lucía',10),(159,'Yamaranguila',10),(160,'San Francisco de Opalaca',10),(161,'Roatán',11),(162,'Guanaja',11),(163,'José Santos Guardiola',11),(164,'Utila',11),(165,'La Paz',12),(166,'Aguanqueterique',12),(167,'Cabañas',12),(168,'Cane',12),(169,'Chinacla',12),(170,'Guajiquiro',12),(171,'Lauterique',12),(172,'Marcala',12),(173,'Mercedes de Oriente',12),(174,'Opatoro',12),(175,'San Antonio del Norte',12),(176,'San José',12),(177,'San Juan',12),(178,'San Pedro de Tutule',12),(179,'Santa Ana',12),(180,'Santa Elena',12),(181,'Santa María',12),(182,'Santiago de Puringla',12),(183,'Yarula',12),(184,'Gracias',13),(185,'Belén',13),(186,'Candelaria',13),(187,'Cololaca',13),(188,'Erandique',13),(189,'Gualcince',13),(190,'Guarita',13),(191,'La Campa',13),(192,'La Iguala',13),(193,'Las Flores',13),(194,'La Unión',13),(195,'La Virtud',13),(196,'Lepaera',13),(197,'Mapulaca',13),(198,'Piraera',13),(199,'San Andrés',13),(200,'San Francisco',13),(201,'San Juan Guarita',13),(202,'San Manuel Colohete',13),(203,'San Rafael',13),(204,'San Sebastián',13),(205,'Santa Cruz',13),(206,'Talgua',13),(207,'Tambla',13),(208,'Tomalá',13),(209,'Valladolid',13),(210,'Virginia',13),(211,'San Marcos de Caiquín',13),(212,'Ocotepeque',14),(213,'Belén Gualcho',14),(214,'Concepción',14),(215,'Dolores Merendón',14),(216,'Fraternidad',14),(217,'La Encarnación',14),(218,'La Labor',14),(219,'Lucerna',14),(220,'Mercedes',14),(221,'San Fernando',14),(222,'San Francisco del Valle',14),(223,'San Jorge',14),(224,'San Marcos',14),(225,'Santa Fe',14),(226,'Sensenti',14),(227,'Sinuapa',14),(228,'Juticalpa',15),(229,'Campamento',15),(230,'Catacamas',15),(231,'Concordia',15),(232,'Dulce Nombre de Culmí',15),(233,'El Rosario',15),(234,'Esquipulas del Norte',15),(235,'Gualaco',15),(236,'Guarizama',15),(237,'Guata',15),(238,'Guayape',15),(239,'Jano',15),(240,'La Unión',15),(241,'Mangulile',15),(242,'Manto',15),(243,'Salamá',15),(244,'San Esteban',15),(245,'San Francisco de Becerra',15),(246,'San Francisco de la Paz',15),(247,'Santa María del Real',15),(248,'Silca',15),(249,'Yocón',15),(250,'Patuca',15),(251,'Santa Bárbara',16),(252,'Arada',16),(253,'Atima',16),(254,'Azacualpa',16),(255,'Ceguaca',16),(256,'Concepción del Norte',16),(257,'Concepción del Sur',16),(258,'Chinda',16),(259,'El Níspero',16),(260,'Gualala',16),(261,'Ilama',16),(262,'Las Vegas',16),(263,'Macuelizo',16),(264,'Naranjito',16),(265,'Nuevo Celilac',16),(266,'Nueva Frontera',16),(267,'Petoa',16),(268,'Protección',16),(269,'Quimistán',16),(270,'San Francisco de Ojuera',16),(271,'San José de las Colinas',16),(272,'San Luis',16),(273,'San Marcos',16),(274,'San Nicolás',16),(275,'San Pedro Zacapa',16),(276,'San Vicente Centenario',16),(277,'Santa Rita',16),(278,'Trinidad',16),(279,'Nacaome',17),(280,'Alianza',17),(281,'Amapala',17),(282,'Aramecina',17),(283,'Caridad',17),(284,'Goascorán',17),(285,'Langue',17),(286,'San Francisco de Coray',17),(287,'San Lorenzo',17),(288,'Yoro',18),(289,'Arenal',18),(290,'El Negrito',18),(291,'El Progreso',18),(292,'Jocón',18),(293,'Morazán',18),(294,'Olanchito',18),(295,'Santa Rita',18),(296,'Sulaco',18),(297,'Victoria',18),(298,'Yorito',18);
/*!40000 ALTER TABLE `municipios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objetos`
--

DROP TABLE IF EXISTS `objetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `objetos` (
  `cod_objeto` int NOT NULL AUTO_INCREMENT,
  `tipo_objeto` varchar(50) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`cod_objeto`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objetos`
--

LOCK TABLES `objetos` WRITE;
/*!40000 ALTER TABLE `objetos` DISABLE KEYS */;
INSERT INTO `objetos` VALUES (1,'Pantalla Empleados','Gestión de empleados'),(2,'Pantalla Productos','Gestión de productos'),(3,'Pantalla Salones','Gestión de salones'),(4,'Pantalla Cotización','Gestión de cotizaciones'),(5,'Pantalla Reservación','Gestión de reservaciones'),(6,'Pantalla Eventos','Facturación de eventos'),(7,'Pantalla Entradas','Facturación de entradas generales'),(8,'Pantalla Seguridad','Panel de administración'),(9,'Pantalla CAI','Gestión de CAI'),(10,'Pantalla Bitácora','Bitácora del sistema'),(11,'Pantalla Clientes','Gestión de clientes'),(12,'Pantalla Escolares','Gestión de recorridos escolares'),(13,'Pantalla Backup','Gestión de Backup'),(17,'solo le puse 30','hola soy las pruebas'),(18,'soy el mejor','pero me falta un poco'),(19,'probadno csosas','sirve?'),(20,'editar empleado','Gestión de empleados');
/*!40000 ALTER TABLE `objetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paquetes`
--

DROP TABLE IF EXISTS `paquetes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paquetes` (
  `cod_paquete` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cod_paquete`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paquetes`
--

LOCK TABLES `paquetes` WRITE;
/*!40000 ALTER TABLE `paquetes` DISABLE KEYS */;
INSERT INTO `paquetes` VALUES (1,'Paquete VIP Actualizado','Incluye acceso VIP, catering de lujo, transporte y hospedaje',3800.00);
/*!40000 ALTER TABLE `paquetes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `cod_permiso` int NOT NULL AUTO_INCREMENT,
  `cod_rol` int DEFAULT NULL,
  `cod_objeto` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `crear` tinyint(1) DEFAULT '0',
  `modificar` tinyint(1) DEFAULT '0',
  `mostrar` tinyint(1) DEFAULT '0',
  `eliminar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cod_permiso`),
  KEY `cod_rol` (`cod_rol`),
  KEY `cod_objeto` (`cod_objeto`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`cod_rol`) REFERENCES `roles` (`cod_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`cod_objeto`) REFERENCES `objetos` (`cod_objeto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,1,4,'Acceso total a Gestión de empleados',1,1,1,1),(2,1,2,'Acceso total a Gestión de productos',1,1,1,1),(3,1,3,'Acceso total a Gestión de salones probandoo',1,1,1,1),(4,1,4,'Acceso total a Gestión de cotizaciones',1,1,1,1),(5,1,5,'Acceso total a Gestión de reservaciones',1,1,1,1),(6,1,6,'Acceso total a Facturación de eventos',1,1,1,1),(7,1,7,'Acceso total a Facturación de entradas generales',1,1,1,1),(9,1,9,'Acceso total a Gestión de CAI',1,1,1,1),(10,1,10,'Acceso total a Bitácora del sistema',1,1,1,1),(17,1,1,'Gestión de productos',1,1,1,1),(18,4,3,'Gestión de salones',1,1,1,1),(19,4,4,'Gestión de cotizaciones',1,1,1,1),(20,4,5,'Gestión de reservaciones',1,1,1,1),(23,9,5,'Permiso actualizado por myke',1,0,1,1),(25,1,11,'Acceso total a Gestión de clientes',1,1,1,1),(26,1,12,'Acceso total a Gestión de recorridos escolares',1,1,1,1),(27,1,8,'Acceso total al Panel de administración',1,1,1,1),(28,1,13,'Acceso total a Gestión de Backup',1,1,1,1),(31,4,5,'UNA PRUEVA MAS',1,1,1,1),(33,1,12,'SDIJFSDFHISFDHISDFHIHSDFHIFSD',1,1,1,1),(37,2,1,'probando cosas',1,1,1,0);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas` (
  `cod_persona` int NOT NULL AUTO_INCREMENT,
  `nombre_persona` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod_persona`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (6,'Miguel García sirve plox','2025-05-15','Masculino','0801890021222'),(7,'Carlos Mendoza actualizado 09','1990-12-05','Masculino','0801199012345'),(10,'Carlos Riveras','1992-03-20','Masculino','08011'),(14,'Javier Salgado si paso la prue','1990-06-15','Masculino','5674625387985'),(16,'Juan Pérez','1990-06-15','Masculino','0801199912345'),(17,'probanddo api','1990-06-15','Masculino','080912345'),(21,'Camila García','1995-08-12','Femenino','0801199512345'),(26,'probando el tipo','9999-06-15','Masculino','080120032341'),(32,'probando la vista','2002-02-07','Masculino','080120222222'),(33,'probando sweetalert2','2001-12-31','Masculino','08103421'),(34,'miguel barahona','2008-01-29','Masculino','08102345'),(35,'probando el tipo rsultad','9999-06-15','Masculino','333332341'),(37,'probando la vista','2001-06-05','Masculino','080120031345'),(38,'kellyn Castillo','1996-05-05','Masculino','08190121'),(39,'Admin Lord','1997-01-07','Masculino','080120259801'),(40,'prueba actualizacion','1990-06-15','Masculino','89129011000'),(41,'kellyn Castillo','2003-06-09','Masculino','6754333'),(46,'probando api','1990-06-15','Masculino','12098211221'),(47,'ya se jodio','2024-11-12','Masculino','65782129876'),(49,'funxiona siono','2007-01-30','Masculino','2345232314151'),(50,'Ultima prueba','2001-02-14','Masculino','6532653265236'),(52,'si funciono','1995-02-15','Masculino','2342353'),(53,'sirve','2005-02-14','Femenino','7628271611111'),(54,'Miguel Garcia','1997-01-13','Masculino','6654437777777'),(55,'sdhaudasdu','2009-02-03','Masculino','796865432'),(56,'Carlos Riveras','2025-06-03','Masculino','5555555555555'),(57,'Prueba Primer Ingreso','2006-02-14','Masculino','2342211111111'),(58,'Moises Ucles','2001-11-10','Masculino','0820200011123'),(59,'hola mundo','2025-06-03','Masculino','5634333333333'),(60,'probando ocultar','2024-01-10','Masculino','6533883838383'),(61,'kellyn Castillo','1995-01-31','Masculino','3455555555555'),(62,'probando campos ocultos','2025-06-12','Masculino','3435345345345');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `cod_rol` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`cod_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Dirección','probando api con laravel',1),(2,'FacEL','jdjhfgjgfhgg',1),(3,'Escolar','funciono o me mintio',1),(4,'Evento','si funciona o que',0),(5,'Factaquilla',NULL,1),(8,'Myke_pros','Es el mejor programando, la real.',1),(9,'ADMON Reservas','NUEVO PERMISO.',0),(11,'Ya no esta en Duro','JAJAJAJJAA sera que si sirve?',1),(13,'que paso soy el mejor','brrrrrrr si soy bueno',0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salon_horario`
--

DROP TABLE IF EXISTS `salon_horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salon_horario` (
  `cod_salon_horario` int NOT NULL AUTO_INCREMENT,
  `cod_salon` int DEFAULT NULL,
  `cod_tipo_horario` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio_hora_extra` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cod_salon_horario`),
  KEY `cod_salon` (`cod_salon`),
  KEY `fk_tipo_horario` (`cod_tipo_horario`),
  CONSTRAINT `fk_tipo_horario` FOREIGN KEY (`cod_tipo_horario`) REFERENCES `tipo_horario` (`cod_tipo_horario`) ON DELETE CASCADE,
  CONSTRAINT `salon_horario_ibfk_1` FOREIGN KEY (`cod_salon`) REFERENCES `salones` (`cod_salon`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salon_horario`
--

LOCK TABLES `salon_horario` WRITE;
/*!40000 ALTER TABLE `salon_horario` DISABLE KEYS */;
INSERT INTO `salon_horario` VALUES (1,1,1,1300.00,100.00),(2,1,2,1380.00,150.00),(3,2,1,10000.00,1200.00),(4,2,2,16000.00,1800.00),(5,3,1,120.00,100.00),(6,3,2,180.00,150.00),(7,4,1,1800.00,200.00),(8,4,2,2070.00,300.00),(11,6,1,1100.00,800.00),(12,6,2,1265.00,900.00),(13,7,1,800.00,87.00),(14,7,2,920.00,200.00),(15,8,1,100.00,80.00),(16,8,2,150.00,355.00);
/*!40000 ALTER TABLE `salon_horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salones`
--

DROP TABLE IF EXISTS `salones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salones` (
  `cod_salon` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `capacidad` int DEFAULT NULL,
  `estado` tinyint DEFAULT '1',
  PRIMARY KEY (`cod_salon`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salones`
--

LOCK TABLES `salones` WRITE;
/*!40000 ALTER TABLE `salones` DISABLE KEYS */;
INSERT INTO `salones` VALUES (1,'Plaza Cultural','Área abierta para actividades culturales.',2222,1),(2,'Salón VIP Gold','Salón remodelado con barra premium',400,0),(3,'Salón VIP','Salón remodelado con capacidad para 300 personas.',300,1),(4,'Auditorio Central','Auditorio techado con escenario y sonido.',120,1),(6,'Salón VIP','Interior con aire acondicionado y mobiliario moderno.',35,1),(7,'Salón Creativo','Espacio interior ideal para talleres educativos.',50,1),(8,'Salón Principal','Salón amplio con capacidad para 500 personas.',500,1);
/*!40000 ALTER TABLE `salones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('D3KrBVEjdpovfmR0wsiH8tk8Ex4wpg6FZjwWx1fA',NULL,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36 Edg/137.0.0.0','YTo2OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWU5nUkhjUklxN3o3WVpIbVRFR0JTUHNtSzQybUxSNEhlSTNzR0FoYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jb3RpemFjaW9uZXMiO31zOjg6InBlcm1pc29zIjthOjE1OntpOjA7YTo1OntzOjY6Im9iamV0byI7czoyNDoiR2VzdGnDs24gZGUgY290aXphY2lvbmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aToxO2E6NTp7czo2OiJvYmpldG8iO3M6MjE6Ikdlc3Rpw7NuIGRlIHByb2R1Y3RvcyI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6MjthOjU6e3M6Njoib2JqZXRvIjtzOjE5OiJHZXN0acOzbiBkZSBzYWxvbmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTozO2E6NTp7czo2OiJvYmpldG8iO3M6MjQ6Ikdlc3Rpw7NuIGRlIGNvdGl6YWNpb25lcyI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6NDthOjU6e3M6Njoib2JqZXRvIjtzOjI1OiJHZXN0acOzbiBkZSByZXNlcnZhY2lvbmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTo1O2E6NTp7czo2OiJvYmpldG8iO3M6MjM6IkZhY3R1cmFjacOzbiBkZSBldmVudG9zIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTo2O2E6NTp7czo2OiJvYmpldG8iO3M6MzQ6IkZhY3R1cmFjacOzbiBkZSBlbnRyYWRhcyBnZW5lcmFsZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjc7YTo1OntzOjY6Im9iamV0byI7czoxNToiR2VzdGnDs24gZGUgQ0FJIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTo4O2E6NTp7czo2OiJvYmpldG8iO3M6MjE6IkJpdMOhY29yYSBkZWwgc2lzdGVtYSI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6OTthOjU6e3M6Njoib2JqZXRvIjtzOjIxOiJHZXN0acOzbiBkZSBlbXBsZWFkb3MiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjEwO2E6NTp7czo2OiJvYmpldG8iO3M6MjA6Ikdlc3Rpw7NuIGRlIGNsaWVudGVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aToxMTthOjU6e3M6Njoib2JqZXRvIjtzOjMyOiJHZXN0acOzbiBkZSByZWNvcnJpZG9zIGVzY29sYXJlcyI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6MTI7YTo1OntzOjY6Im9iamV0byI7czoyNDoiUGFuZWwgZGUgYWRtaW5pc3RyYWNpw7NuIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aToxMzthOjU6e3M6Njoib2JqZXRvIjtzOjE4OiJHZXN0acOzbiBkZSBCYWNrdXAiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjE0O2E6NTp7czo2OiJvYmpldG8iO3M6MzI6Ikdlc3Rpw7NuIGRlIHJlY29ycmlkb3MgZXNjb2xhcmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9fXM6NToidG9rZW4iO3M6MjE0MDoiZXlKaGJHY2lPaUpJVXpJMU5pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiMlJmZFhOMVlYSnBieUk2SWpFaUxDSndaWEp0YVhOdmN5STZXM3NpYjJKcVpYUnZJam9pUjJWemRHbkRzMjRnWkdVZ1kyOTBhWHBoWTJsdmJtVnpJaXdpWTNKbFlYSWlPblJ5ZFdVc0ltMXZaR2xtYVdOaGNpSTZkSEoxWlN3aWJXOXpkSEpoY2lJNmRISjFaU3dpWld4cGJXbHVZWElpT25SeWRXVjlMSHNpYjJKcVpYUnZJam9pUjJWemRHbkRzMjRnWkdVZ2NISnZaSFZqZEc5eklpd2lZM0psWVhJaU9uUnlkV1VzSW0xdlpHbG1hV05oY2lJNmRISjFaU3dpYlc5emRISmhjaUk2ZEhKMVpTd2laV3hwYldsdVlYSWlPblJ5ZFdWOUxIc2liMkpxWlhSdklqb2lSMlZ6ZEduRHMyNGdaR1VnYzJGc2IyNWxjeUlzSW1OeVpXRnlJanAwY25WbExDSnRiMlJwWm1sallYSWlPblJ5ZFdVc0ltMXZjM1J5WVhJaU9uUnlkV1VzSW1Wc2FXMXBibUZ5SWpwMGNuVmxmU3g3SW05aWFtVjBieUk2SWtkbGMzUnB3N051SUdSbElHTnZkR2w2WVdOcGIyNWxjeUlzSW1OeVpXRnlJanAwY25WbExDSnRiMlJwWm1sallYSWlPblJ5ZFdVc0ltMXZjM1J5WVhJaU9uUnlkV1VzSW1Wc2FXMXBibUZ5SWpwMGNuVmxmU3g3SW05aWFtVjBieUk2SWtkbGMzUnB3N051SUdSbElISmxjMlZ5ZG1GamFXOXVaWE1pTENKamNtVmhjaUk2ZEhKMVpTd2liVzlrYVdacFkyRnlJanAwY25WbExDSnRiM04wY21GeUlqcDBjblZsTENKbGJHbHRhVzVoY2lJNmRISjFaWDBzZXlKdlltcGxkRzhpT2lKR1lXTjBkWEpoWTJuRHMyNGdaR1VnWlhabGJuUnZjeUlzSW1OeVpXRnlJanAwY25WbExDSnRiMlJwWm1sallYSWlPblJ5ZFdVc0ltMXZjM1J5WVhJaU9uUnlkV1VzSW1Wc2FXMXBibUZ5SWpwMGNuVmxmU3g3SW05aWFtVjBieUk2SWtaaFkzUjFjbUZqYWNPemJpQmtaU0JsYm5SeVlXUmhjeUJuWlc1bGNtRnNaWE1pTENKamNtVmhjaUk2ZEhKMVpTd2liVzlrYVdacFkyRnlJanAwY25WbExDSnRiM04wY21GeUlqcDBjblZsTENKbGJHbHRhVzVoY2lJNmRISjFaWDBzZXlKdlltcGxkRzhpT2lKSFpYTjBhY096YmlCa1pTQkRRVWtpTENKamNtVmhjaUk2ZEhKMVpTd2liVzlrYVdacFkyRnlJanAwY25WbExDSnRiM04wY21GeUlqcDBjblZsTENKbGJHbHRhVzVoY2lJNmRISjFaWDBzZXlKdlltcGxkRzhpT2lKQ2FYVERvV052Y21FZ1pHVnNJSE5wYzNSbGJXRWlMQ0pqY21WaGNpSTZkSEoxWlN3aWJXOWthV1pwWTJGeUlqcDBjblZsTENKdGIzTjBjbUZ5SWpwMGNuVmxMQ0psYkdsdGFXNWhjaUk2ZEhKMVpYMHNleUp2WW1wbGRHOGlPaUpIWlhOMGFjT3piaUJrWlNCbGJYQnNaV0ZrYjNNaUxDSmpjbVZoY2lJNmRISjFaU3dpYlc5a2FXWnBZMkZ5SWpwMGNuVmxMQ0p0YjNOMGNtRnlJanAwY25WbExDSmxiR2x0YVc1aGNpSTZkSEoxWlgwc2V5SnZZbXBsZEc4aU9pSkhaWE4wYWNPemJpQmtaU0JqYkdsbGJuUmxjeUlzSW1OeVpXRnlJanAwY25WbExDSnRiMlJwWm1sallYSWlPblJ5ZFdVc0ltMXZjM1J5WVhJaU9uUnlkV1VzSW1Wc2FXMXBibUZ5SWpwMGNuVmxmU3g3SW05aWFtVjBieUk2SWtkbGMzUnB3N051SUdSbElISmxZMjl5Y21sa2IzTWdaWE5qYjJ4aGNtVnpJaXdpWTNKbFlYSWlPblJ5ZFdVc0ltMXZaR2xtYVdOaGNpSTZkSEoxWlN3aWJXOXpkSEpoY2lJNmRISjFaU3dpWld4cGJXbHVZWElpT25SeWRXVjlMSHNpYjJKcVpYUnZJam9pVUdGdVpXd2daR1VnWVdSdGFXNXBjM1J5WVdOcHc3TnVJaXdpWTNKbFlYSWlPblJ5ZFdVc0ltMXZaR2xtYVdOaGNpSTZkSEoxWlN3aWJXOXpkSEpoY2lJNmRISjFaU3dpWld4cGJXbHVZWElpT25SeWRXVjlMSHNpYjJKcVpYUnZJam9pUjJWemRHbkRzMjRnWkdVZ1FtRmphM1Z3SWl3aVkzSmxZWElpT25SeWRXVXNJbTF2WkdsbWFXTmhjaUk2ZEhKMVpTd2liVzl6ZEhKaGNpSTZkSEoxWlN3aVpXeHBiV2x1WVhJaU9uUnlkV1Y5TEhzaWIySnFaWFJ2SWpvaVIyVnpkR25EczI0Z1pHVWdjbVZqYjNKeWFXUnZjeUJsYzJOdmJHRnlaWE1pTENKamNtVmhjaUk2ZEhKMVpTd2liVzlrYVdacFkyRnlJanAwY25WbExDSnRiM04wY21GeUlqcDBjblZsTENKbGJHbHRhVzVoY2lJNmRISjFaWDFkTENKcFlYUWlPakUzTlRBNE56QTVOek1zSW1WNGNDSTZNVGMxTURnM05EVTNNMzAuVF9BUS1EaWhiVVc2Njl1enJ4M2FfcUhpZHBPMXE4Tm5ZMHM2MHdSNTMxNCI7czo3OiJ1c3VhcmlvIjthOjU6e3M6MTE6ImNvZF91c3VhcmlvIjtpOjE7czoxNDoibm9tYnJlX3VzdWFyaW8iO3M6OToienVuZ2EuaGNoIjtzOjEzOiJwcmltZXJfYWNjZXNvIjtpOjA7czozOiJyb2wiO3M6MTA6IkRpcmVjY2nDs24iO3M6ODoicGVybWlzb3MiO2E6MTU6e2k6MDthOjU6e3M6Njoib2JqZXRvIjtzOjI0OiJHZXN0acOzbiBkZSBjb3RpemFjaW9uZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjE7YTo1OntzOjY6Im9iamV0byI7czoyMToiR2VzdGnDs24gZGUgcHJvZHVjdG9zIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aToyO2E6NTp7czo2OiJvYmpldG8iO3M6MTk6Ikdlc3Rpw7NuIGRlIHNhbG9uZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjM7YTo1OntzOjY6Im9iamV0byI7czoyNDoiR2VzdGnDs24gZGUgY290aXphY2lvbmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTo0O2E6NTp7czo2OiJvYmpldG8iO3M6MjU6Ikdlc3Rpw7NuIGRlIHJlc2VydmFjaW9uZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjU7YTo1OntzOjY6Im9iamV0byI7czoyMzoiRmFjdHVyYWNpw7NuIGRlIGV2ZW50b3MiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjY7YTo1OntzOjY6Im9iamV0byI7czozNDoiRmFjdHVyYWNpw7NuIGRlIGVudHJhZGFzIGdlbmVyYWxlcyI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6NzthOjU6e3M6Njoib2JqZXRvIjtzOjE1OiJHZXN0acOzbiBkZSBDQUkiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjg7YTo1OntzOjY6Im9iamV0byI7czoyMToiQml0w6Fjb3JhIGRlbCBzaXN0ZW1hIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aTo5O2E6NTp7czo2OiJvYmpldG8iO3M6MjE6Ikdlc3Rpw7NuIGRlIGVtcGxlYWRvcyI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6MTA7YTo1OntzOjY6Im9iamV0byI7czoyMDoiR2VzdGnDs24gZGUgY2xpZW50ZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjExO2E6NTp7czo2OiJvYmpldG8iO3M6MzI6Ikdlc3Rpw7NuIGRlIHJlY29ycmlkb3MgZXNjb2xhcmVzIjtzOjg6Imluc2VydGFyIjtiOjE7czoxMDoiYWN0dWFsaXphciI7YjoxO3M6NzoibW9zdHJhciI7YjoxO3M6ODoiZWxpbWluYXIiO2I6MTt9aToxMjthOjU6e3M6Njoib2JqZXRvIjtzOjI0OiJQYW5lbCBkZSBhZG1pbmlzdHJhY2nDs24iO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO31pOjEzO2E6NTp7czo2OiJvYmpldG8iO3M6MTg6Ikdlc3Rpw7NuIGRlIEJhY2t1cCI7czo4OiJpbnNlcnRhciI7YjoxO3M6MTA6ImFjdHVhbGl6YXIiO2I6MTtzOjc6Im1vc3RyYXIiO2I6MTtzOjg6ImVsaW1pbmFyIjtiOjE7fWk6MTQ7YTo1OntzOjY6Im9iamV0byI7czozMjoiR2VzdGnDs24gZGUgcmVjb3JyaWRvcyBlc2NvbGFyZXMiO3M6ODoiaW5zZXJ0YXIiO2I6MTtzOjEwOiJhY3R1YWxpemFyIjtiOjE7czo3OiJtb3N0cmFyIjtiOjE7czo4OiJlbGltaW5hciI7YjoxO319fX0=',1750874806),('TAN9eF9YxfbtOCYTr4FXilBewrbBR6D2e3t4zX6u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzVXaDdnMHlFNE1Hd3RzWlRKRG1vVG1wS3FveHlBRnNiRkZMVHlpRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=',1750871695),('uBD87f7vSnI22dqsSg0uhIKoOSVOWHcYj7INkFoa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT3dkaEdvbVlxQ0FJb1lsZ1ZBWmZkUkVWY1l6VFFPYUkyUGpmTW5aZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXQtc2Vzc2lvbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NzoidXN1YXJpbyI7czo0OiJNaWtlIjtzOjU6InRva2VuIjtzOjY6ImFiYzEyMyI7fQ==',1750866987);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefonos`
--

DROP TABLE IF EXISTS `telefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefonos` (
  `cod_telefono` int NOT NULL AUTO_INCREMENT,
  `telefono` varchar(20) DEFAULT NULL,
  `cod_persona` int DEFAULT NULL,
  PRIMARY KEY (`cod_telefono`),
  KEY `cod_persona` (`cod_persona`),
  CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefonos`
--

LOCK TABLES `telefonos` WRITE;
/*!40000 ALTER TABLE `telefonos` DISABLE KEYS */;
INSERT INTO `telefonos` VALUES (6,'97497264',6),(7,'99998888',7),(8,'99887766',10),(9,'98765432',14),(11,'98761234',16),(12,'987234',17),(13,'88889999',21),(14,'987234',26),(20,'54634223',32),(21,'88689857',33),(22,'4354543',34),(23,'987234',35),(25,'8868574',37),(26,'67543234',38),(27,'6789999',39),(28,'98765432',40),(29,'23223277',41),(33,'98765432',46),(34,'56756433',47),(35,'67676767',49),(36,'63643563',50),(38,'353345',52),(39,'87436733',53),(40,'65343344',54),(41,'55665566',55),(42,'55665566',56),(43,'54354534',57),(44,'12343288',58),(45,'53535333',59),(46,'67354256',60),(47,'44444444',61),(48,'65343344',62);
/*!40000 ALTER TABLE `telefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_horario`
--

DROP TABLE IF EXISTS `tipo_horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_horario` (
  `cod_tipo_horario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(23) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_horario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_horario`
--

LOCK TABLES `tipo_horario` WRITE;
/*!40000 ALTER TABLE `tipo_horario` DISABLE KEYS */;
INSERT INTO `tipo_horario` VALUES (1,'Día',NULL),(2,'Noche',NULL);
/*!40000 ALTER TABLE `tipo_horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `cod_tipo_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Interno'),(2,'Externo');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `cod_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `intentos` int DEFAULT '0',
  `cod_rol` int DEFAULT NULL,
  `cod_tipo_usuario` int NOT NULL DEFAULT '1',
  `primer_acceso` tinyint(1) DEFAULT '1',
  `ip_conexion` varchar(50) DEFAULT NULL,
  `ip_mac` varchar(50) DEFAULT NULL,
  `creado_por` varchar(50) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `token_recuperacion` varchar(64) DEFAULT NULL,
  `expira_token` datetime DEFAULT NULL,
  `cod_empleado` int DEFAULT NULL,
  PRIMARY KEY (`cod_usuario`),
  UNIQUE KEY `cod_empleado` (`cod_empleado`),
  KEY `cod_rol` (`cod_rol`),
  KEY `cod_tipo_usuario` (`cod_tipo_usuario`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cod_rol`) REFERENCES `roles` (`cod_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`cod_tipo_usuario`) REFERENCES `tipo_usuario` (`cod_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`cod_empleado`) REFERENCES `empleados` (`cod_empleado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'zunga.hch','$2b$10$G.HlDamnc6VsYeYyLH.S.eIBvVuxAfe1YdEPVaNQUEfNGMeslV4pq',1,0,1,2,0,'::1',NULL,NULL,'2025-06-06 23:38:29',NULL,NULL,6),(2,'carlosr','$2b$10$abcdefghijk1234567890ZXCvbnm',1,0,8,2,1,NULL,NULL,NULL,'2025-06-07 08:07:33',NULL,NULL,7),(3,'javiers','$2b$10$/cqTzSocLHuITxi4Cg3hwuu8D03aGr6.KTCwE3pPnfD6YBLTtQcWq',1,0,2,2,0,'::1',NULL,NULL,'2025-06-07 08:18:52',NULL,NULL,8),(4,'kellyn.castillo121','$2b$10$8hLaw3DJQ2w4iFN4JdS/NuSkh8OlKz/daiXBvT5eagrv6cQ4bVP9.',1,0,4,2,0,'::1',NULL,NULL,'2025-06-08 12:11:25',NULL,NULL,9),(5,'admin.lord801','$2b$10$Ds7zn5tJgknmQqahzMhttePYpDqFO2f8lXjtzGmWxwpFNM0OA2jQq',1,0,1,1,0,'::1',NULL,NULL,'2025-06-08 12:14:41',NULL,NULL,10),(6,'javiers','$2b$10$epNqTgUnbWtHGsqjTr49LeZysAWr3eVjI2wkRUT3B3H.DL7BGxoqm',1,0,2,2,1,NULL,NULL,NULL,'2025-06-08 12:26:11',NULL,NULL,11),(7,'kellyn.castillo333','$2b$10$HwaV2kDHQe6DlFP8gDZLEehC5iKtLL0Rlg84ldHN136MNoXBu9iFa',1,0,1,2,0,'::1',NULL,NULL,'2025-06-08 13:56:06',NULL,NULL,12),(8,'javiers','$2b$10$0BIrzFKUDcmpaC5u7onkGul4Z3FgsQCS/JI16/N9O8TDqDlvO7Dmu',1,0,1,1,1,NULL,NULL,NULL,'2025-06-14 18:45:43',NULL,NULL,13),(9,'ya.se.jodio876','$2b$10$VawRySYI2MQGGZXmPH1/NeVgZO8jiF/GYlclsGrAudGuxdikaFz1a',1,0,4,1,1,NULL,NULL,NULL,'2025-06-14 18:57:06',NULL,NULL,14),(10,'funxiona.siono151','$2b$10$fA0TPMxG5DVvEpJm1Vip2.0AmNNpW1jixhNE2W1DdtZNT2/gT4cQ6',0,0,1,1,1,NULL,NULL,NULL,'2025-06-14 19:21:16',NULL,NULL,15),(11,'ultima.prueba236','$2b$10$1NtXXe3V3adBeq7Xo2aTX.SY33OwDc1ZrOE8qKx78c/vSyIBrUy.K',1,0,1,1,1,NULL,NULL,NULL,'2025-06-14 19:40:51',NULL,NULL,16),(12,'ya.no.esta.en.duro111','$2b$10$wekg/OSzGwWtH85IXHzyW.GQyXhkoXShbeI75.frhNSQ1cdhcPyrC',0,0,8,1,1,NULL,NULL,NULL,'2025-06-20 11:07:47',NULL,NULL,17),(13,'miguel.garcia777','$2b$10$qj9WO.wciZ176gdF91i7LuP0bo5WJHb4evnmtyeKtexLojKb0ca4C',1,3,2,1,0,'::1',NULL,NULL,'2025-06-20 16:09:14',NULL,NULL,18),(14,'carlos.riveras555','$2b$10$ANkc/TXodKN1//ihsT0tZ.AU6iq.nZj8ToUdzQwKdxWs6dlmuv36q',0,0,5,1,1,NULL,NULL,NULL,'2025-06-21 11:16:47',NULL,NULL,19),(15,'prueba.primer.ingreso111','$2b$10$d6djQ9e7xeFq9Et3A7iXq.tBLdGY.dCDXNFtHehg6MwzG6/2dm1Ma',1,0,1,1,0,'::1',NULL,NULL,'2025-06-21 11:22:19',NULL,NULL,20),(16,'moises.ucles123','$2b$10$g/.soC.wA7uVSnHAUvDpN.7Vm1/yKurgoGJKZpu6pMjRcgTKA119W',1,0,1,1,0,'::1',NULL,NULL,'2025-06-16 22:08:32',NULL,NULL,21),(17,'hola.mundo333','$2b$10$.VzGHuMc9nxS3vAL5DFWPemoDYF.U9F91Oso4l7LLVX5xwqdhmh/q',1,0,8,1,1,NULL,NULL,NULL,'2025-06-23 09:35:01',NULL,NULL,22),(18,'probando.ocultar383','$2b$10$aLS.2tul9sLAHnOTU/ytEuL0VNhxD4FKPQGbAIuLKBvbeCTujePtO',1,0,1,2,1,NULL,NULL,NULL,'2025-06-23 11:00:25',NULL,NULL,23),(19,'kellyn.castillo555','$2b$10$gH97ET6fKyzixoQJ1VBi8u4ThT2LIRbfSmwcDIfo47mX/t.NH9iv.',1,0,1,1,1,NULL,NULL,NULL,'2025-06-24 00:48:46',NULL,NULL,24),(20,'probando.campos.ocultos345','$2b$10$0fMnRedH9I396xHO5/jBOe2LmiIe5X90Z7un/6B4PE6HgVLYGx1fG',1,0,1,1,1,NULL,NULL,NULL,'2025-06-24 01:07:05',NULL,NULL,25);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verificacion_2fa`
--

DROP TABLE IF EXISTS `verificacion_2fa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verificacion_2fa` (
  `cod_usuario` int NOT NULL,
  `codigo` varchar(6) DEFAULT NULL,
  `expira` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_usuario`),
  CONSTRAINT `verificacion_2fa_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificacion_2fa`
--

LOCK TABLES `verificacion_2fa` WRITE;
/*!40000 ALTER TABLE `verificacion_2fa` DISABLE KEYS */;
INSERT INTO `verificacion_2fa` VALUES (1,'252237','2025-06-25 11:07:36'),(3,'165400','2025-06-07 08:58:58'),(4,'654299','2025-06-20 15:57:40'),(5,'220417','2025-06-24 22:48:18'),(7,'680425','2025-06-21 11:15:14'),(13,'951290','2025-06-21 10:50:33'),(15,'276949','2025-06-21 11:29:03');
/*!40000 ALTER TABLE `verificacion_2fa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'factura_chiminike'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualizar_detalle_cotizacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_detalle_cotizacion`(
    IN pv_cod_cotizacion INT,
    IN pv_json_productos JSON
)
BEGIN
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 v_error = MESSAGE_TEXT;
        ROLLBACK;
        SELECT CONCAT('Error SQL: ', v_error) AS mensaje;
    END;

    START TRANSACTION;

    -- 1. Eliminar detalle anterior
    DELETE FROM detalle_cotizacion
    WHERE cod_cotizacion = pv_cod_cotizacion;

    -- 2. Insertar nuevo detalle desde JSON
    INSERT INTO detalle_cotizacion (cantidad, descripcion, precio_unitario, total, cod_cotizacion)
    SELECT 
        cantidad,
        descripcion,
        precio_unitario,
        cantidad * precio_unitario,
        pv_cod_cotizacion
    FROM JSON_TABLE(
        pv_json_productos,
        '$[*]' COLUMNS (
            cantidad INT PATH '$.cantidad',
            descripcion TEXT PATH '$.descripcion',
            precio_unitario DECIMAL(10,2) PATH '$.precio_unitario'
        )
    ) AS productos;

    COMMIT;

    -- 3. Mostrar datos completos de la cotización
    SELECT 
        c.cod_cotizacion,
        p.nombre_persona AS nombre_cliente,
        c.fecha,
        c.fecha_validez,
        e.nombre AS nombre_evento,
        e.fecha_programa,
        e.hora_programada,
        c.estado
    FROM cotizacion c
    JOIN clientes cli ON c.cod_cliente = cli.cod_cliente
    JOIN personas p ON cli.cod_persona = p.cod_persona
    LEFT JOIN evento e ON e.cod_cotizacion = c.cod_cotizacion
    WHERE c.cod_cotizacion = pv_cod_cotizacion;

    -- 4. Mostrar nuevo detalle
    SELECT 
        cantidad,
        descripcion,
        precio_unitario,
        total
    FROM detalle_cotizacion
    WHERE cod_cotizacion = pv_cod_cotizacion;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualizar_permiso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_permiso`(
    IN p_cod_rol INT,
    IN p_cod_objeto INT,
    IN p_permiso VARCHAR(20),
    IN p_valor TINYINT
)
BEGIN
    SET @sql = CONCAT('UPDATE Permisos SET ', p_permiso, ' = ? WHERE cod_rol = ? AND cod_objeto = ?');
    SET @v_valor = p_valor;
    SET @v_rol = p_cod_rol;
    SET @v_objeto = p_cod_objeto;

    PREPARE stmt FROM @sql;
    EXECUTE stmt USING @v_valor, @v_rol, @v_objeto;
    DEALLOCATE PREPARE stmt;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualizar_personas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_personas`(
    IN PV_COD INT,
    IN PV_NOMBRE VARCHAR(100),
    IN PV_FECHA_NACIMIENTO DATE,
    IN PV_SEXO ENUM('Masculino','Femenino','Otro'),
    IN PV_DNI VARCHAR(20),
    IN PV_CORREO VARCHAR(255),
    IN PV_TELEFONO VARCHAR(20),
    IN PV_DIRECCION TEXT,
    IN PV_COD_MUNICIPIO INT,
    IN PV_RTN VARCHAR(20),
    IN PV_TIPO_CLIENTE ENUM('Individual','Empresa'),
    IN PV_CARGO VARCHAR(50),
    IN PV_SALARIO DECIMAL(10,2),
    IN PV_FECHA_CONTRATACION DATETIME,
    IN PV_COD_DEP_EMPRESA INT,
    IN PV_COD_ROL INT,
    IN PV_ESTADO TINYINT,
    IN PV_NOMBRE_ROL VARCHAR(50),
    IN PV_DESC_ROL TEXT,
    IN PV_ACTION ENUM('CLIENTE','EMPLEADO','ROL')
)
BEGIN
    DECLARE v_cod_persona INT;
    DECLARE v_cod_empleado INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error. Se realizó rollback.' AS mensaje;
    END;

    START TRANSACTION;

    IF PV_ACTION = 'CLIENTE' THEN
        SELECT cod_persona INTO v_cod_persona FROM Clientes WHERE cod_cliente = PV_COD LIMIT 1;

        UPDATE Personas
        SET nombre_persona = PV_NOMBRE,
            fecha_nacimiento = PV_FECHA_NACIMIENTO,
            sexo = PV_SEXO,
            dni = PV_DNI
        WHERE cod_persona = v_cod_persona;

        UPDATE Correos
        SET correo = PV_CORREO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Telefonos
        SET telefono = PV_TELEFONO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Direcciones
        SET direccion = PV_DIRECCION,
            cod_municipio = PV_COD_MUNICIPIO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Clientes
        SET rtn = PV_RTN,
            tipo_cliente = PV_TIPO_CLIENTE
        WHERE cod_persona = v_cod_persona;

    ELSEIF PV_ACTION = 'EMPLEADO' THEN
        SELECT cod_persona, cod_empleado INTO v_cod_persona, v_cod_empleado
        FROM Empleados
        WHERE cod_empleado = PV_COD
        LIMIT 1;

        UPDATE Personas
        SET nombre_persona = PV_NOMBRE,
            fecha_nacimiento = PV_FECHA_NACIMIENTO,
            sexo = PV_SEXO,
            dni = PV_DNI
        WHERE cod_persona = v_cod_persona;

        UPDATE Correos
        SET correo = PV_CORREO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Telefonos
        SET telefono = PV_TELEFONO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Direcciones
        SET direccion = PV_DIRECCION,
            cod_municipio = PV_COD_MUNICIPIO
        WHERE cod_persona = v_cod_persona
        LIMIT 1;

        UPDATE Empleados
        SET cargo = PV_CARGO,
            salario = PV_SALARIO,
            fecha_contratacion = PV_FECHA_CONTRATACION,
            cod_departamento_empresa = PV_COD_DEP_EMPRESA
        WHERE cod_persona = v_cod_persona;

        UPDATE Usuarios
        SET cod_rol = PV_COD_ROL,
            estado = PV_ESTADO
        WHERE cod_empleado = v_cod_empleado
        LIMIT 1;

    ELSEIF PV_ACTION = 'ROL' THEN
        UPDATE Roles
        SET nombre = PV_NOMBRE_ROL,
            descripcion = PV_DESC_ROL
        WHERE cod_rol = PV_COD;

    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'PV_ACTION no es válido. Debe ser CLIENTE, EMPLEADO o ROL';
    END IF;

    COMMIT;
    SELECT 'Actualización completada exitosamente' AS mensaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_catalogo_empleado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_catalogo_empleado`(
    IN pv_accion VARCHAR(50)
)
BEGIN
    IF pv_accion = 'municipios' THEN
        SELECT cod_municipio, municipio 
        FROM municipios;

    ELSEIF pv_accion = 'departamentos_empresa' THEN
        SELECT cod_departamento_empresa, nombre 
        FROM departamento_empresa;

    ELSEIF pv_accion = 'tipo_usuario' THEN
        SELECT cod_tipo_usuario, nombre 
        FROM tipo_usuario;

    ELSE
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Acción no válida para sp_catalogo_empleado';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_consultar_bitacora` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_bitacora`(
    IN p_cod_usuario INT,        
    IN p_fecha_inicio DATE,     
    IN p_fecha_fin DATE,         
    IN p_objeto VARCHAR(100)    
)
BEGIN
    SELECT b.*, u.nombre_usuario
    FROM bitacora b
    JOIN usuarios u ON b.cod_usuario = u.cod_usuario
    WHERE (p_cod_usuario = 0 OR b.cod_usuario = p_cod_usuario)
      AND (p_fecha_inicio IS NULL OR DATE(b.fecha) >= p_fecha_inicio)
      AND (p_fecha_fin IS NULL OR DATE(b.fecha) <= p_fecha_fin)
      AND (p_objeto IS NULL OR p_objeto = '' OR b.objeto = p_objeto)
    ORDER BY b.fecha DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_consultar_bitacora_paginado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_bitacora_paginado`(
    IN p_cod_usuario INT,
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE,
    IN p_objeto VARCHAR(100),
    IN p_limit INT,
    IN p_offset INT
)
BEGIN
    SELECT b.*, u.nombre_usuario
    FROM bitacora b
    JOIN usuarios u ON b.cod_usuario = u.cod_usuario
    WHERE (p_cod_usuario = 0 OR b.cod_usuario = p_cod_usuario)
      AND (p_fecha_inicio IS NULL OR DATE(b.fecha) >= p_fecha_inicio)
      AND (p_fecha_fin IS NULL OR DATE(b.fecha) <= p_fecha_fin)
      AND (p_objeto IS NULL OR p_objeto = '' OR b.objeto = p_objeto)
    ORDER BY b.fecha DESC
    LIMIT p_limit OFFSET p_offset;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_cotizacion_completa_json` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cotizacion_completa_json`(
    -- CLIENTE
    IN PV_NOMBRE VARCHAR(100),
    IN PV_FECHA_NACIMIENTO DATE,
    IN PV_SEXO ENUM('Masculino','Femenino','Otro'),
    IN PV_DNI VARCHAR(20),
    IN PV_CORREO VARCHAR(255),
    IN PV_TELEFONO VARCHAR(20),
    IN PV_DIRECCION TEXT,
    IN PV_COD_MUNICIPIO INT,
    IN PV_RTN VARCHAR(20),
    IN PV_TIPO_CLIENTE ENUM('Individual','Empresa'),

    -- EVENTO
    IN PV_EVENTO_NOMBRE VARCHAR(100),
    IN PV_FECHA_EVENTO DATE,
    IN PV_HORA_EVENTO TIME,

    -- JSON de productos
    IN PV_JSON_PRODUCTOS JSON
)
BEGIN
    DECLARE v_cod_persona INT;
    DECLARE v_cod_cliente INT;
    DECLARE v_cod_cotizacion INT;
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 v_error = MESSAGE_TEXT;
        ROLLBACK;
        SELECT CONCAT('Error SQL: ', v_error) AS mensaje;
    END;

    START TRANSACTION;

    -- Insertar cliente
    INSERT INTO Personas (nombre_persona, fecha_nacimiento, sexo, dni)
    VALUES (PV_NOMBRE, PV_FECHA_NACIMIENTO, PV_SEXO, PV_DNI);
    SET v_cod_persona = LAST_INSERT_ID();

    INSERT INTO Correos (correo, cod_persona) VALUES (PV_CORREO, v_cod_persona);
    INSERT INTO Telefonos (telefono, cod_persona) VALUES (PV_TELEFONO, v_cod_persona);
    INSERT INTO Direcciones (direccion, cod_persona, cod_municipio) 
    VALUES (PV_DIRECCION, v_cod_persona, PV_COD_MUNICIPIO);

    INSERT INTO Clientes (rtn, tipo_cliente, cod_persona) 
    VALUES (PV_RTN, PV_TIPO_CLIENTE, v_cod_persona);
    SET v_cod_cliente = LAST_INSERT_ID();

    -- Cotización
    INSERT INTO Cotizacion (cod_cliente, fecha, fecha_validez, estado)
    VALUES (v_cod_cliente, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), 'pendiente');
    SET v_cod_cotizacion = LAST_INSERT_ID();

    -- Evento
    INSERT INTO Evento (nombre, fecha_programa, hora_programada, cod_cotizacion)
    VALUES (PV_EVENTO_NOMBRE, PV_FECHA_EVENTO, PV_HORA_EVENTO, v_cod_cotizacion);

    -- Insertar productos desde JSON
    INSERT INTO detalle_cotizacion (cantidad, descripcion, precio_unitario, total, cod_cotizacion)
    SELECT 
        cantidad,
        descripcion,
        precio_unitario,
        cantidad * precio_unitario,
        v_cod_cotizacion
    FROM JSON_TABLE(
        PV_JSON_PRODUCTOS,
        '$[*]' COLUMNS (
            cantidad INT PATH '$.cantidad',
            descripcion TEXT PATH '$.descripcion',
            precio_unitario DECIMAL(10,2) PATH '$.precio_unitario'
        )
    ) AS detalles;

    COMMIT;

    SELECT v_cod_cotizacion AS cod_cotizacion_generada;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_detalle_cotizacion_por_id` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_detalle_cotizacion_por_id`(
    IN pv_cod_cotizacion INT
)
BEGIN
  
    SELECT 
        c.cod_cotizacion,
        p.nombre_persona AS nombre_cliente,
        c.fecha,
        c.fecha_validez,
        e.nombre AS nombre_evento,
        e.fecha_programa,
        e.hora_programada,
        c.estado
    FROM cotizacion c
    JOIN clientes cli ON c.cod_cliente = cli.cod_cliente
    JOIN personas p ON cli.cod_persona = p.cod_persona
    LEFT JOIN evento e ON e.cod_cotizacion = c.cod_cotizacion
    WHERE c.cod_cotizacion = pv_cod_cotizacion
    LIMIT 1;

   
    SELECT 
        dc.cantidad,
        dc.descripcion,
        dc.precio_unitario,
        dc.total
    FROM detalle_cotizacion dc
    WHERE dc.cod_cotizacion = pv_cod_cotizacion;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_eliminar_persona` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eliminar_persona`(
    IN PV_COD INT,
    IN PV_ACTION ENUM('CLIENTE','EMPLEADO','ROL')
)
BEGIN
    DECLARE v_cod_persona INT;
    DECLARE v_cod_empleado INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error. Se realizó rollback.' AS mensaje;
    END;

    START TRANSACTION;

    IF PV_ACTION = 'CLIENTE' THEN
        SELECT cod_persona INTO v_cod_persona FROM Clientes WHERE cod_cliente = PV_COD LIMIT 1;

        DELETE FROM Clientes WHERE cod_cliente = PV_COD;
        DELETE FROM Correos WHERE cod_persona = v_cod_persona;
        DELETE FROM Telefonos WHERE cod_persona = v_cod_persona;
        DELETE FROM Direcciones WHERE cod_persona = v_cod_persona;
        DELETE FROM Personas WHERE cod_persona = v_cod_persona;

    ELSEIF PV_ACTION = 'EMPLEADO' THEN
        SELECT cod_persona, cod_empleado INTO v_cod_persona, v_cod_empleado
        FROM Empleados
        WHERE cod_empleado = PV_COD
        LIMIT 1;

        DELETE FROM Usuarios WHERE cod_empleado = v_cod_empleado;
        DELETE FROM Empleados WHERE cod_empleado = v_cod_empleado;
        DELETE FROM Correos WHERE cod_persona = v_cod_persona;
        DELETE FROM Telefonos WHERE cod_persona = v_cod_persona;
        DELETE FROM Direcciones WHERE cod_persona = v_cod_persona;
        DELETE FROM Personas WHERE cod_persona = v_cod_persona;

    ELSEIF PV_ACTION = 'ROL' THEN
        DELETE FROM Permisos WHERE cod_rol = PV_COD;
        DELETE FROM Roles WHERE cod_rol = PV_COD;

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'PV_ACTION no es válido. Debe ser EMPLEADO, CLIENTE o ROL';
    END IF;

    COMMIT;

    SELECT CONCAT('Se eliminó correctamente el registro con código: ', PV_COD) AS mensaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_form_empleado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_form_empleado`(IN pv_accion VARCHAR(20))
BEGIN
    IF pv_accion = 'ROLES' THEN
        SELECT cod_rol AS cod, nombre AS nombre
        FROM roles
        ORDER BY nombre;

    ELSEIF pv_accion = 'DEPARTAMENTOS' THEN
        SELECT cod_departamento_empresa AS cod, nombre AS nombre
        FROM departamento_empresa
        ORDER BY nombre;

    ELSEIF pv_accion = 'MUNICIPIOS' THEN
        SELECT cod_municipio AS cod, municipio AS nombre
        FROM municipios
        ORDER BY municipio;

    ELSE
        SELECT 'Acción no válida' AS error;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_generar_token_recuperacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generar_token_recuperacion`(
    IN pv_correo VARCHAR(100),
    IN pv_token VARCHAR(64),
    IN pv_expira DATETIME
)
BEGIN
    DECLARE v_cod_usuario INT DEFAULT NULL;
    DECLARE v_nombre_usuario VARCHAR(50) DEFAULT NULL;

    SELECT u.cod_usuario, u.nombre_usuario
    INTO v_cod_usuario, v_nombre_usuario
    FROM Correos c
    JOIN Personas p ON c.cod_persona = p.cod_persona
    JOIN Empleados e ON e.cod_persona = p.cod_persona
    JOIN Usuarios u ON u.cod_empleado = e.cod_empleado
    WHERE c.correo = pv_correo
    LIMIT 1;

    IF v_cod_usuario IS NULL THEN
        SELECT 'El correo no pertenece a ningún usuario del sistema' AS error;
    ELSE
        UPDATE Usuarios
        SET token_recuperacion = pv_token,
            expira_token = pv_expira
        WHERE cod_usuario = v_cod_usuario;

        SELECT v_nombre_usuario AS usuario;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_adicional` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_adicional`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_adicional INT,
    IN pv_nombre VARCHAR(100),
    IN pv_descripcion TEXT,
    IN pv_precio DECIMAL(10,2)
)
BEGIN
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error. Se realizó rollback.' AS mensaje;
    END;

    START TRANSACTION;

    IF pv_accion = 'INSERTAR' THEN

        INSERT INTO adicionales (nombre, descripcion, precio)
        VALUES (pv_nombre, pv_descripcion, pv_precio);

        COMMIT;
        SELECT CONCAT('Adicional insertado con ID: ', LAST_INSERT_ID()) AS mensaje;

    ELSEIF pv_accion = 'ACTUALIZAR' THEN

        UPDATE adicionales
        SET nombre = pv_nombre,
            descripcion = pv_descripcion,
            precio = pv_precio
        WHERE cod_adicional = pv_cod_adicional;

        COMMIT;
        SELECT 'Adicional actualizado correctamente' AS mensaje;

    ELSEIF pv_accion = 'MOSTRAR' THEN

        SELECT cod_adicional, nombre, descripcion, precio
        FROM adicionales;

    ELSEIF pv_accion = 'MOSTRAR_ID' THEN

        SELECT cod_adicional, nombre, descripcion, precio
        FROM adicionales
        WHERE cod_adicional = pv_cod_adicional;

    ELSEIF pv_accion = 'ELIMINAR' THEN

        DELETE FROM adicionales
        WHERE cod_adicional = pv_cod_adicional;

        COMMIT;
        SELECT 'Adicional eliminado correctamente' AS mensaje;

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Acción no válida. Usa INSERTAR, ACTUALIZAR, MOSTRAR, MOSTRAR_ID o ELIMINAR';
    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_cai` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_cai`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_cai INT,
    IN pv_cai VARCHAR(100),
    IN pv_rango_desde VARCHAR(25),
    IN pv_rango_hasta VARCHAR(25),
    IN pv_fecha_limite DATE,
    IN pv_estado TINYINT(1)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        UPDATE cai SET estado = 0 WHERE estado = 1;
        INSERT INTO cai (cai, rango_desde, rango_hasta, fecha_limite, estado)
        VALUES (pv_cai, pv_rango_desde, pv_rango_hasta, pv_fecha_limite, 1);

    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE cai
        SET cai = pv_cai,
            rango_desde = pv_rango_desde,
            rango_hasta = pv_rango_hasta,
            fecha_limite = pv_fecha_limite,
            estado = IFNULL(pv_estado, estado)
        WHERE cod_cai = pv_cod_cai;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM cai WHERE cod_cai = pv_cod_cai;

    ELSEIF pv_accion = 'mostrar' THEN
        SELECT 
            cod_cai,
            cai,
            rango_desde,
            rango_hasta,
            fecha_limite,
            CASE estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado
        FROM cai;

    ELSEIF pv_accion = 'mostrar_por_id' THEN
        SELECT 
            cod_cai,
            cai,
            rango_desde,
            rango_hasta,
            fecha_limite,
            CASE estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado
        FROM cai
        WHERE cod_cai = pv_cod_cai;

    END IF;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_entrada` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_entrada`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_entrada INT,
    IN pv_nombre VARCHAR(100),
    IN pv_precio DECIMAL(10,2)
)
BEGIN
    -- Manejo de errores con rollback
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error en la transacción';
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        INSERT INTO entradas (nombre, precio)
        VALUES (pv_nombre, pv_precio);

    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE entradas
        SET nombre = pv_nombre,
            precio = pv_precio
        WHERE cod_entrada = pv_cod_entrada;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM entradas
        WHERE cod_entrada = pv_cod_entrada;

    ELSEIF pv_accion = 'mostrar' THEN
        SELECT * FROM entradas;

    ELSEIF pv_accion = 'mostrar_por_id' THEN
        SELECT * FROM entradas
        WHERE cod_entrada = pv_cod_entrada;

    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Acción no válida';
    END IF;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_inventario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_inventario`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_inventario INT,
    IN pv_nombre VARCHAR(100),
    IN pv_descripcion TEXT,
    IN pv_precio_unitario DECIMAL(10,2),
    IN pv_cantidad_disponible INT,
    IN pv_estado TINYINT
)
BEGIN
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error. Se realizó rollback.' AS mensaje;
    END;

    START TRANSACTION;

    -- INSERTAR
    IF pv_accion = 'INSERTAR' THEN

        INSERT INTO inventario (nombre, descripcion, precio_unitario, cantidad_disponible, estado)
        VALUES (pv_nombre, pv_descripcion, pv_precio_unitario, pv_cantidad_disponible, pv_estado);

        COMMIT;
        SELECT CONCAT('Inventario insertado con ID: ', LAST_INSERT_ID()) AS mensaje;

    -- ACTUALIZAR
    ELSEIF pv_accion = 'ACTUALIZAR' THEN

        UPDATE inventario
        SET nombre = pv_nombre,
            descripcion = pv_descripcion,
            precio_unitario = pv_precio_unitario,
            cantidad_disponible = pv_cantidad_disponible,
            estado = pv_estado
        WHERE cod_inventario = pv_cod_inventario;

        COMMIT;
        SELECT 'Inventario actualizado correctamente' AS mensaje;

    -- MOSTRAR TODOS
    ELSEIF pv_accion = 'MOSTRAR' THEN

        SELECT 
            cod_inventario,
            nombre,
            descripcion,
            precio_unitario,
            cantidad_disponible,
            CASE estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado
        FROM inventario;

    -- MOSTRAR POR ID
    ELSEIF pv_accion = 'MOSTRAR_ID' THEN

        SELECT 
            cod_inventario,
            nombre,
            descripcion,
            precio_unitario,
            cantidad_disponible,
            CASE estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado
        FROM inventario
        WHERE cod_inventario = pv_cod_inventario;

    -- ELIMINAR
    ELSEIF pv_accion = 'ELIMINAR' THEN

        DELETE FROM inventario WHERE cod_inventario = pv_cod_inventario;

        COMMIT;
        SELECT 'Inventario eliminado correctamente' AS mensaje;

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Acción no válida. Usa INSERTAR, ACTUALIZAR, MOSTRAR, MOSTRAR_ID o ELIMINAR';
    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_objetos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_objetos`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_objeto INT,
    IN pv_tipo_objeto VARCHAR(50),
    IN pv_descripcion VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        -- Si hay error hacemos rollback
        ROLLBACK;
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        INSERT INTO objetos (tipo_objeto, descripcion)
        VALUES (pv_tipo_objeto, pv_descripcion);

        COMMIT;
        SELECT 'Objeto insertado correctamente' AS mensaje;

    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE objetos
        SET tipo_objeto = pv_tipo_objeto,
            descripcion = pv_descripcion
        WHERE cod_objeto = pv_cod_objeto;

        COMMIT;
        SELECT 'Objeto actualizado correctamente' AS mensaje;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM objetos
        WHERE cod_objeto = pv_cod_objeto;

        COMMIT;
        SELECT 'Objeto eliminado correctamente' AS mensaje;

    ELSEIF pv_accion = 'mostrar' THEN
        -- No requiere commit porque solo es lectura
        SELECT cod_objeto, tipo_objeto, descripcion
        FROM objetos;

    ELSEIF pv_accion = 'mostrar_id' THEN
        SELECT cod_objeto, tipo_objeto, descripcion
        FROM objetos
        WHERE cod_objeto = pv_cod_objeto;

    ELSE
        -- Si viene un pv_accion inválido
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Acción no válida';
    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_paquete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_paquete`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_paquete INT,
    IN pv_nombre VARCHAR(100),
    IN pv_descripcion TEXT,
    IN pv_precio DECIMAL(10,2)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        -- En caso de error hacemos rollback
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error en la transacción';
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        INSERT INTO paquetes (nombre, descripcion, precio)
        VALUES (pv_nombre, pv_descripcion, pv_precio);

    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE paquetes
        SET nombre = pv_nombre,
            descripcion = pv_descripcion,
            precio = pv_precio
        WHERE cod_paquete = pv_cod_paquete;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM paquetes
        WHERE cod_paquete = pv_cod_paquete;

    ELSEIF pv_accion = 'mostrar' THEN
        SELECT * FROM paquetes;

    ELSEIF pv_accion = 'mostrar_por_id' THEN
        SELECT * FROM paquetes
        WHERE cod_paquete = pv_cod_paquete;

    ELSE
        -- Acción no válida
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Acción no válida';
    END IF;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_permisos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_permisos`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_permiso INT,
    IN pv_cod_rol INT,
    IN pv_cod_objeto INT,
    IN pv_nombre VARCHAR(100),
    IN pv_crear TINYINT(1),
    IN pv_modificar TINYINT(1),
    IN pv_mostrar TINYINT(1),
    IN pv_eliminar TINYINT(1)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error durante la transacción';
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        INSERT INTO permisos (cod_rol, cod_objeto, nombre, crear, modificar, mostrar, eliminar)
        VALUES (pv_cod_rol, pv_cod_objeto, pv_nombre, pv_crear, pv_modificar, pv_mostrar, pv_eliminar);

    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE permisos
        SET cod_rol = pv_cod_rol,
            cod_objeto = pv_cod_objeto,
            nombre = pv_nombre,
            crear = pv_crear,
            modificar = pv_modificar,
            mostrar = pv_mostrar,
            eliminar = pv_eliminar
        WHERE cod_permiso = pv_cod_permiso;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM permisos
        WHERE cod_permiso = pv_cod_permiso;

    ELSEIF pv_accion = 'mostrar' THEN
        SELECT 
            p.cod_permiso,
            r.nombre AS nombre_rol,
            o.tipo_objeto AS nombre_objeto,
            p.nombre,
            CASE p.crear WHEN 1 THEN 'Sí' ELSE 'No' END AS crear,
            CASE p.modificar WHEN 1 THEN 'Sí' ELSE 'No' END AS modificar,
            CASE p.mostrar WHEN 1 THEN 'Sí' ELSE 'No' END AS mostrar,
            CASE p.eliminar WHEN 1 THEN 'Sí' ELSE 'No' END AS eliminar
        FROM permisos p
        INNER JOIN roles r ON p.cod_rol = r.cod_rol
        INNER JOIN objetos o ON p.cod_objeto = o.cod_objeto
        ORDER BY r.nombre, o.tipo_objeto;

    ELSEIF pv_accion = 'mostrar_uno' THEN
        SELECT 
            p.cod_permiso,
            r.nombre AS nombre_rol,
            o.tipo_objeto AS nombre_objeto,
            p.nombre,
            CASE p.crear WHEN 1 THEN 'Sí' ELSE 'No' END AS crear,
            CASE p.modificar WHEN 1 THEN 'Sí' ELSE 'No' END AS modificar,
            CASE p.mostrar WHEN 1 THEN 'Sí' ELSE 'No' END AS mostrar,
            CASE p.eliminar WHEN 1 THEN 'Sí' ELSE 'No' END AS eliminar
        FROM permisos p
        INNER JOIN roles r ON p.cod_rol = r.cod_rol
        INNER JOIN objetos o ON p.cod_objeto = o.cod_objeto
        WHERE p.cod_permiso = pv_cod_permiso;

    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Acción no válida';
    END IF;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_roles` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_roles`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_rol INT,
    IN pv_nombre VARCHAR(50),
    IN pv_descripcion TEXT,
    IN pv_estado TINYINT
)
BEGIN
    DECLARE v_error TEXT;

    -- Manejador de errores para rollback
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error: Se produjo un problema durante la operación' AS mensaje;
    END;

    START TRANSACTION;

    IF pv_accion = 'insertar' THEN
        INSERT INTO roles (nombre, descripcion, estado)
        VALUES (pv_nombre, pv_descripcion, pv_estado);
    
    ELSEIF pv_accion = 'actualizar' THEN
        UPDATE roles
        SET nombre = pv_nombre,
            descripcion = pv_descripcion,
            estado = pv_estado
        WHERE cod_rol = pv_cod_rol;

    ELSEIF pv_accion = 'eliminar' THEN
        DELETE FROM roles
        WHERE cod_rol = pv_cod_rol;

    ELSEIF pv_accion = 'mostrar' THEN
        SELECT cod_rol, nombre, descripcion, estado
        FROM roles;

    ELSE
        SET v_error = 'Acción no válida';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_error;
    END IF;

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_salon` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_salon`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_salon INT,
    IN pv_nombre VARCHAR(100),
    IN pv_descripcion TEXT,
    IN pv_capacidad INT,
    IN pv_estado TINYINT,
    IN pv_precio_dia DECIMAL(10,2),
    IN pv_precio_noche DECIMAL(10,2),
    IN pv_precio_hora_extra_dia DECIMAL(10,2),
    IN pv_precio_hora_extra_noche DECIMAL(10,2)
)
BEGIN
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error. Se realizó rollback.' AS mensaje;
    END;

    START TRANSACTION;

    IF pv_accion = 'INSERTAR' THEN
        INSERT INTO salones(nombre, descripcion, capacidad, estado)
        VALUES (pv_nombre, pv_descripcion, pv_capacidad, pv_estado);

        SET @nuevo_id = LAST_INSERT_ID();

        INSERT INTO salon_horario(cod_salon, cod_tipo_horario, precio, precio_hora_extra)
        VALUES
            (@nuevo_id, 1, pv_precio_dia, pv_precio_hora_extra_dia),
            (@nuevo_id, 2, pv_precio_noche, pv_precio_hora_extra_noche);

        COMMIT;
        SELECT CONCAT('Salón insertado con ID: ', @nuevo_id) AS mensaje;

    ELSEIF pv_accion = 'ACTUALIZAR' THEN
        UPDATE salones
        SET nombre = pv_nombre,
            descripcion = pv_descripcion,
            capacidad = pv_capacidad,
            estado = pv_estado
        WHERE cod_salon = pv_cod_salon;

        UPDATE salon_horario
        SET precio = pv_precio_dia,
            precio_hora_extra = pv_precio_hora_extra_dia
        WHERE cod_salon = pv_cod_salon AND cod_tipo_horario = 1;

        UPDATE salon_horario
        SET precio = pv_precio_noche,
            precio_hora_extra = pv_precio_hora_extra_noche
        WHERE cod_salon = pv_cod_salon AND cod_tipo_horario = 2;

        COMMIT;
        SELECT 'Salón actualizado correctamente' AS mensaje;

    ELSEIF pv_accion = 'MOSTRAR' THEN
        SELECT 
            s.cod_salon,
            s.nombre,
            s.descripcion,
            s.capacidad,
            CASE s.estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado,
            IFNULL(sh1.precio, 0) AS precio_dia,
            IFNULL(sh1.precio_hora_extra, 0) AS precio_hora_extra_dia,
            IFNULL(sh2.precio, 0) AS precio_noche,
            IFNULL(sh2.precio_hora_extra, 0) AS precio_hora_extra_noche
        FROM salones s
        LEFT JOIN salon_horario sh1 ON s.cod_salon = sh1.cod_salon AND sh1.cod_tipo_horario = 1
        LEFT JOIN salon_horario sh2 ON s.cod_salon = sh2.cod_salon AND sh2.cod_tipo_horario = 2;

    ELSEIF pv_accion = 'MOSTRAR_ID' THEN
        SELECT 
            s.cod_salon,
            s.nombre,
            s.descripcion,
            s.capacidad,
            CASE s.estado
                WHEN 1 THEN 'Activo'
                WHEN 0 THEN 'Inactivo'
                ELSE 'Desconocido'
            END AS estado,
            IFNULL(sh1.precio, 0) AS precio_dia,
            IFNULL(sh1.precio_hora_extra, 0) AS precio_hora_extra_dia,
            IFNULL(sh2.precio, 0) AS precio_noche,
            IFNULL(sh2.precio_hora_extra, 0) AS precio_hora_extra_noche
        FROM salones s
        LEFT JOIN salon_horario sh1 ON s.cod_salon = sh1.cod_salon AND sh1.cod_tipo_horario = 1
        LEFT JOIN salon_horario sh2 ON s.cod_salon = sh2.cod_salon AND sh2.cod_tipo_horario = 2
        WHERE s.cod_salon = pv_cod_salon;

    ELSEIF pv_accion = 'ELIMINAR' THEN
        DELETE FROM salon_horario WHERE cod_salon = pv_cod_salon;
        DELETE FROM salones WHERE cod_salon = pv_cod_salon;
        COMMIT;
        SELECT 'Salón eliminado correctamente' AS mensaje;

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Acción no válida. Usa INSERTAR, ACTUALIZAR, MOSTRAR, MOSTRAR_ID o ELIMINAR';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_gestion_usuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_gestion_usuario`(
    IN pv_accion VARCHAR(20),
    IN pv_cod_usuario INT,
    IN pv_nombre_usuario VARCHAR(50),
    IN pv_contrasena VARCHAR(255),
    IN pv_estado TINYINT,
    IN pv_cod_tipo_usuario INT,
    IN pv_cod_rol INT,
    IN pv_cod_empleado INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    IF pv_accion = 'mostrar' THEN
        SELECT 
    u.cod_usuario,
    u.nombre_usuario,
    u.estado,
    u.cod_tipo_usuario,
    tu.nombre AS nombre_tipo_usuario,
    u.cod_rol,
    r.nombre AS nombre_rol,
    p.nombre_persona AS nombre_empleado
FROM usuarios u
LEFT JOIN tipo_usuario tu ON u.cod_tipo_usuario = tu.cod_tipo_usuario
LEFT JOIN roles r ON u.cod_rol = r.cod_rol
LEFT JOIN empleados e ON u.cod_empleado = e.cod_empleado
LEFT JOIN personas p ON e.cod_persona = p.cod_persona;

    ELSEIF pv_accion = 'mostrar_por_id' THEN
        SELECT 
    u.cod_usuario,
    u.nombre_usuario,
    u.estado,
    u.cod_tipo_usuario,
    tu.nombre AS nombre_tipo_usuario,
    u.cod_rol,
    r.nombre AS nombre_rol,
    p.nombre_persona AS nombre_empleado
FROM usuarios u
LEFT JOIN tipo_usuario tu ON u.cod_tipo_usuario = tu.cod_tipo_usuario
LEFT JOIN roles r ON u.cod_rol = r.cod_rol
LEFT JOIN empleados e ON u.cod_empleado = e.cod_empleado
LEFT JOIN personas p ON e.cod_persona = p.cod_persona;

   ELSEIF pv_accion = 'actualizar' THEN
    START TRANSACTION;

    UPDATE usuarios
    SET 
        estado = pv_estado,
        cod_tipo_usuario = pv_cod_tipo_usuario,
        cod_rol = pv_cod_rol
    WHERE cod_usuario = pv_cod_usuario;

    COMMIT;

    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_guardar_codigo_2fa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_guardar_codigo_2fa`(
    IN p_cod_usuario INT,
    IN p_codigo VARCHAR(6),
    IN p_expira DATETIME
)
BEGIN
    DELETE FROM verificacion_2fa 
    WHERE cod_usuario = p_cod_usuario;

    INSERT INTO verificacion_2fa (cod_usuario, codigo, expira)
    VALUES (p_cod_usuario, p_codigo, p_expira);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insertar_personas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_personas`(
    IN PV_NOMBRE VARCHAR(100),
    IN PV_FECHA_NACIMIENTO DATE,
    IN PV_SEXO ENUM('Masculino','Femenino','Otro'),
    IN PV_DNI VARCHAR(20),
    IN PV_CORREO VARCHAR(255),
    IN PV_TELEFONO VARCHAR(20),
    IN PV_DIRECCION TEXT,
    IN PV_COD_MUNICIPIO INT,
    IN PV_RTN VARCHAR(20),
    IN PV_TIPO_CLIENTE ENUM('Individual','Empresa'),
    IN PV_CARGO VARCHAR(50),
    IN PV_SALARIO DECIMAL(10,2),
    IN PV_FECHA_CONTRATACION DATETIME,
    IN PV_COD_DEP_EMPRESA INT,
    IN PV_NOMBRE_USUARIO VARCHAR(50),
    IN PV_CONTRASENA VARCHAR(255),
    IN PV_COD_ROL INT,
    IN PV_NOMBRE_ROL VARCHAR(50),
    IN PV_DESC_ROL TEXT,
    IN PV_ACTION ENUM('CLIENTE','EMPLEADO','ROL')
)
BEGIN
    DECLARE v_cod_persona INT;
    DECLARE v_cod_empleado INT;
    DECLARE v_id_resultado INT;
    DECLARE v_error TEXT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 v_error = MESSAGE_TEXT;
        ROLLBACK;
        SELECT CONCAT('Error SQL: ', v_error) AS mensaje;
    END;

    START TRANSACTION;

    IF PV_ACTION = 'CLIENTE' OR PV_ACTION = 'EMPLEADO' THEN

        INSERT INTO Personas(nombre_persona, fecha_nacimiento, sexo, dni)
        VALUES (PV_NOMBRE, PV_FECHA_NACIMIENTO, PV_SEXO, PV_DNI);
        SET v_cod_persona = LAST_INSERT_ID();

        INSERT INTO Correos(correo, cod_persona)
        VALUES (PV_CORREO, v_cod_persona);

        INSERT INTO Telefonos(telefono, cod_persona)
        VALUES (PV_TELEFONO, v_cod_persona);

        INSERT INTO Direcciones(direccion, cod_persona, cod_municipio)
        VALUES (PV_DIRECCION, v_cod_persona, PV_COD_MUNICIPIO);

        IF PV_ACTION = 'CLIENTE' THEN
            INSERT INTO Clientes(rtn, tipo_cliente, cod_persona)
            VALUES (PV_RTN, PV_TIPO_CLIENTE, v_cod_persona);
            SET v_id_resultado = LAST_INSERT_ID();

        ELSEIF PV_ACTION = 'EMPLEADO' THEN
            INSERT INTO Empleados(cargo, salario, fecha_contratacion, cod_persona, cod_departamento_empresa)
            VALUES (PV_CARGO, PV_SALARIO, PV_FECHA_CONTRATACION, v_cod_persona, PV_COD_DEP_EMPRESA);
            SET v_cod_empleado = LAST_INSERT_ID();

            INSERT INTO Usuarios(nombre_usuario, contrasena, cod_rol, cod_empleado, cod_tipo_usuario)
            VALUES (PV_NOMBRE_USUARIO, PV_CONTRASENA, PV_COD_ROL, v_cod_empleado, 1);
            SET v_id_resultado = LAST_INSERT_ID();
        END IF;

    ELSEIF PV_ACTION = 'ROL' THEN
        INSERT INTO Roles(nombre, descripcion)
        VALUES (PV_NOMBRE_ROL, PV_DESC_ROL);
        SET v_id_resultado = LAST_INSERT_ID();

    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'PV_ACTION no es válido. Debe ser EMPLEADO, CLIENTE o ROL';
    END IF;

    COMMIT;
    SELECT CONCAT('Se agregó exitosamente con el ID: ', v_id_resultado) AS mensaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_login_usuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_usuario`(
    IN pv_accion VARCHAR(30),
    IN pv_usuario VARCHAR(50),
    IN pv_ip_conexion VARCHAR(50)
)
BEGIN
    DECLARE v_exist INT;
    DECLARE v_intentos INT;

    SELECT COUNT(*) INTO v_exist
    FROM Usuarios
    WHERE nombre_usuario = pv_usuario;

    IF v_exist = 0 THEN
        SELECT 'Usuario no encontrado' AS mensaje;
    ELSE
        CASE pv_accion

            WHEN 'mostrar' THEN
                SELECT 
                    u.cod_usuario,
                    u.nombre_usuario,
                    u.contrasena,
                    u.estado,
                    u.intentos,
                    u.cod_rol,
                    r.nombre AS rol,
                    u.cod_tipo_usuario,
                    u.primer_acceso,
                    c.correo
                FROM Usuarios u
                JOIN Roles r ON u.cod_rol = r.cod_rol
                JOIN Empleados e ON u.cod_empleado = e.cod_empleado
                JOIN Personas p ON e.cod_persona = p.cod_persona
                LEFT JOIN Correos c ON p.cod_persona = c.cod_persona
                WHERE u.nombre_usuario = pv_usuario;

            WHEN 'sumar_intento' THEN
                SELECT intentos INTO v_intentos
                FROM Usuarios
                WHERE nombre_usuario = pv_usuario;

                IF v_intentos + 1 >= 3 THEN
                    UPDATE Usuarios
                    SET intentos = intentos + 1,
                        estado = 0
                    WHERE nombre_usuario = pv_usuario;
                ELSE
                    UPDATE Usuarios
                    SET intentos = intentos + 1
                    WHERE nombre_usuario = pv_usuario;
                END IF;

            WHEN 'login_exitoso' THEN
                UPDATE Usuarios
                SET intentos = 0,
                    ip_conexion = pv_ip_conexion,
                    primer_acceso = 0
                WHERE nombre_usuario = pv_usuario;

            ELSE
                SELECT 'Acción no válida' AS mensaje;

        END CASE;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_mostrar_objetos_basico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mostrar_objetos_basico`()
BEGIN
    SELECT cod_objeto, tipo_objeto
    FROM objetos;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_mostrar_persona` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mostrar_persona`(
    IN PV_COD_PERSONA INT,
    IN PV_ACTION ENUM('CLIENTE','EMPLEADO','TODOS_CLIENTES','TODOS_EMPLEADOS','ROL','TODOS_ROLES')
)
BEGIN
    IF PV_ACTION = 'CLIENTE' THEN
        SELECT 
            CL.cod_cliente,
            P.nombre_persona AS nombre,
            P.fecha_nacimiento,
            P.sexo,
            P.dni,
            C.correo,
            T.telefono,
            D.direccion,
            M.municipio,
            DP.departamento,
            CL.rtn,
            CL.tipo_cliente
        FROM Clientes CL
        INNER JOIN Personas P ON P.cod_persona = CL.cod_persona
        LEFT JOIN Correos C ON C.cod_persona = P.cod_persona
        LEFT JOIN Telefonos T ON T.cod_persona = P.cod_persona
        LEFT JOIN Direcciones D ON D.cod_persona = P.cod_persona
        LEFT JOIN Municipios M ON M.cod_municipio = D.cod_municipio
        LEFT JOIN Departamentos DP ON DP.cod_departamento = M.cod_departamento
        WHERE CL.cod_cliente = PV_COD_PERSONA
        LIMIT 1;

    ELSEIF PV_ACTION = 'EMPLEADO' THEN
        SELECT 
            E.cod_empleado,
            P.nombre_persona AS nombre,
            P.fecha_nacimiento,
            P.sexo,
            P.dni,
            C.correo,
            T.telefono,
            D.direccion,
            M.municipio,
            DP.departamento,
            E.cargo,
            E.salario,
            E.fecha_contratacion,
            DE.nombre AS departamento_empresa,
            U.nombre_usuario,
            U.estado,
            R.nombre AS rol,
            TU.nombre AS tipo_usuario
        FROM Empleados E
        INNER JOIN Personas P ON P.cod_persona = E.cod_persona
        LEFT JOIN Correos C ON C.cod_persona = P.cod_persona
        LEFT JOIN Telefonos T ON T.cod_persona = P.cod_persona
        LEFT JOIN Direcciones D ON D.cod_persona = P.cod_persona
        LEFT JOIN Municipios M ON M.cod_municipio = D.cod_municipio
        LEFT JOIN Departamentos DP ON DP.cod_departamento = M.cod_departamento
        LEFT JOIN Departamento_Empresa DE ON DE.cod_departamento_empresa = E.cod_departamento_empresa
        LEFT JOIN Usuarios U ON U.cod_empleado = E.cod_empleado
        LEFT JOIN Roles R ON R.cod_rol = U.cod_rol
        LEFT JOIN Tipo_Usuario TU ON TU.cod_tipo_usuario = U.cod_tipo_usuario
        WHERE E.cod_empleado = PV_COD_PERSONA
        LIMIT 1;

    ELSEIF PV_ACTION = 'TODOS_CLIENTES' THEN
        SELECT 
            CL.cod_cliente,
            P.nombre_persona AS nombre,
            P.fecha_nacimiento,
            P.sexo,
            P.dni,
            C.correo,
            T.telefono,
            D.direccion,
            M.municipio,
            DP.departamento,
            CL.rtn,
            CL.tipo_cliente
        FROM Clientes CL
        INNER JOIN Personas P ON P.cod_persona = CL.cod_persona
        LEFT JOIN Correos C ON C.cod_persona = P.cod_persona
        LEFT JOIN Telefonos T ON T.cod_persona = P.cod_persona
        LEFT JOIN Direcciones D ON D.cod_persona = P.cod_persona
        LEFT JOIN Municipios M ON M.cod_municipio = D.cod_municipio
        LEFT JOIN Departamentos DP ON DP.cod_departamento = M.cod_departamento;

    ELSEIF PV_ACTION = 'TODOS_EMPLEADOS' THEN
        SELECT 
            E.cod_empleado,
            P.nombre_persona AS nombre,
            P.fecha_nacimiento,
            P.sexo,
            P.dni,
            C.correo,
            T.telefono,
            D.direccion,
            M.municipio,
            DP.departamento,
            E.cargo,
            E.salario,
            E.fecha_contratacion,
            DE.nombre AS departamento_empresa,
            U.nombre_usuario,
            U.estado,
            R.nombre AS rol,
            TU.nombre AS tipo_usuario
        FROM Empleados E
        INNER JOIN Personas P ON P.cod_persona = E.cod_persona
        LEFT JOIN Correos C ON C.cod_persona = P.cod_persona
        LEFT JOIN Telefonos T ON T.cod_persona = P.cod_persona
        LEFT JOIN Direcciones D ON D.cod_persona = P.cod_persona
        LEFT JOIN Municipios M ON M.cod_municipio = D.cod_municipio
        LEFT JOIN Departamentos DP ON DP.cod_departamento = M.cod_departamento
        LEFT JOIN Departamento_Empresa DE ON DE.cod_departamento_empresa = E.cod_departamento_empresa
        LEFT JOIN Usuarios U ON U.cod_empleado = E.cod_empleado
        LEFT JOIN Roles R ON R.cod_rol = U.cod_rol
        LEFT JOIN Tipo_Usuario TU ON TU.cod_tipo_usuario = U.cod_tipo_usuario;

    ELSEIF PV_ACTION = 'ROL' THEN
        SELECT cod_rol, nombre, descripcion, estado
        FROM Roles
        WHERE cod_rol = PV_COD_PERSONA
        LIMIT 1;

    ELSEIF PV_ACTION = 'TODOS_ROLES' THEN
        SELECT cod_rol, nombre, descripcion, estado
        FROM Roles;

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'PV_ACTION no es válido.';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_mostrar_roles_basico` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mostrar_roles_basico`()
BEGIN
    SELECT cod_rol, nombre
    FROM roles;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_permisos_usuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_permisos_usuario`(
    IN pv_cod_rol INT
)
BEGIN
    SELECT 
        o.descripcion AS objeto,
        p.crear,
        p.modificar,
        p.mostrar,
        p.eliminar
    FROM Permisos p
    INNER JOIN Objetos o ON p.cod_objeto = o.cod_objeto
    WHERE p.cod_rol = pv_cod_rol;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_primer_acceso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_primer_acceso`(
    IN pv_cod_usuario INT,
    IN pv_nueva_contrasena VARCHAR(255)
)
BEGIN
    UPDATE Usuarios
    SET contrasena = pv_nueva_contrasena,
        primer_acceso = 0,
        intentos = 0
    WHERE cod_usuario = pv_cod_usuario;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_registrar_bitacora` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_bitacora`(
    IN p_cod_usuario INT,
    IN p_objeto VARCHAR(100),
    IN p_accion VARCHAR(20),
    IN p_descripcion TEXT
)
BEGIN
    INSERT INTO bitacora (cod_usuario, objeto, accion, descripcion, fecha)
    VALUES (p_cod_usuario, p_objeto, p_accion, p_descripcion, NOW());
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_resetear_contrasena_token` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resetear_contrasena_token`(
    IN pv_token VARCHAR(64),
    IN pv_nueva_contra VARCHAR(255)
)
BEGIN
    DECLARE filas_afectadas INT;

    UPDATE Usuarios
    SET contrasena = pv_nueva_contra,
        token_recuperacion = NULL,
        expira_token = NULL
    WHERE token_recuperacion = pv_token
      AND expira_token > NOW();

    SET filas_afectadas = ROW_COUNT();

    IF filas_afectadas > 0 THEN
        SELECT 'Contraseña actualizada correctamente' AS mensaje;
    ELSE
        SELECT 'Token inválido o expirado' AS mensaje;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_resumen_cotizacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resumen_cotizacion`(
    IN pv_cod_cotizacion INT
)
BEGIN
    SELECT 
        c.cod_cotizacion,
        p.nombre_persona AS nombre_cliente,
        c.fecha,
        c.fecha_validez,
        MAX(e.nombre) AS nombre_evento,
        MAX(e.fecha_programa) AS fecha_programa,
        MAX(e.hora_programada) AS hora_programada,
        c.estado,

        -- Concatenación de productos en formato resumen
        GROUP_CONCAT(
            CONCAT(
                dc.cantidad, 'x ', dc.descripcion, 
                ' (', FORMAT(dc.precio_unitario, 2), ') = ', FORMAT(dc.total, 2)
            )
            SEPARATOR ', '
        ) AS productos,

        -- Total general de la cotización
        SUM(dc.total) AS monto_total

    FROM cotizacion c
    JOIN clientes cli ON c.cod_cliente = cli.cod_cliente
    JOIN personas p ON cli.cod_persona = p.cod_persona
    LEFT JOIN evento e ON e.cod_cotizacion = c.cod_cotizacion
    JOIN detalle_cotizacion dc ON dc.cod_cotizacion = c.cod_cotizacion
    WHERE pv_cod_cotizacion IS NULL OR pv_cod_cotizacion = 0 OR c.cod_cotizacion = pv_cod_cotizacion
    GROUP BY c.cod_cotizacion, p.nombre_persona, c.fecha, c.fecha_validez, c.estado;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_resumen_personas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_resumen_personas`()
BEGIN
    SELECT 
        (SELECT COUNT(*) FROM personas) AS total_personas,
        (SELECT COUNT(*) FROM empleados) AS total_empleados,
        (SELECT COUNT(*) FROM clientes) AS total_clientes,
        (SELECT COUNT(*) 
         FROM usuarios u
         INNER JOIN empleados e ON u.cod_empleado = e.cod_empleado
         WHERE u.estado = 1) AS empleados_activos,
        (SELECT COUNT(*) 
         FROM usuarios u
         INNER JOIN empleados e ON u.cod_empleado = e.cod_empleado
         WHERE u.estado = 0) AS empleados_inactivos;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_verificar_codigo_2fa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_verificar_codigo_2fa`(
    IN p_cod_usuario INT,
    IN p_codigo VARCHAR(6)
)
BEGIN
    SELECT 
        CASE 
            WHEN COUNT(*) > 0 THEN 1
            ELSE 0
        END AS es_valido
    FROM verificacion_2fa
    WHERE cod_usuario = p_cod_usuario
      AND codigo = p_codigo
      AND expira > NOW();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-25 21:03:09
