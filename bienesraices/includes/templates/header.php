<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">

</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img class="logo-header" src="/build/img/logo.svg" alt="Logo de Bienes Raices">
                </a>

                <div class="movil-menu">
                    <img src="/build/img/barras.svg" alt="Icono menú">
                </div>

                <nav class="navegacion">
                    <a href="nosotros.php">Nosotros</a>
                    <a href="anuncios.php">Anuncios</a>
                    <a href="blog.php">Blog</a>
                    <a href="contacto.php">Contacto</a>
                    <?php if($auth): ?>
                        <a href="cerrar-sesion.php">Cerrar sesión</a>
                    <?php endif; ?>
                </nav>

                <div class="dark-mode-contenedor">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Icono tema oscuro">
                </div>

            </div> <!--.barra-->

            <?php if($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de lujo</h1>
            <?php } ?>
        </div>
    </header>