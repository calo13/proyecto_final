<!DOCTYPE html>
<html lang="en">
<head>

  <style>
    body {
 background-image: url('<?= asset("../src/img/psicologia.jpg") ?>');
 background-color: #007BFF;
}
    #tablaEpqaContainer {
      text-align: center; 
    }

    .opciones {
      display: flex;
      justify-content: center;
      margin-top: 40px; 
    }

    .btn-opcion {
      background-color: #007BFF; 
      color: white;
      margin: 0 40px; 
    }

    .btn-opcion.selected {
      background-color: #28A745; 
    }

    .selected {
      background-color: #28A745;
      color: #fff;
    }
  </style>
</head>
<body>  
  <div class="container">  
    <div class="row justify-content-center">
      <div id="tablaEpqaContainer" class="container mt-1">
        <div class="row justify-content-center mt-4">
          <div class="col-12 p-4 shadow"> 
            <div class="text-center">
              <h1>Test EPQ-A</h1>
              <br>

              <br>
            </div>
            <div id="preguntaContainer">
              <h3 id="preguntaText"></h3>
              <div class="opciones">
                <button id="btnSi" class="btn btn-primary btn-opcion">Sí</button>
                <button id="btnNo" class="btn btn-primary btn-opcion">No</button>
              </div>
            </div>
            <button id="btnSiguiente" class="btn btn-primary float-end" disabled>Siguiente</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="<?= asset('../build/js/cuestionario/epqa.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
