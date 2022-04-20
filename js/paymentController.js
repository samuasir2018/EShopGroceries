function payOrder(){
    let usuario = document.getElementById('usuario').value;
    let coupon = document.getElementById('inputCupon').value;

    $.ajax({
        url: '../php/payment.php',
        type: 'POST',
        data: { email: usuario, couponId: coupon}
        }).done(function(res) {
            console.log(res);
            if (res == -1){
                window.alert("Has alcanzado el número máximo de pedidos para el día. Intentelo de nuevo mañana");
                
                location.reload();
            } 
            else if (res == -2){
                window.alert("El carrito está vacio. Seleccione algún producto e intentelo de nuevo");
            }
            else {
                window.alert("Pedido creado correctamente. Pulse aceptar para continuar");
                location.reload();
            }
        })
        .fail(function(){
            console.log("fallo en el sistema");
        });  
} /*Funcion para pagar, recibe el usuario y el cupon por parametro y los envia mediante ajax, puede tener 3 respuestas, -1 con el numero máximo de pedidos para el día alcazandos (es un pedido al día), -2 con el carrito vacio o 1 para el pago realizado correctamente*/

$('select').on('change', function() {
    let precioTotal = document.getElementById('precioTotal').value;
    var label = document.getElementById('totalDescuento');
    var coupon = this.value;
    $.ajax({
        url: '../php/getDiscount.php',
        type: 'POST',
        data: {couponId: coupon}
        }).done(function(res) {
            let descuento = res;
            if (descuento != 0)
            {
            label.style.display = 'block';
            label.innerHTML = "";
            label.innerHTML += "Precio Total con descuento: " + (precioTotal - (precioTotal*descuento/100)).toFixed(2) +"€";
            } else {
                label.style.display = 'block';
                label.innerHTML = "";
                label.innerHTML += "Precio Total con descuento: " + (precioTotal) +"€";
            }
            
        })
        .fail(function(){
            console.log("fallo en el sistema");
        }); 
}); /*Esta funcion se ejecuta cuando hay un cambio en el select de los descuentos, recibe el precio total y el total descuento, y con ajax manda el cupon elegido, de esta manera se muestra un nuevo elemento en el html con el nuevo precio aplicandole el descuento*/