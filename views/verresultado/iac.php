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
      padding-top: 56px;
      position: relative;
      min-height: 100vh;
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
<div class="row justify-content-center">
    <div id="tablaCandidatoContainer" class="col table-responsive" style="max-width: 80%; padding: 10px;">
        <table id="tablaCandidato" class="table table-bordered table-hover">
        </table>
    </div>
</div>

<script src="<?= asset('./build/js/verresultado/iac.js')  ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



