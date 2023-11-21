-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Temps de generació: 08-11-2023 a les 12:02:36
-- Versió del servidor: 10.11.5-MariaDB-1:10.11.5+maria~ubu2204
-- Versió de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `db_proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `tipo_usuario` varchar(225) NOT NULL,
  `id_empresa` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `DNI` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `administrativo`
--

CREATE TABLE `administrativo` (
  `id` int(11) NOT NULL,
  `tipo_usuario` varchar(225) NOT NULL,
  `id_empresa` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `DNI` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `num_vehiculo` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `matricula_v` varchar(10) DEFAULT NULL,
  `id_factura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `documento_vehiculo`
--

CREATE TABLE `documento_vehiculo` (
  `ID` int(11) NOT NULL,
  `tipo_documento` varchar(255) DEFAULT NULL,
  `ruta_documento` varchar(255) DEFAULT NULL,
  `matricula_vehiculo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `dni_usuario` varchar(10) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `matricula_vehiculo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `imagen`
--

CREATE TABLE `imagen` (
  `ID` int(11) NOT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `matricula_vehiculo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `marca`
--

CREATE TABLE `marca` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `modelo`
--

CREATE TABLE `modelo` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo_carburante` varchar(255) DEFAULT NULL,
  `tipo_marcha` varchar(255) DEFAULT NULL,
  `descripcion_comercial` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `particular`
--

CREATE TABLE `particular` (
  `id` int(11) NOT NULL,
  `tipo_usuario` varchar(225) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `DNI` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `profesional`
--

CREATE TABLE `profesional` (
  `id` int(11) NOT NULL,
  `tipo_usuario` varchar(225) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `DNI` varchar(20) DEFAULT NULL,
  `CIF` varchar(20) DEFAULT NULL,
  `NIF_gerente` varchar(20) DEFAULT NULL,
  `documento_LOPD` varchar(20) DEFAULT NULL,
  `escritura_constitucion` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `documento_LOPD` varchar(255) DEFAULT NULL,
  `NIF_Gerente` varchar(255) DEFAULT NULL,
  `documento_constitucion` varchar(255) DEFAULT NULL,
  `CIF` varchar(255) DEFAULT NULL,
  `certificado_cuenta_bancaria` varchar(255) DEFAULT NULL,
  `domicilio_completo` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `proveedor`
--

INSERT INTO `proveedor` (`id`, `documento_LOPD`, `NIF_Gerente`, `documento_constitucion`, `CIF`, `certificado_cuenta_bancaria`, `domicilio_completo`, `telefono`, `nombre`, `correo_electronico`) VALUES
(1, '', '12345678A', '', 'A1234567B', '', 'Calle falsa 123', '987654321', 'Carlos', 'carlos@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de la taula `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo_usuario` varchar(225) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `DNI` varchar(10) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `color` varchar(50) NOT NULL,
  `danos` text DEFAULT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `tipo_carburante` varchar(50) NOT NULL,
  `fecha_matriculacion` date NOT NULL,
  `kilometros` int(11) NOT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `iva` decimal(5,2) NOT NULL,
  `num_bastidor` varchar(50) NOT NULL,
  `tipo_cambio` varchar(20) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `id_comanda` int(11) DEFAULT NULL,
  `proveedor` varchar(255) NOT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `transporte_incluido` tinyint(1) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bolcament de dades per a la taula `vehiculo`
--

INSERT INTO `vehiculo` (`id`, `marca`, `modelo`, `matricula`, `color`, `danos`, `id_modelo`, `tipo_carburante`, `fecha_matriculacion`, `kilometros`, `id_marca`, `descripcion`, `iva`, `num_bastidor`, `tipo_cambio`, `precio_venta`, `precio_compra`, `id_comanda`, `proveedor`, `nuevo`, `transporte_incluido`, `imagen`) VALUES
(2, 'Aston Martin', 'AMR23', '1433ALO', 'Verde', 'Ninguno', NULL, 'gasolina', '2022-11-11', 33000, NULL, 'AMR23', 21.00, '11111111111111111', 'manual', 2500000.00, 1750000.00, NULL, 'AM', 1, 1, 'uploads/amr23.jpg');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `administrativo`
--
ALTER TABLE `administrativo`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula_v` (`matricula_v`);

--
-- Índexs per a la taula `documento_vehiculo`
--
ALTER TABLE `documento_vehiculo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `matricula_vehiculo` (`matricula_vehiculo`);

--
-- Índexs per a la taula `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_usuario` (`dni_usuario`),
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `matricula_vehiculo` (`matricula_vehiculo`);

--
-- Índexs per a la taula `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `matricula_vehiculo` (`matricula_vehiculo`);

--
-- Índexs per a la taula `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID`);

--
-- Índexs per a la taula `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`ID`);

--
-- Índexs per a la taula `particular`
--
ALTER TABLE `particular`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `profesional`
--
ALTER TABLE `profesional`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DNI` (`DNI`);

--
-- Índexs per a la taula `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `id_modelo` (`id_modelo`),
  ADD KEY `id_marca` (`id_marca`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `administrativo`
--
ALTER TABLE `administrativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `particular`
--
ALTER TABLE `particular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `profesional`
--
ALTER TABLE `profesional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la taula `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);

--
-- Restriccions per a la taula `administrativo`
--
ALTER TABLE `administrativo`
  ADD CONSTRAINT `administrativo_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);

--
-- Restriccions per a la taula `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `comanda_ibfk_1` FOREIGN KEY (`matricula_v`) REFERENCES `vehiculo` (`matricula`);

--
-- Restriccions per a la taula `documento_vehiculo`
--
ALTER TABLE `documento_vehiculo`
  ADD CONSTRAINT `documento_vehiculo_ibfk_1` FOREIGN KEY (`matricula_vehiculo`) REFERENCES `vehiculo` (`matricula`);

--
-- Restriccions per a la taula `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`dni_usuario`) REFERENCES `usuarios` (`DNI`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`matricula_vehiculo`) REFERENCES `vehiculo` (`matricula`);

--
-- Restriccions per a la taula `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`matricula_vehiculo`) REFERENCES `vehiculo` (`matricula`);

--
-- Restriccions per a la taula `marca`
--
ALTER TABLE `marca`
  ADD CONSTRAINT `marca_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `modelo` (`ID`);

--
-- Restriccions per a la taula `particular`
--
ALTER TABLE `particular`
  ADD CONSTRAINT `particular_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);

--
-- Restriccions per a la taula `profesional`
--
ALTER TABLE `profesional`
  ADD CONSTRAINT `profesional_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);

--
-- Restriccions per a la taula `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `modelo` (`ID`),
  ADD CONSTRAINT `vehiculo_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
