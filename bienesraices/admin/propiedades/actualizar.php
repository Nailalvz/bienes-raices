<?php 


    require '../../includes/funciones.php';
    $auth = estaAutenticado();
    if(!$auth){
        header('Location: /');
    }


    // Validar que sea un ID valido 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    // BASE DE DATOS
    require '../../includes/config/database.php';

    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consultaPropiedad = "SELECT * FROM propiedades WHERE id={$id}";
    $resultadoPropiedad = mysqli_query($db, $consultaPropiedad);
    $propiedad = mysqli_fetch_assoc($resultadoPropiedad);

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);

    // echo '<pre>';
    // var_dump($resultadoVendedores);
    // echo '</pre>';

    // Array con mensajes de errores
    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedores_id = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];

    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        $vendedores_id = mysqli_real_escape_string( $db, $_POST['vendedor'] );
        $creado = date('Y/m/d');

        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = 'Debes añadir un titulo';
        }

        if(!$precio){
            $errores[] = 'El precio es obligatorio';
        }

        if( strlen($descripcion) < 50 ){
            $errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$habitaciones){
            $errores[] = 'El número de habitaciones es obligatorio';
        }

        if(!$wc){
            $errores[] = 'El número de baños es obligatorio';
        }

        if(!$estacionamiento){
            $errores[] = 'El número de lugares de estacionamiento es obligatorio';
        }

        if(!$vendedores_id){
            $errores[] = 'El vendedor es obligatorio';
        }

        // Validar por tamaño (1mb máximo)
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida){
            $errores[] = 'La imagen es muy grande';
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        // Comprobar que el arreglo de errores esta vacío
        if(empty($errores)){

            // SUBIDA DE ARCHIVOS

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';
            

            if($imagen['name']){
                // Eliminar la imagen previa para no llenar el servidor
                unlink($carpetaImagenes . $propiedad['imagen']);

                // Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                // Subir la imagen
                move_uploaded_file($imagen["tmp_name"], "$carpetaImagenes" . $nombreImagen);
            } else {
                $nombreImagen = $propiedad['imagen'];
            }

            // Insertar en la base de datos
            $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = {$precio}, imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedores_id = {$vendedores_id} WHERE id = {$id}";

            // echo $query;

            $resultadoVendedores = mysqli_query($db, $query);

            if($resultadoVendedores){
                // Redirecciona al usuario para evitar duplicar datos
                // Solo funciona si no hay código HTML previo
                header('Location: /admin?resultado=2');
            } 
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información general</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Casa con piscina" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <img src="../../imagenes/<?php echo $imagenPropiedad; ?>" alt="" class="imagen-small">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" name="habitaciones" id="habitaciones" placeholder="3" min="1" max="30" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños</label>
                <input type="number" name="wc" id="wc" placeholder="3" min="1" max="20" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamientos</label>
                <input type="number" name="estacionamiento" id="estacionamiento" placeholder="3" min="1" max="20" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultadoVendedores) ): ?>
                        <!--Con esto validamos si el vendedor que viene de la base de datos es el mismo que eleigió el usuario después de validar lo seleccione-->
                        <option  <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde" >
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>  