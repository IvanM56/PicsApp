<?php

class DB {

    private $host = HOST;
    private $user = USER;
    private $password = PASS;
    private $dbname = DBNAME;
    private $pdo;

    private $stmt;
    private $error;

    public function __construct(){

        $dsn = 'mysql:host='. $this->host .';dbname='. $this->dbname;
        
        // $this->pdo = setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        try {
            
            $this->pdo = new PDO($dsn, $this->user, $this->password);

        } catch (PDOException $e) {
            
            $this->error = $e->getMessage();
            
        }

    }


    public function query($sql){

        $this->stmt = $this->pdo->prepare($sql);

    }


    public function bind($param, $value){

        return $this->stmt->bindValue($param, $value);

    }


    public function execute(){

        return $this->stmt->execute();

    }

    public function getAll(){

        $this->stmt->execute();

        return $this->stmt->fetchAll(PDO::FETCH_OBJ);

    }


    public function getSingle(){

        $this->stmt->execute();

        return $this->stmt->fetch(PDO::FETCH_OBJ);

    }

    
    public function rowCount(){

        return $this->stmt->rowCount();
    }

    

}