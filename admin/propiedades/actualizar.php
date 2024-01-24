<?php

require  './includes/app.php';

session_start();

$auth = $_SESSION['login'];

if(!$auth){
    header('location: /bienesraicesctg/');
}
    // Validar en la URL
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
 
    // Redireccionar

    if(!$id){
        header('Location: /bienesraicesctg/admin');
    }
    
    require '../../includes/config/db.php';
    $db = conectarDB();
    // Obtener datos propiedad
    $consulta ="SELECT * FROM propiedades WHERE  id = ${id}";
    $resultado = mysqli_query($db, $consulta); 
    $propiedad = mysqli_fetch_assoc($resultado) ;

    //Llamada a vendedores
    
    $consulta = "SELECT * FROM vendedores" ;
    $resultado = mysqli_query($db, $consulta); 

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento =  $propiedad['estacionamiento'];
$vendedoresID =  $propiedad['vendedores_id'];
$imagenPropiedad =  $propiedad['imagen'];

    $errores =  [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){



        $titulo =  mysqli_real_escape_string($db,  $_POST['titulo']);
        $precio =  mysqli_real_escape_string($db,  $_POST['precio']);
        $descripcion =  mysqli_real_escape_string($db,  $_POST['descripcion']);
        $habitaciones =  mysqli_real_escape_string($db,   $_POST['habitaciones']);
        $wc =  mysqli_real_escape_string( $db, $_POST['wc']);
        $estacionamiento =  mysqli_real_escape_string($db,  $_POST['estacionamiento']);
        $vendedoresID =  mysqli_real_escape_string( $db, $_POST['vendedor']);
        $creado = date('Y/m/d') ;

        // Asignar imagen
        $imagen = $_FILES['imagen'];
        // Validar campos

        if(!$titulo){
            $errores[] = 'tienes que colocar un titulo';
        }

        if(!$precio){
            $errores[] = 'tienes que colocar un precio';
        }
       

        if( strlen($descripcion) < 50){
            $errores[] = 'tienes que colocar ,mas caracteres (5)';
        }

        if(!$precio){
            $errores[] = 'tienes que colocar un precio';
        }
       
        if(!$habitaciones){
            $errores[] = 'tienes que colocar el numero de habitaciones';
        }
        if(!$wc){
            $errores[] = 'tienes que colocar el numero de baños';
        }
        if(!$estacionamiento){
            $errores[] = 'tienes que colocar el numero de estacionamientos';
        }
        if(!$vendedoresID){
            $errores[] = 'seleccione un perfil';
        }

        // Validar peso de imagen

        $medida = 1000 * 1000; 

        if( $imagen['size'] > $medida ){
            $errores[] = 'La imagen es muy pesada';
        }

        // Revisar que el arrglo de errores este vacio

        if(empty($errores)){
            /* Subida de archivos */
            $carpetaImagenes = '../../imagenes/';
        
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            
            if($imagen['name']){
                
                /* Eliminar imagen previa */
                unlink($carpetaImagenes . $propiedad['$imagen']);
                
                
                
                $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen ); /* Subir imagen nueva */
            } else {
                $nombreImagen = $propiedad['$imagen'];
            }


             
            

            

            
            
        // insertar en la base de datos
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = ${$nombreImagen};, descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedores_id = ${vendedoresID} WHERE id = ${id}"; 

        $resultado = mysqli_query($db, $query);

        if ($resultado) { 
            header('Location: /bienesraicesctg/admin?resultado=2');
            
        } 
       
    }
      
    }
    
    incluirTemplate('header');
?>

    
<main class="contenedor seccion">
    <h1>Gestor de bienes raices</h1>
    <h2>Actualizar prpieda</h2>
   
    <a href="/bienesraicesctg/admin/" class="boton boton-verde"> Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form class="formulario" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion general</legend>
            
            <label for="titulo"> Titulo: </label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">
            
            <label for="precio"> Precio: </label>
            <input type="text" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen"> Imagen: </label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png"  >

            <img src="/bienesraicesctg/imagenes/<?php echo $imagenPropiedad;?>" class="imagen-small" >

            <label for="descripcion" > Descripcion:</label>
            <textarea  id="descripcion" name="descripcion" ><?php echo $descripcion;?></textarea>
        </fieldset>

        <fieldset>
            <legend> Informacion Propiedad</legend>

            <label for="habitaciones"> habitaciones: </label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="10" value="<?php echo $habitaciones;?>">
            
            <label for="wc"> Baños: </label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="10" value="<?php echo $wc;?>">

            <label for="estacionamiento"> Estacionamiento: </label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="10" value="<?php echo $estacionamiento;?>">

        </fieldset>

        <fieldset >
            <legend> Vendedor</legend>

            <select  name="vendedor">
                <option value=""> ---Seleccione--- </option>
                <?php  while($vendedor = mysqli_fetch_assoc($resultado)) :?>
                    <option <?php echo $vendedoresID === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>
                <?php endwhile;?>    
            </select>
            
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">

    </form>
    </main>
<?php 
    incluirTemplate('footer');
    
?>