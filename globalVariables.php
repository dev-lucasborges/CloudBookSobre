<?php
include ('conexao.php');
$user_id = $_SESSION['user_id'];
$dadosProfessorQuery = "SELECT * FROM usuarios WHERE id = '$user_id'";
$dadosProfessor = mysqli_query($conexao, $dadosProfessorQuery);

$nome = '';
$nome_completo = '';
$escola = '';
$disciplina = '';
$turmas = '';
$nivel_acesso = '';

while($row = mysqli_fetch_assoc($dadosProfessor)){
  $nome = $row['nome'];
  $nome_completo = $row['nome_completo'];
  $escola = $row['escola'];
  $disciplina = $row['disciplinas'];
  $turmas = $row['turmas'];
  $nivel_acesso = $row['nivel'];
}

?>