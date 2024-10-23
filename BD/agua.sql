-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2021 a las 20:49:07
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agua`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepagos`
--

CREATE TABLE `detallepagos` (
  `iddetalle` int(11) NOT NULL,
  `idservicios` int(11) NOT NULL,
  `totalM3` float(11,2) NOT NULL,
  `valorM3` float(11,2) NOT NULL,
  `subtotal` float(11,2) NOT NULL,
  `igv` float(11,2) NOT NULL,
  `cargofijo` float(11,2) DEFAULT NULL,
  `otroscobros` float(11,2) DEFAULT NULL,
  `mora` float(11,2) DEFAULT NULL,
  `totalpagar` float(11,2) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `tipocobranza` varchar(50) DEFAULT NULL,
  `nro_transacion` varchar(100) DEFAULT NULL,
  `lugarpago` varchar(100) NOT NULL,
  `dineropagado` float(11,2) NOT NULL,
  `cambio` float(11,2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallepagos`
--

INSERT INTO `detallepagos` (`iddetalle`, `idservicios`, `totalM3`, `valorM3`, `subtotal`, `igv`, `cargofijo`, `otroscobros`, `mora`, `totalpagar`, `estado`, `tipocobranza`, `nro_transacion`, `lugarpago`, `dineropagado`, `cambio`, `create_at`, `update_at`) VALUES
(5, 131, 10.00, 0.30, 3.00, 0.00, 3.50, 14.00, 0.00, 20.50, 0, 'Efectivo', '', 'Ventanilla', 20.50, 0.00, '2021-07-02 20:35:58', NULL),
(6, 131, 201.00, 0.30, 57.30, 0.00, 3.50, 14.00, 0.00, 74.80, 1, 'Cuenta', '1010104', 'Página', 0.00, 0.00, '2021-07-02 20:37:11', NULL),
(7, 131, 454.00, 0.30, 75.90, 0.00, 3.50, 14.00, 0.00, 93.40, 1, 'Cuenta', '555', 'Página', 0.00, 0.00, '2021-07-02 20:37:39', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `detalle_pagos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `detalle_pagos` (
`iddetalle` int(11)
,`idservicios` int(11)
,`totalM3` float(11,2)
,`valorM3` float(11,2)
,`subtotal` float(11,2)
,`igv` float(11,2)
,`cargofijo` float(11,2)
,`otroscobros` float(11,2)
,`mora` float(11,2)
,`totalpagar` float(11,2)
,`estado` int(11)
,`tipocobranza` varchar(50)
,`lugarpago` varchar(100)
,`create_at` timestamp
,`nro_transacion` varchar(100)
,`idpersona` int(11)
,`nombres` varchar(202)
,`documento` varchar(45)
,`direccion` varchar(70)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `mostrar_detalle_pagos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `mostrar_detalle_pagos` (
`idrecibo` int(11)
,`idpersona` int(11)
,`iddetallepago` int(11)
,`idservicio` int(11)
,`nombres` varchar(202)
,`documento` varchar(45)
,`direccion` varchar(70)
,`telefono` varchar(45)
,`month_billed` varchar(50)
,`totalM3` int(11)
,`valorM3` float(11,2)
,`igv` float(11,2)
,`subtotal` float(11,2)
,`cargofijo` float(11,2)
,`otroscobros` float(11,2)
,`mora` float(11,2)
,`codigorecibo` varchar(20)
,`totalpagar` float(11,2)
,`estado` int(11)
,`newtotalm3` float(11,2)
,`newvalorm3` float(11,2)
,`newsubtotal` float(11,2)
,`newigv` float(11,2)
,`newcargofijo` float(11,2)
,`newotroscobros` float(11,2)
,`newmora` float(11,2)
,`newtotalpagar` float(11,2)
,`dineropagado` float(11,2)
,`cambio` float(11,2)
,`estadodetalle` int(11)
,`codigoservicio` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `mostrar_detalle_servicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `mostrar_detalle_servicio` (
`idrecibo` int(11)
,`idpersona` int(11)
,`iddetallepago` int(11)
,`idservicio` int(11)
,`nombres` varchar(202)
,`documento` varchar(45)
,`direccion` varchar(70)
,`telefono` varchar(45)
,`month_billed` varchar(50)
,`totalM3` int(11)
,`valorM3` float(11,2)
,`igv` float(11,2)
,`subtotal` float(11,2)
,`cargofijo` float(11,2)
,`otroscobros` float(11,2)
,`mora` float(11,2)
,`codigorecibo` varchar(20)
,`totalpagar` float(11,2)
,`estado` int(11)
,`date_expires` date
,`codigoservicio` varchar(20)
,`codigomedidor` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `mostrar_servicio_persona`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `mostrar_servicio_persona` (
`idservicio` int(11)
,`codigo` varchar(20)
,`codigomedidor` varchar(20)
,`estado` int(11)
,`idpersona` int(11)
,`nombres` varchar(100)
,`apaterno` varchar(50)
,`amaterno` varchar(50)
,`direccion` varchar(70)
,`idzona` int(11)
,`nombrezona` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idpersona` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apaterno` varchar(50) DEFAULT NULL,
  `amaterno` varchar(50) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `sexo` varchar(45) NOT NULL,
  `fecha_nacimiento` varchar(45) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `idZona` int(11) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cobro` int(11) DEFAULT NULL,
  `ultimo_cobro` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersona`, `nombres`, `apaterno`, `amaterno`, `documento`, `sexo`, `fecha_nacimiento`, `telefono`, `idZona`, `direccion`, `email`, `cobro`, `ultimo_cobro`, `fecha`) VALUES
(176, 'PEDRO   ', 'MUÑUICO', ' INCACUTIPA ', '80008925', 'M', 'COD-1245', 'MEDI1236', 9, '', NULL, NULL, NULL, '2021-06-07 13:56:13'),
(177, 'JINES  ', 'QUISPE', 'MUÑUICO', '7895624', 'M', 'CODI-01748', 'MEDI12456', 9, '', NULL, NULL, NULL, '2021-06-07 13:56:22'),
(180, 'ALEJAMDRA', 'PORRAS', 'QUINTANILLA', '75602369', 'M', 'CODI-1265', 'MIDI1234MM', 7, 'AMAZONAS 120', NULL, NULL, NULL, '2021-06-07 13:56:30');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `persona_servicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `persona_servicio` (
`idpersona` int(11)
,`idservicio` int(11)
,`nombres` varchar(100)
,`apaterno` varchar(50)
,`amaterno` varchar(50)
,`documento` varchar(45)
,`sexo` varchar(45)
,`telefono` varchar(45)
,`estado` int(11)
,`codigo` varchar(20)
,`igv` float(11,2)
,`valor1` float(11,2)
,`valor2` float(11,2)
,`cargofijo` float(11,2)
,`otroscobros` float(11,2)
,`mora` float(11,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `persona_servicio_cobros`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `persona_servicio_cobros` (
`idpersona` int(11)
,`nombres` varchar(100)
,`apaterno` varchar(50)
,`amaterno` varchar(50)
,`documento` varchar(45)
,`sexo` varchar(45)
,`fecha_nacimiento` varchar(45)
,`telefono` varchar(45)
,`zona` varchar(50)
,`direccion` varchar(70)
,`idservicio` int(11)
,`codigo` varchar(20)
,`estado` int(11)
,`fechaasta` datetime
,`idrecibo` int(11)
,`totalM3` int(11)
,`valorM3` float(11,2)
,`subtotal` float(11,2)
,`igv` float(11,2)
,`cargofijo` float(11,2)
,`otroscobros` float(11,2)
,`mora` float(11,2)
,`totalpagar` float(11,2)
,`estadorecibo` int(11)
,`fecharecibo` timestamp
,`date_expires` date
,`month_billed` varchar(50)
,`igvservicio` float(11,2)
,`moratiposervicio` float(11,2)
,`expira_en` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibopagos`
--

CREATE TABLE `recibopagos` (
  `idrecibo` int(11) NOT NULL,
  `idservicios` int(11) NOT NULL,
  `iddetallepago` int(11) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `codigomedidor` varchar(20) NOT NULL,
  `totalM3` int(11) NOT NULL,
  `valorM3` float(11,2) NOT NULL,
  `subtotal` float(11,2) NOT NULL,
  `igv` float(11,2) NOT NULL,
  `cargofijo` float(11,2) DEFAULT NULL,
  `otroscobros` float(11,2) DEFAULT NULL,
  `mora` float(11,2) DEFAULT NULL,
  `totalpagar` float(11,2) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `month_billed` varchar(50) DEFAULT NULL,
  `date_expires` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recibopagos`
--

INSERT INTO `recibopagos` (`idrecibo`, `idservicios`, `iddetallepago`, `codigo`, `codigomedidor`, `totalM3`, `valorM3`, `subtotal`, `igv`, `cargofijo`, `otroscobros`, `mora`, `totalpagar`, `estado`, `create_at`, `month_billed`, `date_expires`) VALUES
(106, 131, 5, 'COD-1245', 'MEDI1236', 10, 0.30, 3.00, 0.00, 3.50, 14.00, 0.00, 20.50, 0, '2021-07-02 20:35:58', 'Junio - 2021', '0000-00-00'),
(109, 131, 6, 'COD-1245', 'MEDI1236', 201, 0.30, 57.30, 0.00, 3.50, 14.00, 0.00, 74.80, 3, '2021-07-02 20:37:11', 'Julio - 2021', '2021-07-03'),
(110, 131, 7, 'COD-1245', 'MEDI1236', 454, 0.30, 75.90, 0.00, 3.50, 14.00, 0.00, 93.40, 3, '2021-07-02 20:37:39', 'Agosto - 2021', '2021-09-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idservicio` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `idusuarios` int(11) NOT NULL,
  `idpersonas` int(11) NOT NULL,
  `idtiposervicios` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `codigomedidor` varchar(20) NOT NULL,
  `lecturamedidor` int(11) NOT NULL DEFAULT '0',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idservicio`, `codigo`, `idusuarios`, `idpersonas`, `idtiposervicios`, `estado`, `codigomedidor`, `lecturamedidor`, `create_at`, `update_at`, `date_to`) VALUES
(131, 'COD-1245', 1, 176, 1, 0, 'MEDI1236', 253, '2021-07-02 20:37:39', '2021-07-02 05:00:00', '2021-09-16 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposervicios`
--

CREATE TABLE `tiposervicios` (
  `idtiposervicio` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `valor1` float(11,2) NOT NULL,
  `valor2` float(11,2) NOT NULL,
  `igv` float(11,2) NOT NULL,
  `cargofijo` float(11,2) DEFAULT NULL,
  `otroscobros` float(11,2) DEFAULT NULL,
  `mora` float(11,2) DEFAULT NULL,
  `expira_en` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiposervicios`
--

INSERT INTO `tiposervicios` (`idtiposervicio`, `nombre`, `descripcion`, `valor1`, `valor2`, `igv`, `cargofijo`, `otroscobros`, `mora`, `expira_en`, `create_at`, `update_at`) VALUES
(1, 'SERVICIO DE AGUA POTABLE', 'SERVICIO DE AGUA POTABLE ', 0.30, 0.30, 0.00, 3.50, 14.00, 0.00, 5, '2021-06-06 15:37:16', '2021-06-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text,
  `estado` int(11) NOT NULL DEFAULT '0',
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(1, 'ADMINISTRADOR', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/945.png', 1, '2021-07-14 13:48:42', '2021-07-14 18:48:42'),
(5, 'LECTURADOR', 'LECTURADOR', '$2a$07$asxx54ahjppf45sd87a5auXOd8PdFfdRt8z3yTEFJUm7gt73gHuyK', 'Lecturador', 'vistas/img/usuarios/LECTURADOR/321.png', 1, NULL, '2021-07-14 17:59:26'),
(6, 'CAJERO', 'CAJERO', '$2a$07$asxx54ahjppf45sd87a5auSq3s0AmXTzUtx24gKAjAR3/NZcAeqeq', 'Cobrador', 'vistas/img/usuarios/CAJERO/215.png', 1, NULL, '2021-07-14 17:59:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `idzona` int(11) NOT NULL,
  `nombrezona` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`idzona`, `nombrezona`) VALUES
(7, 'ZONA 1'),
(8, 'ZONA 2'),
(9, 'ZONA 3');

-- --------------------------------------------------------

--
-- Estructura para la vista `detalle_pagos`
--
DROP TABLE IF EXISTS `detalle_pagos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detalle_pagos`  AS  select `det`.`iddetalle` AS `iddetalle`,`det`.`idservicios` AS `idservicios`,`det`.`totalM3` AS `totalM3`,`det`.`valorM3` AS `valorM3`,`det`.`subtotal` AS `subtotal`,`det`.`igv` AS `igv`,`det`.`cargofijo` AS `cargofijo`,`det`.`otroscobros` AS `otroscobros`,`det`.`mora` AS `mora`,`det`.`totalpagar` AS `totalpagar`,`det`.`estado` AS `estado`,`det`.`tipocobranza` AS `tipocobranza`,`det`.`lugarpago` AS `lugarpago`,`det`.`create_at` AS `create_at`,`det`.`nro_transacion` AS `nro_transacion`,`per`.`idpersona` AS `idpersona`,concat(`per`.`nombres`,' ',`per`.`apaterno`,' ',`per`.`amaterno`) AS `nombres`,`per`.`documento` AS `documento`,`per`.`direccion` AS `direccion` from ((`detallepagos` `det` join `servicios` `ser` on((`det`.`idservicios` = `ser`.`idservicio`))) join `personas` `per` on((`ser`.`idpersonas` = `per`.`idpersona`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `mostrar_detalle_pagos`
--
DROP TABLE IF EXISTS `mostrar_detalle_pagos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mostrar_detalle_pagos`  AS  select `rec`.`idrecibo` AS `idrecibo`,`per`.`idpersona` AS `idpersona`,`rec`.`iddetallepago` AS `iddetallepago`,`ser`.`idservicio` AS `idservicio`,concat(`per`.`nombres`,' ',`per`.`apaterno`,' ',`per`.`amaterno`) AS `nombres`,`per`.`documento` AS `documento`,`per`.`direccion` AS `direccion`,`per`.`telefono` AS `telefono`,`rec`.`month_billed` AS `month_billed`,`rec`.`totalM3` AS `totalM3`,`rec`.`valorM3` AS `valorM3`,`rec`.`igv` AS `igv`,`rec`.`subtotal` AS `subtotal`,`rec`.`cargofijo` AS `cargofijo`,`rec`.`otroscobros` AS `otroscobros`,`rec`.`mora` AS `mora`,`rec`.`codigo` AS `codigorecibo`,`rec`.`totalpagar` AS `totalpagar`,`rec`.`estado` AS `estado`,`det`.`totalM3` AS `newtotalm3`,`det`.`valorM3` AS `newvalorm3`,`det`.`subtotal` AS `newsubtotal`,`det`.`igv` AS `newigv`,`det`.`cargofijo` AS `newcargofijo`,`det`.`otroscobros` AS `newotroscobros`,`det`.`mora` AS `newmora`,`det`.`totalpagar` AS `newtotalpagar`,`det`.`dineropagado` AS `dineropagado`,`det`.`cambio` AS `cambio`,`det`.`estado` AS `estadodetalle`,`ser`.`codigo` AS `codigoservicio` from (((`recibopagos` `rec` join `detallepagos` `det` on((`rec`.`iddetallepago` = `det`.`iddetalle`))) join `servicios` `ser` on((`rec`.`idservicios` = `ser`.`idservicio`))) join `personas` `per` on((`ser`.`idpersonas` = `per`.`idpersona`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `mostrar_detalle_servicio`
--
DROP TABLE IF EXISTS `mostrar_detalle_servicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mostrar_detalle_servicio`  AS  select `rec`.`idrecibo` AS `idrecibo`,`per`.`idpersona` AS `idpersona`,`rec`.`iddetallepago` AS `iddetallepago`,`ser`.`idservicio` AS `idservicio`,concat(`per`.`nombres`,' ',`per`.`apaterno`,' ',`per`.`amaterno`) AS `nombres`,`per`.`documento` AS `documento`,`per`.`direccion` AS `direccion`,`per`.`telefono` AS `telefono`,`rec`.`month_billed` AS `month_billed`,`rec`.`totalM3` AS `totalM3`,`rec`.`valorM3` AS `valorM3`,`rec`.`igv` AS `igv`,`rec`.`subtotal` AS `subtotal`,`rec`.`cargofijo` AS `cargofijo`,`rec`.`otroscobros` AS `otroscobros`,`rec`.`mora` AS `mora`,`rec`.`codigo` AS `codigorecibo`,`rec`.`totalpagar` AS `totalpagar`,`rec`.`estado` AS `estado`,`rec`.`date_expires` AS `date_expires`,`ser`.`codigo` AS `codigoservicio`,`ser`.`codigomedidor` AS `codigomedidor` from ((`recibopagos` `rec` join `servicios` `ser` on((`rec`.`idservicios` = `ser`.`idservicio`))) join `personas` `per` on((`ser`.`idpersonas` = `per`.`idpersona`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `mostrar_servicio_persona`
--
DROP TABLE IF EXISTS `mostrar_servicio_persona`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mostrar_servicio_persona`  AS  select `ser`.`idservicio` AS `idservicio`,`ser`.`codigo` AS `codigo`,`ser`.`codigomedidor` AS `codigomedidor`,`ser`.`estado` AS `estado`,`per`.`idpersona` AS `idpersona`,`per`.`nombres` AS `nombres`,`per`.`apaterno` AS `apaterno`,`per`.`amaterno` AS `amaterno`,`per`.`direccion` AS `direccion`,`zon`.`idzona` AS `idzona`,`zon`.`nombrezona` AS `nombrezona` from ((`servicios` `ser` join `personas` `per` on((`ser`.`idpersonas` = `per`.`idpersona`))) join `zonas` `zon` on((`per`.`idZona` = `zon`.`idzona`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `persona_servicio`
--
DROP TABLE IF EXISTS `persona_servicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `persona_servicio`  AS  select `personas`.`idpersona` AS `idpersona`,`servicios`.`idservicio` AS `idservicio`,`personas`.`nombres` AS `nombres`,`personas`.`apaterno` AS `apaterno`,`personas`.`amaterno` AS `amaterno`,`personas`.`documento` AS `documento`,`personas`.`sexo` AS `sexo`,`personas`.`telefono` AS `telefono`,`servicios`.`estado` AS `estado`,`servicios`.`codigo` AS `codigo`,`tiposervicios`.`igv` AS `igv`,`tiposervicios`.`valor1` AS `valor1`,`tiposervicios`.`valor2` AS `valor2`,`tiposervicios`.`cargofijo` AS `cargofijo`,`tiposervicios`.`otroscobros` AS `otroscobros`,`tiposervicios`.`mora` AS `mora` from (((`personas` join `servicios` on((`personas`.`idpersona` = `servicios`.`idpersonas`))) join `recibopagos` on((`servicios`.`idservicio` = `recibopagos`.`idservicios`))) join `tiposervicios` on((`servicios`.`idtiposervicios` = `tiposervicios`.`idtiposervicio`))) group by `servicios`.`idservicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `persona_servicio_cobros`
--
DROP TABLE IF EXISTS `persona_servicio_cobros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `persona_servicio_cobros`  AS  select `per`.`idpersona` AS `idpersona`,`per`.`nombres` AS `nombres`,`per`.`apaterno` AS `apaterno`,`per`.`amaterno` AS `amaterno`,`per`.`documento` AS `documento`,`per`.`sexo` AS `sexo`,`per`.`fecha_nacimiento` AS `fecha_nacimiento`,`per`.`telefono` AS `telefono`,`zon`.`nombrezona` AS `zona`,`per`.`direccion` AS `direccion`,`ser`.`idservicio` AS `idservicio`,`ser`.`codigo` AS `codigo`,`ser`.`estado` AS `estado`,`ser`.`date_to` AS `fechaasta`,`rec`.`idrecibo` AS `idrecibo`,`rec`.`totalM3` AS `totalM3`,`rec`.`valorM3` AS `valorM3`,`rec`.`subtotal` AS `subtotal`,`rec`.`igv` AS `igv`,`rec`.`cargofijo` AS `cargofijo`,`rec`.`otroscobros` AS `otroscobros`,`rec`.`mora` AS `mora`,`rec`.`totalpagar` AS `totalpagar`,`rec`.`estado` AS `estadorecibo`,`rec`.`create_at` AS `fecharecibo`,`rec`.`date_expires` AS `date_expires`,`rec`.`month_billed` AS `month_billed`,`tip`.`igv` AS `igvservicio`,`tip`.`mora` AS `moratiposervicio`,`tip`.`expira_en` AS `expira_en` from ((((`personas` `per` join `servicios` `ser` on((`per`.`idpersona` = `ser`.`idpersonas`))) join `recibopagos` `rec` on((`ser`.`idservicio` = `rec`.`idservicios`))) join `tiposervicios` `tip` on((`ser`.`idtiposervicios` = `tip`.`idtiposervicio`))) join `zonas` `zon` on((`per`.`idZona` = `zon`.`idzona`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detallepagos`
--
ALTER TABLE `detallepagos`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `detallepagos_ibfk_1` (`idservicios`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersona`),
  ADD KEY `idZona` (`idZona`) USING BTREE;

--
-- Indices de la tabla `recibopagos`
--
ALTER TABLE `recibopagos`
  ADD PRIMARY KEY (`idrecibo`),
  ADD KEY `iddetallepago` (`iddetallepago`),
  ADD KEY `recibopagos_ibfk_1` (`idservicios`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idservicio`),
  ADD KEY `idusuarios` (`idusuarios`),
  ADD KEY `idpersonas` (`idpersonas`),
  ADD KEY `idtiposervicios` (`idtiposervicios`);

--
-- Indices de la tabla `tiposervicios`
--
ALTER TABLE `tiposervicios`
  ADD PRIMARY KEY (`idtiposervicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`idzona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallepagos`
--
ALTER TABLE `detallepagos`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `recibopagos`
--
ALTER TABLE `recibopagos`
  MODIFY `idrecibo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idservicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `tiposervicios`
--
ALTER TABLE `tiposervicios`
  MODIFY `idtiposervicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `idzona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepagos`
--
ALTER TABLE `detallepagos`
  ADD CONSTRAINT `detallepagos_ibfk_1` FOREIGN KEY (`idservicios`) REFERENCES `servicios` (`idservicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`idZona`) REFERENCES `zonas` (`idzona`);

--
-- Filtros para la tabla `recibopagos`
--
ALTER TABLE `recibopagos`
  ADD CONSTRAINT `detallepagos` FOREIGN KEY (`iddetallepago`) REFERENCES `detallepagos` (`iddetalle`) ON DELETE CASCADE,
  ADD CONSTRAINT `recibopagos_ibfk_1` FOREIGN KEY (`idservicios`) REFERENCES `servicios` (`idservicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`idpersonas`) REFERENCES `personas` (`idpersona`),
  ADD CONSTRAINT `servicios_ibfk_3` FOREIGN KEY (`idtiposervicios`) REFERENCES `tiposervicios` (`idtiposervicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
