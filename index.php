<?php
        include("includes/header_front.php");
        $basedatos = new basemysql();
        $db = $basedatos->conexion();
        $articulo = new articulo($db);
        $lista_articulos = $articulo->leer();
?>

    <div class="container-fluid">
        <h1 class="text-center">Artículos</h1>
        <div class="row">
        <?php foreach($lista_articulos as $articulo_item) :?>
            <div class="col-sm-4">
                <div class="card">
                    <img src="<?php echo RUTA_FRONT . $articulo_item->imagen; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $articulo_item->titulo; ?></h5>
                        <p><strong><?php echo formatear_fecha($articulo_item->fecha_creacion); ?></strong></p>
                        <p class="card-text"><?php echo texto_corto($articulo_item->texto); ?></p>
                        <a href="detalle.php?id=<?php echo $articulo_item->id; ?>" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>            
    </div>
<?php include("includes/footer.php") ?>
       