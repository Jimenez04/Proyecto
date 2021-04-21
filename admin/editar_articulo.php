<?php 
    include("../includes/header.php");
    $basedatos = new basemysql();
    $db = $basedatos->conexion();
    $articulo = new articulo($db);
    //acciones
        if (isset($_GET['id'])) 
        {
            $articulo->id = $_GET['id'];
            $articulo_item = $articulo->leer_individual();
        }

        if (isset($_POST['editarArticulo'])) 
            {
                $articulo->id = $_POST['id'];
                $articulo->titulo = $_POST['titulo'];
                $articulo->texto = $_POST['texto'];
                    if ($_FILES['imagen']['error'] > 0) 
                    {
                        if (empty($articulo->titulo) || $articulo->titulo == "" 
                            || empty($articulo->texto) || $articulo->texto == ""   ) 
                        {
                            $error = "Algunos campos estan vacios";
                        }else 
                        {
                            if($articulo->actualizar())
                            {
                                $mensaje = "Actualizado correctamente";
                                header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                                exit();
                            }else {
                                $error = "No se pudo actualizar";
                            }
                        }
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
                                if($articulo->actualizar())
                                {
                                    $mensaje = "Actualizado correctamente";
                                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                                }else{
                                    $error = "No se pudo actualizar";
                                } 
                        }
                    }
            }

            if (isset($_POST['borrarArticulo'])) 
            {
                $articulo->id = $_POST['id'];
                if($articulo->borrar_individual())
                {
                    $mensaje = "Eliminado correctamente";
                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                }else{
                    $error = "No se pudo eliminar";
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
            <h3>Editar Artículo</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $articulo_item->id; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $articulo_item->titulo ?>">               
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . $articulo_item->imagen;?>">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">               
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px">
                <?php echo $articulo_item->texto ?>
                </textarea>              
            </div>          
        
            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Artículo</button>

            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>