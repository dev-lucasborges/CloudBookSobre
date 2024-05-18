<?php
include('conexao.php');
$user_id = $_SESSION['user_id'];
if ( $user_id != '1') {
    header('Location: painel.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?<?php echo $cssVersion?>">
    <link rel="stylesheet" href="./css/bootstrap.css?<?php echo $cssVersion?>\">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="./js/bootstrap.js"></script>
    <title>Inicio</title>

    <script>
        const date = new Date();
        var data = new Intl.DateTimeFormat('pt-BR', { timeZone: 'Brazil/East', day:'numeric' ,month:'short' }).format(date);
    </script>
</head>

<body>
    
<?php
  echo '<form class="box mt-3" method="post">';
echo '<div class="containerx z-index-1">';

echo '<h1 class="h1 mb-3"><strong>Novo usuário</strong></h1>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Usuário" name="nome_usuario" required>';
echo '<label>Usuário</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Nível de acesso" name="nivel" required>';
echo '<label>Nível de acesso</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Senha" name="senha" required>';
echo '<label>Senha</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Nome" name="nome" required>';
echo '<label>Nome</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Nome completo" name="nome_completo" required>';
echo '<label>Nome completo</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<select class="form-select" name="escola" required>';
echo "<option value='CE LUIZ REID'>CE LUIZ REID</option>";
echo "<option value='CE IRENE MEIRELLES'>CE IRENE MEIRELLES</option>";
echo '</select>';
echo '<label>Escola</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Disciplinas" name="disciplinas" required>';
echo '<label>Disciplinas</label>';
echo '</div>';

echo '<div class="form-floating mb-3">';
echo '<input type="text" class="form-control" placeholder="Turmas" name="turmas" required>';
echo '<label>Turmas</label>';
echo '</div>';


echo '<input type="hidden" class="form-control" name="loc"">';
echo '<button type="submit" class="btn btn-primary float-end px-5">Salvar</button>';
echo '</div>';
echo '</form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nome_usuario = $_POST['nome_usuario'];
    $status = 'ativo';
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $nivel = $_POST['nivel'];
    $nome_completo = $_POST['nome_completo'];
    $escola = $_POST['escola'];
    $disciplinas = $_POST['disciplinas'];
    $turmas = $_POST['turmas'];

    $query = "INSERT INTO `usuarios`(`nome_usuario`, `nivel`, `status`, `senha`, `nome`, `nome_completo`, `escola`, `disciplinas`, `turmas`, `data_criacao`) 
          VALUES ('$nome_usuario','$nivel','$status','$senha','$nome','$nome_completo','$escola','$disciplinas','$turmas', NOW())";
    mysqli_query($conn, $query);
    header('Location: adm.php');
}

?>
</body>