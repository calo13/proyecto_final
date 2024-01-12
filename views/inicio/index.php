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
            color: white;
            padding-top: 56px;
            position: relative;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            margin-top: 100px;
        }

        .card {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            color: white;
        }

        .btn-primary,
        .btn-secondary {
            margin-top: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
        }
    </style>
    <title>Evaluaciones Psicologicas ETMA</title>
</head>

<body>
    <header>
        <h1>Evaluaciones Psicológicas - Escuela Técnica Militar de Aviación (ETMA)</h1>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center">
                    <h2 class="card-title">Candidato</h2>
                    <p class="card-text">Si eres un candidato, selecciona esta opción para evaluarte.</p>
                    <a href="http://localhost/proyecto_final/candidato" class="btn btn-primary">Evaluarme</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <h2 class="card-title">Evaluadores</h2>
                    <p class="card-text">Esta opción es para evaluadores que poseen una cuenta.</p>
                    <a href="http://localhost/proyecto_final/login" class="btn btn-secondary">Administrar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Evaluaciones Psicológicas - ETMA</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
