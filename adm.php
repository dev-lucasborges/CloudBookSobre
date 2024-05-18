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
    <div class="text-center my-5">
<?php
$hora_atual = date('H');
if ($hora_atual >= 6 && $hora_atual < 12) {
    echo "<h4>Bom dia, Lucas!</h4>";
} elseif ($hora_atual >= 12 && $hora_atual < 18) {
    echo "<h4>Boa tarde, Lucas!</h4>";
} else {
    echo "<h4><b>Boa noite, Lucas!</b></h4>";
}
?>
</div>
<h3 class="h3 ms-3 text-muted">Dashboard</h3>
<div class="d-flex flex-column align-items-center">
            <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-user"></i></div>
                <div class="flex-column">
                <div class="col">Professores</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM usuarios";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = 0;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    $result = $result - 1;
                    $valor = $result * 30;

                    echo $result;?> </div>
                    </div>
                </div>

                       <div class="d-flex flex-column"><a href="cadastrarUsuario.php"><i class="uil uil-plus action"></i></a></div>
                </div>
                
            

            <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-users-alt"></i></div>
                <div class="flex-column">
                <div class="col">Alunos</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM alunos";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = 0;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    echo $result;?></div>
                    </div>
                </div>
                </div>
                
                <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-user"></i></div>
                <div class="flex-column">
                <div class="col">Escolas</div>
                <div class="col text-black">2</div>
                    </div>
                </div>
                </div>
            </div>

            
            
            </div>

            
</div>
<h3 class="h3 ms-3 text-muted">Status</h3>
<?php
// Consulta SQL para obter os usuários ordenados por status
$sql = "SELECT * FROM usuarios ORDER BY status";
$result = $conn->query($sql);

// Verificação de erros na consulta SQL
if (!$result) {
    die('Erro ao obter os usuários: ' . $conn->error);
}

?>

    <table class="table table-responsive text-center">
        <tr>
            <th class="text-start">NOME</th>
            <th>STATUS</th>
            <th>AÇÃO</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td class="text-start"><a href="atualizarUsuarios.php?id='<?= $row['id'] ?>'"><?= $row['nome'] ?></a></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button class='btn btn-success' type="submit" name="status" value="ativo"><i class="uil uil-check px-2"></i></button>
                    <button class='btn btn-warning' type="submit" name="status" value="pendente"><i class="uil uil-clock-eight px-2"></i></button>
                    <button class='btn btn-danger' type="submit" name="status" value="inativo"><i class="uil uil-multiply px-2"></i></button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php

    // Verificação se o formulário foi submetido
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtenção dos dados do formulário
        $id = $_POST['id'];
        $status = $_POST['status'];

        // Consulta SQL para atualizar o status do usuário
        $sql = "UPDATE usuarios SET status='$status' WHERE id=$id";
        $result = $conn->query($sql);

        // Verificação de erros na consulta SQL
        if (!$result) {
            die('Erro ao atualizar o status do usuário: ' . $conn->error);
        }

    }

    ?>



</div>

<h3 class="h3 ms-3 text-muted">Analytics (10/06)</h3>

<div class="d-flex flex-column align-items-center">
            <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-user"></i></div>
                <div class="flex-column">
                <div class="col">Estimativa aprox.</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM usuarios";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = 0;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    $result = $result - 1;
                    $valor = $result * 30 + 500;

                    echo $result .' | $'. $valor?></div>
                    </div>
                </div>

                       <div class="d-flex flex-column"><a href="cadastrarUsuario.php"><i class="uil uil-plus action"></i></a></div>
                </div>
                
            

            <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-users-alt"></i></div>
                <div class="flex-column">
                <div class="col">ainda não pagaram</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM usuarios WHERE status = 'pendente'";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = 0;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    $valor_pendente = $result * 30;

                    echo $result .' | -$'. $valor_pendente?></div>
                    </div>
                </div>
                </div>
                
                <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-users-alt"></i></div>
                <div class="flex-column">
                <div class="col">já pagaram</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM usuarios WHERE status = 'ativo'";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = -1;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    

                    $valor = $result * 30;

                    echo $result .' | +$'. $valor?></div>
                    </div>
                </div>
                </div>

                <div class="d-flex adm-widget align-items-center justify-content-between">
                <div class="info-content d-flex align-items-center">
                <div class="d-flex flex-column"><i class="uil uil-users-alt"></i></div>
                <div class="flex-column">
                <div class="col">total + escolas</div>
                <div class="col text-black">

                    <?php
                    $sql="SELECT * FROM usuarios WHERE status = 'ativo'";

                    $return = $conexao->query( $sql );

                    if ( $return == false ) {
                        echo $conexao->error;
                    }

                    $result = 0;

                    while($registro = $return->fetch_array()) {
                        $result++;
                    }

                    $valor = $result * 30 + 500;

                    echo $result .' | $'. $valor?></div>
                    </div>
                </div>
                </div>



            
            
            </div>

</body>