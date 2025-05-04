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

## Actualización: 2025-05-04 08:10

**Refinamientos Sección "Sobre Mí":**

*   **Inversión de Columnas:** En `#sobre-mi` (`inicio.php`), se movió la imagen (`col-lg-4`) a la derecha (`order-lg-2`) y el texto (`col-lg-8`) a la izquierda (`order-lg-1`).
*   **Iconos Sociales Simplificados:** Se eliminó el texto descriptivo junto a los iconos sociales en `#sobre-mi`, dejando solo los placeholders `<i>`.
*   **CSS Personalizado:** Creado el archivo `public/css/custom.css` con estilos base para la clase `.btn-custom-gradient` (fondo gradiente de ejemplo, efecto hover básico).
*   **Enlace CSS:** Añadido el enlace a `custom.css` en `app/Views/templates/header.php`.
*   **Botón Personalizado:** Aplicada la clase `btn-custom-gradient` al botón "Conoce Más Detalles" en `#sobre-mi`.

---

## Actualización: 2025-05-04 08:27

**Reorganización de Estilos y Botón Personalizado:**

*   **CSS Reubicado:** Creado `public/assets/css/estilos.css` como archivo principal para estilos personalizados.
*   **Clase Botón Definida:** Definida la clase `.btn-marilu1.gradiente` en `estilos.css` con un fondo gradiente (naranja a púrpura), bordes redondeados, sombra y efecto hover.
*   **Enlace CSS Actualizado:** Modificada la ruta en `app/Views/templates/header.php` para apuntar a `public/assets/css/estilos.css`.
*   **Clase Botón Aplicada:** Cambiada la clase del botón "Conoce Más Detalles" en la sección `#sobre-mi` (`inicio.php`) de `btn-primary btn-custom-gradient` a `btn-marilu1 gradiente`.
*   **Márgenes Globales:** Añadidas reglas en `estilos.css` para aplicar un `margin-bottom` general a las etiquetas `<section>`, eliminando la necesidad de clases `mb-5` específicas en `inicio.php`.

---

## Actualización: 2025-05-04 08:53

**Implementación Sección Tienda y Página de Detalle:**

*   **Corrección Botón:** Verificadas y corregidas las clases CSS y HTML para el botón personalizado a `.btn-marilu1-gradiente`.
*   **Controlador Tienda:** Creado `app/Controllers/ControladorTienda.php` para manejar la lógica de la página de detalle. Incluye obtención del `id` del libro desde `$_GET` y datos de ejemplo.
*   **Vista Tienda:** Creada `app/Views/paginas/tienda.php` con la estructura:
    *   Banner superior con nombre.
    *   Layout de 2 columnas: Izquierda (Imagen grande, Quote), Derecha (Título, Autor, Etiquetas de ejemplo, Pestañas Bootstrap: Reseña, Detalles, Reviews con contenido Lorem Ipsum).
*   **Ruta Tienda:** Añadida la ruta `GET /tienda` en `public/index.php` asociada a `ControladorTienda@index`.
*   **Sección Tienda en Inicio:** Añadida la sección `#tienda` en `app/Views/paginas/inicio.php`:
    *   Título "Explora Mis Libros".
    *   Cuadrícula responsiva (`row-cols-*`) de tarjetas Bootstrap (`card`).
    *   Cada tarjeta muestra imagen (placeholder), título, descripción corta (datos de ejemplo) y botón "Ver Detalles" (`.btn-marilu1-gradiente`) que enlaza a `tienda.php?id=X`.
    *   Animaciones `data-aos` aplicadas a las tarjetas.

---

## Actualización: 2025-05-04 09:03

**Correcciones y Ajustes:**

*   **Enlace CSS Corregido:** Modificado `app/Views/templates/header.php` para eliminar `/public/` duplicado en el `href` de `estilos.css`. La ruta correcta es `<?= BASE_URL ?>/assets/css/estilos.css`.
*   **Layout Móvil 'Sobre Mí':** Ajustadas las clases `order-*` en `app/Views/paginas/inicio.php` para la sección `#sobre-mi`. Ahora la imagen (`order-1 order-lg-2`) aparece arriba del texto (`order-2 order-lg-1`) en vistas móviles (xs a md), y el texto aparece primero en pantallas grandes (lg+).

---

## Actualización: 2025-05-04 09:15

**Comentarios PHP y Corrección de Errores Lint:**

*   **Solicitud**: Añadir comentarios explicativos al inicio de todos los archivos `.php` del proyecto.
*   **Acción**: Se añadieron comentarios a:
    - `app/Views/templates/header.php`
    - `app/Views/templates/footer.php`
    - `app/Views/paginas/inicio.php`
    - `app/Views/paginas/tienda.php`
    - `app/Controllers/ControladorInicio.php`
    - `app/Controllers/ControladorTienda.php`
    - `public/index.php`
    - `app/Core/Router.php`
    - `config/config.php`
*   **Corrección**: Se detectaron y corrigieron errores de lint (múltiples intentos) relacionados con `declare(strict_types=1);` que no era la primera declaración en `public/index.php`, `ControladorInicio.php`, `Router.php` y `config/config.php` debido a la inserción inicial de los comentarios.
*   **Pendiente**: Esperando que el USER agregue imágenes para escanear y continuar con la sección tienda.
*   **Corrección (2025-05-04 09:26)**: Para solucionar definitivamente los errores de lint `strict_types`, se movieron los comentarios explicativos en los archivos afectados (`public/index.php`, `ControladorInicio.php`, `Router.php`, `config/config.php`) a líneas posteriores, asegurando que `declare(strict_types=1);` sea la primera declaración absoluta.

### 2025-05-04 09:31
- **Error Fatal Detectado**: `Fatal error: Uncaught Error: Class "App\Core\Controller" not found` en `ControladorInicio.php`.
- **Causa**: `ControladorInicio` intentaba extender `App\Core\Controller`, pero el archivo `app/Core/Controller.php` no existía.
- **Solución**: Se creó el archivo `app/Core/Controller.php` con una definición de clase base `Controller`.
