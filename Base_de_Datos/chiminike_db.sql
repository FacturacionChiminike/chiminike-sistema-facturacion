-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 11-08-2025 a las 13:45:03
-- Versión del servidor: 8.0.36
-- Versión de PHP: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chiminike_db`
--

DELIMITER $$
--
-- Procedimientos
--
$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adicionales`
--

CREATE TABLE `adicionales` (
  `cod_adicional` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `adicionales`
--

INSERT INTO `adicionales` (`cod_adicional`, `nombre`, `descripcion`, `precio`) VALUES
(10, 'CASITA DEL EQUILIBROS', 'Por persona', 25.00),
(11, 'MERIENDA', 'Por persona', 50.00),
(12, 'PARQUE VIAL', 'Por persona', 50.00),
(14, 'taller', 'taller', 35.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `objeto` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `datos_antes` json DEFAULT NULL,
  `datos_despues` json DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `cod_usuario`, `objeto`, `accion`, `datos_antes`, `datos_despues`, `fecha`) VALUES
(1, 23, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 01:14:35'),
(2, 23, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 01:20:09'),
(3, 23, 'Empleado', 'Crear', NULL, '{\"dni\": \"0801262524224\", \"sexo\": \"Masculino\", \"cargo\": \"Soporte Técnico\", \"correo\": \"miguelgarcia9647@gmail.com\", \"cod_rol\": \"1\", \"salario\": \"25000\", \"telefono\": \"97497264\", \"direccion\": \"Canaán\", \"creado_por\": \"miguel.garcia063\", \"cod_municipio\": \"110\", \"nombre_persona\": \"Miguel Angel Garcia Barahona\", \"nombre_usuario\": \"mbarahona.224\", \"cod_tipo_usuario\": \"1\", \"fecha_nacimiento\": \"2000-12-12\", \"fecha_contratacion\": \"2025-02-04\", \"cod_departamento_empresa\": \"1\"}', '2025-08-11 01:39:30'),
(4, 40, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 01:43:16'),
(5, 40, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 01:46:45'),
(6, 40, 'Usuario', 'Actualizar', '{\"estado\": 1, \"cod_rol\": 1, \"nombre_rol\": \"Dirección\", \"cod_usuario\": 22, \"nombre_usuario\": \"kellyn.castillo623\", \"nombre_empleado\": \"Kellyn Castillo\", \"cod_tipo_usuario\": 1, \"nombre_tipo_usuario\": \"Interno\"}', '{\"estado\": 1, \"cod_rol\": \"1\", \"cod_tipo_usuario\": \"1\"}', '2025-08-11 01:50:40'),
(7, 40, 'Permiso', 'Eliminar', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Eliminación de Permiso desde IP 127.0.0.1\"}', '2025-08-11 02:02:45'),
(8, 40, 'Rol', 'Actualizar', '{\"estado\": 1, \"nombre\": \"Dirección\", \"cod_rol\": 1, \"descripcion\": \"probando api con laravel\"}', '{\"estado\": 1, \"nombre\": \"Dirección\", \"descripcion\": \"Acceso total al sistema\"}', '2025-08-11 02:03:12'),
(9, 40, 'Rol', 'Actualizar', '{\"estado\": 1, \"nombre\": \"Factaquilla\", \"cod_rol\": 5, \"descripcion\": null}', '{\"estado\": 1, \"nombre\": \"Factaquilla\", \"descripcion\": \"Facturación de taquilla\"}', '2025-08-11 02:03:32'),
(10, 40, 'Objeto', 'Eliminar', '{\"cod_objeto\": 19, \"descripcion\": \"sirve?\", \"tipo_objeto\": \"probadno csosas\"}', '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Eliminación de Objeto desde IP 127.0.0.1\"}', '2025-08-11 02:03:50'),
(11, 40, 'Objeto', 'Eliminar', '{\"cod_objeto\": 17, \"descripcion\": \"hola soy las pruebas\", \"tipo_objeto\": \"solo le puse 30\"}', '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Eliminación de Objeto desde IP 127.0.0.1\"}', '2025-08-11 02:03:57'),
(12, 25, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 03:17:28'),
(13, 25, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 03:21:58'),
(14, 25, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 03:23:13'),
(15, 25, 'CAI', 'Actualizar', NULL, '{\"cai\": \"8512A-CCECDB-6D43BE-244D81-D2B15E-C6\", \"estado\": 1, \"rango_desde\": \"000-001-01-000000100\", \"rango_hasta\": \"000-001-01-000099999\", \"fecha_limite\": \"2025-10-31\"}', '2025-08-11 03:36:06'),
(16, 25, 'CAI', 'Eliminar', '{\"cai\": \"123-123-12323\", \"estado\": \"Activo\", \"cod_cai\": 6, \"rango_desde\": \"001-001-111\", \"rango_hasta\": \"001-001-200\", \"fecha_limite\": \"2025-08-27T00:00:00.000Z\"}', '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Eliminación de CAI desde IP 127.0.0.1\"}', '2025-08-11 03:36:12'),
(17, 25, 'CAI', 'Eliminar', '{\"cai\": \"123-123-12323\", \"estado\": \"Activo\", \"cod_cai\": 6, \"rango_desde\": \"001-001-111\", \"rango_hasta\": \"001-001-200\", \"fecha_limite\": \"2025-08-27T00:00:00.000Z\"}', '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Eliminación de CAI desde IP 127.0.0.1\"}', '2025-08-11 03:36:18'),
(18, 25, 'Cotización', 'Crear', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Creación de Cotización desde IP 127.0.0.1\"}', '2025-08-11 04:22:03'),
(19, 25, 'Cotización', 'Crear', NULL, '{\"evento\": {\"hora_evento\": \"01:21\", \"fecha_evento\": \"2025-08-14\", \"horas_evento\": 5, \"evento_nombre\": \"fiesta de kelly\"}, \"cliente\": {\"dni\": null, \"rtn\": null, \"sexo\": null, \"correo\": null, \"nombre\": null, \"telefono\": null, \"direccion\": null, \"cod_cliente\": 41, \"tipo_cliente\": null, \"cod_municipio\": null, \"fecha_nacimiento\": null}, \"productos\": [{\"cantidad\": 5, \"descripcion\": \"SALON CULTURAL\", \"precio_unitario\": 10120}], \"cod_cotizacion\": 72}', '2025-08-11 04:22:03'),
(20, 26, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 04:32:25'),
(21, 25, 'Login', 'Acceso', NULL, '{\"ip\": \"127.0.0.1\", \"mensaje\": \"Inicio de sesión exitoso desde IP 127.0.0.1\"}', '2025-08-11 05:33:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cai`
--

CREATE TABLE `cai` (
  `cod_cai` int NOT NULL,
  `cai` varchar(100) NOT NULL,
  `rango_desde` varchar(25) NOT NULL,
  `rango_hasta` varchar(25) NOT NULL,
  `fecha_limite` date NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cai`
--

INSERT INTO `cai` (`cod_cai`, `cai`, `rango_desde`, `rango_hasta`, `fecha_limite`, `estado`, `creado_en`) VALUES
(3, 'CAI-TEST-123456-Ulmate', '00020001', '00150000', '2025-12-19', 0, '2025-06-13 16:34:02'),
(4, 'CAI-2025-009-actualizado', '00020001', '00150000', '2025-10-15', 0, '2025-06-15 21:20:49'),
(5, '8512A-CCECDB-6D43BE-244D81-D2B15E-C6', '000-001-01-000000100', '000-001-01-000099999', '2025-10-31', 1, '2025-07-18 06:19:27'),
(6, '123-123-12323', '001-001-111', '001-001-200', '2025-08-27', 0, '2025-08-08 21:41:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cod_cliente` int NOT NULL,
  `rtn` varchar(20) DEFAULT NULL,
  `tipo_cliente` enum('Individual','Empresa') DEFAULT NULL,
  `cod_persona` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `rtn`, `tipo_cliente`, `cod_persona`) VALUES
(32, '12566787656766', 'Individual', 74),
(33, '09123657668254', 'Individual', 75),
(34, '66651972090132', 'Individual', 76),
(36, '09322761498256', 'Individual', 78),
(37, '82530142736244', 'Individual', 79),
(38, '01211583592375', 'Individual', 80),
(39, '06527783249125', 'Individual', 81),
(40, '0801200013219', 'Individual', 82),
(41, '08012005047923', 'Individual', 84),
(42, '234', 'Individual', 89),
(44, '08054616494949', 'Individual', 91),
(48, '08012222222222', 'Individual', 99),
(50, '08012001311209', 'Individual', 103),
(51, NULL, NULL, 107),
(52, 'XXXXXXXXXXXXX', 'Individual', 108),
(53, '08019282726260', 'Individual', 112);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativos_factura`
--

CREATE TABLE `correlativos_factura` (
  `cod_correlativo` int NOT NULL,
  `cod_cai` int NOT NULL,
  `siguiente_numero` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `correlativos_factura`
--

INSERT INTO `correlativos_factura` (`cod_correlativo`, `cod_cai`, `siguiente_numero`) VALUES
(1, 4, '00020001-00020020'),
(3, 5, '000-001-01-000000133'),
(4, 3, '-00020002'),
(5, 6, '001-001-114');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `cod_correo` int NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `cod_persona` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`cod_correo`, `correo`, `cod_persona`) VALUES
(58, 'kellyncastillo1203@gmail.com', 72),
(60, 'kellyncastillo1203@gmail.com', 74),
(61, 'yamilethflores1203@gmail.com', 75),
(62, 'lmolinam05@gmail.com', 76),
(64, 'darwinucles43@gmail.com', 78),
(65, 'obandoroger0@gmail.com', 79),
(66, 'eljosuemeraz@gmail.com', 80),
(67, 'jeremymejia890@gmail.com', 81),
(68, 'michitogarcia.mg@gmail.com', 82),
(70, 'lmolinam05@gmail.com', 84),
(71, 'lmolinam3000@gmail.com', 86),
(72, 'jeremymejia890@gmail.com', 87),
(73, 'eljosuemeraz@gmail.com', 88),
(74, 'dasdq@gmail.com', 89),
(76, 'sadasd@gmail.com', 91),
(81, 'aldairfigueroa09@gmail.com', 96),
(84, 'kellyn@gmail.com', 99),
(85, 'obandoroger@gmail.com', 100),
(88, 'hipernova504@gmail.com', 103),
(92, NULL, 107),
(93, NULL, 108),
(96, 'unah.chimitech1@gmail.com', 111),
(97, 'ehwhw@gmail.com', 112),
(99, 'miguelgarcia9647@gmail.com', 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `cod_cotizacion` int NOT NULL,
  `cod_cliente` int NOT NULL,
  `fecha` date NOT NULL DEFAULT (curdate()),
  `fecha_validez` date NOT NULL,
  `estado` enum('pendiente','confirmada','expirada','completada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`cod_cotizacion`, `cod_cliente`, `fecha`, `fecha_validez`, `estado`) VALUES
(37, 32, '2025-07-06', '2025-07-11', 'completada'),
(38, 33, '2025-07-06', '2025-07-11', 'completada'),
(39, 34, '2025-07-06', '2025-07-11', 'completada'),
(42, 36, '2025-07-06', '2025-07-11', 'completada'),
(43, 36, '2025-07-06', '2025-07-11', 'pendiente'),
(44, 37, '2025-07-06', '2025-07-11', 'completada'),
(45, 37, '2025-07-06', '2025-07-11', 'expirada'),
(46, 38, '2025-07-06', '2025-07-11', 'completada'),
(47, 39, '2025-07-06', '2025-07-11', 'expirada'),
(48, 38, '2025-07-06', '2025-07-11', 'expirada'),
(49, 40, '2025-07-07', '2025-07-12', 'expirada'),
(50, 40, '2025-07-07', '2025-07-12', 'expirada'),
(53, 41, '2025-07-09', '2025-07-09', 'confirmada'),
(54, 36, '2025-07-10', '2025-07-10', 'completada'),
(55, 32, '2025-07-10', '2025-07-10', 'confirmada'),
(56, 32, '2025-07-10', '2025-07-10', 'confirmada'),
(57, 32, '2025-07-10', '2025-07-10', 'confirmada'),
(58, 32, '2025-07-10', '2025-07-10', 'completada'),
(59, 40, '2025-07-13', '2025-07-18', 'completada'),
(60, 40, '2025-07-17', '2025-07-22', 'completada'),
(61, 36, '2025-07-17', '2025-07-22', 'confirmada'),
(62, 32, '2025-07-17', '2025-07-22', 'completada'),
(63, 32, '2025-07-31', '2025-08-05', 'confirmada'),
(64, 40, '2025-08-03', '2025-08-08', 'completada'),
(65, 32, '2025-08-03', '2025-08-08', 'completada'),
(66, 32, '2025-08-03', '2025-08-08', 'completada'),
(67, 50, '2025-08-03', '2025-08-08', 'expirada'),
(68, 50, '2025-08-03', '2025-08-08', 'pendiente'),
(69, 32, '2025-08-04', '2025-08-09', 'completada'),
(70, 32, '2025-08-09', '2025-08-14', 'pendiente'),
(71, 40, '2025-08-10', '2025-08-15', 'pendiente'),
(72, 41, '2025-08-11', '2025-08-16', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `cod_departamento` int NOT NULL,
  `departamento` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`cod_departamento`, `departamento`) VALUES
(1, 'Atlántida'),
(2, 'Choluteca'),
(3, 'Colón'),
(4, 'Comayagua'),
(5, 'Copán'),
(6, 'Cortés'),
(7, 'El Paraíso'),
(8, 'Francisco Morazán'),
(9, 'Gracias a Dios'),
(10, 'Intibucá'),
(11, 'Islas de la Bahía'),
(12, 'La Paz'),
(13, 'Lempira'),
(14, 'Ocotepeque'),
(15, 'Olancho'),
(16, 'Santa Bárbara'),
(17, 'Valle'),
(18, 'Yoro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_empresa`
--

CREATE TABLE `departamento_empresa` (
  `cod_departamento_empresa` int NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `departamento_empresa`
--

INSERT INTO `departamento_empresa` (`cod_departamento_empresa`, `nombre`) VALUES
(1, 'Dirección General'),
(2, 'Facturación'),
(3, 'Eventos'),
(4, 'Recorridos Escolares');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `cod_descuento` int NOT NULL,
  `descuento_otorgado` decimal(10,2) NOT NULL,
  `rebaja_otorgada` decimal(10,2) NOT NULL,
  `importe_exento` decimal(10,2) NOT NULL,
  `fecha_modificacion` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`cod_descuento`, `descuento_otorgado`, `rebaja_otorgada`, `importe_exento`, `fecha_modificacion`) VALUES
(1, 10.00, 7.00, 9.00, '2025-08-08 21:16:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizacion`
--

CREATE TABLE `detalle_cotizacion` (
  `cod_detallecotizacion` int NOT NULL,
  `cantidad` int NOT NULL,
  `descripcion` text NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cod_cotizacion` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_cotizacion`
--

INSERT INTO `detalle_cotizacion` (`cod_detallecotizacion`, `cantidad`, `descripcion`, `precio_unitario`, `total`, `cod_cotizacion`) VALUES
(187, 3, 'SALON LOBBY', 32257.50, 96772.50, 37),
(188, 100, 'MANTEL (MESA REDONDA)', 143.75, 14375.00, 37),
(189, 100, 'SOBREMANTELES COLORES', 34.50, 3450.00, 37),
(191, 3, 'SALON MEDIO LOBBY', 16128.75, 48386.25, 39),
(192, 4, 'SALON LOBBY', 33522.50, 134090.00, 38),
(198, 3, 'SALON TEMPORALES', 6325.00, 18975.00, 42),
(203, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 47),
(204, 2, 'SALON ARTE', 8222.50, 16445.00, 48),
(205, 8, 'SALON LOBBY', 33522.50, 268180.00, 49),
(206, 2, 'PAQUETE 2', 135.00, 270.00, 49),
(211, 4, 'SALON AREA DEL TREN', 20125.00, 80500.00, 43),
(214, 1, 'dada', 20.00, 20.00, 54),
(238, 7, 'SALON KIOSKO', 7590.00, 53130.00, 61),
(239, 34, 'MERIENDA', 50.00, 1700.00, 61),
(240, 7, 'PAQUETE 1', 100.00, 700.00, 61),
(256, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 62),
(260, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 60),
(261, 2, 'PAQUETE 2', 135.00, 270.00, 60),
(263, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 58),
(264, 7, 'SALON KIOSKO', 7590.00, 53130.00, 59),
(265, 34, 'MERIENDA', 50.00, 1700.00, 59),
(267, 4, 'SALON AREA DEL TREN', 20125.00, 80500.00, 44),
(268, 34, 'FALDONES (MESA RECTANGULAR)', 143.75, 4887.50, 44),
(269, 32, 'ENTRADA GENERAL CUARTA EDAD', 60.00, 1920.00, 44),
(270, 7, 'SALON KIOSKO', 7590.00, 53130.00, 57),
(271, 34, 'MERIENDA', 50.00, 1700.00, 57),
(301, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 66),
(302, 3, 'Hora Extra - Día (SALON MEDIO LOBBY)', 4269.38, 12808.14, 66),
(304, 4, 'SALON MEDIO LOBBY', 16128.75, 64515.00, 50),
(305, 15, 'MERIENDA', 50.00, 750.00, 50),
(306, 1, 'CASITA DEL EQUILIBROS', 25.00, 25.00, 50),
(307, 7, 'PAQUETE 1', 100.00, 700.00, 50),
(308, 4, 'SALON KIOSKO', 150.00, 600.00, 50),
(320, 5, 'SALON CULTURAL', 11385.00, 56925.00, 68),
(321, 4, 'Hora Extra - Día (SALON CULTURAL)', 3162.00, 12648.00, 68),
(327, 4, 'SALON KIOSKO', 6325.00, 25300.00, 46),
(328, 5, 'SALON MEDIO LOBBY', 16761.25, 83806.25, 69),
(329, 5, 'SALON LOBBY', 32257.50, 161287.50, 64),
(330, 34, 'MERIENDA', 50.00, 1700.00, 64),
(331, 5, 'Hora Extra - Noche (SALON LOBBY)', 32257.50, 161287.50, 64),
(332, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 65),
(333, 5, 'SALON ARTE', 0.00, 0.00, 63),
(334, 5, 'SALON CULTURAL', 10120.00, 50600.00, 67),
(335, 3, 'PAQUETE 3', 185.00, 555.00, 67),
(336, 2, 'Hora Extra - Día (SALON CULTURAL)', 3162.00, 6324.00, 67),
(340, 5, 'SALON ARTE', 8222.50, 41112.50, 70),
(341, 5, 'Hora Extra - Día (SALON ARTE)', 2530.00, 12650.00, 70),
(346, 5, 'SALON KIOSKO', 150.00, 750.00, 71),
(347, 10, 'PAQUETE 3', 185.00, 1850.00, 71),
(348, 3, 'Hora Extra - Día (SALON KIOSKO)', 25.00, 75.00, 71),
(349, 2, 'SALON ARTE', 8222.50, 16445.00, 45),
(350, 3, 'Hora Extra - Día (SALON ARTE)', 2530.00, 7590.00, 45),
(358, 7, 'SALON KIOSKO', 7590.00, 53130.00, 55),
(359, 34, 'MERIENDA', 50.00, 1700.00, 55),
(361, 7, 'SALON KIOSKO', 7590.00, 53130.00, 53),
(362, 34, 'MERIENDA', 50.00, 1700.00, 53),
(364, 5, 'SALON CULTURAL', 10120.00, 50600.00, 72);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `cod_detalle_factura` int NOT NULL,
  `cod_factura` int NOT NULL,
  `cantidad` int NOT NULL,
  `descripcion` text NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`cod_detalle_factura`, `cod_factura`, `cantidad`, `descripcion`, `precio_unitario`, `total`, `tipo`) VALUES
(3, 2, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(4, 2, 1, 'CASITA DEL EQUILIBRO (L. 25.00)', 25.00, 25.00, 'Extra'),
(5, 3, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(6, 3, 1, 'CASITA DEL EQUILIBRO (L. 25.00)', 25.00, 25.00, 'Adicional'),
(7, 4, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(8, 4, 1, 'CASITA DEL EQUILIBRO (L. 25.00)', 25.00, 25.00, 'Adicional'),
(9, 6, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(10, 8, 1, 'mesas', 10.00, 10.00, 'Paquete'),
(11, 9, 1, 'Seleccione...', 0.00, 0.00, 'Libro'),
(12, 10, 1, 'ENTRADA GENERAL TERCERA EDAD (L. 75.00)', 75.00, 75.00, 'Entrada'),
(13, 10, 1, 'CASITA DEL EQUILIBRO (L. 25.00)', 25.00, 25.00, 'Adicional'),
(14, 11, 1, 'dada', 20.00, 20.00, 'Paquete'),
(15, 2, 1, 'zz', 1.00, 1.00, 'Extra'),
(16, 12, 5, 'ENTRADA GENERAL (L. 150.00)', 150.00, 750.00, 'Entrada'),
(17, 13, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(18, 13, 1, 'PARQUE VIAL (L. 50.00)', 50.00, 50.00, 'Adicional'),
(21, 15, 1, 'dada', 20.00, 20.00, 'Paquete'),
(22, 16, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 'Paquete'),
(23, 17, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(24, 17, 1, 'MERIENDA (L. 50.00)', 50.00, 50.00, 'Adicional'),
(25, 18, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(26, 19, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(27, 20, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(28, 21, 1, 'ENTRADA GENERAL TERCERA EDAD (L. 75.00)', 75.00, 75.00, 'Entrada'),
(29, 22, 1, 'ENTRADA GENERAL CUARTA EDAD (L. 60.00)', 60.00, 60.00, 'Entrada'),
(30, 23, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(31, 24, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 'Paquete'),
(32, 24, 2, 'PAQUETE 2', 135.00, 270.00, 'Paquete'),
(33, 25, 1, 'Seleccione...', 0.00, 0.00, 'Obra'),
(34, 26, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(36, 28, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 'Paquete'),
(37, 28, 2, 'Horas Extra', 4269.38, 8538.76, 'Extra'),
(38, 29, 1, 'ENTRADA GENERAL TERCERA EDAD (L. 75.00)', 75.00, 75.00, 'Entrada'),
(39, 30, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(40, 30, 1, 'ENTRADA GENERAL CUARTA EDAD (L. 60.00)', 60.00, 60.00, 'Entrada'),
(41, 31, 1, 'dada', 20.00, 20.00, 'Paquete'),
(42, 32, 4, 'SALON AREA DEL TREN', 21275.00, 85100.00, 'Paquete'),
(43, 32, 34, 'FALDONES (MESA RECTANGULAR)', 143.75, 4887.50, 'Paquete'),
(44, 32, 32, 'ENTRADA GENERAL CUARTA EDAD', 60.00, 1920.00, 'Paquete'),
(45, 33, 1, 'ENTRADA GENERAL CUARTA EDAD (L. 60.00)', 60.00, 60.00, 'Entrada'),
(46, 34, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(47, 34, 1, 'MERIENDA (L. 50.00)', 50.00, 50.00, 'Adicional'),
(48, 35, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(49, 36, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(53, 38, 5, 'SALON MEDIO LOBBY', 16128.75, 80643.75, 'Paquete'),
(54, 38, 3, 'Hora Extra - Día (SALON MEDIO LOBBY)', 16128.75, 48386.25, 'Paquete'),
(55, 38, 2, 'Horas Extra', 4269.38, 8538.76, 'Extra'),
(56, 39, 7, 'SALON KIOSKO', 150.00, 1050.00, 'Paquete'),
(57, 39, 34, 'MERIENDA', 50.00, 1700.00, 'Paquete'),
(58, 40, 1, 'CASITA DEL EQUILIBROS (L. 25.00)', 25.00, 25.00, 'Obra'),
(59, 41, 1, 'ENTRADA GENERAL TERCERA EDAD (L. 75.00)', 75.00, 75.00, 'Entrada'),
(60, 42, 2, 'ENTRADA GENERAL (L. 150.00)', 150.00, 300.00, 'Entrada'),
(61, 42, 1, 'CASITA DEL EQUILIBROS (L. 25.00)', 25.00, 25.00, 'Adicional'),
(62, 43, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(63, 44, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(64, 45, 7, 'SALON KIOSKO', 150.00, 1050.00, 'Paquete'),
(65, 45, 34, 'MERIENDA', 50.00, 1700.00, 'Paquete'),
(66, 45, 3, 'Horas Extra', 25.00, 75.00, 'Extra'),
(67, 46, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(68, 47, 7, 'SALON KIOSKO', 150.00, 1050.00, 'Paquete'),
(69, 47, 34, 'MERIENDA', 50.00, 1700.00, 'Paquete'),
(70, 47, 2, 'SALÓN: SALON LOBBY (L. 32257.50)', 32257.50, 64515.00, 'Paquete'),
(71, 48, 1, 'ENTRADA GENERAL (L. 150.00)', 150.00, 150.00, 'Entrada'),
(72, 48, 1, 'PAQUETE 1 (L. 100.00)', 100.00, 100.00, 'Adicional'),
(73, 49, 1, 'PAQUETE 1 (L. 100.00)', 100.00, 100.00, 'Adicional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `cod_direccion` int NOT NULL,
  `direccion` text,
  `cod_persona` int DEFAULT NULL,
  `cod_municipio` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`cod_direccion`, `direccion`, `cod_persona`, `cod_municipio`) VALUES
(57, 'colonia hatillo', 72, 13),
(59, 'colonia hatillo', 74, 16),
(60, 'colonia hatillo', 75, 4),
(61, 'colonia sosa', 76, 16),
(63, 'Colonia villadelmis', 78, 15),
(64, 'Colonia palmira', 79, 98),
(65, 'colonia sagastume', 80, 297),
(66, 'Barrio aceituna', 81, 34),
(67, 'Pueblito', 82, 1),
(69, 'hato en medio sector 2', 84, 35),
(70, 'hato', 86, 16),
(71, 'Col. El Sauce, Tegucigalpa', 87, 14),
(72, 'Colonia Las Uvas', 88, 13),
(73, '1dasd', 89, 26),
(75, 'Colonia las lomas barrio caserío 99', 91, 7),
(80, 'Tres caminos', 96, 110),
(83, 'mi casita humilde', 99, 34),
(84, 'Honduras', 100, 14),
(87, 'Canaán', 103, 13),
(91, NULL, 107, NULL),
(92, NULL, 108, NULL),
(95, 'Tegucigalpa', 111, 110),
(96, 'Canaán', 112, 110),
(98, 'Canaán', 114, 110);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `cod_empleado` int NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `salario` decimal(10,2) NOT NULL,
  `fecha_contratacion` datetime DEFAULT NULL,
  `cod_persona` int DEFAULT NULL,
  `cod_departamento_empresa` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`cod_empleado`, `cargo`, `salario`, `fecha_contratacion`, `cod_persona`, `cod_departamento_empresa`) VALUES
(27, 'Supervisor', 42000.00, '2025-05-01 00:00:00', 72, 2),
(30, 'test', 11.00, '2025-07-09 00:00:00', 86, 1),
(31, 'hola', 1.00, '2025-07-09 00:00:00', 87, 1),
(32, 'josue', 1.00, '2025-07-09 00:00:00', 88, 1),
(35, 'Informática', 15000.00, '2025-07-03 00:00:00', 96, 1),
(37, 'Precidente del pueblo', 1.00, '2025-07-31 00:00:00', 100, 1),
(44, 'Técnico audiovisual', 14000.00, '2024-12-09 00:00:00', 111, 1),
(45, 'Soporte Técnico', 25000.00, '2025-02-04 00:00:00', 114, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `cod_entrada` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`cod_entrada`, `nombre`, `precio`) VALUES
(6, 'ENTRADA GENERAL', 150.00),
(7, 'ENTRADA GENERAL TERCERA EDAD', 75.00),
(8, 'ENTRADA GENERAL CUARTA EDAD', 60.00),
(9, 'ENTRADA PARA PERSONAS CON DISCAPACIDAD', 75.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `cod_evento` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_programa` date NOT NULL,
  `hora_programada` time NOT NULL,
  `cod_cotizacion` int NOT NULL,
  `horas_evento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`cod_evento`, `nombre`, `fecha_programa`, `hora_programada`, `cod_cotizacion`, `horas_evento`) VALUES
(37, 'Culto', '2025-08-15', '08:00:00', 37, 3),
(38, 'Graduación', '2025-12-12', '08:00:00', 38, 4),
(39, 'Seminario', '2025-12-04', '02:00:00', 39, 3),
(42, 'Boda', '2025-12-04', '08:00:00', 42, 3),
(43, 'Reunion', '2026-01-01', '12:00:00', 43, 4),
(44, 'Cumpleaños', '2025-11-04', '02:00:00', 44, 4),
(45, 'Capacitación', '2025-11-11', '11:00:00', 45, 2),
(46, 'Exposición de arte', '2025-11-14', '01:00:00', 46, 4),
(47, 'Cursos', '2025-12-01', '10:00:00', 47, 5),
(48, 'Quince años', '2025-12-12', '02:00:00', 48, 2),
(49, 'Fiesta Graduacion', '2026-01-28', '13:00:00', 49, 8),
(50, 'Partido Real Madrid', '2025-07-09', '13:00:00', 50, 4),
(51, 'Boda de oro', '2026-01-12', '16:00:00', 53, 7),
(52, 'cumple de moises', '2025-07-10', '22:08:00', 54, 4),
(53, 'Reunion de Equipo FC', '2026-01-12', '16:00:00', 55, 7),
(54, 'Super Fiesta', '2025-07-10', '01:23:00', 56, 3),
(55, 'Fiesta de sofia', '2026-01-12', '16:00:00', 57, 7),
(56, 'Culto para celebarar Cumple', '2025-07-20', '17:00:00', 58, 5),
(57, 'Boda', '2026-01-12', '16:00:00', 59, 7),
(58, 'Culto ', '2025-07-20', '17:00:00', 60, 5),
(59, 'boda juan', '2026-01-12', '16:00:00', 61, 7),
(60, 'Culto de Luis', '2025-07-20', '17:00:00', 62, 5),
(61, 'culto', '2025-12-01', '03:00:00', 63, 5),
(62, 'convencion', '2025-08-22', '13:00:00', 64, 5),
(63, 'Inauguración', '2025-09-22', '10:00:00', 65, 5),
(64, 'Culto', '2025-12-30', '10:00:00', 66, 5),
(65, 'Cumpleaños de Pedro', '2025-08-12', '12:00:00', 67, 5),
(66, 'Fiesta', '2025-12-12', '12:00:00', 68, 5),
(67, 'Boda', '2025-08-28', '17:30:00', 69, 5),
(68, 'sofisticado', '2025-08-28', '12:00:00', 70, 5),
(69, 'Prueba desde el servidor', '2025-08-12', '13:00:00', 71, 5),
(70, 'fiesta de kelly', '2025-08-14', '01:21:00', 72, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `cod_factura` int NOT NULL,
  `numero_factura` varchar(30) NOT NULL,
  `cod_correlativo` int NOT NULL,
  `fecha_emision` date NOT NULL,
  `cod_cliente` int NOT NULL,
  `direccion` text NOT NULL,
  `rtn` varchar(20) DEFAULT NULL,
  `cod_cai` int NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `tipo_factura` enum('Evento','Recorrido Escolar','Taquilla General','Libros','Obras') NOT NULL,
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
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`cod_factura`, `numero_factura`, `cod_correlativo`, `fecha_emision`, `cod_cliente`, `direccion`, `rtn`, `cod_cai`, `fecha_limite`, `tipo_factura`, `descuento_otorgado`, `rebajas_otorgadas`, `importe_exento`, `importe_gravado_18`, `importe_gravado_15`, `impuesto_15`, `impuesto_18`, `importe_exonerado`, `subtotal`, `total_pago`, `observaciones`) VALUES
(2, '00020001-00020002', 1, '2025-07-09', 34, 'colonia sosa', '66651972090132', 4, NULL, 'Evento', 17.50, 0.00, 0.00, 150.00, 0.00, 27.00, 0.00, 0.00, 176.00, 185.50, 'kk'),
(3, '00020001-00020003', 1, '2025-07-09', 32, 'colonia hatillo', '12566787656766', 4, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 175.00, 0.00, 26.25, 0.00, 175.00, 201.25, 'ssd'),
(4, '00020001-00020004', 1, '2025-07-09', 32, 'colonia hatillo', '12566787656766', 4, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 175.00, 0.00, 26.25, 0.00, 175.00, 201.25, 'ssd'),
(6, '00020001-00020005', 1, '2025-07-09', 41, 'hato', '08012005047923', 4, NULL, 'Taquilla General', 15.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 135.00, 135.00, 'sda'),
(8, '00020001-00020006', 1, '2025-07-09', 41, 'hato', '08012005047923', 4, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10.00, 10.00, 'ol'),
(9, '00020001-00020007', 1, '2025-07-09', 41, 'hato', '08012005047923', 4, NULL, 'Libros', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'p'),
(10, '00020001-00020008', 1, '2025-07-10', 34, 'colonia sosa', '66651972090132', 4, NULL, 'Recorrido Escolar', 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 99.00, 99.00, 'aad'),
(11, '00020001-00020009', 1, '2025-07-10', 36, 'Colonia villadelmis', '09322761498256', 4, NULL, 'Evento', 0.80, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 19.20, 19.20, 'f'),
(12, '00020001-00020010', 1, '2025-07-10', 34, 'colonia sosa', '66651972090132', 4, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 750.00, 750.00, 'dsad'),
(13, '00020001-00020011', 1, '2025-07-09', 44, 'asda', '122134', 4, NULL, 'Recorrido Escolar', 4.00, 20.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 176.00, 176.00, 'ds'),
(15, '00020001-00020013', 1, '2025-07-13', 38, 'colonia sagastume', '01211583592375', 4, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 20.00, 20.00, NULL),
(16, '00020001-00020014', 1, '2025-07-18', 32, 'colonia hatillo', '12566787656766', 4, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 80643.75, 80643.75, NULL),
(17, '00020001-00020015', 1, '2025-07-19', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Recorrido Escolar', 16.00, 14.00, 4.00, 0.00, 166.00, 0.00, 24.90, 0.00, 166.00, 190.90, 'f'),
(18, '00020001-00020016', 1, '2025-07-19', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 150.00, 150.00, NULL),
(19, '00020001-00020017', 1, '2025-07-19', 39, 'Barrio aceituna', '06527783249125', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 150.00, 150.00, NULL),
(20, '00020001-00020018', 1, '2025-07-19', 39, 'Barrio aceituna', '06527783249125', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 150.00, 150.00, NULL),
(21, '00020001-00020019', 1, '2025-07-19', 37, 'Colonia palmira', '82530142736244', 5, NULL, 'Recorrido Escolar', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 69.00, 69.00, 'f'),
(22, '000-001-01-000000102', 3, '2025-07-19', 33, 'colonia hatillo', '09123657668254', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 60.00, 60.00, 'fd'),
(23, '00020001', 4, '2025-07-19', 32, 'colonia hatillo', '12566787656766', 3, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 150.00, 150.00, 'xzc'),
(24, '000-001-01-000000104', 3, '2025-07-19', 40, 'Pueblito', '0801200013219', 5, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 80913.75, 0.00, 12137.06, 0.00, 80913.75, 93050.81, 'dff'),
(25, '000-001-01-000000106', 3, '2025-07-19', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Obras', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(26, '000-001-01-000000108', 3, '2025-07-23', 39, 'Barrio aceituna', '06527783249125', 5, NULL, 'Recorrido Escolar', 12.00, 10.50, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 124.50, 124.50, NULL),
(28, '000-001-01-000000112', 3, '2025-07-23', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Evento', 7134.60, 6242.78, 1783.65, 0.00, 0.00, 0.00, 0.00, 0.00, 74021.48, 74021.48, NULL),
(29, '000-001-01-000000114', 3, '2025-07-27', 33, 'colonia hatillo', '09123657668254', 5, NULL, 'Recorrido Escolar', 6.00, 5.25, 1.50, 0.00, 62.25, 0.00, 9.34, 0.00, 62.25, 71.59, NULL),
(30, '000-001-01-000000116', 3, '2025-07-27', 39, 'Barrio aceituna', '06527783249125', 5, NULL, 'Taquilla General', 16.80, 14.70, 4.20, 0.00, 0.00, 0.00, 0.00, 0.00, 174.30, 174.30, NULL),
(31, '000-001-01-000000117', 3, '2025-07-27', 36, 'Colonia villadelmis', '09322761498256', 5, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 20.00, 20.00, 'hola'),
(32, '000-001-01-000000118', 3, '2025-07-27', 37, 'Colonia palmira', '82530142736244', 5, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 91907.50, 91907.50, NULL),
(33, '000-001-01-000000119', 3, '2025-07-31', 38, 'colonia sagastume', '01211583592375', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 60.00, 60.00, NULL),
(34, '000-001-01-000000120', 3, '2025-07-31', 48, 'mi casita humilde', '08012222222222', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 200.00, 200.00, NULL),
(35, '000-001-01-000000121', 3, '2025-08-01', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Taquilla General', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 30.00, 0.00, 200.00, 230.00, NULL),
(36, '000-001-01-000000122', 3, '2025-08-01', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Taquilla General', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 30.00, 0.00, 200.00, 230.00, NULL),
(38, '000-001-01-000000124', 3, '2025-08-02', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 137568.76, 137568.76, NULL),
(39, '000-001-01-000000125', 3, '2025-08-06', 40, 'Pueblito', '0801200013219', 5, NULL, 'Evento', 412.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2337.50, 2337.50, NULL),
(40, '000-001-01-000000126', 3, '2025-08-08', 37, 'Colonia palmira', '82530142736244', 5, NULL, 'Obras', 28.80, 25.20, 7.20, 0.00, 0.00, 0.00, 44.82, 0.00, 25.00, 25.00, 'hola'),
(41, '000-001-01-000000127', 3, '2025-08-08', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Taquilla General', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 75.00, 75.00, 'dd'),
(42, '000-001-01-000000128', 3, '2025-08-08', 51, 'null', 'null', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 48.75, 0.00, 325.00, 373.75, 'hola'),
(43, '000-001-01-000000129', 3, '2025-08-08', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Taquilla General', 12.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 138.00, 138.00, NULL),
(44, '000-001-01-000000130', 3, '2025-08-08', 32, 'colonia hatillo', '12566787656766', 5, NULL, 'Taquilla General', 12.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 138.00, 138.00, NULL),
(45, '000-001-01-000000131', 3, '2025-08-08', 41, 'hato en medio sector 2', '08012005047923', 5, NULL, 'Evento', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 423.75, 0.00, 2825.00, 3248.75, NULL),
(46, '001-001-111', 5, '2025-08-10', 34, 'colonia sosa', '66651972090132', 6, NULL, 'Taquilla General', 15.00, 10.50, 13.50, 0.00, 0.00, 0.00, 13.32, 22.20, 88.80, 102.12, 'gracias por su compr'),
(47, '001-001-112', 5, '2025-08-10', 32, 'colonia hatillo', '12566787656766', 6, NULL, 'Evento', 275.00, 192.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 67265.00, 67265.00, 'gracias'),
(48, '001-001-113', 5, '2025-08-10', 52, 'S/D', 'XXXXXXXXXXXXX', 6, NULL, 'Recorrido Escolar', 25.00, 17.50, 22.50, 0.00, 0.00, 0.00, 27.75, 0.00, 185.00, 212.75, 'dd'),
(49, '000-001-01-000000132', 3, '2025-08-10', 52, 'S/D', 'XXXXXXXXXXXXX', 5, NULL, 'Recorrido Escolar', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 100.00, 100.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `cod_inventario` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad_disponible` int NOT NULL,
  `estado` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`cod_inventario`, `nombre`, `descripcion`, `precio_unitario`, `cantidad_disponible`, `estado`) VALUES
(5, 'MANTEL (MESA REDONDA)', 'Para mesa redonda', 143.75, 100, 0),
(6, 'FALDONES (MESA RECTANGULAR)', 'Mesa rectangular', 143.75, 100, 1),
(7, 'SOBREMANTELES COLORES', 'De colores', 34.50, 100, 1),
(8, 'TOLDOS', 'Toldos', 1035.00, 100, 0),
(9, 'silla', 'silla plastica', 20.00, 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `cod_libro` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `cod_municipio` int NOT NULL,
  `municipio` varchar(60) NOT NULL,
  `cod_departamento` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`cod_municipio`, `municipio`, `cod_departamento`) VALUES
(1, 'La Ceiba', 1),
(2, 'El Porvenir', 1),
(3, 'Tela', 1),
(4, 'Jutiapa', 1),
(5, 'La Masica', 1),
(6, 'San Francisco', 1),
(7, 'Arizona', 1),
(8, 'Esparta', 1),
(9, 'Choluteca', 2),
(10, 'Apacilagua', 2),
(11, 'Concepción de María', 2),
(12, 'Duyure', 2),
(13, 'El Corpus', 2),
(14, 'El Triunfo', 2),
(15, 'Marcovia', 2),
(16, 'Morolica', 2),
(17, 'Namasigüe', 2),
(18, 'Orocuina', 2),
(19, 'Pespire', 2),
(20, 'San Antonio de Flores', 2),
(21, 'San Isidro', 2),
(22, 'San José', 2),
(23, 'San Marcos de Colón', 2),
(24, 'Santa Ana de Yusguare', 2),
(25, 'Trujillo', 3),
(26, 'Balfate', 3),
(27, 'Iriona', 3),
(28, 'Limón', 3),
(29, 'Sabá', 3),
(30, 'Santa Fe', 3),
(31, 'Santa Rosa de Aguán', 3),
(32, 'Sonaguera', 3),
(33, 'Tocoa', 3),
(34, 'Bonito Oriental', 3),
(35, 'Comayagua', 4),
(36, 'Ajuterique', 4),
(37, 'El Rosario', 4),
(38, 'Esquías', 4),
(39, 'Humuya', 4),
(40, 'La Libertad', 4),
(41, 'Lamaní', 4),
(42, 'La Trinidad', 4),
(43, 'Lejamaní', 4),
(44, 'Meámbar', 4),
(45, 'Minas de Oro', 4),
(46, 'Ojos de Agua', 4),
(47, 'San Jerónimo', 4),
(48, 'San José de Comayagua', 4),
(49, 'San José del Potrero', 4),
(50, 'San Luis', 4),
(51, 'San Sebastián', 4),
(52, 'Siguatepeque', 4),
(53, 'Villa de San Antonio', 4),
(54, 'Las Lajas', 4),
(55, 'Taulabé', 4),
(56, 'Santa Rosa de Copán', 5),
(57, 'Cabañas', 5),
(58, 'Concepción', 5),
(59, 'Copán Ruinas', 5),
(60, 'Corquín', 5),
(61, 'Cucuyagua', 5),
(62, 'Dolores', 5),
(63, 'Dulce Nombre', 5),
(64, 'El Paraíso', 5),
(65, 'Florida', 5),
(66, 'La Jigua', 5),
(67, 'La Unión', 5),
(68, 'Nueva Arcadia', 5),
(69, 'San Agustín', 5),
(70, 'San Antonio', 5),
(71, 'San Jerónimo', 5),
(72, 'San José', 5),
(73, 'San Juan de Opoa', 5),
(74, 'San Nicolás', 5),
(75, 'San Pedro', 5),
(76, 'Santa Rita', 5),
(77, 'Trinidad de Copán', 5),
(78, 'Veracruz', 5),
(79, 'San Pedro Sula', 6),
(80, 'Choloma', 6),
(81, 'Omoa', 6),
(82, 'Pimienta', 6),
(83, 'Potrerillos', 6),
(84, 'Puerto Cortés', 6),
(85, 'San Antonio de Cortés', 6),
(86, 'San Francisco de Yojoa', 6),
(87, 'San Manuel', 6),
(88, 'Santa Cruz de Yojoa', 6),
(89, 'Villanueva', 6),
(90, 'La Lima', 6),
(91, 'Yuscarán', 7),
(92, 'Alauca', 7),
(93, 'Danlí', 7),
(94, 'El Paraíso', 7),
(95, 'Güinope', 7),
(96, 'Jacaleapa', 7),
(97, 'Liure', 7),
(98, 'Morocelí', 7),
(99, 'Oropolí', 7),
(100, 'Potrerillos', 7),
(101, 'San Antonio de Flores', 7),
(102, 'San Lucas', 7),
(103, 'San Matías', 7),
(104, 'Soledad', 7),
(105, 'Teupasenti', 7),
(106, 'Texiguat', 7),
(107, 'Vado Ancho', 7),
(108, 'Yauyupe', 7),
(109, 'Trojes', 7),
(110, 'Distrito Central', 8),
(111, 'Alubarén', 8),
(112, 'Cedros', 8),
(113, 'Curarén', 8),
(114, 'El Porvenir', 8),
(115, 'Guaimaca', 8),
(116, 'La Libertad', 8),
(117, 'La Venta', 8),
(118, 'Lepaterique', 8),
(119, 'Maraita', 8),
(120, 'Marale', 8),
(121, 'Nueva Armenia', 8),
(122, 'Ojojona', 8),
(123, 'Orica', 8),
(124, 'Reitoca', 8),
(125, 'Sabanagrande', 8),
(126, 'San Antonio de Oriente', 8),
(127, 'San Buenaventura', 8),
(128, 'San Ignacio', 8),
(129, 'Cantarranas', 8),
(130, 'San Miguelito', 8),
(131, 'Santa Ana', 8),
(132, 'Santa Lucía', 8),
(133, 'Talanga', 8),
(134, 'Tatumbla', 8),
(135, 'Valle de Ángeles', 8),
(136, 'Villa de San Francisco', 8),
(137, 'Vallecillo', 8),
(138, 'Puerto Lempira', 9),
(139, 'Brus Laguna', 9),
(140, 'Ahuas', 9),
(141, 'Juan Francisco Bulnes', 9),
(142, 'Villeda Morales', 9),
(143, 'Wampusirpe', 9),
(144, 'La Esperanza', 10),
(145, 'Camasca', 10),
(146, 'Colomoncagua', 10),
(147, 'Concepción', 10),
(148, 'Dolores', 10),
(149, 'Intibucá', 10),
(150, 'Jesús de Otoro', 10),
(151, 'Magdalena', 10),
(152, 'Masaguara', 10),
(153, 'San Antonio', 10),
(154, 'San Isidro', 10),
(155, 'San Juan', 10),
(156, 'San Marcos de la Sierra', 10),
(157, 'San Miguel Guancapla', 10),
(158, 'Santa Lucía', 10),
(159, 'Yamaranguila', 10),
(160, 'San Francisco de Opalaca', 10),
(161, 'Roatán', 11),
(162, 'Guanaja', 11),
(163, 'José Santos Guardiola', 11),
(164, 'Utila', 11),
(165, 'La Paz', 12),
(166, 'Aguanqueterique', 12),
(167, 'Cabañas', 12),
(168, 'Cane', 12),
(169, 'Chinacla', 12),
(170, 'Guajiquiro', 12),
(171, 'Lauterique', 12),
(172, 'Marcala', 12),
(173, 'Mercedes de Oriente', 12),
(174, 'Opatoro', 12),
(175, 'San Antonio del Norte', 12),
(176, 'San José', 12),
(177, 'San Juan', 12),
(178, 'San Pedro de Tutule', 12),
(179, 'Santa Ana', 12),
(180, 'Santa Elena', 12),
(181, 'Santa María', 12),
(182, 'Santiago de Puringla', 12),
(183, 'Yarula', 12),
(184, 'Gracias', 13),
(185, 'Belén', 13),
(186, 'Candelaria', 13),
(187, 'Cololaca', 13),
(188, 'Erandique', 13),
(189, 'Gualcince', 13),
(190, 'Guarita', 13),
(191, 'La Campa', 13),
(192, 'La Iguala', 13),
(193, 'Las Flores', 13),
(194, 'La Unión', 13),
(195, 'La Virtud', 13),
(196, 'Lepaera', 13),
(197, 'Mapulaca', 13),
(198, 'Piraera', 13),
(199, 'San Andrés', 13),
(200, 'San Francisco', 13),
(201, 'San Juan Guarita', 13),
(202, 'San Manuel Colohete', 13),
(203, 'San Rafael', 13),
(204, 'San Sebastián', 13),
(205, 'Santa Cruz', 13),
(206, 'Talgua', 13),
(207, 'Tambla', 13),
(208, 'Tomalá', 13),
(209, 'Valladolid', 13),
(210, 'Virginia', 13),
(211, 'San Marcos de Caiquín', 13),
(212, 'Ocotepeque', 14),
(213, 'Belén Gualcho', 14),
(214, 'Concepción', 14),
(215, 'Dolores Merendón', 14),
(216, 'Fraternidad', 14),
(217, 'La Encarnación', 14),
(218, 'La Labor', 14),
(219, 'Lucerna', 14),
(220, 'Mercedes', 14),
(221, 'San Fernando', 14),
(222, 'San Francisco del Valle', 14),
(223, 'San Jorge', 14),
(224, 'San Marcos', 14),
(225, 'Santa Fe', 14),
(226, 'Sensenti', 14),
(227, 'Sinuapa', 14),
(228, 'Juticalpa', 15),
(229, 'Campamento', 15),
(230, 'Catacamas', 15),
(231, 'Concordia', 15),
(232, 'Dulce Nombre de Culmí', 15),
(233, 'El Rosario', 15),
(234, 'Esquipulas del Norte', 15),
(235, 'Gualaco', 15),
(236, 'Guarizama', 15),
(237, 'Guata', 15),
(238, 'Guayape', 15),
(239, 'Jano', 15),
(240, 'La Unión', 15),
(241, 'Mangulile', 15),
(242, 'Manto', 15),
(243, 'Salamá', 15),
(244, 'San Esteban', 15),
(245, 'San Francisco de Becerra', 15),
(246, 'San Francisco de la Paz', 15),
(247, 'Santa María del Real', 15),
(248, 'Silca', 15),
(249, 'Yocón', 15),
(250, 'Patuca', 15),
(251, 'Santa Bárbara', 16),
(252, 'Arada', 16),
(253, 'Atima', 16),
(254, 'Azacualpa', 16),
(255, 'Ceguaca', 16),
(256, 'Concepción del Norte', 16),
(257, 'Concepción del Sur', 16),
(258, 'Chinda', 16),
(259, 'El Níspero', 16),
(260, 'Gualala', 16),
(261, 'Ilama', 16),
(262, 'Las Vegas', 16),
(263, 'Macuelizo', 16),
(264, 'Naranjito', 16),
(265, 'Nuevo Celilac', 16),
(266, 'Nueva Frontera', 16),
(267, 'Petoa', 16),
(268, 'Protección', 16),
(269, 'Quimistán', 16),
(270, 'San Francisco de Ojuera', 16),
(271, 'San José de las Colinas', 16),
(272, 'San Luis', 16),
(273, 'San Marcos', 16),
(274, 'San Nicolás', 16),
(275, 'San Pedro Zacapa', 16),
(276, 'San Vicente Centenario', 16),
(277, 'Santa Rita', 16),
(278, 'Trinidad', 16),
(279, 'Nacaome', 17),
(280, 'Alianza', 17),
(281, 'Amapala', 17),
(282, 'Aramecina', 17),
(283, 'Caridad', 17),
(284, 'Goascorán', 17),
(285, 'Langue', 17),
(286, 'San Francisco de Coray', 17),
(287, 'San Lorenzo', 17),
(288, 'Yoro', 18),
(289, 'Arenal', 18),
(290, 'El Negrito', 18),
(291, 'El Progreso', 18),
(292, 'Jocón', 18),
(293, 'Morazán', 18),
(294, 'Olanchito', 18),
(295, 'Santa Rita', 18),
(296, 'Sulaco', 18),
(297, 'Victoria', 18),
(298, 'Yorito', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE `objetos` (
  `cod_objeto` int NOT NULL,
  `tipo_objeto` varchar(50) DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `objetos`
--

INSERT INTO `objetos` (`cod_objeto`, `tipo_objeto`, `descripcion`) VALUES
(1, 'Pantalla Empleados', 'Gestión de empleados'),
(2, 'Pantalla Productos', 'Gestión de productos'),
(3, 'Pantalla Salones', 'Gestión de salones'),
(4, 'Pantalla Cotización', 'Gestión de cotizaciones'),
(5, 'Pantalla Reservación', 'Gestión de reservaciones'),
(6, 'Pantalla Eventos', 'Facturación de eventos'),
(7, 'Pantalla Entradas', 'Facturación de entradas generales'),
(8, 'Pantalla Seguridad', 'Panel de administración'),
(9, 'Pantalla CAI', 'Gestión de CAI'),
(10, 'Pantalla Bitácora', 'Bitácora del sistema'),
(11, 'Pantalla Clientes', 'Gestión de clientes'),
(12, 'Pantalla Escolares', 'Gestión de recorridos escolares'),
(13, 'Pantalla Backup', 'Gestión de Backup'),
(18, 'soy el mejor', 'pero me falta un poco'),
(20, 'editar empleado', 'Gestión de empleados'),
(21, 'solo ver', 'Gestión de salones'),
(22, 'Solo ver empleados', 'Gestión de empleados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `cod_paquete` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`cod_paquete`, `nombre`, `descripcion`, `precio`) VALUES
(4, 'PAQUETE 1', 'Recorrido por todas nuestras salas interactivas,', 100.00),
(5, 'PAQUETE 2', 'Recorrido por todas nuestras salas interactivas y un taller por persona.', 135.00),
(6, 'PAQUETE 3', 'Recorrido por todas nuestras salas interactivas, un taller por persona, visita a casita del equilibrio y parque vial.', 185.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `cod_permiso` int NOT NULL,
  `cod_rol` int DEFAULT NULL,
  `cod_objeto` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `crear` tinyint(1) DEFAULT '0',
  `modificar` tinyint(1) DEFAULT '0',
  `mostrar` tinyint(1) DEFAULT '0',
  `eliminar` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`cod_permiso`, `cod_rol`, `cod_objeto`, `nombre`, `crear`, `modificar`, `mostrar`, `eliminar`) VALUES
(1, 1, 4, 'Acceso total a Gestión de empleados', 1, 1, 1, 1),
(2, 1, 2, 'Acceso total a Gestión de productos', 1, 1, 1, 1),
(3, 1, 3, 'Acceso total a Gestión de salones probandoo', 1, 1, 1, 1),
(4, 1, 4, 'Acceso total a Gestión de cotizaciones', 1, 1, 1, 1),
(5, 1, 5, 'Acceso total a Gestión de reservaciones', 1, 1, 1, 1),
(6, 1, 6, 'Acceso total a Facturación de eventos', 1, 1, 1, 1),
(7, 1, 7, 'Acceso total a Facturación de entradas generales', 1, 1, 1, 1),
(9, 1, 9, 'Acceso total a Gestión de CAI', 1, 1, 1, 1),
(10, 1, 10, 'Acceso total a Bitácora del sistema', 1, 1, 1, 1),
(17, 1, 1, 'Gestión de productos', 1, 1, 1, 1),
(18, 4, 3, 'Gestión de salones', 1, 1, 1, 1),
(19, 4, 4, 'Gestión de cotizaciones', 1, 1, 1, 1),
(20, 4, 5, 'Gestión de reservaciones', 1, 1, 1, 1),
(25, 1, 11, 'Acceso total a Gestión de clientes', 1, 1, 1, 1),
(26, 1, 12, 'Acceso total a Gestión de recorridos escolares', 1, 1, 1, 1),
(27, 1, 8, 'Acceso total al Panel de administración', 1, 1, 1, 1),
(28, 1, 13, 'Acceso total a Gestión de Backup', 1, 1, 1, 1),
(33, 1, 12, 'solo visualizar detalles', 1, 1, 1, 1),
(37, 2, 1, 'probando cosas', 1, 1, 1, 0),
(39, 16, 22, 'Solo mirar empleados', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `cod_persona` int NOT NULL,
  `nombre_persona` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`cod_persona`, `nombre_persona`, `fecha_nacimiento`, `sexo`, `dni`) VALUES
(72, 'Kellyn Castillo', '2003-03-12', 'Femenino', '0801200305623'),
(74, 'Kellyn Castillo', '2004-04-12', 'Femenino', '0801200305624'),
(75, 'Yamileth Flores', '2005-05-13', 'Femenino', '0801200305609'),
(76, 'Luis Molina', '2004-02-10', 'Masculino', '08012078633'),
(78, 'Moises Ucles', '2000-12-05', 'Masculino', '0806200003213'),
(79, 'Roger Figueroa', '2025-06-03', 'Masculino', '0807200000087'),
(80, 'Josue Cabrera', '1999-05-10', 'Masculino', '0801200300007'),
(81, 'Jeremy Mejia', '2000-03-15', 'Masculino', '0801200327456'),
(82, 'Miguel Garcia', '2000-07-02', 'Masculino', '080120001321'),
(84, 'luis molina', '2005-02-22', 'Masculino', '0801200504792'),
(86, 'Luis Molina', '2025-07-09', 'Masculino', '080120050479'),
(87, 'Jeremy Mejia', '2002-03-19', 'Masculino', '0801200202766'),
(88, 'Josue Said', '2025-07-09', 'Masculino', '0801200600000'),
(89, 'gustabo serati', '2025-07-17', 'Masculino', '1212'),
(91, 'dasdas', '1986-07-09', 'Masculino', '0801200905623'),
(96, 'Roger Obando', '2001-12-08', 'Masculino', '0208200200564'),
(99, 'kellyn castilloo', '2000-02-08', 'Femenino', '0801298765678'),
(100, 'roger obando', '2005-02-28', 'Masculino', '0801000000000'),
(103, 'prueba de actualizacion', '2000-12-12', 'Masculino', '0801200131120'),
(107, 'juan', NULL, NULL, NULL),
(108, 'CONSUMIDOR FINAL', NULL, NULL, NULL),
(111, 'Administrador UNAH', '2000-07-02', 'Femenino', '0801202512872'),
(112, 'prueba de jose', '2000-12-12', 'Masculino', '0801928272626'),
(114, 'Miguel Angel Garcia Barahona', '2000-12-12', 'Masculino', '0801262524224');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_recuperacion`
--

CREATE TABLE `preguntas_recuperacion` (
  `cod_pregunta` int NOT NULL,
  `pregunta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `preguntas_recuperacion`
--

INSERT INTO `preguntas_recuperacion` (`cod_pregunta`, `pregunta`) VALUES
(1, '¿Nombre de tu primera mascota?'),
(2, '¿Ciudad donde naciste?'),
(3, '¿Nombre de tu mejor amigo de la infancia?'),
(4, '¿Nombre de tu primer maestro?'),
(5, '¿Cuál es el segundo nombre de tu padre?'),
(6, '¿En qué ciudad se conocieron tus padres?'),
(7, '¿Cuál era el nombre de tu escuela primaria?'),
(8, '¿Cuál es tu comida favorita?'),
(9, '¿Cuál es tu película favorita?'),
(10, '¿Nombre de tu primer jefe?'),
(11, '¿Cuál es el nombre de tu abuelo materno?'),
(12, '¿Cuál es el nombre de tu abuela paterna?'),
(13, '¿Cuál fue tu primer empleo?'),
(14, '¿Cuál es el nombre de tu hermano mayor?'),
(15, '¿Cuál es el nombre de tu libro favorito?'),
(16, '¿Cuál es el nombre de tu equipo deportivo favorito?'),
(17, '¿Cuál es el color de tu primer automóvil?'),
(18, '¿Dónde fue tu primer viaje al extranjero?'),
(19, '¿Cuál es tu lugar de vacaciones favorito?'),
(20, '¿En qué calle creciste?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `cod_rol` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`cod_rol`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Dirección', 'Acceso total al sistema', 1),
(2, 'FacEL', 'facturas', 1),
(3, 'Escolar', 'Gestion recorridos esocolares', 1),
(4, 'Evento', 'Encargado de los eventos y sus operaciones', 1),
(5, 'Factaquilla', 'Facturación de taquilla', 1),
(15, 'Ventanilla', 'Entrada General', 1),
(16, 'Temporal', 'Solo unos dias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salones`
--

CREATE TABLE `salones` (
  `cod_salon` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `capacidad` int DEFAULT NULL,
  `estado` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `salones`
--

INSERT INTO `salones` (`cod_salon`, `nombre`, `descripcion`, `capacidad`, `estado`) VALUES
(21, 'SALON CULTURAL', 'Incluye audio parlantes, dos camerinos y proyector de video', 180, 1),
(22, 'SALON ARTE', 'Incluye sillas, mesas y audio parlante', 120, 1),
(23, 'SALON LOBBY', 'Incluye audio parlante, sillas y mesas.', 300, 1),
(24, 'SALON MEDIO LOBBY', 'central', 100, 1),
(25, 'SALON KIOSKO', 'audio', 100, 1),
(26, 'SALON AREA DEL TREN', 'audio y mesas', 100, 1),
(27, 'SALON TEMPORALES', 'Información', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon_horario`
--

CREATE TABLE `salon_horario` (
  `cod_salon_horario` int NOT NULL,
  `cod_salon` int DEFAULT NULL,
  `cod_tipo_horario` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `precio_hora_extra` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `salon_horario`
--

INSERT INTO `salon_horario` (`cod_salon_horario`, `cod_salon`, `cod_tipo_horario`, `precio`, `precio_hora_extra`) VALUES
(41, 21, 1, 10120.00, 3162.00),
(42, 21, 2, 11385.00, 3162.50),
(43, 22, 1, 8222.50, 2530.00),
(44, 22, 2, 9487.50, 2530.00),
(45, 23, 1, 32257.50, 8538.75),
(46, 23, 2, 33522.50, 32257.50),
(47, 24, 1, 16128.75, 4269.38),
(48, 24, 2, 16761.25, 16128.75),
(49, 25, 1, 150.00, 25.00),
(50, 25, 2, 200.00, 30.00),
(51, 26, 1, 20125.00, 4887.50),
(52, 26, 2, 21275.00, 20125.00),
(53, 27, 1, 5175.00, 1725.00),
(54, 27, 2, 6325.00, 5175.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3u4T6QgAs5x5DMtfL35bbQURPSPy6vF9ZA2WKumT', NULL, '181.115.60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbE5pYm1WMFNTdGlWR1JaYkhaYVkxQnpkSEJCYUZFOVBTSXNJblpoYkhWbElqb2lWMHBUTmxvMGMxVkxZVEZLSzNwUVEwRk5kblJ1YzFZNFdtUjJUWEozTlU1bWFEbGFOVU5KWW1FMk1FdDRjR1JsTjJacmEzaHpObGRXWkdrNFltOVVjM3BEVDJSSVFYSnpSbFptYUVKQ1RUUk1URlZuU1dWR2FXcFhOWFIyYWtGb2VXTkZUemhIUkdWelpUWndVbE5UYkV0ek0zb3Jla2xHTDNOV1ptaDJWMHhQSzFaUlltUmlUWGQ1WlZaVVVGSXZTemRFTlVsUE0yMDJMemxwWkhoVmRXeHlhbmxhVm1WelQzSmxLMEoxUjFOcmVHcENRMDgyWmxkaWNWcENXbXBqZEZKNWJtbE1RbU1yTUM5Vk9VOWFSa2hGUVVkdVJuUlFNa2R2Y2pkVVV6Wk5kV3BOWWxCNVZVZHhOSFV4ZFZvMVRVTllOMDlWUTJzMU5EWkVVbkJhVGpncmJIQmtlRXhWVDA5c1VHczNRVXB1VEdKc1NFRTlQU0lzSW0xaFl5STZJbUkzWlRJMk5UTTVObUl4TnpZeU0yTTNNV016Tm1VNU1UQmhOREEyWkdSak5HRTBaREpsWlRrMk5XSXlNR0UwTjJFd05qZ3lZamd5Wm1ObU1UWmxZVGNpTENKMFlXY2lPaUlpZlE9PQ==', 1754882179),
('4sKed7E7Fyrf4MpKE1qtXtTmWC1m5dh0UDcbStCn', NULL, '45.182.22.37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbWRCUms0dll6WjJNWEpzU21vdlkwUlNTM2xCYzJjOVBTSXNJblpoYkhWbElqb2lRbEZ1UkhkWWJuRXphVEJCV1ZWck1FdFRabFl4VDJwR1VuQkRVbGRZVkc1b2RGZGFSVVZYV0U1d1RUZEZObTVEU210dWNuWlZhMFZ3TnpSdGNtYzVSSGRTV1hvM1dFOUliVVZxWVV3M1ZteE5iblp2VTBwTmNITmhOa3hSZG1NNVFsb3hLM1ZMYUVkV1YxSnZjbHBPWW1NdmJIVlRlalF3ZWt4cVJ5dE9Na0ZNYWpSRFZVUjNhWGxoY2pFclZtOUVWbFF6U21sRGMyRk5VRTE2UWpKWk5uZENibFpUV0UxSWNFbFNhV3REVmxkdWNHUnpiRlZIYVhBcmVHdzJXalJUUVUxeU5VWkNlV1FyUWtaM2VVZHRXbTB3ZVhweU0wZEdTME0yYzBzdmNtczBaME00U1hkMGIzUmFNSE5OTkZOUFNtWjZlSE5UVGpFclpsWXpPWGx3VTNOclNEVnJUVTVYTlRaVU1VVnVhamhpV1dOaFVqTkpORnB2V2xkVFRtNXVXVnBIU2pFck5EQnJVMDgyVmpacFpGTlJNbWs1ZEhwblQyOVVSVTQwVUd4VGFUaHFkWEExWm1aaE5uRkVkelJzU1cxMWRFdHhhVkZWV21SdUt6bG5NVkF3YjJzNFZGRnpSR1kyT0RaVE1reFdSM1JOTjIxVllXcFFlVFZVY1U5VFJIUjRXSEIwVUc1dGMzRTFUMmxxYWxGclpVVTBOQzkzTkM5UWVXVkpUMFZKYUZaQlJWQXhlalY2WlRKUk5rSXpjR2hpUlhGU1pIbHJkbTlYUld4eVdIQm5LM2xaVldNemVGVjRXR0Z4VEhsVmVsZGlTSFJWU21SbVNqQk9ZbEp4VkRGamRWRktOelZ2WmtKQ1lWSkVhR1p1U214RUwwTk5OMWx6UjNOcVVUSjFReXRwZFVwallsaENjMGhwZWpaUldrczRkM3BWVUZOVlZXVlZSMkpWZGpsUVYzaHhPVnBGV0dZNFltSktiVXQwTlUxclNXdHlkMjlSVjBKQlRISmxhM1JrZWl0VVUxcFJiblZzYnpWcE9GTTBaa1JMTkU1VVJEZFVZbEp6UlVaaU4wcEVNRGM0TTJSc1RqZFhNRlZKUzNOdFREUkhOMGR6VTFSUFRUSlJaemQzWlhsWGNsRlVLM2x1TkhRMFQxWnZWMjFUYURaMVYxQnlPSFF6ZWxoV0syNTFNREl2VkcweVpHbHJjVEpQUVV4RFRVOHdaSGx3UWpCMlJYUlFXVUYyWldKdVFWTTJiWFJTYUcxaGFXOTVSRVY0ZGxaTWJWTktNRVYwY3pOMGVscEtiaTlNWkZkNmIzZE1TVTFUY25RelNFdFlRVVUzUkV3eGRYVnFkRXQ0YWxSaGMyeG1SbmwyTkZSc2VDdG5OVEp0VUM5UEwwcHRRemc1UzNkMlRrMVNXVEpqUjNKM1F6Z3hjRFowYlc1YWJsWjBUMVlyVlVOVk1GVnJNM2wxTkU1MFRXdFplblZhVW1kcWFVbDVZV2gyU0RVMU9HeEdVbVo2Tkhjd1JDODJSMmcwYlVwcmJFSTRTRE5FYVVORlJrWmplVWt6VERjeFZWZGFVbGREVVVzeWJqUXlPRnBqZHpKWVduQkNWRWR1ZUhwUllURm1ObU5zUlM5d1FpdHZNamRzTlRscU9YUjNVVWh5TUhkVWVDOU9iME5oZUdsV1EyMDFWM3BqVUhScVdrRk9hMVJxU205Tk5Xa3pWM0puYlZsaFdWVnFMMDEyY1ZCM1dHNTJZWGwzU21kSk1XUm5NVlZTVlUwMlVrNU5NekpMVDFKRFpucDVVRVl4VWpRd1VtMTJMM0JuVDBWeVFrbEdTVkl4Tkc5T1UxRmxXbEZLSzBjMUsyaEVka2xDVlRkMlJYVkdVVlJRWm1sRFJWaEZUVVpuUW1RM2NXaFJWMHBEVG5GMlNXTmpXalJQY1c5eUswaFVXWFUwUzBRMFR6bGllVUp5UmpKWk5tWk5URGN6Um1vNEsxWjVlWEV4U1VSblIwZDJiemR3TDNoemVVY3JLM2xoWTNoVmIySjFTaXRuZGxOUGJqQjJTalp4Ym1jcmQzUjFTakZNVlZwWWVXSkhVMkZPVDNoeGJFNVBiRzVwTTFGNVNURXZXVFY0Y1M5NGVURjJhbWMwTWtkc1lqQXJTM2wyVjBWTFoyMVRlVTFGUzFSUVJ6UjFVV014YzAxU2QzcFVjWHBIZEZGYWIxVldha3N6T1U4eFprbHBhekZvWm1wdVEyODRhekoxY1daS1psVlBWaTlXZDJWc00yMVlaM2d6V1hGclV5czFXV3hZSzNST1lqSk5Va0oxU2xsUk1WaElkWHBUWVc5dllXOUhWR2hhTURsU2QzcGhUMEo0U0dOMmNYTmhiRTAwZFRBNVdrUlViMU4wVDJWeE1IRkxWMkZpVkhSc1UyZDVSMEpMYlhRNFpITllSMlJOZFVGdldXNXVTMGxzYzNSbFZGZG1SamN4V2padmNVZHhRMGcxUVdZeWVFUm5NUzlrVEdJeFNscExXWEJ3VUhkcGNHSlJlbGxDWVZoMVVVbExRVEZ5VEdKdFJWSkNiVnB3VHpaSE5sZHpORVpTYjJoTGJrUXdiV2QwWmpKSlZXMXFhWEZJVlZScGFFY3ZhM0VyYVdweGJsZHRhVEpDUzFjNE0wZEZWM1phZGxZM1ZqaFFVWEJMUm5GVVdEaDZNRUpKZEdwc1RVdzRLM2h3U0cxck5HSk5WVGxLWW05MVRYaExRMlJ1YmxKQmRYRXpOblV6VDBKUFIwVnlkMmRoTW1nd1NHdG5USHBSVVZWb1dTOHJibXBLSzJwTFoyRkpWWGQwWTJaaWNtSkhSMFE1VXpBeGVUZzNjWFpXTTA1MldXOUtNemhxZEZSc1MzaFRNWEZFTDFwTmR5OWFaUzlJZVdVM2FYSlVXVEV4Y2toclkzTkRPRXRaVEVjMlpUZzBiV2hMVkdobGNYVm1UbTVMWkc1YVdtYzNUR05tVXpWYVZtTnpaR1pXWjJoNVZqaDZlVnBJWkhCQloyaG5ZWGRvT1RkTmNHUjFPR0pMVVdoQ056a3dZMXBOTjA5a1RuWnpiWFkwVUdSUGRrdGFkV2xHV0daeFlsUjVZbXN4U1U1U1JuQmhNSFZ1TTFaU1duSXJNelJLUW5WMVVrcHJiblpPTkRSUk9UWmhOMkU0TmxCWVdITjVVRWh1VldkdGRXNHhURm81ZWpWSE16aERkRGxNZDJ0T2RTdDRTa1ZCWkdoaFRYcGFiWFZLUW0wd05rWlFSMjQzU3pJd1prcFFabkpKVkRaYVpYQXlWSEJYVkRSUUwxUkdhR2xEWmxNd1VVeERNMms0VVUxeGIwZFNPVkJRWm5BeVlVNDJVbGR2UjNsQmQwczBhbTFHZEZkeGVqUnVUVGx4VTNGdE9FZGlkMDQzY0ZSR1ZqUjJhVlJPVEdsSFltOVBjM1ZqY3pFeVdHbG1PR1UxWTJWRmFtWjNaekp6Ym5aRldVdHdaMXBuV0d4UlJsRXlNRVptZW5BeUt6VTJPRkk0WkU5eFNqTTBlSFZIS3pWbmJGVjVXVEJSU21sM1UzTXZSMkV3ZGtadWJWTXdkV2hZTVhacmJUUkVUMUoyTlM5WE0ySjBZM1V6ZUVsNFREVTVkazV3U1ZreFFUWjBSSGx6TVZjd1N6ZDViRXgzYTAxNVVpdFdRMXB6SzBwblJVZ3hTRlpxVmpkVk0wa3liREJwZUdoQlZtVTNUU3RFYVdGNWEzaHFabVpCWlhwdWVHNHpPVFY0ZGxCTVMyTllaMnBNYTFOd1l6UmhRakZVU0hoak5VbHRZMDlqUmtOM05qSmtObE0wYzJkS05YQjZUWHBMY1VwVGNqWnFSWGt3VTJJclVFZE1WV3RYTkU5aWNTdERNalE1ZUhwWE4wRmhPR1Z3U0ZCNWIyVnVkMGhGZERScVdWUjRjMjVqTTFGeUwzRlFjblJ2WlZJNFFrUlpNRmw0VDNNNWFHNXVNRmNyYjFoSGN5dDFkMjB3Um1ZdlluaGlaQ3RHVGs5bWJWaFVZbVpvT0haTVoxQm9MM2R1TlVRMlQwUkZWRGxvTkZRM2NUUlBPRVJKZW10aGVXZHRiRW8wYmpZeWJuVkZRM3BrZEVWMFIwUnNTMVpqYnpoMllqaHZWRVJRWTFWUVIwcHBZakJSVVhWeVpFSk9OR2hZTlhKU1pYa3JkbkJzUldkd2J6Uk5lR3h6UldsblVsSnRXRU4wYW0xVGNXaERlVEI2WjBSM1VFMVRTMjFvZVc5SGMwOW1ObVUwUkM5R1NqRlBlQ3RRTmpaTWJraHhXa2wzTjNKRFppdGlPV3RUUkdnNU9FSllaR3RJTVUxTGRHbHJOVFZMUjIxVWVrcERUMWR0WW1Ob2FUZE1ZMHhOWVVFM1lsRjVZWFJrTkZZMFdFODBTRk5qTVV0WWFqaHBUMFV2Y1RFM1NGbzRLMHBzYVVWWk4waHJXblZWZDBWWVprUjZOemhVY1hrdloyZFNLemx4ZEc1aWF6aFpOVGhPU2pkTFFrZzBNMlV6TkVkQmNHUjRLMGhoUVRWSlYzWlpjbTluUjFaak1Yb3laRXgwYlU5aE9UWlRNbVY0UkZGd1FrZE1kRFpMTTFSM1kxTTBVbGN5YUc5dVdEWkhiMUpGYUhwSGRqYzJkRFIwYVRZNEx6QlFiV1pTVEV4cFNtaFFTVTR6VEVKWlExWkpNR1l3YTBsMlZsY3lVVUkzT1RacFIyWmpRbUZuU1RoV01XSnpha2xuYUZKV2FsSTBUMFZDWWxoc1ZucFllVTFVZWl0aVRIaHBVVEE1U0VONlltOWlhR2hVWkM5WE1HdGxNVVJOVkc5amIyUjNkMmhLWTBkSk9IUnlPREpNZEhsWUwwTnNjVGxEWVdGNVpFMW1MMU5oZVc1MVFtb3hjbVF3VG5OQk1XWmpaVFV3WjFkTVpHTkxhbmR5WW5WRFNsaG9kVzV6YzNKallqUkNjMkpNUjBwSmNrWTFWMHQzVDJwWWRHTnpkMnRRU1hOTWNteEJWV1p3WW1vd05tZGpTVlpPYlV0RWJUZGhOVzFFWWtwdGQydzFPSGRCUm5Cc2JrNW5XRlJ4UjFkM0wxcG9OVVl5V1c1c2VrWnhWMEoxTkdSc05uQnRaVFpUZFhWU2R6UjJTMjlWYm1ZM1VVYzRlRFl6YlZkNGVHaHNka0pKZW05UlMwNXhiR05SV0U1NFQwMHZUMGRKVDNBMVVVRXdWak5MUkZaRFJWZzNiVmczU1ROemNGSnFVME5YZVdkR2VrYzJUVE51YUVWRU9HOUdZa0Y1U25sWVoybGFSMFZHVmtkMmVsUldVSGd4VnpSc1pqZExTVGhyZVNzMlJtdHVNMkY0TWpSWFNVaEhNRm81WkU5RVJHOUVkRTV4YVUxcVMxZDVVV05tZGtzd1drUmFhbkF4V210d1VsWkhibkJqVG1wdFkwbFphbmhLU3pscVVuVnNhMnhoU0ZSMlJqUTVRa1pxSzNSNFVuVnNVR3RqY25sTFQzSTFXRVpLYWxwS1dFeEhWRFp0V2s5VlVFTk1NeXRxZVROTFMwVmhObEpCV2s1TVJXdDBWbnBTV1VwMmIzUmlRbWxoVTAxcEt6QmFTVkkzZGxCQ1dVZE9MMUl5VlRaM2EwSldhSFpVTVcwM1JuSndRM1pEYW5GTFJHOVdhU3RXZFU4d1N6VmxUbXRuZUhKUVVXc3ZVMGxCSzFrMVR6ZDRheTlZWTNKRlkxbGpaRXQwVVhaRE9GRmFNbVU1TlVaTGRFZ3ZVVWd5VDJoeWMwdHZiVFppUVRKRmRHbFlXa3BNZWtOamVGUmlOMEVyY25scFlVbFFlWFpyWkdOSVNEbDBhM2cyZGtSbk5Ea3hkbGwwYzJNMkt6TnplRzh5UWpRd1lYQXZaMXBTYTFwTlluUkZlR1ZvSzAxcVRtMUpjbHBhWldOTWNGVjViR2hwTjBSck1uZFRjVGQ2Ym1OUlFqbE5RelpGYjJoWVkycEpWVmxXU0dFeFIzUnFaMFl5TlRZNFRWVk1PRnBFZDAxTFFWZDRhemQ2TkhWSVowMDVSVnA1UW1SdlQzaGFRMEpOSzAxblVsQnFaa3hJZW5wT1RuRTFNMXBsYmxsVFlsRkVWR1pNVUZocGVYRjJUa0p1YmxVM1dGWjBjRlp5VEZFM1ZpODNTVEZWUmlzd1RUQmlPREF3Y1hOcmVVeEpTaXMxV2pFd05rRlRlaTlKVkRGbFJsaHdSMUF4VmtwRllYcE5iek5ZTURVNFNqaFlSRkZXZWxGU1FYY3lSWFJOVFhJclNHSXZiMlZHV2tzdk1ISkdhamhWUkRSck0xY3lVMG81VVVKM1FubFRaV2xZVWtSNFYxUjBPVk0yVDJ4NlNrZG1WakEzVWpWbUswOVpibmhDTTNGVVRrWXljVkZwYlZCYWFrUXZPWEYxV2pGaVRXTllRVTlYVmtRMFFXSmlSV2RHVG5CaVdsRjVPWGRHWXpGb1MxQm5NM0p3U1RFM2FuSmhWalJzVjJoQ2FIcEhTVWx5Y1dKUVQxTnZUME56ZUdSSmNtWlVTMnRDZVRkM1JqSnNhRmg1Y3pJMU1qY3JWVmxNVGxab2QzTnJUbE5MU1RRMVFtUjJkMGxtU0N0TlNUQlFOVUYwYmxsdlVuaDFhRGQ2UmtaMlIxVTJWME5qU0dsNlFpOXphRlZwT1RscU5YZEphakJHT1dsaWNIQXZUWGRZVFdkT1UyeEdUSFJEWjBOcFZYaENSM1Z3ZEhsUFowVklVM1JrT0ZOVVJGWTRha3ROUzJwS1ZUbFhVM2xETm1wMWFuRlNXVk5aWWtWelJUSlNOR3MxYVZNd2VGQktUMDB5Tm1OVFNtdHhRalZNV2tOR2VFNVhVRUZuWmtvNVNUWndlVFpyY2tkWlZHNHpWMHRTT0Rsc1RUUnNha1phYmtGc1VWVk9NRU5OVjNaUWNYcGFWREJwUVhZclpWWTBXVUkwU2xSRU1URXJjVGRYWldWRlFpODRha1prZFRrclQzVm5WVE5wYWtWd2FrdGhVbE5zVmtoQ1VVOU5kbkZ4ZGpaVFZYSTRibXQwYjB4S1JHOUtSMlk1U2xScmVUQnBiazlST1VOQlJHZGlPRVJNWkhCeFJtUnhVREJTY1dwdkwzSnVTRVpEV1dvNVZEQnVOazl4ZVRoeloybzNZVVZvVDNsM1MyOW9TMVpsV2twT2JtaHdZek5uZWtSTWVWSjBabFpOZVRsUldHNWFlbEk0Y25wTmFXVXJkRU5wTURaS1pFWldRVXBzV21sWlpHSmtkbk13TVVsRFNpdG1ka0l6VUdSR0wzSXdkMW92VkhoaFFXUlFUVWRhWnprMWVrdG1OblZqZDI4dlNGUmFlR2t5VGxsMWVuUnljRkpvYURVd0szaE9UbFZwVURZcldFUlRVR0k0VmpKMU1EWkRTR0pOVVVsdVRFMDRWVmhPTHprckwySklLM2RFWWtOeFRITXZUazUxYTJab0wwbzNPV1pXSzBGSmNEaERPRVJ2VEdwdGJFTkpaVzB3WW0xWVNUZHRaWGd4YVZacE9XOVFSalYzT1dGWVduQlpVRTEyY3pWNFYzZzRTVFpSY1c0eFZIcE9UVTB3WlZkNGMxbFlkRzlLV2xaakwzaHJUbGwzTmxCbFUwSlVhbVpoYXpkc2IyaFJVbEEwU1hOSFYxRnFlRzkzUlV0M1lURjFRWFl3VjNKbVdsbG9iMWdyYW0xNFN6QlBWR2gyYjFkcWREWkJRVmR2UlZjMlQyOWpORTlKTkdRMWRHRjRiVzVXT0haQ1dFdEVSM0pFTDBGQmRIUkxNM0p4Wnk5dlZGRlpSWGhJV2tkNlZVZDZXbGN5Ykc1SVJrZ3lVRXR0ZHl0VlduSjNOVWRzZVhWdVJtWkdXV3c0ZW5wc2NHSkNUak01Wkc1RlVtWkVlVWRXWWs1dlJHaEZPR0U0WjBKUk1XOWlRVFJFZFhOdFFuWlhVRUoyU0c5MWFFVXlTRGRIV0RkQlVIaFlhVXR2Wm10ME1rRnlVbG8yZVZKWFpERjFSRWxETTNwV00wYzRWamxRYWpodVZFMTNLMWx5VmtGallqQjFlV05NV1dwME5YVkdhR2hDWW5SWkwzRm1ObHBsYWxadk5YSjJZVzk1WnpKaFNIQnROM0pFZEhVNU1pOTVZMVpVWW5oMVZWUTFjRlpqV0V4Q1NHWkNibVYwYVVSbldWSnlTbmxqY1RCdFVsRmtSSEJGUzNGTE9UZ3dXRTUyVGxNMlpEWkZVVmxtVUdnMVFTdEdOelJrUVU1TE1HdDBPSFJFWm5oQldUQkdNemR0UlV4RmNrSmplbVEyVjFCelNHVmtNMFZ0VEZweGNtRkNNRVE1VjJSSVpGVXdhMDVqV1VNd2FrYzVabFYwWTJsemJrNXRUR2QzU0cxSldGRXpiRVpGVjJ0WVYxQXpZMGhNYmxOUE1UQmpRbXRpYmpkMmJYTXlOMXBtVUROc2NsaEhhMDVNY0dkalVsa3dRek5qV25KM2VrRlBlRTFWYTBGdFdFRkJla013UTFaWlVrWnJRa05zTmxNMWNIVkNhMEpIVldkb1Qyb3llVzAwV0dGemJrcERTbTVXWmpkNmQxUnBjSHB3T0VWMVpIcElVRTltUWxsYWQyUk9iRFk1U1haa09ISTNTMUpyT0VoRmVXRlNSamxZTVcxbFYxVktTbk5pUWtWWk1UaFZjRFp2WTFCTmJEVmphVVpUWld4WGVtcGlVekpoWjB4aFN5dEpRa1ZqWkZKM09VcEpSUzlsV1U1VU5pOTJhRnBrVDNwMVdEbHljak5rUVRaM1dGaDNZVUZJYzA4clYzSnNkbEZDZG5nMFMzbElja1ZIWjNsaVVVMUdlbkUxZGxSc1lpc3ZSbVpYTlZGUWFITXhhR1pJVDNWQmRHWjNXSG96Y1c1MFpubEdXa1ZST1ZWakwyMUtiazh5Ym1sVFNXcGxOa3huY0dsb04yWnFlVlJ3ZUVGNFZXbzNSbVpPZVhKeFVqSkJRVXhQTWpkVk5TOXdMM0ZVZUdoaVRuaG9kREZWYUhOTWIxQnRXVEZsVUZaUlRFWjVjelJaVVhZelZsQm9PRFpPU2xCMFpsVjVaVmRhT0VwTVV6UkphMnhHU2pOS1V6RnphbFJDWTFZMU5WQnFXVGN2VjBFdlV6WllZemMwY1daNVExQklVRVpJWmtGWlRFTkVWMDFaWmpKMVZteFpVR2hPYTFwcWEzVlBSSGRoVTNGWmJpOWhXRGh0VlZWU0szVnBaak14YkdwRGJUTmpZME5CUTNSb2NHeGxUVEpCVTFSMk5qSkpRbWh0V2tkNVRVVmhRbGRCTTFaM1dqRjJabWx6ZFdWVE9Xb3dUMk5ET1VVMlRYVk5abXMxY21KVlRFTXZNMVIwTkRndmVURndhRVl3WTFCMWFtODNTRWxPVDJKeFFYaDViR3MyU0daVVVtcHBNV2hyVUd0bFVVOVRRVWgxTDBKU1VXRk9PVVU1YVhrelpVaEtVRWxoYkhRMEswY3lhMFUwY1ZSTWNXOHpkV00wVEhJdlpqTk1Zemh5WVcxd1lUWlljRW95YTJJMGFIUkZXWFExVEhsSWJteFBRVm8xZFROdWRXVlNhamhNWlVnMFkzaFJkMFpIT0RScGVFUkVieTlWWjJKU00yUkpVbEpOVlZkMFVsRlpORk16WkdSNVVFSkthamh0YzNWSWQxcFNZa3RHYWxwdFRsaHhVamg2T1RGaEwxcHBUSEZCUm5wNE5UVTVabVJDVVdkMFIwVmFSSFZwTVVnMlNrVk5hbThyUlRSVWRIVktaM04zTm1kQk4yMHhZMUZYZEhscFZtMDVjalZVWmk5TWRWTlVRazVxU2xCUlEzVlpMMDFUV0RSNVYwSmlSemRRVW05TGVDdGpTVVo1U21NME9XaG9iSGcwYzJKeGFFNHlibGhDY25SM2FFNVVhRkYxUmtSeGVWZEdjM1JMYVV0UWFteE1MM0JPV0dkblprMXJNbXRTVlZScVpIVk9LMU53TkZwSk1HZGpVVnBNWjJSWVpUQTBMMnROVTFaV05HRlhPRGh0WVhaMlkyVlBXbUZXZURJMVJFWlBNV3RyT1VoM1pHcHRVRWh4ZDNKNmJqaG9hbEZWWnl0M1kyVmhLemN3TkRJMVdtNTFNbFZaT0ZwaE4wUmplRGREY21kR1JWVlJXRU5PTms1b2RtSnhNVkZRYkVnM1JWUTFhbGs1T1RKNVdWcFZMMEZRUkZWT0wyeEZTRTExYnpSeWFVWmhWRTFvVkZJd05uYzRaM3BsZVRCck9GaHhVMWxQYjFRekt6UjZkVlY0U1hOak0yZHlUUzlRVXpRMU1UaE9jVEJqU2poeFJWWjRWM0o1ZVdVelVFcFBTMU5TTkZwb05qQXdLMDVPY1hWcE5TdDRVbHB4ZVdaeGQxZEtibkZwVm1GV1NGb3JPQzlYTDJkRmEzZGpla1JVZEdObVdHdDBhbEZvVmxoUU5XaEZRM1JxTXpGVVJrUnJLMDVzYUhRNVQwbGtTVEZFVjBOdGNGUnhSMlY0VDJSMWFIVmpaSE5aUWtob2VDdDNNRGMzY2sxSVpHbFFjVEZEUkVaUmRESnVURzFFWlU5UWNrRnNSV3hZWVhSQ2NWWXhiRllyZEVKSmJ6TTBOekEzV0hsYVZqWnVka05XYTFSc1ZVbFRTRTlSUTI1WGJrcHNNMDUyYzJJM09XaG9VV05wY0ZVMU5YUmpjVlpXWW1SMmMyWkNja3dyUzNOVWFscEJVbTlCY0VraUxDSnRZV01pT2lJMll6VmtaR0poTnpBd1lXVXhPR1l4TVRjeU5ESTROakZoWVRVMk4ySmlZakUzTURNMk4yRXpNR1ZtWldRd1pEZ3pNVGN3WTJNMFpHUXpabVU0WWpJNUlpd2lkR0ZuSWpvaUluMD0=', 1754877852),
('57Vac1nvSSVLJudpClOHTNbrNMXlGvtzwgFht1Eo', NULL, '190.53.249.85', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) GSA/380.0.788317806 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJa3hpYUhOcGVHeFlVMDl3WTFST0swMDRZV2hvYmxFOVBTSXNJblpoYkhWbElqb2lVVlJCVGxoSGIxaEpTVzg1VmxwSWRqWnlSUzhyUzFkWVZWSmllVXMxTlU4M1Vrb3JNMUJaTkV0bFVrOTZaMUZ1YUZseWVVVkNRVGcyYUVreVprc3hSM1JKUmxwWFNpdFZhVUpNU25nMWJFZHBNM1pMVnpsWlZ6TkRORkV6UTFOUFlrbFRVbFV5YVhaVmF6QkZMM3BUTDBwaE4yeGlZa2RhY3pSU1IybDZVV1JtY2xkRFNrVjBlRkZXZGtjeFFYUXdVbWR1Y3pkaFFVTjNaalZ4VG1SWVZVTXdWVXBVYkZWT1VGUTFZMHhZYm1SV2NHRm9MemRTUjNFcmNVNUljazloSzBKWVJXOWFhV1VyVnpsUGRVRkNTVU4yTUhsaGVraERkRWR0Ym10R2VuZFpTUzl5YVd0MGVIcHhUVlpyWTNwb01IZFNXbVZJYVRsdFlVVnBaR3RVZFUxa09HMTNPWEZPZGxsNWJXOUpkMDFFWlU5dVUyYzlQU0lzSW0xaFl5STZJamRoTUdZek1ETmpaVEE1WW1FMllqZGlOalU0TmpFeU5tTTJaakJoTlRabE9UUXpNalE0WkRVellqZzNaRFExTVRFMlpETmhOVEppTkdJelltSXlNVGdpTENKMFlXY2lPaUlpZlE9PQ==', 1754866267),
('5TP6K7oMSdaBT9DEsj26i0E3hXabK027doetjKoB', NULL, '201.220.139.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbmxGT0hWcE9UWmhNR2h2WVVWTk5Ea3hUMnhhUzFFOVBTSXNJblpoYkhWbElqb2lhMnRxWlNzM1QxSjZSWFJYUVhKQldERjRTVWRaZDNoMFRUVnJSbloyV2pZMVpqRlpLeXRxTVhWSmMwVnJiV0kzVkU5RGFDdEZLMWRpVkZOMU16azJTMlZEVDNoUEszSnNRMEZuY25GUFEzSmtjbTFuZDNKRWVUQlFTQ3QwT1V4TFZqRlVhblZVT0hoS2NEbHRLMXBvZUU1eWVUZFdNSGRUUm5Cc1lWUnFNMkpJTDFGRFYwNUZTelUxVXpabFFUZ3dhMmhsVURJMk16UlFNSEJDZVRJNE4zRTFRM3BzVkVaQmJqUkdZamhYYld4NlpIVktURVJ0YzIwNGJFWklhRmd2WVZrNVRFVmplVTFxVmtwVFVsTkJVV05RTVV0aVNFaENNRzk1UWxFMFEzSnRXVzg1YVZCNlVYZFFhbEJZV1hCTFZHbDVhM0ZxYkRCRGJsTnFhek5RWm14RVJVWkRXSHB2UVZOVGMzZGpjbFI0YzJaSWIwRTlQU0lzSW0xaFl5STZJbUV6TnpBNFpXUTVPRE5oTVdJd1ptRmhNV1UyT0dJMlpUWmxNbVJqTTJVMVpUa3pOR0psWkdOaU56azBPV05qT1Rnd1pUQm1OR0V4WkdWaU16UXpNemNpTENKMFlXY2lPaUlpZlE9PQ==', 1754888747),
('7jl3AT6IaMt1CEtIk6k7HXY2iDXueIV4Gh8Cb4BT', NULL, '162.62.213.165', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJbFkxV1V4SVFrcEJTVXRUV1ZnemIwSkZjbVI1Y1djOVBTSXNJblpoYkhWbElqb2lTa3BVWmtzclRqTlpTelY2TXpjeU5tSmFWakZzYUZvMFRsaHJVamw0UmtGdE5qSnZZVmgxV2t0NVdtTk9VMnh2T1ZKb1luZGxVV3hKTURBemVrOVhNV3BaV1M5cVZtVmhUemQ2WmtaWGVUWlVWMmxoYmpSblMzWnBVVU4xZUd0cVNXVTVXa0p4V0hVNWIzazFWMUZUZVRkV2RHeDRSMmhKWTFOTVRIaEdWbU5QVVZGSlJISjVObE5TU25KalVWcEZZVFJ5YjBWM1FYaFhOV2hCY2pSTksxSmhORWRKU0VwSFRGSmFObTVvVDA1MVEwc3dZVkpRTjJsWlVVNWhWMFYxU1hVMU1XOWhPWEl3Y3psdk1VUnVPSEZqT1RKMFJtaHROVVZhTTNOYVIxWkJNSHBCTmk4M05HbHNjMWxhUlRoNlNGWkNRa1F2U0hsM1JFTnRaVVJNUlZCNk5ETnlWMmhCZEc0d2VFdHNkRmdyWVZaaFUyYzlQU0lzSW0xaFl5STZJakkwWlRjNU5ESXdaV1JtWldGaE9UUmxPV1UxWldReE9EY3pZbU0xWVRnd09XWTJNRGMxTmpFNU5EZzJaRFEzTlRJell6SmlaVFEzWWpaaE0yWXhPRFFpTENKMFlXY2lPaUlpZlE9PQ==', 1754885342),
('Ak2POcKQdsHIQktmhBBSJqVisVsNlNutWbGGgRyY', NULL, '181.115.60.0', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36', 'ZXlKcGRpSTZJbFZVWWt0SlowNTBaV294TUVwMVRYRkNTekJxTm5jOVBTSXNJblpoYkhWbElqb2lhek16UlVabVkxTkdaMk5YZFU1SFYyMXVkRFEwUTNaRVlteERWbVF2V0M5RGJraGFhV1pwT0dVNFpFZzVVMUZNWW01UGRuTmtUa1kwUTI1SFpqUlVSamxOTm5keVFuZHlWRE15UzFKa1NtcEZOVlUyY1RSVVRVZ3JabmRsVEdKWEx6a3hTV3BLUVU1VE9UZGFZMGR1VDJaNGNrTnhURVJCVldKUVUyaFZVM1Y1UmtGcVdYbDJZVk5RTmpscFkzaEZNVFYxWmxWbU5XSmxUMVI1VkhKcWVFZDZkRElyUjJWdWVFaFpSbGhHUlcxSlFUbDVXR3ROYm10QldVbERWRWN6Y1hwaWRFVnJZa1JvU2k5bU5HaFdZMXBIY1VWUU5qaGxWMjlaU1dveVNVY3hOSFJJVkRoUlVGQkVWbmswYzBSbE1tbExiRXMzWWpoRU1rbE9MME5IWlVSdmNFSktZVWRVY2xSTFJFNVVaemxVZFRSMlVGaDBlbmxwZWxaNGRXRkhaSGxoTjBOUVlXSTRZM2xuU0hKaVJtRXhRMWxQVUVWamMxbHpOa3R3T1ZsVVV6RjNSMnh0VGtoaFp6WnBSR1ZxVFhSMGRYRjVOa3RIUzNOaU5tWlZVR2hXVFdVMVJqUklVV1pxUlZac2VXdFFhR0pGUjI1TGQwZzNOSGhZU0dkVldXZDNjR2xRZVd0UVVYWlpVVlI2T1hoT1JuWklkVEUxZFRKRmVESXpRek13VldaVWNYRkJjbWgzZURWMGEyZDBWekJhV1hjeVdURnFkR1YxY1hNd2JVUlBjMmhLVm1wM1ZsTTRZbVZKVVU5dFMyOWtXSEI1UWtsaGMxWk9hREJUWlU5NU1WRkViR0UxYlVGQk5qbE9UeTlYYnpReFkzQlRiVzR5UjNaamRHZE1aR3czYlZSMWJFMXZaVXhzUlhSeldHUTNRWEJ6YlZOMmNuSlFaVzFDWjFVNU5IUTJiMEl3VlVGeVREUkpVVTVPVEhKVFlrbERSbGxyWjNSck4zbHRlRFJNZW5GSWVHbFBiMHRRTVRsTGJGZHRLMHhGTVZBMmJtSlFVM0pzU1c4eVUzcDNPRmRKTTFCa1UxTnhNbkkyUVhGcWVuWktVVVpUUzNseU1VWnllWGxOYkUxRGN5dGhjVUZXZVV4YVUzZG1SVmx5YlRWc1QzaFFXRFJtZFhoVU9UUkJjbEk0YUcweFNubzVMMDQxZW5neGNXaFhXWEp1VVZsQlJtNXFhR2hJUVZwVFRIaG9OM1JqUnpoemMyRlZha1E0VURCbmJEbGFPWE4xV0RsVFJXWnNRVk0zZDBFNFdrRk1PVW9yVEhNclNIaHBRVEpZVTNwRU9XWTBTVFZtYlc1dFdISlhZM1pUTjB4VEwwMWpSa294WnpGeVNsRnhTREJVVFV4RE5XOHdTRTFQZURkUVdVbGxZbTFXZERKWU5VdGxSWEkwTm5ST1NXcFhValF5ZEV0dFNFRTNkamMxVW5sb05VUk9TVFY2YzJ4eFZXNDVXR2RGY2s1MU4yUlVUbkJWZFdod1dHMHpSR2xYZFRaNldtVkJUM3BJYURFd2QyWmtZbGxZTW05dmJrSjNRMUZhUmtKbVExQjVRbTVQVkhrMFNuZFBkekJoTHpCUlZUbEZWM0poY0RsWk1rcHNTelpxTmxOVlpUTTNhelZNUjFsbVZGQjBLM2x1YmxKcGNscDZlbVZFTm00dmVUVlhNQ3R6YVZSeFNXWnpkM0ZZZW1sVE9HdzRiMjh4YzJsallteEpLMkpHY1dOVmJFVkxVMUk0V0VvNFQyd3JjREY2UlhsbVYyeE1WSFZaVEZWWE56SXJkV2cwYVdVMVRYRk9WMWxHUkdRMFpFZFJkbmxWYjBWTEx6WjJVSG80Wm5ob2RHRlZhbEEyUm1OdldGVlFPSFZNU1U5WlNEZFdiakJyUTBOdmFVTlBhRk4yVTNOaFl6UnRPV1ZwYzBKRmRGcGhUbE56WmpWVk1FZzJUelJ1U1VjeVRXSnFWbUZ6VFV4VFoydHpNMWhSYTFKUlZGaHlXbGh1YW1Gd1YySlVjR1l2UlZCMVNWYzJlRlp3Y0c1R05tdHJOVzVLUkM5NFNpOTFaMWxyY0dSd1RHNVZRU3RrWWxCbFFXNHhiM2RPU0RaMk1XRTJOeXRuTHpGclQwdEhVRXRWT1VZdlMwTmtMek5uTVZCNVZqRlljMU16V0hOSGIzRlRlbGN3T1RaTGMzUTBZWEZMUW5kWWFsbzVOR0kyYzJ0TFQwVTFjSGhaVVN0NFNETTBkSHBNZEhCRVRGcFNVeTlMYTBoNlNpdHFhRTVGT0hsaWFHa3lXV05yVkdabVdFVm1NRTlNSzBaRGQxQlNSWFpLY2pOdFpVWTBOR3hvU1U5MU9UbFNRVkJrTkRWb1pVZzVXR2RXTWxBNVlXaFlVblZIY2tSSE1uVnNXblI1ZWt4b1p6TnlOVm81TUd4WGRrZHVka1ppTWtwWU9YcExlV1J1ZWs1RWMyZHpRV05UTmtreFJVWklNMEl2Ykd4amEwVkZibHBXVldnMVJtbEhiVmRFZUVrelIxQnFlV1JFVUdodVFtZFJaRll5ZUZoc01FOVhOV2x1WjI1cGNFMDVNV1JXV1hGb01qZzNaVkZQV1VOUk1GSm5lVzVXWmtjeFVWUTRlbVJhTm1GME4yUmhOU3RXZWpCNlEwd3hla1pOYUZwRk5GVkVjRk5SU2tScFMzaEpSbTVWT1haNk4zWjVXSEJ2ZUd4RGFHTm5TRXRHT1hKU1kwNW1iRk4xWVM5NGQyUlJRbFF6UW1OWFJIWXdWbGhPUzI5SFJuSk9VR1ZtVGpSRU5FUnNZVVpITDBsWGJubzNTakJJWVV0RlpYY3lVa1J1VmxSMGMyTldkVFZGVlZOREt5OTVObGxWVVhCV1RUZ3JWSFZIU21GT1dtcGlWazV1YnpaRVNEVndOSEJLY1ZGdmJucE5aazFxVjFobmMyMUdNRFZyTkVKbGVYWnhNMEk1VWk5TFlVdzNNM1l3VWsxWlNHVlFOM2xrY3pkaVdEWkZVazA0YVROa05IUlJiVnBCU0dvemJrZEZORmRNWTFkRVJqSkNVMjVPVXpOM1NIcFdRVTQ1Y1VoTGRtcHVTVXhoWW1aNFJtcGhkMHRyVjA5a2JFOXFaVmxtTkZSVFUxbGtUazA1YjBOcWQwZzBla0ZNTVhGQ1ZsUllaM05QWTFkUmNrZHlXa1Y0UkdrelQwWmljemgxUXpsNmVuUTFSVU5tVXpNd1EybFpOR05UZDFSTkwzSnhlalZYZFhBeGVsWlJWblE0VEUxYU5HSklNWFJHTDFrd05FMUxMMWxTVTA1NFNFdHVVM0F2TUhRclZFaFZiRWs1YkVWRk4xTTJXRXRZZUc5WWVFcENieTkyZVRsWFRIZGphVzlMY1UxTGVHRk5NVzlXUWpCcFFtaG5WazB4ZG13M2JYRXZReTlzWlZWVVNYRmhVR3huYVZoS01uSXhWMkZQTTJobFdFd3pUM05tZDJOak9UVkJTWFZvYVUweVEwMTNOVmMzU0hKck1uSkdZbGR6YkVJNGFHNURWMk5TT0dscWNHeDJTMnBpWkZOSVFuUjFaazEzZFZGa1p6VktiREpvVjJrM2RFNTRWazR2Y1hRMVkycHVVVU5WUW5GR1dYbzBXWGxYYlhRd0wwOWhWemxJTHk5MU5VaEhNakpCV1daRlJqaHZka1V6YkdRM01IbHVjR0ZCTmxNck1EbEJUSGNyYVhoSlMzQlFjQ3REU3paVVdFcE9Oa1E0TVVnclFVdHRSRVpSUVZabGNETlRiMU00YVZWd2ExbFZSV2RhYmxsbU5tOVdhMlZSUzBac2JWVlBhRE40VVdkQk1YcDRiRE51VGt0bFNFaGtZakJvT1Vwb2J5dFVNSE5hVWpOTlRWbDRRMGhhV1UxcEwyazFSMGR1UlhwUlVsaGxVbEJtUVVkNVl6YzVXVFJZZFVkRFEwTk9RM0U1UW5sVVYxQmFPRzQyY0dKMldtaDRWSFZ0YVhWVmJsVXJja2hTTnpjeWJpczRhM2xGTWpsMk5FZEhVbmROTjBOQk9VWmlXVmhHWWpGNFl6VnhOSEZCVVd0RWVVNXhaVXR2UjNFek9FOVFXbTVqUjFacmJWcEhlbEkzVDBkMmJHOHZha1J0ZDI5TE1qWTRTV2xpUzBwc1JsZGlSRU0wTlZWVFZuVmhkVTlDU1ZwV1UwbzFhM04zVFRCMFZIWmtOa04yZGxGaGVVVjZZVU5qZDJsaE5FcFdkMjVTUzB0b2IyNUlWa3RFVVdsUE5ITmhVWGRSWVVKT04ydEpTMUU1VkRKUUszQlNhV2RpYzNkcmVtNXFXbVJzYTBOeU1EbGxVMUZYVlU1YVlXVjJkVkJaTVU1elFqaGhVWFJXZFVOVFIyMHpjRkoxVURCeVNHa3pVMFJYTUdSUlFYbzRaMEkwUVdoTVEzaG1TRkpZY2tnME5ucFFiVGxYTHpoWVZERktkV3hwWW1SRU1YazNXVkZ6TDJsUFJFZFRVSEZLVjBKallqVkRSbkI0UVRCaGNYUmxlbTF5TW1aUFVqSTNZMHhRVkdOblpWUmhPSE4yWkhaWVYybHFTR3hLTjJoeFJHcGlLelpGWkZkbWVuTkVkbUZDTHpWaGFuWjVVVkpaYkM4NVMwUTBiMk1yTDBkdGJVZEZOV1k0Y0hwQ2FGaE9WRzR5UW10elRWTjRURmdyY21zd2FFMWxRWHBXY2tKRVRucGhhRmhUT1UxQk5XOXljMVF4Y2poSlpYbHNWMlZRWjBWT1YzZzRXV1JPV0hOTWJ6Wk1OR1IzZVVSc1IxcHNSVmt5VURoNmR6UllkalEwVDJWSFFtdFFTRFUwZDFKV05rZGtheXQ1VFVOMFkzbGFjRVJ2UjNjMU5XOHlkVWxJT0c1SE5XOUNWM2xJUkVrM1ZsRmpkMmRUSzA5T2VXSTJaSGhTZDBkWlJtMUVVRzUzVGpneE0zTlZkV3h1UkhSMWJWVnlPR2RrYXpreFJrWk5SbmhzT0VjNFZUUllVMEZFYVVsVFVrVmFlVkZ2Wm1saWJuYzRhelZLUlhSV05HNVZNVU5TVFVwcU5uZFRjVmhCYVU0d1JYbEdlRlV2VjBGM2EydHBUemh1YXpSVE5qZFRabEJMWW5VNVVYQnRORXd6YTNOV1NuVTNWbFJ1VFhobk16UlhUbUpNU0VSb05YSjJUMVJUWW1abFpVSk9PRU50WjJ4WGRHZDBZVW8wTldZeVJsaG9kRWt4WlZKTWQyRTNRMjVCVVc1RldFdzViazB4YjFOSVRWbFJlV1V2ZUZsRVNGTlFkRTFuVVROT056UXpiVlJRVWpsRlMydzRNMWhCYXpacmVqWjNTVUpvVFZnM2MyVlNORTltYVZGc2JpOVFXVFIwSzFSVFMwdFdTbnB0YmxKWWIwWXhUV0ZPSzNoc00xVnNNR0Z2VDBONVNrd3ZjRGt3ZVVsa2R6SlhMMWw0WVV0Tk5qVkJlblZET1cxelpHSXZiV2Q2VUVkTVNXVkVia1ZCUjJWSmRHdGliMDByYWtadFdDOVZXV2s1YlVkaVFVbFRRMWxZYW5aMU4zVk9Na3hYYW14WmNsRmxhVFE0YVV4Wlpta3pRbUoyZGpsb1MyTjZlVTFGYmt4VFpYZ3dUMjlqY2pVNVRETnlVR3RMY0dZNFptTktLMWMzWTFseVlVcE9SRzh5V0RRMWJDOVVha2RoZFhseWRERjZRWHBxYm1STWJVMWFhMHg1TWpkVWNWUnNWMjFoV2l0WmVrZHBLM0JHY1RGaVJHVmlXVU5LVGxCUVdpOWFjek4yT1dJMmVIRjZaSFpaTnpkQlVIZG1OekY0TVZSemFtTlZlVll4UzJsNlNqQm5NbVkyUkc0d1VYRTFiWFJaUXl0NFMySjJTVzlrZGxCTlRVTjFhMUJYY21aWGJYcERNVTQwYkZoR01UaEdOMDlWU3pCeGNuTnRZMFpvVm0xTVVHVXpkeXRoZURaU04wZDZVakI2VGpSWldWRjNSVW8wZEN0VGNHNUNWVWhhWldoU1NHY3hNMFJWVFRGTWMwaHdUR1IwWkhOV09HZzJSMkpWYWl0NU9GQXhVV3gyUnpsdlR6TmtabFZVVDBaeFFWTk5jemxSZEdGdFdtTkdZMnhwVUhWNFRsRTViRTVJV2xGelJHRTFTVGxMWmxWVlF6RTRNV0p3YVcxaE5sTnZTa3RQU3pCT2JuRnFVWFpRY3pGUVZtWkhMMDVVYmpWeVRIRlFkbEEzWlhZeFluaFFUVXRMZWtGRlJreERjelpyTVZCd1MxRlRiazlXYjJ4SGFrZHJUMlFyY3k5NlpHWXJNMlpoVTNKRWJVTXpSakZtT1dkVVNscEdRbFJKTlVZMVNIbE9WR1ZrYkROaGVucHpjbGx0VDNsVWFuYzVRMjF6VXpWUU9WQlhaWEF2UTFwaU1uQkRORkZZTnl0d1dIbDZWMEZxUkRaakszcE5lbVEwSzFvMGJ6RkdMMDE0UWs0eFZVcGFWRkpqYzAxa1VuWlJjVWhRYzBkeFR5dFRaM1JGTVZkVWFuVjJNMmR5WjBVMlNIaFhOMU42YUVSbVFXNTRZM2RIVFZVM1ExSkNMemx3UVhOb1JYQkZVek5QU21WelkzaERTWFoxTjFZelYyNXdUemg2Y0M4NFJIUlpaU3RUVFhsVldVVlhaVGxQTDFCTFVFcERkVVE0YUZaWGVHbHBjbVZRVDBoMVYxaHBhMEZ5VlZwWksxVk1ZbWhtYUV4MVJtUjJNRXQzUmxSb1J6Tk5kM1JSY3k5TlIyNUVhemh2VWxjMlNtdFlTRGhyYVVOR2RuRkhTMEZsVmxBNVQwczJUbWR6WjFoVU9HRkVURGt6Y1hBeWEwZHJhQzlIWkhKR1kzRlRVRzVIVkRsVFkweHVja3RNTVVnemRWQnBUV05hUVRNMlNUbHpVRFV6VVhCaFZGSjJhRVZOYkROeFpEUkNkRXgyUkV0eFUxRmFSSHBqWmtvdlNra3lVVEZPSzNwSGEybDNTa1JuTUVaTGNVaDFRbHB5THpFNFUzQjBTMjFYWjNKcVQweFVTbGhGUjNndldsZGpRbTB2ZUZOSFkyRk1LekF2Y0ZBNWJEZFdNRWQzUlRFdmNsbENkR1l4UmtVM2RGbExNVzAxWTFNM1pVMXZlVnA1YmtSWVZURjFTV3hzVUN0RGMyMVhNV3BhYldwaFJVbEZObGRvVmxjeGQwMHpTbFJqZDFOQ01tOXllams1YkdWRFptYzBjM052Y3pablJFMVpNVUU1U1ZoWFpEWkhiMFUyWkZZd1JFWnJPWEZEUld0UFJ6bEtZVGRXU0NzcmRqVjJVMjlTTjNjelNHSkthVGgxZWxSYVUzWlFNME5sWVhkVE4zVmtkeXRzY0hOd1VIZHNNbXhyVlhWSksydG9XRnBzUTIxWVdubFFlWEZLVERoNk0ycDBiSE42U0M5alF6TnhaRzAwYmtVd04zZ3ZPSE5YVTB0eGJUTkxTV0p6UXpObVIyUTRPVWs1UmtadGVrMTVRWE5VVkM5RlYweFJjR292WldWaU9HaEVSRzFXZW5KeGJ6UTNSbEIyZUdablZXdHpNblV4WlZab1IyaHJOR05rTkU1eWNrZHZTbXd3YUVac1FVZGxNbklyUjBobE1XdDJXa05HYWxRMlVVZEtaa3BUVTFWVlpGWk9iMVV4Uld4WmRERXhTbXROZGtscVRtSjNNRUZtZVRGWFpEVnBZVVZ5Umt0TVJXTkpVa1UwYkdoV2N6UkViV0pTZVdwRFRtbHFlbXg2VWl0R01ESk5lWFpVZWxkc2FITnZSRmxMTTJWbWVtUlNOamR3V2toWGJWWndlV3R2UjBNelZtNVhPRVpCYlZKcmQyVTFVVEphVTNKcVIyVmlka1ZqVmtsWk1IWllVRWxUUm5oWVNtYzVUbFIwVkdwbVZFTXhTVmhKZDI5a1pGTkRRM1phVEhKNWNuSmtZalF4WTB0VU5WTkxVamd6UzFVeE5FcFRiMUpEUkRWdE9GcE5URlEzT0dkUE5VVndLM3BTYlhSaWQwczRhbEI1U1dGSmNtbG1OMkZvVlVWcU9EUXlXU3RIUmxkT01tOXlVRU5SY3k5U09WSnBkVWh1Vm5aeU5rMXJTVUZpVms1WlNrTjZWRVYxWVRsVGQxRXZaa3BJTjBSMUx6QmtaMU12YVdaS1NWaE9MMjVSWnpWck1HTnJVbEJyUmxsQlJrcEVNV3gxZDA0elZrOUplbGwwV0VzeFUyOHlNMnhIY21wUGMwbE9aRlUyZVVkM05ERk5VRzFVZW00clFVOUhhVlJMVjNCR1lrMVRWbTlVVjNCSE1XNW5Semt6WWxoRlZXOVhXWGh2TlVWV1ZWWlVTRGczV1c5VFMxazRaalJDWVZrelRtbHBZa001V21kalkxb3JSRlpqT1hOdVluRmxTVUZYSzBkcVRrWnZXRTVJVWtVeVdrVTJNVlZoWjNobVdscFFNbkZaYnpWVmIwaHNiM1pwUkM5d2NGVXZZMWd2YkRkcWFXNVpiMUVyYXpSeGFXMWtkRmREYXpOcmNuUlFja1Y1Wmtod09ITXpMMUp2VjBOdlZXMUJMM0JVYzBVM1FrcFpWM1pYZFhGalkzUjNNbGRFTkRCcWNtOTRWbTR4YUVSTllqaDNNVUZSV21adGNGQllRemxXUzJGR2NFWjFVSGtyYlVoeFptdFFjemxzTm5wSVpGQjZOV295U0dneFQyNVRWbXBaZDJaeFRsSjVPRFpoU2pGNVVDczNTbFpVZDFZdk0yODRXRE5FUzFka1VtRkdOemxEUzBJMWFsTk1SV1ZuTmpsNGNtc3ZVMHBoVWxKWFFsaFNNMU15WWtkMGNEUXpaVkpqVVU1Q1NuVlRkSEJ0ZW5veWVUUmplVVZVUkRkVWRXbzFXV3hGV0V0bWFrRndOVEpOTlN0a04wRXlUREZsTDNaWGRpdDBRMXAxTnpOaFFteFdjWFZaZUdnekszSlNVak5RVDNKSVZtSkRMMUoyZGxKdFJIUjNjRUpZV1hNNFJISmlPVGgxZFV0elNEQjRhRUpyVEdWS1MycGxORkF6TVdsYU4yZEdlVGRCT0VzMFVuTnZVREVyZWtob01VWTFTR3hQUlZodVFtbExNVmx0Yms0elkxbEJkMUpwYUVKSmRtSjZNbGN4ZG5SVFEzRlNSV0kyV25vdlYzUjRURXRhU1V0blJrdEpWMGRDZVdGeWJFTkRSVmRCTkRRd01Xa3ZWRk5IUTNCT1FrOXlLMUprZVU4emNXTjFaR0pNVVV3MWNIRXhUMmRYYW1aSVNtUk1WMll6YWs5c1QzaFRSSEpuWlZKeFpHUlJTbXBVYUM4eU5tcERjRFpuYkZOV01VeDVVbk5uZFhoMGQyZEZjVGxrZW04dlRITk5NRlkxYjJSQ2FWYzFUVko1UVhGVllVSlJZWEZTTW5oYWFGRm1TRVlyZGxabVZISnlNR1U0VERGR1JGWnZlR1I1Y0RCclEyeHFSbnBvTWsxWU1uUnJhekJ0YVM5VVIwaG1VRnBDVXpWTFYwRk5aVmsxU1hCNkszVnRTVmNyYzFGYVRIaG5jRXhVSzBKS1VrdFlOVWhZVVVvNGFucGxSMlk0VHpWVVZXdGlkVmwwTlZkQmVUQTVkemxZZVcxelMyY3laUzlzYWs1WmFVZDVaRzlPZFRWeGRuUk1URGxIYkVWVmNDOHpjekoyYlRsVWRqVXlOamx1TVU4MWFYSlpiRnBqV1V4bmNuTldWUzh2Tm5OaFRVZDZha3BFUkhkeWVFZFZTRzFWWkhabmJqUXdNa1JSVG5BcmFqSmxiV3BIYlZad01Wa3hXSHAxVVhOaWNXNTFMMFI0VkU1TGVITnVVMFp6UTNReldIaG1kVUZEZW1OVVlqQTNjMmRQVFdaTlZHdENSbmRxUVhsR2EwOVBabVZCVVRJNWJYRmlXRmRKTmt4eFQyVm1jbVJzZHpseWJFcDJhMWRUV1VWMk9YUk9jVXR5YVN0aGRUQlRiRzlJV2pSelNGQnJXa0ozWVVadllreHlRV2RCY1ZSMVFuWjRiVzB6SzFCMlp6WXhUWEIwVW05UmFXOVFNV2xoVVhoQlpuRmhOME51YVVrdmRqVlZOekJKUlZsVWIyVXdOV2hKWkRGTFpHMWlOM2d3V1RWWVlYaDRlRmxzYnpobE5tVkpWazFTYURWclkyRmpUalJqTmtSSlZFRkJSMjkwUVhkT1VHVXhSMjl3U1doalp6WXhSbk4zYXpSb2IyRkVTV3B2VjFsMEwwYzFWV2hKZVdjeWJuQnViVVZ1TmxSVVRuRmxXSEJqTlZoQ2FUUlJaaXRKY0VoYVFUWmpNV3hzY3pRNVFWUk5hRmxhVjFSTGIydDBiR3M0U0hSSGFIaDJUVUppTTFoalVXMTZibmRaUVRodFlVRXhkMVZVTVVkbUsxZHdWekpsTUNzNFlsSXhZVzVDTm1Vdk9EZElia3BHTjBobU1WaHFjVTg1VjAxc1RYcEZWMHc0TVRaclJHSjVXVkZIUVVwYUwyaE9SbFppT0ZkcE9UZEVNbGxCZGxWbGRtMTZNRVJ0YUdsSGEweG1Welo1U2tabE1HOHpWMFJSUTNoWlQwbFhlWFZUV1dFd2NsbEVXbWhsVGtKeVQxZHBWVE14U0ZkQlpXRjJkbEV5VEdOUmRtSk5iVFoyTkcxUGRYYzNPVGRDU0hoa0wzbFlZWFJrYVdKMGJIY3JiRFJVT1dNdlJUZDVTbVZPUlVObE9HaGxXRmwyYmtZeFRUWnhPVEJXVVdaeFJ5OW5QVDBpTENKdFlXTWlPaUl6WXpjNE4yRmlabU01T1dWbU1EazFNREpsTlRjeE1HTTNObUl4WVdJeFpqQmhOVFV5TVRGak1EYzJZakl4WWpZMk1UazVZMlUzTmpjNU56WmtNVGszSWl3aWRHRm5Jam9pSW4wPQ==', 1754890959),
('e3L1G2Ro7Na8LFaEM93BLsQMcXgNenUbeTDJn9zr', NULL, '181.115.60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJaXRtUlhFMmVVWjJURU5YVjBVM2RUZE1ja2hNTW1jOVBTSXNJblpoYkhWbElqb2lNRE13Y1RsTFRYUkdSbEJCT0ROd1dsbDROWFJ1TkhwSmEwTXlhR1ptWmsxeGQyNHhTamRaTW1sSFFUYzBNRlk0Vlc5c1ltbFZNMU50TW10bUx6TXlNWEJNYm1keGRGTkdWVFY2U2pkcVppc3hZemhQVG5sTlFtNVpRbEpMT1dKR09XSlZURmRuU0dwMlFqVndOV1V6VnpJMk5HdDRXQzlVWWtaaFlVeGhla05UYjFGeVFVNVRWRGhtUVZGaU5YaEpiWHB5UTBaNVEzUjZNemR6VTBwcGVXSkJXRkpCVGxOc09FVlhVV1JRWVdGd1VERlJUMU5hVkVKUlptNTRkMUUxZEc1T1dGZzFWbWRHZWpFMk1IUmFSV3hZTTFoeFN6VkdNVkV3VG5KNWQzRnBialV5VkhGcE1WVlZjMnN6ZWtoTU9WbEtjRUZZUjFwWWJuVjVaMDlJYkdzMWQzTnRTRVkyVERWRWVEWjRURlUzYUdkSlNVRlRRVlY0Y1U4M0wzRlpTa3RSVkZOb1dsTnRhM2d4ZG5selRGcFhWRTl5ZEhGc1NsWlBjRTB4UmtWUmVIRm1URWR2UldWNmNESjVRakpDVFhWVU5rMTRRblUzVGtGdlZUTldhWFJQTnpGS1drcHRiMWhPVW1reGFHTndWbFJTZGtFeldWRXhiemswYUdGV1dHVmtNM0pDUzBkYVdUTmpNR2RMVGxkV1lWbHdZV2RYVERGT1pVNTBVekpyYUdSVWJYaHhhR1pDSzNKWlIwRjNNVVpFZFhwTVZEZzBLek5vY21KMGJ5OHpObFV4YlhCeFdXOHhORWxDWTI5cWFsZElWMlF2ZDJWaGFGaDVPWFExUzNWS1FrVmtXV05UWWsxck9ISllhRWRuY0ZrM2VuQnhSM1ZKT1dGUVRVUTNObWxuV2toRE5HMVdSVmRwZVVrck0yMHpWbEZaV0dack5uaGFNakZ2VFc5aVdWVTJSV3d3TDFNMFZVSmFZbkJHU2s5MFkzQlZVemt3WkZSeWRFWXlLM1ZrTlcxSllqRmhSVWQ0WkZjM1FUQnJURlZXYkhKSVNUZEZibWRxTTBSdFZ6ZE9lVGN2TjFkR1YwcG5hRzVMV1hSblZVSXdRMjF0Y1cxa2RHeG1ZUzh6YVdod1dXSkRTbEJ2YWpCTmIwVXJXWEZFYmpsWVJWa3JVbE5xTVZodFQzVTBTRUZKV21wMWREVXpTRGxoTjNCSGIycDNPVmg1YlZOcFowOUdkV0p3UVRSSE1tRlhZa3RuWm1VNGFWbFBibFpZZEdka2FFOXZWa1Y1ZEdoWFVHaGlVRXBEWXk5b1ZqaGxXR3RxY3lzMGVrbE1VVzlzWVZwUmJVZGliSGQ1YjFSalZrMVhiRXhIZGtsU2JGVTFWR05RY3pZck9FSTNOR0ZLVTFvMVJXOTVXV1Z0WW5KRllWVm1iVVo0ZEdWM1QxQjFiRVJEVWxZM1dHSlRiVFl2VGl0NlJrMVBPRFZ5U3pkTFUyaDBSUzl0YzBSRlkyUnNWa3hEZDFCM1lWRlhZMkpzZW5wU1UwZEZTWEZNY1RGVFdHRm1TVEZIU1hKV2RrODJVVEJUTXpWcFZVVmxjRFZTZUVWM01IQjVja1J6WlcxVFNXNDVMM1psTjJSU2QycGxVblpyWkRCREwyTm5lRE0zTDI5aGRHMWhaVXRtYUdzNVMxcEdXbE4xSzJGTVltOHZSRUpCZEhaMU1VWXhWMnRxV1hJMVl6aHdURzV1UlVoeFJVOUJXR013VkUxWlltWmlUMFpIYUROWVZIZGhNVFJ6ZWpJeGNtZzJSekZGVVhGbWEzaEpRVk50ZFcxd1kwRmtaM2RGUm1KMFVtd3hZbWRDTHpGMU5qTnFlVE54VWpVclVHMURZVmcyYzFwUVNYcElNV3hsVjA1bFFrazVTSGt3WTJoamFqRm5NV2hsU1c5SmQyYzRPRTVtT0RCNFJqUTFOa2cwYjJNMldraGlia0l3UkhkdlZYVnNUblpGVjI5M1dTc3pWblpsVW1aRlpGRjFMM1owYm5OUEx6RlhiRVJLZUdKVGVIa3JRbU15WkZCVmFpdFVUblpqZDBFclpFVkNSMUptSzBoT1VYTnNTMVZCZW5sc2JXdERXblpuUzFnNE0wZ3hXU3N2YjBGa1dsQTNiblZTYzBwcGVYRkJSbUpEY1hSWU1qVkJabFZqVVVNMllWaDVXbHBNVUdkck1GVnRVRXRZV0V0eGJHeG5SRTEyUnpSTU0zTkxUeXRJYTBSa1RUVlNTa2REWlRCeU1GbDJWVGxDU1U5WFYwRTBRbU41YkdRMmRrRjNkRzlxYkhsTGJYVkxOekZoWVUxRGJqTlRLMDlOZHpaVmRHNDRTV2RQZFZSeFNHUnBNalZzZFhReVNXeHlUVVZaTTBzeVRGSXhiRWRGVGxkTUszZG9RWGhyVjNGNk4wdGplRTl5WjNwWVRqWnVOMHBoZVhOUGNqbFZTVEJ6Y0hoSVdGZ3lVa2hEVGtSeVowdEZla2RNYVhkQ1QzRkZWWEJNYjFOUlZWUktRa1pUU2k5VmNEUXpUWEJVUkcxcWJHMDNaSGxHZEhkbE1FdGpRV0pPVEVwWlVITlZMMXA0YTBoQmRFNXhiRUVyZEVwWWVtMVJOMkpKU1hWeFJWWllXbWhOTm5OeU0ydFdSa2RXYW1WSE0yWkVVVzVEUTBVMmJteGljVXRKVVdNdmN6ZG5SVVUyVVVSV04xYzRjM1JvUlhRMlFsaEpTelZVWlZGM04zcGxNbEl3ZW0xSFNrWmlNSFZoZGpFclNIZzNlR2N3WW5sdlptSnRSMkZJWmsxQ2QxZHJSa0ZsUkhOUFIwUjNWRFJGZEZOQllYaFphWFZ6WldSQloyVllWMVZVVVcxQlpsQmlhbmx0ZFZGUFRIZGtPRXhJYkRCVlVFY3dZVzh6ZVdsNlZYcGpZazFxWld0WmMwVkNNRUZtZVVoWmQwNDRVM2hFZVU5WlEwaFplVzlRUm1NMFNUUkxiWEJVWm5aSWNYVmhTRWRsUzA1WmMwSkNNMms1TjJaTFJWbGthMmQyUjA5R1pqQlhUemx5VDFWTGRDdG9MMkpFTVdORGFEWjJRa1JLZFRCVGJXaExkWEphZFVwbGQwbElOekI2WldsNFpGZHRVMFZWYUd4WWNsbDFWMDU0T1VSalEyVjBibXBaTm14MWJYYzJUR0V3ZFRVNWVuRndObGhNUTFsT0sxUk5aMmxWTkZFdlpYbzNlRUY0T1VKMmNqZGlWVFpCU0dabmJXUllSWE5PV1dRNFptaEtWRGhhY1hORWJXTnZXSEpuU1Rnck9FbERUazFTVXpKdVFtbGFaMmRCVkhNd0wwazVjbFpYTTNBMk9EWjVZbGg0UzNSeUx5dHJhV0ppVFVSR1dGWm5hbFJ0WmtNclUxSmFjRWh4VmtWamFVRTBXa2hQUTBwd1NucHhabG94UVRWTGRIaGxZWGh0Wm10SFZuY3labGMxVGl0V1VqWkJTbXhNU3pkNmJpOTRaR2RTZEVKVFRFcFRhRmMwVUdsTk5rUTRhemN5V0Rodk1XOVhVWFpuWmpBMVdrNXljVWhRUmtoVlREaFNUMFZpU0VGeGNqZGpNMHhKYVVRdk0wOVdhRU5YYVVZck5HRTRiSGs0UzA5SWNtdFdkemR6TVRBck5FcHhkM3BHVlVJclRUZEJPVlpXWVVndlNIb3ZVeTlhTTJoUlpFUXhTSHBYT1ZsaVZqbFFOMkY2UjNZNGVXSlBNbkoyWjI0eFFqRmFUbVJMTlRWUmQwNDFNMWwzYzJGNVJsVmtibGxZYmpKVWVUQlFRMjFOZGxKQ1lrMTVTRlZ3U1hoSmRGZDZUMjR3U2tGNk0yaFZhamROY2xneVIyTm1NbmRyYmxreGVDOXJjazlGS3pOaE5VY3liMmc1ZEhCNVJXOWxWRmxVVHpGMVlrRllaVXhDTUM5UVNUSjVZVXgyU1hCM1kyWmpPSE5oTDNGbFozVlRibU5JVWxaTFRUVXpNbW95U2xRclN6RmFXbmM0THk5ak5GaHRkazF2Y1ZCQlF6TTRSRzFEWnpSMmJtOXJPV3RZWmtGT0szbEVkMFF4YzFwbFpWUnFOamN3ZWtGT1JHaHhaVFpPVjFONGNsbGxlV2cxVjJaWFdFSjRhRWxDTlVKUVIzUnpLM1V3WlRCQ1NFc3JVR2RtZW1KNGJWb3ZiRmd5UVc5VVJtRlhhV05ZVVZCTk1EaG1aVFpCUkVNeldrRkljelZEVEcxVVkyMTJLMGQ1TldvM01HVlNWekptV0UxWlMwaDFTVVUzT1hScWRtcGlWRFZUSzNkcFpuSnZORU5SZGs1bFFVMVZhVmRSY1dwSVl6VjJWM3BqZEVsbWFqVlpZbUo0TjJZMlIwNVhUVUY0ZGtORVVsQkhjVFY0WWpCelYwOHZVMFJ3V0cxcFNISk1RVU0yU25oSlYxbEhTMVUyZVhCMVRtTkZaa2s1VDNJeE5rNHhTMHB5VlRreGFVbFdSbkZvVlhkNmEyMWpjSEZuY1hOMFJFVllVVzFDUjI5SWNtTTRTWGhrZG05R1YwcHNhWE5wYWpOb09YRlRjMUYzVkhnNFpTODRXbWhoWkdGSWNFbERWV1ZXYjJaTlRuZHJZMHhZYjFReE5raHJNREEzY1hVNGFFVnBTRXdyYW5GQ1ppOU5hRXhJVUZBd2NqTkJZblEwZUVWUFZFVkNPR05JU0hWbFMwZHhWMHBwVTNwWVJscEdTRk5RTVV0a2VuTjBXbVkwWWt4RGRGaEpNekV3WjFaSmVETXhNbkZtWW1Zd016SkRkekppVEVod1NXUXJPV1UyWkd0eWVGVklkRVV2WjA1bk1tMDJSblZOWVdsblNXSjBRV2RDUlUxaWRXUlNUM051TWtRMFZUZHpZbFZHZW0xM1RsbHJjbTEzYms5U01qRnlWSGhtWTNRMk1GSTVjM05tUzBzMU5uUnBhRVJrZGpWYVpuTlpObE00TDJrM01reGFPRmhNY0RCTWF5OUpPV3hHVEdZM01FSm1kMjFCZGtkU2VtSk1VV2hsUm05NWNsUjVhM0JyUzJGRWVrMVpRVloxZDI1aE1VdE9abVkzT0dGRU9GWnJPVVZ5UXk5QlNXaHNkMjVCTUU1TWJqRlZRVmRyUzJaRk1sWjNTVU14TTNSQ1pqRmtNbUZUSzB0eFNrNDJhMUpQYUd0aFRVSlhRMmx4U25sSmJHTjRVbmRUTjAxQ1pFZGhTVGhIT0RaeWJtOVhVSGxqVDBKb016VTRWR28zVEVsMU4yTkRRemh2T1RGQ1dUTlRZbkpuY0RWNVpsWlhSR1EzZWxCRGJYaEVUMjVoVUhGYVJ5OU9USFU0TWtKME1sTlZOaXRsUkdkcWEya3lNekpoV1Vaa1F5OVBUVWhyTkdOSU4yMW5iR2xuYWprM1VuVTVUM1ZDTXpWQ1FYaFRlRkY1Ym14SE5XVmhaSGxWVm5aYVNUTjBNRWd2VVRVdk16aEpOV2RsY25ZdmFtZ3hiMnh1ZEdaUGNpOUJhbFZ3ZVhBeFNVSTFNV3RwV1ZwT01WZHZOMEpWUWpReWEwZERSVEZ0U2tJelUwSjZVSEZFYUcxRFZ6bHVjVTEyYWpRMVZtRjZjRzh6TjFkVmVXUlZORTVMUjBFNU5TOUxiMjAyVlM5V1pYZFpWWE5JZVhoTFNXcFJTV051VEVKSU5FUldRazVvWjBWelVHNHliMWMxZGtKQ1dXaEpha2hqYWpGSWNWbDVNSHBZUldOdVZtRXhka1JsUjJwU04zRnVNbEZFU2xac04waDBMMHhwY0Vaekt5dFRla0kxU21adU1XaExlV2hCU0ROMWIyNTFWSEpHZW5CRU5VWmFkRlpTVkZWRFJDOVhVMDV2TTJOWVFXWXpVVnB1UkRsSU1HRmphRGx5ZVRBeGEwRldibGd6S3pkT1oyUkdUR3BZWVdNdlJHOXJRVVV2UlVkSVlXa3JNbmx0T1U4elJEQnBTazkwWVd0NFRtdFBUR3RXY1hGMWEyWkdaM3BRTkV0d05sVmpORmhNTTFWbGNHVjJSVGxEVVVkVGNHVXhZemR5YURBNWQyRmFNbWcwUzBOSk1UZFNkV0U0WmtVNWFqY3dPRk5EVGpaSFYzVmhTMGczVVZOdWVYQm5jQ3RzWjAxRmRHVXlSbXh5YldOcVV6aHpXV0kzYlhGVk5IWkdZa1JVV0RVdk0wbE9MMGgwYkZKeFlqUmthVEJRUzNCNWJXeHFZa1Z2VFZKT2QxUlNXRTUzU0dSRFdqSmlaelI0Y0RCRlNFdFJiMHR6WW1OTVN6YzFUVFEzVTNkTU5Fd3JjR3hIVnpka05FaE9LemhQVXpWMk5VMHZaRGcxWjNWVU1rMXBha1ZIUnk4d1ZrTjFNVnB3VVhCRVdFTlJaREp1V0U5dlVEZE1WRXRpYkhwRFduWlVhRU5ST0ZkRmEwMVdWRWx2YmxGcVpXZE1aVTVOYnpsV2NraFRNV05ITjI5bmRFMTBkM0p1WW5KbVJEWkxhR05RVlRGQmVrMU1PVGw1UjJsV1dqZHpiRGRCTjJOd2FreG9Za0pYZVhGT2RXOVNhSE5sUVVweWQycDFiM2hJVkd4aE56VmFaaTgwY3pkaVRrdEpOaXRRYWlzM2MxbEtOSGQwT0cxT1RqUnljbFJEVWtSUFJuVnVRa1puUVVkWEsyZ3pTMmxDZVZob1JrdHZSMVpWTDBRNFRqRnVVbkpLVlVwUFNsVlNLM0JSVFM5dWVGcGlZVlYxY2t4bVZrODBVM05rZFRaaWFXWkROVXBzV0ROQmVsTjVNMGc1Vm01VWR6VmtXRVJaVFdGMlJtTkliQzlNV0hjeFIxbzBTSFpSVGxSMU9WVk9LMk5DUVRWM1ZUbGhkVkpaZDBGQ1JVVlpabmhpSzJSMVlYRTNTWE1yV2t4S1dUTnhkakZ0Unk5VWVFNHZVVVpRVjJSWmRrSlFUVXhTZFRCMWJFOUpaVlZFVW5CcU4xZFpiWFEzYkhwdVpuaFhMMGc1UTBOVk1FNHhaMGhvWWl0U1RXdEtVbWhvYVVKVVIwOTVhMUY2ZFRsR1dVNU1RblZZYVV0aVNHeEViRWhTTTA0MWNHNUtkRWRUY0VwME5tSjVTa1Y2TnlzNVppdGhVMVJKUkdRMFEwUkdkbWxRWTA1MFdWRk9XR3hZVUVsNVJXZHJVSEpKU0dvMGNVWlpXVXRTU25Fck5YUjRTMnR3YWtjMll6Wk1VbWxNWTA5ek5sWk1XV1UxVjI0dksxWndjbWRUYUVkMGIxbFhhRk4wVFZaRWREWnBTRlZFZW14eWFtdExTMVJWVVRkUFdFeGljR28yYTJRMGFXbDVjR3MwUTI5TWFXcE9VMDFUTVhVclVuRjBNMGxtYVUxUWVVTXlWV1JyYkZvMWRqUmlTa3hKZUZkM2J6RTNWSG80SzI1VlkybHNiM3B0YUdKTmFGTnFNR0ZXV2pRd2IyNXJOMDV0YmpsaFkxWXhUM2c0VFVZM2NGTTFhVUZFYjBSR2JXWlNhMnN6VFdOV09FeFFOV2RGZUVsWGNXUkplRWh6ZWpOVFREaEpNRGRKT0d0UFpHbFBhaXRaVVhKRk5tdHFhV05KVFd4MlRtdDNNbmsyTmsxNVQzaE1WRGxrVDBwWFpEQnRhbFpMYnpSWVluVXdNVmhrV0VSeE9FNUhaQzlMWkhkSlV6WTNlWElyZVdrclNqRlBOMEkySzFveVRrMU5RVzAzWlVzdk0yYzBkaloxTmtKeFltOTJVMVpTVm10U1lpdGFSRUZpZVRWT1NucDFlVEpGYzJadk9FZzVTMU52ZG5WS2FpODFORGRaWVZOVU5IQkJObkEwVjFFdllXNXpOVEZRTURRME1qUXlhVEpPU1ZOck1GTnVSMWhNTWxkQ1VVUk5LM0JRVlRaRVJWRnJhRFZyZFN0cFkxVm5kMjlVT0c4MmIyTnhiQ3RpWTNGeUwybHhkRnA0Ym5Gc0wyOUJSMXB2V2psV0t5OXBkMGswVEhoNE1VUkxSME5sYkZsYVJDdFVXVE5wTTBOQlZHWm1VazV1YkZsbVoyUmtWRkJpUkRKeWJtRTBaek53UjJ4V2VFZ3ZMMGxFUml0UWJrd3dPRGhEUjNwRk1WUnVWV2RrYVRZellrMXNXbU5HV0VaNWJFOU5lbHBJTjBwRmVIRmlWR0ZtUlZRd1VEWlRZbmN5TkZwcU1VTXJaMWxPTm5Oc1NqZG5MMWh0WkVkb1lVOVZRMVJtV0V4c1pUWTJTME5LT0VrdmR6bERLMGxFVmtwQ2VXSjZRVkJHVlVZMWN6aHdWV1ZRUkVoc1ZWWmFWbWwzVVdOMFZIYzBPSFZYYjB0SU1qQlhVbEYxY1VSeGVtSmthR1pRUzI4emNHcGhURFpMYWtKUEswUlBTVkF3TW1waE9Ya3dlVTlKVW5BNWRubEtkbmRyYmxoamVubFhLM2RuVlRSSmNITkNSMjl2Y1VkblUxTnBTbFJaVmpSeVNrUm1SR3gwZFZkMmNuRnVhR3MwVW1aNVpHMW5USEJ6WTJKaFJEQjNNa2RJYkd4amRWQmpUalZ4TVZobFVIZFRXa2xOTldwMlpHSnJWell6V1dwc01WbFFkM1ZxZUhkNVowTlpaVkJNUWtWVmVYVkpPRlJqWVdGRWNDc3JOM0Z4VlRWUVZpdGhabUYxU1hkU01rVlFkMEZMZFU1VGRuTnRLMkZ1WXpSTWVGWjRVRzV3VkVSalVIa3pZVmRQZEcxMllYbHJVemcxVEM5V1MyOHJUMlpRUlRCU09EazJWRUZNVlZoTldWRjVjazVKTW5jclpuTmhOblY1Vld0eFoyeE9hWEp0ZFhoYU1IbzRWMDh5VEZaYVJIQnNSMEZ3TmlzeVZXVmlkR0ptVm05V1ZIWkdkVmxCV1ZodU9YVTFRazAwWlhCWVpqQnJkbmxxYkRCeE1GWkxhMUpPVFZGbVJXeGhZMmxzTlRSMFkydzFVWE5TUTFoUGVtNVZOR0ZJWTNZMWRuSnFlWEYxU1d0QlZ6ZEhRMWcwWkZvMmQyRXZhMDAzYm5KR1ZFUkpUekFyWlVGeVoxRkpORkV3UXpSeU0zbHhRMVpGWkdkeFEzSTRiWHBpUWpOV09VRkdaRUpvVUdWcGFFaDFUR3hZUkdoR2EybEVTemRYVVZKbk5YWTJUekZrV0VoeFdGbG5kbTlPYWxGc1FWZ3JVRWxoU0hkaGIxVjFNWFJHT0U1ek5VMUNTVloxVlhGMWRIUjNhVXg2TTAwMVJscFRjR2hMYWxKaWNqWkpjVWQ1YkRkS05HTmpWM1pEWVdoV1dYa3hhemhuZEZOWWFIZFdXbkZ3TWtFMGJsVlhRbmhPYkRGUVlqRjBhVXAwTTBoTVVFTjZTVTkwUkhCdU9FbG5aMmhJV1d4MWRsRnFVbXgxUlU5MGNtSTFkVGRYYmxKU1kxZE9ZbWxYSzJkcU9FWXhkVlIwTDBSSmJHOTRSbWx4YTJGTVpURnhORzFzT1c5TGNIbEljbXh6U0dWelZta3lNbUZsUW0xSGIxRnJaR0Y0Ums1WVNVMU9XVFoyTVhwbEwwdDFNa2gyUVhSRVNEQkNTR2QxUzNWQmRHeGtRM1JXWkRGaU5IaFVVMWh1WjBwRVdFOVRhRFpETUM5WGRpc3hORnBUWW1GNlF6a3pPV3hrYzA0Mk0wbDVkMmx0VHl0Q01IRnBWemxpUWtGUlNqaE5kMmxEWWpGelNHcE9Remh6Uml0NGFVRnRVRTlNUzFoblpsaG9kRFZxTWpaT2N6bG1NRkJuUW5JdllqaGhVMU5pYjFod1NTdHlRVXB1V1dRM1owMTFjbFZKUlRKb2MwcHdkSE54UWs1d2RrOHJNMlZ5Y1c4NVNVODRPVXRPTDJkUmRFbDRNVEF2VGpBekwxUmtjMnhPWjIxaVRIQTJUR1F4U2xsMGEwSnhXV3RRZVN0TE1uZGpUelZFTWpGTk1YVjRSMDlYYjFwNmVFOUhSV3AzWmtWU05GWTJRbmRrYXpSTVMwcFBVRkIwVDBWaFZVa3JZbEpzVGxoc1RrNDJPVXh1YVM5RlMxSnJVRTQyYUZNMldXcHVTVXhUTkRSU1oyVkNaMXAyVkZGMVlVUnlVRmxtTWxwTlpXWjRWV05hYTFkSE1DOUNWa3hVUlU4d09UWlFibTlyVEhCSlVraEJlV1JIVFdaUVRrZEVhbUZISzFsdE4yaDNPRXBwTDNaNFR6Um1TVGhXYVdReVdsVjNObmxDVXpsYVpYaG5hVVZPWVhCU2QzZFRXbUZaVmpRdk9WSmpSVVVyUTB3NFIxZEtlV0V5VUhCTWRVUTRNRXRNYUdwNWIxaFBTamwxUmxRMlQwSlJVVmhKVFhabmRXaGFNMUl3YjNWNlVrbHBhazE1Vm5sblpIUXhha3hXWm1wM1VFTjVVMDF4Ulc1SGNXSkNUbWt6UmxsMFNIWm1Xa1pQUTNGMVIySnFZMlJEU0U0M1dYb3JNVGxpTmtFMmRISndZbUpGTDBOYWR6aHZTV2tyYjJ3NVNIbFNiV0ZrY1ZZMFJXbHhlWGR4TVdaU1JXbE9URVEyU21sbGVVWnZNWGRhV1ZKQ01YUTVTSFJCTUd4NlRHTm1Za3BHU1c0MU9IUTRXbmd4WlRscFFsTkVlbkk1VTJaTVExRkliMEkwUTNWU1VtMXBOMkZIVUVSNk5tcGtlSGc0TTA5Qk9DOVFlVkZUTURkWFYzVkVVbXhpZDBsVmQwczVNMFYxTkZkWlQzWkNXWGcyVDBOYVVsTmlOV1JJUWtoSVJHdFdSbmgwYWxNaUxDSnRZV01pT2lJMU1tSmhOalJoWW1ReU1tRmlNbUV5TkdZMU16RXdZV0UzTVRreU16Tm1NV1UyTnpnd056RXhNVEZrTldRMU9XWTFNR1ZtWTJVNFpHVTJZV1ZpWXpWbUlpd2lkR0ZuSWpvaUluMD0=', 1754891065),
('eS1CWAX18v4Ud0kqGGRGAiKAM8l3nrOBGdGhs025', NULL, '138.94.121.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbkozUlRSdVUwSklSbmc0ZGxwaVVUUTVRaXRCUVVFOVBTSXNJblpoYkhWbElqb2llSGxVYWtSamRXMUdXVFpIT1hwR2VITnRPWGw1TlZWVlVUWlJhRGQ2VVRGTGVUUkJSQ3RIVldwT2EwSlVkRW8xVWpVeE5WVklLM2RFT0dwRlNXcFVkMmd3UXpZd1EzcHNWblZTU21KNGRrUXdiM0p1TmxoM1dWWlRaSG80ZEdaM1pFWlJOV1YzSzFoelIwVlljRVpuUmt4cFZsVXdjMGRwU0RWMmFFZG5WV1l3Y0dwRVRtbHZkM2xqU2poa05tNVRTbmRsVm10NGVGazJOVXh0U205SVRYRm9RbTF0UVRZdlZFeHJiM2wwZFhaUUwyMTZSbFJsU1N0dWNsaENWMk1yV0RoRlJVaEdUblJQUVhFdmVIUXdNRE5MWTI1cFdHaENObmxMTUhoaWFGRlBPRXAyZWtSNlJIcHlRbFpFVDBVd1lUZE9kVk53WlZKVGVrUjNZVFZPVDJzMU5YaE1iRWgwYTJzM1IzZEVhVFUzTVdWdk5rRTlQU0lzSW0xaFl5STZJbVppTjJFek4yWm1PV0ZrWWpRMlpqRmxaalprTm1Sa01tSmxNR0ZqT1dVMk5URmhOREV6WWpaaVl6ZGtZV1ZqWXpobU1HUTBNalk1WlRFMU1qSTNNak1pTENKMFlXY2lPaUlpZlE9PQ==', 1754882898),
('F4itobfPrVpN84IDPLiuk3dAzQL1owr0neeQzIPi', NULL, '45.182.22.38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'ZXlKcGRpSTZJbGx5YWpKQ1IxTTNSbkl3V1RCRk1UaE9ZMUEyWW1jOVBTSXNJblpoYkhWbElqb2llRU00ZUZKTGMyTjZOa1pKUVRWTFpsSTFURkZzYVhNMmFHTkhRa281SzFSd1VsVTRTMWR1TlVrM1VHWm9aVFkwUld4clVtbElTakJDWTBoR1YzaFRORkoxUVZSTVVFeExUemxtUVd4dlVtMXRNRVZhSzNsWE5qUjJWa2QwUldwUk9IVnZUa05rUWxVclVuaE9NM3BZV0V3d1NVWXZUM3BTVTBsV1VVSkxLemRwZDFsalp6UnNNRXBaVFVONVRHSTJiRmh5WkZsRVVrRmpkV0pzZEd4SFZETXhhbTlZWlc5MFpETjVaRTVvYW5Gc1psQkxaVTh4TW1vNFIyOHdjM2xtWTJ0T01USTJVM1p2YXpSTFYxQkxUMXBVUnpjd1VIWnJVMjlhYzFkeGRrRk1jbmxCVm1kT1ZIaG1MMlZpWVU0MFZraHhjR3AzWlhoRGQyVmhaalE1YUVFMGVUTktlVXBIYkcwM2JsUmlVVXBtUlZKSFVrRTlQU0lzSW0xaFl5STZJbUl6WXpZeE5qUTNOVFZrT0RZMU9XSmxZV0ZoTWpVeVpHSXdOelE0TkRZNE9EVTNZakkwT0RZNU5qRXhZMk0yWmprek56TmpPREZrTUdFd016ZzBZVE1pTENKMFlXY2lPaUlpZlE9PQ==', 1754865440),
('FmvSqbf41B7IUH6EXbuu0It6Eora5ZzaeCWeWQpe', NULL, '170.244.240.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbGRZYlVJM00zSkVTVXg2ZW1sclp5dFlLMlZMUTFFOVBTSXNJblpoYkhWbElqb2lNVE5yU0RFNFlrWktlSE5tVkdSMVlVVnVjWFJRYTFZdmRtbGFkbVowUW5sa2NqYzRVVGR6VkhKVlRWUmhSREJrUlVnMlFXazVjVWhqVW5sS2NWQktPSGwwUkM5amR6SjNaamhUZDJGd2NrWlVjMHhGYVVSQ1VrdGlOMWcyZGtsWloyWnhUaXRFTUVGUVVFTnBXVnBzUTJWQmFXZFRUalpQUkhOMVowOXZMM1ZHVjI5U0wwZHFNRzV3VERFeFZUWTFaR3gzUnpCMVRtZHdaRWxJWkhKTWNITmpZVVJUY3poVlRFOURPSGRZYmpsbFltVjZObXBGVjBGcVZuZHZRMjV1SzA5U1JGRlFWbGxrVWxoVmVVOWplVFF5YkdZeFJGVTVSSGxzYW10UmVVSlJVRzV5U21OdlZGUkhNVlZUVEZSM1JURlNOazFMY1UxcWJreFBTWEJ4UVdKdGFHbExla0k0VkdOc2VGRklTMk5zTVhKd1NYYzlQU0lzSW0xaFl5STZJak5rTlRjek0ySTFaRE13WXpSaVlqZGxNR0kyTkdFMk5qRTFOak5pTldZeE1UQXdNV1l3T1RJNFlqRTFOVFpqT1Rsa1pUZGhaRFkxTXpVNE0yTXpZMk1pTENKMFlXY2lPaUlpZlE9PQ==', 1754864349),
('GEBHqbYwF7tDLu7g561xHLXnoeL6ugZetRVAi0Af', NULL, '170.244.240.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbmhwZFhrd09YRTBjVEJaY0ZSYVMyUllSMW8yY25jOVBTSXNJblpoYkhWbElqb2lNbTFDZUZORWVrZHVNRTVWZG5kRk1FSnFlR055UjNwUFJHeFFOR0U0Y0ZwV2J6TXhkM05FVjBWdFFsZzVLMjV6UjBGa0szcFdjbGxRWm01TGFXTTNXa2RKUW5GTmEyb3djR3hJTDBaRU5GRnlWRGhFYWtaT2VsaGpjVUZ3V21wdldXRnJReXQyWkVGeVRYSndObkJvWnl0dFIxVTBOWGRMT0RCM1JWVkViM05IZDJoV05rUjJRVlpJWVhWM1NVeFBlRWxWVVRSS1ptMTNiVFYzVEdOM1EyRXpSMWRPYjNoQmFIaFRPVzlvUlRCNU1GWlFZMDByWWpaa2JERXJla1pxZVdaWWJVMU5lbXhhZEV4VlZYQXJlRXhqZDJjNE9UUjFNa3A0VjNBNVZ6RTRWRkpwYW5GSmNWbzRlVEZYUjNjMVdrY3hUMlJ4YVZkUFdVVllUVWd6VWtKV1pXSTRaVzFoTm5waVdqZGFOVzg0SzBscVNuYzlQU0lzSW0xaFl5STZJamMzTldJNFptWTBPV05oTVRCa1ptTTVPVGcyTUdFM01XSmxPV1l4WVdNd01qZ3pORFU0Tm1FMU1UYzNPV0ZrWXpVMVl6VmtNekE0T0RWbFkyRmpOR1lpTENKMFlXY2lPaUlpZlE9PQ==', 1754863804);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IircKXaUGposUCOXrSbnKX3rrdrwASnaFNHWwRzl', NULL, '138.94.121.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJazgxVFc1aVNUSnVTMVFyVEhabmFXWk9lR05FUTJjOVBTSXNJblpoYkhWbElqb2lhbTVyZUN0aVNVNVpjbWRCWkRFeGNHd3hiVlF3VkVVeGFubHpSbko0WjJZMFZISkZLMlUxTTB4blExSkhUQ3RpTmxoV1NEbElhelZtUkhack9GZ3ZRa2w1Y0hZMFZXbzNPVlI2TmtSaVpuSlZWa280VEZwRlUzSXhNamxpT1ZWMmVFNVVkVGgzZFZoRVRHOVdlazlJVkN0VVVXbGpOall4WTNGTE5GaGxWVkEwVUhZNWNITlVOazFFUkd0SldVdFRjMFY0TVZNM2NqWjVaWE4zWkhCVWNVVkRaemgzZDNoVE5IbDFNRlpIT1hSVE5scDZXakFyUjA5UksyaDFjVXRaTUc5VlVrZEtTMGRRWms0Mk0wZFZVM2xZU0VaT2RsTmtTME5UYkRFM2FHdFVXR1ZYWkdWNVpUSmhjVVl4WVM5TVlUbE9lalZQVVVjdlR6bHBVQ3RsWW1ZNWRVZFNZa1pFUjBWYVRITlpNSEpxTUU5dE1GSXJXRVk1Wm05bGVqSlBSWEJoWldkaVRFZHdSRWxOZFZBclNrZ3JiM3BVWVdsNmRsUTVVRTV2TjBwaVRIQXZlbXNyU21WbVNHSkdhakJNZDB4SlRYUnlZVVpKYW1aVVNsQjZkbmhMU0V4cU4waEZMemwwU1hGa00wVlROa1ZXYlZsV1ZWTXhjbVZVUVVZMmNqRjZNMG9yV0doTldqWmxkV3h6Um1rdmVGcEZiM3BRT1c1R1dXUm5WR2h4YWtSbUwzVlRUVTVQZURoYWVsQlVNbVl6YVRaMllXdzFlRlppZG1KamEwcFNVVVZDU21OS2EwdHpNSFpaWm05RFlqUkZWazFVUzFkMVduVnlkR1pWTWpaWmRtdGFabkI0WWt0WU0zZG1UblZVTTBwamRqbHpZa0owYlZOeU5rdEZiVUpsUkdNck1DOUtSRFZ5VlVGV05VSnNZMGhuZW1OdFVVZFJSbkZSUVdkRWFtVTFVVVZDV1ROR2VXOXZiVlpvVmxWWFVGUldWSFZCUTBjNWFqUTRlbGxJYUc1RFluZElWVVF2T1hsWldEVTJiRk01YTJsYVFXOURORkpQWm1Gb1lqQmhURXRhYTJKMWVXcHNXbXRhTDFGRllWWmpVbmN2U2xkUGRHOUNRamRpVDFWMmFWRnNRbEJoUkUxeGMwdFVaV1ZoU3paUk5GQTNWbFJKY0VORFEyRnFkV1pJZUhFNU0wNXpRMk5QZGs1cldtd3pka2xyTmpadVVWaEZkWEpaVTJOWWVXa3llR1kxUm01bFoxbEhPREJhWWpCMVdrRklXR3BJWVRWVVFXbE9SM1pxVlhGdk5EZG1iakpKT1RsVFRIcFpVV1J1UVZsNFYxaEhVaXRtZDJKRFZGRmxiMVo1YTJGNFpqaHBXWGd2SzB0VFMweExVeXQwWVdwMmJqWnlVV2RzTVdZMmF6bFlVblJaVFROTVprMHZhbTA1WVhkUWNXRm9NRUpFVkhSUlZGQjNRbFJPT0V0YU16UXJaWGhpVEVaVGRGWmpVSFJzV25sd1YwUmhjazF6Wm5acllpOXVhRVl2WnpoblJYVlRMMmRaV0d3eGJHMXVjbkJPTVVONVpXa3pRelZsYVRad2EyRkVVWEYxYjNsd2RuWm1hVVZEYkVSbVJUSTNUbU5IY25GTllXNWpTVlV5Y0RsRVJtRlhTWEU0TkN0R01HRjRORk50YWxscVV6aEdVak12TlhsR1lYaDJNbGhVYmtGdGVIbFpLMHhWTTBKeE9FVXhkVVppTmpaMGVGTXhNemhNT0U5T1JITTNWbmRLUjA5RVExQlFRa2hJYW5odFZrVnJOVzExV0VoUVRuVTRkSEUxUTNWSVNrWmFhSEZIZEd4UGJIUjVUR2x3VDNOb0x6TnFkRU4wZDA0M2JWZzJkRkJUYVhKMkszUmlXRTlpVkRSWFdtVjFkR04yYkdvMGIwVXpOM2RKVms1Nk5HeGpkakJ5YnpGT1FrNWllSFUxU2xKSFZHRTNRM04xV0ZOeFUwSlNZM2g1YjJkUk5rNHJRbHBZTURFeFFXZzNha2RaZG5WV1RsbFNZVzEzY0ZkYWJGZHFNMUpCZFhselIweE5aRWR4TWtwVU4zUkdaWG81ZWtoVVNXWmtjRFJJZW5sclJtbFRMMU5tTTNvMWMxWkVRakJFZDBwd1JXMXpWbUoyY0ZKQ1puSjFibWRKZG1ZeVZuVXlZMFowVG5ZclIwRTBaR2RxYlVOdk5IRkhVbkZIVTNGbWRuaEtNbFpDU0dkeE9HUmhiR0ZwUjJRMGJVUXdaa1ZoVEdOR1EwSm9hVlZuYjNReFNYUlRTVmhvU1VzeE1saHFiWGR5YWxkTWRrbFFkbXh1WTNWaGVWa3ZXV2xuZVcxdE5GVmxXRXhDTm5wblZEWXdkMFJpUkcxaWJVbDBaVEExTjFBNWJrZDRhalY1UkVwMGNGSndOVUpzZWs4ek1GUTNVMlp4UldoTFdISldXVEE0VEdKUmNHNHlaVFZhUlVKNVprTlJOM3BYWmtoRE1uRXZhbWxZTUdsRUsyTXlNREY1UTNneVUxUnVVRUk1YVZwUGVqSndiVVZZUmxkNWRWVlpTVmxSVlcwMlNWSkxha2hxVkZsMk0yTjFTRWRsY25JNFIwb3ljWGczU3l0MFVqaFlNVUY1ZFVONVRHc3JSRzEyTTJnM1VHNVdPWG8yV0VoR1NVcEtlVVkzWm5RM2JsRkRZWE5YUVU1U1VUVkhVRFkwVW5FeWJXMHlUbEZpV0RWeWExcERlRlJoT0dwdVlqbG5SRXBsTkNzeFRqQk5hR05RUkVwRVVVUnRjWHBDWXpabk1uRXJTMlJZVm5ONFdsUkpRbU5TYVhReGJEZGtObTFYUTBWVGVFaDBXRWw0Y1RGMmJtNHpRMVpxYkcxUVpsTjJTUzlOYVdKdlQweFZXblp6Y2xOaGNtWkJPWE5DV1V0R05sVjNRV3BISzAxT2J6RTBabTVRY1cwcmVqUkNka1ZGYVU5WmN6Y3JaaXRDU1U1d1EzQmlOVmxLTTBJdmNXZDRTblZhU0VKMmR6UmtlV3RIY1VwT1VWSm9lWFZIT1d0aWIyRjRiMkZvUjFZMGEwMUNjR3M1SzFsdU5VNUJiVUZQYVhoU1EwSktNM1F4UkdNNVZrZDFWbVI1VGxGNWNXaFFTREYxSzJoTk1FZFFNVTkwYm5jNFkxcGlWbUZHZUc4Mk5WaEpWRzlOTDBvdmNFSmFhVEJCY0ZGVWNubDZiSFpCZW10cmVtcHZhaTlyVURobVNqVk1UVXhaZFdoVGNITkpVRmRxT1djclpYUjRiRzl1TlVSU2VUZGhUR2R0VG10aFUyNDFhVXh6UzJSc1dpdHNiMDVKU0M5UFJIZG1PRkJ5UVdRcmNGaEhTMnBuZG5SdGQxaDFTV3B5UkRGd1UwTjBSemxRU1RkcksyMU9ORFF3TmpWVGRsVXlWR0pzY3pKblRXZE1MM041U2tGc04yVXhUVVJCUjFKbU1YbHhkVWRxU1hodldUQkJTVmR2TVhoSlJsUkliRVUzWVUxVE4weFdXR3MxZDBjMWVFTk1WQ3R5YmtkNWNsaFdNR0pNYW10MU5YSkNZbTlLTUhWNlkxSXdNa3hLTDJJclMyWlFVblZ5V1RWeE9HTjRUa1JhYms5ME0xbFRTalpQSzFoRlMzSTFWME41UTJ3NE5VNXhOR1ZtVmpWTFVXUmxTaXQzWlV0emJrUkhaV3RLUmxGNmMwMTZRVE5zY21GNFkydFJkRFptVURCdWJuTmFSRWRXTDFCaFNVOTBNVTk1Wm5wSlRuZzVORE52VERKYVIwMUJOVFp0TVZwbVJIUnBNbFpHWmpsWlF5OUNUelpXUzFGbVpuVjBPSEppVDJwcFpXNDJTM2xzVjFsTUwxRk9XbWxGT0hSMUwzRmpkRkJLUkhZM2JERjZZMWxpU2xwb1VEWk5WRzFsYzFKUWVtOWFSaTlpWW5FeGQyZEpZVVJJVkdac1NIQTBVRlJaYmpkTVEwZzBkRE5GTkVkdFN6TnRkbWRuYW5wc1VUUjVWalZOYjNwSGMxUm1PRVZrVjFSUVZteFVkM2haVGtjdmNWaFJSbEJZZFdkaUwwdHVkeTlGVW1OM05UVndNbFJVVEVOT1luVktUM2xSWTJOdFp6bDJPV2h5VlZVd1JrOUJNamd3V1d0bFRFNUZXVXcwWjI5SE5VcFBSMmh5Wml0MU0wWTNaMVZFV25sNVFqbHdiMUF4ZGtaNVExTTVaRkpKYUhKMFR6RklVVnBhZHpWRVZIZ3pRa3RTYkZJeEx6aHViMlpWYWtwUk4wcFZabTlMT0dScUsxZGFTMll2Y0RVd1JsTktOM2RFVDBaVFJuYzBaVFZKY0dVMVRGTklka3hoY0hkVWJreFlWbVV3VjAxUU9XaEZiWGxzVldkTk1sRm5OMGdyYkc1c2JUZ3dUV3AwYVhKT2FrbDJZeloyTTJsd1FreElhME5sVHl0M1drbFNRbkJqYm5wdFVtMTNUSFJuVlZOa1IxUTFXV3RUVUZwdk9FRTFWVlV3Wmk5U1IyTXJVVE5yVWxOdlVXdEpXRmg0YW10cVl6SXlNVVJSTTI1SlVraFllVUZ6ZWxkcU1GUTFlWGQzU1ZkcU5IQmFUek0xY3poR05TdHpkakpVVDJGQlVrVlVSRTl0Y21WVFRITlJkeTl1YTAxUWRGVnZZakEzVldkME5FZDFlSFIwVkRSQk0yRmhhWE5oWkd0bFNWVjNRekZvWldVd2QxSTJSbXQxYTB3eFJ6aHNaMnhEYWxZd1dWWkRlR1phWldjM01IUmFkR2RQTDNVeFVWcGtkbVprU1ZBck56bFFkekpzUlZWWmNVOW5SVEZrU0ZsUWJEZGtXVVpzWkZRMFJGVnFUbE5CUVN0c1kwaFVVM1pRU3poNlMzaFFiM2RPVmk5eGVIQklUblpUVkVkRGExZzVVVEpKUVRkaGFEUTJSSFJ3VUhGbWNuTnBXbXBaVmxKblIwZ3hlVEJJZVZoS2MwcFdkbUpVWlhFemVXMTZaMkkzUW10eVdVdDRlbWxYWm1aT1dqY3JZVlIzTkdOTlIyUlJVak51UkdWQlpETjRValZ6ZEVsMlJXUjBVMkpGV0hwcmF6TldOMlZMUm5ObGJHbGlVMlZqUmtoMVYzUTRaMXBET0ZKQk9HNHJOU3RqUmxWSlJGVjFNbE5QVTNWNGJVVlJWWG8yVVdGeVRHdEJNa2RtVkcxaE5IbGhLMk5oT0V0MFlWZEpOa3hsVlVZMVYxbGlTbFZuZDNOd1JsVmxlbTlTYzBaTmVtNUxhSFJKV1VkeGFGaHdVR2hPUTNSbFkwcDFWVGgxZGpaeWJ6TmxNRkJ6Ukc5TWNtTkZVMWxUYkhaRFVETTJNRXNyWWxOTFpHazNOelpDSzFodlZsaHVOM1ZZTUdVeVpWUlBOazFsY0VRMVJEUkNabXh6ZHpScWFHdHplRmt4VkVnM2FHVTJUV1pSYUU1TVpta3dSbXAxVjJsS2RqaHdaRmRNY0hsMGRYSnRXRmR6TTBKRGNUTlFjV2Q1VkVaRU9HcHVXVWRaUm0xWlZVVnBOMEpPYlZGcWVqRnRTRlkzVWpCR1JubEZOMHR3VlhjNWJYZFRPVXhCVnpseFpreFRVV0pRUTJWd04zSnZkRlZXTW1WQ1JrUnNNRUY1V0hOcWNuTXpUbVl3YjI1dFkwZEpWMEpPZW1ocE5VaFZRa2d4YlVaVlNIbHBNM1JHVjB3M1lVbHJZWGxoZFd0NksxSmtMMkpNY0hOalFrVjJZbnBDYUZwaGNGTlBORGRuVkVaSVNrMHhlRTgxUW1kM2FYaEZNbWQxVkZwVllUZDFTemx1WkZkV1YwaHRUeTlVUm1scmVVbG1RemRITVRGQk5WRlVjbXcxYkdjcmJGQlJTVkJLVm1sc1pHOTBTMDUzZVc5cFdTODVkVmR6YWtKUEt6UXdOMFEyV2tsT1UzWkVkVE5JUlRKQ1FXeHJiSFZTYjA5SlJFWlVjVmh2ZDI1blREaHZUakJvUjNOTlJWSlRhVFI2VldsT1VWRnNTREpDTlVKMkx6aFlkR1pQWkd0T0wwdFRiV0pvZGt0QlkwNHJiekJEWVhjdlppOXlhMDFVU0VwM2FraFdOblY0WTNRdlpFUXhUREJvWlRZck5sVkhUamhoUVRKWVZVcHBORFJvVURSSFRuRlZSVkJwYlV0UGFFbzFhREpRYzFWa2NHTjNjVUpGZDBWcFptcG9SVmxLVmpOYVRVRnFURmhIT1hoc1owMTJjRGRNZEZkQ05rSnRRMVJrVTJORVMyOW5WbkZhV1dsblkwTmhWVVpSUmsxdGQwa3ljU3R0YkhOTVltbHhjU3N5U2pNMVkxZHBPR05yV1ZobE5GSXJVMlJ4ZW1oeWVHVTVRVVUzUldsc1ppOXdVbEl5YkU5TFpHczBkbEZwY3pCc1UzWXpVbEJLUWtGSll6QlpZMk13WjFvNE9VeG5kMEl2UW0xcmMwUm5SV1ZKU21od0t5dHNTRWhHVFdOdlVGUk1ZMGxJVWtwc00xTm1TMDFvVVd0SmVqWlVRMUIyWmpJemVVZEJjMjAyTkZGaGFVaGFWRFo0WmxsS1JqWjNVM1k1WkdaNVVsTnFZbUU0WTFWcU5scDZSWEZwTlZwc09FMDRLekk0UTNnNFlXY3lOU3NyUWpaa1VuWmlTblZrUkV4UlYwTnROV1UxWTJWclNIcHJlVk14WVVSR1lsUmFUVEZ0WVVwcmJIZE9LMmRvZW14alVFMWhaMDFtYW5BM1NURTFTelZrU1VsSFRFNXdTVXBMZFZaRVFURmtaVk5NYlVzemMwVTBNa1IzUldsR2FEUTVaaTlhWkhjMGNFSnJLMW8wTm1OWk1reGtTVVp4V1ZjM01rWTJjM28yYUZRNVRsSlhLM0JaV0hRMVRGWkJVemRuWlhsV1JteDNNM1JIUlROdVkwdE5jRkZTYTNsQlRFcHFWM2cyVEhGUmVqQXZjbFJxZVZWblQwbFJSMUZ2WkhWdlVHUmFUMUJWV0ZSdFVuVXhNbGd2UkM5Sk1rWnpkRXRaTTBOMWN6UnRlVUZ2VTNWT2MycHBWSGxIWTFsS1dVUTJOR3c0YmxSaFR5OVBkWEJuWjJNeGNTOVVVVXcyVFhGaWNuSXhTVWhIZFVKQlZUSXJWVGxRZGk5a056RjNkamxVYUVOMEsxUlhLemQ0WXpoQ1pEaDVablZZZFRKcFVqWkxabE5YVldScGRVVTRRVTB5WmxKM2NXdFFSbnBvV0ZCQlpsQnZjRlpCU0hwQ2RYcG9UMGhUWVcwMFlVaHJUMloyTnpKclZESmFabXBqTkhvMVRVeG5RV3hUYVdzMVJsWkVRbmh5UmsxeFIxaHpjakp3ZGpGblFrRlFRM2h1YmtObmNqVllXamhyVFd0TlprTldUMnR0WkU1Uk5uZEVSbEp3ZVRkM1VETkVWVGxUY21sdlpuZDRWbTV2VFdacVRsSjVOVGRIYlVoWFMxRldhMnB3T1VoalZuQk9RamwzZGxOMVJXNXhaVzh5UW1wRk9FOXhkRWRJVVhGUE1Fa3JObUY2YlZWUFdHTXZaRm80V25oaU5UbEVjbWRoZHpoellrZE1aRko1V0VVM2NWcDJOa2cwWjNoWlpESnpaVnA2ZURNd2FtNVlkbmc1UlVGVVVWZHVkbXczT0cxWGJuZzFaWFF2UVVwS2FtZDFNVU16U3l0VU1tdGxLMnRhUW5Ca1J6Y3ZSRFZtU0hCM2RYWjBXbFJoV2xSNFRHdHhORFZpYTFwNUszQnNkRkJJVjNKbGVEazNVSFF3UnpkemR5OWxOWEp6V1ZkNmJXbHNVMnROZFhJd01XNVFXamR6WkRkMVRWSXljamg1VUdzMFNWQjBNa0p1TjFWVlkyMTFZMjV0WW1WTVJucExjMnRhWTFwRE0zRjBRMHczWVdaSFpVdGphamd5U1VWT09XbG1SMll2TDNOUmIzSXZaMUpsWlVGSGVGRllXRXByV205MFNIazRhMjg0VXpCek4wcGtkWE5TUWtGdlFWZzJZbGgzYzJVM2NrUkdLMHQzTUdOVFFtVjJSMEpOWlZKMWFrdFBXV0YzY0U1cVFuQkVhWHB5ZGpKVmNFcHpOVGhqWkRKeU1FTXdhVlEyTkROQlVWTTVlRE5ETkd4U1NIZEdNR2h0UXl0cmJXOVRSMlpVTjJSVFVEZHJaa2d2UzI1WFZtWTFaRW81TkdwNU5FZHNlV2MzYWxSME9IQm1TMFUyTjJkNFFVc3lRbUZxV25sMFVsUkJOVGxvUVdSNVEzWktiU3R5UkVaTk0wVTJSRzExUTFnd2RXVXdjWEE1UWpWVldYWkNSV0pIYTJ4SlNrOURaazFwUkU1NWFIQnhWMjVXZWpseldscFdjbTR4WTNsb2EzcFpSV1F3VUdKdkswZE9WbWR1ZVc5dVozWTVhMEZxVEUxc09HNTZTRTl3VG5GaGFuRXhLMk5hY1d4b1VHMWxjR2xaYUdZMU55OXNaVVpSZGtSV1YxUmhVSEI1UTJGdmFuVXJabkZVWkZsdlZHTlRSVUp2T0ZkR05WQjBNVXBHVDJkaldIbEpSbTl1U0ZZNVEwOVlkMng0UW5kUVZtOVJjMFl3YXpoaFUyOUpUV04xY1VKR1lqQTFSSFEwU0dSa2VUZFFSbTFRYWpKNVVUbE5XbUpPUW1SaFltRlVkRTh2U1N0aGQxUnJVVmxGYURaSmFVRjZMMEoyU1VWU1luWlpjbXRWZDFCWVVqWTRkV3BGVkVaVWNtWjNVWGh4TTJwQ2F6Wk1NVFZpZUdKdFpWQjBWRmhsY1RKWWNqQlpaazFWVWpGemVsUlRUamxXUVhwM1QwMVVVQzh6ZVhGTU5XbFFRa0prV1U5MlFpdHJXRzFDY0dkTU1FOUtUVkU0Um1KeVVHazBlU3R5YjJsemJIWTRaVGh1U0dGc1JIVkllbU5xYTJJMVJuaFFTamxvVDB4eWJVeHpNemRVY1U5cmJUbHpNSG96Y1ZORFJXSTFVbUpXU0c1ck9ERklaSGd3Y0N0UmFEVkZZWGRNYm1kc1VWSTJhMnRwYUhSNlVHeGpTbGxzVkhKWWVrdE9lVk51SzBwcWNVNDFha1E1TWpCcWRtY3pVbVl5YjNsbWVrTmthVFZ6Ykhsb1UySjJhRWR1UlhKMVltOUdVVTlKV1doTWIwd3JMMlJyVTFwNVdWRldSMmhSUVdodVRqRlBkSEpOV0RWUWNEa3liMmREYmxGT0wwUTFNalUxU1hSR1l6VXdaeXRQYVRGRGFXc3pVMG8xTUVwa1ZGVjVheXREZWk5ck5raDNSRFZUYUZOSVEyUnpaMDFSVDNKV01XVXlUeXRTU0U5SE9XRkdhM1YzZG5wRE1GVTJWVEl2WjJjNGVHeHhiSEEyVjFSSVprOUJMMUEyY0VSNlFXOTBhR0puWlNzeWNIQlBTMFpMTDA1Rk1rNUlUR1ZzYWpCaEsyeDNRMkY1T1c5MWJFeGFXREptUzFGU1ZXdDVRbUpzUWt4c1dERTVSbWxtVjFWalkwTnhPVUppTWtWdFduSnpRVVZoZWpScE5uZHZTRXR3VGpOaEswSjVLMUZPUXlzM2VtaFZPSEpPV1cxbmMwSXZZakZGU21SUFdWWlBRMlJQWjFrMWNGWkZhRUZJVkUxU2IyeG1OWEZIY21RMFkzTmpVR1ZxWkV4MU1WVk9ibGxhUWxoelZYbFdObE53VW5aS1QwZDJWbk5RYjB4c2IwSmFiM1pyWWxCbmFFczJPVEJaVTBGS09WRkhOMVJUZGxGQ1VIZElVMUY0VEhBeVF6TkdaM1Y0WWtwVk5UQmFlSFI2UVdSTFZFWkdNVE50Y1dWdVNqRjNXWGx1ZVhWWlFUVjJWRkF5TjBocGEwTXpaR0Z0VEU1WlMybEpaWGhUTTNwdWQwNXRTRWhUWXpKNldqWTFNelpLZVc5V1MzTm1PSEJ2YkU1a01ubFVhRTFyU1hSMWRYWlhRVkpyUkRKNGJ6UnZSWEZ1TVZodFdtRkVOMlZ5YkV4UFQxUmtRVmh4YldseWJtcDRjUzluVlZZMk55czJSbVpWTkVVcmNWWnlkM0k0ZWtnellYWndVV0ZuTTIxSkwwNXVSaTkxZFdjNFJGWm9RbE5MYldGdVltWkNhRVp3TW1WaWJUZDBlbVo0WW1oeWVVaExTREJ1VEU1M1J6ZGpaVTA1ZFZaRFptOVlVM2d3VFUxR1VISTFka3RRZHpGNWNEbDFTRWRwVFdGTldsRTVNVGN3WVcxTmVFUjJVekJqVDFwMllVVTRiMmxtVEZWR2VIVjVaREJqVG1jeVpFSkxTMnczV0RJcldVVjVjVGRSU1RNelVYQlpkVU5yU21GS2N6WlZhRFZOVTJSS00xUkJkR1FyU2xKRVYyTkhiVkZEYTBWT1ExcHNhSEYxUkVWelNYZFFhMjEzT1N0a2ExcGpPRk5oT1c5T2RrUnVhMHQxVVc1MGVIWTJRMmQyU1RCb1kzRklielZYZUZJM1VYWTJkRFpwYnpsbldISm1iMEpwZEVGUWNEaHdWWGhOZEdGb2IwOUxkVFV6UmtOV1QzZzJkMjlTV0dWbk1HRnBZWHBNTUU5SWRHNVNPRWszZUdaSWRIbG5WbU00WlZGd05uSk5SWGhvVW5WS1NXWlliREZFUW5CNFdHWnBabWgxWlVoSGFYZ3JlSGxhUml0bmRuTnJhVEEwVFVWRE1rbHpaMkpHVEU1elYzTnlRMGMwTVVSSlowOW5ibGt4UTI1WWVUZHNNalJuV1RraUxDSnRZV01pT2lKbFltSm1NbVprWm1RME9HSm1OR0ZoWlRNMVpqSTBNbVptWlRjeU1qTmlZMlZsTlRjd1pXSTJOekl6TW1Vd1lUUXpaVFF6WldNME5USTNPREpqTjJWbElpd2lkR0ZuSWpvaUluMD0=', 1754884847),
('lEi42q6XyJED8VjNSeBUf3cQ387fohc7hhtsEKMy', NULL, '45.182.22.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', 'ZXlKcGRpSTZJbVU0YkVGWFJtMUpRV2RHYkV4eE1IaGtiRWxZYW5jOVBTSXNJblpoYkhWbElqb2laak15VWxGTlJsQjViak5ITWt0UlFtdHZhRzgyTm5aaGNqQnJPRkpxVUM5d1JFY3laMVZMUjFCSlJDOWlibWRyU1d0ME56UmpOamd4Vm5wVldVMU5WelI0Y0RCMGFHMTNXVFJpY3l0NlJqTmtSV3d5ZEZKSll6WldWMkk0UVZOeWNrZFliekp6UkVGTFJIaHdOWGswU21OYWNTOHJWV1owTVVRckx6VlRjMkZXTW5wcU9VTTVaR2NyTUZCVVExTnhXbFJCT1dwc09Fd3hhRXhuY0hoc01WZzRTbWt2U0ZWeFlsRTBWQzg1YWxwS1UzVTRaR0VyVWs1a2FrSkJkbWRUZUdkallXTndZVlE1Wkc1a2RsVTJhbXh4Wm5kdVdXaGFNSGRCU2pCeVVFZGpMMkV6T1hoeVNHSTNPVFZ2YUdkdFFYWkNTMmc1YW5Sd1UxZEJVazFwSzJ4Sk5rdGphSE0wZDNadFpYTnRkVFJZZEU5d2JWRTlQU0lzSW0xaFl5STZJak14TkRVMU16WXlZemcxTm1JMk1tVTRNR1k1TldKa1pUUTJOakZoTWpneFlqRTRZek01TlRNM01Ua3dNemc0TmprM1ptUTFaVGxqTjJNM1lXUXpOREFpTENKMFlXY2lPaUlpZlE9PQ==', 1754860949),
('lqANEsiNtm2oLvRXh7QXlIviYOGH7QIFII3cGChd', NULL, '186.2.134.69', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbXRqWXpOQmFqZDNiek51VkdOeVRrOVBhQ3RTT0djOVBTSXNJblpoYkhWbElqb2ljWEJZUjFOUFkwaHBVV05UTDI5SU5raHRjVlFyUlVabmRrVk9TMWQzU1Vsb1MxaEpWaTh3THpGRWRYcGpPR3cyTnpsWmFYWmhMMlpLUWxSdmVWRXdNRXAwVkVGVVJuVllZekV3TURCMlJuSjFaVUZuYUVndmRETTRPSFJ4VUZsMlFuSXhLMlU0WldKME1HZEtXRlJDWWk5NWVHaHJPSFF4UkVGRVNFeFRkSE54UVdKaVdtbG9OV2xLTVROcFJ6QjVkbmh3ZW1WSVQza3ljM0JvWlhkRVN6Tk5jRUZsVUVFck5qQlFlRWxQVWpOVlRVSnZWMHBDTVdOMWIwWkZNV05PZVRjMlkxQlBlR1JqT1cxUlpHeHFhMngxYm1sc1ZrWm1lVkpUZDJaMlluY3piMlZOVlRWcE5EVXJjWGxYVkRGWGNWTk5ibFF2SzJack0yeExXbVJ2Y0daak1VVkZiaTlTWkdKMk5EVk1jRE13T0ZFeWIxRTlQU0lzSW0xaFl5STZJbVJqTldFME4yTmpOakEzTmpZeVpHTTBPVFV6TUROa05EUTVNbUV4TURWak56aGlOekkxWkRGa05tWXlabU0zWkRReE9HVmpOalJtTlRRNE1HSXdZVFFpTENKMFlXY2lPaUlpZlE9PQ==', 1754866511),
('nutoCpFNFIyehjGUvY1UOhx1TBxIrFWUEsvK614u', NULL, '201.220.139.170', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', 'ZXlKcGRpSTZJbXc0U0c0NVNVbzRjM05DTDJGYVNUUkJOVkJGY0hjOVBTSXNJblpoYkhWbElqb2lSbUZQVWxONFdYVm9iSFJ4Vm5neE1GWmlhMHN2TVVFMVJWVmpUek4zY0VjMGFETnZTbUYyTW14eVF6a3ZUa0ZHUWpWalEyOUhjRGM0VnpWQlQzcHJla3hNWlU5UFVtZHpkbVpGV0dGNU1GTlRPWG95Y1RVdlQyaE9NaXRwUTJndlZUQjVjVGRyZEZwa1ZVd3hOMWRDVmtKaGQxbERlbFIyTTJnNU1FaHVUek5HY21WelYwZDRVVkJuTDI1cFZFbzJkRUpzT0hGV1JGZHlja2xoUzNWclpqQjVlWGRCUzA1eVRHNDVTMHBGVWxsVFdtNU5OVVU0Y1cxMlZqTkhTamxuTnpOaFoyNVNMMVZPVTNoQ1VFdHJWbVI0Y1RrdlpVVk5Sekl2VTJKNlFqQjRRaTlLTjFGdk1VUnJiMWw1Y25Rd1RqQkhaWFpMYmxkUE9UZElXWE5KYkU4d1dqZ3hlV1F4ZFZCT1dIWnVSMFpJZEVWWGRVRTlQU0lzSW0xaFl5STZJbUppTXpBNVltWTJaamRoWVRobU1EbGhaVE5pWkdSaE5tVTVaVFF4WkRSa05qQmpaams1WlRVMFpUWm1ZalU1TWpRME5UTTJNalUyTTJFME9UWTFZVFFpTENKMFlXY2lPaUlpZlE9PQ==', 1754866352),
('oWt5CDp5O72EsZH0alfLCvX1DLwIsXzdMcRyXwlN', NULL, '23.228.130.132', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', 'ZXlKcGRpSTZJa1Y1TmtaRk4zZ3dabGxPWjFwblEyWjZVSGxzU0hjOVBTSXNJblpoYkhWbElqb2lSSGhTY0UxdlFXdzJUM0JHUkhWSk0ybDVSRTQyWlRFMVNGcHJWbE5EVTFwS2VWWnlaWHBpWVdScFlXbFdURk5PVkc5WVNtWjBiWFpZZVdkSlp6RnRSazFCYTNRclEySlZVa2hoWTNSMFZUSjBhVkI2UkM5VFEzSXlTM1pPY1d4RFJVeGxNWGxsU2xFcmNVVldWMEZTTUVoaFVrdHJNQ3RHVW1JelRGQkRNR040ZERjdlZIZEJSMWMyUW1samJUZDFSMEZST1ZGUk5UUTFVbWd5TWpCQ2JpODVZVXg1YW5SMFRuZHNiWGxWU1d0UVpHZDJZMVpFU3k5a1ZWaDBSbUUzWWpOR1NGTldTU3QwY2tSWFZWcGpaazFCUTBSMUx5ODFaak5UU0RORGRGSnRTMmRVTm10bVdqQnhWRkk0VjNGUlpUQlRZbGxrY2toQk5sRTVkblowVkdabVpXUmFaVkJ5VTFkMFNHWjFWamhPV2tGaVlVRTlQU0lzSW0xaFl5STZJak5sWXprNFpHRTJPREZrTTJWaVpqVTBPR1JqTWprek9UTmpZVFV4WXpVM04yUmtZamd3WmpBNU5UbGpOR1V4WXpNME5qbGpOR05pWVRBeE5UWmpaVFFpTENKMFlXY2lPaUlpZlE9PQ==', 1754890408),
('rvCTmawyf15ke2T3sxn3l1qFIETKnzzx3KsUFOzM', NULL, '186.2.155.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/139.0.7258.76 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJakJzY0RkTVRIQlJVa2xPZHpsNFNWbElObkJSV0hjOVBTSXNJblpoYkhWbElqb2lWblpzVW5sbFZGaHdXVEU1Vmt0RmFrUm1UbXhYYW5KSGRqTXdMek4xYlZSWVdYTkJNVTFLVVVwME9HVnhjek5HYUd3cmVqbEpVUzkxVm1zelMxaGllWFkzVVU5UVlYQm9jVFoyWjJ3M1pqRnpSRlpWT0VaMmVFeG9TVkpYT0d4V1ZERmlVMVp2T1RSa1lubzBTV2xzWTFrNE9FdGlOVlpGT0VkelUwWXpka3hCT0ZrNVpFZFlWRnAzT1dvdlZVWTFSbVU0Y1M5SWVHdFJhMHRDYUdSNGNrMVRjMlYwTjBKWGFHOVVRamRsVEdGWGVFWnBiMk16WlM5dmNYVktUMlkyVGtkbFRYWm1TbTkxUVcweFQwdE5SRzUyV1RGdVpVb3ZVSFpuZFhkUEwwaDFjREJXUTFKRU4xQm9aSHBWYjJ4Q1RXSllNbkZtV2xsRWJuWkJMM1JDVTBOdmNFZHpjMWxvUTBRMlVUZGFlVWRVVEc5d1dtYzlQU0lzSW0xaFl5STZJamhoWkdNek5XSTJZVGhrTUdKaU0yWTBZemRtTW1WaU5XWmlaV1JtTXpBd1ltVXhPV0ZrTWpnMU5EVXdZVE5sTURsa05EaGhNVGM1T0RnMlltUXdabVVpTENKMFlXY2lPaUlpZlE9PQ==', 1754873025),
('TjZAJkhuTDLoHdIOCTwQCdKmpgkmDOb4LqqreaDV', NULL, '43.164.197.177', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJbWRoUkhsUmFUTXZXbGMyVlVaemFrNHlkRVJuSzBFOVBTSXNJblpoYkhWbElqb2lkbEUwYm5oMFIxQk5UblpRWWs5WmMxSmlaRmhSYkVSeWRWRnNLMEZpVFRsdVJrTnZjRU5SYUZGcmJtdEhXRVY1VlZCRmFGWjBhMHhHTW0wMmNVNTViVVJGTjA5clRrdFVjRGx6YzJoM1JISnFaSGd4YmpWMlFuTXJXRUpvTHpGME9GRndWMVIyUkRRMGFtOW5Va3RTY2tab1dFbHpjRk5LWm1sSE1EbFBXVUp2T0V4UFdVWkxaVGhxV205d05sbDFjVEJzZFdwSmFHOUZWa1YyZGxGVlFrOXdOMEZ6ZVRsWGJWUXZZVFExV0dnMGJUSlRZWE5yVlZNNFEzTlBUMDVqY0hweldteGhSMjFzYTNkSFZqZFBlVXRrY2xSTFNpdEtUMWR2VTJWYVFYRm5Wa0pxT0U5MmNuVkdjbWwyVFRsV2FXeFVkRmxvYjFwbU5YVTJlV0p5WVRRMUwxVk5aMDlJVFc1VVpHZEJjRWxyVnl0Q1ZWRTlQU0lzSW0xaFl5STZJakZsTmprMU5XSXhZVFUwT0dJeU0yUXhaV1U0WkRJeU5HVXdNVEJtTlRBeU9XSmhOMkU1TlRGbVpHTTVPVE0xTW1WbE5qUTNNV0l6WXpjME9XUTBPV1VpTENKMFlXY2lPaUlpZlE9PQ==', 1754886906),
('U1YMgeh0BYMQmiltlIcuM6j6xYQLhd6gCZglcZxg', NULL, '190.242.24.111', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'ZXlKcGRpSTZJbVV3VW5wc05UYzRaeXR1TUVkbmRWcENTRGgzY0VFOVBTSXNJblpoYkhWbElqb2liMEkxUmxCT1RVWlRZbkpRVlhSUlJFNXZPVFphT0U1ck9EZFZZV3d6WWl0b2VUbFdOa0ZzUlZsbU9IbHhPVEpSVFZKRldYWXhRekJtTXpnd1RteHVUM2RsT0hveFVtcDFNemh5Uml0M1FXWlFVMDFOTTJaVWRsTnRXbUZTVEZGYVdTdGtVakozTTNoT1FrOUNOVkV6ZWxWSFUxWnpURWMzYTIxQmEwRTVjRmRRY2pWTmJVRmtkMmRITWt4bGFXdEZZVlZLY1dsdldUUk9XRnBuUlRneU0xTXdRVU5CVHpaaVZIQklOM1JRY1ZGbmNUTk9ZMlJrVW05VVkxRnBhMkV6WVRaekswWnZla3BpTUhrclExZEVTR0ZKVlZFcmExRlFSemRUUm5oQk4zaE1VMU5wTjBWWVprVjBVR0ZtWVVOV1UwZENPVms1UVRnNFUySmFVSEl4Y1cxQ1ltRlBZWGhNVkhrMVQyeDFiVmd6Y1c1SmNrRTlQU0lzSW0xaFl5STZJak5tWm1ZNU5tRm1NRFZpTURSaE5tRXpPVFExTkRVek1UTTFOalEzWlRRMU1EVTROek15WWpOak16SmpaV1UxTnpVeU9UZGtNVE0yT0RFMU1HRTVOalVpTENKMFlXY2lPaUlpZlE9PQ==', 1754884732),
('Uu6AD7Tgo31ox7fw5xh1ysPoGPI0xw9BtY0nGka8', NULL, '79.124.58.198', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'ZXlKcGRpSTZJbFpYYkVwV2NuZHVjM2hVV0RCVGNYSXlValV2WW1jOVBTSXNJblpoYkhWbElqb2lSM2QwY3pOdlNrVmlMMW8wVkZCaEt6ZzJNRFZGSzJFck5EUjFhbUU0YnpOTlRFa3daR3RzUVRFMk5FMXhUR2syZWtKcFVtOVRabWRPU3pKVGVuUnJibFpKTVROaVNHbE9RVU0zYW5aS1NIWmFaMGxtTjNoNFJESmFkVkZpV0RNd1JEbGxOM1V3TjBSR1VVaFpXakl6VVRSMWIzVkdhV1ZvYXpCck1rcFpjVEphWjNwQmFYcENSemhOUWpGellYaExPWHBJZUc1dkx5dE1Va0p6YUZBNFkySXhaMUJaVTFvck4xUk5jR1pxTkVWcE1XeG5NbEZwYURjM2FXNWhXakF6YUVaMFNFNTNSVTV6VUhacWRpOVFWVEZFY1ROaU9WQkZZa3ROYkM5MGRXTkZaRGhRT1RVemMzSTJZMlk1VUhWaVkzbFdVMHN5YnpSaVZuUndWWEp4UkUxV2RUVjRNV1I1ZEVaeFpsWlRZMWw0U2tkSlVsRTlQU0lzSW0xaFl5STZJbUptTTJJNVpEQTVNemt6TURreE16WXpZelk1TTJRM01HRTBZMkZoWTJKa01UaGpNamRpWkRsa01tVTJZV1V4TnpBd05USmhNVGszT0dFek1EVm1PREFpTENKMFlXY2lPaUlpZlE9PQ==', 1754881786),
('vVOLaMtBMjc2pwz4YNyb9tyIaSQtd4VH7cMAhPOn', NULL, '138.94.121.243', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbEV3TUd3clVFUk9PVmMyT0doSFZuaHZVVEpVYzFFOVBTSXNJblpoYkhWbElqb2laVUpTTW5WT2MyUlFXbXAxZUdOTU5sZFJVRWhGVlhrMlZFOUphaTlsYzNsdWMybzJZMjB4Tm5WVlQyRllaekJSTm0xRmNEVnVaelZaTVZCbU4yZEdUbVJNU1hGVVIzTkNhelp5U2xZd1UyODRlSGx3Y0hwRlVqVjZVbWR0UlVGM1N6TndZMkk1Y1VWbGVIVnZNelI2VFRJMVZtSmtVMlJxY1ZOVlNUVllVa1ZKUzI5MVdqaDROM0ZRTUc1b2IwTTNlSEppYXpaMWFESnBhWFprZURFeVVWbEpWM1JZV1RkeU1XMUthMXBPUTB0MVpuSnNTMlk0TTFwaVNqVjVNWEJXVFdveVRtRXJTWEp1Y2xWWVpuUTRVMFZKY0dNelQyTkNjekpyWW13NWJtbDRZVFJxVUhCM2MzTmlPVTlYWms5UmFVSTRiM2ROTDJzeFVFSjVTWFUwYlRWRFl5dGtNWE5hT1ZCTE9EZzRPR3B4UTNGcWJreG1hVWxhYzA5WlJWaEJiMGh3YUdoemVtVlNiemM1YWtkUmJ6QnZSbU5RUm10SFZXUldhVkZZWVVNelprSjJRMFJaYUc5SmJVOVRRa1ZJUldWWk16TjVaV3h5VERoV1pqRkNiMlJCU0Vsc1kyaENUVGN2U3pGdlIwSmlOSEpxYm1wM1NXaFVZV3NyUVc1TmFFbEhlVkJoWWpkV056Rm1OazluVEd4YWEyOTRURXBYVXk5amFVUTRjV1J4TkVaTFZVcEVjR3RwUjI5d0szaHhZUzk1U205NVVHY3pVVmt4V1ZkbGFXVjFTRmhLVDBoRlVtbHViazV1UWs1cGJuRldielZDUTIxeFdGUmhhamxpZUVwSGMyaGtaa1p1TkZabWNsaGFSMUpDTTBObldqVlhjVWRLTW1SSWNUZHdlWE5XY1ZGUWFERjZVR1IzWldWbFREbG5WRmMzVkhOVU1FVnRVa2hZUm5Jd05DdHlUemhTYjFWUGFGY3hLelpUUkZkUFFraFhabWhtYTBaVGRGWm9ORVZtYzBwaWEyaHpURlJpU0N0TFRFTjBibG92TldsSVJXOUdUQ3QwYVdzNE1EVlBSa3BRYm5aUFEzbHllaXQwVHpNMllXVllORTFwUkRWcmJGQnRSVlpqZFcwMWMyeEpORVZ4V1dsb1oxVkxZMVZwYlVJd2VVUnNNbGdyYjA1RVpEUjZja1J6TDAxRE9WVmpWMEZaY2xGeVpXRnZlRzFqVEZseFYyNDVSVzFSVEVSTk1EVjRXRTAwUjFsbU4yZGlaRzl6WVZsek5FdHFjRE5zTjJsdU5VWnpWamhpVUVWcmVEWTNaRmhpV0dwaFFteHlRazlGZGt4dVJHbE1kVVpaZFRSbWJsQTNjMlJFUzNodmRGUkVaMGRqUjNwR1ZtcENRMkpMVGk5cGNqUjVZekJRSzBaRVUzRmxkbW8wTlZSTVJXZzFWbWh1Y2tGVmVGSXljWEJWZHpSUVVYY3hiV1V2Y1VWTFVYZDJWa296UjBndlZuWnlObXhvY21OMlZXeHNUMEpGYVhjeU1rcGlkRXBHT1daV1puTTRTRzlqVUZWNGRtOXJWRWh0TjA0MksyZ3ZUVkY1UWt0aU1VcERORVpPYjFFelltOVZja2R5Um1sRFpVbEljRlYwWW5GNFdIVTRkRll2YlhkMk9GZG9Uall3ZDNFemIzWlNUSGg2TlhCSVRUZ3JaMk5WYWpCT1VXMHhMMGxwVTBsRWVsaDVhM28zYzNoS1VuTlVRM2wzV1c1TWEwdFdWMUJXYTFkaUx6WnhUMk0xVFRSSk1VTjViVk5ZU2s1bFZHWmxVU3RSWVdKUlRuRjJOelZSTlhOU2NXWnBSRk5wYzB0c1dEbHZSM1F5V25GREwzUTRUVzlKVlc5UU5HTnFRazR6UzBKMlFrVnhkR051VlZCRVVrMW1aV1ZrVDNKNmNEYzROSGc1ZFVVMmVHOUljelYwT0d4ak9GVTJjR2R3Y3pKSGJubHZlSGxoV1dOT1ZGWnVkMm80T0dSWmNYUk9UV0pKSzNSTkwxaE9MemRxT1Vkak16SkxZVmRtUTFGWVRFZGlaalZ3WnpNclJscDViMmhMTTNneVJWcDRUMkpEWjFjdldWaFNhemRsYzNwYWJtZFliMFEzZW14c2VEVk5hM2wzT1ZsYVNUUXJlSElyWXpOcFlXc3dObE5WY2tsUlltVmpUSEoxYW1aUFVVcGFXVWhJUTFoWVJrYzBMM05sVEd0SFZVVXhjbmt2Wm1ORVNuUllXa0pYTTBZeU5XOUNWRWQxVUVoWVdtWTNkV3hxYmtzeVRsWkpNSFl5V1VWT2JDc3ZaVTk0YUhKQlVGSnRaMm80VjJKdVFXOVNlVEIwV2twR1NGSjVNekl5YUZkMmRHNWFTelEyTTBZeFZUQkVTVXBhY0ZOdlZUbDRSR2RWVUc1MFpGSkZSaTlYTDJ0S2JYWkZjUzlWU1hwV2JFMW5haXR5YmpBMWJFcGlhV0ZzTmprNGJrVlBhRWxvTW1OaVdGbENVV3RyY0VOMU1WZ3pZVFptYWpKTVptUXpWVUpCTjI5MGJqWklORWRMYTFwc2NEbHRaSFJ3WkdoNGF6ZDVRV3h2YVVSelpqWkJNVk5HYjBoblRXWlFOVU15WkVaeWFXaHBkVVJtVWpKc1NHcE5RV2g1VG1GaFpHRjZSREJqVm1kSE1ITkdkbGxQVEdsb1EzUk9VVUpKTTB0V2QwTnZiRWxIWlRRM1dFeHZXbU5DZDBkMlRGcEtTbmhqV1RocFRsVjZlVU0zVldod1lTdEpVWHBMZUdsYU1uaFVPV2gwWjFCa2FWQlBkbTFYVldWNVEyd3lSMHBuTm1ZNFZGaGhVVkJ3VjJwUVNqQmxPVk5KSzJSalR6bHdhbFoyVm05NEwwcHBXVkJvYWt0SU9ERkVUVE5TY1VZeFdUSk1NR1p5U21kT1RsUkxSVFo1UlVkNFoyTm5ZbXRxVERWdFZ6WlVXVXBRZUdOYU0wZEtWakU1T1ZKaFdHWm1VMDlZYWpRNFNYUTNWalpWVjBkMU5YZEVZMjl1TnpCSVdFdEdTRWR2VG14aE9VaFBjelJ2VmpCaVptSjBVM3BxVDFsVGMzQnZkVWxOVFUxQlEyRkplRXQyYkdoa01XMUNaazFIYjB0eGVWTmlWMmRxY25Wd1ZtUnZiRGwxZWtsV1pWbHdOVFJaZEZwbEwweHZSVTAwYlhKWWFVZE5Xa3N6YkZCa05USlliemx0Ukhvd016VlBVV0ZhYTFsbGJUZzJRa2Q2WkdkM1NXUlFNa0pJYlV3eE5ERk5XWEJFTDBaWk5HUXZSMlVyVm5wcWF6WnpjMWxXVUZGclUzWXhZbTFyTkV4MVlYTXdjaTloVTIxRGJIZFJjR2RoWjFORFozTm1OWGxoZW5WYVVsbE9jbTFWVDFKMGVDdHNURFJFWVhocVl5dG9kVlpTTTNBdlJVVnZlbkJoZEN0Q01VMTZOemxKZFRBemEwVkVUM0JFV2tSaVRHSldWMkV6YmtwTWFWZFVMMFo0UW5kME5VbG5aSEI0U2t3d1ZYaFBWR2gxWld0UlN6bG9kSEpOY1RKcFdXUTNaRlJSUzJGUFYyTTFXbFJ5YlhJeU5GVjFUaTg1VTNWMGJVUnVUbGxPVDFCSVFrZEhUVTlQTkRFMEt6RlZObkl5TTFBemEyOUVXVVZXVkVZeU9IZG5VMGR3TjJ3cmJXb3hXR3RIWkU5a2VtVklOSG8xUjB0U1NrWjNhSFZOU1ZCVU5VZFZSV0ZuZUhsdmNHUTRiMjlaZVROQlUwcG1kbTlqV0ZOaFNuQTBNRzAxU2pGalVtWlRSR0pMY1RsT2VuRTRjREpxU213NWJ6WXdTWFZXZERkU2RuSnBkbEoySzBaR1ZFeFlVWGxxVjB0eVRFMXZVbUp6TkRkNE9UVnJUbXB1V2pKd2RpOUtZemwySzJoTmVXSXJUVWxsYTBaNVJGUkVaMVl5V1U1blJVaFpZM2szVFdoM01rZGFaRXRrUzBGUlFVOVNWVEJ6Vnl0d1pGRnVhR05WYVhRMVFrUnJNR2hCVlhGNE5sSlVjalEzU3pSVFdtVXpTbk5DUW1aSGVtUnRRWEpFZEZOWlRVVjViazg0Y1VWbGMzaFlZVThyTVRGTGFYYzFaalo1YTNoTmRVRkVWM1p0WjNsb1ZtcENhalpRUmtKbWVuRllVR3BFUWpkM1ZGQmpNR2htV0hsNVJraDNZa1JRTlVaSWQyRlZUV3RQTkhGNlkzSkZUWE5FTDAxMWFrZ3pVa2hWZFZOWmRHRlBjRzlWZEVoNlJYQTFNblJzWkdkcWNVcHRjM1ozV1c4MGJWRkJaV0l6S3k5eWFVb3lRbXQwZUROVFZFczJLMmw2VDFWU1RtZENUQ3RIWVRWSFQwdGtTMWxITXpVNGRYaHNaV3BJWkc1T1duVlFjMmxHVm1OTVVEQXdZazlpWVV0VU5ITTVibFE0Wm5GcGJUZEZXRzQxYm5FeGRXeEdVa28yTTJGWFNYVnpiMjB2UkRWME5FZHJSME5vYUhWc2FGbFVVMDg0Y0ZSa1oxa3JRak0xTVhKeVVreHJPR2d6U1dwdVlTOXZhekJuZVZGWU4zbFRhSGREVFVOck9HaDFhVlJqUnpOTFprWTVkVTV4VVZockwwUnFhVmswY0doSk0ySjZjMEZZYm5KTmVVZHNjMEZHYlc5emQxSmxSMkYzVDFKU1kwZFlRV3hvTDFOWmRURjVMMVJNVFRGRWVsZEhlSGhWVDA1cGNtWkxiMVkwYVZVNVVrcENiV1F6SzJGM1FtY3JaSE5SZEN0a2FteFpkbU5vU205U1RreHdlRXRtUjIxaVFWWndSalJUY2xKd2RuTlVTM1p3VWpabWR5OVpkMUZVUVUxck4yUm9ObFpYTkhaME1VY3lRbkkxUTBoU2IwcDNVSEJZYkRBME1rNXNORVJCVTBNemVVVXdZVWhrVmxaSlF6TTBTM2x6ZURrclRrUlVSbUpRYWxSV2JsbEtWbWx2T0ROd2QxTmpibEIzUVROemQyOWlNM2R4ZFM5VmVHTXpTbnBTYm5aVU1VSmpjWHBDYWtOWlMxVm9ia0UxUTJwQk4yMTNkM0o2Y0U5eVlYbG9VVkZWUWxoU1QzcFBUamRHWjFCemNrcElUVkF5Y0hCNEsySXpZa1kzWXpWSFF5dG5UMjFJV1dGdGVIWkdOa3h0YUhFelMxbEtkVkU0TkRReVoyMVdkVTQwT1dZM1QwWTRRek52YURaaVNqaHlNWEpvYWl0SE4xVm5UbmhCTUhsbU5rRnRiMFJJVFhGd1prZENWRTFaYW00elpuZEdXRGsxUkRoMVUzaG1TM2RQUmtFcmVHaEtZek5zTVZCSU1UWlBabTB5ZGtwRk9XTkRXVmd3VmpkemQyeE5kMDEwT1ZGR2JIa3JPVGM0UmxONFFYVkJhV2h5UkVOV1ZXMWxSVXhUYXpoS2VFMHdhbEVyU2toUFQwTjZXRVJ4TVVkcUt6SjBNR0UxV1dsTGRuWldUV0kyVUZoVWJISlpMMEk0VEVJdloxRTNVVGxFV0RsRllYVmtORFpzYmxvMmVXeFdSMFV4V21sRFVEQjBVbEptZDJsQlFWZ3lNbFkwSzJSaFprMURRbXhrZUU1SmFrRjJkMHh4YldSQkx6VTBiR2h2UTFsdk9VMW9iV280YkhkU2IzUkJhMnRZYUdwQlUyNTZLMFpKVEdkT1JVTnVaa1JYUmxkcVVERXZRblkzV2xKMGFUbDBWV0ZQVTNGeU5YcHBPV0pWY21kc1UxTk5kM1pKVFdGTWFVSkRaRFZ6YkVaWFFYWjFWVEUxZWpOMlkyRnFXVU15WkZwQ2JXUnlVRFJKTW1GRmIxWTRTWEpRWVVwalFWbFViRFZ3TlVGWFQwdE5jamx2Y2s5NmNqRkRhamMwVVhadFJIcE5WVWd3WmpKd1RHRndaM05TTDJoVGVFeDJOVWxrVUVoUFZYQk1jSFZTYTJOTFdrTTRMMU5WUlVrNVQzTlhSbGR2UzNrNFZWVm9ZM3BuYjBJNVJGQmFkbE12VjBnMGRIVXhVWFpZWTBrMWJYQnVRMmhMUWxCMFMyOUdXRkJ0UXpGcVNHbHFSalppV2tSa01sSmFTV3hPTmtwTllWbE1XVmhuU0cxR1NsWndXVGN4Y2tWcFNFVldLMnhuTVRaWlRYbENkV0l3TkdSMVJITk9jVUp1YUd3NWRscHNiMG94VWpCemVsWlZVakJGYUdsaWFUQnlkSE5XUnpOUmQzUjViMjlTVFhaUE5YUkVXbFkzVG0xRE1Tc3paelpyYWs5UE0yeDNPRzVQVjFwWGNVWlVRVll3VEdsc1R6TnlSVFZsUkdsdVYzTlJWelJpTHpKb09EUldOR0pqUkUxSGJtVkROVVZzTURGeFFWcEJjelJqT0RNd1ZHUTRha3hzTjNCNFZtb3dMMWhsTHpjMVltcHRMMHhqYjFocmNsRnFZMFptV0ZaNWJqSjBURGQ0ZGtRclVUWlJRVlZwVkd4MFZtaE5abWsyY0ZKa2FDdHVVR00xVW1wdmFGRm9RMFphWXpneFkwUnplbUl5VmxWR2IyZDBWMWxxVXl0amVrbG1USEZZYlhOMmRtcFNXRTFSUkZoUVlsRXZhVmRCT1ZSbFVFODVkalJQYWxKMldqTlViMkpOVUdRelpWZE9LM1YxUjFwaWRsTnhOM1o1TDJWWGNqZHZlVzl5Um5sdU5YRkdNV0UyTm1oblZ6TTJUMlJ5T0ZCRFltWm5iVTlUUWxsNGFUaFZlVmgyTjB3eU9IVlJiR0U0VEdSc1YyVkdWazk0YkZoWU9VeEZNR2t3Ym1ONGFVdzNhbmhHUmt0UlRXMTFTeXRuV1U1V00wNVhUMk12TlM5VGVFTjVMMnRQUjFFelpYWXdaR2N3Y0ZOeldFSXZkRmhWU21SUlNHMTBOWFJNUW05clMxQnZNR1pxZUVkUlNsbE9NWFpyYUVkSFdURXJhRzR3V0ZBM2FqRktaREl3TXpCTlNXWlJSbXRWT1V0M2FYbGpaaklyV0RJdk9VZFpRbk4yU0ZGYVlqazVOVkZyWldGNlRUSlJTR0o2UW1sa1EwVTNUa0pNTmxoQmN5OVdZWGRQUVZoQ01FUnJSV1ZPYzNWWU1tWXdSelpDVldGRWRGRnlNbVUyVVV3eGFVdERNWE56VkUxaldFNWFiVlk0U2xGdWJUQTJhMmhvV205R1JGZFBSVkpwVDJkUFptOVBPR0pSVVVWaVpXdzFNbEpqY3pOT2QwSjJSVlk1Y3pJeE5VYzNja2xvZDJoeldEWkpORzVSZWxKSE4wc3lRVmwwWW1kc1dVTlRLeXRPVUN0Q01tbDZVV1J1UlVZd1ZEZHBiVlptZERac0wwbDRORlJCYjA1NVVFUklNek5zTlZoQlRtZ3haM2RVY21keVoyeDFUME5VVlc5RVVFeHFObkp2V0ZoR1owMUlNSFpGU0RGdk1TOW1lSFkxU0RGdFpVaGxObFI1ZEV4MmN6TjRiVGRFVGtSc1dVbFhUVXROT0N0TFRHZ3ljVE42TW5sUlVWQjRjV1pTWTJWQ2NFTm1kVVZSZFRkWFJubEViV3hFVTBSVWNYWTBUVTlHYjJnMmVXSmhlVFVyZEhSUFMwSTJSRFJVVURWVldqaGpaR1ZKZUZGWGVVVnpOV3QxUldWYU5tVnhiMU53UnpnemNGVjBlVzlpVGk5MllWZG5kVGw2VGpWM1NXVjZlVXAyTUdOVlpHMHdTRGMwUjNjeWMxTlJiVWxSYVhGUlRuZDRSWFZzVlZod1QxQlFOV1pEVFdKbEwyWlhkWE0xY1hCaFUzUnNOVTV3VWxGSVR5dExaR3cxUkRWRE5WVnlhWEpHVUc5WVNGVnJkREpZU0cxMVRsWlFWalIxY0U1bmJURmxPVXhOTWxobGNUaG9aWE5TTTBoQlprSmxRMmd5YkVaQ2IwTTJOMmN6WWt4V01HeEZRVlp1U2tSSk5HazBSREJ2VGxSdGRuTnRSa1U0TUhoSGNURlNWRlk1YW05MEwyaFJNVlJIUkVvNFRGSllOelpOYmxJdlYxbFNWbEZ4Y0ZGTGFrVjZaRFJ5TTFaMmIzWTNaemxrYkVSalJ6bFBTalZzYlV3eVNraHJRVXh3T0doemREVmpXRzQ0WkVnck5XNDJNVTB4WkVFMVRWUmFXQ3RJTVcxQ2NITnJSek55UTBvNFdTdHhXRTVUVTNKMFl5OHhVSGRxU0doUFJVWTVWMnhNZEV4NU5VUlVkSGhRVUhkMmExZFZibVJWY0VKYWRGRXJSME5hYTFKQ2NHWlBiVFptWWpCT1lYTTFRWGwzZURkUFNtbDFUWE5KU1daME9ESkVkVkI1YmtwTFdHUk5MekZZWlVkS1NURlZSV3RSV2pZNVlrTXlhMmRpT0ROR1YxSnJWa1pLTVZOalR6QkRUMWMzVlhsbVVWRkVaa2NyVTNWcE1ucHphVEphYUU0eldHWlZaRkJYZVdsNE5YTndRbllyZFV3eVpFNUVTMEpuV0ZscVRqa3dSRFEzU3l0dmNHTkdkR2xKYUVOTE1Xa3laMmh6ZFRGRWFFYzBhazg1T1ZkYWVVaG1abnBKSzBJNGNIWk5VRVZ2VEc1c01YTjFhR2cyV2s1ck1XeGxkRmRwY1dKMVdWVTVkVEk1VDBoSFVqUTBkemR6ZFRrM1VWaGhha0p4VDI5QmRuWnFRVzl1ZG1GT1JXaG1LM3BTU0d4VU5qbEJTRWdyWlZOWVpGQjZabEZQV0M5WFJYcDZhRWxIWlhSRmNrMVlVVVpFT1VGMU5uSnhZbEJZU0RJMmRHaHpUa3RhUm1kUFkxZDVaMHBhZFhZMWQxUkVjekJxY1dKVFJWSkNTbFpNTDI5elZEVnVaM2xYSzBGbWMybG5NR0ZPY1RaSWREZFhVVXBLWnk4dlltTmhhbVZvZERSRVRsQjZNRVZTZDNocFp6UXlTell3WlRVNWNHWjZUbVJHUTNsaWVuRkVOM2g2VmxCb1ZuVnVjVkZ4SzA5R2FtVkhURnAzWkZJNVdrSlBVV1ppY3pkNFJuTXpTbFpHZDBSSGNDOXVOMWRvTTFremRFZGFZMmxTTUhZNFFqbHljVWhTWnpoNE5TdGhRa3RXU0Vkd1lqSkhSR0puTTNobU9ERkNSR3RPY0VwWU4zQkZNbUUxVERJMlYxVmpNMDFHT0ZrMFdYSlNUR1IzZDJSNFVWa3pkRUZVUm5SWVIwSXhjRWcwYlc4MGIxbDRMM0pZV1VoaWVUWTNUSFpOZWtoM04waG9TVXBhZHpsc1NscEViRmhDYlU1VldsbDZValV2WW5GNlltUXhSbGhqT0ZoeGREVlBNbGhWTmtaclJqSnhORzh6U1RKSFJFdHJUVVZEUTFKVVZXMVRkemxuVUhWWFRFMTVaVTVCZEhGWGRURkhUVGNyY1RkSVdtMUZRazV0WW1vM05UbFZiVVU1YWpWUVNrMUJjV3B4WjBOWlpYWkdabTV4TDB0NVZrSkRNbUZYWlhWc2F6VjNjRXBJYzBkQ2RFOXVXVnB6WkZCbEt6TnBWbVJ3UzNsa1NrMUxVV2RtTVZVMGVVRjJNVTlIY3pOUE4zbGtaa2xqVlhSWE1XaHphMXBRTDNodk1UWlZhRk5IU1VrdlZ6UnJUWEZaVERaWE4yVnJNMEkyTUhWcGIwdFRkRGxrVWtwQ1puSmhZelk1YldsaGRraERZazR6U0U4MGFFZE9Vbmx6UlZoaGQyVnJRM1pKT1VoV1ZuRnZhbTVXYjBFclUwOHZjbmxCZHk5V1dEVjBaR3BtTUUxRFFXdHFWRTh3UW5sNWRVRTJNMlJhUkROek5GaExPVkJaYlZwUVFWQnVhRkpTY2pKMlVHWTFhRWR3T0RRMmVtdG9kMmM0ZW1KQ2NXOVphbEF5Y2tkTFduWjFhelZ5YTNWMFoxUkhORGw0TWxkcFMxaFFTRmMzWWt0bFpGaHllRzF1T0ZOamVIZGxjVFJVV2padk9IaDNaa1Z4ZVhVd05tdHlZalJWTTJOMWFHOUpiM1pNZDNSSWRteGFWM2N5U2tOT04wMW9ORGxwVVdkVE9WaGpVVzVTV0VRNEwxRjNOR2xUY1dWd1RtaFVhVkJ4Um1NNVVFWmtjWHAxZVhCUk1VbFRNRXBaUVRKTE0yMXBTSGhIV21aV016aFlOVGswU2tOMWQybDZjSFJLZERoRWVtMHlia2hSTldSeUwwaHZhbk5EWmlzNFZFWTNXRWc0WVdkM1pXRnlWSFpCWjFWbWVGcElPRWszYW1ZM1VtcFdXRGg2VG5GNU4wVjJXVEJyTkZwS01URktZMFpKUTJ3eFRERkRiWHBsUTNoUmFrVkhaVXMxUTJWSmVrSTRiRFI1VW1wbVdqQldOM2xMVGtKTVFteGphMWs0Tm1KaWVITlBSU3Q2V0d4WFNuQkNjbGRQWVhGcVQwTnBlVFIwTmxSSGFXcENkVzgxU21abFR6ZENNVWRaWmtaaFZFTktVVFl4ZVhoamJHbGpiazAzVjJOc2EwdGlTR3B4WkhwcWJTdExUV3R0ZWpORmFWaE5SVGxDYWxONFkyMDJjMnBQVTJSR1dYTm1ZbE4zWjBacFExRkdWVkEwUnk5eVkyZzNaejBpTENKdFlXTWlPaUl4WkRJeU9URTFZMlJqWkRCbE56UXdNREZtWkdWaU5qTmhaRGt6Wmpsa05UQXlZVFUwTURFNU5tWmxZamRqWWpjd01ERmxObU5qTW1aaFl6WTFOemsySWl3aWRHRm5Jam9pSW4wPQ==', 1754886746),
('WkqocUrXWopcSVRsvCjeQvsT9M09CKxB5JTimxyE', NULL, '64.62.156.64', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/120.0.6099.28 Safari/537.36', 'ZXlKcGRpSTZJbmhGZEdjelJ6QjNRak42TXpkUGFHaFJOMlpEYVZFOVBTSXNJblpoYkhWbElqb2lWMHB1U2pCNlNUQmFkM1k0UzJFNFJIWjJNRFIyYkdaaVFraDJVbUUyVmxwVVdESjRWekpWVnpFM1pXSklNVWQ0ZG01eWEwTlNkalpoUm1oRlVGZGxSbVp4T0VaV1IxUnpiakpFWmtadVZXMXZjMnRsVVdwSVUwVnVkRTloT0V4bFF6WnlaVUZJTVZCNlVHcHBRVEJDTjJOSGN6ZDZNbXBpU0ROaFRtSTFUek53ZVdkUlZrbHpaVGwwZGxZd1FrWXZXV1ZRTUhKNk9XdGthMjFESzNGamNreHNSbEJMSzFaS1VHZDBOVE12TWxnM2RVeHJXR1poZEV4b2VIUnNSMDlNVGpGblNWWTRXa3MwUkhWeGFFSm9hMGxETkZoaWRUaEhPWGdyUkVwRFZrbzFObk51TXpadlZsaFZjMUJJY1N0dE9VUkZUVzl6VmtWRlJqWlRhbE5rWjFKNGRUQXJaRm95ZERoUFIzWjBNM1pwSzBkdFlsRTlQU0lzSW0xaFl5STZJbUkzTURjek1UVTBNVEk1T1RneE5ETmtPR00xTUdFelpqWTJOemt6T1dRMU1qWmpNakF6WkRaa1lUazBZekptTXpVMFptSTRNVE5oTW1RM09XWmxORGdpTENKMFlXY2lPaUlpZlE9PQ==', 1754888556),
('X3BeA8d3VmMhYt44bKMztzYggRsDYzyTtjfvStsS', NULL, '181.210.15.70', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJalZRTW1kU1RHbG1jMDgzUlRSSWNVRnRVMWhFY0djOVBTSXNJblpoYkhWbElqb2lTRGxqTUhKTFVuTjFkM1JoSzNWc2EyNXpTVnAyZVhjME5VbzFTMXBwV0ZaQ04wRlpkR1UwUmtNMVluVkxSMEZZYlVkWk5GSnVVSHBoUzBwUldWbGlSV3NyY0dWMk16ZDJSek5JYjNaTE4xVk5VMFZuV0ZaTE1VcEdNVkpSUmxaU1duaERNWFZ5TDBGWmRDdERVbWhhVGtGSEt5dGpUVlZtTWt4R1NFMVFkbGx0VUU1TFRVMTRPV2hQVG05YVVEZ3hOVVZTY2s1WGRIZ3JjbTVZZUUwNU1XNWFNVFZHWTBKWmFWcE9PRUY2V0dSWmR5dFlRMWxYWkVaVGJ5OUNiazVMZURGVk9XTkJlV3h4V1RKT1VtNXRhREp3TlhWTFFYaE9WVVF4TlVzM2MxTXlPRTV3U2xjNGVrTkJZMXAxV2tOb01VbFJVM2RZTmxwVFNqUk1MMnBxYTJkSGNGQkJXbXBCVjJwNlQwRXlObTgwU1VJMU5FRTlQU0lzSW0xaFl5STZJakkwWVdJd01qQTRZemN5Wm1aaE9EY3lNMlkxWkRGalpEWXhaRFUwTVdOa05ETTNZekkzWVdFeE1qVmlZamRoTkRJME0ySTRPREJsT0RWaU5qRTJOekFpTENKMFlXY2lPaUlpZlE9PQ==', 1754865138);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `cod_telefono` int NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `cod_persona` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `telefonos`
--

INSERT INTO `telefonos` (`cod_telefono`, `telefono`, `cod_persona`) VALUES
(58, '95921947', 72),
(60, '95921948', 74),
(61, '95921949', 75),
(62, '33814976', 76),
(64, '33948147', 78),
(65, '99846752', 79),
(66, '88945667', 80),
(67, '95998763', 81),
(68, '85552444', 82),
(70, '99325427', 84),
(71, '99325427', 86),
(72, '96696217', 87),
(73, '89906208', 88),
(74, '1', 89),
(76, '96454543', 91),
(81, '98253456', 96),
(84, '93784638', 99),
(85, '12345678', 100),
(88, '88689857', 103),
(92, NULL, 107),
(93, NULL, 108),
(96, '33983737', 111),
(97, '99837635', 112),
(99, '97497264', 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_horario`
--

CREATE TABLE `tipo_horario` (
  `cod_tipo_horario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(23) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo_horario`
--

INSERT INTO `tipo_horario` (`cod_tipo_horario`, `nombre`, `descripcion`) VALUES
(1, 'Día', NULL),
(2, 'Noche', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `cod_tipo_usuario` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`cod_tipo_usuario`, `nombre`) VALUES
(1, 'Interno'),
(2, 'Externo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int NOT NULL,
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
  `cod_empleado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nombre_usuario`, `contrasena`, `estado`, `intentos`, `cod_rol`, `cod_tipo_usuario`, `primer_acceso`, `ip_conexion`, `ip_mac`, `creado_por`, `fecha_registro`, `token_recuperacion`, `expira_token`, `cod_empleado`) VALUES
(22, 'kellyn.castillo623', '$2b$10$n6CQy5GB2LpIj3HV2E4I5uLKdvS.YXyp9D2LjbMKjvDx9mig82RYW', 1, 0, 1, 1, 1, '127.0.0.1', NULL, NULL, '2025-07-06 16:54:20', NULL, NULL, 27),
(25, 'lmolina.479', '$2b$10$lD2KKLUzSYY9xeGZlAmPU.j5esx5PJzozO92XnQY5g/LGWzInfb2i', 1, 0, 1, 1, 0, '127.0.0.1', NULL, 'miguel.garcia063', '2025-07-09 12:43:08', NULL, NULL, 30),
(26, 'jmejia.766', '$2b$10$JGYgjcwRNrbFMPQTrOHH3OTmBeuWo/pIgVNyReSZG81RsYzFXJUiS', 1, 0, 1, 1, 0, '127.0.0.1', NULL, 'lmolina.479', '2025-07-09 20:09:51', NULL, NULL, 31),
(27, 'jsaid.000', '$2b$10$.dASYFURVQWSjEex/oOmnOtqwYlICBCn.FSjxPiGASURMYjHU5q06', 1, 0, 1, 1, 1, '127.0.0.1', NULL, 'lmolina.479', '2025-07-09 20:11:18', NULL, NULL, 32),
(30, 'robando.564', '$2b$10$SmFPjQOrmheqJUSlGiOyDuxN.4L32E4ytsaXkjbS/BvfJmXg9zOUC', 1, 0, 1, 1, 1, '127.0.0.1', NULL, 'mucles.325', '2025-07-24 00:11:45', NULL, NULL, 35),
(32, 'uuu.000', '$2b$10$RbI75z0w6rqHsN65L9EUkuNSfYXEb8506MpcCB5Quoew1mCtPy10m', 1, 0, 1, 1, 1, NULL, NULL, 'miguel.garcia063', '2025-08-01 00:17:47', NULL, NULL, 37),
(39, 'aunah.872', '$2b$10$iJkpev.auY3DjTvI0mzuceDwpQKNYeDStZ1Wmsg8n9yP96VIi4OOq', 1, 0, 1, 1, 1, NULL, NULL, 'miguel.garcia063', '2025-08-10 21:45:11', NULL, NULL, 44),
(40, 'mbarahona.224', '$2b$10$/mQAqy21x76YB6A6doLW4.Ebnc2cli5Z48rIZnXal71p3wcl2VisS', 1, 0, 1, 1, 0, '127.0.0.1', NULL, 'miguel.garcia063', '2025-08-11 01:39:28', NULL, NULL, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_preguntas`
--

CREATE TABLE `usuario_preguntas` (
  `cod_usuario_pregunta` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `cod_pregunta` int NOT NULL,
  `respuesta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario_preguntas`
--

INSERT INTO `usuario_preguntas` (`cod_usuario_pregunta`, `cod_usuario`, `cod_pregunta`, `respuesta`) VALUES
(7, 40, 2, '$2b$10$uJzQwREelHHoQBb67vcyCOG3WvfFwJ0SZkzsBODqY.bOEuashrCjq'),
(8, 40, 6, '$2b$10$7PqcanZbVnAb2DOfQU6Q4utlR8/wlTQ6FGS1iAXlg49H8S7vklbSq'),
(9, 25, 17, '$2b$10$fRmJFy4qlxdZP9pxn7UHDeyaEMCsbMqIIFojdcU8MxqTVhwsv8ZHS'),
(10, 25, 16, '$2b$10$j.XUYaB8suseavc/uVUv/uBYT79.5uT7OW5PmJfPQoPw4fOqoYVgm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificacion_2fa`
--

CREATE TABLE `verificacion_2fa` (
  `cod_usuario` int NOT NULL,
  `codigo` varchar(6) DEFAULT NULL,
  `expira` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `verificacion_2fa`
--

INSERT INTO `verificacion_2fa` (`cod_usuario`, `codigo`, `expira`) VALUES
(22, '726107', '2025-08-08 20:30:40'),
(25, '247449', '2025-08-11 05:38:04'),
(26, '811765', '2025-08-11 04:37:25'),
(27, '134261', '2025-08-07 21:19:52'),
(30, '128788', '2025-07-31 22:01:12'),
(40, '934237', '2025-08-11 01:51:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adicionales`
--
ALTER TABLE `adicionales`
  ADD PRIMARY KEY (`cod_adicional`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cai`
--
ALTER TABLE `cai`
  ADD PRIMARY KEY (`cod_cai`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cliente`),
  ADD KEY `cod_persona` (`cod_persona`);

--
-- Indices de la tabla `correlativos_factura`
--
ALTER TABLE `correlativos_factura`
  ADD PRIMARY KEY (`cod_correlativo`),
  ADD KEY `fk_correlativo_cai` (`cod_cai`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`cod_correo`),
  ADD KEY `cod_persona` (`cod_persona`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`cod_cotizacion`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`cod_departamento`);

--
-- Indices de la tabla `departamento_empresa`
--
ALTER TABLE `departamento_empresa`
  ADD PRIMARY KEY (`cod_departamento_empresa`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`cod_descuento`);

--
-- Indices de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD PRIMARY KEY (`cod_detallecotizacion`),
  ADD KEY `cod_cotizacion` (`cod_cotizacion`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`cod_detalle_factura`),
  ADD KEY `cod_factura` (`cod_factura`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`cod_direccion`),
  ADD KEY `cod_persona` (`cod_persona`),
  ADD KEY `cod_municipio` (`cod_municipio`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`cod_empleado`),
  ADD KEY `cod_persona` (`cod_persona`),
  ADD KEY `cod_departamento_empresa` (`cod_departamento_empresa`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`cod_entrada`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`cod_evento`),
  ADD KEY `cod_cotizacion` (`cod_cotizacion`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`cod_factura`),
  ADD UNIQUE KEY `numero_factura` (`numero_factura`),
  ADD KEY `cod_cliente` (`cod_cliente`),
  ADD KEY `cod_cai` (`cod_cai`),
  ADD KEY `fk_factura_correlativo` (`cod_correlativo`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`cod_inventario`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`cod_libro`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`cod_municipio`),
  ADD KEY `cod_departamento` (`cod_departamento`);

--
-- Indices de la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`cod_objeto`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`cod_paquete`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`cod_permiso`),
  ADD KEY `cod_rol` (`cod_rol`),
  ADD KEY `cod_objeto` (`cod_objeto`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`cod_persona`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `preguntas_recuperacion`
--
ALTER TABLE `preguntas_recuperacion`
  ADD PRIMARY KEY (`cod_pregunta`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`cod_rol`);

--
-- Indices de la tabla `salones`
--
ALTER TABLE `salones`
  ADD PRIMARY KEY (`cod_salon`);

--
-- Indices de la tabla `salon_horario`
--
ALTER TABLE `salon_horario`
  ADD PRIMARY KEY (`cod_salon_horario`),
  ADD KEY `cod_salon` (`cod_salon`),
  ADD KEY `fk_tipo_horario` (`cod_tipo_horario`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`cod_telefono`),
  ADD KEY `cod_persona` (`cod_persona`);

--
-- Indices de la tabla `tipo_horario`
--
ALTER TABLE `tipo_horario`
  ADD PRIMARY KEY (`cod_tipo_horario`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`cod_tipo_usuario`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `cod_empleado` (`cod_empleado`),
  ADD KEY `cod_rol` (`cod_rol`),
  ADD KEY `cod_tipo_usuario` (`cod_tipo_usuario`);

--
-- Indices de la tabla `usuario_preguntas`
--
ALTER TABLE `usuario_preguntas`
  ADD PRIMARY KEY (`cod_usuario_pregunta`),
  ADD KEY `cod_usuario` (`cod_usuario`),
  ADD KEY `cod_pregunta` (`cod_pregunta`);

--
-- Indices de la tabla `verificacion_2fa`
--
ALTER TABLE `verificacion_2fa`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adicionales`
--
ALTER TABLE `adicionales`
  MODIFY `cod_adicional` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cai`
--
ALTER TABLE `cai`
  MODIFY `cod_cai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cod_cliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `correlativos_factura`
--
ALTER TABLE `correlativos_factura`
  MODIFY `cod_correlativo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `cod_correo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `cod_cotizacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `cod_departamento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `departamento_empresa`
--
ALTER TABLE `departamento_empresa`
  MODIFY `cod_departamento_empresa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `cod_descuento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  MODIFY `cod_detallecotizacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `cod_detalle_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `cod_direccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `cod_empleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `cod_entrada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `cod_evento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `cod_factura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `cod_inventario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `cod_libro` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `cod_municipio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT de la tabla `objetos`
--
ALTER TABLE `objetos`
  MODIFY `cod_objeto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `cod_paquete` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `cod_permiso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `cod_persona` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `preguntas_recuperacion`
--
ALTER TABLE `preguntas_recuperacion`
  MODIFY `cod_pregunta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `cod_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `salones`
--
ALTER TABLE `salones`
  MODIFY `cod_salon` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `salon_horario`
--
ALTER TABLE `salon_horario`
  MODIFY `cod_salon_horario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `cod_telefono` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `tipo_horario`
--
ALTER TABLE `tipo_horario`
  MODIFY `cod_tipo_horario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `cod_tipo_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuario_preguntas`
--
ALTER TABLE `usuario_preguntas`
  MODIFY `cod_usuario_pregunta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correlativos_factura`
--
ALTER TABLE `correlativos_factura`
  ADD CONSTRAINT `fk_correlativo_cai` FOREIGN KEY (`cod_cai`) REFERENCES `cai` (`cod_cai`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `correos_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD CONSTRAINT `detalle_cotizacion_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`cod_cotizacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`cod_factura`) REFERENCES `facturas` (`cod_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `direcciones_ibfk_2` FOREIGN KEY (`cod_municipio`) REFERENCES `municipios` (`cod_municipio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`cod_departamento_empresa`) REFERENCES `departamento_empresa` (`cod_departamento_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`cod_cotizacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`cod_cai`) REFERENCES `cai` (`cod_cai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_correlativo` FOREIGN KEY (`cod_correlativo`) REFERENCES `correlativos_factura` (`cod_correlativo`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`cod_departamento`) REFERENCES `departamentos` (`cod_departamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`cod_rol`) REFERENCES `roles` (`cod_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`cod_objeto`) REFERENCES `objetos` (`cod_objeto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salon_horario`
--
ALTER TABLE `salon_horario`
  ADD CONSTRAINT `fk_tipo_horario` FOREIGN KEY (`cod_tipo_horario`) REFERENCES `tipo_horario` (`cod_tipo_horario`) ON DELETE CASCADE,
  ADD CONSTRAINT `salon_horario_ibfk_1` FOREIGN KEY (`cod_salon`) REFERENCES `salones` (`cod_salon`) ON DELETE CASCADE;

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`cod_persona`) REFERENCES `personas` (`cod_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cod_rol`) REFERENCES `roles` (`cod_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`cod_tipo_usuario`) REFERENCES `tipo_usuario` (`cod_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`cod_empleado`) REFERENCES `empleados` (`cod_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_preguntas`
--
ALTER TABLE `usuario_preguntas`
  ADD CONSTRAINT `usuario_preguntas_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`),
  ADD CONSTRAINT `usuario_preguntas_ibfk_2` FOREIGN KEY (`cod_pregunta`) REFERENCES `preguntas_recuperacion` (`cod_pregunta`);

--
-- Filtros para la tabla `verificacion_2fa`
--
ALTER TABLE `verificacion_2fa`
  ADD CONSTRAINT `verificacion_2fa_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
