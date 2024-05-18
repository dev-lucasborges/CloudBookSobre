<?php
include ("conexao.php");
$user_id = $_SESSION['user_id'];
$turma_id = $_GET["turma"];
$disciplinaAtual = $_GET['disciplina'];
$bimestre = $_GET['bimestre'];


// buscar dados do usuário

$dadosProfessorQuery = "SELECT * FROM usuarios WHERE id = '$user_id'";
$dadosProfessor = mysqli_query($conexao, $dadosProfessorQuery);

$nome = '';
$nome_completo = '';
$escola = '';
$disciplina = '';
$turmas = '';

while($row = mysqli_fetch_assoc($dadosProfessor)){
  $nome = $row['nome'];
  $nome_completo = $row['nome_completo'];
  $escola = $row['escola'];
  $disciplina = $row['disciplinas'];
  $turmas = $row['turmas'];
}
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
    <link rel="stylesheet" href="./css/print.css" media="print">
    <title>Relatório Geral</title>
</head>
<body>
<div class="row align-items-center">
    <div class="col d-flex justify-content-center ">
        <img class="bg-dark rounded m-1" src="./assets/<?php echo $escola; ?>.png" width="100px" alt="" srcset="">
    </div>
    <div class="col m-1">
            <span class="seeduc">GOVERNO DO ESTADO DO RIO DE JANEIRO - SECRETARIA DE ESTADO DE EDUCAÇÃO - DIR. REGIONAL NORTE FLUMINENSE - <strong><?php echo $escola; ?></strong></span>
    </div>
    <div class="col">
            <h1 class="h1 bold text-primary"><strong><?php echo $disciplinaAtual; ?></strong></h1>
    </div>
    </div>
    <div class="d-flex justify-content-center">
    <div class="">
            <div class="seeduc text-center bg-primary rounded px-2 text-light mb-3">DIÁRIO DE CLASSE 2023</div>
    </div>
    </div>



    <table class="table bg-light mb-0">
        <thead>
            <th>TURMA: <?php echo $turma_id;?></th>
            <th>AULAS PREVISTAS:__</th>
            <th>AULAS DADAS:__</th>
            <th>BIMESTRE: 4°</th>
            <th>MÉDIAS PERDIDAS:__</th>
            <th>MÉDIAS RECUPERADAS:__</th>
            <th>DOCENTE: <?php echo $nome_completo; ?></th>
        </thead>
    </table>

    <table class="table table-responsive m-0 table-sm small">
        <thead>
            <th class='text-center withBorder'>N° DA MATRÍCULA</th>
            <th class='withBorder'>NOME DO ALUNO</th>
            <?php
            if($bimestre == 1){
            echo '<th class="text-center withBorder">FEVEREIRO</th>';
            echo '<th class="text-center withBorder">MARÇO</th>';
            echo '<th class="text-center withBorder">ABRIL</th>';
            }
            if($bimestre == 2){
            echo '<th class="text-center withBorder">MAIO</th>';
            echo '<th class="text-center withBorder">JUNHO</th>';
            echo '<th class="text-center withBorder">JULHO</th>';
            }
            if($bimestre == 3){
              echo '<th class="text-center withBorder">AGOSTO</th>';
              echo '<th class="text-center withBorder">SETEMBRO</th>';
              echo '<th class="text-center withBorder">OUTUBRO</th>';
            }
            if($bimestre == 4){
              echo '<th class="text-center withBorder">NOVEMBRO</th>';
              echo '<th class="text-center withBorder">DEZEMBRO</th>';
            }
            ?>

            
            <th class='text-center withBorder'>AV1</th>
            <th class='text-center withBorder'>REC1</th>
            <th class='text-center withBorder'>AV2</th>
            <th class='text-center withBorder'>REC2</th>
            <th class='text-center withBorder'>AV3</th>
            <th class='text-center withBorder'>REC3</th>
            <th class='text-center withBorder'>MÉDIA</th>
            <th class='text-center withBorder'>PONTOS DE REC.</th>
            <th class='text-center withBorder'>MÉDIA FINAL</th>
            <th class='text-center withBorder'>TOTAL DE FALTAS</th>
        </thead>

        <tbody>
        <?php

    $user_id = $_SESSION['user_id'];
  // Recuperando dados do banco de dados
$query = " SELECT * FROM faltas";
$result = mysqli_query($conn, $query);



$notas_query = "SELECT aluno_id, av1, rec1, av2, rec2, av3, rec3 FROM notas WHERE insertBy = '$user_id' AND notas.disciplina = '$disciplinaAtual' AND notas.bimestre = '$bimestre' ";
$notas_result = mysqli_query($conn, $notas_query);

$notas_query_media = "SELECT aluno_id, SUM(av1 + av2 + av3) AS nota_total FROM notas WHERE insertBy = '$user_id' AND notas.disciplina = '$disciplinaAtual' AND notas.bimestre = '$bimestre' GROUP BY aluno_id ";
$notas_result_media = mysqli_query($conn, $notas_query_media);

$notas_array_media = array();
while ($nota = mysqli_fetch_assoc($notas_result_media)) {
  $notas_array_media[$nota['aluno_id']] = $nota['nota_total'];
}

$notas_query_rec = "SELECT aluno_id, SUM(rec1 + rec2 + rec3) AS nota_total FROM notas WHERE insertBy = '$user_id' AND notas.disciplina = '$disciplinaAtual' AND notas.bimestre = '$bimestre' GROUP BY aluno_id ";
$notas_result_rec = mysqli_query($conn, $notas_query_rec);

$notas_array_rec = array();
while ($nota = mysqli_fetch_assoc($notas_result_rec)) {
  $notas_array_rec[$nota['aluno_id']] = $nota['nota_total'];
}

$notas_query_total = "SELECT aluno_id, SUM(
    CAST(REPLACE(av1, ',', '.') AS DECIMAL(10, 2)) +
    CAST(REPLACE(av2, ',', '.') AS DECIMAL(10, 2)) +
    CAST(REPLACE(av3, ',', '.') AS DECIMAL(10, 2)) +
    CAST(REPLACE(rec1, ',', '.') AS DECIMAL(10, 2)) +
    CAST(REPLACE(rec2, ',', '.') AS DECIMAL(10, 2)) +
    CAST(REPLACE(rec3, ',', '.') AS DECIMAL(10, 2))
) AS nota_total 
FROM notas 
WHERE insertBy = '$user_id' 
  AND notas.disciplina = '$disciplinaAtual' 
  AND notas.bimestre = '$bimestre' 
GROUP BY aluno_id";

$notas_result_total = mysqli_query($conn, $notas_query_total);

$notas_array_total = array();
while ($nota = mysqli_fetch_assoc($notas_result_total)) {
  $notas_array_total[$nota['aluno_id']] = $nota['nota_total'];
}


$notas_array = array();
while ($nota = mysqli_fetch_assoc($notas_result)) {
  $notas_array[$nota['aluno_id']] = array(
    'av1' => $nota['av1'],
    'rec1' => $nota['rec1'],
    'av2' => $nota['av2'],
    'rec2' => $nota['rec2'],
    'av3' => $nota['av3'],
    'rec3' => $nota['rec3']
  );
}

$alunos_query = "SELECT id, nome, turma_id, escola FROM alunos WHERE turma_id = '$turma_id' AND escola = '$escola'" ;
$alunos_result = mysqli_query($conn, $alunos_query);

$month = "02"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query = "SELECT aluno_id, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result = mysqli_query($conn, $faltas_query);

$faltas_array = array();
while ($falta = mysqli_fetch_assoc($faltas_result)) {
  $faltas_array[$falta['aluno_id']] = $falta['faltas'];
}

$month_mar = "03"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_mar = "SELECT aluno_id, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_mar' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre'GROUP BY aluno_id";
$faltas_result_mar = mysqli_query($conn, $faltas_query_mar);

$faltas_array_mar = array();
while ($falta = mysqli_fetch_assoc($faltas_result_mar)) {
  $faltas_array_mar[$falta['aluno_id']] = $falta['faltas'];
}

$month_abr = "04"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_abr = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_abr' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_abr = mysqli_query($conn, $faltas_query_abr);

$faltas_array_abr = array();
while ($falta = mysqli_fetch_assoc($faltas_result_abr)) {
  $faltas_array_abr[$falta['aluno_id']] = $falta['faltas'];
}

$month_mai = "05"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_mai = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_mai' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_mai = mysqli_query($conn, $faltas_query_mai);

$faltas_array_mai = array();
while ($falta = mysqli_fetch_assoc($faltas_result_mai)) {
  $faltas_array_mai[$falta['aluno_id']] = $falta['faltas'];
}

$month_jun = "06"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_jun = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_jun' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_jun = mysqli_query($conn, $faltas_query_jun);

$faltas_array_jun = array();
while ($falta = mysqli_fetch_assoc($faltas_result_jun)) {
  $faltas_array_jun[$falta['aluno_id']] = $falta['faltas'];
}

$month_jul = "07"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_jul = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_jul' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_jul = mysqli_query($conn, $faltas_query_jul);

$faltas_array_jul = array();
while ($falta = mysqli_fetch_assoc($faltas_result_jul)) {
  $faltas_array_jul[$falta['aluno_id']] = $falta['faltas'];
}

$month_ago = "08"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_ago = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_ago' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_ago = mysqli_query($conn, $faltas_query_ago);

$faltas_array_ago = array();
while ($falta = mysqli_fetch_assoc($faltas_result_ago)) {
  $faltas_array_ago[$falta['aluno_id']] = $falta['faltas'];
}

$month_set = "09"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_set = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_set' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_set = mysqli_query($conn, $faltas_query_set);

$faltas_array_set = array();
while ($falta = mysqli_fetch_assoc($faltas_result_set)) {
  $faltas_array_set[$falta['aluno_id']] = $falta['faltas'];
}

$month_out = "10"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_out = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_out' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_out = mysqli_query($conn, $faltas_query_out);


$faltas_array_out = array();
while ($falta = mysqli_fetch_assoc($faltas_result_out)) {
  $faltas_array_out[$falta['aluno_id']] = $falta['faltas'];
}

$month_nov = "11"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_nov = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_nov' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_nov = mysqli_query($conn, $faltas_query_nov);


$faltas_array_nov = array();
while ($falta = mysqli_fetch_assoc($faltas_result_nov)) {
  $faltas_array_nov[$falta['aluno_id']] = $falta['faltas'];
}

$month_dez = "12"; // Exemplo, pode ser substituído por uma variável com o mês desejado
$faltas_query_dez = "SELECT aluno_id, disciplina, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND SUBSTRING(data, 4, 2) = '$month_dez' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result_dez = mysqli_query($conn, $faltas_query_dez);


$faltas_array_dez = array();
while ($falta = mysqli_fetch_assoc($faltas_result_dez)) {
  $faltas_array_dez[$falta['aluno_id']] = $falta['faltas'];
}




$alunos_query = "SELECT id, nome, turma_id, escola FROM alunos WHERE turma_id = '$turma_id' AND escola = '$escola'";
$alunos_result = mysqli_query($conn, $alunos_query);

while ($aluno = mysqli_fetch_assoc($alunos_result)) {
  $faltas_fev = isset($faltas_array[$aluno['nome']]) ? $faltas_array[$aluno['nome']] : 0;
  $faltas_mar = isset($faltas_array_mar[$aluno['nome']]) ? $faltas_array_mar[$aluno['nome']] : 0;
  $faltas_abr = isset($faltas_array_abr[$aluno['nome']]) ? $faltas_array_abr[$aluno['nome']] : 0;
  $faltas_mai = isset($faltas_array_mai[$aluno['nome']]) ? $faltas_array_mai[$aluno['nome']] : 0;
  $faltas_jun = isset($faltas_array_jun[$aluno['nome']]) ? $faltas_array_jun[$aluno['nome']] : 0;
  $faltas_jul = isset($faltas_array_jul[$aluno['nome']]) ? $faltas_array_jul[$aluno['nome']] : 0;
  $faltas_ago = isset($faltas_array_ago[$aluno['nome']]) ? $faltas_array_ago[$aluno['nome']] : 0;
  $faltas_set = isset($faltas_array_set[$aluno['nome']]) ? $faltas_array_set[$aluno['nome']] : 0;
  $faltas_out = isset($faltas_array_out[$aluno['nome']]) ? $faltas_array_out[$aluno['nome']] : 0;
  $faltas_nov = isset($faltas_array_nov[$aluno['nome']]) ? $faltas_array_nov[$aluno['nome']] : 0;
  $faltas_dez = isset($faltas_array_dez[$aluno['nome']]) ? $faltas_array_dez[$aluno['nome']] : 0;
  $nota_total = isset($notas_array_media[$aluno['nome']]) ? $notas_array_media[$aluno['nome']] : 0;
  $nota_total_rec = isset($notas_array_rec[$aluno['nome']]) ? $notas_array_rec[$aluno['nome']] : 0;
  $nota_total_total = isset($notas_array_total[$aluno['nome']]) ? $notas_array_total[$aluno['nome']] : 0;
  
  if($bimestre == 1){
  $total_faltas = $faltas_fev + $faltas_mar + $faltas_abr;
  }
  
  if($bimestre == 2){
    $total_faltas = $faltas_mai + $faltas_jun + $faltas_jul;
  }
  
  if($bimestre == 3){
    $total_faltas = $faltas_ago + $faltas_set + $faltas_out;
  }
  
    if($bimestre == 4){
    $total_faltas = $faltas_nov + $faltas_dez;
  }
  
  $notas = isset($notas_array[$aluno['nome']]) ? $notas_array[$aluno['nome']] : array(
    'av1' => 0,
    'rec1' => 0,
    'av2' => 0,
    'rec2' => 0,
    'av3' => 0,
    'rec3' => 0
  );

  $falta_color_fev = "";
  if ($faltas_fev > 0) {
    $falta_color_fev = "color:red;";
  }

  $falta_color_mar = "";
  if ($faltas_mar > 0) {
    $falta_color_mar = "color:red;";
  }

  $falta_color_abr = "";
  if ($faltas_abr > 0) {
    $falta_color_abr = "color:red;";
  }

  $falta_color_mai = "";
  if ($faltas_mai > 0) {
    $falta_color_mai = "color:red;";
  }

  $falta_color_jun = "";
  if ($faltas_jun > 0) {
    $falta_color_jun = "color:red;";
  }

  $falta_color_jul = "";
  if ($faltas_jul > 0) {
    $falta_color_jul = "color:red;";
  }
  
  $falta_color_jul = "";
  if ($faltas_jul > 0) {
    $falta_color_jul = "color:red;";
  }
  
  $falta_color_ago = "";
  if ($faltas_ago > 0) {
    $falta_color_ago = "color:red;";
  }
  
  $falta_color_set = "";
  if ($faltas_set > 0) {
    $falta_color_set = "color:red;";
  }
  
  $falta_color_out = "";
  if ($faltas_out > 0) {
    $falta_color_out = "color:red;";
  }
  
    $falta_color_nov = "";
  if ($faltas_nov > 0) {
    $falta_color_nov = "color:red;";
  }
  
    $falta_color_dez = "";
  if ($faltas_dez > 0) {
    $falta_color_dez = "color:red;";
  }

  $falta_color_total = "";
  if ($total_faltas > 0) {
    $falta_color_total = "color:red;";
  }



  echo "<tr>";
  echo "<td class='text-center withBorder'><a href='./relatorioIndividual.php?nome={$aluno['nome']}'> {$aluno['id']}</a></td>";
  echo "<td class='withBorder'><a href='./relatorioIndividual.php?nome={$aluno['nome']}&disciplina=$disciplinaAtual&turma=$turma_id&bimestre=$bimestre'> {$aluno['nome']}</a></td>";
  if($bimestre == 1){
    echo "<td class='text-center withBorder' style='$falta_color_fev'>{$faltas_fev}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_mar'>{$faltas_mar}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_abr'>{$faltas_abr}</td>";
  }
  if($bimestre == 2){
    echo "<td class='text-center withBorder' style='$falta_color_mai'>{$faltas_mai}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_jun'>{$faltas_jun}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_jul'>{$faltas_jul}</td>";
  }
  
  if($bimestre == 3){
    echo "<td class='text-center withBorder' style='$falta_color_ago'>{$faltas_ago}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_set'>{$faltas_set}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_out'>{$faltas_out}</td>";
  }
  
    if($bimestre == 4){
    echo "<td class='text-center withBorder'style='$falta_color_nov'>{$faltas_nov}</td>";
    echo "<td class='text-center withBorder'style='$falta_color_dez'>{$faltas_dez}</td>";
  }



  echo "<td class='text-center withBorder'>{$notas['av1']}</td>";
  echo "<td class='text-center withBorder'>{$notas['rec1']}</td>";
  echo "<td class='text-center withBorder'>{$notas['av2']}</td>";
  echo "<td class='text-center withBorder'>{$notas['rec2']}</td>";
  echo "<td class='text-center withBorder'>{$notas['av3']}</td>";
  echo "<td class='text-center withBorder'>{$notas['rec3']}</td>";
  echo "<td class='text-center withBorder'>{$nota_total}</td>";
  echo "<td class='text-center withBorder'>{$nota_total_rec}</td>";
  echo "<td class='text-center withBorder'>{$nota_total_total}</td>";
  echo "<td class='text-center withBorder' style='$falta_color_total'>{$total_faltas}</td>";
  echo "</tr>";
}


?>

<table class="table bg-light mb-0 mt-0 small">
        <thead>
          <tr>
            <th>DATA</th>
            <th>CONTEÚDO DADO</th>
          </tr>
        </thead>
        <tbody>
         
        <?php   
        $sql = "SELECT data, GROUP_CONCAT(conteudo SEPARATOR ', ') AS conteudos 
        FROM conteudo 
        WHERE insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND turma = '$turma_id'  GROUP BY data";

$result = $conexao->query($sql);

  while($row = $result->fetch_assoc()) {
    echo "<tr><td class='withBorder bg-white' >" . $row["data"] . "</td><td class='bg-white'>" . $row["conteudos"] . "</td></tr>";
  }?>

        </tbody>
    </table>

    <h1 class="h1 mb-2 mt-2 bold text-center text-primary"><strong>FALTAS</strong></h1>

    <table class="table bg-light mb-0 mt-0 small">
        <thead>
          <tr>
            <th>ALUNO</th>
            <th>FALTAS</th>
          </tr>
          </thead>
          <tbody>
          <?php
  $queryy = "SELECT alunos.nome, GROUP_CONCAT(DISTINCT CONCAT(SUBSTRING(faltas.data, 1, 5)) ORDER BY STR_TO_DATE(faltas.data, '%d/%m/%Y') SEPARATOR ', ') as faltas FROM alunos LEFT JOIN faltas ON alunos.nome = faltas.aluno_id WHERE faltas.id = 1 AND faltas.insertBy = '$user_id' AND faltas.disciplina = '$disciplinaAtual' AND faltas.turma_id = '$turma_id'  AND alunos.escola = '$escola' GROUP BY alunos.nome"; // utilize o filtro necessário
  $resultt = mysqli_query($conexao, $queryy);
  while ($row = mysqli_fetch_assoc($resultt)) {
    echo "<tr>";
    echo "<td class='withBorder bg-white'>".$row['nome']."</td>";
    echo "<td class='bg-white'>".$row['faltas']."</td>";
    echo "</tr>";
  }
?>
          </tbody>
        
    </table>

        </tbody>
    </table>

    <div class="text-center sans-serif m-5"> <hr class="mt-5 mb-2 m-auto w-50">Assinatura do Professor</div>
   <div class="d-flex justify-content-center m-5 print-btn">
        <button class="btn btn-primary px-5" onclick="window.print()">Imprimir</button>
   </div>
</body>
</html>