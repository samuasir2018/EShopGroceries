<?php
    require_once('libreriaPdo.php');
    require_once('daoUser.php');
    require_once('daoProduct.php');
    require_once('daoCoupon.php');

    class DaoOrder
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('id18809134_eshopgroceries');
        }

        public function printOrderHistory($email){
            $daoUser = new DaoUser ();
            $orderHistory = $daoUser->getDataOrderDetails($email); /* Saco los pedidos en base al email del usuario */
            foreach ($orderHistory as $pedido){ // por cada pedido se imprime
                echo '
                <button type="button" class="collapsible">Pedido '.$pedido["orderId"].':</button>
                <div class="content">
                    <table class="table" style="text-align:center">
                        <tr>
                            <th>Num. Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Ver Pedido</th>
                        </tr>
                        <tr>
                            <td>'.$pedido["orderId"].'</td>
                            <td>
                            '.$pedido["date"].'</td>
                            <td>
                            '.$pedido["total"].'</td>
                            <td><a href="ticket.php?ticketId='.$pedido["orderId"].'" target="_blank"><img class="iconTicket" src="../img/icons/viewOrder.jpg"></img></a></td>
                        </tr>
                    </table>
                </div>';
            }
        } /* Metodo para imprimir el historial del pedido, la ultima posición es una imagen que al clickar nos lleva a una nueva vista dependiendo del id del pedido */

        public function getDataOrder($orderId)
        {
            $consulta = "SELECT * FROM orderdetails WHERE orderId = :ORDERID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':ORDERID' => $orderId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){ // devuelve una order porque el orderId es único
                $arrayOrder = [
                    "orderId" => $fila['orderId'],
                    "email" => $fila['email'],
                    "date" => $fila['date'],
                    "total" => $fila['total'],
                ];
            }
            return $arrayOrder;
        } /* Metodo para sacar pedidos en base a un orderId, pero no todos sus atributos ya que lo uso en algunas funciones especificas donde no requiero todos los datos */
    

        public function getDataOrderByOrderId($orderId){
            $consulta = "SELECT * FROM orderdetails WHERE ORDERID = :ORDERID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':ORDERID' => $orderId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){ // devuelve un único pedido porque el orderid es único
                $arrayOrder = [
                    "orderId" => $fila['orderId'],
                    "email" => $fila['email'],
                    "date" => $fila['date'],
                    "total" => $fila['total'],
                    "coupon" => $fila['coupon']
                ];
            }
            return $arrayOrder;
        } /* Metodo para sacar un pedido en base a su orderId*/

        public function getDataOrderProduct($orderId){
            $consulta = "SELECT * FROM order_product WHERE orderId = :ORDERID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':ORDERID' => $orderId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $arrayListaProductos = [];
            foreach ($filasArray as $fila){ // devuelve las filas de la tabla order_product que es peddido - producto - cantidad, que coincidan con el orderId que se pasa por parametro
                $arrayProducto = [
                    "orderId" => $fila['orderId'],
                    "productId" => $fila['productId'],
                    "amount" => $fila['amount']
                ];
                array_push($arrayListaProductos, $arrayProducto); // volcado del arrayProducto en el arrayListaProductos, de esta manera cada posicion del arrayListaProductos es una entrada de la base de datos de la tabla order_product
            }
            return $arrayListaProductos;
        } // Se vuelcan los datos de productos de un pedido, por ejemplo del pedido 5 se compraron 3 botellas de agua, la tabla order_Product es una tabla intermedia para hacer la relación, número pedido con un producto y la cantidad del producto

        public function createTable($orderId){
            $daoProduct = new DaoProduct();
            $arrayOrderDetails = $this->getDataOrderByOrderId($orderId); // Obtengo los datos del pedido en base al orderId
            $arrayOrderProducts = $this->getDataOrderProduct($orderId); // Obtengo el listado de productos y cantidades de ese pedido
            $daoCoupon = new DaoCoupon();
            $arrayCoupon = NULL; // seteo el cupon en null por si el usuario no elije ninguno
            if ($arrayOrderDetails['coupon'] != NULL){ // si en el pedido hay algun cupon, lo guardo en arraycupon, haciendo una busqueda por id
                $arrayCoupon = $daoCoupon->getCouponById($arrayOrderDetails['coupon']); //con el id del cupon llamo al metodo que busca cupones por id
            }        
            echo '
            <div class="row">
                <div class="col-1">
                </div>
                <div class="col-10 ticket">
                    <table class="table table-hover" style="text-align:center">
                        <thead>
                            <tr>
                                <th scope="col">Nº Producto</th>
                                <th scope="col">ID Producto</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio total</th>
                            </tr>
                        </thead>
                        <tbody>';
            $cont = 1; // contador para la primera linea de número de articulo, por ejemplo Articulo 1 : Patatas con id 5 (5 es el id producto de las patatas por ejemplo)
            $totalPreDescuento = 0; // total antes del descuento
            foreach ($arrayOrderProducts as $productoPedido){// recorremos el array de productos y vamos imprimiendo los datos
                $arrayInfoProducto = $daoProduct->listProductById($productoPedido['productId']);
                echo '
                            
                                <tr>
                                    <th scope="row">'.$cont.'</th>
                                    <th scope="row">'.$arrayInfoProducto["productId"].'</th>
                                    <td>'.$arrayInfoProducto["product"].'</td>
                                    <td>'.$arrayInfoProducto["price"].'</td>
                                    <td>'.$productoPedido["amount"].'</td>
                                    <td>'.$productoPedido["amount"]*$arrayInfoProducto["price"].'€</td>
                                </tr>';
                $cont++;
                $totalPreDescuento +=$productoPedido["amount"]*$arrayInfoProducto["price"]; //precio es el precio del producto por cantidad y se le suma a lo que ya había
            }   
            echo '
                    </tbody>
                    </table>
                </div>
            </div>
            
            <h1 class="ticketDebt">Total del pedido: '.$totalPreDescuento.' €</h1>
            ';
            if (!$arrayCoupon == NULL){// si hay algun cupón de descuento imprimimos cuanto vale con el descuento
                echo'
                <h1 class="ticketDebt" style="color:red">Cupón de descuento seleccionado: '.$arrayCoupon['description'].'</h1>
                <h1 class="ticketDebt" style="color:red">Total del pedido con DESCUENTO: '.$arrayOrderDetails['total'].' €</h1>
                ';
            } else {
                echo'
                <h1 class="ticketDebt" style="color:red">No se seleccionó ningún cupón de descuento</h1>
                ' ;
            }
        } /* Metodo para imprimir tickets (recibo de compra) */
    }
    
?>