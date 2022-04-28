<?php

class CartController {

  protected static $isItemInCart = false;

  /**
   * Add cart item in the shopping cart session
   * @param $request
   * @return mixed
   * @throws \Exception
   */
  static function add($request) {
    try {
      $index = 0;
      if(!Session::has("user_cart") || count(Session::get("user_cart")) < 1) {
        Session::add("user_cart", [
          0 => ["product_id" => $request->product_id, "quantity" => $request->qty]
        ]);
      } else {
        foreach($_SESSION["user_cart"] as $cart_items) {
          $index++;
          foreach($cart_items as $key => $value) {
            if($key == "product_id" && $value == $request->product_id) {
              //Replace cart item with a new array
              array_splice($_SESSION["user_cart"], $index-1, 1,
                array([
                  "product_id" => $request->product_id,
                  "quantity" => $cart_items["quantity"] + $request->qty
                ]));
              self::$isItemInCart = true;
            }
          }
        }

        // If shopping cart was empty
        if (!self::$isItemInCart) {
          array_push($_SESSION["user_cart"], [
            "product_id" => $request->product_id, "quantity" => $request->qty
          ]);
        }
      }
    } catch(\Exception $ex) {
      echo $ex->getMessage();
    }
  }

  /**
   * Remove cart item from the shopping cart session
   * @param $index
   */
  static function removeItem($index) {
    if (count(Session::get("user_cart")) <= 1) {
      //empty cart
      self::clear();
    } else {
      unset($_SESSION["user_cart"][$index]);
      sort($_SESSION["user_cart"]);
    }
  }

/**
 * Remove all items from the shopping cart session
 * @param $index
 */
  static function clear() {
    Session::remove("user_cart");
  }

}
