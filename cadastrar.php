<?php
include ("conexao.php");

// Recuperando dados do formulário
$data = $_POST['data'];
$turma = $_POST['turma'];
$alunos_faltantes = $_POST['aluno_faltante'];
$professor_id = $_POST['professor_id'];
$conteudo = $_POST['conteudo'];
$bimestre = $_POST['bimestre'];
$disciplina = $_POST['disciplina'];
$quantidade = intval($_POST['quantidade']); // Convertendo a quantidade para um número inteiro

foreach ($_POST['aluno'] as $aluno) {
  for ($i = 0; $i < $quantidade; $i++) {
    $id = is_array($_POST['aluno_faltante']) && in_array($aluno, $_POST['aluno_faltante']) ? 1 : 0;
    $query = "INSERT INTO `faltas`(`id`, `data`, `aluno_id`, `turma_id`,`bimestre`, `insertBy`, `disciplina`) VALUES ('$id', '$data', '$aluno', '$turma', '$bimestre', '$professor_id', '$disciplina')";
    
    // Verifica se o conteúdo não está vazio antes de executar a consulta
      $conn->query($query);
    
  }
}

// Verifica se o conteúdo não está vazio antes de executar a consulta
if (!empty($conteudo)) {
  $queryConteudo = "INSERT INTO `conteudo`(`conteudo`, `data`, `insertBy`, `disciplina`, `turma`) VALUES ('$conteudo','$data','$professor_id', '$disciplina', '$turma')";
  $conn->query($queryConteudo);
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css?<?php echo $cssVersion?>">
    <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <title>Sucesso!</title>
</head>
<body>

<div class="container">
    
    <div class="mx-auto text-center box-v">
  <h1 class="text-center">Dados inseridos com sucesso!</h1>
    <a href="painel.php"><button class="btn btn-primary px-3">Voltar</button></a>
  </div>
</div>

</body>
</html>