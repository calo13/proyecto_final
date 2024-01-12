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
<h2 class="text-center mb-4 text-primary">Inicio de Sesión</h2>
<div class="row justify-content-center" >
        <form id="formLogin" class="col-lg-4 border rounded p-3" style="background-color: rgba(255, 255, 255, 0.3);">
            <div class="row mb-3">
                <div class="col">
                    <label for="usu_dpi" class="form-label">DPI</label>
                    <input type="number" class="form-control" id="usu_dpi" name="usu_dpi">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="usu_password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="usu_password" name="usu_password">
                    </div>
                </div>
                <div class="row mb-3">
                <div class="col">
                    <label class="form-check-label" for="show_password">
                        <input type="checkbox" id="show_password">
                        Mostrar Contraseña
                    </label>
                </div>
            </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </div>
        </form>
    </div class="mt-3">
    <p class="mb-0 text-center">¿No tiene una cuenta?<a href="/proyecto_final/registro" class="text-primary fw-bold ms-2">Registrarse</a></p> 
    </div>
    <div class="container-fluid footer">
        <p style="font-size: xx-small; font-weight: bold;">
            Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
        </p>
    </div>
    <script src="<?= asset('./build/js/login/index.js') ?>"></script>
</div>