<?php
    require_once('libreriaPdo.php');
    require_once('daoProduct.php');

    class DaoBuylist
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('eshopgroceries');
        }

        public function printBuylist()
        {
            echo '
                <form>
                    <div class="container carrouselCentral">
                        <div id="" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <a href="buylist.php?BuylistId=1"><img src="../img/icons/Carousel.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block tituloCarrousel">
                                        <h2>Semana de los lacteos</h2>
                                    </div>
                                    </a>
                                </div>

                                <div class="carousel-item">
                                    <a href="buylist.php?BuylistId=2"><img src="../img/icons/Carousel2.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block tituloCarrousel">
                                        <h2>Lo mejor de la Panaderia</h2>
                                    </div>
                                    </a>
                                </div>

                                <div class="carousel-item">
                                    <a href="buylist.php?BuylistId=3"><img src="../img/icons/Carousel3.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block tituloCarrousel">
                                        <h2>Bebidas Refrescantes</h2>
                                    </div>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
        ';
        }/* Como esta parte del código es muy repetitiva lo he metido en un metodo */

        public function searchBuylist($buylistId)
        {
            $consulta = "SELECT * FROM buylist WHERE buylistId = :BUYLISTID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':BUYLISTID' => $buylistId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){ //solo devuelve una buylist porque tienen id único
                $arrayBuylist = [
                    "buylistId" => $fila['buylistId'],
                    "firstProduct" => $fila['firstProduct'],
                    "secondProduct" => $fila['secondProduct'],
                    "thridProduct" => $fila['thridProduct'],
                ];
            }
            return $arrayBuylist;
        } /*Metodo simple para devolver una buylist basandose en el id */

        public function printProductsBuylist($buylistId){

            $infoBuylist = $this->searchBuylist($buylistId); //busco una buylist con una id que recibimos por parametro
            
            $daoProduct = new DaoProduct();
            $count = 1; // Como hay 3 productos por buylist, seteo un contador en 1 que va aumentado por cada producto que imprime hasta ser menor que  4 (ya que solo hay 3 productos)

            while ($count < 4){
                if ($count == 1){
                    $product = $daoProduct->listProductById($infoBuylist["firstProduct"]);
                } else if ($count == 2){
                    $product = $daoProduct->listProductById($infoBuylist["secondProduct"]);
                } else {
                    $product = $daoProduct->listProductById($infoBuylist["thridProduct"]);
                }


                    echo '
                    <div class="col-4 productoIndivual">
                        <img src="../'.$product["icon"].'" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">'.$product["product"].' - Precio: '.$product["price"].'€</h5>
                            <div class="row textoCantidad">
                                <div class="col-4">
                                    <input type="number" class="form-control inputTexto textoCantidad" name="cantidad'.$product["productId"].'" id="cantidadInput'.$product["productId"].'" placeholder="Cantidad" value="1" min="1">
                                </div>
                                <div class="col-8">
                                    <button class="btn btn-primary buttonAdd" id="button'.$product["productId"].'" onclick="addBasket('.$product["productId"].', )">Añadir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                

                $count++;
            }
        }/* Metodo para imrpimir los productos de cada buylist */
    }
?>