<?php
    class db{
        private $host = "localhost";
        private $dbname = "id21633661_visenzzo2";
        private $user = "id21633661_visenzzo2";
        private $password = "Visenzzo*1";
        public function conexion(){
            try {
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
                return $PDO;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

?>