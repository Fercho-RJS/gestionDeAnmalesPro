-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2025 a las 21:04:15
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `refugio_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adopciones`
--

CREATE TABLE `adopciones` (
  `idAdopciones` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `Mascota_idMascota` int(11) NOT NULL,
  `fecha_adopcion` date NOT NULL,
  `estado` enum('En proceso','Vigente','Rechazada') COLLATE utf8_bin DEFAULT NULL,
  `observacionesl` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `idDonaciones` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_donacion` date DEFAULT NULL,
  `metodo_pago` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `referencia_pago` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `estado` enum('Pendiente','Confirmado','Rechazado') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEventos` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL COMMENT 'Organizador\n',
  `titulo` varchar(50) COLLATE utf8_bin NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `estado` enum('Pendiente','En proceso','Finalizado') COLLATE utf8_bin NOT NULL,
  `imagen_portada` varchar(200) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `idMascota` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `nombre` varchar(80) COLLATE utf8_bin NOT NULL,
  `categoria` varchar(45) COLLATE utf8_bin NOT NULL,
  `raza` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `color` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `height` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `chipNro` varchar(50) COLLATE utf8_bin NOT NULL,
  `status` varchar(45) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Dentro de la tabla, se podrá registrar todo dato de las mascotas que se encuentren, tanto Adoptadas, como Perdidas. Ésta tabla debe rellenarse en ambos casos, Una mascota puede estar perdida, o adoptada, pero además, puede estar en estado de refugio o "stand-by" lo que refiere a que está en espera de una adopción.\n\nEs importante, inclusive para mascotas callejeras sin dueño, que estos datos sean llenados en su mayoría.\n';

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`idMascota`, `Usuario_idUsuario`, `nombre`, `categoria`, `raza`, `edad`, `color`, `height`, `imagen`, `chipNro`, `status`) VALUES
(1, 2, 'Chucho', 'Tortuga Peligrosa', 'Tortuguineitor', 125, 'Tortuga', 'Tortuga', '/gestionDeAnimales/public/res/animal_profiles/photo-1757968571-images.jpeg', 'c961467db2', 'Perdido'),
(2, 5, 'Braco', 'Canino', 'Pug', 5, 'Negro', 'Pequeño', '/gestionDeAnimales/public/res/animal_profiles/photo-1757968763-c6608128d4f0326315545a212dfc2788.jpg', '3779f2f9fb', 'Perdido'),
(9, 2, 'Paola La Loca', 'Canino', 'Mestiza', 22, 'Naranja claro & Blanco', 'Grande', '/gestionDeAnimales/public/res/animal_profiles/photo-1758054850-images (1).jpeg', '2b93691062', 'Adoptado'),
(10, 2, 'Alex_Leflix', 'Canino', 'Mestizo', 813, 'Prueba', 'Prueba', '/gestionDeAnimales/public/res/animal_profiles/photo-1761478524-Abanico.png', '8c2b30572d', 'Perdido'),
(11, 2, 'Prueba', 'Canino', 'Prueba', -96, 'Negro', 'Tortuga', '/gestionDeAnimales/public/res/animal_profiles/photo-1761593980-A.png', '', 'Adoptado'),
(14, 5, 'Alvatraos', 'Loro', 'Ave', 22, 'Verde', 'Pequeño', '/gestionDeAnimales/public/res/animal_profiles/photo-1761594198-B.png', 'd643845b31', 'Adoptado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticias` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL COMMENT 'Publicador',
  `titulo` varchar(50) COLLATE utf8_bin NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `portada` varchar(200) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perdidos`
--

CREATE TABLE `perdidos` (
  `Mascota_idMascota` int(11) NOT NULL,
  `fecha_de_reporte` date NOT NULL DEFAULT current_timestamp(),
  `lugar` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` enum('Encontrado','Perdido') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `perdidos`
--

INSERT INTO `perdidos` (`Mascota_idMascota`, `fecha_de_reporte`, `lugar`, `descripcion`, `status`) VALUES
(1, '2025-10-27', NULL, NULL, 'Perdido'),
(2, '2025-09-26', NULL, NULL, 'Perdido'),
(10, '2025-10-27', NULL, NULL, 'Perdido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL,
  `nombre` varchar(55) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(55) COLLATE utf8_bin NOT NULL,
  `dni` varchar(10) COLLATE utf8_bin NOT NULL,
  `email` varchar(120) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `barrio` varchar(50) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(45) COLLATE utf8_bin NOT NULL,
  `calleAltura` int(11) NOT NULL,
  `depto` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `piso` int(11) DEFAULT NULL,
  `localidad` varchar(45) COLLATE utf8_bin NOT NULL,
  `provincia` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `nombre`, `apellido`, `dni`, `email`, `telefono`, `barrio`, `direccion`, `calleAltura`, `depto`, `piso`, `localidad`, `provincia`) VALUES
(1, 'Ana', 'Fernandez', '15999685', 'ana.fernandez1@mail.com', '+5493408787161', 'Sur', 'Mitre', 1610, '', 0, 'San Cristobal', 'Santa Fe'),
(2, 'Pedro', 'Torres', '28126928', 'pedro.torres2@mail.com', '+5493408862979', 'Jose Dho', 'Mitre', 685, '', 0, 'San Cristobal', 'Santa Fe'),
(3, 'Juan', 'Diaz', '39687253', 'juan.diaz3@mail.com', '+5493408227060', 'Sur', 'Belgrano', 837, '', 0, 'San Cristobal', 'Santa Fe'),
(4, 'Luis', 'Garcia', '49721556', 'luis.garcia4@mail.com', '+5493408829784', 'Juan XXIII', 'Belgrano', 497, '', 0, 'San Cristobal', 'Santa Fe'),
(5, 'Lucia', 'Perez', '55178309', 'lucia.perez5@mail.com', '+5493408436228', 'Centro', 'Belgrano', 1652, '', 0, 'San Cristobal', 'Santa Fe'),
(6, 'Miguel', 'Diaz', '61017679', 'miguel.diaz6@mail.com', '+5493408055341', 'Este', 'Mitre', 701, '', 0, 'San Cristobal', 'Santa Fe'),
(7, 'Carlos', 'Diaz', '76169110', 'carlos.diaz7@mail.com', '+5493408077950', 'Sur', 'Mitre', 547, '', 0, 'San Cristobal', 'Santa Fe'),
(8, 'Ana', 'Perez', '85791781', 'ana.perez8@mail.com', '+5493408717650', 'Jose Dho', 'San Martin', 1796, '', 0, 'San Cristobal', 'Santa Fe'),
(9, 'Sofia', 'Perez', '98073726', 'sofia.perez9@mail.com', '+5493408685246', 'Este', 'Belgrano', 1614, '', 0, 'San Cristobal', 'Santa Fe'),
(10, 'Fernando D. E.', 'Rojas G.', '44495699', 'fernandorojas.contacto@gmail.com', '0340815435682', 'Juan XXIII', 'Oroño', 1023, '', 0, 'San Cristobal', 'Santa Fe'),
(11, 'Laura', 'Diaz', '116063744', 'laura.diaz11@mail.com', '+5493408613687', 'Oeste', 'Mitre', 117, '', 0, 'San Cristobal', 'Santa Fe'),
(12, 'Laura', 'Rodriguez', '126120456', 'laura.rodriguez12@mail.com', '+5493408949213', 'Sur', 'Mitre', 1400, '', 0, 'San Cristobal', 'Santa Fe'),
(13, 'Andrea', 'Gongora', '25424371', 'andreamarisolgongora@gmail.com', '+5493408670408', 'Juan XXIII', 'Oroño', 1023, '', 0, 'San Cristobal', 'Santa Fe'),
(14, 'Miguel', 'Perez', '149864051', 'miguel.perez14@mail.com', '+5493408564110', 'Jose Dho', 'Oroño', 743, '', 0, 'San Cristobal', 'Santa Fe'),
(15, 'Invitado', 'Temporal', '00000000', 'guest@invitado.com', '00 0 0000 000000', 'Ninguno/a', 'Ninguno/a', 0, '', 0, 'San Cristobal', 'Santa Fe'),
(16, 'Veterinaria', 'Herradura', '2012345678', 'herraduravet@gmail.com', '3408676767', 'Jose Dho', 'Belgrano', 100, '', 0, 'San Cristobal', 'Santa Fe'),
(17, 'Maria', 'Diaz', '171623825', 'maria.diaz17@mail.com', '+5493408466180', 'Sur', 'Belgrano', 722, '', 0, 'San Cristobal', 'Santa Fe'),
(18, 'Miguel', 'Lopez', '187852571', 'miguel.lopez18@mail.com', '+5493408928296', 'Sur', 'Mitre', 146, '', 0, 'San Cristobal', 'Santa Fe'),
(19, 'Maria', 'Fernandez', '192013827', 'maria.fernandez19@mail.com', '+5493408652645', 'Jose Dho', 'Sarmiento', 1608, '', 0, 'San Cristobal', 'Santa Fe'),
(20, 'Miguel', 'Martinez', '206689175', 'miguel.martinez20@mail.com', '+5493408668955', 'Este', 'Mitre', 1919, '', 0, 'San Cristobal', 'Santa Fe'),
(21, 'Pedro', 'Torres', '216940870', 'pedro.torres21@mail.com', '+5493408834449', 'Este', 'Belgrano', 1864, '', 0, 'San Cristobal', 'Santa Fe'),
(22, 'Pedro', 'Fernandez', '226482678', 'pedro.fernandez22@mail.com', '+5493408030424', 'Centro', 'Mitre', 750, '', 0, 'San Cristobal', 'Santa Fe'),
(23, 'Carlos', 'Garcia', '232094733', 'carlos.garcia23@mail.com', '+5493408528440', 'Juan XXIII', 'Sarmiento', 689, '', 0, 'San Cristobal', 'Santa Fe'),
(24, 'Lucia', 'Sanchez', '243010067', 'lucia.sanchez24@mail.com', '+5493408651729', 'Juan XXIII', 'San Martin', 515, '', 0, 'San Cristobal', 'Santa Fe'),
(25, 'Juan', 'Gomez', '258177815', 'juan.gomez25@mail.com', '+5493408189038', 'Jose Dho', 'Oroño', 514, '', 0, 'San Cristobal', 'Santa Fe'),
(26, 'Miguel', 'Fernandez', '267471882', 'miguel.fernandez26@mail.com', '+5493408924302', 'Oeste', 'Mitre', 648, '', 0, 'San Cristobal', 'Santa Fe'),
(27, 'Juan', 'Perez', '275057517', 'juan.perez27@mail.com', '+5493408727784', 'Sur', 'San Martin', 1539, '', 0, 'San Cristobal', 'Santa Fe'),
(28, 'Sofia', 'Garcia', '288800176', 'sofia.garcia28@mail.com', '+5493408941557', 'Juan XXIII', 'Belgrano', 1586, '', 0, 'San Cristobal', 'Santa Fe'),
(29, 'Laura', 'Sanchez', '299293759', 'laura.sanchez29@mail.com', '+5493408723211', 'Norte', 'Oroño', 1360, '', 0, 'San Cristobal', 'Santa Fe'),
(30, 'Luis', 'Gomez', '307219862', 'luis.gomez30@mail.com', '+5493408485045', 'Sur', 'Oroño', 492, '', 0, 'San Cristobal', 'Santa Fe'),
(31, 'Carlos', 'Lopez', '319367082', 'carlos.lopez31@mail.com', '+5493408644513', 'Este', 'Sarmiento', 1986, '', 0, 'San Cristobal', 'Santa Fe'),
(32, 'Carlos', 'Diaz', '325349060', 'carlos.diaz32@mail.com', '+5493408517871', 'Jose Dho', 'Belgrano', 1555, '', 0, 'San Cristobal', 'Santa Fe'),
(33, 'Sofia', 'Sanchez', '336961808', 'sofia.sanchez33@mail.com', '+5493408056910', 'Este', 'San Martin', 232, '', 0, 'San Cristobal', 'Santa Fe'),
(34, 'Sofia', 'Sanchez', '349047026', 'sofia.sanchez34@mail.com', '+5493408585449', 'Sur', 'Sarmiento', 1113, '', 0, 'San Cristobal', 'Santa Fe'),
(35, 'Maria', 'Perez', '359377515', 'maria.perez35@mail.com', '+5493408610158', 'Centro', 'San Martin', 135, '', 0, 'San Cristobal', 'Santa Fe'),
(36, 'Miguel', 'Lopez', '367785425', 'miguel.lopez36@mail.com', '+5493408316224', 'Sur', 'Belgrano', 673, '', 0, 'San Cristobal', 'Santa Fe'),
(37, 'Miguel', 'Sanchez', '371790473', 'miguel.sanchez37@mail.com', '+5493408115881', 'Jose Dho', 'Belgrano', 602, '', 0, 'San Cristobal', 'Santa Fe'),
(38, 'Miguel', 'Garcia', '387354031', 'miguel.garcia38@mail.com', '+5493408293250', 'Sur', 'Oroño', 1374, '', 0, 'San Cristobal', 'Santa Fe'),
(39, 'Luis', 'Diaz', '393504362', 'luis.diaz39@mail.com', '+5493408029380', 'Jose Dho', 'San Martin', 1781, '', 0, 'San Cristobal', 'Santa Fe'),
(40, 'Pedro', 'Torres', '404238029', 'pedro.torres40@mail.com', '+5493408756248', 'Sur', 'Belgrano', 1259, '', 0, 'San Cristobal', 'Santa Fe'),
(41, 'Juan', 'Lopez', '414370516', 'juan.lopez41@mail.com', '+5493408903337', 'Sur', 'San Martin', 523, '', 0, 'San Cristobal', 'Santa Fe'),
(42, 'Lucia', 'Rodriguez', '425071499', 'lucia.rodriguez42@mail.com', '+5493408316493', 'Centro', 'San Martin', 119, '', 0, 'San Cristobal', 'Santa Fe'),
(43, 'Pedro', 'Torres', '433474322', 'pedro.torres43@mail.com', '+5493408735026', 'Sur', 'Belgrano', 1069, '', 0, 'San Cristobal', 'Santa Fe'),
(44, 'Pedro', 'Lopez', '445557131', 'pedro.lopez44@mail.com', '+5493408729624', 'Juan XXIII', 'Belgrano', 1854, '', 0, 'San Cristobal', 'Santa Fe'),
(45, 'Lucia', 'Martinez', '459255398', 'lucia.martinez45@mail.com', '+5493408770874', 'Norte', 'Mitre', 872, '', 0, 'San Cristobal', 'Santa Fe'),
(46, 'Juan', 'Garcia', '468800521', 'juan.garcia46@mail.com', '+5493408470124', 'Norte', 'Oroño', 465, '', 0, 'San Cristobal', 'Santa Fe'),
(47, 'Ana', 'Perez', '473273888', 'ana.perez47@mail.com', '+5493408833360', 'Oeste', 'Mitre', 221, '', 0, 'San Cristobal', 'Santa Fe'),
(48, 'Laura', 'Gomez', '485866552', 'laura.gomez48@mail.com', '+5493408854951', 'Centro', 'San Martin', 164, '', 0, 'San Cristobal', 'Santa Fe'),
(49, 'Miguel', 'Rodriguez', '497368373', 'miguel.rodriguez49@mail.com', '+5493408172585', 'Norte', 'Oroño', 1089, '', 0, 'San Cristobal', 'Santa Fe'),
(50, 'Laura', 'Perez', '507222517', 'laura.perez50@mail.com', '+5493408908250', 'Juan XXIII', 'Belgrano', 1723, '', 0, 'San Cristobal', 'Santa Fe'),
(51, 'Ana', 'Rodriguez', '516121489', 'ana.rodriguez51@mail.com', '+5493408126453', 'Juan XXIII', 'Belgrano', 1397, '', 0, 'San Cristobal', 'Santa Fe'),
(52, 'Maria', 'Martinez', '523038623', 'maria.martinez52@mail.com', '+5493408978215', 'Este', 'Sarmiento', 1035, '', 0, 'San Cristobal', 'Santa Fe'),
(53, 'Ana', 'Martinez', '534692887', 'ana.martinez53@mail.com', '+5493408835722', 'Jose Dho', 'Mitre', 612, '', 0, 'San Cristobal', 'Santa Fe'),
(54, 'Juan', 'Gomez', '541550125', 'juan.gomez54@mail.com', '+5493408452626', 'Sur', 'Belgrano', 1498, '', 0, 'San Cristobal', 'Santa Fe'),
(55, 'Pedro', 'Torres', '553300377', 'pedro.torres55@mail.com', '+5493408754469', 'Centro', 'Mitre', 344, '', 0, 'San Cristobal', 'Santa Fe'),
(56, 'Maria', 'Sanchez', '569817204', 'maria.sanchez56@mail.com', '+5493408013450', 'Este', 'Belgrano', 1004, '', 0, 'San Cristobal', 'Santa Fe'),
(57, 'Miguel', 'Gomez', '573746302', 'miguel.gomez57@mail.com', '+5493408994176', 'Jose Dho', 'Sarmiento', 931, '', 0, 'San Cristobal', 'Santa Fe'),
(58, 'Laura', 'Diaz', '585527698', 'laura.diaz58@mail.com', '+5493408018485', 'Juan XXIII', 'Mitre', 139, '', 0, 'San Cristobal', 'Santa Fe'),
(59, 'Sofia', 'Perez', '595862147', 'sofia.perez59@mail.com', '+5493408129889', 'Oeste', 'Oroño', 1666, '', 0, 'San Cristobal', 'Santa Fe'),
(60, 'Ana', 'Torres', '603729872', 'ana.torres60@mail.com', '+5493408224974', 'Sur', 'Sarmiento', 463, '', 0, 'San Cristobal', 'Santa Fe'),
(61, 'Miguel', 'Garcia', '612234350', 'miguel.garcia61@mail.com', '+5493408013138', 'Norte', 'Oroño', 1305, '', 0, 'San Cristobal', 'Santa Fe'),
(62, 'Luis', 'Martinez', '622451443', 'luis.martinez62@mail.com', '+5493408773399', 'Sur', 'Sarmiento', 1035, '', 0, 'San Cristobal', 'Santa Fe'),
(63, 'Miguel', 'Perez', '632767071', 'miguel.perez63@mail.com', '+5493408272540', 'Este', 'Oroño', 1195, '', 0, 'San Cristobal', 'Santa Fe'),
(64, 'Ana', 'Sanchez', '646243084', 'ana.sanchez64@mail.com', '+5493408829399', 'Centro', 'Sarmiento', 1411, '', 0, 'San Cristobal', 'Santa Fe'),
(65, 'Luis', 'Fernandez', '656268919', 'luis.fernandez65@mail.com', '+5493408255353', 'Sur', 'Sarmiento', 1039, '', 0, 'San Cristobal', 'Santa Fe'),
(66, 'Laura', 'Rodriguez', '661046297', 'laura.rodriguez66@mail.com', '+5493408147235', 'Oeste', 'Mitre', 1543, '', 0, 'San Cristobal', 'Santa Fe'),
(67, 'Juan', 'Rodriguez', '673849443', 'juan.rodriguez67@mail.com', '+5493408290676', 'Este', 'Mitre', 1712, '', 0, 'San Cristobal', 'Santa Fe'),
(68, 'Pedro', 'Sanchez', '685676527', 'pedro.sanchez68@mail.com', '+5493408234704', 'Norte', 'Sarmiento', 475, '', 0, 'San Cristobal', 'Santa Fe'),
(69, 'Maria', 'Lopez', '699455857', 'maria.lopez69@mail.com', '+5493408370409', 'Norte', 'Belgrano', 1634, '', 0, 'San Cristobal', 'Santa Fe'),
(70, 'Luis', 'Diaz', '704748332', 'luis.diaz70@mail.com', '+5493408748975', 'Centro', 'Oroño', 417, '', 0, 'San Cristobal', 'Santa Fe'),
(71, 'Carlos', 'Torres', '711594242', 'carlos.torres71@mail.com', '+5493408387023', 'Sur', 'San Martin', 165, '', 0, 'San Cristobal', 'Santa Fe'),
(72, 'Maria', 'Sanchez', '723049037', 'maria.sanchez72@mail.com', '+5493408578345', 'Sur', 'San Martin', 1583, '', 0, 'San Cristobal', 'Santa Fe'),
(73, 'Ana', 'Martinez', '733925244', 'ana.martinez73@mail.com', '+5493408937703', 'Jose Dho', 'Mitre', 1806, '', 0, 'San Cristobal', 'Santa Fe'),
(74, 'Ana', 'Gomez', '745756511', 'ana.gomez74@mail.com', '+5493408500962', 'Norte', 'San Martin', 1850, '', 0, 'San Cristobal', 'Santa Fe'),
(75, 'Carlos', 'Lopez', '755140700', 'carlos.lopez75@mail.com', '+5493408642833', 'Oeste', 'Mitre', 1056, '', 0, 'San Cristobal', 'Santa Fe'),
(76, 'Miguel', 'Lopez', '761518988', 'miguel.lopez76@mail.com', '+5493408665500', 'Norte', 'San Martin', 343, '', 0, 'San Cristobal', 'Santa Fe'),
(77, 'Sofia', 'Rodriguez', '777190395', 'sofia.rodriguez77@mail.com', '+5493408041017', 'Jose Dho', 'Belgrano', 1067, '', 0, 'San Cristobal', 'Santa Fe'),
(78, 'Luis', 'Torres', '786991463', 'luis.torres78@mail.com', '+5493408211703', 'Jose Dho', 'Mitre', 1221, '', 0, 'San Cristobal', 'Santa Fe'),
(79, 'Laura', 'Fernandez', '794836123', 'laura.fernandez79@mail.com', '+5493408840496', 'Oeste', 'Belgrano', 904, '', 0, 'San Cristobal', 'Santa Fe'),
(80, 'Luis', 'Gomez', '809767772', 'luis.gomez80@mail.com', '+5493408210215', 'Este', 'Oroño', 1342, '', 0, 'San Cristobal', 'Santa Fe'),
(81, 'Miguel', 'Rodriguez', '812750300', 'miguel.rodriguez81@mail.com', '+5493408737152', 'Jose Dho', 'Mitre', 1309, '', 0, 'San Cristobal', 'Santa Fe'),
(82, 'Ana', 'Fernandez', '824495682', 'ana.fernandez82@mail.com', '+5493408668680', 'Este', 'San Martin', 264, '', 0, 'San Cristobal', 'Santa Fe'),
(83, 'Luis', 'Rodriguez', '831162661', 'luis.rodriguez83@mail.com', '+5493408629142', 'Sur', 'Belgrano', 1822, '', 0, 'San Cristobal', 'Santa Fe'),
(84, 'Luis', 'Sanchez', '845066665', 'luis.sanchez84@mail.com', '+5493408490591', 'Norte', 'Mitre', 138, '', 0, 'San Cristobal', 'Santa Fe'),
(85, 'Laura', 'Martinez', '855998327', 'laura.martinez85@mail.com', '+5493408343238', 'Oeste', 'San Martin', 1251, '', 0, 'San Cristobal', 'Santa Fe'),
(86, 'Luis', 'Torres', '861451834', 'luis.torres86@mail.com', '+5493408294503', 'Juan XXIII', 'Mitre', 830, '', 0, 'San Cristobal', 'Santa Fe'),
(87, 'Luis', 'Torres', '876387561', 'luis.torres87@mail.com', '+5493408799250', 'Centro', 'Belgrano', 1633, '', 0, 'San Cristobal', 'Santa Fe'),
(88, 'Maria', 'Sanchez', '885800846', 'maria.sanchez88@mail.com', '+5493408032733', 'Centro', 'Mitre', 1132, '', 0, 'San Cristobal', 'Santa Fe'),
(89, 'Pedro', 'Diaz', '898808230', 'pedro.diaz89@mail.com', '+5493408368668', 'Oeste', 'Mitre', 1104, '', 0, 'San Cristobal', 'Santa Fe'),
(90, 'Sofia', 'Garcia', '908354619', 'sofia.garcia90@mail.com', '+5493408459921', 'Sur', 'San Martin', 1754, '', 0, 'San Cristobal', 'Santa Fe'),
(91, 'Carlos', 'Garcia', '918387625', 'carlos.garcia91@mail.com', '+5493408183272', 'Juan XXIII', 'Mitre', 1291, '', 0, 'San Cristobal', 'Santa Fe'),
(92, 'Ana', 'Sanchez', '926658585', 'ana.sanchez92@mail.com', '+5493408878592', 'Centro', 'Belgrano', 1501, '', 0, 'San Cristobal', 'Santa Fe'),
(93, 'Pedro', 'Perez', '933724713', 'pedro.perez93@mail.com', '+5493408976492', 'Sur', 'Mitre', 644, '', 0, 'San Cristobal', 'Santa Fe'),
(94, 'Maria', 'Diaz', '946790399', 'maria.diaz94@mail.com', '+5493408910712', 'Juan XXIII', 'Mitre', 1346, '', 0, 'San Cristobal', 'Santa Fe'),
(95, 'Sofia', 'Torres', '956161260', 'sofia.torres95@mail.com', '+5493408795834', 'Centro', 'Oroño', 283, '', 0, 'San Cristobal', 'Santa Fe'),
(96, 'Juan', 'Perez', '969366560', 'juan.perez96@mail.com', '+5493408766623', 'Oeste', 'Belgrano', 1884, '', 0, 'San Cristobal', 'Santa Fe'),
(97, 'Lucia', 'Gomez', '978774998', 'lucia.gomez97@mail.com', '+5493408064263', 'Oeste', 'Sarmiento', 808, '', 0, 'San Cristobal', 'Santa Fe'),
(98, 'Miguel', 'Martinez', '988304632', 'miguel.martinez98@mail.com', '+5493408692445', 'Este', 'San Martin', 133, '', 0, 'San Cristobal', 'Santa Fe'),
(99, 'Carlos', 'Martinez', '994623435', 'carlos.martinez99@mail.com', '+5493408040491', 'Centro', 'Sarmiento', 1756, '', 0, 'San Cristobal', 'Santa Fe'),
(100, 'Lucia', 'Diaz', '1006244725', 'lucia.diaz100@mail.com', '+5493408113460', 'Sur', 'Belgrano', 590, '', 0, 'San Cristobal', 'Santa Fe'),
(102, 'David', 'Rojas', '44495691', 'sanfix.informatica@gmail.com', '5493408435682', 'Juan XXIII', 'Oronio', 123, '123', 123, 'San Cristobal', 'Santa Fe');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `toptresmascotas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `toptresmascotas` (
`idMascota` int(11)
,`Usuario_idUsuario` int(11)
,`nombre` varchar(80)
,`categoria` varchar(45)
,`raza` varchar(50)
,`edad` int(11)
,`color` varchar(45)
,`height` varchar(45)
,`imagen` varchar(200)
,`chipNro` varchar(50)
,`status` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `Persona_idPersona` int(11) NOT NULL,
  `rol` enum('Administrador','Voluntario','Publicista','Veterinario','Usuario','Invitado') COLLATE utf8_bin NOT NULL,
  `password` varchar(80) COLLATE utf8_bin NOT NULL,
  `fecha_alta` date DEFAULT current_timestamp(),
  `habilitado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Persona_idPersona`, `rol`, `password`, `fecha_alta`, `habilitado`) VALUES
(1, 1, 'Veterinario', '$2y$10$y9S1Yl6gX0iFZYlEbA4ej.va.mhwzSY1RD5GIKWcYnVnSzC24NzvC', '2025-01-14', 1),
(2, 10, 'Administrador', '$2y$10$hNj1wbxHH8VnFN2G8bxLF.9FJjVPM66Pzg/CsLVgF7dhvuR0XIFPG', '2025-08-25', 1),
(3, 3, 'Administrador', '$2y$10$P4RO0kEqJaIWn8LCJmLiyuQ6spFVhFpzhTkfsiyw9KPrMlgo/Rwty', '2025-05-28', 1),
(4, 4, 'Invitado', '$2y$10$ZT6MfOsj1Sq6chsLZ.V0TOHAXWu/lS0p5ezBtznqm5E4f4M5PhP8y', '2025-06-22', 1),
(5, 13, 'Usuario', '$2y$10$zwYndFl2sca2wLFWnYUoZuxoCcyshNfT6Icj/HbBzKMcDUZg0UVHu', '2025-08-25', 1),
(6, 6, 'Veterinario', '$2y$10$P1OVCkQAxNYaqCNOMYBOIOe3LZHadybfknxDJfb2WcMv8O9xqPyYW', '2024-09-25', 1),
(7, 15, 'Invitado', '$2y$10$/WJ0xU87eYmpYkQ6KwBq5OVYEewkFNnVZkWZqx6jTCz71pMhrfZvC', '2025-08-25', 1),
(8, 16, 'Veterinario', '$2y$10$BC6k3yO3gceLC7AAn.f9WOqlrBRpga54H2xC1R3RtPPqpOwz9ABn.', '2025-08-25', 1),
(9, 9, 'Veterinario', '$2y$10$QZvRtcdiMDSY8Ru8Uej0Ve3w9fLdvT5VyO1y5DtAigKjHDKkLlYSq', '2025-08-23', 1),
(10, 10, 'Usuario', '$2y$10$2Ptk1lkBuN5EpiycPaQOVu6UysqLndIh5S2rB8HRAglQz4kf//qOK', '2024-09-06', 1),
(11, 11, 'Invitado', '$2y$10$/igvEOpZ7vK2bf3dhCIx1epzRU/SW5ZvzhYKn/vxIZu9r2rTV59jW', '2025-05-28', 1),
(12, 12, 'Administrador', '$2y$10$QQtWnrmgpHwkJTZ7Uix8Oe0RysRqDZFiJQS9ABX82pqGqwicfOBIe', '2024-11-07', 1),
(13, 13, 'Usuario', '$2y$10$vSRXETZrCCDpZroaUqOtvuDr65lxjljjnMvA/wmpvTE3lRrxMPNsG', '2024-10-27', 1),
(14, 14, 'Administrador', '$2y$10$JkQq7MxhymmpYA3e//hMe.1uFs4brQ690HzgMeEX3VSfyUBeS78DC', '2024-12-27', 1),
(15, 15, 'Usuario', '$2y$10$nyjQc.GDSZnC.ou2o8nCOOaU21ACdbt0CF/f7BRKhF354WVeI4j62', '2025-06-08', 1),
(16, 16, 'Invitado', '$2y$10$qQXUJvtatE/7eCeBKivuGOL.VsXhvCoqQr0q7oQRRjNan98DYgAe.', '2024-09-04', 1),
(17, 17, 'Usuario', '$2y$10$cRpsNXdtB2BIkQOtI8IKyuCvnFxWfn2EwzQTpIrMb9L27K8A86tWS', '2025-01-09', 1),
(18, 18, 'Administrador', '$2y$10$BzrtJnnsRFyOSStoXxJKQ.u.3G1iEnc455Sp4z/tXzvqT7Fg/MWm.', '2025-01-28', 1),
(19, 19, 'Usuario', '$2y$10$WKLPiXKX2viquvmz2dn2nuYvZFI0XqbjA5EUMW8Uoc36ILGat.0dC', '2025-07-10', 1),
(20, 20, 'Invitado', '$2y$10$sCBgJOO0L1Ew4OVOF5J0deQB1l4NT7nPkYqUeQUmvxcnWuIfIVXBe', '2024-12-16', 1),
(21, 21, 'Veterinario', '$2y$10$J1rhZJAxw/eEw8M6YMJ/.OkYxc35TuVZHncDTJvlixF6y/w4ZTLOW', '2024-10-21', 1),
(22, 22, 'Usuario', '$2y$10$PShPVzzSe0w47MeHAE.n..rRShc1fs68CI4B6qwJYygrL88enBPWa', '2025-03-27', 1),
(23, 23, 'Invitado', '$2y$10$Qs25oJ/pzukGcqhqw0R6jebEaU6/U0Bcp/DMC0y0g9.3r1udbdNnu', '2025-08-11', 1),
(24, 24, 'Administrador', '$2y$10$3mHE5EKnn3D9tsaSAtXunu1QUe9YMCr3kaVibwSsc236gCWunecoa', '2024-11-05', 1),
(25, 25, 'Invitado', '$2y$10$qk2E.A8DDhXLqOsAuyzZFeZEwccN4T9KVEeuK1G8z2ApG2ifN4wBS', '2025-05-02', 1),
(26, 26, 'Administrador', '$2y$10$bIOHY3E/1peSRdxsl1CaJutzy5i9cSE/97VWq3GqIl70cpxuY5ZmK', '2025-07-04', 1),
(27, 27, 'Veterinario', '$2y$10$rw4gQ2PbGjTYScs..4tnCuy5PqlTWtMtoE.dfSVnuaq0nHYvh1AkC', '2025-07-12', 1),
(28, 28, 'Usuario', '$2y$10$vOmDO05aUkfKDqrBUL0.LOjWZne47uFmPXUzAx0aVHzGKkIDL8E1K', '2025-03-17', 1),
(29, 29, 'Administrador', '$2y$10$AyShUF2fyaHJLME6IXbBEeV4ONt4r/eHw80e/.Li9DFfMDxTzX9gq', '2025-07-21', 1),
(30, 30, 'Administrador', '$2y$10$lZz1yxJgGZnYg8cjJgj8nO74IJsmuv3wuULoS8BAO4na3M5EhC3W.', '2025-07-09', 1),
(31, 31, 'Veterinario', '$2y$10$UGZNmlZik3oy7dfONLKHfezohS1PcjSqEkKUearvxxifo5ZeIQVlC', '2024-11-18', 1),
(32, 32, 'Administrador', '$2y$10$S53qgCZo2bZdMGz9HvF8yuMTHZeAKdPn9Zk/Am5KvOIvE5U5XzU1.', '2025-08-07', 1),
(33, 33, 'Administrador', '$2y$10$p/nmVXmflDHZErF2uKE6WeG/4AER6MQU0eTLrap9lKSalxpEhdYVm', '2024-09-19', 1),
(34, 34, 'Invitado', '$2y$10$j3gBITQtYlgIu3EtA3ME4.k.FqShn.Wu9ZFlYtIYCzKQz3s95Viqe', '2024-11-08', 1),
(35, 35, 'Invitado', '$2y$10$S6Z1iKBtRBFbP1WvztMkeuq8uuEs0uW44T806Th4lzgnDR4wj68ia', '2025-03-07', 1),
(36, 36, 'Usuario', '$2y$10$06jR9jGjI3/YQ4c7Kza0MevQzMRRspE.Mi1Tu8YXSxQTG5C73N0M6', '2025-08-02', 1),
(37, 37, 'Administrador', '$2y$10$gsqO/.zolhJZ4ECziqFA/.KtefHfyq7EUCBQnNXCe2MXw6hI4J8MK', '2025-01-31', 1),
(38, 38, 'Usuario', '$2y$10$crqG0TgZqjAEaoyMw8qZheyXCEZXX2h3e.gBjxNOCfcSzVTxlZ4Oa', '2025-01-31', 1),
(39, 39, 'Usuario', '$2y$10$PY3LtdJLJBoBr.9RlSXVz.Ig7s5FMFZA0kLfulg9n8rpoAozbecUO', '2025-04-28', 1),
(40, 40, 'Administrador', '$2y$10$VEAHijduqLFe9wgGiBYHx.AR4aGeGFN/xjEA2Ajf15/sFTuHdXw1e', '2024-09-24', 1),
(41, 41, 'Veterinario', '$2y$10$VZUUPaKWiNtJOa9x5Pm9HuZoKkEBqULDoxTTwQs35Z1lbf7zJwULy', '2024-11-01', 1),
(42, 42, 'Invitado', '$2y$10$GZfdac3U90wAhWAkdH9Z5e/BhjCacmV8Y.0rTzsJMTHkO8XYhEU2.', '2024-10-29', 1),
(43, 43, 'Administrador', '$2y$10$tsnxA1grPbawoMM12sp27OsTdiwUwbFmEFOV0Y0SKJlf8vgICKf9a', '2025-03-11', 1),
(44, 44, 'Administrador', '$2y$10$igFhC71XQIdAWFSb/ezVLun91MYDQefvqsdcz/afzwWSXFgFKbD1G', '2025-01-28', 1),
(45, 45, 'Veterinario', '$2y$10$5.kTuW7LSgv3lJpb6pqU1Oen7kLmdbRVWQxXKMrWyuX/5Wa0imp/K', '2025-03-31', 1),
(46, 46, 'Administrador', '$2y$10$7LVWosHLLWGhHYwNupMEvOx7sWGXXP0lV7IDZMoK6b5oYzRtZce46', '2025-02-03', 1),
(47, 47, 'Usuario', '$2y$10$6RUzkcJrP6pCfJBwzJfIxOWlBGzYe5qSgsKmrfUGKYJR5TG/b4FjK', '2025-06-15', 1),
(48, 48, 'Invitado', '$2y$10$52qNkuAymLBa7gBwv7vSLepfKpbvGOOlAbMzQjWH8RQbdkXX58ASy', '2025-01-12', 1),
(49, 49, 'Administrador', '$2y$10$5r038RGuPPrBkxpnHoC.bOJ.xzeJOYFPJSd3ouiePuYRAYrqQhjvu', '2025-08-06', 1),
(50, 50, 'Administrador', '$2y$10$8ZABkp7OF0QmN042w4iBSesLRvwr3fk36KFC.PWY5.zO7NeHhdrt6', '2025-06-23', 1),
(51, 51, 'Veterinario', '$2y$10$u5A7SL1SLfdmCfSE31EM5.HG2Q2PQpCHl/dF.qjV5v.TNvF7NXu4W', '2025-07-30', 1),
(52, 52, 'Administrador', '$2y$10$wazIcOxnC1PGNqXC1xWpjutn1YBiPiNCfADwHz9Qrq0l1D33b2L2G', '2025-08-27', 1),
(53, 53, 'Usuario', '$2y$10$AUXy4zIrjxST8pb9uSiKUOVoNpepOiq7jAAKSd5n5NY/UuVLeVbUW', '2024-12-17', 1),
(54, 54, 'Administrador', '$2y$10$t9lRep1e3T20m49geB7.F.qDuVqC0sfoGJRoVuvp/Q4EFEXMNfGe2', '2025-02-09', 1),
(55, 55, 'Administrador', '$2y$10$ST4vnva8DFRX/jHnmm7GNe0g//6Q7DQhoLkIgMZTM81/sMIn6lLVi', '2025-01-21', 1),
(56, 56, 'Veterinario', '$2y$10$VR5BWmvWGI2o05kWS3e.t.uFdAfsAb4SSHv8HVgj8tONJZBFVPlpC', '2025-07-09', 1),
(57, 57, 'Veterinario', '$2y$10$XHlnmpDzcOOVxastsythS.543Wg320mc2igRmbD2DKPpd0RduPn0y', '2025-06-16', 1),
(58, 58, 'Invitado', '$2y$10$DO359QBhlWgvMIg3fpFodeGmQWGTlYNHR/6bZ8vU6UPX6mY72sPQW', '2024-12-04', 1),
(59, 59, 'Veterinario', '$2y$10$bQ7C7Xrrj3lsfXJpl2/97.1nVl9WvcqWr0wwTDjN1.244/.Uvvr7i', '2025-07-12', 1),
(60, 60, 'Invitado', '$2y$10$OP04X5NV196FqUIuho7KyOQ6W8ZSyuA/nLhW0oA51QuQwHoxyW8bC', '2025-08-08', 1),
(61, 61, 'Administrador', '$2y$10$L4hQ/oiP6TtCkMACljVCuu0nIzIbSSY35HlOvqr08BcSdWYlkjXrS', '2025-03-28', 1),
(62, 62, 'Administrador', '$2y$10$ruNbK3pm8Gqj94hncJRsWOA4udpT/oGEi03sk.OwDiwjIpo.0oiNG', '2025-01-20', 1),
(63, 63, 'Veterinario', '$2y$10$zVng8mDkRLjDYZjcCsHxQe/hAvLnvMZuI7.kNRzuaxmKBLiKQO8pC', '2024-09-23', 1),
(64, 64, 'Administrador', '$2y$10$R.gwG3/lA6CV6gRVNqJB/eXnjziV/AmD3K4CBPAjY4ZUX.A9MlpV2', '2024-12-23', 1),
(65, 65, 'Usuario', '$2y$10$1DAop2IXeUKKO1TzDph5oe8JHxpQxqr0anHZKPOu/AIYkAngYWbcu', '2024-11-08', 1),
(66, 66, 'Usuario', '$2y$10$mP7V2gHPjdzwapOEZ5jET.fE4EWdCg/9QkHvRBLiPsLmnUw0HzQWO', '2025-02-01', 1),
(67, 67, 'Invitado', '$2y$10$Nqskov5GhZaXTMtRB2O65.Nm0Alu.0v0nQiazOy4mc8j2X4eSDOta', '2025-05-06', 1),
(68, 68, 'Administrador', '$2y$10$HlZpbeyVwRYaFZPuGyz0G.J.9wfYSUyh2TPqRFVqOD9vMOOYxVw8.', '2024-10-10', 1),
(69, 69, 'Invitado', '$2y$10$K/eGUHr7YbUWx4wZ/rm6Ve4WG7HZPAdJv3THwZnsE1P0vjs7EYPtK', '2025-09-01', 1),
(70, 70, 'Invitado', '$2y$10$B/mM3Dd9fX/95ZUH6Ii8leV.S47X0LVwgJU1yYKk5lbnzMoVRmrgS', '2025-05-07', 1),
(71, 71, 'Administrador', '$2y$10$vvsiq/9bXb8/0DbHddbA/uxBF33NjN3fyxgRSA2AF/6nZI2k4PxUq', '2025-03-07', 1),
(72, 72, 'Usuario', '$2y$10$cQpQx0wnKbXzg1wWjuPLaulFad//lC5cqkp9Kvzyx3T1XfrNAoUei', '2025-03-31', 1),
(73, 73, 'Usuario', '$2y$10$v8DL2m/2YPhY5ZLuMSU0q.yZSMZfZHaRIF0CoU.ujJDZ.XyF77mlO', '2025-07-06', 1),
(74, 74, 'Veterinario', '$2y$10$i8D58tDD0eDOqA63XCf9TerYGYfeh87Jg6j8gSoUSCZbUbNCOchYG', '2025-04-09', 1),
(75, 75, 'Veterinario', '$2y$10$L1tLMf9lRav1kVADDr7qJOUXhyQk.gaD.KVDWwo9UZhyjCYzzSj2u', '2025-02-23', 1),
(76, 76, 'Veterinario', '$2y$10$HdqvAgMWeVNzJRR4PhlEReCjCg2F.s1Ztjg6zS634VQ3WNHsvIZB2', '2025-07-27', 1),
(77, 77, 'Invitado', '$2y$10$HmlPs27XNNScylusQn8G8emggN9W0chNDJ9nC3HBVnegPAsxhwXZC', '2024-12-01', 1),
(78, 78, 'Administrador', '$2y$10$QyX4u1QAQp4nDbTr8vbzBONuuVMSiqxb/2HQVjmXKbRwwS4YH2t3W', '2024-11-08', 1),
(79, 79, 'Veterinario', '$2y$10$ntwpqfpj7UEl8Lyya0OHtOiBTUW1bkxn2PvMRzQTbKnm2nISnNyfG', '2025-03-21', 1),
(80, 80, 'Invitado', '$2y$10$OqQyrnApNrnXO42IIsR4R.VHlE2XHkBSUkjxvcwR0Nvpbs/bG2.ca', '2025-01-17', 1),
(81, 81, 'Usuario', '$2y$10$RJvE4qsMxFqw2lE4CkyXquPF3/z1BDS0L.43N5PUefsaxC8eswZSC', '2024-11-25', 1),
(82, 82, 'Invitado', '$2y$10$K8jT.rKZ2T6e4mHf.yxhTOo742Y9emkSZAXBLrjv5yzNZJLjEESTa', '2024-09-19', 1),
(83, 83, 'Veterinario', '$2y$10$iA5Jg6Jtn5hmHg3gpqi5T.st.ATq/4jWlsI7nua.3aCjuLVe9g1ny', '2024-09-18', 1),
(84, 84, 'Administrador', '$2y$10$wHgSLzSdnrTGpZ.yBoB4FOe7kYXjU4rQFHAnbE3vRrm8dN/JtosIy', '2025-02-24', 1),
(85, 85, 'Administrador', '$2y$10$qDkzuI.zIyDgz4kEmfKSWu1TkBctdO9Do/hkpZF6QYHtd4paXhfQW', '2025-02-03', 1),
(86, 86, 'Administrador', '$2y$10$zv1aSx5Odo9gPLr.8zxoQ./qzcKiamDXibV6Z85LMRX9gKZXLQoJW', '2024-11-28', 1),
(87, 87, 'Veterinario', '$2y$10$OJR0EV518HyNat60/PvwLOomPsHfnstCblf8MR6VefIUhenAjGKIG', '2024-11-29', 1),
(88, 88, 'Administrador', '$2y$10$J/FO/rqGrT.VYhEKjAc89eIJAg7Lo9Omx5v4elZoQ/MKgSDvjy1Xm', '2025-08-31', 1),
(89, 89, 'Invitado', '$2y$10$MNlXM6tYRpWkLwHhAO5xYub1ekXEwoCD0mT2u3dUyZ3un/MMhXSm2', '2024-10-29', 1),
(90, 90, 'Veterinario', '$2y$10$NZ1oDKKvZzzgg1fsRxF2b.S3Ml2KmU/gvwriVLQhTwB/P/rnm8WL2', '2024-12-24', 1),
(91, 91, 'Usuario', '$2y$10$MPxlyi6v81FprWPW67jW/Oh3WXPl75K2d/HQN8NW2QxbWU5FO2d8m', '2024-10-21', 1),
(92, 92, 'Usuario', '$2y$10$50vB5i9DhqdMTiPMq328Mu.UIBLrfOgwYdoxA0Oq7L7Je2kbc0seu', '2025-01-28', 1),
(93, 93, 'Veterinario', '$2y$10$9a1WA040NSIdA0w684jjleOErJCRuCcbsPPb.D5IhpC/LEOMcGJmO', '2025-02-01', 1),
(94, 94, 'Invitado', '$2y$10$B/L.pVMk4Cg/tvuZAF5sluF2MyhA3IwxG1KGeggvyg809GPMYz.oO', '2025-01-02', 1),
(95, 95, 'Invitado', '$2y$10$sURiI2.jSMGCWr38lQUUz.AOH1nWYlpUKA9vEsRq9yjfZ4fiei4sC', '2025-04-30', 1),
(96, 96, 'Usuario', '$2y$10$OYcebMMCsHt2B.w3efcOyeyxMCSjk/L5JDjc65KHaDk7aDFYu3wAa', '2024-09-06', 1),
(97, 97, 'Veterinario', '$2y$10$p7wBpTLVb04y35gzJUUxb.npK55qJ6XsnS.JfXE3KvPFJJF6mdfGq', '2025-03-11', 1),
(98, 98, 'Veterinario', '$2y$10$8q.SUvaB0gvGbEXlbD8IsOVUynQr3aTphzkFfFg4CzmDuncm5DmKa', '2025-06-09', 1),
(99, 99, 'Usuario', '$2y$10$xXgu82vrv/YOWP3uDldGJu1DNOyoP2x2526Fctu6REkxDzJskmfhq', '2025-05-14', 1),
(100, 100, 'Usuario', '$2y$10$z/MM19xV/wR99awWWIXiYeReEOUKmAkS9IVsZTsrnPr/UcU3kwjeW', '2025-03-13', 1),
(102, 102, 'Veterinario', '$2y$10$wBqQOOFD7hLyWwVI8JnRF.WxgTZNQGGN5rzbDVJk0Ry6a.yzR8Y/m', '2025-09-15', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas`
--

CREATE TABLE `vacunas` (
  `idVacunas` int(11) NOT NULL,
  `nombre` varchar(80) COLLATE utf8_bin NOT NULL COMMENT 'Nombre del laboratorio que fabrica la vacuna.\n',
  `descripcion` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `fabricante` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `dosis_requeridas` int(11) DEFAULT 1 COMMENT 'Si es una sola dosis o necesita varias aplicaciones.',
  `intervalo_dias` int(11) DEFAULT NULL COMMENT 'Si la vacuna necesita una segunda dosis, cuántos días deben pasar antes de aplicarla.\n',
  `contraindicaciones` text COLLATE utf8_bin DEFAULT NULL COMMENT 'Información de posibles efectos secundarios o advertencias.\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='La función de ésta tabla radica en registrar el tipo de vacuna que se aplica. Luego de que la mascota posea el certificado expedido por el agente Veterinario, con las estampillas correspondientes y la firma/sello oficial, se debe registrar la vacuna que se aplicó. Ésta vacuna, quedará guardada en un historial, para así no tener que rellenar ésta misma, en caso de que la misma ya se encuentre en la base de datos, no hará falta volver a incorporarla facilitando la selección de ésta, y los unicos datos que deberá variar son su número de serie, fechas de interés, además del agente Veterinario que hizo tal operación.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas_mascota`
--

CREATE TABLE `vacunas_mascota` (
  `idMascotaVacuna` int(11) NOT NULL,
  `Vacunas_idVacunas` int(11) NOT NULL,
  `Mascota_idMascota` int(11) NOT NULL,
  `veterinario` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `numero_serie` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `fecha_elaboracion` date DEFAULT NULL,
  `fecha_colocacion` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `proxima_dosis` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Dentro de ésta tabla, se relaciona la Mascota y la vacuna que fue aplicada. Dentro de la relación, se puede especificar, qué agente Veterinario realizó la colocación, así como además, la fecha en que se realizó. Incorporando datos importantes de la misma, que claro son opcionales. \n\nEs importante detallar, primero, que la vacuna tenga una fecha de colocación y además, especificar cuándo ésta caduca, para así determinar si ésta misma es vieja, si requiere renovación, o si el dueño del animal perdió o dejó atrás el seguimiento de salud de su mascota.\n';

-- --------------------------------------------------------

--
-- Estructura para la vista `toptresmascotas`
--
DROP TABLE IF EXISTS `toptresmascotas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `toptresmascotas`  AS SELECT `mascota`.`idMascota` AS `idMascota`, `mascota`.`Usuario_idUsuario` AS `Usuario_idUsuario`, `mascota`.`nombre` AS `nombre`, `mascota`.`categoria` AS `categoria`, `mascota`.`raza` AS `raza`, `mascota`.`edad` AS `edad`, `mascota`.`color` AS `color`, `mascota`.`height` AS `height`, `mascota`.`imagen` AS `imagen`, `mascota`.`chipNro` AS `chipNro`, `mascota`.`status` AS `status` FROM `mascota` LIMIT 0, 3 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adopciones`
--
ALTER TABLE `adopciones`
  ADD PRIMARY KEY (`idAdopciones`),
  ADD KEY `fk_Adopciones_Mascota1_idx` (`Mascota_idMascota`),
  ADD KEY `fk_Adopciones_Usuario1_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`idDonaciones`),
  ADD KEY `fk_Donaciones_Usuario1_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEventos`),
  ADD UNIQUE KEY `titulo_UNIQUE` (`titulo`),
  ADD KEY `fk_Eventos_Usuario1_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`idMascota`),
  ADD UNIQUE KEY `Index_Mascota_chipNro` (`chipNro`),
  ADD KEY `fk_Mascota_Usuario1_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticias`),
  ADD KEY `fk_Noticias_Usuario1_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `perdidos`
--
ALTER TABLE `perdidos`
  ADD UNIQUE KEY `fk_Perdidos_Mascota1_idx` (`Mascota_idMascota`) USING BTREE;

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD UNIQUE KEY `dni_UNIQUE` (`dni`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_Usuario_Persona1_idx` (`Persona_idPersona`);

--
-- Indices de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  ADD PRIMARY KEY (`idVacunas`);

--
-- Indices de la tabla `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD PRIMARY KEY (`idMascotaVacuna`),
  ADD UNIQUE KEY `numero_serie_UNIQUE` (`numero_serie`),
  ADD KEY `fk_Vacunas_has_Mascota_Mascota1_idx` (`Mascota_idMascota`),
  ADD KEY `fk_Vacunas_has_Mascota_Vacunas1_idx` (`Vacunas_idVacunas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adopciones`
--
ALTER TABLE `adopciones`
  MODIFY `idAdopciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `idDonaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `idMascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  MODIFY `idVacunas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  MODIFY `idMascotaVacuna` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adopciones`
--
ALTER TABLE `adopciones`
  ADD CONSTRAINT `fk_Adopciones_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Adopciones_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD CONSTRAINT `fk_Donaciones_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_Eventos_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `fk_Mascota_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_Noticias_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `perdidos`
--
ALTER TABLE `perdidos`
  ADD CONSTRAINT `fk_Perdidos_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_Persona1` FOREIGN KEY (`Persona_idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD CONSTRAINT `fk_Vacunas_has_Mascota_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Vacunas_has_Mascota_Vacunas1` FOREIGN KEY (`Vacunas_idVacunas`) REFERENCES `vacunas` (`idVacunas`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
