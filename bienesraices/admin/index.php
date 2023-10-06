<?php

    require '../includes/funciones.php';
    $auth = estaAutenticado();
    if(!$auth){
        header('Location: /');
    }
    // Importar la conexión
    // BASE DE DATOS
    require '../includes/config/database.php';
    $db = conectarDB();

    // Escribir el query
    $query = "SELECT * FROM propiedades";

    // Consultar base de datos
    $resultadoPropiedades = mysqli_query($db, $query);

    // Muestra un mensaje condicional
    // Si no existe el valor le asigna null
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            // Elimina el archivo
            $query = "SELECT imagen FROM propiedades WHERE id = {$id}";

            $resultado = mysqli_query($db, $query);
            $propiedadImagen = mysqli_fetch_assoc($resultado);

            unlink('../imagenes/' . $propiedadImagen['imagen']);

            // Elimina la propiedad
            $query = "DELETE FROM propiedades WHERE id = {$id} ";
            echo $query;

            $resultado = mysqli_query($db, $query);
            if($resultado){
                header('Location: /admin?resultado=3');
            }
        }
    }

    // Muestra un template
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador de Bienes raices</h1>

        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php elseif(intval( $resultado ) === 2): ?>
            <p class="alerta exito">Anuncio actualizado correctamente</p>
        <?php elseif(intval( $resultado ) === 3): ?>
            <p class="alerta exito">Anuncio eliminado correctamente</p>
        <?php endif; ?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Recorrer los resultados -->
                <?php while ( $propiedad = mysqli_fetch_assoc($resultadoPropiedades) ): ?>
                <tr>
                    <td> <?php echo $propiedad['id']; ?> </td>
                    <td> <?php echo $propiedad['titulo']; ?> </td>
                    <td> <img class="imagen-tabla" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen de la propiedad"> </td>
                    <td> <?php echo $propiedad['precio']; ?> </td>
                    <td>

                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-small-amarillo-block">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" value="Eliminar" class="boton-small-rojo-block-input">              
                        </form>

                    </td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 

    // Cerra la conexión

    incluirTemplate('footer');
?>  