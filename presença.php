<?php
include('conexao.php');

$data = $_GET['data'];
$turma = $_GET['turma'];
$disciplina = $_GET['disciplina'];
$bimestre = $_GET['bimestre'];
$escola = $_SESSION['escola'];
$user_id = $_SESSION['user_id'];

$queryAlunos = "SELECT nome, escola FROM alunos WHERE turma_id = '$turma' AND escola = '$escola'";
$resultadoAlunos = mysqli_query($conexao, $queryAlunos);
$alunos = array();

while ($aluno = mysqli_fetch_assoc($resultadoAlunos)) {
  $alunos[] = $aluno;
}

$queryWhitelist = "SELECT aluno_id, status FROM whitelist WHERE insertBy = '$user_id' AND disciplina = '$disciplina' AND bimestre = '$bimestre' AND turma_id = '$turma'";
$resultadoWhitelist = mysqli_query($conexao, $queryWhitelist);
$alunosWhitelist = array();
$whitelist = array();

while ($alunoWhitelist = mysqli_fetch_assoc($resultadoWhitelist)) {
  $alunosWhitelist[] = $alunoWhitelist['aluno_id'];
  $whitelist[] = $alunoWhitelist;
}

$queryApelido = "SELECT aluno_id, apelido FROM apelidos WHERE insertBy = '$user_id' AND disciplina = '$disciplina' AND bimestre = '$bimestre' AND turma_id = '$turma'";
$resultadoApelido = mysqli_query($conexao, $queryApelido);
$alunosApelido = array();

while ($alunoApelido = mysqli_fetch_assoc($resultadoApelido)) {
  $alunosApelido[$alunoApelido['aluno_id']] = $alunoApelido;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chamada</title>
  <link rel="stylesheet" href="style.css?<?php echo $cssVersion ?>">
  <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="./css/bootstrap.css">
</head>

<body>
  <div class="viewAreaCall">
    <form action="cadastrar.php" method="post">
      <div class="table table-responsive">
        <table class="table table-striped mt-2">
          <thead>
            <th>Nome</th>
            <th>Falta</th>
          </thead>
          <h1 class="text-center mt-5">Chamada</h1>
          <p class="text-center text-muted">(<b><?php echo $disciplina ?></b>)</p>

          <div class="text-center">
            <span class="badge text-bg-primary mx-1"><?php echo $turma ?></span>
            <span class="badge text-bg-primary mx-1"><?php echo $data ?></span>
          </div>

          <input type="hidden" name="data" value="<?php echo $data; ?>">
          <input type="hidden" name="turma" value="<?php echo $turma; ?>">
          <input type="hidden" name="professor_id" value="<?php echo $user_id; ?>">
          <input type="hidden" name="bimestre" value="<?php echo $bimestre; ?>">
          <input type="hidden" name="disciplina" value="<?php echo $disciplina; ?>">
          <div class="form-floating mx-5 mt-2">
            <select class="form-select" name='quantidade'>
              <option value="1">1 aula</option>
              <option selected value="2">2 aulas</option>
              <option value="3">3 aulas</option>
              <option value="4">4 aulas</option>
            </select>
            <label>Quantidade de aulas</label>
          </div>

          <ol>
            <?php
            $i = 1;
            foreach ($alunos as $aluno) {
              $nome = $aluno['nome'];
              $alunoId = $aluno['nome'];
              $apelidoInfo = isset($alunosApelido[$alunoId]) ? $alunosApelido[$alunoId] : null;
              $apelido = $apelidoInfo ? $apelidoInfo['apelido'] : '';
              $frequenta = in_array($aluno['nome'], $alunosWhitelist); // Verifica se o aluno está na whitelist
              $nomeStyle = $frequenta ? 'text-danger' : ''; // Estilo do nome do aluno
              $inputDisabled = $frequenta ? 'style="pointer-events: none;"' : ''; // Habilita ou desabilita o input
              $status = '';

              if ($frequenta) {
                $key = array_search($aluno['nome'], $alunosWhitelist);
                $status = ' <b class="text-danger">('.$whitelist[$key]['status'].')</b>';
              }

              echo '<tr>';
              echo '<td><a href="relatorioIndividual.php?turma='.$turma.'&disciplina='.$disciplina.'&bimestre='.$bimestre.'&nome='.$nome.'&loc=chamada&data='.$data.'"><span class="text-muted small">' . $i . '.</span> <span class="' . $nomeStyle . '">' . ($apelido ? $apelido : $nome) . '</span>' . $status . '</a></td>';
              echo '<td>';
              echo '<div class="form-check form-switch">';
              echo '<input class="form-check-input" role="switch" type="checkbox" name="aluno_faltante[]" value="' . $nome . '" ' . ($frequenta ? 'checked' : '') . ' ' . $inputDisabled . '>';
              echo '</div>';
              echo '</td>';
              echo '</tr>';
              echo '<input type="hidden" name="aluno[]" value="' . $nome . '">';
              $i++;
            }
            ?>
          </ol>

          <script>
// Restaurar o estado dos checkboxes usando o armazenamento local (localStorage)
function restoreCheckboxState() {
  const checkboxes = document.querySelectorAll('input[name="aluno_faltante[]"]');
  checkboxes.forEach(checkbox => {
    const nome = checkbox.value;
    if (localStorage.getItem(nome) === 'true') {
      checkbox.checked = true;
    }
  });
}

// Execute a função de restaurar assim que a página for carregada
document.addEventListener('DOMContentLoaded', restoreCheckboxState);
</script>

        </table>
      </div>
      <div class="form-floating mx-3 mb-4">
        <input class="form-control" placeholder="Conteúdo dado" id="floatingTextarea" name="conteudo">
        <label for="floatingTextarea">Conteúdo dado</label>
      </div>
      <div class="d-flex justify-content-center">
        <input class="btn btn-primary mb-5 w-75 pt-2 pb-2" type="submit" value="Enviar">
      </div>
    </form>
  </div>
</body>

</html>
