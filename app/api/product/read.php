<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Product.php';

  // Dtabase instance and connection
  $database = new Database();
  $db = $database->connect();
  
  // Product class instance
  $product = new Product($db);
  
  // Product query
  $result = $product->read();
  
  // Get row count
  $num = $result->rowCount();
  
  // Check if any products
  if($num > 0) {
      
    // Product array
    $products_arr = array();
    
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        
        extract($row);
        
        $product_item = array(
            'id' => $id,
            'sku' => $sku,
            'name' => $name,
            'img_url' => $img_url,
            'description' => html_entity_decode($description),
            'price' => $price,
      );

      // Push to "data"
      array_push($products_arr, $product_item);
    }

    // Transform into JSON and output
    echo json_encode($products_arr);

  } else {
    // No products found
    echo json_encode(
      array('message' => 'Товары не найдены')
    );
  }