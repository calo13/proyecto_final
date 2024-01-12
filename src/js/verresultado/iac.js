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
            render : () => contador ++       
        },
                {
            title : 'Tipo',
            data: 'tipo_pregunta'
        },        
                {
            title : 'Puntuacion',
            data: 'puntuacion_por_tipo',

        },        
                {
            title : 'Percentiles',
            data: 'percentiles',

        },        
                {
            title : 'Sinceridad',
            data: 'puntuacion_bare_s',

        },        
    ]
})


const urlParams = new URLSearchParams(window.location.search);
const nuevoCandidatoID = urlParams.get('nuevoCandidatoID');

console.log('ID del nuevo candidato:', nuevoCandidatoID);

const buscar = async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const nuevoCandidatoID = urlParams.get('nuevoCandidatoID');
    
    const url = `/proyecto_final/API/verresultado/buscar/iac?nuevoCandidatoID=${nuevoCandidatoID}`;
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