<?php
    require_once('libreriaPdo.php');

    class DaoProduct
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('id18809134_eshopgroceries');
        }

        public function listProduct()
        {
            $productId = 0;
            $consulta = "SELECT * FROM product WHERE productId > :PRODUCTID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':PRODUCTID' => $productId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $arrayProductos = [];
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){
                $arrayProducto = [
                    "productId" => $fila['productId'],
                    "product" => $fila['product'],
                    "price" => $fila['price'],
                    "icon" => $fila['icon']
                ];
                array_push($arrayProductos, $arrayProducto); 
            }
            return $arrayProductos;
        } /* Lo mismo que listProductById pero lista todos los productos */

        public function listProductByName($product)
        {
            $consulta = "SELECT * FROM product WHERE product LIKE :PRODUCT"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':PRODUCT' => "%$product%");//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $arrayProductos = [];
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){
                $arrayProducto = [
                    "productId" => $fila['productId'],
                    "product" => $fila['product'],
                    "price" => $fila['price'],
                    "icon" => $fila['icon']
                ];
                array_push($arrayProductos, $arrayProducto); 
            }
            return $arrayProductos;
        } /* lo mismo que listProductById pero lista por nombre, lo uso para las busquedas */

        public function listProductById($productId)
        {
            $consulta = "SELECT * FROM product WHERE productId = :PRODUCT"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':PRODUCT' => $productId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){
                $arrayProducto = [
                    "productId" => $fila['productId'],
                    "product" => $fila['product'],
                    "price" => $fila['price'],
                    "icon" => $fila['icon']
                ];
            }
            return $arrayProducto;
        } /* MEtodo que sirve para listar un producto en base a una ID que se le pasa por parametro, de tal manera que devuelve un array en la que cada posición es un atributo (columna de la base de datos también), de un producto */

        public function printMarket(){
            $arrayProductos = $this->listProduct();
            foreach ($arrayProductos as $product){
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
            }/* Metodo para imprimir los productos que haya en la base de datos, de tal manera que genera el mercado */
        }

        public function printSearch($search){
            $arrayProductos = $this->listProductByName($search);
            foreach ($arrayProductos as $product){
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
            }
        } /* Metodo para imprimir los productos que se busquen, se le pasa por parametro una cadena de texto para la busqueda y se llamma a listPRoductByName que busca según la cadena de texto que se le pasa por parametro */
    }
?>