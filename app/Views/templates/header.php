<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageDescription ?? '' ?>">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- AOS CSS (CDN) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/estilos.css">

    <title><?= htmlspecialchars($pageTitle ?? APP_NAME) ?></title>

    <!-- Favicon (Ejemplo) -->
    <!-- <link rel="icon" href="<?= BASE_URL ?>/assets/images/favicon.ico"> -->

    <!-- Estilos CSS -->
    <!-- Deberíamos tener un archivo CSS principal compilado o varios específicos -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css"> -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/navbar.css"> -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css"> -->

    <!-- Estilos rápidos para empezar (luego mover a CSS) -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
            line-height: 1.6;
        }
        .container {
            max-width: 1140px;
            margin: 0 auto; /* Centrado */
            padding: 20px 15px; /* Espacio interior */
            /* background-color: #fff; */ /* Opcional: fondo blanco para el contenido */
            /* box-shadow: 0 2px 4px rgba(0,0,0,0.05); */ /* Sombra sutil */
        }
        header {
            background-color: #343a40; /* Fondo oscuro */
            color: #fff;
            padding: 1rem 0;
            border-bottom: 3px solid #ffc107; /* Un toque de color */
        }
        header .container {
             display: flex;
             justify-content: space-between; /* Logo a la izq, nav a la der */
             align-items: center;
        }

        header h1 a {
             color: #fff;
             text-decoration: none;
             font-size: 1.8rem;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        nav ul li {
            margin-left: 20px; /* Espacio entre items */
        }
        nav ul li a {
            color: #f8f9fa; /* Color de enlace más suave */
            text-decoration: none;
            font-weight: 500; /* Un poco más grueso */
            transition: color 0.3s ease;
        }
        nav ul li a:hover,
        nav ul li a.active { /* Para marcar la página activa */
            color: #ffc107; /* Resaltar al pasar el mouse o si está activo */
            /* text-decoration: underline; */
        }
        footer {
            background-color: #343a40; /* Mismo color que el header */
            color: #adb5bd; /* Color de texto más suave */
            padding: 2rem 0;
            margin-top: 40px;
            text-align: center;
            font-size: 0.9em;
            border-top: 3px solid #ffc107; /* Mismo borde que el header */
        }
        footer a {
            color: #ced4da;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        footer a:hover {
            color: #ffc107;
        }
        footer p {
            margin-bottom: 0.5rem;
        }
        .main-content {
             min-height: calc(100vh - 250px); /* Empuja el footer hacia abajo (ajustar altura header/footer) */
             padding-top: 20px;
             padding-bottom: 20px;
        }

    </style>

    <!-- Posible inclusión de JS en head si es necesario -->

</head>
<body>

<header>
    <div class="container">
        <h1><a href="<?= BASE_URL ?>/"><?= APP_NAME ?></a></h1>
        <nav>
            <ul>
                <!-- Añadiremos lógica para la clase 'active' más adelante -->
                <li><a href="<?= BASE_URL ?>/trabajos">Trabajos</a></li>
                <li><a href="<?= BASE_URL ?>/lanzamientos">Nuevos Lanzamientos</a></li>
                <li><a href="<?= BASE_URL ?>/noticias">Noticias</a></li>
                <li><a href="<?= BASE_URL ?>/tienda">Tienda</a></li>
                <li><a href="<?= BASE_URL ?>/contacto">Contacto</a></li>
                <!-- <li><a href="<?= BASE_URL ?>/admin">Admin Panel</a></li> -->
            </ul>
        </nav>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <!-- El contenido específico de cada página se inyectará aquí -->
