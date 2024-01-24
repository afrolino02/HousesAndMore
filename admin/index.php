<?php 
    require '../includes/app.php';


    session_start(); 

    $auth = $_SESSION['login'];

    if(!$auth){
        header('location: /bienesraicesctg/');
    }



    /* Importar la conexion con la base de datos */
    
    /* Seleccionar consulta */
    $consulta = "SELECT * FROM propiedades";
    $resultadoConsulta = mysqli_query($db, $consulta); 



    /* Muestra el resultado */
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('/bienesraicesctg/imagenes/' . $propiedad['imagen']);
            /* Eliminar todo */
            $query = "DELETE FROM propiedades WHERE id = ${id}"; 
            $resultado = mysqli_query($db, $query);

            
            if($resultado){
                header('Location: /bienesraicesctg/admin?resultado=3 ');
            }
        }
    }

    incluirTemplate('header');
    
?>

<main class="contenedor seccion">
    <h1>Gestor de bienes raices</h1><!--  -->
    <?php if($resultado == 1):?>
        <p class="alerta exito">Registrado correctamente</p>
    
    <?php endif;?>
    <?php if($resultado == 2):?>
        <p class="alerta exito">Actualizado correctamente</p>
    
    <?php endif;?>
    <?php if($resultado == 3):?>
        <p class="alerta exito">Eliminado correctamente</p>
    
    <?php endif;?>



    <a href="/bienesraicesctg/admin/propiedades/crear.php" class="boton boton-verde"> Nueva propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while( $propiedades = mysqli_fetch_assoc($resultadoConsulta)):?>
                    <tr>
                        <td> <?php echo $propiedades['id']?></td>
                        <td> <?php echo $propiedades['titulo']?></td>
                        <td class="imagen-tabla"> <img src="../imagenes/<?php echo $propiedades['imagen']?>"></td>
                        <td><?php echo $propiedades['precio']?></td>
                        <td>
                            <a href="./propiedades/actualizar.php?id=<?php echo $propiedades['id'];?>" class='boton-verde-block'>Actualizar</a>
                            
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo  $propiedades['id'];?>">
                            <input type="submit" class="boton-rojo-block w-100" w-100 value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endwhile;?>
                </tbody>
        </table>

    </main>
<?php 
    mysqli_close($db);
    incluirTemplate('footer');
    
?>