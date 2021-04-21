<?php 
    class articulo
    {
        //variables
        private $conex;
        private $table = 'articulos';
        public $id;
        public $titulo;
        public $imagen;
        public $texto;
        public $fecha_creacion;
        //metodos
        public function __construct($db)
        {
            $this->conex = $db;
        }

        public function leer()
        {
            $consulta = "SELECT id, titulo, imagen, texto, fecha_creacion FROM $this->table";
            $stmt = $this->conex->Prepare($consulta);
            $stmt->execute();
            $lista_articulos = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $lista_articulos;
        }

        public function leer_individual()
        {
            $consulta = "SELECT id, titulo, imagen, texto, fecha_creacion FROM $this->table WHERE id=:id LIMIT 0,1";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('id');
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            $articulos = $stmt->fetch(PDO::FETCH_OBJ);
            return $articulos;
        }

        public function crear()
        {
            $consulta = "INSERT into $this->table  (titulo, imagen, texto) values (:titulo, :imagen, :texto)";
            $stmt = $this->conex->Prepare($consulta);
            $this->limpiardatos('imagen');
            $this->limpiardatos('titulo');
            $this->limpiardatos('texto');
            $stmt->bindParam(':imagen',  $this->imagen , PDO::PARAM_STR);
            $stmt->bindParam(':titulo',$this->titulo, PDO::PARAM_STR);
            $stmt->bindParam(':texto', $this->texto, PDO::PARAM_STR);
                if($stmt->execute()) return true;
            printf("error $\n" , $stmt->error);
        }

        public function actualizar()
        { 
                if ($this->imagen == "") {
                    $consulta = "UPDATE $this->table  SET titulo=:titulo, texto=:texto where id = :id";
                    $stmt = $this->conex->Prepare($consulta);
                }else {
                    $consulta = "UPDATE $this->table  SET titulo=:titulo, imagen=:imagen, texto=:texto where id = :id";
                    $stmt = $this->conex->Prepare($consulta);
                    $this->limpiardatos('imagen');
                    $stmt->bindParam(':imagen',  $this->imagen , PDO::PARAM_STR);
                }
            $this->limpiardatos('titulo');
            $this->limpiardatos('texto');
            $this->limpiardatos('id');
            $stmt->bindParam(':titulo',$this->titulo, PDO::PARAM_STR);
            $stmt->bindParam(':texto', $this->texto, PDO::PARAM_STR);
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