-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2025 a las 19:03:28
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
(11, 113, NULL, '2025-12-19', 'Vigente', NULL);

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
(2, 117, 'Campaña de vacunación antirrábica', '2025-12-22', '2025-12-26', '16:30:00', 'Jornada de Vacunación Antirrábica Gratuita\r\nTe invitamos a participar en nuestra campaña de vacunación antirrábica para proteger a tu mascota y a toda la comunidad. La rabia es una enfermedad mortal pero prevenible, y la vacunación es la mejor herramienta para mantener a salvo a nuestros compañeros de cuatro patas.\r\n¿Qué ofrecemos?\r\n\r\nVacunación antirrábica gratuita para perros y gatos\r\nCertificado oficial de vacunación\r\nAtención por personal veterinario calificado\r\nAsesoría sobre cuidados preventivos\r\n\r\nRequisitos:\r\n\r\nMascotas mayores de 3 meses de edad\r\nEn buen estado de salud general\r\nLlevar collar o correa para perros\r\nTransportadora para gatos\r\n\r\nProtege a tu mascota, protege a tu familia. La prevención es responsabilidad de todos. ¡Te esperamos!', 'Pendiente', '/public/res/eventos/evento-1766155445-486365429_1073499794819292_4530396173837108762_n.jpg'),
(3, 117, 'Sorteo de Hallowen \"Disfraz para tu mascota\"', '2025-10-23', '2025-10-25', '17:00:00', '¡CONCURSO DE DISFRACES DE HALLOWEEN 2021!\r\n¡PARTICIPA Y GANA!\r\n\r\nEn Veterinaria San Cristobal queremos divertirnos contigo y tu mascota, por eso te invitamos a participar en nuestro concurso de disfraces este mes de octubre 2021. Participa a partir de hoy 29 de octubre hasta el 01 de noviembre 2021.\r\n\r\nInstrucciones para participar:\r\n1. SÍGUENOS en Facebook como https://www.facebook.com/veterinariasancristobal\r\n2. En esta publicación sube tu foto para que podamos ver el disfraz de tu mascota.\r\n\r\nCategorías:\r\n* A. Fotografía solo de tu mascota disfrazada\r\n* B. Fotografía de toda la familia y su mascota todos disfrazados\r\n\r\nPREMIACIÓN:\r\nLos premios se darán a conocer el 02 de noviembre cuando se anuncie a los ganadores de cada categoría. Habrá solo 1 ganador por cada categoría.\r\n\r\n*A todos los participantes se les regalará una galletita para su mascota.\r\n\r\nVigencia de participación: del 29 de octubre al 01 de noviembre 2021.', 'Finalizado', '/public/res/eventos/evento-1766160220-480230934_9274016922719035_7454815229853208226_n.jpg');

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
(57, NULL, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: N/A)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 16:47:44'),
(56, NULL, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: N/A)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 16:47:31'),
(55, NULL, 'Invitado', 'Ha iniciado sesión como invitado (usuario ID: N/A)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 16:40:30'),
(54, 113, 'Administrador', 'Usuario editó perfil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-19 16:38:45');

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
(20, 111, 'aramis', 'perro', 'border', 0, 'blanco y negro', 'grande', '/public/res/animal_profiles/photo-1764103738-dev2.png', '2d5f825583', 'Adoptado');

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
(114, 'David', 'Rojas', '10000000', 'sanfix.informatica@gmail.com', '+54 9 3408 435682', 'Juan XXIII', 'Oroño', 1023, '', 0, 'San Cristobal', 'Santa Fe'),
(115, 'Veterinaria', 'La Herradura', '25345434', 'veterinario@gmail.com', '+54 9 3408 123456', 'Sargento Bustamante', 'Urquiza', 1100, 'A', 2, 'San Cristobal', 'Santa Fe'),
(116, 'Administrador', 'del Sistema', '32131231', 'admin@gmail.com', '+54 9 3408 876543', 'Juan XXIII', 'Oroño', 2321, '', 0, 'San Cristobal', 'Santa Fe'),
(117, 'Ayudante', 'del Sistema', '33212312', 'gerente@gmail.com', '+54 9 3408 415374', 'Juan Caparroz', 'Caseros', 1280, 'A', 0, 'San Cristobal', 'Santa Fe'),
(118, 'El', 'Departamental', '12345678', 'publicidad@gmail.com', '+54 9 3408 123214', 'Jose Dho', 'H. Yrigoyen', 544, '', 0, 'San Cristobal', 'Santa Fe');

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
  `habilitado` tinyint(4) NOT NULL DEFAULT 1,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Persona_idPersona`, `rol`, `password`, `fecha_alta`, `habilitado`, `photo`) VALUES
(105, 106, 'Invitado', '', '2025-11-15', 1, NULL),
(108, 109, 'Usuario', '$2y$10$XYpGMIM3Vw6UM970npR9N.ymARged.RPNbQqB7YggwXfkJDuHGL6W', '2025-11-15', 1, NULL),
(109, 110, 'Usuario', '$2y$10$Nv7NtsTuITll3MhJx6MQOuirKjI3iWjUI8IF/6OKyTgG6J3XDXlxi', '2025-11-15', 1, NULL),
(110, 111, 'Usuario', '$2y$10$oueAVklZqoitGePdyxABceXRzA8gm3JkAEGsfMqDtEqO9CCt/fnmO', '2025-11-25', 1, NULL),
(111, 112, 'Usuario', '$2y$10$Ojrqu3cV6QJGv7H8Ay4JRuyvwcaWbp6bjsXjRR1SeaQMjRA7ULyRa', '2025-11-25', 1, NULL),
(113, 114, 'Administrador', '$2y$10$pnsLrIFr5yia41PuM6NoleMKiZDZMViN5j2ERHFGpCR48daDMqLsK', '2025-12-04', 0, '/public/res/user_profiles/user-113-1766159732-Profile.png'),
(114, 115, 'Veterinario', '$2y$10$2syh1DX9BIpIfxEdClRqMeIrlT70.Ss92LZu5O/uRyJR8eHc5XM2m', '2025-12-04', 1, '/public/res/user_profiles/user-114-1766159663-VeterinarioHerradura.png'),
(115, 116, 'Administrador', '$2y$10$FiWOwAfA2okMDvOoYeUHo.z6yLPYzcPRa9VGM1S/X4Jjq1xoCB07W', '2025-12-04', 1, '/public/res/user_profiles/user-115-1766159637-Admin.png'),
(116, 117, 'Ayudante', '$2y$10$zNxV1KgU0ynSdAr5KPE3DO9xvXQgu/G7aDdPlxKSG75p6JG.W64VK', '2025-12-04', 1, NULL),
(117, 118, 'Publicista', '$2y$10$DmLFFWF/2mIxlEH.HXMbouxT.IHlYS8lgBbo9bu68IcdqaXtXU7IK', '2025-12-04', 1, '/public/res/user_profiles/user-117-1766159706-ElDepartamental.png');

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
  MODIFY `idAdopciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `idDonaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `idMascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

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
