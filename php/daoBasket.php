<?php
    require_once('libreriaPdo.php');
    require_once('daoProduct.php');

    class DaoBasket
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('eshopgroceries');
        }

        public function searchProduct($productId){
            $consulta = "SELECT * FROM product WHERE productId = :PRODUCTID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':PRODUCTID' => $productId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){//Solo devuelve un producto, porque son de ID unicos
                $arrayProducto = [
                    "productId" => $fila['productId'],
                    "product" => $fila['product'],
                    "price" => $fila['price'],
                    "icon" => $fila['icon']
                ]; 
            }
            return $arrayProducto;
        } /* Metodo para buscar un producto en base a una id que pasamos por parametro */

        public function insertDataBasket($email, $productId, $amount){
            $consultaInsertar = "INSERT INTO basket (email, productId, amount) VALUES (:EMAIL, :PRODUCTID, :AMOUNT)";
            $paramInsertar = array(':EMAIL' => $email,':PRODUCTID' => $productId,':AMOUNT' => $amount);
            $this->objDB->SimpleQuery($consultaInsertar,$paramInsertar);
        } /*Insertar básico en la base de datos con email, id del producto y cantidad*/

        public function checkEntry ($email, $productId){
            $consulta = "SELECT * FROM basket WHERE productId = :PRODUCTID AND email= :EMAIL"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':EMAIL' => $email,':PRODUCTID' => $productId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $count = 0;
            foreach ($filasArray as $fila){//Solo devuelve un producto, porque son de ID unicos
                $count ++;
            }
            if ($count == 0){ //Si devuelve 0 es que no había ninguna entrada de ese producto con ese email y se envia true, si devuelve algo mayor a 1 se envia false
                return true;
            } else {
                false;
            }
        }

        public function getAmount ($email, $productId){
            $consulta = "SELECT amount FROM basket WHERE productId = :PRODUCTID AND email= :EMAIL"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':EMAIL' => $email,':PRODUCTID' => $productId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $amount = 0;
            foreach ($filasArray as $fila){//Solo devuelve un producto, porque son de ID unicos
                $amount = $fila['amount'];
            }
            return $amount;
        }

        public function addAmountAlreadyExistEntry ($email, $productId, $amount){
            $consultaUpdate = "UPDATE basket SET amount = :AMOUNT WHERE productId = :PRODUCTID AND email= :EMAIL";
            $paramUpdate = array(':EMAIL' => $email,':PRODUCTID' => $productId,':AMOUNT' => $amount);
            $this->objDB->SimpleQuery($consultaUpdate,$paramUpdate);
        }/* Para casos en los que si exista el producto, se actualiza su cantidad, por ejemplo en el carrito ya había Agua y se añade una botella nueva */

        public function getBasketData($email){
            $consulta = "SELECT * FROM basket WHERE email= :EMAIL"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':EMAIL' => $email);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $arrayProducts = [];
            foreach ($filasArray as $fila){//Por cada producto que haya en la basket de el usuario especificado por el email, se vuelca a un arrayPRoduct con el dato id del producto y la cantidad
                $arrayProduct = [
                    "productId" => $fila['productId'],
                    "amount" => $fila['amount']
                ]; 

                array_push($arrayProducts, $arrayProduct);//volcado del arrayPRoduct sobre el arrayProducts, de esta manera en la nueva iteración se sobreescribirá arrayProduct, pero sus datos ya estarán en el array grande de productos (arrayProducts), donde cada posiciópn es un obj producto
            }
            return $arrayProducts;
        }

        public function deleteBasketData($email, $productId){
            $consultaDelete = "DELETE FROM basket WHERE productId = :PRODUCTID AND email= :EMAIL";
            $paramDelete = array(':EMAIL' => $email,':PRODUCTID' => $productId);
            $this->objDB->SimpleQuery($consultaDelete,$paramDelete);
        }/* Delete simple dependiendo del email y el producto */

        public function deleteAllBasketData($email){
            $consultaDelete = "DELETE FROM basket WHERE email= :EMAIL";
            $paramDelete = array(':EMAIL' => $email);
            $this->objDB->SimpleQuery($consultaDelete,$paramDelete);
        }/* Delete simple de toda la basket dependiendo del email */

        public function getTotalBasket($email){
            $data = $this->getBasketData($email);//Vuelco los datos de la basket dependiendo del email
            $daoProduct = new DaoProduct();
            $totalPrice = 0; //seteo el precio a 0

            foreach ($data as $product){
                $productInfo = $daoProduct->listProductById($product['productId']);
                $totalPrice += $productInfo['price'] * $product['amount'];
            } // por cada producto sumo al precio total el precio del producto por el total
            return $totalPrice;
        }
    }
?>