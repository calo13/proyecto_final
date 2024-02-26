<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




  <style>
    body {
      background-image: url("<?= asset('./images/fondo6.png') ?>");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      color: white;
      padding-top: 56px;
      position: relative;
      min-height: 100vh;
      margin: 0;
      font-family: 'Arial', sans-serif;
    }

    .footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      padding: 10px 0;
      background-color: #f8f9fa;
    }

    .custom-table th {
      background-color: rgba(128, 128, 128, 0.5);
    }

    .custom-table,
    .custom-table td {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .dataTables_info {
      color: black;
    }

    .dataTables_filter label {
      color: black;
    }

    .dataTables_paginate {
      color: black;
    }

    .dataTables_length label {
      color: black;
    }
  </style>
  <title>Navbar con Bootstrap</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="<?= asset('images/cit.png') ?>" alt="Logotipo" style="max-width: 40px; height: auto;">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand" href="#">Psicología</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              EVALUACIONES
            </a>
            <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
              <li><a class="dropdown-item" href="/proyecto_final/evaluacion/epqa">EVALUAR EPQ-A</a></li>
              <li><a class="dropdown-item" href="/proyecto_final/evaluacion/iac">EVALUAR IAC</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Test Psicologicos
            </a>
            <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
              <li><a class="dropdown-item" href="/proyecto_final/test/epqa">Test IPQ-A</a></li>
              <li><a class="dropdown-item" href="/proyecto_final/test/iac">Test IAC</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="d-flex">
        <a href="/proyecto_final/menuAdministrador" class="btn btn-info me-2">Menu Principal</a>
        <a href="/proyecto_final/logout" class="btn btn-danger">Cerrar Sesión</a>
      </div>
    </div>
  </nav>

  <br>
  <h1 class="text-center" style="color: black;">EVALUACIONES EPQ-A</h1>


  <div class="row justify-content-center">
    <div id="tablaCandidatoContainer" class="col table-responsive"
      style="max-width: 85%; padding: 10px; margin-left: 60px; margin-top: 1px;">
      <table id="tablaCandidato" class="table table-bordered table-hover custom-table">
      </table>
    </div>
  </div>


  <!-- para abrir los modals de respuestas y resultados -->
  <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="miModalLabel">Título del Modal</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe id="modalIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal Concluciones -->
  <div class="modal fade" id="conclusionModal" tabindex="-1" aria-labelledby="conclusionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="conclusionModalLabel">Cambiar Conclusión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="conclusionForm" name="cand_conclusion">
            <div class="mb-3">
              <label for="conclusionSelect" class="form-label" name="cand_conclusion">Seleccionar Conclusión:</label>
              <select name="cand_conclusion" class="form-select" id="conclusionSelect">
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="APTO">APTO</option>
                <option value="NO APTO">NO APTO</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" name="guardarConclusiónBtn" class="btn btn-primary"
            id="guardarConclusiónBtn">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= asset('./build/js/evaluacion/epqa.js') ?>"></script>


</html>