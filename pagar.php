<?php
    require_once('php/daoProduct.php');
    require_once('php/daoBasket.php');
    require_once('php/basket.php');
    require_once('php/daoUser.php');
    require_once('php/daoCoupon.php');
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
        <link rel="stylesheet" type="text/css" href="css/style_main.css"></link>
        <link rel="stylesheet" type="text/css" href="css/style_store.css"></link>
        <link rel="stylesheet" type="text/css" href="css/style_pago.css"></link>

        <title>EShopGroceries - Pagar</title>
        <link rel="icon" type="image/x-icon" href="img/logo/logo.png">
    </head>

    <?php
            session_start();
    ?>

    <body>

        <div class="row">
            <div class="col-9 padding-Logo ">
                <img class="logo" src="img/logo/logo.png"></img>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="./mercado.php">Inicio</a>
                </div>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="./interfazPersonal.php">Perfil</a>
                </div>
            </div>
            <div class="col-1 padding-0 padding-Menu">
                <div class="menuLateralDerecho">
                    <a href="#footerZone">Contacto</a>
                </div>
            </div>
        </div>
        
        <form action="busqueda.php" method="POST">
            <div class="row barraBusqueda">
                <div class="col-8">
                <?php        
                    $daoUser = new DaoUser();
                    $daoUser->userLoggedIn();
                ?>
                </div>
                <div class="col-3 busqueda">
                    <input type="text" class="form-control inputBusqueda" name="BUSQUEDA" id="inputBusqueda" placeholder="Buscar ...">
                </div>
                <div class="col-1">
                    <input type="image" src="img/icons/Lupa.png" class="lupa"></input>
                </div>
            </div>
        </form>

        
        <div class="container-fluid centroRegistro">
           <div class="row">
                <div class="col-10 tiraProductos">
                    <div class="container-md centroPago">
                        <div class="row containerPago">
                            <div class="col-5 ">
                                <h4>Nombre Titular de la Tarjeta</h4>
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control inputTexto" id="inputNombreTarjeta" placeholder="Introduce tu nombre">
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div class="col-5">
                                <h4>Número de Tarjeta</h4>
                            </div>
                            <div class="col-7">
                                <input type="email" class="form-control inputTexto" id="inputNumTarjeta" placeholder="Introduce tu tarjeta">
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div class="col-5">
                                <h4>Fecha de expiración</h4>
                            </div>
                            <div class="col-7">
                                <input type="date" class="form-control inputTexto" id="inputFecha">
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div class="col-5">
                                <h4>Código de Seguridad</h4>
                            </div>
                            <div class="col-7">
                                <input type="number" class="form-control inputTexto" id="inputCVC" placeholder="Introduce Código de Seguridad">
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div class="col-5">
                                <h4>Codigo Postal</h4>
                            </div>
                            <div class="col-7">
                                <input type="number" class="form-control inputTexto" id="inputCP" placeholder="Introduce tu Codigo Postal">
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div class="col-5">
                                <h4>Dirección</h4>
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control inputTexto" id="inputDireccion" placeholder="Introduce tu Dirección">
                            </div>
                        </div>
                        <div class="row containerCupon">
                            <div class="row containerCuponInterno">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="inputCupon"><h4>Cupón</h4></label>
                                        </div>
                                        <div class="col-8 inputCuponContainer">
                                            <select id="inputCupon" class="form-select" aria-label="Default select example">
                                                <option value="0" selected>Sin Cupón</option>
                                                <?php
                                                    $daoCoupon = new DaoCoupon();
                                                    $daoCoupon->printCoupons();
                                                ?>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!--Div Vacio-->
                                </div>
                            </div>
                        </div>
                        <div class="row containerPago">
                            <div id='errorDiv' class='alert alert-danger' role='alert' style="display: none"></div><br>
                        </div>
                        <div class="row containerPago">
                            <div class="col">
                                <button type="button" disabled id="payButton" class="btn btn-danger botonPagarPedido" onclick="payOrder()">PAGAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 carrito">
                    <div class="row">
                        <div class="col">
                            <h3>Carrito</h3>
                        </div>
                        <div class="col">
                            <img class="carritoIMG" src="./img/icons/Basket.PNG">
                        </div>
                    </div>
                    <hr></hr>
                    <div>
                        <?php
                            $objBasket = new Basket();
                            $objBasket->updateBasket($_SESSION['user']['email']);
                            $objBasket->printBasket();
                            echo '
                            <h4 class="discountText"><b><label id="totalDescuento" style="display: none"></label></b></h4>
                            ';
                        ?>
                        <button onclick="location.href='./pagar.php'" type="button" class="btn btn-danger botonFinalizar">Finalizar</button>
                        <br><br>
                    </div>    
                </div>
           </div>
        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- JS propio -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/paymentController.js"></script>
        <script src="js/basketController.js"></script>
        <script src="js/validatePayment.js"></script>
    </body>
    <footer id="footerZone">
        <hr>
        <div class="row">
            <div class="col-4 leftColumnFooter">
                <b><p>E-Shop Groceries - Avenida de los institutos, s/n. 13600 Alcazar de San Juan (Ciudad Real) 
                    <br> Telf: 555-5555-555-55 -  e-mail: EShopGroceries@Groceries.com<br><br>
                <i>Todos los derechos reservados.</i><br><br>
                Web desarrollada por el alumno de Desarrollo de aplicaciones web en el I.E.S Juan Bosco,
                <i>Samuel</i><br><br>

                Enlaces de Interés:</b>

                </p>
            </div>
            <div class="col-8 rightColumnFooter">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3083.442200223938!2d-3.2240970846593426!3d39.391500725272486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd69af036cec6af9%3A0x3cb32e283081ecee!2sIES%20Juan%20Bosco!5e0!3m2!1ses!2ses!4v1649858760279!5m2!1ses!2ses" width="1050" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </footer>
</html>