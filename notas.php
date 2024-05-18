<?php
include('conexao.php');
$turma = $_GET['turma'];
$disciplina = $_GET['disciplina'];
$escola = $_SESSION['escola'];
$bimestre = $_GET['bimestre'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <link rel="stylesheet" href="style.css?<?php echo $cssVersion?>">
    <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>
<div class="viewAreaCall">
<form action="lançarNotas.php" method="post">
<h1 class="text-center mt-5">Notas</h1>
<p class="text-center text-muted">(<b><?php echo $disciplina ?>)</b></p>
<div class="text-center"><span class="badge text-bg-primary mx-1"> <?php echo $turma?></span><span class="badge text-bg-primary mx-1"> <?php echo $bimestre?>° BIMESTRE</span></div>

<input type="hidden" name="turma" value="<?php echo $turma; ?>">
<div class="table table-responsive">
  <table class="table table-striped mt-5 table-responsive">
    <thead class="bg-blueLight">
      <th class="th">Nome</th>
      <th class="th">AV1</th>
      <th class="th">REC1</th>
      <th class="th">AV2</th>
      <th class="th">REC2</th>
      <th class="th">AV3</th>
      <th class="th">REC3</th>
    </thead>
    <input type="hidden" name="professor_id" value="<?php echo $user_id; ?>">
    <?php
      $sql = "SELECT a.nome, n.av1, n.rec1, n.av2, n.rec2, n.av3, n.rec3, w.status
              FROM alunos a
              LEFT JOIN notas n ON a.nome = n.aluno_id AND n.insertBy = '$user_id' AND n.disciplina = '$disciplina' AND n.bimestre = '$bimestre'
              LEFT JOIN whitelist w ON a.nome = w.aluno_id AND w.insertBy = '$user_id' AND w.disciplina = '$disciplina' AND w.bimestre = '$bimestre'
              WHERE a.turma_id = '$turma' AND a.escola = '$escola'";
      $result = mysqli_query($conexao, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $nome = $row['nome'];
          $status = $row['status'];
          $nome_formatado = $nome;
          $readonly = ''; // variável para armazenar o valor da propriedade 'readonly'
          $corNome = '';
          if (!empty($status)) {
            $nome_formatado = "<span class='text-danger'>$nome <b>($status)</b></span>";
          }

          if (!empty($row['status'])) {
            $readonly = 'readonly'; // Define 'readonly' se houver um status na whitelist
            $corNome = 'text-muted';
          }


          echo '<tr>';
          echo "<td><a href='./relatorioIndividual.php?loc=notas&turma=".$turma."&disciplina=".$disciplina."&bimestre=".$bimestre."&nome=".$nome."'>$nome_formatado</td>";
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['av1'] ?? '').'" name="AV1[' . $nome . ']" id="AV1-' . $nome . '" '.$readonly.'></td>';
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['rec1'] ?? '').'" name="REC1['.$nome.']" id="REC1-'.$nome.'" '.$readonly.'></td>';
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['av2'] ?? '').'" name="AV2[' . $nome . ']" id="AV2-' . $nome . '" '.$readonly.'></td>';
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['rec2'] ?? '').'" name="REC2['.$nome.']" id="REC2-'.$nome.'" '.$readonly.'></td>';
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['av3'] ?? '').'" name="AV3[' . $nome . ']" id="AV3-' . $nome . '" '.$readonly.'></td>';
          echo '<td class="text-center withBorder"><input class="form-control form-control-sm text-center '.$corNome.'" maxlength="3" value="'.($row['rec3'] ?? '').'" name="REC3['.$nome.']" id="REC3-'.$nome.'" '.$readonly.'></td>';
          echo '<input type="hidden" name="aluno[]" value="' . $nome . '">';
          echo '<input type="hidden" name="turma" value="' . $turma . '">';
          echo '<input type="hidden" name="disciplina" value="' . $disciplina . '">';
          echo '<input type="hidden" name="bimestre" value="' . $bimestre . '">';
        }
      }
    ?>
  </table>
</div>
<div class="d-flex justify-content-center">
  <input class="btn btn-primary mb-5 w-75 pt-2 pb-2" type="submit" value="Enviar">
</div>
</form>
</div>
</div>
</body>
</html>
