<?php 
    class comentario
    {
        //variables
        private $conex;
        private $table = 'comentarios';
        public $id;
        public $comentario;
        public $estado;
        public $fecha_creacion;
        public $articulo_id;
        public $email_usuario;

        //metodos
        public function __construct($db)
        {
            $this->conex = $db;
        }

        public function leer()
        {
            $consulta = "SELECT c.id as id_comentario, c.comentario as comentario, c.estado as estado,
             c.fecha_creacion as fecha_creacion, c.usuario_id, u.email AS nombre_usuario, a.titulo AS titulo_articulo
             FROM $this->table c INNER JOIN usuarios u ON u.id = c.usuario_id INNER JOIN articulos a ON a.id = c.articulo_id";
            $stmt = $this->conex->Prepare($consulta);
            $stmt->execute();
            $lista_comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $lista_comentarios;
        }

        public function leer_individual()
        {
            $consulta = "SELECT c.id as id_comentario, c.comentario as comentario, c.estado as estado,
                        c.fecha_creacion as fecha_creacion, c.usuario_id, u.email AS nombre_usuario, 
                        a.titulo AS titulo_articulo FROM $this->table c INNER JOIN usuarios
                        u ON u.id = c.usuario_id INNER JOIN articulos a ON a.id = c.articulo_id
                        WHERE c.id = :id LIMIT 0,1";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            $comentario = $stmt->fetch(PDO::FETCH_OBJ);
            return $comentario;
        }

        public function leer_individual_por_articulo($id_articulo)
        {
            $consulta = "SELECT c.id as id_comentario, c.comentario AS comentario, c.estado
            AS estado, c.fecha_creacion AS fecha, c.usuario_id, u.email AS nombre_usuario
            FROM $this->table c INNER JOIN usuarios u on u.id = c.usuario_id
             where articulo_id = :articulo_id AND estado = 1";
            $stmt = $this->conex->Prepare($consulta);
            $id_articulo = htmlspecialchars(strip_tags($id_articulo));
            $stmt->bindParam(':articulo_id', $id_articulo, PDO::PARAM_INT);
            $stmt->execute();
            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $comentarios;
        }

        public function crear()
        {
            $consulta0 = "SELECT * from usuarios where email = :email";
            $stmt = $this->conex->Prepare($consulta0);
            $this->limpiardatos('email_usuario');
            $stmt->bindParam(':email',  $this->email_usuario , PDO::PARAM_STR);
            $stmt->execute();
            $usuario_id = $stmt->fetch(PDO::FETCH_OBJ)->id;
            $consulta = "INSERT into $this->table  (comentario, usuario_id, articulo_id, estado)
             values (:comentario, :usuario_id, :articulo_id, 0)";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('comentario');
            $this->limpiardatos('articulo_id');
            $stmt->bindParam(':comentario',  $this->comentario , PDO::PARAM_STR);
            $stmt->bindParam(':articulo_id',$this->articulo_id, PDO::PARAM_INT);
            $stmt->bindParam(':usuario_id',$usuario_id, PDO::PARAM_INT);
                if($stmt->execute()) return true;
            printf("error $\n" , $stmt->error);
            return false;
        }

        public function actualizar()
        { 
            $consulta = "UPDATE $this->table  SET estado=:estado where id = :id";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('estado');
            $this->limpiardatos('id');
            $stmt->bindParam(':estado',$this->estado, PDO::PARAM_INT);
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
        
        private function limpiardatos($propiedad)
        {
            if (property_exists($this, $propiedad)) {
                return $this->$propiedad = htmlspecialchars(strip_tags($this->$propiedad));
            }
            return $this->$propiedad;
        }
    }
?>