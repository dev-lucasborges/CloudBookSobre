<?php

define('HOST', 'localhost');
define('USUARIO', 'u631704596_devlucasborges');
define('SENHA', '27512320903510#L.r');
define('DB', 'u631704596_cloudbookdb');
$conexao = mysqli_connect( HOST, USUARIO, SENHA, DB) or die ('error');
include('verifica_login.php');

$host = "localhost";
$user = "u631704596_devlucasborges";
$password = "27512320903510#L.r";
$dbname = "u631704596_cloudbookdb";

$conn = mysqli_connect($host, $user, $password, $dbname);

$cssVersion = 'v=2.0';


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-blur sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="painel.php"><strong>Book</strong></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="painel.php">Inicio</a>
        <a class="nav-link" href="disciplina.php?loc=P">Chamada</a>
        <a class="nav-link" href="disciplina.php?loc=R">Resumo</a>
        <a class="nav-link" href="disciplina.php?loc=G">R. Geral</a>
      </div>
    </div>
  </div>
</nav>
</body>
</html>