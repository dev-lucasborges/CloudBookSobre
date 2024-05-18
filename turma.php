<?php
    include('conexao.php');

    $data = $_POST['data'];
    $data = date("d/m/Y", strtotime($data));
    $disciplina = $_POST['disciplina'];
    $bimestre = $_POST['bimestre'];
    $user_id = $_SESSION['user_id'];

    $loc = $_POST['loc'];
    
    if ($loc == 'C') {
      $call = 'chamadasAnteriores.php';
  } elseif ($loc == 'F') {
      $call = 'faltas.php';
  } else {
      $call = 'presença.php';
  }
  

?>

<!DOCTYPE html>
<html lang="en">
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
    <div class="d-flex align-items-center flex-column">
        <h3 class="h3 mb-0 text-center mt-1">Selecione a turma:</h3>
        <div class="badge text-bg-secondary mb-2 mx-auto">Data: <?php echo $data?></div>
    </div>
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
    
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$call.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
    
  }
  echo '</div>';
  
  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>Segundo ano:</h3>';
  foreach ($segundo_ano as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$call.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';

  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>Terceiro ano:</h3>';
  foreach ($terceiro_ano as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$call.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';

  echo '<div class=" p-3 rounded bg-blueLight3 my-1">';
  echo '<h3>CN:</h3>';
  foreach ($outros as $turma) {
    echo '<a class="p-2 m-1 bg-primary rounded text-white btn" href="'.$call.'?turma='.$turma.'&data='.$data.'&bimestre='.$bimestre.'&disciplina='.$disciplina.'">'.$turma.'</a>';
  }
  echo '</div>';
?>
        
    </div>

    
    </div>


</body>
</html>