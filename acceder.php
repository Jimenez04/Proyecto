<?php 
    include("includes/header_front.php");
    $basedatos = new basemysql();
    $db = $basedatos->conexion();
    $usuario = new usuario($db);
    //acciones
        if (isset($_POST['acceder'])) 
        {
            $usuario->email = $_POST['email'];
            $usuario->password = $_POST['password'];
                if ( empty($usuario->email) || $usuario->email == "" 
                    || empty($usuario->password) || $usuario->password == ""   ) 
                {
                    $error = "Algunos campos estan vacios";
                }else 
                { 
                    if($usuario->acceder())
                    {
                        $_SESSION['autenticado'] = true;
                        $_SESSION['email'] = $usuario->email;
                        echo("<script> location.href = '".RUTA_FRONT."'; </script>");
                    }else
                    {
                        $error = "La contraseña o correo no son correctos";
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
        <h1 class="text-center">Acceso de Usuarios</h1>
        <div class="row">
            <div class="col-sm-6 offset-3">
                <div class="card">
                   <div class="card-header">
                        Ingresa tus datos para acceder
                   </div>
                    <div class="card-body">
                    <form method="POST" action="">

                   

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingresa el email">               
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Ingresa el password">               
                    </div>

                    <br />
                    <button type="submit" name="acceder" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Acceder</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>  
         
    </div>
<?php include("includes/footer.php"); ?>
       