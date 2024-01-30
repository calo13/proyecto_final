import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.getElementById('formularioCandidato');
const btnGuardar = document.getElementById('btnGuardar');
const divTabla = document.getElementById('tablaCandidato');
const btnConfirmarTest = document.getElementById('btnConfirmarTest');
const cuiInput = document.getElementById('cand_dpi');
const reg = document.getElementById('registrar');
const modalSeleccionarTest = new bootstrap.Modal(document.getElementById('modalSeleccionarTest'));


function iniciar_app() {

    reg.setAttribute('disabled', 'true');
}


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
            title: 'Nombre Completo',
            render: function (data, type, row, meta) {
                return row.cand_primer_nombre + ' ' + row.cand_segundo_nombre + ' ' + row.cand_primer_apellido + ' ' + row.cand_segundo_apellido;
            }
        },
        {
            title : 'Sexo',
            data: 'cand_sexo'
        },
        {
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
            title: 'Fecha de Evaluación',
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
            title : 'MODIFICAR',
            data: 'cand_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-primer_nombre='${row["cand_primer_nombre"]}' data-segundo_nombre='${row["cand_segundo_nombre"]}' data-primer_apellido='${row["cand_primer_apellido"]}' data-segundo_apellido='${row["cand_segundo_apellido"]}' data-sexo='${row["cand_sexo"]}' data-fecha_nacimiento='${row["cand_fecha_nacimiento"]}'>Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'cand_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
        
    ]
})


const buscar = async () => {
    const url = `/proyecto_final/API/candidato/buscar`;
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


let nuevoCandidatoID;


const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['cand_id','cand_segundo_nombre','cand_segundo_apellido'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('cand_id'); 

    const url = '/proyecto_final/API/candidato/guardar'; 
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
console.log(data)
        const { codigo, mensaje, detalle, id } = data;
        let icon = 'info';

        switch (codigo) {
            case 1:
                nuevoCandidatoID = id;
                formulario.reset(); 
                icon = 'success';
                buscar(); 
                modalSeleccionarTest.show(); 
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.log(error);
    }
    modalSeleccionarTest.show();
};

let candiIDcodificado = btoa (nuevoCandidatoID);
console.log(candiIDcodificado);


btnConfirmarTest.addEventListener('click', async () => {
    
    const testSeleccionado = document.querySelector('input[name="cand_test_id"]:checked');
    if (!testSeleccionado) {
        Toast.fire({
            icon: 'info',
            text: 'Por favor, seleccione un test antes de confirmar.'
        });
        return;
    }

    const formData = new FormData(formulario);
    formData.append('cand_test_id', testSeleccionado.value);
    formData.append('nuevoCandidatoID', nuevoCandidatoID);

    const url = '/proyecto_final/API/candidato/guardar_con_test';
    const config = {
        method: 'POST',
        body: formData,
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data)
        // return
        if (data.codigo === 1) {
            Toast.fire({
                icon: 'success',
                text: 'Datos del formulario y test guardados con éxito.'
            });
            modalSeleccionarTest.hide();
            formulario.reset();
        } else {
            Toast.fire({
                icon: 'error',
                text: 'Hubo un error al guardar los datos.'
            });
        }
    } catch (error) {
        console.error(error);
    }
});




const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const primer_nombre = button.dataset.primer_nombre;
    const segundo_nombre = button.dataset.segundo_nombre;
    const primer_apellido = button.dataset.primer_apellido;
    const segundo_apellido = button.dataset.segundo_apellido;
    const sexo = button.dataset.sexo;
    const fecha_nacimiento = button.dataset.fecha_nacimiento;
    // const fecha_evaluacion = button.dataset.fecha_evaluacion;

    const dataset = {
        id,
        primer_nombre,
        segundo_nombre,
        primer_apellido,
        segundo_apellido,
        sexo,
        fecha_nacimiento,
        // fecha_evaluacion
};

console.log('Datos recopilados:', dataset);

colocarDatos(dataset);
const body = new FormData(formulario);
body.append('cand_id', id);
body.append('cand_primer_nombre', primer_nombre);
body.append('cand_segundo_nombre', segundo_nombre);
body.append('cand_primer_apellido', primer_apellido);
body.append('cand_segundo_apellido', segundo_apellido);
body.append('cand_sexo', sexo);
body.append('cand_fecha_nacimiento', fecha_nacimiento);
};

const colocarDatos = (dataset) => {
    formulario.cand_id.value = dataset.id;
    formulario.cand_primer_nombre.value = dataset.primer_nombre;
    formulario.cand_segundo_nombre.value = dataset.segundo_nombre;
    formulario.cand_primer_apellido.value = dataset.primer_apellido;
    formulario.cand_segundo_apellido.value = dataset.segundo_apellido;
    formulario.cand_sexo.value = dataset.sexo;
    formulario.cand_fecha_nacimiento.value = dataset.fecha_nacimiento;

    const tablaCandidatoContainer = document.getElementById('tablaCandidatoContainer');
    tablaCandidatoContainer.style.display = 'none';

    // Restablecer el estado de los botones
    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
}


const modificar = async () => {
    if (await confirmacion('warning', 'Desea modificar este registro?')) {     
        const body = new FormData(formulario)
        const url = '/proyecto_final/API/candidato/modificar';
        const config = {
            method : 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
    
            const { codigo, mensaje, detalle } = data;
            let icon = 'info';
            switch (codigo) {
                case 1:
                    formulario.reset();
                    icon = 'success', 
                            'mensaje';
                    buscar();
                    break;
    
                case 0:
                    icon = 'error';
                    console.log(detalle);
                    break;
    
                default:
                    break;
            }
            Toast.fire({
                icon,
                text: mensaje
            });
            // al terminar de modificar se mostrara el formulario y limpiara el formulario
            const tablaCandidatoContainer = document.getElementById('tablaCandidatoContainer');
            tablaCandidatoContainer.style.display = '';
            formulario.cand_id.value = ''; // Limpiar el campo ID
            btnGuardar.disabled = false;
            btnGuardar.parentElement.style.display = '';
            btnBuscar.disabled = false;
            btnBuscar.parentElement.style.display = '';
            btnModificar.disabled = true;
            btnModificar.parentElement.style.display = 'none';
            btnCancelar.disabled = true;
            btnCancelar.parentElement.style.display = 'none';
        } catch (error) {
            console.log(error);            
            }
        }
}
const confirmarTest = () => {
    if (nuevoCandidatoID) {
        const testSeleccionado = document.querySelector('input[name="cand_test_id"]:checked');
        if (testSeleccionado) {
            const testID = testSeleccionado.value;

            let urlDestino = '';

            if (testID === '1') {
                urlDestino = `/proyecto_final/respuesta/epqa?nuevoCandidatoID=${nuevoCandidatoID}&testID=${testID}`;
            } else if (testID === '2') {
                urlDestino = `/proyecto_final/respuesta/iac?nuevoCandidatoID=${nuevoCandidatoID}&testID=${testID}`;
            } else {
                Toast.fire({
                    icon: 'info',
                    text: 'Test no válido'
                });
                return;
            }

            window.location.href = urlDestino;

            formulario.style.display = 'none';
        } else {
            Toast.fire({
                icon: 'info',
                text: 'Debe seleccionar un test'
            });
        }
    } else {
        Toast.fire({
            icon: 'info',
            text: 'Primero debes guardar el candidato'
        });
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

buscar();
formulario.addEventListener('submit', guardar)
document.getElementById('btnConfirmarTest').addEventListener('click', confirmarTest);
