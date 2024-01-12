<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= asset('./src/css/style.cs') ?>">
    


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

        header {            
            text-align: center;            
        }

        header h1 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            margin-bottom: 15; 
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .card {
            flex: 0 0 40%; 
            margin: 1%;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: #333;
            padding: 10px;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.07);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .card h2 {
            color: #007bff;
        }

        .card p {
            font-size: 1.3em;
        }
        .card img {
            width: 50%; 
            height: auto; 
            object-fit: contain; 
            border-radius: 8px 8px 0 0; 
            margin: 0 auto;
            display: block;
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
    <title>Navbar con Bootstrap</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
    <a class="navbar-brand" href="#">
  <img src="<?= asset('images/cit.png') ?>" alt="Logotipo" style="max-width: 40px; height: auto;">
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<a class="navbar-brand" href="#">Psicología</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              EVALUACIONES
            </a>
            <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
              <li><a class="dropdown-item" href="/proyecto_final/evaluacion/epqa">EVALUAR EPQ-A</a></li>
              <li><a class="dropdown-item" href="/proyecto_final/evaluacion/iac">EVALUAR IAC</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
      <a href="/proyecto_final/logout" class="btn btn-danger">Cerrar Sesión</a>
    </div>
  </div>
</nav>
</head>
<body>
    <br>
    <header>
        <h1>Evaluaciones Psicológicas - Escuela Técnica Militar de Aviación (ETMA)</h1>
    </header>

    <div class="container">
        <div class="card-container">
            <div class="card text-center" onclick="location.href='evaluacion/epqa';">
                <img src="./images/baremos_EPQA.png" alt="Evaluar EPQ-A">
                <p class="card-text">Realiza evaluación de los candidatos que han completado el Test EPQ-A.</p>
            </div>

            <div class="card text-center" onclick="location.href='evaluacion/iac';">
                <img src="./images/baremos_IAC.png" alt="Evaluar IAC">
                <p class="card-text">Realiza evaluación de los candidatos que han completado el Test IAC.</p>
            </div>
             <div class="card text-center" onclick="location.href='test/epqa';">
                <img src="./images/test_EPQA.png" alt="Test EPQ-A">
                <p class="card-text">Ver las las preguntas del Test EPQ-A.</p>
            </div>
            <div class="card text-center" onclick="location.href='test/iac';">
                <img src="./images/test_IAC.png" alt="Test Test IAC">
                <p class="card-text">Ver las las preguntas del Test IAC.</p>
            </div>

            <!-- Tarjeta 5: Baremos EPQ-A -->
            <!-- <div class="card text-center" onclick="location.href='#';">
                <img src="./images/baremos_EPQA.png" alt="Baremos EPQ-A">
                <p class="card-text">Plantilla de comparacion EPQ-A.</p>
            </div> -->

            <!-- Tarjeta 6: Baremos IAC -->
            <!-- <div class="card text-center" onclick="location.href='#';">
                <img src="./images/baremos_IAC.png" alt="Baremos IAC">
                <p class="card-text">Plantilla de comparacion IAC.</p>
            </div> -->
          
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Evaluaciones Psicológicas - ETMA</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
