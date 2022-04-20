<?php
    require_once('libreriaPdo.php');
    require_once('daoBasket.php');
    require_once('daoCoupon.php');

    class DaoPayment
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('id18809134_eshopgroceries');
        }

        public function pay($email, $couponId){
            $objDaoBasket = new DaoBasket;
            $resultOrderDetails = $this->createOrderDetails($email, $couponId);// el metodo createORderDetails será explicado después, pero puede devolver -1 -2 o 1
            if ($resultOrderDetails == -1){
                return -1;
            } 
            else if ($resultOrderDetails == -2){
                return -2;
            }
            else {
                $this->insertOrderProduct($email); // el metodo insertOrderPRoduct será explicado más adelante
                $objDaoBasket->deleteAllBasketData($email); // borra el carrito
                return 1;
            }
        }/* Este metodo sirve para devolver el valor que reciba desde createOrderDetails, excepto si recibe otra cosa que no sea -1 y -2 en ese caso insertará el pedido y limpiará el carrito */

        public function checkEntryOrder ($email, $date){
            $consulta = "SELECT * FROM orderdetails WHERE date = :DATE AND email= :EMAIL"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':EMAIL' => $email,':DATE' => $date);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $count = 0;
            return count($filasArray) <= 0;
        } /* Metodo que sirve para comprobar si hay algun pedido con la fecha y el email que se le pasa por parametro, si contador es menor o igual que 0 devuelve true sino false*/

        public function createOrderDetails($email, $couponId){
            $date = date('Y-m-d'); // la fecha de hoy con el formato YYYY MM DD
            $daoBasket = new DaoBasket();
            $total = $daoBasket->getTotalBasket($email); // el total del pedido pasando por parametro el email
            $daoCoupon = new DaoCoupon();
            $coupon = $daoCoupon->getCouponById($couponId); // sacamos el cupon asociado al cuponID
            if ($coupon["couponId"] != 0)
            {
                $total = $total - ($total * $coupon["discount"] / 100); // si es distinto de null calculamos el total con el descuento aplicado
            }

            if ($total == 0){
                return -2; // si el total es 0 es que el carrito está vacio, entonces devolvemos -2 y ya manejaremos el error
            }
            
            if ($this->checkEntryOrder($email, $date)){ // comprobamos si el usuario tiene algún pedido para el día de hoy, si no lo tiene insertamos el nuevo pedido con el email, la fecha, el total y el cupon
                $consultaInsertar = "INSERT INTO orderdetails (email, date, total, coupon) VALUES (:EMAIL, :DATE, :TOTAL, :COUPON)";
                $paramInsertar = array(':EMAIL' => $email,':DATE' => $date,':TOTAL' => $total, ':COUPON' => $coupon["couponId"]);
                $this->objDB->SimpleQuery($consultaInsertar,$paramInsertar);
                return 1; 
            } else {
                return -1; // si devolvemos este -1 es porque ya existe 1 pedido para ese usuario y dia, por lo que ha llegado al limite y manejaremos el error en la siguiente función donde se devuelva el resultado
            }
        }/* Este metodo sirve para crear una entrada nueva en orderdetails con el email, la fecha, el total y el cupon, es básicamente un pedido nuevo */

        public function getOrderId($email){
            $date = date('Y-m-d');
            $consulta = "SELECT orderId FROM orderdetails WHERE date = :DATE AND email= :EMAIL"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':EMAIL' => $email,':DATE' => $date);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){//Solo devuelve un producto, porque son de ID unicos
                $orderId = $fila['orderId'];
            }
            return $orderId;
        } /* Metodo para obtener el orderId de un pedido pasandole el email y la fecha */

        public function insertOrderProduct($email){
            $objDaoBasket = new DaoBasket;
            $dataBasket = $objDaoBasket->getBasketData($email);
            $orderId = $this->getOrderId($email);
            foreach ($dataBasket as $entry){
                $consultaInsertar = "INSERT INTO order_product (orderId, productId, amount) VALUES (:ORDERID, :PRODUCTID, :AMOUNT)";
                $paramInsertar = array(':ORDERID' => $orderId,':PRODUCTID' => $entry['productId'],':AMOUNT' => $entry['amount']);
                $this->objDB->SimpleQuery($consultaInsertar,$paramInsertar);
            }
        } /* Metodo para meter tantas linea de pedido/ticket (orderid , ID producto y cantidad) como haya en el carrito a un pedido ya existente . Este metodo y el getOrderId no pueden fallar, porque se les llama en partes del codigo donde se comprueba previamente que existe un pedido con los requisitos necesarios, sino estos metodos nunca llegarian a ejecutarse*/


    }
?>