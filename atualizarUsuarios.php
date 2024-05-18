<?php
include('conexao.php');
$user_id = $_SESSION['user_id'];
if ( $user_id != '1') {
    header('Location: painel.php');
    exit();
}
?>
<?php

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os valores atualizados do formulário
    $id = $_POST['id'];
    $nomeUsuario = $_POST['nome_usuario'];
    $nivel = $_POST['nivel'];
    $status = $_POST['status'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $nomeCompleto = $_POST['nome_completo'];
    $dataCriacao = $_POST['data_criacao'];
    $escola = $_POST['escola'];
    $disciplinas = $_POST['disciplinas'];
    $turmas = $_POST['turmas'];

    // Atualiza as informações do usuário no banco de dados
    $query = "UPDATE usuarios SET 
                nome_usuario = '$nomeUsuario',
                nivel = '$nivel',
                status = '$status',
                senha = '$senha',
                nome = '$nome',
                nome_completo = '$nomeCompleto',
                data_criacao = '$dataCriacao',
                escola = '$escola',
                disciplinas = '$disciplinas',
                turmas = '$turmas'
              WHERE id = $id";
    $conn->query($query);

    // Redireciona para a página de listagem de usuários ou exibe uma mensagem de sucesso
    header("Location: adm.php");
    exit();
}

// Obtém o ID do usuário a ser atualizado
$id = $_GET['id'];

// Consulta o usuário com o ID fornecido
$query = "SELECT * FROM usuarios WHERE id = $id";
$result = $conn->query($query);
$usuario = $result->fetch_assoc();

// Fecha a conexão com o banco de dados
$conn->close();
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
    <title>Atualizar Usuário</title>
</head>
<body>
    

    <form class="box mt-3" method="POST" action="">
        <h1 class="h1 mb-3">Atualizar Usuário</h1>
        
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="nome_usuario" value="<?php echo $usuario['nome_usuario']; ?>">
        <label for="nome_usuario">Nome de Usuário:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="nivel" value="<?php echo $usuario['nivel']; ?>">
        <label for="nivel">Nível:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="status" value="<?php echo $usuario['status']; ?>">
        <label for="status">Status:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="password" name="senha" value="<?php echo $usuario['senha']; ?>">
        <label for="senha">Senha:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="nome" value="<?php echo $usuario['nome']; ?>">
        <label for="nome">Nome:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="nome_completo" value="<?php echo $usuario['nome_completo']; ?>">
        <label for="nome_completo">Nome Completo:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="date" name="data_criacao" value="<?php echo $usuario['data_criacao']; ?>">
        <label for="data_criacao">Data de Criação:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="escola" value="<?php echo $usuario['escola']; ?>">
        <label for="escola">Escola:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="disciplinas" value="<?php echo $usuario['disciplinas']; ?>">
        <label for="disciplinas">Disciplinas:</label>
        </div>

        <div class="form-floating mb-3">
        <input class="form-control" type="text" name="turmas" value="<?php echo $usuario['turmas']; ?>">
        <label for="turmas">Turmas:</label>
        </div>

        <button type="submit" class="btn btn-primary float-end px-5">Salvar</button>
    </form>
</body>
</html>
