<?php

include_once '../../classes/Request.php';
include_once '../../classes/CSRFToken.php';
include_once '../../classes/Session.php';
include_once 'CartController.php';

class ShopController {
  public function addItem() {

    $request = json_decode(file_get_contents('php://input'), true);
    $request = (object) $request;

    if (CSRFToken::verifyCSRFToken($request->token, false)) {

      if (!$request->product_id) {
        echo json_encode(["fail" => "Malicious Activity"]);
        exit;
      }

      if($request->qty > 1000 || $request->qty < 1) {
        echo json_encode(["fail" => "Malicious Activity"]);
        exit;
      }

      CartController::add($request);

      $countItems = count(Session::get("user_cart"));

      echo json_encode(["success" => "Product added to cart successfully", "countItems" => $countItems]);
      exit;
    }

    echo json_encode(["fail" => "Token mismatch"]);
    exit;
  }
}
