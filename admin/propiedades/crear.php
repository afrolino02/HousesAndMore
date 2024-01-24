<?php
require '../../includes/app.php';
    
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;
    

    estaAutenticado();
    
    $db = conectarDB(); 

    $consulta = "SELECT * FROM vendedores" ;
    $resultado = mysqli_query($db, $consulta); 

    $errores = Propiedad::getErrores();

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedoresID= '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Instanciar
        $propiedad = new Propiedad($_POST);
        // Crear nombre unico
        $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";
        
        if($_FILES['imagen']['tmp_name']){
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

    

        // Validar
        $errores = $propiedad->validar();

        if(empty($errores)){
        
            

            if(!is_dir(CARPETA_IMAGENES)){
                mkdir((CARPETA_IMAGENES));
            }
            // nombre de imagen

            

            // Guardar en el servidor
            $image->save( CARPETA_IMAGENES . $nombreImagen );
            // Guardar
           $resultado = $propiedad->guardar();

        if ($resultado) { 
            header('Location: /bienesraicesctg/admin?resultado=1');
            
        } 
       
    }
      
    }
    
    incluirTemplate('header');
?>

    
<main class="contenedor seccion">
    <h1>Gestor de bienes raices</h1>
   
    <a href="/bienesraicesctg/admin/" class="boton boton-verde"> Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form class="formulario" method="post" action="/bienesraicesctg/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion general</legend>
            
            <label for="titulo"> Titulo: </label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">
            
            <label for="precio"> Precio: </label>
            <input type="text" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen"> Imagen: </label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png"  >

            <label for="descripcion" > Descripcion:</label>
            <textarea  id="descripcion" name="descripcion" ><?php echo $descripcion;?></textarea>
        </fieldset>

        <fieldset>
            <legend> Informacion Propiedad</legend>

            <label for="habitaciones"> habitaciones: </label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="10">
            
            <label for="wc"> Baños: </label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="10">

            <label for="estacionamiento"> Estacionamiento: </label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="10">

        </fieldset>

        <fieldset >
            <legend> Vendedor</legend>

            <select name="vendedorId">
    <option value="">---Seleccione---</option>
    <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
        <option <?php echo $vendedoresID === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>
     <?php endwhile; ?>
            </select>
            
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">

    </form>
    </main>
<?php 
    incluirTemplate('footer');
    
?>