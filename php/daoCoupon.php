<?php
    require_once('libreriaPdo.php');

    class DaoCoupon
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('id18809134_eshopgroceries');
        }

        public function printCoupons(){
            $arrayCoupons = $this->getCoupon();
            foreach ($arrayCoupons as $coupon){
                echo '
                <option value="'.$coupon["couponId"].'">Número cupón: '.$coupon["couponId"].' - '.$coupon["description"].'</option>
                ';
            }
        } /* Funcion simple para imprimir cupones, hace uso de getCoupon que se explicará más adelante*/

        public function discount($couponId){
            $consulta = "SELECT * FROM coupon where isActive = 1 AND couponId = :COUPONID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':COUPONID' => $couponId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){// da un resultado único ya que el id cupon es único
                $arrayCoupon = [
                    "couponId" => $fila['couponId'],
                    "discount" => $fila['discount'],
                    "description" => $fila['description']
                ];
            }
            return $arrayCoupon['discount'];
        }/* Devuelve un cupón en base a un id cupón */

        public function getCoupon()
        {
            $consulta = "SELECT * FROM coupon where couponId > 0 AND isActive = 1"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array();//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            $arrayCoupons = []; //array de cupones
            foreach ($filasArray as $fila){ // por cada cupon que devuelvo lo añado al arrayCoupon, que tiene en sus posiciones el cuponID, el descuento y la descripción, a su vez esto se vuelcan el arrayCoupons, que tiene en cada posición un objcupon completo. Así luego se puede sobreescribir el contenido de arrayCoupon
                $arrayCoupon = [
                    "couponId" => $fila['couponId'],
                    "discount" => $fila['discount'],
                    "description" => $fila['description']
                ];
                array_push($arrayCoupons, $arrayCoupon);
            }
            return $arrayCoupons;
        }

        public function printClub(){
            $arrayCoupons = $this->getCoupon();
            echo '
            <ul style="list-style-type:none;" class="list-group list-group">';
            foreach ($arrayCoupons as $coupon) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                    <div class="fw-bold">'.$coupon["description"].'</div>
                    Nº de cupón: '.$coupon["couponId"].'<br>
                    Este cupón ofrece un '.$coupon["description"].'
                    </div>
                    <span class="badge bg-primary rounded-pill">%</span>
                </li>';
            }
            echo '
            </ul>
            ';
        } /* Metodo simple para imprimir la lista de cupones en el perfil del usuario */

        public function getCouponById($couponId)
        {
            $consulta = "SELECT * FROM coupon where isActive = 1 AND couponId = :COUPONID"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':COUPONID' => $couponId);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){ // solo deuvelve uno porque el id cupón es único
                $arrayCoupon = [
                    "couponId" => $fila['couponId'],
                    "discount" => $fila['discount'],
                    "description" => $fila['description']
                ];
            }
            return $arrayCoupon;
        } /* Devuelve un cupón con un id que le pasamos por parametro*/
    }
    
?>