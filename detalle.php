<?php
        include("includes/header_front.php");
        $basedatos = new basemysql();
        $db = $basedatos->conexion();
        $articulo = new articulo($db);
        $comentarios = new comentario($db);
        if (isset($_GET['id'])) 
        {
            $articulo->id = $_GET['id'];
            $articulo_item = $articulo->leer_individual();
            $comentarios_item = $comentarios->leer_individual_por_articulo($articulo->id);
        }

        if (isset($_POST['enviarComentario'])) 
        {
            $comentarios->email_usuario = $_POST['usuario'];
            $comentarios->comentario = $_POST['comentario'];
            $comentarios->articulo_id = $_POST['articulo'];
                if (empty($comentarios->email_usuario) || $comentarios->email_usuario == ''
                    || empty($comentarios->comentario) || $comentarios->comentario == ""
                    || empty($comentarios->articulo_id) || $comentarios->articulo_id == "") {
                        $error = "Algunos campos estan vacios";
                }else {
                    if ($comentarios->crear()) {
                        $mensaje = "Comentario creado correctamente, Estado: Revisión";
                        echo("<script> location.href = '".RUTA_FRONT."'; </script>");
                    }else {
                        $error = "Error interno... 500";
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
        <div class="col-sm-12">
           <?php if (isset($mensaje)) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><?php echo $mensaje; ?> </strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           <?php endif; ?>
        </div>    
    </div>

    <div class="container-fluid"> 
      
        <div class="row">
                
        <div class="row">
        <div class="col-sm-12">
            
        </div>  
    </div>

            <div class="col-sm-12">
                <div class="card">
                   <div class="card-header">
                        <h1><?php echo $articulo_item->titulo ?></h1>
                   </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="<?php echo RUTA_FRONT . $articulo_item->imagen; ?>" class="card-img-top">
                        </div>

                        <p><?php echo $articulo_item->texto ?></p>

                    </div>
                </div>
            </div>
        </div>  
  
        <div class="row">        
            <?php if (isset($_SESSION['autenticado'])) : ?>
                <div class="col-sm-6 offset-3">
                    <form method="POST" action="">
                        <input type="hidden" name="articulo" value="<?php echo $articulo->id ?>">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['email']?>" readonly>               
                        </div>
                    
                        <div class="mb-3">
                            <label for="comentario">Comentario</label>   
                            <textarea class="form-control" name="comentario" style="height: 200px"></textarea>              
                        </div>          
                    
                        <br />
                        <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
    <h3 class="text-center mt-5">Comentarios</h3>
        <?php if ($comentarios_item) : foreach($comentarios_item as $comentario) : ?>
                <h4><i class="bi bi-person-circle"></i> <?php echo $comentario->nombre_usuario; ?></h4>
                <p><?php echo $comentario->comentario; ?></p>
        <?php endforeach; endif; ?>
    </div>
         
    </div>
<?php include("includes/footer.php"); ?>
       