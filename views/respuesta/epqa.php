  <!DOCTYPE html>
  <html lang="en">

  <head>
      <style>
          body {
              font-family: 'Arial', sans-serif;
              background-image: url("<?= asset('./images/fondo6.png') ?>");

              background-size: cover; 
              background-repeat: no-repeat;
              background-position: center;
              color: balck;
              padding-top: 56px;
              position: relative;
              min-height: 100vh;
              margin: 0;
          }

          #cronometro-container {
              text-align: center;
              margin-top: 20px;
              font-size: 1.2em;
              color: #000;
          }

          #tiempo-restante {
              font-size: 2em;
              font-weight: bold;
              color: #000;
              animation: scaleAnimation 0.5s infinite alternate;
          }

          @keyframes scaleAnimation {
              from {
                  transform: scale(1);
              }

              to {
                  transform: scale(1.1);
              }
          }

          #tablaIacContainer {
              text-align: center;
          }

          .center-text {
              text-align: center;
          }

          #preguntaText {
              text-align: center;
              font-size: 1.5em;
              margin-bottom: 20px;
          }

          .opciones {
              display: flex;
              justify-content: center;
              margin-top: 20px;
          }

          .btn-opcion {
              background-color: #007BFF; 
              color: white;
              margin: 0 20px; 
              font-size: 1.2em;
              padding: 10px 20px;
          }

          .btn-opcion.selected {
              background-color: #28A745; 
          }

          .selected {
              background-color: #28A745;
              color: #fff; 
          }

          .selected1 {
              background-color: red;
              color: #fff; 
          }

          .row.mb-3 {
              margin-bottom: 20px;
          }
          #barra-progreso-container {
              text-align: center;
              margin-top: 20px;
              position: relative;
          }

          #barra-progreso {
              background-color: rgba(128, 128, 128, 0.7); 
              height: 30px;
              width: 50%; 
              display: inline-block;
              position: relative;
          }

          #barra-progreso-verde {
              background-color: #28A745; 
              height: 100%; 
              width: 0; 
              position: absolute;
              top: 0;
              left: 0;
          }

          #numero-pregunta {
              font-size: 1.2em;
              color: #fff; 
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
          }
</style>
  </head>

  <body>
    
      <br><br><br>
      <h1 class="text-center">Test EPQ-A</h1>
      
      <div class="row justify-content-center mb-5" style="background-color: transparent;">
          <form class="col-lg-6 border  p-3" id="formularioRespuesta" style="background-color: rgba(255, 255, 255, 0.3);">
              <input type="hidden" name="res_id" id="res_id">
              <input type="hidden" name="res_cand_id" id="res_cand_id" class="form-control">
              <input type="hidden" name="res_test_id" id="res_test_id" class="form-control">
              <input type="hidden" name="res_pregunta_id" id="res_pregunta_id" class="form-control">
              <div class="row mb-3" style="background-color: transparent;">
                  <div class="col">
                      <div id="preguntaContainer" style="background-color: rgba(128, 128, 128, 0.15);">
                          <br>
                          <h3 id="preguntaText"></h3>
                          <!-- Opciones "Sí" y "No" -->
                          <div class="opciones">
                              <button id="btnSi" class="btn btn-success btn-opcion" style="width: 10%;">Sí</button>
                              <button id="btnNo" class="btn btn-danger btn-opcion" style="width: 10%;">No</button>
                          </div>
                          <br><br><br>
                      </div>
                      <div class="row mb-3">
                          <div class="col center-text">
                              <button type="submit" form="formularioRespuesta" id="btnGuardar"
                                  class="btn btn-primary w-30" disabled>Siguiente pregunta</button>
                          </div>
                      </div>
                  </div>
              </div>
      </div>
          </form>
        </div>


        <div id="barra-progreso-container">
    <div id="barra-progreso">
        <div id="barra-progreso-verde"></div>
        <div id="numero-pregunta"></div>
    </div>
</div>



      <div id="cronometro-container">
          Tiempo Restante: <span id="tiempo-restante"></span>
      </div>

      <script src="<?= asset('./build/js/respuesta/epqa.js') ?>"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>
