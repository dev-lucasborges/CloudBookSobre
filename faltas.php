<?php
include('conexao.php');

$turma = $_GET['turma'];
$data = $_GET['data'];
$bimestre = $_GET['bimestre'];
$user_id = $_SESSION['user_id'];
$disciplina = $_GET['disciplina'];
$escola = $_SESSION['escola'];

$query = "SELECT alunos.nome, faltas.id AS falta_id, faltas.FJ AS justificada FROM alunos LEFT JOIN faltas ON alunos.nome = faltas.aluno_id AND faltas.data = '$data' AND faltas.bimestre = '$bimestre' AND faltas.disciplina = '$disciplina' WHERE alunos.turma_id = '$turma' AND alunos.escola = '$escola' ORDER BY alunos.nome";
$result = mysqli_query($conexao, $query);

$queryConteudos = "SELECT conteudo FROM conteudo WHERE data = '$data' AND insertBy = '$user_id' AND disciplina = '$disciplina'";
$resultConteudos = mysqli_query($conexao, $queryConteudos);
$conteudos = array();

while ($rowConteudo = mysqli_fetch_assoc($resultConteudos)) {
  $conteudos[] = $rowConteudo['conteudo'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?<?php echo $cssVersion?>">
    <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="./js/bootstrap.js"></script>
    <title>Justificar Faltas</title>
</head>
<body>

<div class="text-center  mb-3">
<h1 class="text-center mt-5 mb-0 fw-100">Justificar Faltas</h1>
<p class="text-center text-muted">(<b><?php echo $disciplina ?>)</b></p>
</div>

<div class="text-center"><span class="badge text-bg-primary mx-1"> <?php echo $turma?></span><span class="badge text-bg-danger mx-1"> <?php echo $data?></span></div>

<div class="viewAreaCall">
<table class="table table-striped mt-5">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Falta</th>
            <th class="text-center">FJ</th>
        </tr>
    </thead>
    <tbody>
    <?php
    echo '<form method="post" action="atualizar_faltas2.php">';
    $i = 1;
    $prev_aluno_nome = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $aluno_id = $row['nome'];
        $aluno_nome = $row['nome'];
        $falta_id = $row['falta_id'];
        $justificada = $row['justificada'];

        echo '<input type="hidden" name="falta_id[' . $aluno_id . ']" value="' . $falta_id . '">';
        echo '<input type="hidden" name="justificada[' . $aluno_id . ']" value="' . $justificada . '">';
        
        // Defina a variável $checked com base no valor de falta_id
        $checked = ($falta_id == 1) ? 'checked' : '';
        $justificadaChecked = ($justificada == 'justificada') ? 'checked' : '';
        
        echo '<tr>';
        
        if ($aluno_nome != $prev_aluno_nome) {
            echo '<td><span class="text-muted">' . $i . '. </span>' . $aluno_nome . '</td>';
            $i++;
        } else {
            echo '<td>' . $aluno_nome . '</td>';
        }

        echo '<td>';
        echo '<div class="form-check form-switch">';
        echo '<input class="form-check-input" role="switch" type="checkbox" name="alunos_faltantes[]" value="' . $aluno_id . '" ' . $checked . '>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="px-2 ">';
        echo '<input class="form-check-input2" type="checkbox" name="justificada_checkbox[' . $aluno_id . ']" value="justificada" ' . $justificadaChecked;
        
        // Adicione o atributo "disabled" condicionalmente se o checkbox de falta não estiver marcado
        if (empty($checked)) {
            echo ' disabled';
        }
        
        echo '>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        
        $prev_aluno_nome = $aluno_nome;
    }
    echo '<input type="hidden" name="data" value=' . $data . '>';
    echo '<input type="hidden" name="turma" value=' . $turma . '>';
    echo '<input type="hidden" name="bimestre" value=' . $bimestre . '>';
    echo '<input type="hidden" name="disciplina" value="' . $disciplina . '">';
    echo '<input type="hidden" name="user_id" value=' . $user_id . '>';
    ?>
    </tbody>
</table>
<h1 class="text-center mt-5 mb-3">Conteúdo(s)</h1>
<?php

foreach ($conteudos as $key => $conteudo) {
  $numeroConteudo = $key + 1;
  echo '<div class="form-floating mx-3 mb-4">';
  echo '<input class="form-control" type="text" name="conteudo[]" value="' . $conteudo . '">';
  echo '<label for="conteudo" class="form-label">Conteúdo ' . $numeroConteudo . '</label>';
  echo '</div>';
}

?>
<div class="d-flex justify-content-between px-3 mb-5">
    <button class='btn btn-secondary px-3 mx-1 w-50' type="reset">Cancelar</button>
    <button class='btn btn-primary px-3 mx-1 w-50' type="submit">Atualizar</button>
</div>


</form>

</div>

</body>
</html>
