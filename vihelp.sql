-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2024 a las 03:33:08
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
-- Base de datos: `vihelp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `clave_cita` int(11) NOT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `lugar_cita` varchar(100) DEFAULT NULL,
  `indi_cita` varchar(100) DEFAULT NULL,
  `Usuarios_clave_us` int(11) NOT NULL,
  `iddoctor` int(11) DEFAULT NULL,
  `claveAdmin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`clave_cita`, `fecha_cita`, `lugar_cita`, `indi_cita`, `Usuarios_clave_us`, `iddoctor`, `claveAdmin`) VALUES
(1, '2024-04-08 08:47:00', 'Av. Chimalhuacán #456,57000,Col Benito Juárez, Nezahualcóyotl, Edo de México', 'no hay', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citatratamiento`
--

CREATE TABLE `citatratamiento` (
  `idcitaTratamiento` int(11) NOT NULL,
  `fecha_citaTratamiento` datetime DEFAULT NULL,
  `numeroCita` int(11) DEFAULT NULL,
  `claveMedicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `citatratamiento`
--

INSERT INTO `citatratamiento` (`idcitaTratamiento`, `fecha_citaTratamiento`, `numeroCita`, `claveMedicina`) VALUES
(1, '2024-04-07 02:47:05', 1, 1),
(2, '2024-04-07 08:43:26', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `iddoctor` int(11) NOT NULL,
  `nombre_doc` varchar(45) DEFAULT NULL,
  `apellidos_doc` varchar(45) DEFAULT NULL,
  `cedula_doc` varchar(45) DEFAULT NULL,
  `genero_doc` varchar(45) DEFAULT NULL,
  `institucion` varchar(45) DEFAULT NULL,
  `telefono_doc` varchar(45) DEFAULT NULL,
  `foto_doc` varchar(200) DEFAULT NULL,
  `correo_doc` varchar(45) DEFAULT NULL,
  `contrasena_doc` varchar(200) DEFAULT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`iddoctor`, `nombre_doc`, `apellidos_doc`, `cedula_doc`, `genero_doc`, `institucion`, `telefono_doc`, `foto_doc`, `correo_doc`, `contrasena_doc`, `tipoUsuario`) VALUES
(1, 'doctor', 'doctor', 'doctor', 'doctor', 'UNAM', '1234567890', './view/assets/img/xmenderechop.jpg', 'doctor@doctor.com', '6520f6309492a8390d4e41975529397d86e7f36742cd43a584f8e3624fd5c2ec097fad100e72676367c28748508366cf94b254790e9e53c27d033cc178cdcf56', 2),
(2, 'Juan', 'Perez Gomez', '56S4D65A4D5', 'Masculino', 'IPN', '1234567890', './view/assets/img/VIH1.png', 'doctor@gmail.com', '6520f6309492a8390d4e41975529397d86e7f36742cd43a584f8e3624fd5c2ec097fad100e72676367c28748508366cf94b254790e9e53c27d033cc178cdcf56', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formamedica`
--

CREATE TABLE `formamedica` (
  `idformaMedica` int(11) NOT NULL,
  `forma_medicina` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `formamedica`
--

INSERT INTO `formamedica` (`idformaMedica`, `forma_medicina`) VALUES
(1, 'Tableta'),
(2, 'Capsula');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `clave_med` int(11) NOT NULL,
  `idmedicina` int(11) DEFAULT NULL,
  `idformaMedica` int(11) DEFAULT NULL,
  `dosis_med` varchar(45) DEFAULT NULL,
  `fre_med` int(11) DEFAULT NULL,
  `idviaMedica` int(11) DEFAULT NULL,
  `duracion_med` int(11) DEFAULT NULL,
  `indicacion_med` varchar(100) DEFAULT NULL,
  `fecha_med` datetime DEFAULT NULL,
  `fecharegistroMed` datetime DEFAULT NULL,
  `claveAdmin` int(11) DEFAULT NULL,
  `Usuarios_clave_us` int(11) NOT NULL,
  `iddoctor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`clave_med`, `idmedicina`, `idformaMedica`, `dosis_med`, `fre_med`, `idviaMedica`, `duracion_med`, `indicacion_med`, `fecha_med`, `fecharegistroMed`, `claveAdmin`, `Usuarios_clave_us`, `iddoctor`) VALUES
(1, 1, 1, '12gr', 12, 1, 2, 'no hay', '2024-04-07 19:28:00', '2024-04-07 02:47:05', 1, 2, NULL),
(2, 2, 2, '10gr', 4, 1, 2, 'no hay', '2024-04-07 08:46:00', '2024-04-07 08:43:26', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicina`
--

CREATE TABLE `medicina` (
  `idmedicina` int(11) NOT NULL,
  `nombre_med` varchar(45) DEFAULT NULL,
  `descripcion_med` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `medicina`
--

INSERT INTO `medicina` (`idmedicina`, `nombre_med`, `descripcion_med`) VALUES
(1, 'Clonazepam', 'Ta potente'),
(2, 'Penicilina', 'Antibiotico'),
(3, 'Ketorolaco', 'Para el dolor'),
(4, 'Amoxicilina', 'Antibiotico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacioncitas`
--

CREATE TABLE `notificacioncitas` (
  `idnotificacionCitas` int(11) NOT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `claveCita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notificacioncitas`
--

INSERT INTO `notificacioncitas` (`idnotificacionCitas`, `fecha_cita`, `claveCita`) VALUES
(7, '2024-04-07 08:47:00', 1),
(8, '2024-04-07 12:47:00', 1),
(9, '2024-04-07 16:47:00', 1),
(10, '2024-04-07 20:47:00', 1),
(11, '2024-04-08 00:47:00', 1),
(12, '2024-04-08 04:47:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionmedicina`
--

CREATE TABLE `notificacionmedicina` (
  `idnotificacionMedicina` int(11) NOT NULL,
  `fecha_toma` datetime DEFAULT NULL,
  `fecha_aplazada` varchar(3) DEFAULT NULL,
  `med_tomado` varchar(3) DEFAULT NULL,
  `claveMedicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notificacionmedicina`
--

INSERT INTO `notificacionmedicina` (`idnotificacionMedicina`, `fecha_toma`, `fecha_aplazada`, `med_tomado`, `claveMedicina`) VALUES
(5, '2024-04-07 08:51:00', '2', '2', 2),
(6, '2024-04-07 12:46:00', '1', '1', 2),
(7, '2024-04-07 16:46:00', '1', '1', 2),
(8, '2024-04-07 20:46:00', '1', '1', 2),
(9, '2024-04-08 00:46:00', '1', '1', 2),
(10, '2024-04-08 04:46:00', '1', '1', 2),
(11, '2024-04-08 08:46:00', '1', '1', 2),
(12, '2024-04-08 12:46:00', '1', '1', 2),
(13, '2024-04-08 16:46:00', '1', '1', 2),
(14, '2024-04-08 20:46:00', '1', '1', 2),
(15, '2024-04-09 00:46:00', '1', '1', 2),
(16, '2024-04-09 04:46:00', '1', '1', 2),
(49, '2024-04-07 19:28:00', '1', '1', 1),
(50, '2024-04-08 07:28:00', '1', '1', 1),
(51, '2024-04-08 19:28:00', '1', '1', 1),
(52, '2024-04-09 07:28:00', '1', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idtipoUsuario` int(11) NOT NULL,
  `tipo_us` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idtipoUsuario`, `tipo_us`) VALUES
(1, 'paciente'),
(2, 'doctor'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `clave_us` int(11) NOT NULL,
  `nombre_us` varchar(50) DEFAULT NULL,
  `apellidos_us` varchar(50) DEFAULT NULL,
  `genero_us` varchar(45) DEFAULT NULL,
  `telefono_us` varchar(50) DEFAULT NULL,
  `correo_us` varchar(50) DEFAULT NULL,
  `contrasena_us` varchar(200) DEFAULT NULL,
  `foto_us` varchar(200) DEFAULT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`clave_us`, `nombre_us`, `apellidos_us`, `genero_us`, `telefono_us`, `correo_us`, `contrasena_us`, `foto_us`, `tipoUsuario`) VALUES
(1, 'admin', 'admin', 'ADMIN', '1234567890', 'admin@admin.com', '6520f6309492a8390d4e41975529397d86e7f36742cd43a584f8e3624fd5c2ec097fad100e72676367c28748508366cf94b254790e9e53c27d033cc178cdcf56', './view/assets/img/xmenderechop.jpg', 3),
(2, 'Julio Yael', 'Acosta Gonzalez', NULL, '1234567890', 'paciente@paciente.com', '6520f6309492a8390d4e41975529397d86e7f36742cd43a584f8e3624fd5c2ec097fad100e72676367c28748508366cf94b254790e9e53c27d033cc178cdcf56', './view/assets/img/xmenderechop.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viamedica`
--

CREATE TABLE `viamedica` (
  `idviaMedica` int(11) NOT NULL,
  `via_med` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `viamedica`
--

INSERT INTO `viamedica` (`idviaMedica`, `via_med`) VALUES
(1, 'Oral'),
(2, 'Cutaneo'),
(3, 'Oftalmico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`clave_cita`),
  ADD KEY `fk_cita_Usuarios1_idx` (`Usuarios_clave_us`),
  ADD KEY `fk_cita_doctor1_idx` (`iddoctor`),
  ADD KEY `fk_cita_Usuarios2_idx` (`claveAdmin`);

--
-- Indices de la tabla `citatratamiento`
--
ALTER TABLE `citatratamiento`
  ADD PRIMARY KEY (`idcitaTratamiento`),
  ADD KEY `fk_citaTratamiento_medicamentos1_idx` (`claveMedicina`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`iddoctor`),
  ADD KEY `fk_doctor_tipoUsuario1_idx` (`tipoUsuario`);

--
-- Indices de la tabla `formamedica`
--
ALTER TABLE `formamedica`
  ADD PRIMARY KEY (`idformaMedica`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`clave_med`),
  ADD KEY `fk_medicamentos_medicina1_idx` (`idmedicina`),
  ADD KEY `fk_medicamentos_forma_med1_idx` (`idformaMedica`),
  ADD KEY `fk_medicamentos_viaMedica1_idx` (`idviaMedica`),
  ADD KEY `fk_medicamentos_Usuarios1_idx` (`Usuarios_clave_us`),
  ADD KEY `fk_medicamentos_doctor1_idx` (`iddoctor`),
  ADD KEY `fk_medicamentos_Usuarios2_idx` (`claveAdmin`);

--
-- Indices de la tabla `medicina`
--
ALTER TABLE `medicina`
  ADD PRIMARY KEY (`idmedicina`);

--
-- Indices de la tabla `notificacioncitas`
--
ALTER TABLE `notificacioncitas`
  ADD PRIMARY KEY (`idnotificacionCitas`),
  ADD KEY `fk_notificacionCitas_cita1_idx` (`claveCita`);

--
-- Indices de la tabla `notificacionmedicina`
--
ALTER TABLE `notificacionmedicina`
  ADD PRIMARY KEY (`idnotificacionMedicina`),
  ADD KEY `fk_notificacionMedicina_medicamentos1_idx` (`claveMedicina`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idtipoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`clave_us`),
  ADD KEY `fk_Usuarios_tipoUsuario1_idx` (`tipoUsuario`);

--
-- Indices de la tabla `viamedica`
--
ALTER TABLE `viamedica`
  ADD PRIMARY KEY (`idviaMedica`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `clave_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `citatratamiento`
--
ALTER TABLE `citatratamiento`
  MODIFY `idcitaTratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `iddoctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `formamedica`
--
ALTER TABLE `formamedica`
  MODIFY `idformaMedica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `clave_med` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicina`
--
ALTER TABLE `medicina`
  MODIFY `idmedicina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificacioncitas`
--
ALTER TABLE `notificacioncitas`
  MODIFY `idnotificacionCitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notificacionmedicina`
--
ALTER TABLE `notificacionmedicina`
  MODIFY `idnotificacionMedicina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idtipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `clave_us` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `viamedica`
--
ALTER TABLE `viamedica`
  MODIFY `idviaMedica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_Usuarios1` FOREIGN KEY (`Usuarios_clave_us`) REFERENCES `usuarios` (`clave_us`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_Usuarios2` FOREIGN KEY (`claveAdmin`) REFERENCES `usuarios` (`clave_us`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cita_doctor1` FOREIGN KEY (`iddoctor`) REFERENCES `doctor` (`iddoctor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citatratamiento`
--
ALTER TABLE `citatratamiento`
  ADD CONSTRAINT `fk_citaTratamiento_medicamentos1` FOREIGN KEY (`claveMedicina`) REFERENCES `medicamentos` (`clave_med`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_tipoUsuario1` FOREIGN KEY (`tipoUsuario`) REFERENCES `tipousuario` (`idtipoUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `fk_medicamentos_Usuarios1` FOREIGN KEY (`Usuarios_clave_us`) REFERENCES `usuarios` (`clave_us`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medicamentos_Usuarios2` FOREIGN KEY (`claveAdmin`) REFERENCES `usuarios` (`clave_us`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_medicamentos_doctor1` FOREIGN KEY (`iddoctor`) REFERENCES `doctor` (`iddoctor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_medicamentos_forma_med1` FOREIGN KEY (`idformaMedica`) REFERENCES `formamedica` (`idformaMedica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_medicamentos_medicina1` FOREIGN KEY (`idmedicina`) REFERENCES `medicina` (`idmedicina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_medicamentos_viaMedica1` FOREIGN KEY (`idviaMedica`) REFERENCES `viamedica` (`idviaMedica`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificacioncitas`
--
ALTER TABLE `notificacioncitas`
  ADD CONSTRAINT `fk_notificacionCitas_cita1` FOREIGN KEY (`claveCita`) REFERENCES `cita` (`clave_cita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificacionmedicina`
--
ALTER TABLE `notificacionmedicina`
  ADD CONSTRAINT `fk_notificacionMedicina_medicamentos1` FOREIGN KEY (`claveMedicina`) REFERENCES `medicamentos` (`clave_med`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Usuarios_tipoUsuario1` FOREIGN KEY (`tipoUsuario`) REFERENCES `tipousuario` (`idtipoUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
