function addBasket(idProducto){
    let cantidad = document.getElementById('cantidadInput'+idProducto).value;
    let usuario = document.getElementById('usuario').value;

    if (cantidad > 0 && cantidad < 99){
        $.ajax({
            url: '../php/insertBasket.php',
            type: 'POST',
            data: { email: usuario, idProducto: idProducto, cantidad: cantidad }
            }).done(function(res) {
                console.log(res);
                location.reload();
            })
            .fail(function(){
                console.log("fallo en el sistema");
            }); 
    } else if (cantidad <= 0){
        window.alert("La cantidad seleccionada no puede ser inferior a 1");
        location.reload();
    } else {
        window.alert("La cantidad seleccionada no puede ser superior a 99");
        location.reload();
    }
    
} /*Funcion para añadir productos a la basket, recibo la cantidad y el usuario y envio con ajax el id del producto, la cantidad y el email*/


function delBasket(idProducto){
    let usuario = document.getElementById('usuario').value;

    $.ajax({
        url: '../php/deleteBasket.php',
        type: 'POST',
        data: { email: usuario, idProducto: idProducto}
        }).done(function(res) {
            console.log(res);
            location.reload();
        })
        .fail(function(){
            console.log("fallo en el sistema");
        }); 
} /*Funcion para borrar productos de la basket, recibo el usuario y envio el usuario y el id del producto con ajax*/

/*
$( document ).ready(function() {
    $(document).on("click",".buttonAdd",function(){//buscar event listener, bindear elemento con clase button al evento click
        let cantidad = $(this).parent().find("input");//convertirlo a obj jquery
        if (cantidad.value === undefined){
            window.alert("La cantidad no puede ser 0");
        }
    });
}); Antigua forma de controlar el evento del click, NO LA USO*/ 
