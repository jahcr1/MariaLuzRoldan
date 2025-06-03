-- Esquema unificado de la base de datos para el sitio MLR
-- Nombre sugerido para la base de datos: mlr_db (configúralo en tu archivo .env)
-- Codificación recomendada: utf8mb4 con cotejamiento utf8mb4_unicode_ci

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00"; -- O tu zona horaria, ej: '-03:00'

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mlr_db`
-- (Debes crear esta base de datos manualmente en MySQL/MariaDB)
-- CREATE DATABASE IF NOT EXISTS `mlr_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `mlr_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros` (Libros/Productos)
--

CREATE TABLE IF NOT EXISTS `libros` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del libro',
  `titulo` VARCHAR(255) NOT NULL COMMENT 'Título del libro',
  `autor` VARCHAR(255) NULL DEFAULT 'Maria Luz Roldan' COMMENT 'Autor (siempre el mismo o puede variar?)',
  `editorial` VARCHAR(150) NULL COMMENT 'Editorial',
  `isbn` VARCHAR(20) NULL UNIQUE COMMENT 'ISBN (opcional pero recomendado, debe ser único)',
  `anio_publicacion` YEAR NULL COMMENT 'Año de publicación',
  `descripcion` TEXT NULL COMMENT 'Descripción larga y detallada del libro',
  `descripcion_corta` VARCHAR(500) NULL COMMENT 'Descripción corta para vistas previas',
  `precio` DECIMAL(10, 2) NOT NULL COMMENT 'Precio de venta',
  `stock` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Cantidad disponible en inventario',
  `imagen` VARCHAR(255) NULL COMMENT 'Ruta relativa a la imagen principal',
  `slug` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Identificador para URL amigable (ej: el-nombre-del-libro)',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Indica si el libro está visible/a la venta',
  `paginas` INT UNSIGNED NULL COMMENT 'Número de páginas',
  `idioma` VARCHAR(50) NULL COMMENT 'Idioma del libro',
  `encuadernacion` VARCHAR(50) NULL COMMENT 'Tipo de encuadernación',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_activo_stock` (`activo`, `stock`) -- Índice útil para buscar libros activos y en stock
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla para almacenar los libros disponibles en la tienda';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del usuario',
  `nombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del usuario',
  `email` VARCHAR(150) NOT NULL UNIQUE COMMENT 'Email para acceso (único)',
  `password` VARCHAR(255) NOT NULL COMMENT 'Contraseña hasheada',
  `rol` ENUM('admin', 'cliente') NOT NULL DEFAULT 'cliente' COMMENT 'Rol del usuario en el sistema',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si el usuario está activo o no',
  `ultimo_acceso` DATETIME NULL COMMENT 'Fecha del último acceso',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Usuarios del sistema';

-- --------------------------------------------------------

--
-- Estructura de tabla para `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único de la noticia',
  `titulo` VARCHAR(200) NOT NULL COMMENT 'Título de la noticia',
  `slug` VARCHAR(255) NOT NULL UNIQUE COMMENT 'URL amigable (único)',
  `resumen` VARCHAR(500) NULL COMMENT 'Breve resumen o extracto de la noticia',
  `contenido` TEXT NULL COMMENT 'Contenido completo de la noticia',
  `imagen_preview` VARCHAR(255) NULL COMMENT 'Ruta de la imagen principal',
  `url_origen` VARCHAR(255) NULL COMMENT 'URL de origen de la noticia',
  `plataforma` VARCHAR(50) NULL COMMENT 'Plataforma de origen (facebook, instagram, etc)',
  `fecha_publicacion` DATE NOT NULL COMMENT 'Fecha de publicación',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si la noticia está publicada',
  `es_destacada` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Si aparece en portada',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_fecha_activo` (`fecha_publicacion`, `activo`),
  INDEX `idx_es_destacada` (`es_destacada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Noticias del sitio';

-- --------------------------------------------------------

--
-- Estructura de tabla para `presentaciones`
--

CREATE TABLE IF NOT EXISTS `presentaciones` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del evento',
  `lugar` VARCHAR(200) NOT NULL COMMENT 'Lugar del evento',
  `fecha_evento` DATETIME NOT NULL COMMENT 'Fecha y hora del evento',
  `descripcion` TEXT NULL COMMENT 'Descripción del evento',
  `enlace` VARCHAR(255) NULL COMMENT 'Enlace externo para más información',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si el evento está activo',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_fecha_activo` (`fecha_evento`, `activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Presentaciones y eventos';

-- --------------------------------------------------------

--
-- Estructura de tabla para `slides`
--

CREATE TABLE IF NOT EXISTS `slides` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del slide',
  `titulo` VARCHAR(100) NOT NULL COMMENT 'Título del slide',
  `descripcion` VARCHAR(255) NULL COMMENT 'Descripción corta',
  `imagen` VARCHAR(255) NOT NULL COMMENT 'Ruta a la imagen',
  `enlace` VARCHAR(255) NULL COMMENT 'Enlace opcional al hacer clic',
  `orden` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Orden de aparición',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si el slide está activo',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_orden_activo` (`orden`, `activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Slides para el carrusel de la página principal';

-- --------------------------------------------------------

--
-- Estructura de tabla para `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del pedido',
  `nombre_cliente` VARCHAR(150) NOT NULL COMMENT 'Nombre del cliente',
  `email_cliente` VARCHAR(150) NOT NULL COMMENT 'Email del cliente',
  `telefono_cliente` VARCHAR(20) NULL COMMENT 'Teléfono del cliente',
  `direccion_envio` TEXT NOT NULL COMMENT 'Dirección de envío',
  `ciudad` VARCHAR(100) NOT NULL COMMENT 'Ciudad',
  `provincia` VARCHAR(100) NOT NULL COMMENT 'Provincia/Estado',
  `codigo_postal` VARCHAR(10) NOT NULL COMMENT 'Código postal',
  `metodo_pago` VARCHAR(50) NOT NULL COMMENT 'Método de pago utilizado',
  `estado` ENUM('pendiente', 'pagado', 'enviado', 'completado', 'cancelado') NOT NULL DEFAULT 'pendiente',
  `total` DECIMAL(10, 2) NOT NULL COMMENT 'Total del pedido',
  `notas` TEXT NULL COMMENT 'Notas adicionales',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Última actualización',
  PRIMARY KEY (`id`),
  INDEX `idx_estado` (`estado`),
  INDEX `idx_fecha` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pedidos de la tienda';

-- --------------------------------------------------------

--
-- Estructura de tabla para `detalle_pedido`
--

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del detalle',
  `pedido_id` INT UNSIGNED NOT NULL COMMENT 'ID del pedido relacionado',
  `libro_id` INT UNSIGNED NOT NULL COMMENT 'ID del libro',
  `cantidad` INT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Cantidad de unidades',
  `precio_unitario` DECIMAL(10, 2) NOT NULL COMMENT 'Precio unitario al momento de la compra',
  PRIMARY KEY (`id`),
  INDEX `idx_pedido` (`pedido_id`),
  INDEX `idx_libro` (`libro_id`),
  FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de productos por pedido';

-- --------------------------------------------------------

--
-- Estructura de tabla para `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del álbum',
  `titulo` VARCHAR(100) NOT NULL COMMENT 'Título del álbum',
  `fecha` DATE NOT NULL COMMENT 'Fecha del álbum',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si el álbum está activo',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Álbumes de fotos';

-- --------------------------------------------------------

--
-- Estructura de tabla para `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único de la imagen',
  `album_id` INT UNSIGNED NOT NULL COMMENT 'ID del álbum',
  `titulo` VARCHAR(100) NULL COMMENT 'Título de la imagen',
  `detalle` TEXT NULL COMMENT 'Detalle o descripción de la imagen',
  `ruta_imagen` VARCHAR(255) NOT NULL COMMENT 'Ruta a la imagen',
  `mostrar_inicio` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Si se muestra en la página inicial',
  `orden` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Orden de visualización',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_mostrar_inicio` (`mostrar_inicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Imágenes de los álbumes';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
