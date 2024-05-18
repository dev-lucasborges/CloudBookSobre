<?php
include("conexao.php");
$turma = $_GET["turma"];
$disciplinaAtual = $_GET["disciplina"];
$escola = $_SESSION['escola'];
$bimestre = $_GET['bimestre'];
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
    <title>Resumo</title>
</head>
<body>
<div class="viewAreaCall">

<h1 class="text-center mt-5">Resumo</h1>
<p class="text-center text-muted">(<b><?php echo $disciplinaAtual ?>)</b></p>
<div class="text-center"><span class="badge text-bg-primary mx-1 mb-5"> <?php echo $turma?></span><span class="badge text-bg-primary mx-1"> <?php echo $bimestre?>° BIMESTRE</span></div>

    <table class="table table-responsive table-striped">
        <thead>
            <th>Nome</th>
            <th class='text-center'>Faltas</th>
            <th class='text-center'>NF</th>
        </thead>
        <tbody>
        
<?php
$user_id = $_SESSION['user_id'];

// Monta a consulta SQL
// Obtenha o número total de faltas para cada aluno
$faltas_query = "SELECT aluno_id, COALESCE(COUNT(id), 0) AS faltas FROM faltas WHERE id = 1 AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND faltas.bimestre = '$bimestre' GROUP BY aluno_id";
$faltas_result = mysqli_query($conn, $faltas_query);
$faltas_array = array();

while ($falta = mysqli_fetch_assoc($faltas_result)) {
  $faltas_array[$falta['aluno_id']] = $falta['faltas'];
}

$notas_query = "SELECT aluno_id, av1, av2, av3, rec1, rec2, rec3 FROM notas WHERE insertBy = '$user_id' AND notas.disciplina = '$disciplinaAtual' AND notas.bimestre = '$bimestre'";
$notas_result = mysqli_query($conn, $notas_query);
$notas_array = array();

while ($nota = mysqli_fetch_assoc($notas_result)) {
  $av1 = $nota['av1'];
  $av2 = $nota['av2'];
  $av3 = $nota['av3'];
  $rec1 = $nota['rec1'];
  $rec2 = $nota['rec2'];
  $rec3 = $nota['rec3'];

  // Verifica se o valor da recuperação é maior que a avaliação e atualiza a nota total
  if ($rec1 > $av1) {
    $av1 = $rec1;
  }
  if ($rec2 > $av2) {
    $av2 = $rec2;
  }
  if ($rec3 > $av3) {
    $av3 = $rec3;
  }

  $nota_total = intval($av1) + intval($av2) + intval($av3);

  $notas_array[$nota['aluno_id']] = $nota_total;
}

$alunos_query = "SELECT nome, turma_id, escola FROM alunos WHERE turma_id = '$turma' AND escola = '$escola'";
$alunos_result = mysqli_query($conn, $alunos_query);

while ($aluno = mysqli_fetch_assoc($alunos_result)) {
  $faltas = isset($faltas_array[$aluno['nome']]) ? $faltas_array[$aluno['nome']] : 0;
  $nota_total = isset($notas_array[$aluno['nome']]) ? $notas_array[$aluno['nome']] : 0;

  $falta_color = "";
  if ($faltas > 0) {
    $falta_color = "color:red;";
  }

  $nota_color = "";
  if ($nota_total >= 1 && $nota_total <= 4) {
    $nota_color = "color:red;";
  } elseif ($nota_total >= 5 && $nota_total <= 7) {
    $nota_color = "color:orange;";
  } elseif ($nota_total >= 8 && $nota_total <= 10) {
    $nota_color = "color:green;";
  }

  $whitelist_query = "SELECT * FROM whitelist WHERE aluno_id = '{$aluno['nome']} ' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";
  $whitelist_result = mysqli_query($conn, $whitelist_query);
  $whitelist_row = mysqli_fetch_assoc($whitelist_result);
  $is_whitelisted = $whitelist_row !== null;

  echo "<tr>";
  echo "<td>";

  if ($is_whitelisted) {
    echo "<a href='./relatorioIndividual.php?loc=resumo&turma=".$turma."&disciplina=".$disciplinaAtual."&bimestre=".$bimestre."&nome={$aluno['nome']}'><span class='text-danger''>
    {$aluno['nome']}";
    echo "<b> (";
    echo $whitelist_row['status'];
    echo ")</b></span></a>";
  } else {
    echo "<a href='./relatorioIndividual.php?loc=resumo&turma=".$turma."&disciplina=".$disciplinaAtual."&bimestre=".$bimestre."&nome={$aluno['nome']}'>{$aluno['nome']}</a>";
  }

  echo "</td>";
  echo "<td class='text-center withBorder' style='{$falta_color}'>{$faltas}</td>";
  echo "<td class='text-center withBorder' style='{$nota_color}'>{$nota_total}</td>";
  echo "</tr>";
}
?>
</tbody>
    </table>
</div>
</body>
</html>
