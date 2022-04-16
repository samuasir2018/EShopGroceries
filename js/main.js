const element = document.querySelector('form')
let listenerSubmit;
var expresiones = {
    /*userName*/ uN: /^[a-zA-Z ]{1,100}$/, //cualquier letra y espacios en blanco de 1 a 100 caracteres
    /*email Address*/ eA: /^[^\s@]+@[^\s@]+\.[^\s@]{1,50}$/, // cualquier caracter @ cualquier caracter de 1 a 50 caracteres
    /*password*/ pW: /^[\S]{1,20}$/, //Cualquier cosa menos espacio en blanco de 1 a 20 caracteres
    /*dni*/ dI: /^[\d]{8}[a-zA-Z]{1}$/, // 8 numeros (rellenar con 0 si es necesario) y una letra
    /*creditCard*/ cC: /^[\d]{16}$/, // 16 numeros
    /*Address*/ aD: /^[\S ]{1,50}$/, //Cualquier cosa de 1 a 50 caracteres
    /*PostCode*/ pD: /^[\d]{5}$/,
    /*phone*/ pH: /^[\d]{9}$/
}

function showerror(error){
    var div = document.getElementById('errorDiv');
    div.style.display = 'block';
    div.innerHTML = "";
    div.innerHTML += error;
} /*Funcion para añadir un div con mensaje de error, este mensaje depende de lo que le pasemos por parametro*/

function validarDatos(){
    //Capturas los datos del formulario
    let nombre = $('#inputNombre').val().trim();
    let email = $('#inputEmail').val().trim();
    let contrasenna = $('#inputContrasenna').val().trim();
    let dni = $('#inputDni').val().trim();
    let tarjeta = $('#inputTarjeta').val().trim();
    let cp = $('#inputCP').val().trim();
    let direccion = $('#inputDireccion').val().trim();
    let telefono = $('#inputTelefono').val().trim();
    
    if (!expresiones.uN.test(nombre))
    {
        showerror('error en el campo nombre, debes introducir solo letras y espacios en blanco, hasta 100 caracteres. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.eA.test(email))
    {
        showerror('error en el campo Email, debes introducir un email valido formato: X@X.X  de hasta 50 caracteres. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.pW.test(contrasenna))
    {
        showerror('error en el campo contraseña, debes introducir una contraseña de hasta 20 caracteres sin espacios en blanco. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.dI.test(dni))
    {
        showerror('error en el campo DNI, debes introducir un DNI de 8 numeros y 1 letra rellena con 0 a la izquierda si es necesario. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.cC.test(tarjeta))
    {
        showerror('error en el campo tarjeta, debes introducir una tarjeta de 16 digitos sin espacios en blanco ni guiones. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.pD.test(cp))
    {
        showerror('error en el campo codigo postal, debes introducir un codigo postal de 5 digitos rellena con 0 a la izquierda si es necesario. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.aD.test(direccion))
    {
        showerror('error en el campo dirección, puedes introducir cualquier caracter y espacios en blanco hasta 50 caracteres. Se deshabilitará el botón de registro');
        return false;
    }
    if (!expresiones.pH.test(telefono))
    {
        showerror('error en el campo teléfono, Solo se admiten 9 números. Se deshabilitará el botón de registro');
        return false;
    }

    var div = document.getElementById('errorDiv');
    div.style.display = 'none';
    return true;
} /* Funcion que devuelve true o false dependiendo de los datos capturados en el formulario y evaluandolo con los patrones regex correspondiente a cada uno, si la evaluación es negativa también llama a la función showerror */



(function ($) {
    $('#inputNombre').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputNombre').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputEmail').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputEmail').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputContrasenna').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputContrasenna').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    
    $('#inputDni').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputDni').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputTarjeta').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputTarjeta').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputCP').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputCP').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputDireccion').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputDireccion').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });

    $('#inputTelefono').focusout(function (e)
    {
        if (!validarDatos()){
            $('#inputTelefono').unbind('focus');
            document.getElementById("enviarRegistro").disabled = true;
        } else{
            document.getElementById("enviarRegistro").disabled = false;
        }
    });
})(jQuery); /* Cada vez que se da click fuera de un campo, se evalua la funcion validar datos, si devuelve false nos muestra el error */