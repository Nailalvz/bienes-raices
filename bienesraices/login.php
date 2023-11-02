<?php 

    require 'includes/app.php';

    $db = conectarDB();
    // Autenticar el usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $email = mysqli_real_escape_string($db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($db, $_POST['password'] );

        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }

        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)){
            // Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($db, $query);

            // Accedemos de esta forma porque $resultado es un objeto
            // Comprueba si hay resultados de la consulta
            if($resultado->num_rows){

                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no devolviendo true o false
                $auth = password_verify($password, $usuario['password']);

                if($auth){

                    // Iniciar sesión
                    session_start();

                    // Lennar el arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');


                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }
        }

    }


    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
        <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="example@example.com" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="" id="password" required>
            </fieldset>

            <input type="submit" value="Iniciar sesión" class="boton boton-verde">

        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>  