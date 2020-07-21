<?php
    class Database{
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $dbname = 'php_oop_crud_level_1';
        private $conn;
        private static $instance;

        
        function dbConn(){
            try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->pass);
            }catch(PDOException $e){
                echo "Connection error:".$e->getMessage();
            }

            return $this->conn;
        }

        public static function getDbInstance(){
            if(!isset(self::$instance)){
                self::$instance = new Database();
            }
            return self::$instance;
        }
    }

