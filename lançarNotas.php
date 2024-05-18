<?php
include("conexao.php");

// Recuperando dados do formulário
$AV1 = $_POST['AV1'];
$REC1 = $_POST['REC1'];
$AV2 = $_POST['AV2'];
$REC2 = $_POST['REC2'];
$AV3 = $_POST['AV3'];
$REC3 = $_POST['REC3'];
$alunos = $_POST['aluno'];
$turma = $_POST['turma'];
$professor_id = $_POST['professor_id'];
$disciplina = $_POST['disciplina'];
$bimestre = $_POST['bimestre'];

// Iniciar transação
mysqli_begin_transaction($conn);

foreach ($alunos as $aluno) {
    $query_verifica = "SELECT * FROM notas WHERE aluno_id = '$aluno' AND turma = '$turma' AND insertBy = '$professor_id' AND disciplina = '$disciplina' AND bimestre = '$bimestre' FOR UPDATE";
    $result = mysqli_query($conn, $query_verifica);

    if (mysqli_num_rows($result) > 0) {
        // faz update
        $query = "UPDATE notas SET AV1 = '$AV1[$aluno]', REC1 = '$REC1[$aluno]', AV2 = '$AV2[$aluno]', REC2 = '$REC2[$aluno]', AV3 = '$AV3[$aluno]', REC3 = '$REC3[$aluno]' WHERE aluno_id = '$aluno' AND turma = '$turma' AND insertBy = '$professor_id' AND disciplina = '$disciplina' AND bimestre = '$bimestre'";
        mysqli_query($conn, $query);
    } else {
        // faz insert
        $query = "INSERT INTO notas (aluno_id, AV1, REC1, AV2, REC2, AV3, REC3, turma, insertBy, disciplina, bimestre) VALUES ('$aluno', '$AV1[$aluno]', '$REC1[$aluno]', '$AV2[$aluno]', '$REC2[$aluno]', '$AV3[$aluno]', '$REC3[$aluno]', '$turma', '$professor_id', '$disciplina', '$bimestre')";
        mysqli_query($conn, $query);
    }
}

// Finalizar transação
mysqli_commit($conn);

// Resto do código
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