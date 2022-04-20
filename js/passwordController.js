function passRecovery(){
    
    let usuario = document.getElementById('inputEmail').value;
    let preguntaSecreta = document.getElementById('inputPreguntaSecreta').value;
    let respuestaSecreta = document.getElementById('inputRespuestaaSecreta').value;
    let nuevaContrasena = document.getElementById('inputNuevaContrasena').value;

    $.ajax({
        url: '../php/passwordRecovery.php',
        type: 'POST',
        data: { email: usuario, pregunta: preguntaSecreta, respuesta: respuestaSecreta, contrasena: nuevaContrasena }
        }).done(function(res) {
            window.alert(res);
            location.reload();
        })
        .fail(function(){
            window.alert("fallo en el sistema");
        });
    
} /*Funcion para añadir productos a la basket, recibo la cantidad y el usuario y envio con ajax el id del producto, la cantidad y el email*/

