<?php
    require_once('daoPayment.php');

    $email = $_POST['email'];
    $coupon = $_POST['couponId'];

    $daoPayment = new DaoPayment();
    $resultPay = $daoPayment->pay($email, $coupon);
    if ($resultPay == -1){
        echo -1;
    } 
    else if ($resultPay == -2){
        echo -2;
    }
    else {
        echo 1;
    }
    // Si devuelve -1 es que ya hay un pedido para el día de hoy para ese usuario, -2 el carrito está vacio y 1 se completa el pago
?>