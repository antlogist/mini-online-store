<?php
if (!isset($_SESSION)) session_start();
include_once '../../classes/Session.php';
include_once '../../functions/helper.php';

class CartController
{

    protected static $isItemInCart = false;

    /**
     * Add cart item in the shopping cart session
     *
     * @param Object $request
     * @return void
     */
    static function add(Object $request)
    {
        try {
            $index = 0;
            if (!Session::has("user_cart") || count(Session::get("user_cart")) < 1) {
                Session::add("user_cart", [
                    0 => ["product_id" => $request->product_id, "quantity" => $request->qty]
                ]);
            } else {
                foreach ($_SESSION["user_cart"] as $cart_items) {
                    $index++;
                    foreach ($cart_items as $key => $value) {
                        if ($key == "product_id" && $value == $request->product_id) {
                            //Replace cart item with a new array
                            array_splice(
                                $_SESSION["user_cart"],
                                $index - 1,
                                1,
                                array([
                                    "product_id" => $request->product_id,
                                    "quantity" => $cart_items["quantity"] + $request->qty
                                ])
                            );
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
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @param Int $index
     * @return void
     */
    static function removeItem(Int $index)
    {
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
    static function clear()
    {
        Session::remove("user_cart");
    }


    /**
     * Get cart items
     * @return mixed
     * @throws \Exception
     */

    static function getCartItems($reqFromOrderClass = false)
    {

        // Get website link
        $link = getWebsiteUrl();
        $link .= '/app/api/product/read.php';

        // Get all products
        $products = json_decode(file_get_contents($link));
        $productsObject = array();

        // Transform array into object
        foreach ($products as $product) {
            $productsObject[$product->id] = $product;
        }

        try {
            $result = array();
            $cartTotal = 0;
            $cartTotalVat = 0;

            if (!Session::has("user_cart") || count(Session::get("user_cart")) < 1) {
                echo json_encode([
                    "fail" => "No items in the cart"
                ]);
                exit;
            }
            $index = 0;
            foreach (Session::get("user_cart") as $cart_items) {
                $productId = $cart_items["product_id"];
                $quantity = $cart_items["quantity"];
                $item = $productsObject[$productId];

                if (!$item) {
                    continue;
                }

                $totalPrice = $item->price * $quantity;
                $cartTotal = $totalPrice + $cartTotal;
                $totalPrice = number_format($totalPrice, 2);


                array_push($result, [
                    "id" => $item->id,
                    "img_url" => $item->img_url,
                    "sku" => $item->sku,
                    "name" => $item->name,
                    "price" => $item->price,
                    "qty" => $quantity,
                    "total_price" => $totalPrice,
                    "sort_index" => $index
                ]);

                $index++;
            }

            $cartTotal = number_format($cartTotal, 2);

            Session::add("cartTotal", $cartTotal);

            if ($reqFromOrderClass === true) {
                return $result;
            } else {
                echo json_encode(["items" => $result, "cartTotal" => $cartTotal]);
                exit;
            }
        } catch (\Exception $ex) {
            echo $ex;
        }
    }
}
