-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2019 a las 02:26:10
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `merceriabd`
--
CREATE DATABASE IF NOT EXISTS `merceriabd` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `merceriabd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medias`
--

CREATE TABLE `medias` (
  `ID` int(11) NOT NULL,
  `color` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `precio` float NOT NULL,
  `talle` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medias`
--

INSERT INTO `medias` (`ID`, `color`, `marca`, `precio`, `talle`) VALUES
(1, 'rojo', 'adidas', 80, 3),
(2, 'azul', 'nike', 110.5, 2.5),
(5, 'rosa', 'Yuliana', 60, 4),
(6, 'rosa', 'hilfiger', 200, 2),
(7, 'negro', 'Nike', 280, 4),
(9, 'violeta', 'puma', 130, 1),
(10, 'azul', 'olorin', 200, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `perfil` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(80) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `correo`, `clave`, `nombre`, `apellido`, `perfil`, `foto`) VALUES
(5, 'santiago@mail.com', '1234', 'Santiago', 'Rouaux', 'administrador', './fotos/190849.jpg'),
(12, 'matias@mail.com', '1234', 'Matias', 'Rouaux', 'propietario', './fotos/142839.jpg'),
(16, 'martin@mail.com', '1234', 'Martin', 'Rouaux', 'propietario', './fotos/143629.jpg'),
(17, 'lucia@mail.com', '1234', 'Lucia', 'Rouaux', 'propietario', './fotos/143652.jpg'),
(18, 'guillermina@mail.com', '1234', 'Guillermina', 'Rouaux', 'propietario', './fotos/143743.jpg'),
(20, 'juan@mail.com', '1111', 'Juan', 'Oliverio', 'empleado', './fotos/021950.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medias`
--
ALTER TABLE `medias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
