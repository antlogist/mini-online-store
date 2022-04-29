<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../classes/Request.php';
include_once '../../controllers/OrderController.php';

  //Check the request type
  if(Request::has('post')){
    $order = new OrderController();
    $order->createOrder();
  } else {
    return null;
  }
