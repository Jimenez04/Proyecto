<?php 
        include("../includes/header.php");
        $basedatos = new basemysql();
        $db = $basedatos->conexion();
        $articulo = new articulo($db);
        //acciones
            if (isset($_POST['crearArticulo'])) 
            {
                $articulo->titulo = $_POST['titulo'];
                $articulo->texto = $_POST['texto'];
                    if ($_FILES['imagen']['error'] > 0) 
                    {
                        $error = "Ningun archivo seleccionado";
                    }else
                    {
                        if (empty($articulo->titulo) || $articulo->titulo == "" 
                            || empty($articulo->texto) || $articulo->texto == ""   ) 
                        {
                            $error = "Algunos campos estan vacios";
                        }else 
                        {//imagen
                            $image = $_FILES['imagen']['name'];
                            $imageArr = explode('.', $image);
                            $rand = rand(1000, 99999); //nombre diferente en cada vez;
                            $nuevo_nombre_imagen = $imageArr[0] . $rand . '.' . $imageArr[1];
                            $rutaimagenparcial = "../img/articulos/" . $nuevo_nombre_imagen;
                            $articulo->imagen = "/img/articulos/" . $nuevo_nombre_imagen;
                            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaimagenparcial); //copio la imagen en el servidor de aplicacion
                         //fin imagen///////
                                if($articulo->crear())
                                {
                                    $mensaje = "Creado correctamente";
                                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                                } 
                        }
                    }
            }
?>
    <div class="row">
        <div class="col-sm-12">
           <?php if (isset($error)) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong><?php echo $error; ?> </strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           <?php endif; ?>
        </div>    
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Crear un Nuevo Artículo</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingresa el título">               
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="apellidos" placeholder="Selecciona una imagen">               
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px"></textarea>              
            </div>          
        
            <br />
            <button type="submit" name="crearArticulo" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Artículo</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php"); ?>
       