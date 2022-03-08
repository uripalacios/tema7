drop database if exists examendwes;
create database examendwes;

--
use `examendwes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `jug1` int(11) DEFAULT NULL,
  `jug2` int(11) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `resultado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id`, `jug1`, `jug2`, `fecha`, `resultado`) VALUES
(1, 1, 2, '10/03/2022', '4-6 6-5 6-1'),
(2, 3, 2, '04/03/2022', '6-2 6-3'),
(3, 2, 3, '10/03/2022', '4-6 6-5 6-1'),
(4, 3, 1, '04/03/2022', '6-2 6-3'),
(5, 1, 2, '10/03/2022', '4-6 6-5 6-2'),
(8, 1, 2, '09/09/2022', '6-1 1-6 6-7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `perfil` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `perfil`) VALUES
(1, 'maria', 'maria', 'admin'),
(2, 'pepe', 'pepe', 'user'),
(3, 'lolo', 'lolo', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
