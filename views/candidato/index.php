<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-image: url("./images/psicologia.jpg");
      background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: black;
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
  </style>
  <title>Navbar con Bootstrap</title>
</head>
<body>
<br><br><br>
<h1 class="text-center">Formulario Candidato</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-5 border bg- p-3" id="formularioCandidato" style="background-color: rgba(255, 255, 255, 0.5);">
        <input type="hidden" name="cand_id" id="cand_id" > 
        <div class="row mb-3">
            <div class="col">
                <label for="cand_primer_nombre">Primer Nombre</label> 
                <input type="text" name="cand_primer_nombre" id="cand_primer_nombre" class="form-control">
            </div>
            <div class="col">
                <label for="cand_segundo_nombre">Segundo Nombre</label> 
                <input type="text" name="cand_segundo_nombre" id="cand_segundo_nombre" class="form-control">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="cand_primer_apellido">Primer Apellido</label> 
                <input type="text" name="cand_primer_apellido" id="cand_primer_apellido" class="form-control">
            </div>
            <div class="col">
                <label for="cand_segundo_apellido">Segundo Apellido</label> 
                <input type="text" name="cand_segundo_apellido" id="cand_segundo_apellido" class="form-control">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="cand_sexo">Sexo</label> 
                <select class="form-select" id="cand_sexo" name="cand_sexo">
                    <option value="">Seleccione...</option>
                    <option value="F">Femenino</option>
                    <option value="M">Masculino</option>
                </select>
            </div>
            <div class="col">
                <label for="cand_fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" name="cand_fecha_nacimiento" id="cand_fecha_nacimiento" class="form-control">
            </div>
            <div class="col">
                    <label for="cand_fecha_nacimiento">DPI</label>
                    <input type="number" name="cand_dpi" id="cand_dpi" class="form-control" required>
                </div>
        </div>        
        <div class="row mb-3">
            <div class="col">
                <button type="submit" id="registrar" name="registrar" form="formularioCandidato" id="btnGuardar" data-saludo="hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
            </div>
        </div>
    </form>
</div>

<!-- modal para seleccionar el test -->
<div class="modal fade" id="modalSeleccionarTest" tabindex="-1" aria-labelledby="modalSeleccionarTestLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSeleccionarTestLabel">Seleccionar un Test</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($test as $psi_test) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cand_test_id" id="test<?= $psi_test['test_id'] ?>" value="<?= $psi_test['test_id'] ?>">
                        <label class="form-check-label" for="test<?= $psi_test['test_id'] ?>">
                            <?= $psi_test['test_nombre'] ?>
                        </label>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarTest">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('./build/js/candidato/index.js')  ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



