<?php 
    require 'includes/app.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h2>Casas y departamentos en Venta</h2>
        
        <?php
            // Esta variable se pasa hacia el include 
            $limite = 20;
            include 'includes/templates/anuncios.php';
        ?>
        
    </main>


<?php 
    incluirTemplate('footer');
?>  