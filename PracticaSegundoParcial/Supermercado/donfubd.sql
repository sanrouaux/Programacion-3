-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2017 a las 04:01:44
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `donfubd`
--
CREATE DATABASE IF NOT EXISTS `donfubd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `donfubd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `foto` varchar(30) NOT NULL,
  `legajo` int(11) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `perfil` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `email`, `foto`, `legajo`, `clave`, `perfil`) VALUES
(1, 'Pedro', 'Gonzalez', 'pedrogonzalez@gmail.com', 'fotopedro.jpg', 62544, '57842', 'user'),
(3, 'diego', 'galvan', 'diegogalvan@gmail.com', '195623.jpg ', 62757, '1234', 'admin'),
(4, 'Federico', 'Thompson', 'federicothompson@gmail.com', '210546.jpg ', 62758, '3214', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`) VALUES
(1, 'disco rigido 5tb', 4900),
(3, 'placa de video', 4500),
(4, 'memoria ram 4gb', 600),
(5, 'lectograbadora dvd', 300),
(10, 'gabinete full tower', 3000),
(15, 'Cooler fan', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tokens`
--

INSERT INTO `tokens` (`id`, `token`) VALUES
(3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOiIyMDE3LTExLTE2IDAwOjAwOjI3IiwiYXVkIjoiOWZmNGY4NjM0MzRlM2VmYzYxMzIyNDhhMGNhMmViNzc4ZjYyNjZkNCIsImRhdGEiOnsidmFsaWRvIjoidHJ1ZSIsInVzdWFyaW8iOnsiaWQiOiIzIiwibm9tYnJlIjoiZGllZ28iLCJhcGVsbGlkbyI6ImdhbHZhbiIsImVtYWlsIjoiZGllZ29nYWx2YW5AZ21haWwuY29tIiwiZm90byI6IjE5NTYyMy5qcGcgIiwibGVnYWpvIjo2Mjc1NywiY2xhdmUiOiIxMjM0IiwicGVyZmlsIjoiYWRtaW4ifX0sImFwcCI6IkFQSSBSRVNUIDIwMTcifQ.sZMrKP3t-PnIh8YprcwnrCz3BsbTh-JUg3GDEFsPKrQ');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
