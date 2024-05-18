<?php
include ("conexao.php");
$aluno_nome = $_GET["nome"];
$user_id = $_SESSION['user_id'];
$disciplinaAtual = $_GET['disciplina'];
$turma = $_GET['turma'];
$escola = $_SESSION['escola'];
$bimestre = $_GET['bimestre'];
$loc = $_GET['loc'];
$data = $_GET['data'];

$query_status = "SELECT * FROM `whitelist` WHERE aluno_id = '$aluno_nome' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";
$result_status = mysqli_query($conexao, $query_status);

$query_apelido = "SELECT * FROM `apelidos` WHERE aluno_id = '$aluno_nome' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";
$result_apelidos = mysqli_query($conexao, $query_apelido);

$apelido = 'NENHUM APELIDO';

$status = 'ATIVO';


if(mysqli_num_rows($result_apelidos) > 0) {
    while($row = mysqli_fetch_assoc($result_apelidos)) {
        $apelido = $row['apelido'];
    }
}else{
    $apelido = 'NENHUM APELIDO';
}

if (mysqli_num_rows($result_status) > 0) {
    while ($row = mysqli_fetch_assoc($result_status)) {
        $status = $row['status'];
    }
}else{
    $status = 'ATIVO';
}

if($status == 'ATIVO'){
    $status = 'ATIVO';
    $status_color = 'bg-success';
}

if($status == 'NF'){
    $status = 'NÃO FREQUENTA';
    $status_color = 'bg-danger';
}

if($status == 'EV'){
    $status = 'EVADIDO';
    $status_color = 'bg-warning';
}

if($status == 'TR'){
    $status = 'TRANSFERIDO';
    $status_color = 'bg-warning';
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
    <title>Relatório Individual</title>
</head>
<body class="bg-blueLight2">
    <div class="viewAreaCall">
<h1 class="text-center mt-5">Relatório Individual</h1>
<p class="text-center text-muted">(<b><?php echo $disciplinaAtual ?>)</b></p>

                <div class="d-flex justify-content-center flex-column align-items-center mb-5">
                    <span class="badge bg-primary my-1"><?php echo $aluno_nome ." ($turma)";?></span>
                    <span class="badge bg-secondary my-1"><?php echo $apelido?></span>
                    <span class="badge <?php echo $status_color?> my-1 "><?php echo $status;?></span>
                </div>

                <div class="bg-white p-3 mb-3 mx-2 widget-radius">
                <h5 class="h5 text-center text-danger"><b>FALTAS</b></h5>
    <?php


$query = "SELECT alunos.nome, faltas.data, COALESCE(COUNT(faltas.id), 0) AS faltas FROM alunos
LEFT JOIN faltas ON alunos.nome = faltas.aluno_id AND faltas.id = 1
WHERE alunos.nome = '$aluno_nome' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND alunos.escola = '$escola'  AND bimestre = '$bimestre'
GROUP BY alunos.nome, faltas.data";

$result = mysqli_query($conn, $query);

$query2 = "SELECT * FROM notas WHERE aluno_id = '$aluno_nome' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";

$result2 = mysqli_query($conn, $query2);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn));
}

echo "<table class='table table-responsive table-bordered'>";
echo "<thead>";
echo "<tr>";
echo "<th class='text-center withBorder'>Qtd. Faltas</th>";
echo "<th class='text-center withBorder'>Data</th>";
echo "</tr>";
echo "</thead>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td class='text-center withBorder'>" . $row["faltas"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row["data"] . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

?>
<div class="bg-white p-3 mb-3 mx-2 widget-radius">
<h5 class="h5 text-center text-primary"><b>NOTAS</b></h5>

<?php

echo "<table class='table table-responsive table-bordered'>";
echo "<thead>";
echo "<tr>";
echo "<th class='text-center'>AV1</th>";
echo "<th class='text-center'>AV2</th>";
echo "<th class='text-center'>AV3</th>";
echo "<th class='text-center'>REC1</th>";
echo "<th class='text-center'>REC2</th>";
echo "<th class='text-center'>REC3</th>";
echo "</tr>";
echo "</thead>";

while ($row2 = mysqli_fetch_assoc($result2)) {
    echo "<tr>";
    echo "<td class='text-center withBorder'>" . $row2["AV1"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row2["AV2"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row2["AV3"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row2["REC1"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row2["REC2"] . "</td>";
    echo "<td class='text-center withBorder'>" . $row2["REC3"] . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

?>

<div class="bg-white p-3 mb-3 mx-2 widget-radius">
<h5 class="h5 text-center text-secondary"><b>TOTAL</b></h5>

<?php

$query2 = "SELECT * FROM notas WHERE aluno_id = '$aluno_nome' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";

$result2 = mysqli_query($conn, $query2);

$total_av = 0;
while ($row2 = mysqli_fetch_assoc($result2)) {
    $total_av += intval($row2["AV1"]) + intval($row2["AV2"]) + intval($row2["AV3"]);
}

$query3 = "SELECT COALESCE(COUNT(*), 0) AS faltas FROM faltas WHERE aluno_id = '$aluno_nome' AND id = '1' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual' AND bimestre = '$bimestre'";

$result3 = mysqli_query($conn, $query3);

$total_faltas = mysqli_fetch_assoc($result3)["faltas"];

$total_rec = 0;
$result2 = mysqli_query($conn, $query2);
while ($row2 = mysqli_fetch_assoc($result2)) {
    $total_rec += intval($row2["REC1"]) + intval($row2["REC2"]) + intval($row2["REC3"]);
}

$media_av = $total_av;

if($media_av > $total_rec){
    $nota_recuperada = $media_av;
}

if($media_av < $total_rec){
    $nota_recuperada = $total_rec;
}

if ($media_av == 0 && $total_rec == 0) {
    $nota_recuperada = 0;
}

echo "<table class='table table-responsive table-bordered'>";
echo "<thead>";
echo "<tr>";
echo "<th class='text-center'>FALTAS</th>";
echo "<th class='text-center'>MÉDIA</th>";
echo "<th class='text-center'>REC.</th>";
echo "<th class='text-center'>NOTA RECUPERADA</th>";
echo "</tr>";
echo "</thead>";
echo "<tr>";
echo "<td class='text-center withBorder'>$total_faltas</td>";
echo "<td class='text-center withBorder'>$media_av</td>";
echo "<td class='text-center withBorder'>$total_rec</td>";
echo "<td class='text-center withBorder'>$nota_recuperada</td>";
echo "</tr>";
echo "</table>";
echo "</div>";



mysqli_free_result($result);

mysqli_close($conn);

?>

<div class="bg-white p-3 mb-3 mx-2 widget-radius">
  <form action="atualizar_apelidos.php" method="post">
    <h5 class="h5 text-center text-info"><b>APELIDO / NOME SOCIAL</b></h5>
            <div class="form-floating">
        <input type="text" class="form-control" id="floatingInputValue" name='apelido' value="<?php echo $apelido; ?>">
        <label for="floatingInputValue">APELIDO OU NOME SOCIAL</label>
        <p class="text-muted text-center small mt-1">(DEIXE EM BRANCO PARA DESFAZER ALTERAÇÕES)</p>
        </div>

        <?php
        echo '<input type="hidden" name="aluno_nome" value="'.$aluno_nome.'">';
        echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
        echo '<input type="hidden" name="disciplinaAtual" value="'.$disciplinaAtual.'">';
        echo '<input type="hidden" name="turma" value="'.$turma.'">';
        echo '<input type="hidden" name="escola" value="'.$escola.'">';
        echo '<input type="hidden" name="bimestre" value="'.$bimestre.'">';
        echo '<input type="hidden" name="loc" value="'.$loc.'">';

        echo '<input type="hidden" name="loc" value="'.$loc.'">';
        echo '<input type="hidden" name="data" value="'.$data.'">';
        ?>

    <div class="d-flex align-items-center justify-content-center mt-1">
        <input class="btn btn-primary mb-1 px-5 text-white" type="submit" value="Atualizar">
    </div>
  </form>
</div>







<div class="bg-white p-3 mb-5 mx-2 widget-radius">
  <form action="atualizar_whitelist.php" method="post">
    <h5 class="h5 text-center text-warning"><b>ATUALIZAR STATUS</b></h5>
    <div class="form-floating">
    <div class="form-floating">
  <select class="form-select" id="floatingSelect" name="status">
    <option value="AV" <?php if ($status == 'ATIVO') echo 'selected'; ?>>Ativo</option>
    <option value="NF" <?php if ($status == 'NÃO FREQUENTA') echo 'selected'; ?>>Não frequenta (NF)</option>
    <option value="TR" <?php if ($status == 'TRANSFERIDO') echo 'selected'; ?>>Transferido (TR)</option>
    <option value="EV" <?php if ($status == 'EVADIDO') echo 'selected'; ?>>Evadido (EV)</option>
  </select>
  <label for="floatingSelect">STATUS</label>
</div>

</div>

        <?php
        echo '<input type="hidden" name="aluno_nome" value="'.$aluno_nome.'">';
        echo '<input type="hidden" name="user_id" value="'.$user_id.'">';
        echo '<input type="hidden" name="disciplinaAtual" value="'.$disciplinaAtual.'">';
        echo '<input type="hidden" name="turma" value="'.$turma.'">';
        echo '<input type="hidden" name="escola" value="'.$escola.'">';
        echo '<input type="hidden" name="bimestre" value="'.$bimestre.'">';
        echo '<input type="hidden" name="loc" value="'.$loc.'">';

        echo '<input type="hidden" name="loc" value="'.$loc.'">';
        echo '<input type="hidden" name="data" value="'.$data.'">';
        ?>
    <div class="d-flex align-items-center justify-content-center mt-2">
        <input class="btn btn-primary mx-1 px-5 text-white" type="submit" value="Atualizar">
    </div>
  </form>
</div>

</body>
</html>


