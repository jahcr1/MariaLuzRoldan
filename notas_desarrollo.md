# Notas de Desarrollo - Proyecto Web MLR

## Resumen Inicial (Hasta 2025-05-04 06:49)

Este documento registra las decisiones clave, cambios y pasos realizados durante el desarrollo del sitio web.

**Objetivo:** Reestructurar el proyecto existente aplicando principios de Clean Architecture y MVC, usando PHP y MySQL.

**Estructura del Proyecto Adoptada:**

*   `/app`
    *   `/Core` (Clases base como `Database`, `Router`)
    *   `/Controllers` (Lógica de aplicación, ej: `ControladorInicio.php`)
    *   `/Models` (Interacción con base de datos, ej: `Libro.php` - *pendiente*)
    *   `/Views`
        *   `/paginas` (Vistas específicas, ej: `inicio.php`)
        *   `/templates` (Cabecera y pie de página, ej: `header.php`, `footer.php`)
*   `/config` (Archivos de configuración, ej: `config.php`, `database.php`)
*   `/database` (Schema SQL, migraciones, seeds, ej: `schema.sql`)
*   `/public` (Punto de entrada web, assets públicos)
    *   `index.php` (Front Controller)
    *   `.htaccess` (Reglas de reescritura)
    *   `/assets` (CSS, JS, Imágenes - *pendiente organizar*)
*   `/vendor` (Dependencias de Composer)
*   `.env` / `.env.example` (Variables de entorno)
*   `composer.json` (Gestión de dependencias)
*   `.gitignore` (Archivos ignorados por Git)
*   `README.md` (Documentación inicial)

**Componentes Clave Implementados/Configurados:**

*   **Composer:** Inicializado, con dependencias (`phpdotenv`, `phpmailer`). Autoload PSR-4 configurado para `App\` -> `app/`.
*   **Configuración:** `.env` para secretos, `config.php` para constantes globales y ajustes de entorno, `database.php` para credenciales de BD.
*   **Core:** `Database.php` (Singleton PDO), `Router.php` (manejo básico de rutas).
*   **Controladores:** `ControladorInicio.php` (maneja la ruta `/`).
*   **Vistas:** Plantillas `header.php`, `footer.php`. Vista `paginas/inicio.php`.
*   **Base de Datos:** `schema.sql` define la tabla `libros`.
*   **Punto de Entrada:** `public/index.php` configura la app y despacha rutas usando el Router.
*   **Git:** Repositorio inicializado, `.gitignore` configurado, commits realizados.

**Decisiones Importantes:**

*   **Convención de Nombres:** Carpetas principales (`Controllers`, `Models`, `Views`) en inglés. Clases, métodos y archivos PHP *dentro* de ellas en español (ej: `ControladorInicio`, `Libro`, `inicio.php`). Tablas de BD en español (`libros`).
*   **Flujo MVC:** Se sigue el patrón Modelo-Vista-Controlador.
*   **Gestión de Dependencias:** Se usa Composer.
*   **Variables de Entorno:** Se usa `phpdotenv` para gestionar configuraciones sensibles.

---

## Actualización: 2025-05-04 07:31

**Frontend Setup y Secciones Iniciales:**

*   **Frameworks/Librerías:**
    *   Integrado **Bootstrap 5** (CSS y JS Bundle) vía CDN en `header.php` y `footer.php`.
    *   Integrado **AOS (Animate On Scroll)** (CSS y JS) vía CDN en `header.php` y `footer.php`. Inicializado en `footer.php` (`AOS.init()`).
    *   Se decide usar el componente **Bootstrap Carousel** para el slider de propaganda.
*   **Estructura de Assets:** Creada estructura de carpetas en `public/assets/` (`css`, `js`, `images/layout`, `images/libros`, `images/autora`).
*   **Vista Inicio (`inicio.php`):**
    *   Añadida sección `#slider-propaganda` usando Bootstrap Carousel con 5 slides (placeholders de imagen y texto).
    *   Añadida sección `#nuevos-lanzamientos` con estructura de rejilla (imagen a la izquierda, texto a la derecha), placeholders y atributos `data-aos` para animación.
*   **Archivo de Registro de Prompts:** Creado `notas_prompts.md` para registrar las interacciones de la conversación a partir de ahora.

---

## Actualización: 2025-05-04 07:58

**Sección "Sobre Mí":**

*   Añadida la estructura HTML para la sección `#sobre-mi` en `inicio.php`.
*   Diseño con rejilla Bootstrap (`col-lg-4` para imagen, `col-lg-8` para texto).
*   Incluye placeholders para:
    *   Imagen de autora (redondeada, con sombra).
    *   Texto introductorio y párrafo Lorem Ipsum.
    *   Iconos de redes sociales (requerirá librería externa como Font Awesome).
    *   Botón "Ver Más" (enlace pendiente a futura página `/sobre-mi-detalle`).
*   Aplicados efectos de animación `data-aos` (`fade-right`, `fade-left`).

---
