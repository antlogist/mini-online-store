<?php 

class Product {

    // Database
    private $conn;
    private $table = 'products';

   /**
   *  Database in counstructor
   *  @param $db
   */
    public function __construct($db) {
        $this->conn = $db;
    }

  /**
   * Get all products
   * @return mixed
   */
    public function read() {
        
        // Create query
        $query = 'SELECT id, sku, name, img_url, description, price FROM products';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();
        
        return $stmt;
    }
}
