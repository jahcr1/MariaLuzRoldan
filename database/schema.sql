-- Esquema inicial de la base de datos para el sitio MLR
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

DROP TABLE IF EXISTS `libros`; -- Opcional: eliminar si existe para recrearla
CREATE TABLE `libros` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del libro',
  `title` VARCHAR(255) NOT NULL COMMENT 'Título del libro',
  `author` VARCHAR(255) NULL DEFAULT 'Maria Luz Roldan' COMMENT 'Autor (siempre el mismo o puede variar?)',
  `publisher` VARCHAR(150) NULL COMMENT 'Editorial',
  `isbn` VARCHAR(20) NULL UNIQUE COMMENT 'ISBN (opcional pero recomendado, debe ser único)',
  `publication_year` YEAR NULL COMMENT 'Año de publicación',
  `description` TEXT NULL COMMENT 'Descripción larga y detallada del libro',
  `short_description` VARCHAR(500) NULL COMMENT 'Descripción corta para vistas previas',
  `price` DECIMAL(10, 2) NOT NULL COMMENT 'Precio de venta',
  `stock` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Cantidad disponible en inventario',
  `cover_image_main` VARCHAR(255) NULL COMMENT 'Ruta relativa (desde /public/assets/images/books/) a la imagen principal',
  `slug` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Identificador para URL amigable (ej: el-nombre-del-libro)',
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Indica si el libro está visible/a la venta (1) o no (0)',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_is_active_stock` (`is_active`, `stock`) -- Índice útil para buscar libros activos y en stock
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla para almacenar los libros disponibles en la tienda';

-- --------------------------------------------------------

--
-- (Próximamente) Estructura de tabla para `imagenes_libro` (Galería de imágenes por libro)
--
-- CREATE TABLE `imagenes_libro` (
--   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--   `libro_id` INT UNSIGNED NOT NULL,
--   `image_path` VARCHAR(255) NOT NULL COMMENT 'Ruta relativa a la imagen',
--   `alt_text` VARCHAR(255) NULL COMMENT 'Texto alternativo para la imagen',
--   `display_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Orden para mostrar en la galería',
--   `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`),
--   INDEX `idx_libro_id` (`libro_id`),
--   FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Imágenes adicionales para la galería de cada libro';


-- --------------------------------------------------------

--
-- (Próximamente) Estructura de tabla para `usuarios` (Clientes y Administradores)
--

-- --------------------------------------------------------

--
-- (Próximamente) Estructura de tabla para `pedidos` (Pedidos)
--

-- --------------------------------------------------------

--
-- (Próximamente) Estructura de tabla para `detalles_pedido` (Detalle de productos por pedido)
--


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
