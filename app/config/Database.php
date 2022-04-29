<?php 

  class Database {
    // Database parameters
    private $host = 'db';
    private $dbName = 'online_store';
    private $userName = 'root';
    private $password = 'root';
    private $conn;

    // Database connection
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->userName, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }

  }
