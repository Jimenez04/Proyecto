<?php 
    class basemysql {
        //cadena de conexion
        private $host = "localhost";
        private $db_name = "blog";
        private $username = 'root';
        private $password = '';
        private $conex;

        public function conexion()
        {
            $this->conex = null;
            try {
                $dsn = 'mysql:host=' . $this->host . ';dbname='. $this->db_name;
                $pdo = new PDO($dsn, $this->username, $this->password);
                $this->conex = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
                $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOexcepcion $e) {
            echo "<script> console.log($e->getMessage());</script>";
            }
            return $this->conex;
        }
        
    }
?>