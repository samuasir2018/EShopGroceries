<?php
    require_once('daoBasket.php');

    $email = $_POST['email'];
    $productId = $_POST['idProducto'];
    $amount = $_POST['cantidad'];

    $daoBasket = new DaoBasket();

    if ($daoBasket->checkEntry($email, $productId)){
        $daoBasket->insertDataBasket($email, $productId, $amount);

        $res = "Se inserta una nueva entry para el carrito";

        echo $res;
    } else{
        $amount += $daoBasket->getAmount($email, $productId);
        $daoBasket->addAmountAlreadyExistEntry($email, $productId, $amount);

        $res = "Ya existia esa entry. se añaden más cantidad de ese producto";

        echo $res;
    }/* Para ver si existia un producto en el carrito o no, de tal manera que se añade nuevo o simplemente se aumenta la cantidad */
?>