import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form');
const urlParams = new URLSearchParams(window.location.search);
const nuevoCandidatoID = urlParams.get("nuevoCandidatoID");
const testID = urlParams.get("testID");

document.getElementById("res_cand_id").value = nuevoCandidatoID;
document.getElementById("res_test_id").value = testID;

const btnSi = document.getElementById("btnSi");
const btnNo = document.getElementById("btnNo");

// Variables
let seleccion = null;
let contenedor;
let preguntasEPQA;
let preguntaText = document.getElementById("preguntaText");
const btnGuardar = document.getElementById("btnGuardar");
let tiempoRestante = 3600;
let intervaloCronometro;






function iniciarCronometro() {
    intervaloCronometro = setInterval(actualizarCronometro, 1000);
}

function detenerCronometro() {
    clearInterval(intervaloCronometro);
}

function actualizarCronometro() {
    tiempoRestante--;

    if (tiempoRestante <= 0) {
        detenerCronometro();
        console.log("Tiempo agotado");
    } else {
        const tiempoFormateado = formatearTiempo(tiempoRestante);

        document.getElementById('tiempo-restante').textContent = tiempoFormateado;
    }
}


function formatearTiempo(segundos) {
    const minutos = Math.floor(segundos / 60);
    const segundosRestantes = segundos % 60;
    return `${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
}


btnSi.addEventListener('click', (event) => {
    event.preventDefault();
    seleccion = 1;
    btnSi.classList.add('selected');
    btnNo.classList.remove('selected1');
    habilitarBotonGuardar(); 
});

btnNo.addEventListener('click', (event) => {
    event.preventDefault();
    seleccion = 2;
    btnNo.classList.add('selected1');
    btnSi.classList.remove('selected');
    habilitarBotonGuardar();
});

function habilitarBotonGuardar() {
    if (seleccion !== null) {
        btnGuardar.disabled = false; 
    }
}


const resPreguntaIdInput = document.getElementById("res_pregunta_id");

let contador = 1;

const datatable = new Datatable('#tablaRespuesta', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'can_id',
            data: 'res_cand_id'
        },
        {
            title: 'test_id',
            data: 'res_test_id'
        },
        {
            title: 'pregunta_id',
            data: 'res_pregunta_id'
        },
        {
            title: 'respuesta',
            data: 'res_respuesta'
        },
    ]
});





const buscarEPQA = async () => {
    const url = `/proyecto_final/API/respuesta/buscar/epqa`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        if (data && data.length > 0) {
            preguntasEPQA = data;
            preguntaText.textContent = preguntasEPQA[0].pregunta_pregunta;
            resPreguntaIdInput.value = preguntasEPQA[0].pregunta_id;
            contenedor = 0;
            btnGuardar.disabled = false;

    const totalPreguntas = preguntasEPQA.length;
    const preguntasRespondidas = contenedor + 1;
    const porcentajeCompletado = (preguntasRespondidas / totalPreguntas) * 100;

    actualizarBarraProgreso(porcentajeCompletado, preguntasRespondidas, totalPreguntas);

    document.getElementById('numero-pregunta').textContent = `${preguntasRespondidas}/${totalPreguntas}`;
        } else {
            preguntaText.textContent = 'No hay preguntas disponibles';
            btnGuardar.disabled = true;
        }
    } catch (error) {
        console.log(error);
    }
    iniciarCronometro();
};

function actualizarBarraProgreso(porcentaje, preguntaActual, totalPreguntas) {
    const barraProgresoVerde = document.getElementById('barra-progreso-verde');
    const numeroPregunta = document.getElementById('numero-pregunta');

    barraProgresoVerde.style.width = `${porcentaje}%`;

    numeroPregunta.textContent = `${preguntaActual}/${totalPreguntas}`;
}


const buscarRES = async () => {
    const url = `/proyecto_final/API/respuesta/buscar/res`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if (data) {
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            })
        }
    } catch (error) {
        console.log(error);
    }
}


const mostrarModalFelicidades = async () => {
    detenerCronometro();

    await actualizarTiempoCandidato(nuevoCandidatoID, tiempoRestante);

    Swal.fire({
        title: '¡Felicidades!',
        text: 'Has terminado tu TEST.',
        icon: 'success',
        confirmButtonText: 'Salir',
        allowOutsideClick: false, 
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/proyecto_final/inicio'; 
        }
    });
};


const actualizarTiempoCandidato = async (cand_id, tiempo) => {
    try {
        const body = JSON.stringify({ cand_id, tiempo });
        const headers = { 'Content-Type': 'application/json' };
        const response = await fetch('/proyecto_final/API/respuesta/actualizarTiempo', {
            method: 'POST',
            body: body,
            headers: headers
        });
        const data = await response.json();
        console.log(data);
    } catch (error) {
        console.error('Error al actualizar el tiempo:', error);
    }
};



const guardar = async (evento) => {
    evento.preventDefault();

    if (btnGuardar.disabled) {
        return; // Evita clics múltiples
    }

    if (!validarFormulario(formulario, ["res_id"])) {
        Toast.fire({
            icon: "info",
            text: "Debe llenar todos los datos",
        });
        return;
    }

    if (seleccion === null) {
        Toast.fire({
            icon: "info",
            text: "Debe seleccionar una opción (SI o NO)",
        });
        return;
    }

    btnGuardar.disabled = true; // Deshabilita el botón "Guardar" temporalmente

    const body = new FormData(formulario);
    body.delete("res_id");
    body.set("res_respuesta", seleccion);

    const url = "/proyecto_final/API/respuesta/guardar";
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method: "POST",
        body,
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = "info";
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = "success";
                buscarRES();
                if (contenedor < preguntasEPQA.length - 1) {
                    contenedor++;
                    preguntaText.textContent = preguntasEPQA[contenedor].pregunta_pregunta;
                    resPreguntaIdInput.value = preguntasEPQA[contenedor].pregunta_id;
                } else {
                    // Mostrar el modal de felicitaciones
                    mostrarModalFelicidades();
                    return; // Detener la ejecución para evitar duplicados
                }
                seleccion = null;
                btnSi.classList.remove('selected');
                btnNo.classList.remove('selected');
                habilitarBotonGuardar(); // Llama a la función para habilitar el botón "Guardar"

                // Configurar la barra de progreso
                const totalPreguntas = preguntasEPQA.length;
                const preguntasRespondidas = contenedor + 1;
                const porcentajeCompletado = (preguntasRespondidas / totalPreguntas) * 100;

                // Actualizar la barra de progreso
                actualizarBarraProgreso(porcentajeCompletado, preguntasRespondidas, totalPreguntas);

                // Mostrar el número de pregunta actual
                document.getElementById('numero-pregunta').textContent = `${preguntasRespondidas}/${totalPreguntas}`;
                break;

            case 0:
                icon = "error";
                console.log(detalle);
                break;

            default:
                break;
        }
        Toast.fire({
            icon,
            text: mensaje,
        });
    } catch (error) {
        console.log(error);
    }
};




buscarRES();
buscarEPQA();
formulario.addEventListener('submit', guardar);
