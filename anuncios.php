<?php 
 require  './includes/app.php';
    $inicio = true;
    $db = conectarDB();
    incluirTemplate('header');
    
?>
    

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>
        <?php 

        $limite = 3; 
        include 'includes/templates/anuncios.php';
        ?>  
    </main>

<?php 

    mysqli_close($db);

incluirTemplate('footer')

?>