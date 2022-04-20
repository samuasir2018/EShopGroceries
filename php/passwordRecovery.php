<?php
    require_once('daoUser.php');
    
    $email = $_POST['email'];
    $pregunta = $_POST['pregunta'];
    $respuesta = $_POST['respuesta'];
    $nuevaContrasena = $_POST['contrasena'];

    $daoUser = new DaoUser();
    if ($resultado = $daoUser->changePassword($email, $pregunta, $respuesta, $nuevaContrasena)){
        $res = "La contraseña ha sido actualizada correctamente";
    }else {
        $res = "La contraseña no ha sido actualizada";
    }
    echo $res;
?>