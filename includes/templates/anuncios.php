<?php 

$db = conectarDB();
/* Seleccionar consulta */
$consulta = "SELECT * FROM propiedades LIMIT ${limite}";
$resultado = mysqli_query($db, $consulta); 

?>

<div class="contenedor-anuncios">
<?php while($propiedad =  mysqli_fetch_assoc($resultado )): ?>
            <div class="anuncio">
                <picture>
                
                    <img loading="lazy" src="/bienesraicesctg/imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">
                </picture>

                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad['titulo']; ?> </h3>
                    <p><?php echo $propiedad['descripcion']; ?> </p>
                    <p class="precio"><?php echo $propiedad['precio']; ?> </p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                            <p><?php echo $propiedad['wc']; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p><?php echo $propiedad['estacionamiento']; ?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $propiedad['habitaciones']; ?></p>
                        </li>
                    </ul>

                    <a href="/bienesraicesctg/anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
            <?php  endwhile;?>
        </div>
