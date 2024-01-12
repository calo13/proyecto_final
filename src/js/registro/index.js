import { validarFormulario, Toast } from "../funciones";
import Swal from "sweetalert2";

const show_password = document.getElementById('show_password');
const formRegistro = document.getElementById('formRegistro');

function ver_password() {
    const passwordInput = document.getElementById("usu_password");
    const showPasswordCheckbox = document.getElementById("show_password");

    if (showPasswordCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}


const guardar = async (e) => {
    e.preventDefault();

    const body = new FormData(formRegistro)
    body.delete('usu_id')
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
                    title: 'Registro Enviado',
                    text: 'Pendiente a ser Aprobado',
                    icon: 'info',
                    showCancelButton: false,
                    confirmCancelButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                window.location.href = '/proyecto_final/';
                break;

            case 2:
                Toast.fire({
                    title: 'Usuario ya Existente',
                    text: 'Ingrese otro usuario',
                    icon: 'info',
                    showCancelButton: false,
                    confirmCancelButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                break;

            case 3:
                Toast.fire({
                    title: 'Catalogo  ya Existente',
                    text: 'Ingrese otro catalogo',
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


formRegistro.addEventListener('submit', guardar)
show_password.addEventListener('click', ver_password);
