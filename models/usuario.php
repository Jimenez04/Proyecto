<?php 
    class usuario
    {
        //variables
        private $conex;
        private $table = 'usuarios';
        public $id;
        public $nombre;
        public $email;
        public $password;
        public $fecha_creacion;
        public $rol;
        //metodos
        public function __construct($db)
        {
            $this->conex = $db;
        }

        public function leer()
        {
            $consulta = "SELECT u.id as usuario_id, u.nombre as usuario_nombre, u.email as usuario_email,
             u.fecha_creacion as usuario_fecha_creacion, r.nombre as rol FROM $this->table u INNER JOIN roles r ON r.id = u.rol_id";
            $stmt = $this->conex->Prepare($consulta);
            $stmt->execute();
            $lista_usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $lista_usuarios;
        }

        public function leer_individual()
        {
            $consulta = "SELECT u.id as usuario_id, u.nombre as usuario_nombre, u.email as usuario_email,
            u.fecha_creacion as usuario_fecha_creacion, r.nombre as rol FROM $this->table u INNER JOIN
             roles r ON r.id = u.rol_id WHERE u.id=:id LIMIT 0,1";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            $usuarios = $stmt->fetch(PDO::FETCH_OBJ);
            return $usuarios;
        }

        public function registrar()
        {
                $consulta = "INSERT into $this->table  (nombre, email, password, rol_id) values
                (:nombre, :email, :password, :rol)";
               $stmt = $this->conex->Prepare($consulta);
               $this->limpiardatos('nombre');
               $this->limpiardatos('email');
               $this->limpiardatos('password');
               $this->password = md5($this->password);
               $this->rol = 0;
               $stmt->bindParam(':nombre',  $this->nombre , PDO::PARAM_STR);
               $stmt->bindParam(':email',$this->email, PDO::PARAM_STR);
               $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
               $stmt->bindParam(':rol', $this->rol, PDO::PARAM_INT);
                   if($stmt->execute()) return true;
               printf("error $\n" , $stmt->error);
        }

        public function validar_usuario()
        {
            $consulta = "SELECT * FROM $this->table u WHERE email=:email";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('email');
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        public function actualizar()
        { 
            $consulta = "UPDATE $this->table  SET rol_id=:rol where id = :id";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('rol');
            $this->limpiardatos('id');
            $stmt->bindParam(':rol',$this->rol, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                if($stmt->execute()) return true;
            printf("error $\n" , $stmt->error);
        }

        public function borrar_individual()
        {
            $consulta = "DELETE FROM $this->table WHERE id=:id";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        public function acceder()
        {
            $consulta = "SELECT * FROM $this->table u WHERE email=:email AND password =:password";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('email');
            $this->limpiardatos('password');
            $this->password = md5($this->password);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_OBJ);
            if ($resultado) {
                return true;
            }else{
                return false;
            }
        }
        
        private function limpiardatos($propiedad)
        {
            if (property_exists($this, $propiedad)) {
                return $this->$propiedad = htmlspecialchars(strip_tags($this->$propiedad));
            }
            return $this->$propiedad;
        }
    }
?>