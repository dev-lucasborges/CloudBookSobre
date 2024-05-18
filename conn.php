<?php
define('HOST', 'localhost');
define('USUARIO', 'u631704596_devlucasborges');
define('SENHA', '27512320903510#L.r');
define('DB', 'u631704596_cloudbookdb');
$conexao = mysqli_connect( HOST, USUARIO, SENHA, DB) or die ('error');

$host = "localhost";
$user = "u631704596_devlucasborges";
$password = "27512320903510#L.r";
$dbname = "u631704596_cloudbookdb";


// Cria a conexão com o banco de dados
$conn = mysqli_connect($host, $user, $password, $dbname);


?>