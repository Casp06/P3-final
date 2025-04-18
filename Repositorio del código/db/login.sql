-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20231128.289d080811
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2023 a las 01:24:50
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_request` tinyint(4) NOT NULL DEFAULT 0,
  `activo` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `password`, `nombre`, `email`, `token_password`, `password_request`, `activo`, `fecha_alta`) VALUES
(1, 'admin', '$2y$10$XVpMS8xrgJmQ7/7bSaPpUeRMRUbbt7s3dJyUd10y9sAx6KUvYdhru', 'Administrador', 'visenzzo8@gmail.com', NULL, 0, 1, '2023-12-05 11:40:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `valor`) VALUES
(1, 'tienda_nombre', 'Visenzzo'),
(2, 'correo_email', 'visenzzo8@gmail.com'),
(3, 'correo_smtp', 'smtp.gmail.com'),
(4, 'correo_password', 'My1+MHB68JcbwTiGQ/acrw==:Q32XYQf3UEY25/MKppadC79b+r8F7VvyDACAbwbxoeU='),
(5, 'correo_puerto', '587');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `titulo`, `descripcion`, `categoria_nombre`, `categoria_id`, `precio`, `descuento`) VALUES
(1, 'Blusa Estampado de Paisley', 'Blusa Estampado de Paisley', 'Mujer', 'mujer', 1000.00, 0),
(2, 'Pantalón Corto Cintura Alta', 'Pantalón Corto Cintura Alta', 'Mujer', 'mujer', 500.00, 0),
(3, 'Pantalón Corto Cintura Alta', 'Pantalón Corto Cintura Alta', 'Mujer', 'mujer', 500.00, 0),
(4, 'Camiseta con Estampado 3D', 'Camiseta con Estampado 3D', 'Hombre', 'hombre', 500.00, 0),
(5, 'Camiseta con Estampado 3D', '\r\nLa \"Camiseta con Estampado 3D\" es una prenda de vestir que presenta un diseño visual tridimensional en su superficie. Este estampado 3D agrega un elemento de profundidad y realismo al diseño de la camiseta, creando un aspecto llamativo y moderno. Ideal para aquellos que buscan prendas únicas y con estilo que destaquen en su vestuario. La camiseta ofrece una combinación de comodidad y estilo, fusionando la moda con efectos visuales impactantes.', 'Hombre', 'hombre', 500.00, 0),
(6, 'Falda larga seda con Estampado', 'Falda larga seda con Estampado', 'Mujer', 'mujer', 500.00, 0),
(7, 'Conjunto con Estampado floral ', 'Conjunto con Estampado floral ', 'Mujer', 'mujer', 500.00, 0),
(8, 'Conjunto con Estampado floral ', 'Conjunto elegante con un estampado floral vibrante, perfecto para destacar tu estilo primaveral. Incluye top y pantalón a juego, ideal para ocasiones casuales o eventos especiales.', 'Mujer', 'mujer', 500.00, 0),
(9, 'Blusa Riffle Hombros Descubiertos', '\r\nLa \"Blusa Ruffle Hombros Descubiertos\" es una prenda elegante y femenina que presenta detalles de volantes en los hombros y un diseño de hombros descubiertos, brindando un toque de estilo y glamour. Esta blusa versátil es perfecta para ocasiones casuales o eventos más formales, proporcionando comodidad y sofisticación. Confeccionada con atención a los detalles, combina moda y comodidad para realzar tu estilo único.', 'Mujer', 'mujer', 500.00, 0),
(10, 'Blusa Estampado de Paisley', 'La \"Blusa Estampado de Paisley\" es una prenda elegante y versátil que presenta un patrón clásico de paisley. Confeccionada con tejidos de alta calidad, esta blusa ofrece comodidad y estilo. Ideal para ocasiones formales o informales, el estampado de paisley añade un toque de sofisticación a tu vestuario. Combínala con pantalones o faldas para crear looks atractivos y a la moda. Un elemento esencial para cualquier guardarropa que busca fusionar elegancia y tendencia.', 'Mujer', 'mujer', 500.00, 0),
(11, 'Conjunto con Estampado Abstracto', '\"Conjunto con Estampado Abstracto\": Este conjunto ofrece un estilo moderno y vibrante con su estampado abstracto único. La prenda, diseñada para brindar comodidad y elegancia, presenta un patrón artístico que agrega un toque contemporáneo. Perfecto para quienes buscan destacar con moda audaz y expresiva.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Mujer', 'mujer', 500.00, 0),
(12, 'Pantalones Cargo Bolsillos Solap', '\"Pantalones cargo con diseño versátil y moderno. Destacan por sus prácticos bolsillos solapados, ofreciendo estilo y funcionalidad en cada detalle.\"', 'Mujer', 'mujer', 500.00, 0),
(13, 'Pantalon Corto Carga de Algodón', '\"Pantalón corto de estilo cargo confeccionado en suave algodón. Diseño versátil y cómodo, perfecto para días casuales y actividades al aire libre.\"', 'Hombre', 'hombre', 500.00, 0),
(14, 'Pantalon Corto Carga de Algodón', 'Pantalón corto de estilo cargo confeccionado en suave algodón. Diseño versátil y cómodo, perfecto para días casuales y actividades al aire libre.\"', 'Hombre', 'hombre', 500.00, 0),
(15, 'Vestido De Corte Floral globo ', '\r\n\"Vestido de corte floral globo: una elegante y cómoda pieza que combina un diseño moderno con un corte favorecedor. Con estampado floral, este vestido destaca por su estilo versátil, perfecto para diversas ocasiones. Su corte globo agrega un toque de originalidad, realzando la feminidad con un toque de frescura y sofisticación.\"', 'Mujer', 'mujer', 500.00, 0),
(16, 'Bikini Negra De Gran Elasticidad ', 'Disfruta del estilo y comodidad con nuestro Bikini Negra de Gran Elasticidad. Este atractivo conjunto no solo destaca por su diseño elegante y moderno, sino también por su tejido elástico que se ajusta perfectamente a tu figura. Ideal para lucir con confianza y confort en la playa o la piscina.', 'Mujer', 'mujer', 500.00, 0),
(17, 'Conjunto con Estampado Abstracto', 'El \"Conjunto con Estampado Abstracto\" es una elegante y moderna combinación de prendas que incorpora un atractivo estampado abstracto. Este conjunto ofrece un estilo único y contemporáneo, perfecto para quienes buscan destacar con originalidad en su vestimenta. Confeccionado con materiales de calidad, el conjunto brinda comodidad y versatilidad, convirtiéndolo en una opción ideal para diversas ocasiones. La fusión de diseño y confort hace de este conjunto una elección distinguida para quienes aprecian la moda creativa y expresiva.', 'Mujer', 'mujer', 500.00, 0),
(18, 'Camiseta con Estampado 3D', 'Expresa tu estilo con nuestra camiseta con estampado 3D, una prenda única que combina moda y comodidad. El diseño tridimensional añade un toque moderno y llamativo, mientras que la suavidad del material garantiza un uso cómodo en cualquier ocasión. Perfecta para destacar y marcar tendencia con un toque de originalidad en tu guardarropa.', 'Hombre', 'hombre', 500.00, 0),
(19, 'Blusa Estampado de Paisley (Size S)', 'Esta elegante blusa presenta un encantador estampado de paisley, añadiendo un toque de estilo bohemio a tu guardarropa. Confeccionada en talla S, ofrece un ajuste cómodo y favorecedor. Ideal para cualquier ocasión, esta blusa es la elección perfecta para quienes buscan un estilo sofisticado con un toque de originalidad', 'Mujer', 'mujer', 500.00, 0),
(20, 'Blusa Estampado de Paisley', '', 'Mujer', 'mujer', 500.00, 0),
(21, 'Conjunto con Estampado Palazzo', '', 'Mujer', 'mujer', 500.00, 0),
(22, 'Camiseta con Estampado 3D', 'La camiseta con estampado 3D es una prenda moderna y llamativa que destaca por su diseño tridimensional. Con detalles visuales que sobresalen, esta camiseta aporta un toque de estilo único. Su comodidad se combina con una expresión de moda audaz, haciendo que sea una elección perfecta para aquellos que buscan destacar con un toque distintivo en su vestimenta cotidiana.', 'Hombre', 'hombre', 500.00, 0),
(23, 'Conjunto Top y falda larga', 'El conjunto Top y falda larga es una elegante y versátil opción para lucir a la moda en diversas ocasiones. El top presenta un diseño moderno y favorecedor, mientras que la falda larga agrega un toque de sofisticación. Perfecto para eventos casuales o más formales, este conjunto ofrece comodidad y estilo en una combinación única.', 'Mujer', 'mujer', 500.00, 0),
(24, 'Conjunto Top Manga Larga', 'El conjunto Top y falda larga es una elegante y versátil opción para lucir a la moda en diversas ocasiones. El top presenta un diseño moderno y favorecedor, mientras que la falda larga agrega un toque de sofisticación. Perfecto para eventos casuales o más formales, este conjunto ofrece comodidad y estilo en una combinación única.', 'Mujer', 'mujer', 500.00, 0),
(25, 'Conjunto floral Top y falda larga', 'El conjunto Top y falda larga es una elegante y versátil opción para lucir a la moda en diversas ocasiones. El top presenta un diseño moderno y favorecedor, mientras que la falda larga agrega un toque de sofisticación. Perfecto para eventos casuales o más formales, este conjunto ofrece comodidad y estilo en una combinación única.', 'Mujer', 'mujer', 500.00, 0),
(26, 'Camiseta con Estampado 3D', '\r\nLa camiseta con estampado 3D es una prenda moderna y estilizada que presenta un diseño tridimensional único. Con detalles visuales que crean efectos de profundidad y realismo, esta camiseta ofrece un toque de originalidad y moda. Fabricada con materiales de calidad, brinda comodidad mientras resalta tu estilo con un estampado vibrante y atractivo. Perfecta para quienes buscan destacar con una pieza única en su vestuario cotidiano.', 'Hombre', 'hombre', 500.00, 0),
(27, 'Conjunto floral Top y falda larga', 'El conjunto floral de top y falda larga es una elección elegante y femenina para cualquier ocasión. El top presenta un estampado floral vibrante que añade un toque fresco y primaveral, mientras que la falda larga complementa el conjunto con estilo y comodidad. Perfecto para eventos casuales o formales, este conjunto ofrece una combinación de moda y versatilidad, destacando la belleza y la sofisticación en cada detalle.', 'Mujer', 'mujer', 500.00, 0),
(28, 'Blusa Estampado prensada de Paisley', '\r\nLa Blusa Estampado Prensada de Paisley es una elegante y versátil prenda que destaca por su diseño estampado inspirado en el icónico patrón paisley. Fabricada con materiales de alta calidad, esta blusa ofrece comodidad y estilo. Su corte favorecedor y su patrón único la convierten en una elección ideal para cualquier ocasión, ya sea casual o formal. Añade un toque de sofisticación a tu guardarropa con esta blusa que fusiona la moda moderna con la atemporalidad del estampado paisley.', 'Mujer', 'mujer', 500.00, 0),
(29, 'Camiseta con Estampado 3D', 'Disfruta de un estilo único con nuestra Camiseta con Estampado 3D. Esta prenda moderna y llamativa presenta un diseño tridimensional que añade un toque de creatividad a tu vestuario. Fabricada con materiales de alta calidad, proporciona comodidad y estilo a la vez. Perfecta para destacar en cualquier ocasión y expresar tu personalidad a través de la moda.', 'Hombre', 'hombre', 500.00, 0),
(30, 'Conjunto con Estampado floral ', '\r\nEl \"Conjunto con Estampado Floral\" es una elección elegante y vibrante para destacar en tu guardarropa. Este conjunto presenta un diseño floral llamativo que agrega un toque fresco y femenino. La prenda coordinada ofrece versatilidad y estilo, perfecta para ocasiones casuales o eventos más formales. Con su estampado floral en tendencia, este conjunto es una opción encantadora para aquellos que buscan un aspecto moderno y lleno de vida.', 'Mujer', 'mujer', 500.00, 0),
(31, 'Blusa sin mangas Paisley ', 'La blusa sin mangas Paisley combina estilo y comodidad con un estampado vibrante. Su diseño elegante y femenino presenta patrones Paisley que añaden un toque de sofisticación. Confeccionada con materiales de alta calidad, esta blusa es perfecta para lucir a la moda en cualquier ocasión, ya sea de día o de noche. Su versatilidad la convierte en una opción ideal para realzar tu estilo único y destacar en tu guardarropa.', 'Mujer', 'mujer', 500.00, 0),
(32, 'Pantalon Palazzo Estanpado', '', 'Mujer', 'mujer', 500.00, 0),
(33, 'Vestido con Estampado floral ', '\"Deslumbra con nuestro vestido con estampado floral, una elegante y femenina pieza que combina estilo y frescura. Su diseño presenta un atractivo estampado floral que agrega un toque de encanto primaveral, mientras que su corte favorecedor realza la figura. Ideal para ocasiones especiales o simplemente para destacar tu estilo cotidiano con un toque de sofisticación floral.\"', 'Mujer', 'mujer', 500.00, 0),
(34, 'Vestido con Estampado Adstracto ', '\r\nEl Vestido con Estampado Abstracto es una elegante y moderna opción para cualquier ocasión. Con un diseño único y llamativo de patrones abstractos, este vestido ofrece un toque artístico y a la moda. Su corte favorecedor y tela cómoda lo hacen ideal para lucir con estilo y comodidad en eventos casuales o más formales. Añade un toque de originalidad a tu guardarropa con este vestido versátil y lleno de personalidad.', 'Mujer', 'mujer', 500.00, 0),
(35, 'Blusa Estampado de Paisley floral', '\r\nLa Blusa Estampado de Paisley floral es una prenda elegante y vibrante que combina un diseño clásico de paisley con elementos florales, creando un estilo único y atractivo. Confeccionada con materiales de alta calidad, esta blusa ofrece comodidad y versatilidad. Su estampado distintivo agrega un toque de sofisticación a cualquier conjunto, ya sea casual o formal. Perfecta para destacar tu sentido de la moda con un toque fresco y femenino.', 'Mujer', 'mujer', 500.00, 0),
(36, 'Blusa Estampado de Paisley floral', 'La blusa estampada de Paisley floral es una prenda elegante y vibrante que combina el clásico diseño Paisley con elementos florales. Confeccionada con tejidos de alta calidad, esta blusa ofrece un estilo femenino y moderno. El estampado Paisley, conocido por sus formas curvas y elegantes, se fusiona armoniosamente con detalles florales, creando una prenda única y atractiva. Perfecta para ocasiones casuales o formales, esta blusa añade un toque de sofisticación y frescura a cualquier atuendo.', 'Mujer', 'mujer', 500.00, 0),
(37, 'Blusa Ancha con Hombro Inclinado', '\r\nLa \"Blusa Ancha con Hombro Inclinado\" es una prenda elegante y moderna que ofrece comodidad y estilo. Su diseño amplio y los hombros inclinados brindan un toque único y sofisticado. Confeccionada con telas de alta calidad, esta blusa es perfecta para ocasiones casuales o eventos más formales. Aporta versatilidad a tu guardarropa, permitiéndote destacar tu estilo con un toque contemporáneo y a la moda.', 'Mujer', 'mujer', 500.00, 0),
(38, 'Camisa Cuello Sólido Lazo tracero', '\r\nLa \"Camisa Cuello Sólido Lazo Trasero\" es una prenda elegante y versátil que combina un diseño clásico con un toque distintivo. Con un cuello sólido y un lazo delicadamente atado en la parte posterior, esta camisa añade un elemento de sofisticación y estilo a cualquier conjunto. Perfecta para ocasiones formales o para dar un toque refinado a tu vestuario diario. Fabricada con materiales de calidad, garantiza comodidad y durabilidad, convirtiéndola en una elección elegante para diversas ocasiones.', 'Mujer', 'mujer', 500.00, 0),
(39, 'Pantalon Palazzo Estanpado', '\r\nEl Pantalón Palazzo Estampado es una prenda elegante y cómoda que combina un diseño de piernas anchas con un estampado único y atractivo. Confeccionado con telas de alta calidad, este pantalón ofrece comodidad y estilo a la vez. Ideal para diversas ocasiones, desde eventos formales hasta salidas informales, el Palazzo Estampado agrega un toque de moda y versatilidad a tu guardarropa.', 'Mujer', 'mujer', 500.00, 0),
(40, 'Conjunto Top Manga Larga', '\r\nEl Conjunto Top Manga Larga es una opción versátil y elegante para cualquier ocasión. Con mangas largas que brindan cobertura y estilo, este conjunto ofrece comodidad con un toque moderno. Ideal para combinar con pantalones o faldas, este conjunto es perfecto para lograr un look sofisticado y a la moda en cualquier temporada.', 'Mujer', 'mujer', 500.00, 0),
(41, 'Top Tankini Color Liso Con Uniones ', '\r\nEl Top Tankini Color Liso con Uniones es una elegante y versátil prenda de baño que combina comodidad y estilo. Confeccionado en un tono sólido, este top destaca por sus detalles de uniones que añaden un toque moderno y atractivo. Diseñado para ofrecer cobertura y soporte, es la elección perfecta para disfrutar de días soleados en la playa o la piscina con confianza y estilo.', 'Mujer', 'mujer', 500.00, 0),
(42, 'Blusa Riffle Hombros Descubiertos', '\r\nLa \"Blusa Riffle Hombros Descubiertos\" es una prenda elegante y femenina que destaca por su diseño único. Confeccionada con tejidos de alta calidad, presenta un estilo moderno y juvenil al dejar al descubierto los hombros, añadiendo un toque de sofisticación. Los detalles de volantes (riffles) proporcionan un atractivo adicional, creando una blusa versátil perfecta para ocasiones casuales o eventos más formales. Su combinación de comodidad y estilo la convierte en una opción encantadora para cualquier guardarropa de moda.', 'Mujer', 'mujer', 500.00, 0),
(43, 'Camiseta con Estampado 3D', '', 'Hombre', 'hombre', 500.00, 0),
(44, 'Conjunto con Estampado floral', '', 'Mujer', 'mujer', 500.00, 0),
(45, 'Blusa manga larga con encaje', '', 'Mujer', 'mujer', 500.00, 0),
(46, 'Camisa sin hombro manga larga', '', 'Mujer', 'mujer', 500.00, 0),
(47, 'Tenis Altos Canvas con plataforma', 'Conquista las calles con estilo y comodidad usando nuestros Tenis Altos Canvas con plataforma. Estos modernos tenis no solo te brindan un toque de altura adicional, sino que también destacan por su diseño contemporáneo en lona. Perfectos para quienes buscan un look urbano y a la moda sin comprometer la comodidad en cada paso.\"', 'Mujer', 'otro', 500.00, 0),
(48, 'Bolso de Cuero Weixier para hombre ', '\r\nEl bolso de cuero Weixier para hombre es un accesorio elegante y funcional que combina estilo y practicidad. Fabricado con cuero de alta calidad, este bolso ofrece durabilidad y un diseño atractivo. Con compartimentos bien organizados, es ideal para llevar objetos personales esenciales, como billetera, teléfono y llaves. Su diseño moderno lo convierte en el complemento perfecto para cualquier atuendo, añadiendo un toque de sofisticación a la moda masculina. Ideal para el hombre contemporáneo que valora la elegancia y la comodidad en sus accesorios diarios.', 'Hombre', 'otro', 500.00, 0),
(49, 'Bolso de Cuero Weixier para hombre ', '\r\nEl bolso de cuero Weixier para hombre es un accesorio elegante y funcional que combina estilo y practicidad. Fabricado con cuero de alta calidad, este bolso ofrece durabilidad y un diseño atractivo. Con compartimentos bien organizados, es ideal para llevar objetos personales esenciales, como billetera, teléfono y llaves. Su diseño moderno lo convierte en el complemento perfecto para cualquier atuendo, añadiendo un toque de sofisticación a la moda masculina. Ideal para el hombre contemporáneo que valora la elegancia y la comodidad en sus accesorios diarios.', 'Hombre', 'otro', 500.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
