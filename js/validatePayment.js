/*JS practicamente idento a main.js sirve para controlar que los datos introducidos son validos, en este caso en la ventana de pagos*/

var dateMax = new Date(); 
dateMax.setFullYear(dateMax.getFullYear() + 15)
inputFecha.min = new Date().toISOString().split("T")[0];
inputFecha.max = dateMax.toISOString().split("T")[0];
/*Crear una fecha minima (hoy) y una máxima dentro de 15 años , para validar que las tarjetas no están caducadas*/


var expresiones = {
    /*userName*/ uN: /^[a-zA-Z ]{1,100}$/, //cualquier letra y espacios en blanco de 1 a 100 caracteres
    /*creditCard*/ cC: /^[\d]{16}$/, // 16 numeros
    /*SecurityCode*/ sC: /^[\d]{3}$/, // 3 numeros
    /*Address*/ aD: /^[\S ]{1,50}$/, //Cualquier cosa de 1 a 50 caracteres
    /*PostCode*/ pD: /^[\d]{5}$/ // 5 numeros
}

function showerror(error){
    var div = document.getElementById('errorDiv');
    div.style.display = 'block';
    div.innerHTML = "";
    div.innerHTML += error;
}



function validarDatos(){
    //Capturas los datos del formulario
    let nombre = $('#inputNombreTarjeta').val().trim();
    let tarjeta = $('#inputNumTarjeta').val().trim();
    let cvc = $('#inputCVC').val().trim();
    let cp = $('#inputCP').val().trim();
    let direccion = $('#inputDireccion').val().trim();
    let fecha = $('#inputFecha').val();
    
    if (!expresiones.uN.test(nombre))
    {
        showerror('error en el campo nombre, debes introducir solo letras y espacios en blanco, hasta 100 caracteres. Se deshabilitará el botón de pagar');
        return false;
    }
    if (!expresiones.sC.test(cvc))
    {
        showerror('error en el campo Código de Seguridad, debes introducir un CVC de 3 numeros. Se deshabilitará el botón de pagar');
        return false;
    }
    if (!expresiones.cC.test(tarjeta))
    {
        showerror('error en el campo tarjeta, debes introducir una tarjeta de 16 digitos sin espacios en blanco ni guiones. Se deshabilitará el botón de pagar');
        return false;
    }
    if (!expresiones.pD.test(cp))
    {
        showerror('error en el campo codigo postal, debes introducir un codigo postal de 5 digitos rellena con 0 a la izquierda si es necesario. Se deshabilitará el botón de pagar');
        return false;
    }
    if (!expresiones.aD.test(direccion))
    {
        showerror('error en el campo dirección, Máximo 50 caracteres. Se deshabilitará el botón de pagar');
        return false;
    }
    if (fecha > inputFecha.max || fecha < inputFecha.min)
    {
        showerror('Fecha no valida. Se deshabilitará el botón de pagar');
        return false;
    }

    var div = document.getElementById('errorDiv');
    div.style.display = 'none';
    return true;
}



(function ($) {
    $('#inputNombreTarjeta').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputNombreTarjeta').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else{
            document.getElementById("payButton").disabled = false;
        }
    });

    $('#inputNumTarjeta').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputNumTarjeta').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else{
            document.getElementById("payButton").disabled = false;
        }
    });

    
    $('#inputCVC').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputCVC').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else{
            document.getElementById("payButton").disabled = false;
        }
    });

    $('#inputCP').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputCP').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else{
            document.getElementById("payButton").disabled = false;
        }
    });

    $('#inputDireccion').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputDireccion').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else{
            document.getElementById("payButton").disabled = false;
        }
    });

    $('#inputFecha').click(function (e)
    {
        if (!validarDatos()){
            $('#inputFecha').unbind('focus');
            document.getElementById("payButton").disabled = true;
        } else {
            document.getElementById("payButton").disabled = false;
        }
    });


})(jQuery);