<?php
session_start(); // Inicia a sessão
include('conn.php');

$error_msg = ''; // Define a variável $error_msg como vazia

if (isset($_POST['submit'])) {
    // Recebe as informações do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se as informações de login estão corretas
    $query = "SELECT * FROM usuarios WHERE nome_usuario = '$username' AND senha = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Armazena as informações do usuário na sessão
        $user = mysqli_fetch_assoc($result);

        if ($user['status'] == 'ativo' || $user['status'] == 'pendente') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['escola'] = $user['escola'];

            // Redireciona para a página restrita
            header('Location: painel.php');
            exit();
        } elseif ($user['status'] == 'inativo') {
            $error_msg = 'Usuário inativo';
        }
    } else {
        // Define a mensagem de erro
        $error_msg = 'Usuário ou senha inválidos';
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
} else {
    // Limpa a variável $error_msg se não houver erros
    $error_msg = '';
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=1.3 ">
    <link rel="stylesheet" href="./css/bootstrap.css?v=1.3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>CloudBook</title>
</head>
<body>


<div class="viewArea">
<div class="container">
<div class="video-container">
<h1 class="loginLogo">CloudBook</h1>

</div>
    
    <div class="mx-auto w-100 p-3 rounded">
    <form method="post">

  <div class="form-floating userinput">
  <input type="text" name="username" class="form-control" id="floatingInput" value="<?php if (isset($_COOKIE['usuario'])){ $usuario = $_COOKIE['usuario']; echo "$usuario"; } ?>">
  <label for="floatingInput">Usuário</label>
</div>
<div class="form-floating mb-2 passinput">
  <input type="password" name="password" class="form-control" id="floatingPassword" value="<?php if (isset($_COOKIE['senha'])){ $senha = $_COOKIE['senha']; echo "$senha"; } ?>">
  <label for="floatingPassword">Senha</label>
</div>

<?php if (!empty($error_msg)): ?>
<div class="error-container d-flex mx-auto justify-content-center mb-2 px-2 small">
    <span class="error-msg  w-100 text-center "><?php echo $error_msg; ?></span>
</div>
<?php endif; ?>

  <button type="submit" name="submit" class="btn btn-primary w-100">Entrar</button>
</form>
    </div>
    </div>



    </div>
</body>
</html>
