<?php
    require_once('libreriaPdo.php');
    require_once('daoOrder.php');

    class DaoUser
    {
        private $objDB;

        public function __construct()
        {
            $this->objDB = new DB ('eshopgroceries');
        }

        public function createUser($objUser)
        {
            $name = $objUser->getName();
            $email = $objUser->getEmail();
            $password = $objUser->getPassword();
            $dni = $objUser->getDni();
            $creditCard = $objUser->getCreditCard();
            $address = $objUser->getAddress();
            $postcode = $objUser->getPostcode();
            $phone = $objUser->getPhone();
            $registerDate = $objUser->getRegisterDate();
            $secretQuestion = $objUser->getSecretQuestion();
            $secretAnswer = $objUser->getSecretAnswer();

            //Query
            $querysql = "INSERT INTO user VALUES (:NAMES, :EMAIL, :PASSWORDS, :DNI, :CREDITCARD, :ADDRESSS, :POSTCODE, :PHONE, :REGISTERDATE, :SECRETQUESTION, :SECRETANSWER )";

            //Sanity param
            $param = array(':NAMES' => $name, ':EMAIL' => $email, ':PASSWORDS' => $password, ':DNI' => $dni, ':CREDITCARD' => $creditCard, ':ADDRESSS' => $address, ':POSTCODE' => $postcode, ':PHONE' => $phone, ':REGISTERDATE' => $registerDate, ':SECRETQUESTION' => $secretQuestion, ':SECRETANSWER' => $secretAnswer);

            //Execute Query
            $message = $this->objDB->SimpleQuery($querysql, $param);
            return $message;
        } /* Metodo que recibe un objeto usuario, obtiene los datos de sus atributos (los va guardando en varibles) y lo da de alta en la base de datos */

        public function getDataUser($emailUser){
            $consulta = "SELECT * FROM user WHERE email = :USUARIO"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':USUARIO' => $emailUser);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){ // solo va a devolver un usuario porque el email es único
                $arrayResultado = [
                    "name" => $fila['name'],
                    "email" => $fila['email'],
                    "dni" => $fila['dni'],
                    "creditCard" => $fila['creditCard'],
                    "address" => $fila['address'],
                    "phone" => $fila['phone'],
                    "postCode" => $fila['postCode']
                ];   
            }
            return $arrayResultado;
        } /* MEtodo para sacar los datos de un usuario en base a un email */

        public function getDataOrderDetails($emailUser){
            $consulta = "SELECT * FROM orderdetails WHERE email = :USUARIO"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':USUARIO' => $emailUser);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $arrayPedidos = [];
            $filasArray = $this->objDB->filas;
            foreach ($filasArray as $fila){
                $arrayPedido = [
                    "orderId" => $fila['orderId'],
                    "email" => $fila['email'],
                    "date" => $fila['date'],
                    "total" => $fila['total'],
                ];  
                array_push($arrayPedidos, $arrayPedido); 
            }
            return $arrayPedidos;
        } /* Saca todos los pedidos de un usuario en base a su email, tiene un array con los datos de un pedido (cada posicion es un atributo del pedido) que se va volcando en un array de pedidos (cada posicion es un pedido) */

        public function userLoggedIn(){
            $usuarioSesion = $_SESSION['user']['name'];
            if (!isset($usuarioSesion)){
                header ("Location: inicio.php"); // Si no está logeado le lleva al index.php
            } else {
                echo "<h5>Bienvenido ".$usuarioSesion.". Click para <a href='salir.php'>Salir</a><br><br></h5>";
                echo "<input type='hidden' id='usuario' value='".$_SESSION['user']['email']."'></input>";
                //Arriba inicio la sesion y muestro el nombre de usuario para dar feedback sobre con que usuario se conecta
            } 
        } /* Funcion para comprobar si estás logeado, muestra el nombre de usuario y un botón para salir y sino te lleva al index */

        public function userLoggedInRegister(){
            if (isset($_SESSION['user']['name'])){
                session_start();
                session_destroy();
                header ("Location: registro.php");
                exit();
            } // Si accedes al registro logeado, te expulsa, para que no te registres ya logeado por tema de cookies/sesiones e incompatibilidades
        }

        public function userLoggedInTicket($orderId){
            $usuarioSesion = $_SESSION['user']['name'];
            if (!isset($usuarioSesion)){
                header ("Location: inicio.php");
            } else {
                $daoOrder = new DaoOrder();
                $arrayOrderDetails = $daoOrder->getDataOrder($orderId);
                if ($_SESSION['user']['email'] == $arrayOrderDetails['email']){
                    echo "<h2>Ticket nº: ".$arrayOrderDetails['orderId'];
                    echo "<h2>Fecha del pedido: ".$arrayOrderDetails['date'];
                    echo "<h3>Cliente: ".$arrayOrderDetails['email'];
                    //Arriba inicio la sesion y muestro el nombre de usuario para dar feedback sobre con que usuario se conecta
                } else{
                    header ("Location: inicio.php");
                    exit();
                }
            } /* Similar a userLoggedIn pero sirve para que los usuarios no puedan ver ticket de otros usuarios, ya que comprueba la sesión frente al usuario que realizó el Pedido con Número X (por ejemplo orderId 5), esto lo hace con una consulta a la base de datos */
        }

        public function checkUser($user, $encryptPassword){
            $contador = 0; //Variable para controlar si devuelve algo la consulta
            $consulta = "SELECT * FROM user WHERE email = :USUARIO AND password =:CONTRASENIA"; //consulta con los parametros puestos para que no se produzca inyeccion
            $param = array(':USUARIO' => $user,':CONTRASENIA' => $encryptPassword);//parametros de la consulta
            $this->objDB->DataQuery($consulta,$param);//Se ejecuta la consulta
            $filasArray = $this->objDB->filas;//Guardo los resultados de la consulta
            foreach ($filasArray as $fila) {
                $contador++;//Si encuentra algun resultado suma el contador
            }
            if ($contador == 0){
                $usuarioABloquear;
                //Compruebo cuantas veces hay que fallado el usuario para saber si bloquearlo o no EN LOS ULTIMOS 5 MINS (VARIABLE TIEMPOPREVIO)
                $contadorLoginFallidos=0;
                $tiempoPrevio=time() - 5 * 60;//5 min previo a la actual porque lo que se mira es si hay 3 fallos consecutivos en menos de una 5 minmin
                $accesoFallido = 'D';
                $consultaVecesFallidas = "SELECT * FROM login WHERE email = :USUARIO AND time >= :HORA AND access = :ACCESO ORDER BY time ASC LIMIT 3";
                $paramVecesFallidas = array(':USUARIO' => $user,':HORA' => $tiempoPrevio, ':ACCESO' => $accesoFallido);
                $this->objDB->DataQuery($consultaVecesFallidas, $paramVecesFallidas);//Se ejecuta la consulta
                $filasArrayFallidos = $this->objDB->filas;//Guardo los resultados de la consulta
                foreach ($filasArrayFallidos as $accfal) {
                    $contadorLoginFallidos++;
                }
    
    
                //Compruebo cuantas veces hay que fallado el usuario para saber si bloquearlo o no EN LOS ULTIMOS 15 MINS (VARIABLE TIEMPOPREVIOQUINCE)
                $contadorLoginFallidosQuince = 0;
                $tiempoPrevioQuince=time() - 15 * 60;//15mins prevos a la actual porque lo que se mira es si hay 4 fallos consecutivos en menos de 15 minmin
                $consultaVecesFallidasQuince = "SELECT * FROM login WHERE email = :USUARIO AND time >= :HORAQUINCE AND access = :ACCESO ORDER BY time ASC LIMIT 4";
                $paramVecesFallidasQuince = array(':USUARIO' => $user,':HORAQUINCE' => $tiempoPrevioQuince, ':ACCESO' => $accesoFallido);
                $this->objDB->DataQuery($consultaVecesFallidasQuince, $paramVecesFallidasQuince);//Se ejecuta la consulta
                $filasArrayFallidosQuince = $this->objDB->filas;//Guardo los resultados de la consulta
                foreach ($filasArrayFallidosQuince as $accfalQuince) {
                    $contadorLoginFallidosQuince++;
                }
    
                if ($contadorLoginFallidos==3){
                    $usuarioABloquear = $filasArrayFallidos[1]['email'];
                    $horaBloqueo = date("D M j H:i:s", $filasArrayFallidos[1]['time'] + 60 * 60);
                    $intento1 = date("D M j H:i:s", $filasArrayFallidos[2]['time']);
                    $intento2 = date("D M j H:i:s", $filasArrayFallidos[1]['time']);
                    $intento3 = date("D M j H:i:s", $filasArrayFallidos[0]['time']);
                    return $mensaje = 'Usuario con nombre: '.$usuarioABloquear.' Incorrecto, 3 fallos en menos de una 5 minutos. El usuario queda bloqueado hasta las '.$horaBloqueo.'<br>Sus intentos de sesion fueron a las:<br>-'.$intento1.'<br>-'.$intento2.'<br>-'.$intento3;
                }   
               
                if ($contadorLoginFallidosQuince==4){
                    $usuarioABloquearQuince = $filasArrayFallidosQuince[1]['email'];
                    $horaBloqueoQuince = date("D M j H:i:s", $filasArrayFallidosQuince[1]['time'] + 60 * 60);
                    $intento0Quince = date("D M j H:i:s", $filasArrayFallidosQuince[3]['time']);
                    $intento1Quince = date("D M j H:i:s", $filasArrayFallidosQuince[2]['time']);
                    $intento2Quince = date("D M j H:i:s", $filasArrayFallidosQuince[1]['time']);
                    $intento3Quince = date("D M j H:i:s", $filasArrayFallidosQuince[0]['time']);
                    return $mensaje = 'Usuario con nombre: '.$usuarioABloquearQuince.' Incorrecto, 4 fallos en menos de 15 minutos. El usuario queda bloqueado hasta las '.$horaBloqueoQuince.'<br>Sus intentos de sesion fueron a las:<br>- '.$intento0Quince.'<br>-'.$intento1Quince.'<br>-'.$intento2Quince.'<br>-'.$intento3Quince;
                }   
                    
                else {
                    $acceso='D';
                    $hora=time();
                    $consultaInsertar = "INSERT INTO login (email, password, time, access) VALUES (:USUARIO, :CLAVE, :HORA, :ACCESO)";
                    $paramInsertar = array(':USUARIO' => $user,':CLAVE' => $encryptPassword,':HORA' => $hora, ':ACCESO' => $acceso);
                    $this->objDB->SimpleQuery($consultaInsertar,$paramInsertar);
                    return $mensaje = 'Usuario Incorrecto';
                }
    
            } else {
                //si existe
                $_SESSION['user'] = $this->getDataUser($user);
                $_SESSION['orderDetails'] = $this->getDataOrderDetails($user);
                header('Location: interfazPersonal.php');
            }
        }
    }
?>