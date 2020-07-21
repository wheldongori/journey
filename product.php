<?php

    class Product{
        private $conn;
        private $tbl_name = 'products';

        public $id;
        public $name;
        public $price;
        public $description;
        public $category_id;
        public $timestamp;

        function __construct($db){
            $this->conn = $db;
        }

        function create(){
            $query = "INSERT INTO
            ".$this->tbl_name."
            SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";


            $stmt = $this->conn->prepare($query);

             // posted values
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    
            // to get time-stamp for 'created' field
            $this->timestamp = date('Y-m-d H:i:s');

            $stmt->bindParam(":name",$this->name);
            $stmt->bindParam(":price",$this->price);
            $stmt->bindParam(":description",$this->description);
            $stmt->bindParam(":category_id",$this->category_id);
            $stmt->bindParam(":created",$this->timestamp);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }

        //read all products
        function readAll($from_record_num,$records_per_page){
            $query = "SELECT
                        id, name, description, price, category_id, 
                          FROM "
                          .$this->tbl_name."
                          ORDER BY 
                             name ASC
                          LIMIT {$from_record_num},{$records_per_page}";
            $stmt = $this->conn->prepare($query);
            
            $stmt->execute();

            return $stmt;

        }
         //read all products
         function read(){
            $query = "SELECT
                        id, name, description, price, category_id, 
                          FROM "
                          .$this->tbl_name."
                          ORDER BY 
                             name ASC";
            $stmt = $this->conn->prepare($query);
            
            $stmt->execute();

            return $stmt;

        }

        //read single product
        function readSingleProduct(){
            $query = "SELECT 
                        id, name, description, price, category_id, 
                        FROM"
                        .$this->tbl_name."
                        WHERE id = ? LIMIT 0,1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1,$this->id);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            $result = isset($row) ? $this->name = $row['name'] : NULL;
        }

    }