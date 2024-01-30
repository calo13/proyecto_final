import { validarFormulario, Toast } from "../funciones";
import Swal from "sweetalert2";

const show_password = document.getElementById('show_password');
const formRegistro = document.getElementById('formRegistro');
const reg = document.getElementById('registrar');
const cuiInput = document.getElementById('usu_dpi');
const contraseña = document.getElementById('usu_password');
const contraseñacopia = document.getElementById('usu_password2');

function validarContraseña() {
    const contraseñaValor = contraseña.value;
    const contraseñacopiaValor = contraseñacopia.value;

    if (contraseñaValor !== contraseñacopiaValor) {
        Toast.fire({
            icon: 'error',
            title: 'Las contraseñas no coinciden'
        });
        return false;
    }

    const regexMayuscula = /[A-Z]/;
    const regexMinuscula = /[a-z]/;
    const regexNumero = /[0-9]/;

    if (
        contraseñaValor.length >= 6 &&
        regexMayuscula.test(contraseñaValor) &&
        regexMinuscula.test(contraseñaValor) &&
        regexNumero.test(contraseñaValor)
    ) {
        console.log('TAL')
        return true;
    } else {
        console.log('VEZ<')
        Toast.fire({
            icon: 'error',
            title: 'La contraseña debe contener al menos 1 mayúscula, 1 minúscula, 1 número y tener más de 6 caracteres.'
        });
        return false;
    }
}

formRegistro.addEventListener('submit', function (event) {
    if (!validarContraseña()) {
        event.preventDefault();
    }
});






function ver_password() {
    const passwordInput = document.getElementById("usu_password");
    const showPasswordCheckbox = document.getElementById("show_password");

    if (showPasswordCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

function iniciar_app() {

     reg.setAttribute('disabled', 'true');
}




const guardar = async (e) => {
    e.preventDefault();
    console.log('entra')
    const body = new FormData(formRegistro)
    body.delete('usu_id')
    body.delete('usu_password2')
    const url = '/proyecto_final/API/registro/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        const { codigo, mensaje, detalle } = data;

        switch (codigo) {
            case 1:
                Toast.fire({
                    title: 'Registro exitoso',
                    text:  mensaje,
                    icon: 'info',
                    showCancelButton: false,
                    confirmCancelButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                window.location.href = '/proyecto_final/';
                break;
        
            case 2:
                Toast.fire({
                    title: 'alerta',
                    text: mensaje,
                    icon: 'info',
                    showCancelButton: false,
                    confirmCancelButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                break;
        
            case 3:
                Toast.fire({
                    title: 'alerta',
                    text: mensaje,
                    icon: 'info',
                    showCancelButton: false,
                    confirmCancelButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                break;
        }

    } catch (error) {
        console.log(error);
    }
};

function cuiIsValid(cui) {
    if (!cui) {
        return false;
    }

    var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

    if (!cuiRegExp.test(cui)) {
        return false;
    }

    cui = cui.replace(/\s/g, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));

    var munisPorDepto = [
        17, 8, 16, 16, 13, 14, 19, 8, 24, 21, 9, 30, 32, 21, 8, 17, 14, 5, 11, 11, 7, 17
    ];

    if (depto === 0 || muni === 0 || depto > munisPorDepto.length || muni > munisPorDepto[depto - 1]) {
        return false;
    }

    var total = 0;
    for (var i = 0; i < numero.length; i++) {
        total += numero[i] * (i + 2);
    }

    var modulo = (total % 11);

    return modulo === verificador;
}


cuiInput.addEventListener('change', function (e) {
    var inputValue = this.value;

    // Limpiar el valor eliminando caracteres no permitidos
    var cleanedValue = inputValue.replace(/[^0-9\s]/g, '');

    // Actualizar el valor del input con el valor limpio
    this.value = cleanedValue;

    if (cuiIsValid(cleanedValue)) {
        // Mostrar toast indicando que el CUI es válido
        Toast.fire({
            icon: 'success',
            title: 'CUI válido'
        });
        reg.removeAttribute('disabled');

    } else {
        // Mostrar toast indicando que el CUI no es válido
        Toast.fire({
            icon: 'error',
            title: 'CUI no válido'
        });
        this.value = '';
    }
});
iniciar_app()
formRegistro.addEventListener('submit', guardar)
show_password.addEventListener('click', ver_password);
