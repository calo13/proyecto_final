import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import $ from 'jquery';


let contador = 1;
const datatable = new Datatable('#tablaCandidato', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            data: 'pregunta_id'       
        },
                {
            title : 'Pregunta',
            data: 'pregunta_pregunta'
        },        
                {
            title : 'Respuesta',
            data: 'res_respuesta',
            render: function (data) {
                const estados = {
                    1: "SI",
                    2: "NO",
                };
                return estados[data] || "NO RESPONDIO";
            }
        },    
        {
            title : 'Precisión',
            data: 'resultado'
        },           
    ]
})


const urlParams = new URLSearchParams(window.location.search);
const nuevoCandidatoID = urlParams.get('nuevoCandidatoID');

console.log('ID del nuevo candidato:', nuevoCandidatoID);

const buscar = async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const nuevoCandidatoID = urlParams.get('nuevoCandidatoID');
    
    const url = `/proyecto_final/API/verrespuesta/buscar/epqa?nuevoCandidatoID=${nuevoCandidatoID}`;
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

buscar();