-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2025 a las 06:51:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `conexion_vocacional`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `usuario` varchar(10) NOT NULL,
  `password_hash` varchar(50) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`usuario`, `password_hash`, `nombre_completo`, `activo`) VALUES
('admin', 'admin123', 'Frank', 1),
('admin', 'admin123', 'Frank', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colegios`
--

CREATE TABLE `colegios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colegios`
--

INSERT INTO `colegios` (`id`, `nombre`, `direccion`, `ciudad`, `activo`, `fecha_creacion`) VALUES
(1, 'I.E Fabio Vásquez', 'Calle 123 #45-67', 'Dosquebradas', 1, '2025-09-17 06:35:55'),
(2, 'I.E Cristo Rey', 'Avenida Principal #100-23', 'Dosquebradas', 1, '2025-09-17 06:35:55'),
(3, 'I.E Santa Sofia', 'Carrera 56 #78-90', 'Dosquebradas', 1, '2025-09-17 06:35:55'),
(4, 'I.E Agustín Nieto Caballero', 'Calle 123 #45-67', 'Dosquebradas', 1, '2025-09-17 06:36:35'),
(5, 'I.E Empresarial', 'Avenida Principal #100-23', 'Dosquebradas', 1, '2025-09-17 06:36:35'),
(6, 'I.E Juan Manuel González', 'Carrera 56 #78-90', 'Dosquebradas', 1, '2025-09-17 06:36:35'),
(7, 'I.E Los Andes', NULL, NULL, 1, '2025-09-22 15:13:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `grado` varchar(10) NOT NULL,
  `colegio_id` varchar(100) NOT NULL,
  `nombre_contacto` varchar(100) NOT NULL,
  `telefono_contacto` varchar(20) NOT NULL,
  `programa_1` int(11) NOT NULL,
  `programa_2` int(11) NOT NULL,
  `programa_3` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre_completo`, `documento`, `correo`, `telefono`, `grado`, `colegio_id`, `nombre_contacto`, `telefono_contacto`, `programa_1`, `programa_2`, `programa_3`, `fecha_registro`) VALUES
(12, 'juan', NULL, 'beltrananderson283@gmail.com', '322', '9', 'Colegio 3', 'kk', 'll', 7, 5, 8, '2025-09-09 05:32:15'),
(13, 'juan', NULL, 'beltrananderson283@gmail.com', '322', '9', 'Colegio 3', 'kk', 'll', 7, 5, 8, '2025-09-09 05:32:17'),
(14, 'juan', NULL, 'beltrananderson283@gmail.com', '322', '9', 'Colegio 3', 'kk', 'll', 7, 5, 8, '2025-09-09 05:32:19'),
(15, 'lore', NULL, 'faberprueba@gmail.com', '3221233', '9', 'Colegio 2', 'lula', '1244', 6, 8, 7, '2025-09-09 05:34:06'),
(16, 'juan', NULL, 'admin@sistema.com', '3221233', '9', 'Colegio 4', 'lula', '1244', 7, 8, 4, '2025-09-09 05:46:32'),
(17, 'juan', NULL, 'faberprueba@gmail.com', '3221233', '9', 'Colegio 2', 'lula', '1244', 7, 8, 6, '2025-09-16 15:01:33'),
(19, 'jj', '1088352967', '', '3206533267', '7°', '5', 'po', '342', 0, 0, 0, '2025-09-18 16:29:19'),
(20, 'juan', '456', '', '3206533267', '8°', '3', 'yasmin', '1234', 0, 0, 0, '2025-09-18 16:33:44'),
(21, 'juan', '4567', '', '3206533267', '8°', '3', 'yasmin', '1234', 0, 0, 0, '2025-09-18 16:35:27'),
(22, 'yasmin', '1234567', '', '3206533267', '10°', '4', 'yasmin', '342', 0, 0, 0, '2025-09-18 16:39:07'),
(23, 'yasmin', '12345670', '', '3206533267', '9A', '4', 'yasmin', '342', 0, 0, 0, '2025-09-18 16:42:08'),
(24, 'samuel', '123456', '', '44', '9C', '2', 'sfasd', 'dsfads', 0, 0, 0, '2025-09-18 18:39:34'),
(25, 'german', '10130789', '', '3206533267', '6°', '2', 'sfasd', '1234', 0, 0, 0, '2025-09-22 14:37:05'),
(26, 'julian', '10101010', '', '3206533267', '9D', '1', 'manuela', '1234', 0, 0, 0, '2025-09-22 15:27:56'),
(27, 'juan', '123456709', '', '44', '9A', '1', 'manuela2', '1234', 0, 0, 0, '2025-09-22 15:29:53'),
(28, 'juan', '123456799', '', '3206533267', '7°', '4', 'sfasd', '3423', 0, 0, 0, '2025-09-23 22:01:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preferencias`
--

CREATE TABLE `preferencias` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL CHECK (`prioridad` between 1 and 3),
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preferencias`
--

INSERT INTO `preferencias` (`id`, `estudiante_id`, `programa_id`, `prioridad`, `fecha_registro`) VALUES
(1, 19, 1, 1, '2025-09-18 16:29:19'),
(2, 19, 4, 2, '2025-09-18 16:29:19'),
(3, 19, 5, 3, '2025-09-18 16:29:19'),
(4, 20, 2, 1, '2025-09-18 16:33:44'),
(5, 20, 3, 2, '2025-09-18 16:33:44'),
(6, 20, 4, 3, '2025-09-18 16:33:44'),
(7, 21, 2, 1, '2025-09-18 16:35:27'),
(8, 21, 3, 2, '2025-09-18 16:35:27'),
(9, 21, 4, 3, '2025-09-18 16:35:27'),
(10, 22, 1, 1, '2025-09-18 16:39:07'),
(11, 22, 2, 2, '2025-09-18 16:39:07'),
(12, 22, 3, 3, '2025-09-18 16:39:07'),
(13, 23, 1, 1, '2025-09-18 16:42:08'),
(14, 23, 2, 2, '2025-09-18 16:42:08'),
(15, 23, 3, 3, '2025-09-18 16:42:08'),
(16, 24, 1, 1, '2025-09-18 18:39:34'),
(17, 24, 2, 2, '2025-09-18 18:39:34'),
(18, 24, 3, 3, '2025-09-18 18:39:34'),
(19, 25, 1, 1, '2025-09-22 14:37:05'),
(20, 25, 3, 2, '2025-09-22 14:37:05'),
(21, 25, 4, 3, '2025-09-22 14:37:05'),
(22, 26, 1, 1, '2025-09-22 15:27:56'),
(23, 26, 5, 2, '2025-09-22 15:27:56'),
(24, 26, 3, 3, '2025-09-22 15:27:56'),
(25, 27, 1, 1, '2025-09-22 15:29:53'),
(26, 27, 5, 2, '2025-09-22 15:29:53'),
(27, 27, 2, 3, '2025-09-22 15:29:53'),
(28, 28, 11, 1, '2025-09-23 22:01:06'),
(29, 28, 10, 2, '2025-09-23 22:01:06'),
(30, 28, 15, 3, '2025-09-23 22:01:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `nombre`, `descripcion`, `imagen`, `activo`, `fecha_creacion`) VALUES
(1, 'Técnico Programación de Aplicaciones para Dispositivos Móviles.', 'Implementación de bases de datos.\r\n• Desarrollo de aplicaciones móviles \r\nhibridas.\r\n• Construcción de algoritmos en \r\nsoluciones software.\r\n• Desarrollo de aplicaciones móviles \r\nnativas.\r\n• Aplicar el enfoque de la programación \r\norientada a objetos.\r\n• Construcción de requisitos del software', 'img_programas/programacion_movil.png', 1, '2025-09-18 15:51:50'),
(2, 'Técnico Programación para Analítica de Datos', 'Formación en Analítica de Datos', 'img_programas/analitica_datos.png', 1, '2025-09-18 15:51:50'),
(3, 'Técnico Soporte de Topografia y Georeferenciación', 'Formación en Topografía', 'img_programas/topografia.png', 1, '2025-09-18 15:51:50'),
(4, 'Técnico en Pintura Arquitectónica y Acabados Especiales', 'Formación en Pintura y Acabados', 'img_programas/pintura.png', 1, '2025-09-18 15:51:50'),
(5, 'Técnico en Mantenimiento e Instalación de Sistemas Solares Fotovoltaicos', 'Formación en Instalación Sistemas Solares', 'img_programas/fotovoltaico.png', 1, '2025-09-18 15:51:50'),
(6, 'Técnico Mantenimiento de Vehículos Livianos', 'Mantenimiento Vehiculos', 'img_programas/vehiculos.png', 1, '2025-09-22 15:53:35'),
(7, 'Técnico Mantenimiento de Motocicletas y Motocarros', 'Mantenimiento Motocicletas', 'img_programas/motos.png', 1, '2025-09-22 15:53:35'),
(8, 'Técnico Implementación y Mantenimiento de Sistemas de Internet de Las Cosas', 'Internet de las Cosas', 'img_programas/internet_cosas.png', 1, '2025-09-22 15:53:35'),
(9, 'Técnico Dibujo Mecánico', 'Dibujo Mecánico', 'img_programas/dibujo.png', 1, '2025-09-22 16:05:24'),
(10, 'Técnico en Agrotrónica', 'Agrotrónica', 'img_programas/agrotronica.png', 1, '2025-09-22 16:05:24'),
(11, 'Técnico en Venta de Productos en Línea', 'Productos en Línea', 'img_programas/productos_linea.png', 1, '2025-09-22 16:05:24'),
(12, 'Técnico en Recursos Humanos', 'Recursos Humanos', 'img_programas/recursos_humanos.png', 1, '2025-09-22 16:05:24'),
(13, 'Técnico Promoción  de Contenidos en Medios Digitales', 'Medios Digitales', 'img_programas/contenidos_digitales.png', 1, '2025-09-22 16:05:24'),
(14, 'Técnico Operaciones de Comercio Exterior', 'Comercio Exterior', 'img_programas/comercio_exterior.png', 1, '2025-09-22 16:05:24'),
(15, 'Técnico Nómina y Prestaciones Sociales', 'Nómina y Prestaciones', 'img_programas/nomina.png', 1, '2025-09-22 16:05:24'),
(16, 'Técnico Cocina', 'Cocina', 'img_programas/cocina.png', 1, '2025-09-22 16:05:24'),
(17, 'Técnico Asistencia en Organización de Archivos', 'Organización de Archivos', 'img_programas/asis_archivos.png', 1, '2025-09-22 16:05:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colegios`
--
ALTER TABLE `colegios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preferencias`
--
ALTER TABLE `preferencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estudiante_id` (`estudiante_id`,`programa_id`),
  ADD UNIQUE KEY `estudiante_id_2` (`estudiante_id`,`prioridad`),
  ADD KEY `programa_id` (`programa_id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colegios`
--
ALTER TABLE `colegios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `preferencias`
--
ALTER TABLE `preferencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `preferencias`
--
ALTER TABLE `preferencias`
  ADD CONSTRAINT `preferencias_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `preferencias_ibfk_2` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
