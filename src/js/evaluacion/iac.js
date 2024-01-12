import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { event } from "jquery";
const btnGuardarConclusion = document.getElementById('guardarConclusiónBtn')
const iframe = document.getElementById('vista');

let contador = 1;
const datatable = new Datatable('#tablaCandidato', {
    language : lenguaje,
    data : null,
    columns: [
        {
            className: 'text-center',
            width: '50px',
            title : 'NO',
            render : () => contador ++       
        },
        {
            title: 'NOMBRE',
            data: null,
            render: function (data, type, row, meta) {
                return row.cand_primer_nombre + ' ' + row.cand_segundo_nombre + ' ' + row.cand_primer_apellido + ' ' + row.cand_segundo_apellido;
            }
        },

        {
            className: 'text-center',
            width: '50px',
            title: 'EDAD',
            data: 'edad',
            render: function (data) {
                if (!isNaN(parseFloat(data))) {
                    return Math.round(parseFloat(data));
                } else {
                    return '';
                }
            }
        },
        {   
            className: 'text-center',
            width: '50px',
            title: 'NO. PREGUNTA',
            data: null, 
            render: function(data, type, row) {
                return row.respondidas + '/' + row.total;
            }
        },
        {
            className: 'text-center',
            width: '50px',
            title: 'FECHA DE EVALUACIÓN',
            data: 'cand_fecha_evaluacion',
            render: function (data, type, row, meta) {
                if (type === 'display' || type === 'filter') {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-ES');
                }
                return data;
            }
        },
            {
                className: 'text-center',
                width: '50px',
                title: 'RESPUESTA',
                data: 'cand_id',
                searchable: false,
                orderable: false,
                render: (data, type, row, meta) => `<button class="btn btn-info" data-toggle="modal" data-target="#miModal" data-ruta='/proyecto_final/verrespuesta/iac?nuevoCandidatoID=${data}'>VER</button>`
            },            
            {
                className: 'text-center',
                width: '50px',
                title: 'RESULTADO',
                data: 'cand_id',
                searchable: false,
                orderable: false,
                render: (data, type, row, meta) => `<button class="btn btn-primary" data-toggle="modal" data-target="#miModal" data-ruta='/proyecto_final/verresultado/iac?nuevoCandidatoID=${data}'>VER</button>`
            },
            {
                className: 'text-center',
                width: '140px',
                title: 'CONCLUSIÓN',
                data: 'cand_conclusion',
                searchable : false,
                orderable : false,
                render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-conclusion='${row["cand_conclusion"]}' data-cand_id='${row["cand_id"]}'>${data}</button>`
            },
        
    ]
})


datatable.on('click', '.btn-warning', function (e) {
    const boton = e.target;
    const cand_id = boton.dataset.cand_id;
    
    const modal = document.getElementById('conclusionModal');
    const modalButton = modal.querySelector('#guardarConclusiónBtn');
    
    modalButton.dataset.cand_id = cand_id;
  
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
  });

const guardarConclusión = async (e)=> {
    const cand_id = e.target.dataset.cand_id;
    const conclusionSelect = document.getElementById('conclusionSelect');
    const cand_conclusion = conclusionSelect.value;

    console.log(cand_id)
    console.log(cand_conclusion)
  
    fetch('/proyecto_final/API/evaluacion/guardarconclusion', {
        method: 'POST',
        body: JSON.stringify({ cand_id, cand_conclusion }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.codigo === 1) {
            buscar();
        } else {
            console.error('Error al guardar la conclusión');
        }
    })
    .catch((error) => {
        console.error('Error de red:', error);
    });
};

const buscar = async () => {
    const url = `/proyecto_final/API/evaluacion/buscar/iac`;
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



const traRuta = async (e) => {
    let boton = e.target;
    let ruta = boton.dataset.ruta;

    document.getElementById('modalIframe').src = ruta;

    const miModal = new bootstrap.Modal(document.getElementById('miModal'));
    miModal.show();
}

buscar();
datatable.on('click','.btn-info', traRuta )
datatable.on('click','.btn-primary', traRuta )
btnGuardarConclusion.addEventListener('click', guardarConclusión);