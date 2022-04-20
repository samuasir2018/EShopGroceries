<?php
    require_once('../php/daoUser.php');
    require_once('../php/user.php');
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!--Css propio-->
        <link rel="stylesheet" type="text/css" href="../css/style_registro.css"></link>
        <link rel="stylesheet" type="text/css" href="../css/style_main.css"></link>



        <title>EShopGroceries - Registro</title>
        <link rel="icon" type="image/x-icon" href="../img/logo/logo.png">
        <?php
            session_start();
        ?>
    </head>

    <body>
        <?php
            $daoUserSession = new DaoUser();
            $daoUserSession->userLoggedInRegister();
        ?>

        <div class="row">
            <div class="col-9 padding-Logo ">
                <img class="logo" src="../img/logo/logo.png"></img>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="./inicio.php">Inicio</a>
                </div>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="./inicio.php">Perfil</a>
                </div>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="#footerZone">Contacto</a>
                </div>
            </div>
        </div>

    <form action="" id="formInsert" method="post">
        <div class="container-md centroRegistro">
            <div class="row containerRegistro">
                <div class="col-5 ">
                    <label for="NOMBRE"><h4>Nombre</h4></label>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="NOMBRE" id="inputNombre" placeholder="Introduce tu nombre">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Email</h4>
                </div>
                <div class="col-7">
                    <input type="email" class="form-control inputTexto" name="EMAIL" id="inputEmail" placeholder="Introduce tu email">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Contraseña</h4>
                </div>
                <div class="col-7">
                    <input type="password" class="form-control inputTexto" name="CONTRASENNA" id="inputContrasenna" placeholder="Introduce tu Contraseña">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>DNI</h4>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="DNI" id="inputDni" placeholder="Introduce tu DNI">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Tarjeta de credito</h4>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="TARJETA" id="inputTarjeta" placeholder="Introduce tu tarjeta de credito">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Codigo Postal</h4>
                </div>
                <div class="col-7">
                    <input type="number" min=0 class="form-control inputTexto" name="CP" id="inputCP" placeholder="Introduce tu Codigo Postal">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Dirección</h4>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="DIRECCION" id="inputDireccion" placeholder="Introduce tu Dirección">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Telefono</h4>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="TELEFONO" id="inputTelefono" placeholder="Introduce tu Teléfono">
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Pregunta Secreta</h4>
                </div>
                <div class="col-7">
                    <select class="form-select" aria-label="Default select example" name="PREGUNTASECRETA" id="inputPreguntaSecreta">
                        <option value="0" selected>¿Dónde naciste?</option>
                        <option value="1" selected>¿Nombre de tu mascota?</option>
                        <option value="2" selected>¿Cuál es tu ciudad favorita?</option>
                    </select>
                </div>
            </div>
            <div class="row containerRegistro">
                <div class="col-5">
                    <h4>Respuesta Secreta</h4>
                </div>
                <div class="col-7">
                    <input type="text" class="form-control inputTexto" name="RESPUESTASECRETA" id="inputRespuestaSecreta" placeholder="Introduce tu Respuesta Secreta">
                </div>
            </div>
            <div class="row containerRegistro">
                <button type="submit" name="BOTONREGISTRO" id="enviarRegistro" class="btn btn-danger botonRegistrar">REGISTRAR</button>
            </div>
            <?php
                if (isset($_POST['BOTONREGISTRO']))
                {
                    $encryptPassword = sha1($_POST['CONTRASENNA']);
                    $fechaRegistro = date('Y-m-d');
                    if ($_POST['NOMBRE'] == '' or $_POST['EMAIL'] == '' or $encryptPassword == '' or $_POST['DNI'] == '' or $_POST['TARJETA'] == '' or $_POST['DIRECCION'] == '' or $_POST['CP'] == '' or $_POST['CP'] == '' or $_POST['PREGUNTASECRETA'] == '' or $_POST['RESPUESTASECRETA'] == ''){
                        echo "<div class='alert alert-danger' role='alert'>Uno de los campos es nulo. Rellene todos los</div>";
                    } else {
                        $objUser = new User($_POST['NOMBRE'], $_POST['EMAIL'], $encryptPassword, $_POST['DNI'], $_POST['TARJETA'], $_POST['DIRECCION'], $_POST['CP'], $_POST['TELEFONO'], $fechaRegistro, $_POST['PREGUNTASECRETA'], $_POST['RESPUESTASECRETA'] );
                        $daoUser = new DaoUser();
                        $message = $daoUser-> createUser($objUser);
                        if ($message==1){
                            echo "<div class='alert alert-success' role='alert'>El registro se ha realizado correctamente</div>";
                        } else if ($message=1062){
                            echo "<div class='alert alert-danger' role='alert'>Usuario Duplicado, utilice un dni y/o correo diferente. Código de error: ".$message."</div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Error desconocido. Contacte con el administrador, número de error: ".$message."</div>";
                        }
                    }
                }
            ?>
            <div id='errorDiv' class='alert alert-danger' role='alert' style="display: none"></div>
        </div>
    </form>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script type="module" src="../js/main.js"></script>
    </body>
    <footer id="footerZone">
        <hr>
        <div class="row">
            <div class="col-4 leftColumnFooter">
            <p><b>E-Shop Groceries - Avenida de los institutos, s/n. 13600 Alcazar de San Juan (Ciudad Real) 
                    <br> Telf: 555-5555-555-55 -  e-mail: EShopGroceries@Groceries.com<br><br>
                <i>Todos los derechos reservados.</i><br><br>
                Web desarrollada por el alumno de Desarrollo de aplicaciones web en el I.E.S Juan Bosco,
                <i>Samuel</i><br><br></b>
            </p>
            </div>
            <div class="col-8 rightColumnFooter">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3083.442200223938!2d-3.2240970846593426!3d39.391500725272486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd69af036cec6af9%3A0x3cb32e283081ecee!2sIES%20Juan%20Bosco!5e0!3m2!1ses!2ses!4v1649858760279!5m2!1ses!2ses" width="1050" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </footer>
</html>