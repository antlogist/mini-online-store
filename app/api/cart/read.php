<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  
  include_once '../../controllers/CartController.php';

  $cart = new CartController();
  $cart->getCartItems();
