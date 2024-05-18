<?php
    include('conexao.php');
    $bimestre = $_GET['bimestre'];
    $disciplina = $_GET['disciplina'];
    $loc = $_GET['loc'];
    $user_id = $_SESSION['user_id'];

    if($data = $_GET['data']){
        $data = $_GET['data'];
    }else{
        $data = '';
    }

    $newLoc = '';

    if($loc == 'N'){
        $newLoc = 'notas.php';
    }

    if($loc == 'G'){
        $newLoc = 'relatorioGeral.php';
    }

    if($loc == 'R'){
        $newLoc = 'relatorio.php';
    }

    if($loc == 'F'){
        $newLoc = 'faltas.php';
    }

    if($loc == 'C'){
        $newLoc = 'chamadasAnteriores.php';
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
    <title>Selecione a turma</title>
</head>
<body>

<div class="container">

    <div class="mx-auto text-center box-v bg-white">
        <h2 class="">Selecione a turma:</h2>
        <?php
        $sql = "SELECT * FROM usuarios WHERE id = '$user_id'";
        $result = mysqli_query($conexao, $sql);
        $primeiro_ano = array();
        $segundo_ano = array();
        $terceiro_ano = array();
        $outros = array();
        while ($row = mysqli_fetch_assoc($result)) {
            // Divide a string da coluna turmas em várias turmas
            $turmas = explode(',', $row['turmas']);

            foreach ($turmas as $turma) {
            $turma = trim($turma);
            if (!empty($turma)) {
                // Verifica o primeiro caractere da turma
                $primeiro_caractere = substr($turma, 0, 1);
                if ($primeiro_caractere == '1') {
                $primeiro_ano[] = $turma;
                } elseif ($primeiro_caractere == '2') {
                $segundo_ano[] = $turma;
                } elseif ($primeiro_caractere == '3') {
                $terceiro_ano[] = $turma;
                } elseif ($primeiro_caractere == 'C' && substr($turma, 1, 1) == 'N') {
                $outros[] = $turma;
                }
            }
            }
        }
  
  // Exibe as turmas separadas por ano e CN
  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>Primeiro ano:</h3>';
  foreach ($primeiro_ano as $turma) {
    
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$newLoc.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
    
  }
  echo '</div>';
  
  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>Segundo ano:</h3>';
  foreach ($segundo_ano as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$newLoc.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';

  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>Terceiro ano:</h3>';
  foreach ($terceiro_ano as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$newLoc.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';

  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>CN:</h3>';
  foreach ($outros as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$newLoc.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';
?>
    </div>
    </div>


</body>
</html>