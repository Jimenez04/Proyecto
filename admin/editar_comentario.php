<?php
    include("../includes/header.php");
    $basedatos = new basemysql();
    $db = $basedatos->conexion();
    $comentario = new comentario($db);
    //acciones
        if (isset($_GET['id'])) 
        {
            $comentario->id = $_GET['id'];
            $comentario_item = $comentario->leer_individual();
        }

        if (isset($_POST['editarComentario'])) 
        {
            $comentario->id = $_POST['id'];
            $comentario->estado = $_POST['cambiarEstado'];
            if (empty($comentario->id) || $comentario->id == '' || $comentario->estado =='') 
            {
                    $error = "Algunos campos estan vacios";
            }else
            {
                if($comentario->actualizar())
                {
                    $mensaje = "Actualizado correctamente";
                    header("Location:comentarios.php?mensaje=" . urlencode($mensaje));
                }else{
                    $error = "No se pudo actualizar";
                } 
            }
            
        }

        if (isset($_POST['borrarComentario'])) 
        {
            $comentario->id = $_POST['id'];
            if($comentario->borrar_individual())
            {
                $mensaje = "Eliminado correctamente";
                header("Location:comentarios.php?mensaje=" . urlencode($mensaje));
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
            <h3>Editar Comentario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action=""> 

            <input type="hidden" name="id" value="<?php echo $comentario_item->id_comentario; ?>">

            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly>
                <?php echo $comentario_item->comentario; ?>
                </textarea>              
            </div>               

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" 
                value="<?php echo $comentario_item->nombre_usuario; ?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="cambiarEstado" aria-label="Default select example">
                <option value="">--Seleccionar una opción--</option>
                <option value="1"<?php if($comentario_item->estado == "1"){echo "Selected";} ?>
                >Aprobado</option>
                <option value="0"<?php if($comentario_item->estado == "0"){echo "Selected";} ?>
                >No Aprobado</option>              
                </select>                 
            </div>  

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       