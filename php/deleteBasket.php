<?php
    require_once('daoBasket.php');

    $email = $_POST['email'];
    $productId = $_POST['idProducto'];

    $daoBasket = new DaoBasket();
    $daoBasket->deleteBasketData($email, $productId);

    $res = "Se ha borrado el producto";
    echo $res;
?>