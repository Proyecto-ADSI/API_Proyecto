CREATE DATABASE  IF NOT EXISTS `callphone_soft_bd` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `callphone_soft_bd`;
-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: callphone_soft_bd
-- ------------------------------------------------------
-- Server version	8.0.20

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
-- Table structure for table `acciones_oferta`
--

DROP TABLE IF EXISTS `acciones_oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acciones_oferta` (
  `Id_Accion` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Oferta` int NOT NULL,
  `Id_Estado_Oferta` int NOT NULL,
  `Fecha_Accion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Mensaje` varchar(255) NOT NULL,
  PRIMARY KEY (`Id_Accion`),
  KEY `fk_Acciones_Oferta_Ofertas1_idx` (`Id_Oferta`),
  KEY `fk_Acciones_Oferta_Usuarios1_idx` (`Id_Usuario`),
  KEY `fk_Acciones_Oferta_Estados_Oferta1_idx` (`Id_Estado_Oferta`),
  CONSTRAINT `fk_Acciones_Oferta_Estados_Oferta1` FOREIGN KEY (`Id_Estado_Oferta`) REFERENCES `estados_oferta` (`Id_Estado_Oferta`),
  CONSTRAINT `fk_Acciones_Oferta_Ofertas1` FOREIGN KEY (`Id_Oferta`) REFERENCES `ofertas` (`Id_Oferta`),
  CONSTRAINT `fk_Acciones_Oferta_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aclaraciones`
--

DROP TABLE IF EXISTS `aclaraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aclaraciones` (
  `Id_Aclaracion` int NOT NULL AUTO_INCREMENT,
  `Aclaracion` varchar(255) NOT NULL,
  `Id_Oferta` int NOT NULL,
  PRIMARY KEY (`Id_Aclaracion`),
  KEY `fk_Aclaraciones_Ofertas1_idx` (`Id_Oferta`),
  CONSTRAINT `fk_Aclaraciones_Ofertas1` FOREIGN KEY (`Id_Oferta`) REFERENCES `ofertas` (`Id_Oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `atencion_telefonica`
--

DROP TABLE IF EXISTS `atencion_telefonica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atencion_telefonica` (
  `Id_AT` int NOT NULL AUTO_INCREMENT,
  `Id_Llamada` int NOT NULL,
  `Medio_Envio` int NOT NULL,
  `Tiempo_Post_Llamada` varchar(45) NOT NULL,
  `Id_Operador` int NOT NULL,
  PRIMARY KEY (`Id_AT`),
  KEY `fk_Atencion_Telefonica_Llamadas1_idx` (`Id_Llamada`),
  KEY `fk_Atencion_Telefonica_Operadores1_idx` (`Id_Operador`),
  CONSTRAINT `fk_Atencion_Telefonica_Llamadas1` FOREIGN KEY (`Id_Llamada`) REFERENCES `llamadas` (`Id_Llamada`),
  CONSTRAINT `fk_Atencion_Telefonica_Operadores1` FOREIGN KEY (`Id_Operador`) REFERENCES `operadores` (`Id_Operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `barrios_veredas`
--

DROP TABLE IF EXISTS `barrios_veredas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barrios_veredas` (
  `Id_Barrios_Veredas` int NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(45) DEFAULT NULL,
  `Nombre_Barrio_Vereda` varchar(45) DEFAULT NULL,
  `Id_Municipio` int NOT NULL,
  `Id_SubTipo_Barrio_Vereda` int NOT NULL,
  `Estado` int DEFAULT NULL,
  PRIMARY KEY (`Id_Barrios_Veredas`),
  KEY `fk_Barrios-Veredas_Municipios1_idx` (`Id_Municipio`),
  KEY `fk_Barrios-Veredas_SubTipo_Barrio_Vereda1_idx` (`Id_SubTipo_Barrio_Vereda`),
  CONSTRAINT `fk_Barrios-Veredas_Municipios1` FOREIGN KEY (`Id_Municipio`) REFERENCES `municipios` (`Id_Municipio`),
  CONSTRAINT `fk_Barrios-Veredas_SubTipo_Barrio_Vereda1` FOREIGN KEY (`Id_SubTipo_Barrio_Vereda`) REFERENCES `subtipo_barrio_vereda` (`Id_SubTipo_Barrio_Vereda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calificacion_operador`
--

DROP TABLE IF EXISTS `calificacion_operador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificacion_operador` (
  `Id_Calificacion_Operador` int NOT NULL AUTO_INCREMENT,
  `Calificacion` varchar(45) NOT NULL,
  `Estado_Calificacion` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Calificacion_Operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categorias_notificacion`
--

DROP TABLE IF EXISTS `categorias_notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_notificacion` (
  `Id_Categoria_N` int NOT NULL AUTO_INCREMENT,
  `Categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_Categoria_N`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `Id_Cita` int NOT NULL AUTO_INCREMENT,
  `Id_Llamada` int NOT NULL,
  `Encargado_Cita` varchar(45) NOT NULL,
  `Ext_Tel_Contacto_Cita` varchar(45) DEFAULT NULL,
  `Representante_Legal` int NOT NULL,
  `Fecha_Cita` datetime NOT NULL,
  `Duracion_Verificacion` time NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Id_Barrios_Veredas` int NOT NULL,
  `Lugar_Referencia` varchar(45) NOT NULL,
  `Id_Operador` int NOT NULL,
  `Factibilidad` varchar(45) DEFAULT NULL,
  `Id_Coordinador` int DEFAULT NULL,
  `Id_Estado_Cita` int NOT NULL,
  PRIMARY KEY (`Id_Cita`),
  KEY `fk_Citas_Llamadas1_idx` (`Id_Llamada`),
  KEY `fk_Citas_Barrios-Veredas1_idx` (`Id_Barrios_Veredas`),
  KEY `fk_Citas_Estado_Cita1_idx` (`Id_Estado_Cita`),
  KEY `fk_Citas_Usuarios1_idx` (`Id_Coordinador`),
  KEY `fk_Citas_Operadores1_idx` (`Id_Operador`),
  CONSTRAINT `fk_Citas_Barrios-Veredas1` FOREIGN KEY (`Id_Barrios_Veredas`) REFERENCES `barrios_veredas` (`Id_Barrios_Veredas`),
  CONSTRAINT `fk_Citas_Estado_Cita1` FOREIGN KEY (`Id_Estado_Cita`) REFERENCES `estados_citas` (`Id_Estado_Cita`),
  CONSTRAINT `fk_Citas_Llamadas1` FOREIGN KEY (`Id_Llamada`) REFERENCES `llamadas` (`Id_Llamada`),
  CONSTRAINT `fk_Citas_Operadores1` FOREIGN KEY (`Id_Operador`) REFERENCES `operadores` (`Id_Operador`),
  CONSTRAINT `fk_Citas_Usuarios1` FOREIGN KEY (`Id_Coordinador`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conexiones_usuario`
--

DROP TABLE IF EXISTS `conexiones_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conexiones_usuario` (
  `Id_Conexion_Usuario` int NOT NULL AUTO_INCREMENT,
  `Conexion` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_Conexion_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `configuracion_sistema`
--

DROP TABLE IF EXISTS `configuracion_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion_sistema` (
  `Id_Configuracion` int NOT NULL AUTO_INCREMENT,
  `Duracion_Cita` time NOT NULL,
  `EmpresasXContact` int NOT NULL,
  `Dias_Inhabilitacion` int NOT NULL,
  `CitasXTCita` int NOT NULL,
  `Tiempo_Laboral_Inicio` time NOT NULL,
  `Tiempo_Laboral_Fin` time NOT NULL,
  PRIMARY KEY (`Id_Configuracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `corporativos_actuales`
--

DROP TABLE IF EXISTS `corporativos_actuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corporativos_actuales` (
  `Id_Corporativo_Actual` int NOT NULL AUTO_INCREMENT,
  `Id_DBL` int NOT NULL,
  PRIMARY KEY (`Id_Corporativo_Actual`),
  KEY `fk_Corporativos_Actuales_Datos_Basicos_Lineas1_idx` (`Id_DBL`),
  CONSTRAINT `fk_Corporativos_Actuales_Datos_Basicos_Lineas1` FOREIGN KEY (`Id_DBL`) REFERENCES `datos_basicos_lineas` (`Id_DBL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `corporativos_anteriores`
--

DROP TABLE IF EXISTS `corporativos_anteriores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corporativos_anteriores` (
  `Id_Corporativo_Anterior` int NOT NULL AUTO_INCREMENT,
  `Id_DBL` int NOT NULL,
  PRIMARY KEY (`Id_Corporativo_Anterior`),
  KEY `fk_Corporativos_Anteriores_Datos_Basicos_Lineas1_idx` (`Id_DBL`),
  CONSTRAINT `fk_Corporativos_Anteriores_Datos_Basicos_Lineas1` FOREIGN KEY (`Id_DBL`) REFERENCES `datos_basicos_lineas` (`Id_DBL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `datos_basicos_lineas`
--

DROP TABLE IF EXISTS `datos_basicos_lineas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datos_basicos_lineas` (
  `Id_DBL` int NOT NULL AUTO_INCREMENT,
  `Id_Cliente` int NOT NULL,
  `Id_Operador` int DEFAULT NULL,
  `Id_Plan_Corporativo` int DEFAULT NULL,
  `Cantidad_Total_Lineas` int DEFAULT NULL,
  `Valor_Total_Mensual` varchar(45) DEFAULT NULL,
  `Id_Calificacion_Operador` int DEFAULT NULL,
  `Razones` varchar(100) DEFAULT NULL,
  `Id_Estado_DBL` int NOT NULL,
  PRIMARY KEY (`Id_DBL`),
  KEY `fk_Datos_Basicos_Lineas_Plan_Corporativo1_idx` (`Id_Plan_Corporativo`),
  KEY `fk_Datos_Basicos_Lineas_Operadores1_idx` (`Id_Operador`),
  KEY `fk_Datos_Basicos_Lineas_Estados_DBL1_idx` (`Id_Estado_DBL`),
  KEY `fk_Datos_Basicos_Lineas_Directorio1_idx` (`Id_Cliente`),
  KEY `fk_Datos_Basicos_Lineas_Calificacion_Operador1_idx` (`Id_Calificacion_Operador`),
  CONSTRAINT `fk_Datos_Basicos_Lineas_Calificacion_Operador1` FOREIGN KEY (`Id_Calificacion_Operador`) REFERENCES `calificacion_operador` (`Id_Calificacion_Operador`),
  CONSTRAINT `fk_Datos_Basicos_Lineas_Directorio1` FOREIGN KEY (`Id_Cliente`) REFERENCES `directorio` (`Id_Cliente`),
  CONSTRAINT `fk_Datos_Basicos_Lineas_Estados_DBL1` FOREIGN KEY (`Id_Estado_DBL`) REFERENCES `estados_dbl` (`Id_Estado_DBL`),
  CONSTRAINT `fk_Datos_Basicos_Lineas_Operadores1` FOREIGN KEY (`Id_Operador`) REFERENCES `operadores` (`Id_Operador`),
  CONSTRAINT `fk_Datos_Basicos_Lineas_Plan_Corporativo1` FOREIGN KEY (`Id_Plan_Corporativo`) REFERENCES `plan_corporativo` (`Id_Plan_Corporativo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `datos_visita`
--

DROP TABLE IF EXISTS `datos_visita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datos_visita` (
  `Id_Datos_Visita` int NOT NULL AUTO_INCREMENT,
  `Fecha_Visita` date DEFAULT NULL,
  `Tipo_Venta` varchar(45) DEFAULT NULL,
  `Calificacion` int DEFAULT NULL,
  `Sugerencias` text,
  `Observacion` text,
  PRIMARY KEY (`Id_Datos_Visita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `Id_Departamento` int NOT NULL AUTO_INCREMENT,
  `Nombre_Departamento` varchar(45) DEFAULT NULL,
  `Id_Pais` int NOT NULL,
  `Estado_Departamento` int DEFAULT NULL,
  PRIMARY KEY (`Id_Departamento`),
  KEY `fk_Departamento_Pais1_idx` (`Id_Pais`),
  CONSTRAINT `fk_Departamento_Pais1` FOREIGN KEY (`Id_Pais`) REFERENCES `pais` (`Id_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_lineas`
--

DROP TABLE IF EXISTS `detalle_lineas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_lineas` (
  `Id_Detalle_Linea` int NOT NULL AUTO_INCREMENT,
  `Id_Linea_Movil` int DEFAULT NULL,
  `Id_Linea_Fija` int DEFAULT NULL,
  `Id_DBL` int NOT NULL,
  PRIMARY KEY (`Id_Detalle_Linea`),
  KEY `fk_Detalle_Lineas_Lineas1_idx` (`Id_Linea_Movil`),
  KEY `fk_Detalle_Lineas_Datos_Basicos_Lineas1_idx` (`Id_DBL`),
  KEY `fk_Detalle_Lineas_Lineas_Fijas1_idx` (`Id_Linea_Fija`),
  CONSTRAINT `fk_Detalle_Lineas_Datos_Basicos_Lineas1` FOREIGN KEY (`Id_DBL`) REFERENCES `datos_basicos_lineas` (`Id_DBL`),
  CONSTRAINT `fk_Detalle_Lineas_Lineas1` FOREIGN KEY (`Id_Linea_Movil`) REFERENCES `lineas_moviles` (`Id_Linea_Movil`),
  CONSTRAINT `fk_Detalle_Lineas_Lineas_Fijas1` FOREIGN KEY (`Id_Linea_Fija`) REFERENCES `lineas_fijas` (`Id_Linea_Fija`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `directorio`
--

DROP TABLE IF EXISTS `directorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directorio` (
  `Id_Cliente` int NOT NULL AUTO_INCREMENT,
  `NIT_CDV` varchar(45) DEFAULT NULL,
  `Razon_Social` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Extension` varchar(45) DEFAULT NULL,
  `Encargado` varchar(45) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `Celular` varchar(45) DEFAULT NULL,
  `Direccion` varchar(45) DEFAULT NULL,
  `Id_Barrios_Veredas` int DEFAULT NULL,
  `Fecha_Control` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado_Cliente` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Cliente`),
  KEY `fk_Directorio_Barrios_Veredas1_idx` (`Id_Barrios_Veredas`),
  CONSTRAINT `fk_Directorio_Barrios_Veredas1` FOREIGN KEY (`Id_Barrios_Veredas`) REFERENCES `barrios_veredas` (`Id_Barrios_Veredas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos` (
  `Id_Documento` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Estado_Documento` int DEFAULT '1',
  PRIMARY KEY (`Id_Documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documentos_soporte`
--

DROP TABLE IF EXISTS `documentos_soporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_soporte` (
  `Id_Documentos` int NOT NULL AUTO_INCREMENT,
  `Camara_Comercio` varchar(45) NOT NULL,
  `Cedula_RL` varchar(45) NOT NULL,
  `Soporte_Ingresos` varchar(45) NOT NULL,
  `Detalles_Plan_Corporativo` varchar(45) DEFAULT NULL,
  `Oferta` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_Documentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `Id_Empleado` int NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int DEFAULT NULL,
  `Documento` varchar(45) DEFAULT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Apellidos` varchar(45) DEFAULT NULL,
  `Email` varchar(45) NOT NULL,
  `Id_Sexo` int DEFAULT NULL,
  `Celular` varchar(10) DEFAULT 'No tiene',
  `Imagen` varchar(45) DEFAULT NULL,
  `Id_Turno` int DEFAULT NULL,
  `Email_Valido` int DEFAULT NULL,
  PRIMARY KEY (`Id_Empleado`),
  KEY `fk_Empleados_Sexo1_idx` (`Id_Sexo`),
  KEY `fk_Empleados_Documentos1_idx` (`Tipo_Documento`),
  KEY `fk_Empleados_Turnos1_idx` (`Id_Turno`),
  CONSTRAINT `fk_Empleados_Documentos1` FOREIGN KEY (`Tipo_Documento`) REFERENCES `documentos` (`Id_Documento`),
  CONSTRAINT `fk_Empleados_Sexo1` FOREIGN KEY (`Id_Sexo`) REFERENCES `sexos` (`Id_Sexo`),
  CONSTRAINT `fk_Empleados_Turnos1` FOREIGN KEY (`Id_Turno`) REFERENCES `turnos` (`Id_Turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `empresas_asignadas`
--

DROP TABLE IF EXISTS `empresas_asignadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas_asignadas` (
  `Id_Empresa_Asignada` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Cliente` int NOT NULL,
  `Estado_Asignacion` int NOT NULL,
  PRIMARY KEY (`Id_Empresa_Asignada`),
  KEY `fk_Empresas_Asignadas_Usuarios1_idx` (`Id_Usuario`),
  KEY `fk_Empresas_Asignadas_Directorio1_idx` (`Id_Cliente`),
  CONSTRAINT `fk_Empresas_Asignadas_Directorio1` FOREIGN KEY (`Id_Cliente`) REFERENCES `directorio` (`Id_Cliente`),
  CONSTRAINT `fk_Empresas_Asignadas_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_citas`
--

DROP TABLE IF EXISTS `estados_citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_citas` (
  `Id_Estado_Cita` int NOT NULL AUTO_INCREMENT,
  `Estado_Cita` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_Estado_Cita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_dbl`
--

DROP TABLE IF EXISTS `estados_dbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_dbl` (
  `Id_Estado_DBL` int NOT NULL AUTO_INCREMENT,
  `Estado_DBL` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_Estado_DBL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_llamadas`
--

DROP TABLE IF EXISTS `estados_llamadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_llamadas` (
  `Id_Estado_Llamada` int NOT NULL AUTO_INCREMENT,
  `Estado_Llamada` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_Estado_Llamada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_lp`
--

DROP TABLE IF EXISTS `estados_lp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_lp` (
  `Id_Estado_LP` int NOT NULL AUTO_INCREMENT,
  `Estado_LP` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_Estado_LP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_oferta`
--

DROP TABLE IF EXISTS `estados_oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_oferta` (
  `Id_Estado_Oferta` int NOT NULL AUTO_INCREMENT,
  `Estado_Oferta` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_Estado_Oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estados_visita`
--

DROP TABLE IF EXISTS `estados_visita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_visita` (
  `Id_Estado_Visita` int NOT NULL AUTO_INCREMENT,
  `Estado_Visita` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_Estado_Visita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `importar_clientes`
--

DROP TABLE IF EXISTS `importar_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `importar_clientes` (
  `Id_Importar_Cliente` int NOT NULL AUTO_INCREMENT,
  `NIT` varchar(45) DEFAULT NULL,
  `Razon_Social` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Extension` varchar(45) DEFAULT NULL,
  `Encargado` varchar(45) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `Celular` varchar(45) DEFAULT NULL,
  `Direccion` varchar(45) DEFAULT NULL,
  `Municipio` varchar(45) DEFAULT NULL,
  `Barrio` varchar(45) DEFAULT NULL,
  `Tiene_PC` varchar(45) DEFAULT NULL,
  `Operador_Actual` varchar(45) DEFAULT NULL,
  `Cantidad_Total_Lineas` varchar(45) DEFAULT NULL,
  `Valor_Total_Mensual` varchar(45) DEFAULT NULL,
  `Calificacion` varchar(45) DEFAULT NULL,
  `Razones` varchar(45) DEFAULT NULL,
  `Fecha_Inicio` varchar(45) DEFAULT NULL,
  `Fecha_Fin` varchar(45) DEFAULT NULL,
  `Clausula_Permanencia` varchar(45) DEFAULT NULL,
  `Descripcion` text,
  `Estado_Cliente_Importado` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Importar_Cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lineas_fijas`
--

DROP TABLE IF EXISTS `lineas_fijas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lineas_fijas` (
  `Id_Linea_Fija` int NOT NULL AUTO_INCREMENT,
  `Pagina_Web` int DEFAULT NULL,
  `Correo_Electronico` int DEFAULT NULL,
  `IP_Fija` int DEFAULT NULL,
  `Dominio` int DEFAULT NULL,
  `Telefonia` int DEFAULT NULL,
  `Television` int DEFAULT NULL,
  PRIMARY KEY (`Id_Linea_Fija`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lineas_moviles`
--

DROP TABLE IF EXISTS `lineas_moviles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lineas_moviles` (
  `Id_Linea_Movil` int NOT NULL AUTO_INCREMENT,
  `Linea` varchar(10) DEFAULT NULL,
  `Minutos` varchar(45) DEFAULT NULL,
  `Navegacion` varchar(45) DEFAULT NULL,
  `Mensajes` varchar(45) DEFAULT NULL,
  `Minutos_LDI` varchar(45) DEFAULT NULL,
  `Cantidad_LDI` varchar(45) DEFAULT NULL,
  `Servicios_Ilimitados` varchar(45) DEFAULT NULL,
  `Servicios_Adicionales` varchar(100) DEFAULT NULL,
  `Cargo_Basico` varchar(45) DEFAULT NULL,
  `Grupo` int DEFAULT NULL,
  PRIMARY KEY (`Id_Linea_Movil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `llamadas`
--

DROP TABLE IF EXISTS `llamadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `llamadas` (
  `Id_Llamada` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Cliente` int DEFAULT NULL,
  `Persona_Responde` varchar(45) DEFAULT NULL,
  `Fecha_Llamada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Duracion_Llamada` time NOT NULL,
  `Info_Habeas_Data` int NOT NULL,
  `Observacion` text NOT NULL,
  `Id_Estado_Llamada` int NOT NULL,
  PRIMARY KEY (`Id_Llamada`),
  KEY `fk_Llamadas_estado_lllamads1_idx` (`Id_Estado_Llamada`),
  KEY `fk_Llamadas_Usuarios1_idx` (`Id_Usuario`),
  KEY `fk_Llamadas_Directorio1_idx` (`Id_Cliente`),
  CONSTRAINT `fk_Llamadas_Directorio1` FOREIGN KEY (`Id_Cliente`) REFERENCES `directorio` (`Id_Cliente`),
  CONSTRAINT `fk_Llamadas_estado_lllamads1` FOREIGN KEY (`Id_Estado_Llamada`) REFERENCES `estados_llamadas` (`Id_Estado_Llamada`),
  CONSTRAINT `fk_Llamadas_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `llamadas_programadas`
--

DROP TABLE IF EXISTS `llamadas_programadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `llamadas_programadas` (
  `Id_LP` int NOT NULL AUTO_INCREMENT,
  `Id_Llamada` int DEFAULT NULL,
  `Id_Cita` int DEFAULT NULL,
  `Id_Visita` int DEFAULT NULL,
  `Fecha_LP` datetime NOT NULL,
  `Estado_LP` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_LP`),
  KEY `fk_Llamadas_Citas_Programadas_Citas1_idx` (`Id_Cita`),
  KEY `fk_Llamadas_Programadas_Llamadas1_idx` (`Id_Llamada`),
  KEY `fk_Llamadas_Programadas_Visita_Interna1_idx` (`Id_Visita`),
  KEY `fk_Llamadas_Programadas_Estados_LP1_idx` (`Estado_LP`),
  CONSTRAINT `fk_Llamadas_Citas_Programadas_Citas1` FOREIGN KEY (`Id_Cita`) REFERENCES `citas` (`Id_Cita`),
  CONSTRAINT `fk_Llamadas_Programadas_Estados_LP1` FOREIGN KEY (`Estado_LP`) REFERENCES `estados_lp` (`Id_Estado_LP`),
  CONSTRAINT `fk_Llamadas_Programadas_Llamadas1` FOREIGN KEY (`Id_Llamada`) REFERENCES `llamadas` (`Id_Llamada`),
  CONSTRAINT `fk_Llamadas_Programadas_Visita_Interna1` FOREIGN KEY (`Id_Visita`) REFERENCES `visitas` (`Id_Visita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `municipios`
--

DROP TABLE IF EXISTS `municipios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `municipios` (
  `Id_Municipio` int NOT NULL AUTO_INCREMENT,
  `Nombre_Municipio` varchar(45) DEFAULT NULL,
  `Id_Departamento` int NOT NULL,
  `Estado` int DEFAULT NULL,
  PRIMARY KEY (`Id_Municipio`),
  KEY `fk_Municipios_Departamento1_idx` (`Id_Departamento`),
  CONSTRAINT `fk_Municipios_Departamento1` FOREIGN KEY (`Id_Departamento`) REFERENCES `departamento` (`Id_Departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `Id_Nota` int NOT NULL AUTO_INCREMENT,
  `Nota` varchar(255) NOT NULL,
  `Id_Oferta` int NOT NULL,
  PRIMARY KEY (`Id_Nota`),
  KEY `fk_Notas_Ofertas1_idx` (`Id_Oferta`),
  CONSTRAINT `fk_Notas_Ofertas1` FOREIGN KEY (`Id_Oferta`) REFERENCES `ofertas` (`Id_Oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noticias` (
  `Id_Noticia` int NOT NULL,
  `Titulo` varchar(45) NOT NULL,
  `Descripcion` text NOT NULL,
  `Imagen` longblob,
  `Fecha` datetime DEFAULT NULL,
  `Id_Usuario` int NOT NULL,
  PRIMARY KEY (`Id_Noticia`),
  KEY `fk_Noticias_Usuarios1_idx` (`Id_Usuario`),
  CONSTRAINT `fk_Noticias_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `Id_Notificacion` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Categoria_N` int NOT NULL,
  `Fecha_Notificacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Mensaje` varchar(45) NOT NULL,
  `Id_Registro` int DEFAULT NULL,
  PRIMARY KEY (`Id_Notificacion`),
  KEY `fk_Notificaciones_Usuarios1_idx` (`Id_Usuario`),
  KEY `fk_Notificaciones_Categorias_Notificacion1_idx` (`Id_Categoria_N`),
  CONSTRAINT `fk_Notificaciones_Categorias_Notificacion1` FOREIGN KEY (`Id_Categoria_N`) REFERENCES `categorias_notificacion` (`Id_Categoria_N`),
  CONSTRAINT `fk_Notificaciones_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notificaciones_usuarios`
--

DROP TABLE IF EXISTS `notificaciones_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones_usuarios` (
  `Id_NU` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Notificacion` int NOT NULL,
  `Estado_Lectura` int NOT NULL DEFAULT '0',
  `Estado_Visita` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_NU`),
  KEY `fk_Notificaciones_Usuarios_Usuarios1_idx` (`Id_Usuario`),
  KEY `fk_Notificaciones_Usuarios_Notificaciones1_idx` (`Id_Notificacion`),
  CONSTRAINT `fk_Notificaciones_Usuarios_Notificaciones1` FOREIGN KEY (`Id_Notificacion`) REFERENCES `notificaciones` (`Id_Notificacion`),
  CONSTRAINT `fk_Notificaciones_Usuarios_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novedades`
--

DROP TABLE IF EXISTS `novedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `novedades` (
  `Id_Novedad` int NOT NULL AUTO_INCREMENT,
  `Descripcion_Novedad` text NOT NULL,
  `Estado_Novedad` varchar(45) NOT NULL,
  `Fecha_Novedad` datetime NOT NULL,
  `Id_Cita` int NOT NULL,
  PRIMARY KEY (`Id_Novedad`),
  KEY `fk_Novedades_Citas1_idx` (`Id_Cita`),
  CONSTRAINT `fk_Novedades_Citas1` FOREIGN KEY (`Id_Cita`) REFERENCES `citas` (`Id_Cita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oferta_estandar`
--

DROP TABLE IF EXISTS `oferta_estandar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oferta_estandar` (
  `Id_OE` int NOT NULL AUTO_INCREMENT,
  `Id_Oferta` int NOT NULL,
  `Id_Propuesta` int NOT NULL,
  PRIMARY KEY (`Id_OE`),
  KEY `fk_Pre_Oferta_Estantar_Propuestas1_idx` (`Id_Propuesta`),
  KEY `fk_Pre_Oferta_Estandar_Ofertas1_idx` (`Id_Oferta`),
  CONSTRAINT `fk_Pre_Oferta_Estandar_Ofertas1` FOREIGN KEY (`Id_Oferta`) REFERENCES `ofertas` (`Id_Oferta`),
  CONSTRAINT `fk_Pre_Oferta_Estantar_Propuestas1` FOREIGN KEY (`Id_Propuesta`) REFERENCES `propuestas` (`Id_Propuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oferta_personalizada`
--

DROP TABLE IF EXISTS `oferta_personalizada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oferta_personalizada` (
  `Id_OP` int NOT NULL AUTO_INCREMENT,
  `Id_Oferta` int NOT NULL,
  `Id_Corporativo_Anterior` int NOT NULL,
  `Id_Corporativo_Actual` int NOT NULL,
  `Basico_Neto_Operador1` varchar(45) DEFAULT NULL,
  `Basico_Neto_Operador2` varchar(45) DEFAULT NULL,
  `Valor_Neto_Operador1` varchar(45) DEFAULT NULL,
  `Valor_Bruto_Operador2` varchar(45) DEFAULT NULL,
  `Bono_Activacion` varchar(45) DEFAULT NULL,
  `Valor_Neto_Operador2` varchar(45) DEFAULT NULL,
  `Total_Ahorro` varchar(45) DEFAULT NULL,
  `Reduccion_Anual` varchar(45) DEFAULT NULL,
  `Valor_Mes_Promedio` varchar(45) DEFAULT NULL,
  `Ahorro_Mensual_Promedio` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id_OP`),
  KEY `fk_Detalle_Venta_Corporativos_Anteriores1_idx` (`Id_Corporativo_Anterior`),
  KEY `fk_Detalle_Venta_Corporativos_Actuales1_idx` (`Id_Corporativo_Actual`),
  KEY `fk_Pre_Oferta_Personalizada_Ofertas1_idx` (`Id_Oferta`),
  CONSTRAINT `fk_Detalle_Venta_Corporativos_Actuales1` FOREIGN KEY (`Id_Corporativo_Actual`) REFERENCES `corporativos_actuales` (`Id_Corporativo_Actual`),
  CONSTRAINT `fk_Detalle_Venta_Corporativos_Anteriores1` FOREIGN KEY (`Id_Corporativo_Anterior`) REFERENCES `corporativos_anteriores` (`Id_Corporativo_Anterior`),
  CONSTRAINT `fk_Pre_Oferta_Personalizada_Ofertas1` FOREIGN KEY (`Id_Oferta`) REFERENCES `ofertas` (`Id_Oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ofertas` (
  `Id_Oferta` int NOT NULL AUTO_INCREMENT,
  `Id_AT` int DEFAULT NULL,
  `Id_Visita` int DEFAULT NULL,
  `Nombre_Cliente` varchar(45) DEFAULT NULL,
  `Mensaje_Superior` varchar(255) DEFAULT NULL,
  `Tipo_Oferta` int NOT NULL,
  `Respuesta_Cliente` text,
  `Fecha_Activacion` datetime DEFAULT NULL,
  `Id_Estado_Oferta` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Oferta`),
  KEY `fk_Pre_Ofertas_Estados_Pre_Oferta1_idx` (`Id_Estado_Oferta`),
  KEY `fk_Pre_Ofertas_Atencion_Telefonica1_idx` (`Id_AT`),
  KEY `fk_Pre_Ofertas_Visitas1_idx` (`Id_Visita`),
  CONSTRAINT `fk_Pre_Ofertas_Atencion_Telefonica1` FOREIGN KEY (`Id_AT`) REFERENCES `atencion_telefonica` (`Id_AT`),
  CONSTRAINT `fk_Pre_Ofertas_Estados_Pre_Oferta1` FOREIGN KEY (`Id_Estado_Oferta`) REFERENCES `estados_oferta` (`Id_Estado_Oferta`),
  CONSTRAINT `fk_Pre_Ofertas_Visitas1` FOREIGN KEY (`Id_Visita`) REFERENCES `visitas` (`Id_Visita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opciones_predefinidas`
--

DROP TABLE IF EXISTS `opciones_predefinidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opciones_predefinidas` (
  `Id_OP` int NOT NULL AUTO_INCREMENT,
  `Opcion` varchar(255) NOT NULL,
  `Categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`Id_OP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operador_asesores`
--

DROP TABLE IF EXISTS `operador_asesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operador_asesores` (
  `Id_Operador_Asesores` int NOT NULL AUTO_INCREMENT,
  `Id_Usuario` int NOT NULL,
  `Id_Operador` int NOT NULL,
  PRIMARY KEY (`Id_Operador_Asesores`),
  KEY `fk_Operador_Asesores_Operadores1_idx` (`Id_Operador`),
  KEY `fk_Operador_Asesores_Usuarios1_idx` (`Id_Usuario`),
  CONSTRAINT `fk_Operador_Asesores_Operadores1` FOREIGN KEY (`Id_Operador`) REFERENCES `operadores` (`Id_Operador`),
  CONSTRAINT `fk_Operador_Asesores_Usuarios1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operadores`
--

DROP TABLE IF EXISTS `operadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operadores` (
  `Id_Operador` int NOT NULL AUTO_INCREMENT,
  `Nombre_Operador` varchar(45) NOT NULL,
  `Color` varchar(45) NOT NULL,
  `Genera_Oferta` int NOT NULL,
  `Correo_Operador` varchar(45) DEFAULT NULL,
  `Contrasena_Operador` varchar(45) DEFAULT NULL,
  `Imagen_Operador` varchar(45) NOT NULL,
  `Estado_Operador` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pais` (
  `Id_Pais` int NOT NULL AUTO_INCREMENT,
  `Nombre_Pais` varchar(45) DEFAULT NULL,
  `Estado` int DEFAULT NULL,
  PRIMARY KEY (`Id_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plan_corporativo`
--

DROP TABLE IF EXISTS `plan_corporativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_corporativo` (
  `Id_Plan_Corporativo` int NOT NULL AUTO_INCREMENT,
  `Id_Documentos` int DEFAULT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Fin` date DEFAULT NULL,
  `Clausula_Permanencia` int DEFAULT NULL,
  `Descripcion` text,
  `Estado_Plan_Corporativo` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Plan_Corporativo`),
  KEY `fk_Plan_Corporativo_Documentos_Soporte1_idx` (`Id_Documentos`),
  CONSTRAINT `fk_Plan_Corporativo_Documentos_Soporte1` FOREIGN KEY (`Id_Documentos`) REFERENCES `documentos_soporte` (`Id_Documentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `presentacion_corporativa`
--

DROP TABLE IF EXISTS `presentacion_corporativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presentacion_corporativa` (
  `Id_Presentacion_Corporativa` int NOT NULL AUTO_INCREMENT,
  `Quienes_somos` varchar(300) DEFAULT NULL,
  `Presentacion_Corporativacol` varchar(45) DEFAULT NULL,
  `Mision` varchar(300) DEFAULT NULL,
  `Principios_descripcion` varchar(300) DEFAULT NULL,
  `Nuestra_escencia` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`Id_Presentacion_Corporativa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `principios`
--

DROP TABLE IF EXISTS `principios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `principios` (
  `Id_Principios` int NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(45) DEFAULT NULL,
  `Descripcion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`Id_Principios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `propuestas`
--

DROP TABLE IF EXISTS `propuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propuestas` (
  `Id_Propuesta` int NOT NULL AUTO_INCREMENT,
  `Cantidad_Lineas` int NOT NULL,
  `Id_Linea_Movil` int NOT NULL,
  PRIMARY KEY (`Id_Propuesta`),
  KEY `fk_Propuestas_Lineas_Moviles1_idx` (`Id_Linea_Movil`),
  CONSTRAINT `fk_Propuestas_Lineas_Moviles1` FOREIGN KEY (`Id_Linea_Movil`) REFERENCES `lineas_moviles` (`Id_Linea_Movil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `Id_Rol` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `Estado` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id_Rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sexos`
--

DROP TABLE IF EXISTS `sexos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sexos` (
  `Id_Sexo` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Estado` int DEFAULT '1',
  PRIMARY KEY (`Id_Sexo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subtipo_barrio_vereda`
--

DROP TABLE IF EXISTS `subtipo_barrio_vereda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subtipo_barrio_vereda` (
  `Id_SubTipo_Barrio_Vereda` int NOT NULL AUTO_INCREMENT,
  `SubTipo` varchar(45) NOT NULL,
  `Estado` int DEFAULT '1',
  PRIMARY KEY (`Id_SubTipo_Barrio_Vereda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `turnos`
--

DROP TABLE IF EXISTS `turnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `turnos` (
  `Id_Turno` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Inicio` time DEFAULT NULL,
  `Fin` time DEFAULT NULL,
  `Estado` int DEFAULT '1',
  PRIMARY KEY (`Id_Turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `Id_Usuario` int NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(45) NOT NULL,
  `Contrasena` varchar(60) NOT NULL,
  `Id_Conexion_Usuario` int NOT NULL DEFAULT '6',
  `Id_Rol` int NOT NULL,
  `Id_Empleado` int NOT NULL,
  `Estado_Usuario` int NOT NULL DEFAULT '0',
  `Token` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`Id_Usuario`),
  UNIQUE KEY `Usuario_UNIQUE` (`Usuario`),
  KEY `fk_Usuarios_Roles1_idx` (`Id_Rol`),
  KEY `fk_Usuarios_Empleados1_idx` (`Id_Empleado`),
  KEY `fk_Usuarios_Conexiones_Usuario1_idx` (`Id_Conexion_Usuario`),
  CONSTRAINT `fk_Usuarios_Conexiones_Usuario1` FOREIGN KEY (`Id_Conexion_Usuario`) REFERENCES `conexiones_usuario` (`Id_Conexion_Usuario`),
  CONSTRAINT `fk_Usuarios_Empleados1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleados` (`Id_Empleado`),
  CONSTRAINT `fk_Usuarios_Roles1` FOREIGN KEY (`Id_Rol`) REFERENCES `roles` (`Id_Rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visita_externa`
--

DROP TABLE IF EXISTS `visita_externa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visita_externa` (
  `Id_Visita_Externa` int NOT NULL AUTO_INCREMENT,
  `Id_Asesor` int NOT NULL,
  `Id_Datos_Visita` int NOT NULL,
  `Id_Cliente` int NOT NULL,
  PRIMARY KEY (`Id_Visita_Externa`),
  KEY `fk_Visita_Externa_Usuarios1_idx` (`Id_Asesor`),
  KEY `fk_Visita_Externa_Datos_Visita1_idx` (`Id_Datos_Visita`),
  KEY `fk_Visita_Externa_Directorio1_idx` (`Id_Cliente`),
  CONSTRAINT `fk_Visita_Externa_Datos_Visita1` FOREIGN KEY (`Id_Datos_Visita`) REFERENCES `datos_visita` (`Id_Datos_Visita`),
  CONSTRAINT `fk_Visita_Externa_Directorio1` FOREIGN KEY (`Id_Cliente`) REFERENCES `directorio` (`Id_Cliente`),
  CONSTRAINT `fk_Visita_Externa_Usuarios1` FOREIGN KEY (`Id_Asesor`) REFERENCES `usuarios` (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visitas`
--

DROP TABLE IF EXISTS `visitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitas` (
  `Id_Visita` int NOT NULL AUTO_INCREMENT,
  `Tipo_Visita` int NOT NULL,
  `Id_Asesor` int NOT NULL,
  `Id_Cita` int NOT NULL,
  `Id_Datos_Visita` int DEFAULT NULL,
  `Id_Estado_Visita` int NOT NULL,
  PRIMARY KEY (`Id_Visita`),
  KEY `fk_Visita_Interna_Datos_Visita1_idx` (`Id_Datos_Visita`),
  KEY `fk_Visita_Interna_Usuarios1_idx` (`Id_Asesor`),
  KEY `fk_Visitas_Citas1_idx` (`Id_Cita`),
  KEY `fk_Visitas_Estados_Visita1_idx` (`Id_Estado_Visita`),
  CONSTRAINT `fk_Visita_Interna_Datos_Visita1` FOREIGN KEY (`Id_Datos_Visita`) REFERENCES `datos_visita` (`Id_Datos_Visita`),
  CONSTRAINT `fk_Visita_Interna_Usuarios1` FOREIGN KEY (`Id_Asesor`) REFERENCES `usuarios` (`Id_Usuario`),
  CONSTRAINT `fk_Visitas_Citas1` FOREIGN KEY (`Id_Cita`) REFERENCES `citas` (`Id_Cita`),
  CONSTRAINT `fk_Visitas_Estados_Visita1` FOREIGN KEY (`Id_Estado_Visita`) REFERENCES `estados_visita` (`Id_Estado_Visita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-21 10:03:43
