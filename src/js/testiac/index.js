import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje"
import Swal from "sweetalert2";


const formulario = document.querySelector('form');
const btnCancelar = document.getElementById('btnCancelar');


formulario.style.display = 'none';

let contenedor = 1;

const datatable = new Datatable('#tablaIac', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contenedor++,
            width: '5%',
            className: 'text-center'
        },
        {
            title: 'Pregunta',
            data: 'pregunta_pregunta',
        },
        {
            title: 'Tipo',
            data: 'pregunta_tipo',
            className: 'text-center',
            width: '5%',
        },
        {
            title: 'Respuesta',
            data: 'pregunta_respuesta',
            className: 'text-center',
            width: '8%',
        
            render: function (data, type, row, meta) {
                if (data === "1") {
                    return 'Sí';
                } else if (data === "2") {
                    return 'No';
                } else {
                    return '?'; 
                }
            }
        }, 
    ]
});


const buscarIAC = async () => {
    const url = `/proyecto_final/API/test/buscar/iac`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        datatable.clear().draw();
        if (data) {
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const ocultarFormulario = () => {
    formulario.reset();
    formulario.style.display = 'none';
    tablaIacContainer.style.display = 'block';
};


const traeDatos = (e) => {
    const button = e.target;
    const pregunta = button.dataset.pregunta;
    const tipo = button.dataset.tipo;
    const respuesta = button.dataset.respuesta;

    formulario.pregunta_pregunta.value = pregunta;
    formulario.pregunta_tipo.value = tipo;
    formulario.pregunta_respuesta.value = respuesta;
}

btnCancelar.addEventListener('click', ocultarFormulario);
datatable.on('click','.btn-warning', traeDatos)
buscarIAC();
