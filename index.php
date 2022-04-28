<?php
    // Start session if it is not already started
    if (!isset($_SESSION)) session_start();

    include_once 'app/classes/CSRFToken.php';

    // Set session token
    $token = CSRFToken::_token();

    // Set qty products in cart on load
    $countItemsOnLoad = count(Session::get("user_cart"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Custom style-->
    <link rel="stylesheet" href="dist/css/all.css">
    <!--Vue js-->
    <script src="dist/js/all.js?ver=<?= microtime(); ?>" defer></script>
</head>
<body>
    <script>
      const token = '<?= $token ?>';
      const countItemsOnLoad = '<?= $countItemsOnLoad ?>';
    </script>

    <div id="app"></div>

    <!--Bootstrap script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>