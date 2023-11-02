<?php 

    require '../../includes/app.php';

    use App\Propiedad;

    estaAutenticado();

    // BASE DE DATOS
    $db = conectarDB();

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);

    // echo '<pre>';
    // var_dump($resultadoVendedores);
    // echo '</pre>';

    // Array con mensajes de errores
    $errores = Propiedad::getErrores();

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedores_id = '';

    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST);
        $errores = $propiedad->validar();


        // Comprobar que el arreglo de errores esta vacío
        if(empty($errores)){

            $propiedad->guardar();

            // Asignar Files a una variable
            $imagen = $_FILES['imagen'];
    
           
    
            // echo "<pre>";
            // var_dump($errores);
            // echo "</pre>";

            // SUBIDA DE ARCHIVOS

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ). "jpg";

            // Subir la imagen
            move_uploaded_file($imagen["tmp_name"], "$carpetaImagenes" . $nombreImagen);



            // echo $query;

            $resultadoVendedores = mysqli_query($db, $query);

            if($resultadoVendedores){
                // Redirecciona al usuario para evitar duplicar datos
                // Solo funciona si no hay código HTML previo
                header('Location: /admin?resultado=1');
            } 
        }
    }
    
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form action="/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información general</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Casa con piscina" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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

                <select name="vendedores_id">
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultadoVendedores) ): ?>
                        <!--Con esto validamos si el vendedor que viene de la base de datos es el mismo que eleigió el usuario después de validar lo seleccione-->
                        <option  <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde" >
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>  