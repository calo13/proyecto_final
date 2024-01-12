// Ignorar los errores de repeticiom, recuerda que hay varios js en este archivo y todos estan bien

// JS 1.1.1 de candidato/index.js --------------------------------------------------------------------------------------------------------------------------------
// Falta quitar los comentarios que no son necesarios y cometar partes que podrian ser necesarias
// los candidatos se registran bien y redirige al test que se selecciona en el modal
// OJO OJO OJO posiblemente aqui deba iniciar el contador una vez que se confirma el test
// otros que no se me ocurren aun
// Agregar el estado del candidato a evaluado, por evaluar, aprobador o no aprobado
import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.getElementById('formularioCandidato');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('tablaCandidato');
const btnConfirmarTest = document.getElementById('btnConfirmarTest');
const modalSeleccionarTest = new bootstrap.Modal(document.getElementById('modalSeleccionarTest'));

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

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
            data: null, // Deja esto en null ya que vamos a personalizar la representación
            render: function (data, type, row, meta) {
                // Combina los valores de las columnas en una sola columna
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
                    // Formatea la fecha en el formato deseado (día-mes-año)
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-ES'); // Puedes ajustar el idioma según tu preferencia
                }
                return data; // Devuelve la fecha sin cambios para otras operaciones
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

// const mostrarFormulario = () => {
//     tablaIacContainer.style.display = 'none';
//     formulario.style.display = 'block';
// };

// const ocultarFormulario = () => {
//     formulario.reset();
//     formulario.style.display = 'none';
//     tablaIacContainer.style.display = 'block';
// };

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
    body.delete('cand_id'); // Elimina el campo 'cand_id' para agregar un nuevo candidato

    const url = '/proyecto_final/API/candidato/guardar'; // URL para guardar el candidato
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle, id } = data;
        let icon = 'info';

        switch (codigo) {
            case 1:
                nuevoCandidatoID = id; // Guarda el ID del nuevo candidato
                formulario.reset(); // Limpia el formulario
                icon = 'success';
                buscar(); // Actualiza la tabla de candidatos
                modalSeleccionarTest.show(); // Abre el modal para seleccionar el test
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

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    // console.log(id);
    if (await confirmacion('warning', 'Desea elminar este registro?')) {
        const body = new FormData()
        body.append('cand_id', id)
        const url = '/proyecto_final/API/candidato/eliminar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method: 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            // console.log(data);
            // return;
            const { codigo, mensaje, detalle } = data;
            let icon = 'info'
            switch (codigo) {
                case 1:
                    // formulario.reset();
                    icon = 'success'
                    buscar();
                    // cancelarAccion();
                    break;
                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;
                default:
                    break;
            }
            Toast.fire({
                icon,
                text: mensaje
            })
        } catch (error) {
            console.log(error);
        }
    }
}

const cancelarAccion = () => {
    const tablaCandidatoContainer = document.getElementById('tablaCandidatoContainer');
    tablaCandidatoContainer.style.display = '';
    btnGuardar.disabled = false;
    btnGuardar.parentElement.style.display = '';
    btnBuscar.disabled = false;
    btnBuscar.parentElement.style.display = '';
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    divTabla.style.display = '';
    formulario.reset();
}

            // Confirma el test seleccionado, lo guarda y redireciona a la nueva url segun el test que seleccionemos.
const confirmarTest = () => {
    if (nuevoCandidatoID) {
        const testSeleccionado = document.querySelector('input[name="cand_test_id"]:checked');
        if (testSeleccionado) {
            const testID = testSeleccionado.value;

            // URL de destino según el test seleccionado
            let urlDestino = '';

            if (testID === '1') {
                // urlDestino = '/proyecto_final/cuestionario/epqa'; // no lleva las variables
                urlDestino = `/proyecto_final/respuesta/epqa?nuevoCandidatoID=${nuevoCandidatoID}&testID=${testID}`;
 //lleva las variables
            } else if (testID === '2') {
                // urlDestino = '/proyecto_final/cuestionario/iac'; // no lleva las variables
                urlDestino = `/proyecto_final/cuestionario/iac?nuevoCandidatoID=${nuevoCandidatoID}&testID=${testID}`;
            } else {
                Toast.fire({
                    icon: 'info',
                    text: 'Test no válido'
                });
                return;
            }

            // Redirigir a la nueva URL en la misma ventana
            window.location.href = urlDestino;

            // Ocultar el formulario
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




buscar();
formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', colocarDatos )
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )
document.getElementById('btnConfirmarTest').addEventListener('click', confirmarTest);







// JS 1.1.1 de respuesta/epqa.js -------------------------------------------------------------------------------------------------------------------------------------

//hasta aqui funciona bien el guardar y seleccionar las preguntas
//error: si preciona seguido (como undoble o triple click) se guardaran varias veces la misma pregutna con la misma respuesta
//aun no tiene cronometro
// falta un aviso de que finalizo el formulario
// falta aviso de que su tiempo a terminado
// falta redirigirlo al menu iniciar

import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form');

// Obtener los parámetros de la URL
const urlParams = new URLSearchParams(window.location.search);
const nuevoCandidatoID = urlParams.get("nuevoCandidatoID");
const testID = urlParams.get("testID");

// Asignar los valores a los campos ocultos en el formulario
document.getElementById("res_cand_id").value = nuevoCandidatoID;
document.getElementById("res_test_id").value = testID;

// Selecciona los botones "Sí" y "No"
const btnSi = document.getElementById("btnSi");
const btnNo = document.getElementById("btnNo");

// Variables
let seleccion = null;
let contenedor;
let preguntasEPQA;
let preguntaText = document.getElementById("preguntaText");
const btnGuardar = document.getElementById("btnGuardar");

btnSi.addEventListener('click', (event) => {
    event.preventDefault(); // Previene el envío del formulario por el botón "Sí"
    seleccion = 1; // 1 para "Sí"
    btnSi.classList.add('selected'); // Agrega la clase "selected" al botón "Sí"
    btnNo.classList.remove('selected'); // Quita la clase "selected" del botón "No"
  });
  
  btnNo.addEventListener('click', (event) => {
    event.preventDefault(); // Previene el envío del formulario por el botón "No"
    seleccion = 2; // 2 para "No"
    btnNo.classList.add('selected'); // Agrega la clase "selected" al botón "No"
    btnSi.classList.remove('selected'); // Quita la clase "selected" del botón "Sí"
  });
  

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
    } else {
      preguntaText.textContent = 'No hay preguntas disponibles';
      btnGuardar.disabled = true;
    }
  } catch (error) {
    console.log(error);
  }
};

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

const guardar = async (evento) => {
  evento.preventDefault();
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
          preguntaText.textContent = "No hay más preguntas disponibles";
          btnGuardar.disabled = true;
        }
        seleccion = null;
        btnSi.classList.remove('selected');
        btnNo.classList.remove('selected');
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