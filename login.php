<?php

    /* Conectar con la base de datos */
    
    require 'includes/app.php';
    $db = conectarDB();
    
    /* Declaracion de errores */
   $errores = [];

    /* Sacar por medio del requestmethod del Post */
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /*  Sanitizar la entrada*/
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    /* Sanitizar el password */
    $password = mysqli_real_escape_string($db, ($_POST['password']));
    // Validar  Email y Contraseña  
    
    
    if(!$email){
        $errores[] = "El Email es necesario";
    }
    if(!$password){
        $errores[] = "El password es necesario";
    }

    
    
    if(empty($errores)){

        // Revisar si el usuario existe

        $query = "SELECT * FROM usuarios WHERE email = '${email}'";
        $resultado = mysqli_query($db, $query);


        if ($resultado->num_rows) {
            // Revisar si el usuario es correcto
            $usuario = mysqli_fetch_assoc($resultado);

            $auth = password_verify($password, $usuario['password']);

            if ($auth) {
                // Primero iniciar la sesion 
                session_start();
                $_SESSION['usuario']= $usuario['email'];
                $_SESSION['login'] = true;

                header('location: /bienesraicesctg/admin');
            } else {
                /* Validar que la contrase;a es incorrecta */
                $errores[] = "La contraseña es incorrecta";
            }
            
        } else {
            // Validar que el usuario no existe
            $errores[] = "El usuario no exsiste";
        }
        
        
        /* echo '<pre>';
        var_dump($resultado);
        echo '</pre>'; */
        

    } 
   

}

        
    
    incluirTemplate('header');
    
?>  
 <main class=" seccion contenedor contenido-centrado">

     <h1>Loguearse</h1>
     <form class="formulario "  method="post">
         
         
         <?php foreach($errores as $error): ?>
            
            <div class=" alerta error">  <?php echo $error ?> </div> 
                    
            
            
            <?php endforeach; ?>
            <fieldset>
                <legend>Información Personal</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Email" id="email">

                <label for="password"> Contraseña</label>
                <input type="password" name="password" placeholder="ingresar contraseña" id="contraseña">
            </fieldset>
            
            <input type="submit" value="Enviar" class="boton-verde">
        </form>
        
    </main>
        

        <?php 


mysqli_close($db);
    incluirTemplate('footer');
  
?>