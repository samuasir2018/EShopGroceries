<?php

require_once('daoBasket.php');

class Basket{
    private $product;
    
    public function __construct()
    {
        $this->product = [];
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    public function updateBasket($email){
        $objDaoBasket = new daoBasket();
        $this->product = $objDaoBasket->getBasketData($email);
    } /*Metodo para actualizar la basket, obtiene el contenido desde el objDaoBasket llamando a su metodo getBasketData pasandole el email del usuario por atributo (la explicación de que hace este metodo se hará en daoBasket), y actualiza el atributo product de basket*/

    public function printBasket(){
        $objDaoProduct = new daoProduct(); //llamo al daoProduct para poder sacar los datos de cada producto
        $totalPrice = 0; //hago set del precio en 0
        foreach ($this->product as $product){// por cada uno de los productos (atributo de basket)
            $fullProduct = $objDaoProduct->listProductById($product["productId"]); //guardo en fullproduct un obj producto completo con nombre, id cantidad, precio e icono, para ahora ir imprimiendolos abajo
            echo '
                <div class="row">
                    <div class="col-8">
                        <b>Nombre: '.$fullProduct["product"].'</b>
                        <br>
                        <b>Precio/Unidad: '.$fullProduct["price"].'</b>
                        <br>
                        <b>Cantidad: '.$product["amount"].'</b>
                        <br><br>
                        <img src="'.$fullProduct["icon"].'" class="iconBasket"></img>
                    </div>
                    <div class="col-4">
                        <br><br><br><br>
                        <img src="./img/icons/remove.png" class="iconRemove" onclick="delBasket('.$product["productId"].', )"></img>
                    </div>
                </div>
                <hr class="hrBasket"></hr>
            ';
            $totalPrice += $fullProduct["price"]*$product["amount"]; // voy sumando el precio por la cantidad al total
        }
        echo '
            <div>
                <label><h4><b>Precio total: '.$totalPrice.'€</b></h4></label>
                <input type="hidden" id="precioTotal" value="'.$totalPrice.'"></input>
            </div>
        ';
    }/* MEtodo para imprimir el carrito */
}