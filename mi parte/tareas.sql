-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2026 a las 19:17:12
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
-- Base de datos: `tareas`
--

-- -CREATE DATABASE IF NOT EXISTS `tareaas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tareas`;
-------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `materia` varchar(50) DEFAULT 'General',
  `tipo` varchar(50) DEFAULT 'Tarea',
  `descripcion` text DEFAULT NULL,
  `prioridad` varchar(20) DEFAULT 'Media',
  `fecha` date DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `titulo`, `materia`, `tipo`, `descripcion`, `prioridad`, `fecha`, `estado`) VALUES
(5, 'Tarea de lengiaje', 'General', 'Tarea', '3333332', 'Media', '2026-04-10', 0),
(6, 'Tarea de ciencias', 'Ciencias', 'Proyecto', '', 'Media', '2026-04-10', 0),
(7, 'rrrrrrrrr', 'Matemáticas', 'Tarea', '', 'Alta', '2026-04-10', 0),
(8, 'iii', 'Matemáticas', 'Tarea', '', 'Baja', '2026-04-10', 0),
(9, 'Investigacion', 'Historia', 'Tarea', 'leer desde la pagina 12 hasta la 87', 'Alta', '2026-04-12', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
