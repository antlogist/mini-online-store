<?php 

  class Database {
    // Database parameters
    private $host = 'localhost';
    private $dbName = 'dbname';
    private $userName = 'username';
    private $password = 'password';
    private $conn;

    // Database connection
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->userName, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }

  }
