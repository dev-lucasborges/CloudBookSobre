<?php
    include('conexao.php');
    $user_id = $_SESSION['user_id'];
    $loc = $_GET['loc'];
    
    if ($loc == 'P' || $loc == 'C' || $loc == 'F') {
        $call = 'data.php?';
    } else {
        $call = 'turmaOut.php?';
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
    <title>Selecione a disciplina</title>
</head>
<body>

<div class="container">
    
    <div class="mx-auto text-center box-v">
        <h3 class="mb-4 h3">Selecione a disciplina:</h3>
        <form action="bimestre.php" method="post">
        <div class="form-floating">

  <select name='disciplina' class="form-select" id="floatingSelect" aria-label="Floating label select example">
    <?php
        $sql = "SELECT * FROM usuarios WHERE id = '$user_id'";
        $result = mysqli_query($conexao, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
 
          $disciplinas = explode(',', $row['disciplinas']);

          foreach ($disciplinas as $disciplina) {
              $disciplina = trim($disciplina);
              if (!empty($disciplina)) {
                echo "<option selected value='".$disciplina."'>".$disciplina."</option>";
              }
            }
        }
        echo '<input type="hidden" name="loc" value="'.$loc.'"';
    ?>
  </select>
  <label for="floatingSelect">Disciplina</label>
  <button class="btn btn-primary px-3 mt-2" type="submit">Próximo</button>
  
</div>
</form>
    </div>
    </div>


</body>
</html>