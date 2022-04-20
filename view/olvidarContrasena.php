<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!--Css propio-->
        <link rel="stylesheet" type="text/css" href="../css/style_main.css"></link>

        <title>EShopGroceries - Recuperar Contraseña</title>
        <link rel="icon" type="image/x-icon" href="../img/logo/logo.png">
    </head>

    <body>

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
                    Perfil
                </div>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    Contacto
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="inicioSesion">
                    <h2>Recuperación de contraseña</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 divRegistro">
                <h5>¿Eres nuevo? <a href="./registro.php">Registrate aquí
                </a></h5>
            </div>
        </div>


    <div class="loginCentral">
        <div class="row">
            <div class="col-12 direccionPass">
                <h2>Dirección email</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 divInputDireccion">
                <input type="email" class="form-control inputDireccion" id="inputEmail" name="EMAIL" placeholder="Introduce tu correo electronico">
            </div>
        </div>
        <div class="row">
            <div class="col-12 direccionPass">
                <h2>Pregunta Secreta</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 divInputDireccion">
                <select class="form-select pregunta" aria-label="Default select example" name="PREGUNTASECRETA" id="inputPreguntaSecreta">
                    <option value="0" selected>¿Dónde naciste?</option>
                    <option value="1" selected>¿Nombre de tu mascota?</option>
                    <option value="2" selected>¿Cuál es tu ciudad favorita?</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 direccionPass">
                <h2>Respuesta Secreta</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 divInputDireccion">
                <input type="text" class="form-control inputDireccion" id="inputRespuestaaSecreta" name="RESPUESTASECRETA" placeholder="Introduce tu respuesta secreta">
            </div>
        </div>
        <div class="row">
            <div class="col-12 direccionPass">
                <h2>Nueva Contraseña</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 divInputDireccion">
                <input type="password" class="form-control inputDireccion" id="inputNuevaContrasena" name="NUEVACONTRASENA" placeholder="Introduce tu nueva contraseña">
            </div>
        </div>
    </div>

    <div class="contenedorCentralInferior">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary botonIniciarSesion" name="enviarRegistro" id="botonRegistro" onclick="passRecovery()">Recuperar contraseña</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 divOlvidoPass">
                <h5><a href="./olvidarContrasena.php">¿Has olvidado tu contraseña?
                </a></h5>
            </div>
        </div>
    </div>



        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="../js/passwordController.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
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