<?php
    include('conexao.php');

    $loc = $_POST['loc'];
    $disciplina = $_POST['disciplina'];
    
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
    <title>Selecione o bimestre</title>
</head>
<body>

<div class="container">
    
    <div class="mx-auto text-center box-v">
        <h3 class="mb-4 h3">Selecione o bimestre:</h3>
        <a class="p-2 px-3 bg-primary rounded text-white" href="<?php echo $call;?>bimestre=1&loc=<?php echo $loc;?>&disciplina=<?php echo $disciplina;?>">1°</a>
        <a class="p-2 px-3 bg-primary rounded text-white" href="<?php echo $call;?>bimestre=2&loc=<?php echo $loc;?>&disciplina=<?php echo $disciplina;?>">2°</a>
        <a class="p-2 px-3 bg-primary rounded text-white" href="<?php echo $call;?>bimestre=3&loc=<?php echo $loc;?>&disciplina=<?php echo $disciplina;?>">3°</a>
        <a class="p-2 px-3 bg-primary rounded text-white" href="<?php echo $call;?>bimestre=4&loc=<?php echo $loc;?>&disciplina=<?php echo $disciplina;?>">4°</a>
    </div>
    </div>


</body>
</html>