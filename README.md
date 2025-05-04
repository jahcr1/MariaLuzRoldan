# Proyecto Sitio Web Escritor MLR

Descripción breve del proyecto...

## Instalación

1.  Clonar el repositorio.
2.  Copiar `.env.example` a `.env` y configurar las variables de entorno (base de datos, email, etc.).
3.  Ejecutar `composer install` para instalar dependencias.
4.  Configurar el servidor web (Apache/Nginx) para que apunte a la carpeta `public/` como DocumentRoot.
5.  Crear la base de datos definida en `.env`.
6.  Ejecutar los scripts SQL en `database/schema.sql` para crear las tablas.

## Estructura

Descripción de la estructura de carpetas...

*   `/public`: Raíz web, contiene `index.php` (Front Controller) y assets.
*   `/app`: Núcleo de la aplicación (Controladores, Modelos, Vistas, Core, Servicios).
*   `/config`: Archivos de configuración.
*   `/database`: Scripts SQL.
*   `/vendor`: Dependencias de Composer.
*   `.env`: Variables de entorno locales (¡No versionar!).
