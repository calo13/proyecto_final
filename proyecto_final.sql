-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2024 a las 16:36:33
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
-- Base de datos: `proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_baremos_epqa`
--

CREATE TABLE `psi_baremos_epqa` (
  `bare_id` int(11) NOT NULL,
  `bare_sexo` varchar(1) DEFAULT NULL,
  `bare_percentiles` int(11) DEFAULT NULL,
  `bare_n` int(11) DEFAULT NULL,
  `bare_e` int(11) DEFAULT NULL,
  `bare_p` int(11) DEFAULT NULL,
  `bare_s` int(11) DEFAULT NULL,
  `bare_test_id` int(11) DEFAULT NULL,
  `bare_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_baremos_iac`
--

CREATE TABLE `psi_baremos_iac` (
  `pd_id` int(11) NOT NULL,
  `pd_pc` int(11) DEFAULT NULL,
  `pd_personal` int(11) DEFAULT NULL,
  `pd_familiar` int(11) DEFAULT NULL,
  `pd_escolar` int(11) DEFAULT NULL,
  `pd_social` int(11) DEFAULT NULL,
  `pd_global` int(11) DEFAULT NULL,
  `pd_s` int(11) DEFAULT NULL,
  `pd_test_id` int(11) DEFAULT NULL,
  `pd_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_candidato`
--

CREATE TABLE `psi_candidato` (
  `cand_id` int(11) NOT NULL,
  `cand_primer_nombre` varchar(50) DEFAULT NULL,
  `cand_segundo_nombre` varchar(50) DEFAULT NULL,
  `cand_primer_apellido` varchar(50) DEFAULT NULL,
  `cand_segundo_apellido` varchar(50) DEFAULT NULL,
  `cand_sexo` varchar(1) DEFAULT NULL,
  `cand_fecha_nacimiento` date DEFAULT NULL,
  `cand_fecha_evaluacion` date DEFAULT curdate(),
  `cand_fecha_evaluacion_terminada` date DEFAULT NULL,
  `cand_time` time DEFAULT NULL,
  `cand_centro` varchar(15) DEFAULT 'ETMA',
  `cand_estado` varchar(250) NOT NULL,
  `cand_conclusion` varchar(30) DEFAULT 'PENDIENTE',
  `cand_test_id` int(11) DEFAULT NULL,
  `cand_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_preguntas_epqa`
--

CREATE TABLE `psi_preguntas_epqa` (
  `pregunta_id` int(11) NOT NULL,
  `pregunta_pregunta` varchar(255) DEFAULT NULL,
  `pregunta_tipo` varchar(10) DEFAULT NULL,
  `pregunta_respuesta` int(11) DEFAULT NULL,
  `pregunta_situacion` smallint(6) DEFAULT 1,
  `pregunta_test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_preguntas_iac`
--

CREATE TABLE `psi_preguntas_iac` (
  `pregunta_id` int(11) NOT NULL,
  `pregunta_pregunta` varchar(255) DEFAULT NULL,
  `pregunta_tipo` varchar(10) DEFAULT NULL,
  `pregunta_respuesta` int(11) DEFAULT NULL,
  `pregunta_situacion` smallint(6) DEFAULT 1,
  `pregunta_test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_respuestas`
--

CREATE TABLE `psi_respuestas` (
  `res_id` int(11) NOT NULL,
  `res_cand_id` int(11) DEFAULT NULL,
  `res_test_id` int(11) DEFAULT NULL,
  `res_pregunta_id` int(11) DEFAULT NULL,
  `res_respuesta` int(11) DEFAULT NULL,
  `res_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psi_test`
--

CREATE TABLE `psi_test` (
  `test_id` int(11) NOT NULL,
  `test_nombre` varchar(50) DEFAULT NULL,
  `test_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `psi_test`
--

INSERT INTO `psi_test` (`test_id`, `test_nombre`, `test_situacion`) VALUES
(1, 'IAC', 1),
(2, 'EPQ-A', 1),
(3, 'QAP', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(50) DEFAULT NULL,
  `rol_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol_nombre`, `rol_situacion`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'CANDIDATOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_nombre` varchar(50) DEFAULT NULL,
  `usu_dpi` int(11) DEFAULT NULL,
  `usu_password` varchar(255) DEFAULT NULL,
  `usu_email` varchar(255) DEFAULT NULL,
  `usu_telefono` varchar(15) DEFAULT NULL,
  `usu_rol` int(11) DEFAULT NULL,
  `usu_situacion` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `psi_baremos_epqa`
--
ALTER TABLE `psi_baremos_epqa`
  ADD PRIMARY KEY (`bare_id`),
  ADD KEY `bare_test_id` (`bare_test_id`);

--
-- Indices de la tabla `psi_baremos_iac`
--
ALTER TABLE `psi_baremos_iac`
  ADD PRIMARY KEY (`pd_id`),
  ADD KEY `pd_test_id` (`pd_test_id`);

--
-- Indices de la tabla `psi_candidato`
--
ALTER TABLE `psi_candidato`
  ADD PRIMARY KEY (`cand_id`),
  ADD KEY `cand_test_id` (`cand_test_id`);

--
-- Indices de la tabla `psi_preguntas_epqa`
--
ALTER TABLE `psi_preguntas_epqa`
  ADD PRIMARY KEY (`pregunta_id`),
  ADD KEY `pregunta_test_id` (`pregunta_test_id`);

--
-- Indices de la tabla `psi_preguntas_iac`
--
ALTER TABLE `psi_preguntas_iac`
  ADD PRIMARY KEY (`pregunta_id`),
  ADD KEY `pregunta_test_id` (`pregunta_test_id`);

--
-- Indices de la tabla `psi_respuestas`
--
ALTER TABLE `psi_respuestas`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `res_cand_id` (`res_cand_id`),
  ADD KEY `res_test_id` (`res_test_id`),
  ADD KEY `res_pregunta_id` (`res_pregunta_id`);

--
-- Indices de la tabla `psi_test`
--
ALTER TABLE `psi_test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`),
  ADD UNIQUE KEY `usu_nombre` (`usu_nombre`),
  ADD UNIQUE KEY `usu_dpi` (`usu_dpi`),
  ADD UNIQUE KEY `usu_email` (`usu_email`),
  ADD KEY `usu_rol` (`usu_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `psi_baremos_epqa`
--
ALTER TABLE `psi_baremos_epqa`
  MODIFY `bare_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `psi_baremos_iac`
--
ALTER TABLE `psi_baremos_iac`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `psi_candidato`
--
ALTER TABLE `psi_candidato`
  MODIFY `cand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `psi_preguntas_epqa`
--
ALTER TABLE `psi_preguntas_epqa`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `psi_preguntas_iac`
--
ALTER TABLE `psi_preguntas_iac`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `psi_respuestas`
--
ALTER TABLE `psi_respuestas`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `psi_test`
--
ALTER TABLE `psi_test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `psi_baremos_epqa`
--
ALTER TABLE `psi_baremos_epqa`
  ADD CONSTRAINT `psi_baremos_epqa_ibfk_1` FOREIGN KEY (`bare_test_id`) REFERENCES `psi_test` (`test_id`);

--
-- Filtros para la tabla `psi_baremos_iac`
--
ALTER TABLE `psi_baremos_iac`
  ADD CONSTRAINT `psi_baremos_iac_ibfk_1` FOREIGN KEY (`pd_test_id`) REFERENCES `psi_test` (`test_id`);

--
-- Filtros para la tabla `psi_candidato`
--
ALTER TABLE `psi_candidato`
  ADD CONSTRAINT `psi_candidato_ibfk_1` FOREIGN KEY (`cand_test_id`) REFERENCES `psi_test` (`test_id`);

--
-- Filtros para la tabla `psi_preguntas_epqa`
--
ALTER TABLE `psi_preguntas_epqa`
  ADD CONSTRAINT `psi_preguntas_epqa_ibfk_1` FOREIGN KEY (`pregunta_test_id`) REFERENCES `psi_test` (`test_id`);

--
-- Filtros para la tabla `psi_preguntas_iac`
--
ALTER TABLE `psi_preguntas_iac`
  ADD CONSTRAINT `psi_preguntas_iac_ibfk_1` FOREIGN KEY (`pregunta_test_id`) REFERENCES `psi_test` (`test_id`);

--
-- Filtros para la tabla `psi_respuestas`
--
ALTER TABLE `psi_respuestas`
  ADD CONSTRAINT `psi_respuestas_ibfk_1` FOREIGN KEY (`res_cand_id`) REFERENCES `psi_candidato` (`cand_id`),
  ADD CONSTRAINT `psi_respuestas_ibfk_2` FOREIGN KEY (`res_test_id`) REFERENCES `psi_test` (`test_id`),
  ADD CONSTRAINT `psi_respuestas_ibfk_3` FOREIGN KEY (`res_pregunta_id`) REFERENCES `psi_preguntas_epqa` (`pregunta_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`usu_rol`) REFERENCES `rol` (`rol_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
