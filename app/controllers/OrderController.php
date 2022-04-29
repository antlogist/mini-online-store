<?php 

include_once '../../classes/Request.php';
include_once '../../classes/CSRFToken.php';
include_once '../../classes/Session.php';
include_once '../../config/Database.php';
include_once '../../models/Order.php';
include_once 'CartController.php';


class OrderController {

  /**
   * Create order
   * @param $request
   * @return mixed
   */
    public function createOrder() {

        // Receive post request
        $request = json_decode(file_get_contents('php://input'), true);
        $request = (object) $request;

        if(!Session::has("user_cart") || count(Session::get("user_cart")) < 1) {
            echo json_encode([
                "fail" => "No items in the cart"
            ]);
            exit;
        }

        if (CSRFToken::verifyCSRFToken($request->token, true)) {
            // Dtabase instance and connection
            $database = new Database();
            $db = $database->connect();

            // Order class instance
            $order = new Order($db);

            //Get cart items
            $cart_items = CartController::getCartItems(true);

            $uniq_id = time();

            foreach($cart_items as $cart_item) {

                $product_id = $cart_item['id'];
                $order_id = $uniq_id;
                $product_sku = $cart_item['sku'];
                $user_id = 1;
                $qty = $cart_item['qty'];
                $price = $cart_item['price'];
                $total_price= $price * $qty;

                $order->create($product_id, $order_id, $product_sku, $user_id, $qty, $price, $total_price);

            }

            Session::remove('user_cart');

            echo json_encode(["success" => "Thank you for your order"]);
            exit;

        }

        echo json_encode(["fail" => "Token mismatch"]);
        exit;

    }
}
