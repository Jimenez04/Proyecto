<?php 
    include("../includes/header.php");
    $basedatos = new basemysql();
    $db = $basedatos->conexion();
    $usuario = new usuario($db);
    //acciones
        if (isset($_GET['id'])) 
        {
            $usuario->id = $_GET['id'];
            $usuario_item = $usuario->leer_individual();
        }

        if (isset($_POST['editarUsuario'])) 
        {
            $usuario->id = $_POST['id'];
            $usuario->rol = $_POST['rol'];
                if (empty($usuario->id) || $usuario->id == "" 
                || empty($usuario->rol) || $usuario->rol == ""   ) 
                {
                    $error = "Algunos campos estan vacios";
                }else 
                {
                    if($usuario->actualizar())
                    {
                        $mensaje = "Actualizado correctamente";
                        header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
                        exit();
                    }else
                    {
                        $error = "No se pudo actualizar";
                    }
                }
        }

        if (isset($_POST['borrarUsuario'])) 
        {
            $usuario->id = $_POST['id'];
            if($usuario->borrar_individual())
            {
                $mensaje = "Eliminado correctamente";
                header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
            }else
            {
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
            <h3>Editar Usuario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $usuario_item->usuario_id; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" 
                value="<?php echo $usuario_item->usuario_nombre; ?>" readonly>              
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" 
                value="<?php echo $usuario_item->usuario_email; ?>" readonly>               
            </div>
            <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" aria-label="Default select example" name="rol">
                <option value="">--Selecciona un rol--</option>
                <option value="1" <?php if($usuario_item->rol == "Administrador"){echo "Selected";} ?>
                >Administrador</option>  
                <option value="2" <?php if($usuario_item->rol == "Registrado"){echo "Selected";} ?>
                >Registrado</option>
            </select>             
            </div>          
        
            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       