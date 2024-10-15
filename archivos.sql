-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 18:48:44
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
-- Base de datos: `archivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(6) UNSIGNED NOT NULL,
  `campo1` varchar(50) NOT NULL,
  `campo2` varchar(50) NOT NULL,
  `campo3` varchar(50) NOT NULL,
  `campo4` varchar(50) NOT NULL,
  `archivo1` varchar(255) NOT NULL,
  `archivo2` varchar(255) NOT NULL,
  `archivo3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `campo1`, `campo2`, `campo3`, `campo4`, `archivo1`, `archivo2`, `archivo3`) VALUES
(1, 'nb', 'jhkj', 'lklk', 'lklk', 'uploads/QR1.png', 'uploads/QR2.png', 'uploads/QR1 (1).png'),
(2, 'nb', 'jhkj', 'lklk', 'lklk', 'uploads/MENA2204L1.xlsx', 'uploads/HJHJH.pdf', 'uploads/PRUEBA 1.0.pdf'),
(3, '', '', '', '', 'uploads/', 'uploads/', 'uploads/'),
(4, 'nb', 'jhkj', 'lklk', 'lklk', 'uploads/IMG_20240723_150111.jpg', 'uploads/IMG_20240819_084804.jpg', 'uploads/429688187.pdf'),
(5, 'KIJHOLIJ', 'LK', 'LKJ', 'JI', 'uploads/Gráfico de línea de tiempo timeline flujo progreso de proyecto o empresa histórico evolución moderno multicolor.png', 'uploads/embarque.png', 'uploads/Cuadro Comparativo de Tipos de Emprendedores.pdf'),
(6, '', '', '', '', 'uploads/', 'uploads/', 'uploads/');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
