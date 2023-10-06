<?php 

    // Validar que sea un ID valido 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }

    require 'includes/config/database.php';

    $db = conectarDB();

    $query = "SELECT * FROM propiedades WHERE id = {$id}";
    $resultadoPropiedad = mysqli_query($db, $query);

    if(!$resultadoPropiedad->num_rows){
        header('Location: /');
    }

    $propiedad = mysqli_fetch_assoc($resultadoPropiedad);

    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo']; ?> </h1>

        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen de la propiedad" >

        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad['precio']; ?> €</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono baños">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad['descripcion']; ?></p>

        </div>
    </main>


<?php 
    incluirTemplate('footer');
    mysqli_close($db);
?>  