-- Tablas adicionales para el proyecto MLR

-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único del usuario',
  `nombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del usuario',
  `email` VARCHAR(150) NOT NULL UNIQUE COMMENT 'Email para acceso (único)',
  `password` VARCHAR(255) NOT NULL COMMENT 'Contraseña hasheada',
  `rol` ENUM('admin', 'editor') NOT NULL DEFAULT 'editor' COMMENT 'Rol del usuario en el sistema',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si el usuario está activo o no',
  `ultimo_acceso` DATETIME NULL COMMENT 'Fecha del último acceso',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Usuarios del panel administrativo';

-- Estructura de tabla para `noticias`
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID único de la noticia',
  `titulo` VARCHAR(200) NOT NULL COMMENT 'Título de la noticia',
  `slug` VARCHAR(255) NOT NULL UNIQUE COMMENT 'URL amigable (único)',
  `extracto` VARCHAR(500) NULL COMMENT 'Breve resumen o extracto de la noticia',
  `contenido` TEXT NOT NULL COMMENT 'Contenido completo de la noticia',
  `imagen` VARCHAR(255) NULL COMMENT 'Ruta de la imagen principal',
  `fecha_publicacion` DATE NOT NULL COMMENT 'Fecha de publicación',
  `activo` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Si la noticia está publicada',
  `destacado` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Si aparece en portada',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última modificación',
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_fecha_activo` (`fecha_publicacion`, `activo`),
  INDEX `idx_destacado` (`destacado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Noticias del sitio';

-- Estructura de tabla para `presentaciones`
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

-- Estructura de tabla para `slides`
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

-- Estructura de tabla para `pedidos`
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

-- Estructura de tabla para `detalle_pedido`
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
