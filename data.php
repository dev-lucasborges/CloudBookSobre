<?php
    include ("conexao.php");
    $loc = $_GET['loc'];
    $bimestre = $_GET['bimestre'];
    $disciplina = $_GET['disciplina'];

    if ($bimestre == 1) {
        $min_date = '2023-02-06';
        $max_date = '2023-05-05';
    } elseif ($bimestre == 2) {
        $min_date = '2023-05-06';
        $max_date = '2023-07-07';
    } elseif ($bimestre == 3) {
        $min_date = '2023-07-24';
        $max_date = '2023-09-27';
    } elseif ($bimestre == 4) {
        $min_date = '2023-09-28';
        $max_date = '2023-12-22';
    }

    $current_date = date('Y-m-d');

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
    <title>Selecione uma data</title>
</head>
<body>
    <div class="container">
    
    <div class="mx-auto text-center box-v">
        <h2 class="mb-3">Selecione uma data:</h2>
        <form action="turma.php" method="post">
    <input type="date" id="data" name="data" value="<?php echo $current_date; ?>" min="<?php echo $min_date; ?>" max="<?php echo $max_date; ?>">
    <input type="hidden" name="loc" value="<?php echo $loc;?>">
    <input type="hidden" name="bimestre" value="<?php echo $bimestre;?>">
    <input type="hidden" name="disciplina" value="<?php echo $disciplina;?>">
    <input class="btn btn-primary w-75 mt-2" type="submit"  value="Continuar">

    </div>
    </form>

    </div>
</body>
</html>
