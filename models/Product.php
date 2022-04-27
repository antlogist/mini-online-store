<?php 

class Product {

    // Database
    private $conn;
    private $table = 'products';

    // Database in counstructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all products
    public function read() {
        
        // Create query
        $query = 'SELECT id, name, img_url, description, price FROM products';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();
        
        return $stmt;
    }
}