<?php 
    include("../includes/header.php");
    $basedatos = new basemysql();
    $db = $basedatos->conexion();
    $usuario = new usuario($db);
    $lista_usuarios = $usuario->leer();
  ?>
  
    <div class="row">
        <div class="col-sm-12">
           <?php if (isset($_GET['mensaje'])) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><?php echo $_GET['mensaje']; ?> </strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           <?php endif; ?>
        </div>    
    </div>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Usuarios</h3>
    </div>     
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblUsuarios" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha de Creación</th>                       
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($lista_usuarios as $item) :?>
                    <tr>
                        <td> <?php echo $item->usuario_id; ?></td>
                        <td><?php echo $item->usuario_nombre; ?></td>
                        <td><?php echo $item->usuario_email; ?></td>
                        <td><?php echo $item->rol; ?></td>
                        <td><?php echo $item->usuario_fecha_creacion; ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $item->usuario_id; ?>"
                             class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>                                            
                        </td>
                    </tr>
                <?php endforeach; ?>             
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblUsuarios').DataTable();
    });
</script>