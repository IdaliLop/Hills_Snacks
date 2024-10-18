-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2024 a las 04:36:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hills_snacks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `Idusuario_UC` int(11) NOT NULL,
  `IdNegocio_N` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `IdProducto_P` int(11) NOT NULL,
  `IdNegocio_N` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`IdProducto_P`, `IdNegocio_N`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño`
--

CREATE TABLE `dueño` (
  `IdDueño_D` int(11) NOT NULL,
  `Nombre_D` varchar(45) NOT NULL,
  `Apellido_D` varchar(45) NOT NULL,
  `Pass_D` varchar(64) DEFAULT NULL,
  `Telefono_D` varchar(45) DEFAULT NULL,
  `Correo_D` varchar(45) DEFAULT NULL,
  `IdNegocio_N` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dueño`
--

INSERT INTO `dueño` (`IdDueño_D`, `Nombre_D`, `Apellido_D`, `Pass_D`, `Telefono_D`, `Correo_D`, `IdNegocio_N`) VALUES
(1, 'Rene Gustavo', 'Velazquez Gonzalez', 'Rene.velazquez', '3310457899', 'ReneVelaz@gmail.com', NULL),
(2, 'Evelin Cristina', 'Gonzalez Soto', 'evelin.82', '3320456677', 'EvelinGnz@gmail.com', NULL),
(3, 'Leonardo ', 'Murillo', 'Leo.murillo', '3312457890', 'LeoMu@gmail.com', NULL),
(4, 'Quetzali', 'Monay', 'biyin.24', '3331323334', 'Monat@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

CREATE TABLE `negocio` (
  `IdNegocio_N` int(11) NOT NULL,
  `Nombre_N` varchar(45) NOT NULL,
  `Direccion_N` varchar(45) NOT NULL,
  `Tipo_de_negocio` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `negocio`
--

INSERT INTO `negocio` (`IdNegocio_N`, `Nombre_N`, `Direccion_N`, `Tipo_de_negocio`) VALUES
(1, 'Tacos Lomeli', 'Colina Central 3355', 'Tacos'),
(2, 'Hamburguesas Murillo', 'Colina del templo 654', 'Hamburguesas'),
(3, 'Tapiocas Biyin', 'Colina de la prudencia 369', 'Tapiocas'),
(4, 'Pollos Abel', 'Colina Central 3655', 'Pollo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto_P` int(11) NOT NULL,
  `Nombre_P` varchar(45) NOT NULL,
  `Precio_P` int(11) NOT NULL,
  `Disponibilidad_P` int(11) NOT NULL,
  `IdNegocio_N` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto_P`, `Nombre_P`, `Precio_P`, `Disponibilidad_P`, `IdNegocio_N`) VALUES
(1, 'Tapioca de cafe', 50, 25, 3),
(2, 'Hamburguesas', 75, 20, 2),
(3, 'Pollo asado', 180, 30, 4),
(4, 'Taco al pastor', 15, 33, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `IdTrabajador_T` int(11) NOT NULL,
  `Nombre_T` varchar(45) NOT NULL,
  `Apellido_T` varchar(45) NOT NULL,
  `Pass_T` varchar(64) DEFAULT NULL,
  `Domicilio_T` varchar(45) NOT NULL,
  `Correo_T` varchar(45) NOT NULL,
  `IdNegocio_N` int(11) DEFAULT NULL,
  `IdDueño_D` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='	';

--
-- Volcado de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`IdTrabajador_T`, `Nombre_T`, `Apellido_T`, `Pass_T`, `Domicilio_T`, `Correo_T`, `IdNegocio_N`, `IdDueño_D`) VALUES
(1, 'Raquel ', 'Mariscal', 'Raquis.M', 'colina central 3245', 'Raquel@gmail.com', NULL, NULL),
(2, 'Sandra', 'Castellanos', 'Sandra.cas', 'Colina de la prudencia', 'Sandy@gmail.com', NULL, NULL),
(3, 'Yesua', 'Lopez', 'Chino33*', 'Colina del los lamentos 784', 'Yesua@gmail.com', NULL, NULL),
(4, 'Elias ', 'Lopez', 'Elias333*', 'Colinas de los lamentos 795', 'Elias@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_cliente`
--

CREATE TABLE `usuario_cliente` (
  `Idusuario_UC` int(11) NOT NULL,
  `Nombre_UC` varchar(45) NOT NULL,
  `Apellido_UC` varchar(45) NOT NULL,
  `Pass_UC` varchar(64) DEFAULT NULL,
  `Telefono_UC` varchar(45) NOT NULL,
  `Domicilio_UC` varchar(45) NOT NULL,
  `Correo_UC` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_cliente`
--

INSERT INTO `usuario_cliente` (`Idusuario_UC`, `Nombre_UC`, `Apellido_UC`, `Pass_UC`, `Telefono_UC`, `Domicilio_UC`, `Correo_UC`) VALUES
(1, 'Santiago Leonel', 'Serrano Gonzalez', 'Leo.serrano', '3366997788', 'Colina Central 3141', 'LeoS@gmail.com'),
(2, 'rafael ', 'Gonzalez Soto', 'Rago91', '3355774422', 'Atequiza 1506', 'Rago@gamil.com'),
(3, 'Ana Karen', 'Alon Gonzalez', 'Ana.alon', '3388201011', 'Loma del mar 7788', 'KeranAlo@gmail.com'),
(4, 'Paola', 'Gonzalez', 'Pao.gonzalez', '3311885566', 'Camichines 3355', 'PaoGonzalez@gmail.com'),
(9, 'Emiliano', 'Velazquez', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176', '3318530145', 'Central', 'emiliano@gmail.com'),
(10, 'Ida', 'Lopez', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176', '3344556677', 'Colina del Mar', 'ida@gmail.com'),
(12, 'valeria', 'gonzalez', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176', '3377889944', 'central', 'val@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD KEY `Idusuario_UC` (`Idusuario_UC`),
  ADD KEY `IdNegocio_N` (`IdNegocio_N`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD KEY `IdProducto_P` (`IdProducto_P`),
  ADD KEY `IdNegocio_N` (`IdNegocio_N`);

--
-- Indices de la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD PRIMARY KEY (`IdDueño_D`),
  ADD KEY `IdNegocio_N` (`IdNegocio_N`) USING BTREE;

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`IdNegocio_N`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto_P`),
  ADD KEY `IdNegocio_N` (`IdNegocio_N`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`IdTrabajador_T`),
  ADD UNIQUE KEY `IdNegocio_N` (`IdNegocio_N`),
  ADD KEY `IdDueño_D` (`IdDueño_D`);

--
-- Indices de la tabla `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  ADD PRIMARY KEY (`Idusuario_UC`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dueño`
--
ALTER TABLE `dueño`
  MODIFY `IdDueño_D` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `IdNegocio_N` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto_P` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  MODIFY `IdTrabajador_T` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario_cliente`
--
ALTER TABLE `usuario_cliente`
  MODIFY `Idusuario_UC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`Idusuario_UC`) REFERENCES `usuario_cliente` (`Idusuario_UC`) ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`IdNegocio_N`) REFERENCES `negocio` (`IdNegocio_N`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`IdNegocio_N`) REFERENCES `negocio` (`IdNegocio_N`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cuenta_ibfk_2` FOREIGN KEY (`IdProducto_P`) REFERENCES `producto` (`IdProducto_P`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD CONSTRAINT `dueño_ibfk_1` FOREIGN KEY (`IdNegocio_N`) REFERENCES `negocio` (`IdNegocio_N`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `IdNegocio_N` FOREIGN KEY (`IdNegocio_N`) REFERENCES `negocio` (`IdNegocio_N`);

--
-- Filtros para la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD CONSTRAINT `trabajador_ibfk_1` FOREIGN KEY (`IdDueño_D`) REFERENCES `dueño` (`IdDueño_D`) ON UPDATE CASCADE,
  ADD CONSTRAINT `trabajador_ibfk_2` FOREIGN KEY (`IdNegocio_N`) REFERENCES `negocio` (`IdNegocio_N`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
