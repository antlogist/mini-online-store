<?php 

class Order {

    // Database
    private $conn;
    private $table = 'orders';

   /**
   *  Database in counstructor
   *  @param $db
   */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create order
     * @param $product_id
     * @param $order_id
     * @param $product_sku
     * @param $user_id
     * @param $qty
     * @param $price
     * @param $total_price
     * @return mixed
   */
    public function create($product_id, $order_id, $product_sku, $user_id, $qty, $price, $total_price) {

        $product_id = htmlspecialchars(strip_tags($product_id));
        $order_id = htmlspecialchars(strip_tags($order_id));
        $product_sku = htmlspecialchars(strip_tags($product_sku));
        $user_id = htmlspecialchars(strip_tags($user_id));
        $qty = htmlspecialchars(strip_tags($qty));
        $price = htmlspecialchars(strip_tags($price));
        $total_price = htmlspecialchars(strip_tags($total_price));

        $query = 'INSERT INTO ' . $this->table . ' (product_id, order_id, product_sku, user_id, qty, price, total_price) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)';

        $stmt = $this->conn->prepare($query);

        // Execute query
        if ($stmt->execute([$product_id, $order_id, $product_sku, $user_id, $qty, $price, $total_price])) {
            return $stmt;
        }

        // Echo error if smth goes wrong
        echo json_encode(["fail" => "Something went wrong"]);
    }
}