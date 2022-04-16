<?php
    require_once('daoCoupon.php');

    $coupon = $_POST['couponId'];

    if($coupon == -1){
        return 0;
    }

    $daoCoupon = new DaoCoupon();
    $resultDiscount = $daoCoupon->discount($coupon);
    echo $resultDiscount;
?>