-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2025 a las 15:42:54
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
-- Base de datos: `asd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adopciones`
--

CREATE TABLE `adopciones` (
  `idAdopciones` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `Mascota_idMascota` int(11) DEFAULT NULL,
  `fecha_adopcion` date NOT NULL,
  `estado` enum('En proceso','Vigente','Rechazada') COLLATE utf8_bin DEFAULT NULL,
  `observacionesl` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `adopciones`
--

INSERT INTO `adopciones` (`idAdopciones`, `Usuario_idUsuario`, `Mascota_idMascota`, `fecha_adopcion`, `estado`, `observacionesl`) VALUES
(9, 113, 27, '2025-12-04', 'Vigente', NULL);

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

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEventos`, `Usuario_idUsuario`, `titulo`, `fecha_inicio`, `fecha_fin`, `hora_inicio`, `descripcion`, `estado`, `imagen_portada`) VALUES
(1, 113, 'Prueba', '2025-12-04', '2025-12-24', '12:22:00', 'Hola mundo', 'Pendiente', '/public/res/eventos/evento-1764896802-gatos-blanco-negro.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_acciones`
--

CREATE TABLE `log_acciones` (
  `idLog` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `accion` text NOT NULL,
  `ip_origen` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log_acciones`
--

INSERT INTO `log_acciones` (`idLog`, `usuario_id`, `rol`, `accion`, `ip_origen`, `user_agent`, `fecha`) VALUES
(1, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '200.0.215.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 21:20:01'),
(2, 106, 'Veterinario', 'Ha iniciado sesión David Rojas con el DNI: 44495699', '200.0.215.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 21:23:04'),
(3, 108, 'Usuario', 'Ha iniciado sesión Valentín  Giovannini  con el DNI: 42533896', '181.189.214.35', 'Mozilla/5.0 (Linux; Android 14; 23100RN82L Build/UP1A.231005.007; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.122 Mobile Safari/537.36 Instagram 406.0.0.58.159 Android (34/14; 320dpi; 720x1438; Xiaomi/Redmi; 23100RN82L; gale; mt6768; es_US; 822918295; IABMV/1)', '2025-11-16 21:45:17'),
(4, 106, 'Administrador', 'Ha iniciado sesión David Rojas con el DNI: 44495699', '200.0.215.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 22:15:21'),
(5, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '190.182.160.132', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-18 23:55:56'),
(6, 106, 'Administrador', 'Ha iniciado sesión David Rojas con el DNI: 44495699', '190.182.160.132', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-18 23:56:23'),
(7, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '200.0.215.47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-19 13:48:36'),
(8, 106, 'Administrador', 'Ha iniciado sesión David Rojas con el DNI: 44495699', '200.0.215.125', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-21 19:28:07'),
(9, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '190.182.160.127', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-25 19:09:28'),
(10, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '185.40.4.143', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 19:15:42'),
(11, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '200.0.215.39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 19:26:21'),
(12, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '200.0.215.39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 19:34:42'),
(13, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '181.9.213.102', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-25 20:15:05'),
(14, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '181.9.213.102', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-25 20:16:20'),
(15, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '201.217.246.228', 'Mozilla/5.0 (Linux; Android 14; Pixel 6 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.6261.119 Mobile Safari/537.36 OPR/81.2.4292.78581', '2025-11-25 20:16:27'),
(16, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '186.126.46.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 20:16:51'),
(17, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '181.9.213.102', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-25 20:31:46'),
(18, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '186.126.46.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 20:35:16'),
(19, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '181.9.213.102', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-11-25 20:42:50'),
(20, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 13:19:29'),
(21, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 18:33:49'),
(22, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 18:48:58'),
(23, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '192.168.100.71', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-04 18:56:53'),
(24, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '192.168.100.71', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-04 20:02:57'),
(25, 105, 'Administrador', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 21:17:29'),
(26, 105, 'Usuario', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 21:17:40'),
(27, 105, 'Usuario', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 21:20:20'),
(28, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 21:28:20'),
(29, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 21:57:37'),
(30, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 22:04:47'),
(31, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 22:40:34'),
(32, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 22:43:08'),
(33, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 00:57:33'),
(34, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 01:08:14'),
(35, NULL, NULL, 'Se ha registrado un nuevo usuario.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 01:12:34'),
(36, NULL, NULL, 'Se ha registrado un nuevo usuario.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 01:13:31'),
(37, NULL, NULL, 'Se ha registrado un nuevo usuario.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 01:14:34'),
(38, NULL, NULL, 'Se ha registrado un nuevo usuario.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 01:22:35'),
(39, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '192.168.100.71', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-05 01:45:15'),
(40, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 02:24:06'),
(41, 105, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: 105)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 02:24:23');

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
(20, 111, 'aramis', 'perro', 'border', 0, 'blanco y negro', 'grande', '/public/res/animal_profiles/photo-1764103738-dev2.png', '2d5f825583', 'Adoptado'),
(27, 113, 'Junny', 'Gato', 'Mestizo', 4, 'Naranja, Marrón, Blanco, Gris', 'Pequeño', '/public/res/animal_profiles/encuentro-1764902483-Imagen_de_WhatsApp_2025-12-04_a_las_19.07.02_0cf98a33.jpg', 'a1984a4dfb', 'Adoptado');

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
  `Mascota_idMascota` int(11) DEFAULT NULL,
  `fecha_de_reporte` date NOT NULL DEFAULT current_timestamp(),
  `lugar` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `status` enum('Encontrado','Perdido') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(106, 'Invitado', '', '00000000', 'guest@invitado.com', '', '', '', 0, NULL, NULL, '', ''),
(109, 'Valentín ', 'Giovannini ', '42533896', 'valentingiovannini1103@gmail.com', '3492703180', 'Otro', 'Domingo silva ', 1040, '', 0, 'Rafaela ', 'Santa fe '),
(110, 'Marisol', 'Vilches', 'maarchilve', 'maarchilves@gmail.com', 'maarchilves@gmail.com', 'Palermo', 'La paz', 686, '', 0, 'San Cristóbal ', 'Santa Fe'),
(111, 'Ana', 'Lagos', '32840911', 'analagos@gmail.com', '3408480921', 'Rivadavia', 'Derqui', 1742, 'San C', 0, 'San Cristóbal', 'Santa Fe'),
(112, 'neldo', 'croissant', '23', 'nlcroiss@gmail.com', '3408682511', 'Belgrano', 'salta', 1051, '', 0, 'san cristobal', 'santa fe'),
(114, 'David', 'Rojas', '44495699', 'sanfix.informatica@gmail.com', '+54 9 3408 435682', 'Juan XXIII', 'Oroño', 1023, '', 0, 'San Cristobal', 'Santa Fe'),
(115, 'Veterinaria', '\"El Doctor Perruno\"', '2534543454', 'veterinario@gmail.com', '+54 9 3408 123456', 'Sargento Bustamante', 'Urquiza', 1100, 'A', 2, 'San Cristobal', 'Santa Fe'),
(116, 'Administrador', 'del Sistema', '3213123123', 'admin@gmail.com', '+54 9 3408 876543', 'Juan XXIII', 'Oroño', 2321, '', 0, 'San Cristobal', 'Santa Fe'),
(117, 'Ayudante', 'del Sistema', '3321231231', 'gerente@gmail.com', '+54 9 3408 415374', 'Juan Caparroz', 'Caseros', 1280, 'A', 0, 'San Cristobal', 'Santa Fe'),
(118, 'El', 'Departamental', '1234567851', 'publicidad@gmail.com', '+54 9 3408 123214', 'Jose Dho', 'H. Yrigoyen', 544, '', 0, 'San Cristobal', 'Santa Fe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `Persona_idPersona` int(11) NOT NULL,
  `rol` enum('Administrador','Ayudante','Publicista','Veterinario','Usuario','Invitado') COLLATE utf8_bin NOT NULL,
  `password` varchar(80) COLLATE utf8_bin NOT NULL,
  `fecha_alta` date DEFAULT current_timestamp(),
  `habilitado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Persona_idPersona`, `rol`, `password`, `fecha_alta`, `habilitado`) VALUES
(105, 106, 'Invitado', '', '2025-11-15', 1),
(108, 109, 'Usuario', '$2y$10$XYpGMIM3Vw6UM970npR9N.ymARged.RPNbQqB7YggwXfkJDuHGL6W', '2025-11-15', 1),
(109, 110, 'Usuario', '$2y$10$Nv7NtsTuITll3MhJx6MQOuirKjI3iWjUI8IF/6OKyTgG6J3XDXlxi', '2025-11-15', 1),
(110, 111, 'Usuario', '$2y$10$oueAVklZqoitGePdyxABceXRzA8gm3JkAEGsfMqDtEqO9CCt/fnmO', '2025-11-25', 1),
(111, 112, 'Usuario', '$2y$10$Ojrqu3cV6QJGv7H8Ay4JRuyvwcaWbp6bjsXjRR1SeaQMjRA7ULyRa', '2025-11-25', 1),
(113, 114, 'Administrador', '$2y$10$FC3Rnd9P9vqbEIVrTk0nK.eB/7TqKKRbOXHLYqaerzlFuUt1gRxWi', '2025-12-04', 1),
(114, 115, 'Veterinario', '$2y$10$2syh1DX9BIpIfxEdClRqMeIrlT70.Ss92LZu5O/uRyJR8eHc5XM2m', '2025-12-04', 1),
(115, 116, 'Administrador', '$2y$10$FiWOwAfA2okMDvOoYeUHo.z6yLPYzcPRa9VGM1S/X4Jjq1xoCB07W', '2025-12-04', 1),
(116, 117, 'Ayudante', '$2y$10$zNxV1KgU0ynSdAr5KPE3DO9xvXQgu/G7aDdPlxKSG75p6JG.W64VK', '2025-12-04', 1),
(117, 118, 'Publicista', '$2y$10$1wnnugJyoeA7g66sLtRcX.SxonD54RaPubFvCsEhpSoZKvqVSn472', '2025-12-04', 1);

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

--
-- Volcado de datos para la tabla `vacunas`
--

INSERT INTO `vacunas` (`idVacunas`, `nombre`, `descripcion`, `fabricante`, `dosis_requeridas`, `intervalo_dias`, `contraindicaciones`) VALUES
(1, 'Rabia', 'Previene la rabia viral en animales domésticos. Obligatoria en muchos países.', 'Zoetis', 1, NULL, 'Puede causar fiebre leve y sensibilidad en el lugar de aplicación.'),
(2, 'Moquillo canino', 'Protege contra el virus del distemper canino, altamente contagioso.', 'MSD Animal Health', 3, 21, 'Fatiga temporal y fiebre leve.'),
(3, 'Parvovirus canino', 'Previene la enteritis viral grave en cachorros y adultos.', 'Elanco', 3, 21, 'Puede provocar vómitos leves y diarrea transitoria.'),
(4, 'Leptospirosis', 'Protege contra infecciones bacterianas transmitidas por agua contaminada.', 'Virbac', 2, 30, 'Reacciones locales, fiebre leve.'),
(5, 'Tos de las perreras', 'Previene Bordetella bronchiseptica y parainfluenza canina.', 'Zoetis', 1, NULL, 'Estornudos, tos leve post-vacunación.'),
(6, 'Hepatitis infecciosa canina', 'Previene adenovirus tipo 1, que afecta hígado y riñones.', 'Boehringer Ingelheim', 2, 30, 'Fatiga leve, inapetencia temporal.'),
(7, 'Triple felina', 'Protege contra panleucopenia, calicivirus y rinotraqueitis felina.', 'MSD Animal Health', 3, 21, 'Puede causar estornudos y fiebre leve.'),
(8, 'Leucemia felina (FeLV)', 'Previene el virus de la leucemia felina, especialmente en gatos jóvenes.', 'Zoetis', 2, 30, 'Reacciones locales, fiebre leve.'),
(9, 'Rabia felina', 'Previene la rabia en gatos. Obligatoria en zonas endémicas.', 'Elanco', 1, NULL, 'Dolor leve en el sitio de aplicación.'),
(10, 'Mixomatosis', 'Previene enfermedad viral grave en conejos.', 'Virbac', 2, 180, 'Inflamación leve en el lugar de aplicación.'),
(11, 'Enfermedad viral hemorrágica (VHD)', 'Protege conejos contra VHD tipo 1 y 2.', 'MSD Animal Health', 1, NULL, 'Fatiga leve, inapetencia temporal.'),
(12, 'Giardia', 'Previene giardiasis en perros y gatos, especialmente en ambientes húmedos.', 'Zoetis', 2, 21, 'Puede causar malestar digestivo leve.'),
(13, 'Coronavirus canino', 'Previene enteritis leve por coronavirus en cachorros.', 'Elanco', 2, 21, 'Reacciones leves, inapetencia.'),
(14, 'Dermatofitosis felina', 'Previene tiña en gatos, especialmente en criaderos.', 'Boehringer Ingelheim', 2, 30, 'Posible irritación dérmica leve.'),
(15, 'Parainfluenza canina', 'Previene infecciones respiratorias virales en perros.', 'Virbac', 2, 21, 'Tos leve post-vacunación.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas_mascota`
--

CREATE TABLE `vacunas_mascota` (
  `idMascotaVacuna` int(11) NOT NULL,
  `Vacunas_idVacunas` int(11) NOT NULL,
  `Mascota_idMascota` int(11) DEFAULT NULL,
  `veterinario` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `numero_serie` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `fecha_elaboracion` date DEFAULT NULL,
  `fecha_colocacion` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `proxima_dosis` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Dentro de ésta tabla, se relaciona la Mascota y la vacuna que fue aplicada. Dentro de la relación, se puede especificar, qué agente Veterinario realizó la colocación, así como además, la fecha en que se realizó. Incorporando datos importantes de la misma, que claro son opcionales. \n\nEs importante detallar, primero, que la vacuna tenga una fecha de colocación y además, especificar cuándo ésta caduca, para así determinar si ésta misma es vieja, si requiere renovación, o si el dueño del animal perdió o dejó atrás el seguimiento de salud de su mascota.\n';

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
-- Indices de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  ADD PRIMARY KEY (`idLog`);

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
  MODIFY `idAdopciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `idDonaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `idMascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  MODIFY `idVacunas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  MODIFY `idMascotaVacuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adopciones`
--
ALTER TABLE `adopciones`
  ADD CONSTRAINT `fk_Adopciones_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE SET NULL ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_Perdidos_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_Persona1` FOREIGN KEY (`Persona_idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vacunas_mascota`
--
ALTER TABLE `vacunas_mascota`
  ADD CONSTRAINT `fk_Vacunas_has_Mascota_Mascota1` FOREIGN KEY (`Mascota_idMascota`) REFERENCES `mascota` (`idMascota`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
