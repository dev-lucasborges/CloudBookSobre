<?php
    include_once("globalVariables.php");
    $user_id = $_SESSION['user_id'];
    $capturarNome = "SELECT * FROM `usuarios` WHERE id = $user_id";
    $resultadoNome = mysqli_query($conexao, $capturarNome);

    while ($professor = mysqli_fetch_assoc($resultadoNome)) {
        $nomeProfessor = $professor['nome'];
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
<div class="viewArea">

<style>
  .navbar{
    display: none;
  }
  </style>

    <div class="hero-blur flex-column">
      

      

    <div class=" d-flex justify-content-between">
        
        <div class="profile-info">
            <p class="text-muted small"><?php echo $escola.' - '; ?><script>document.write(data)</script></p>
            <h1 class="mt-1 h2">Olá, <b><?php echo $nomeProfessor ;?>!</b></h1>
        </div>
        
        <div class="profile">
            <img class="" src="./assets/images.png">
        </div>

    </div>

    <?php
    echo '<div class="row align-items-center mt-3 justify-content-center">';
        if($nivel_acesso == 1){
        

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=R">';
        echo '<div class="widget">';
        echo '<span><i class="uil uil-file-check"></i></span>';
        echo '<p class="text-muted">Resumo</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=G">';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-file-alt"></i></span>';
        echo '<p class="text-muted">Relatório</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=P">';
        echo '<div class="widget  widget-active">';
        echo '<span><i class="uil uil-arrow-circle-right"></i></span>';
        echo '<p>Chamada</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        
        }

        if($nivel_acesso == 2){

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=N">';
        echo '<div class="widget">';
        echo '<span><i class="uil uil-diary"></i></span>';
        echo '<p class="text-muted text-center">Notas</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=R">';
        echo '<div class="widget">';
        echo '<span><i class="uil uil-file-check"></i></span>';
        echo '<p class="text-muted">Resumo</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=P">';
        echo '<div class="widget  widget-active">';
        echo '<span><i class="uil uil-arrow-circle-right"></i></span>';
        echo '<p>Chamada</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
      
        echo '<div class="opcoes mt-3 d-flex justify-content-center flex-column align-items-center">';
        echo '<button id="mostrar-mais"><i class="uil uil-angle-down seta"></i></button>';
        echo '<div class="opcoes-adicionais">';

        echo '<div class="row mt-3 justify-content-center">';
        
        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=G">';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-file-alt"></i></span>';
        echo '<p class="text-muted">Relatório</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=C">';
        echo '<!-- <a href="development.html"> -->';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-history"></i></span>';
        echo '<p class="text-muted text-center">Chamadas Anteriores</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        
        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=F">';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-user-exclamation"></i></span>';
        echo '<p class="text-muted text-center">Justificar Faltas</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    
        echo '</div>';
        echo '</div>';
        }

      if($nivel_acesso == 3){

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=N">';
        echo '<div class="widget">';
        echo '<span><i class="uil uil-diary"></i></span>';
        echo '<p class="text-muted text-center">Notas</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=R">';
        echo '<div class="widget">';
        echo '<span><i class="uil uil-file-check"></i></span>';
        echo '<p class="text-muted">Resumo</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=P">';
        echo '<div class="widget  widget-active">';
        echo '<span><i class="uil uil-arrow-circle-right"></i></span>';
        echo '<p>Chamada</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '</div>';

        echo '<div class="opcoes mt-4 d-flex justify-content-center flex-column align-items-center">';
        echo '<button id="mostrar-mais"><i class="uil uil-angle-down seta"></i></button>';
        echo '<div class="opcoes-adicionais">';

        echo '<div class="row mt-3 justify-content-center">';
        
        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=G">';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-file-alt"></i></span>';
        echo '<p class="text-muted">Relatório</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=C">';
        echo '<!-- <a href="development.html"> -->';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-history"></i></span>';
        echo '<p class="text-muted text-center">Chamadas Anteriores</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        
        echo '<div class="col">';
        echo '<a href="disciplina.php?loc=F">';
        echo '<div class="widget mx-auto mt-2">';
        echo '<span><i class="uil uil-user-exclamation"></i></span>';
        echo '<p class="text-muted text-center">Justificar Faltas</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        
        echo '</div>';
        echo '<div class="col">';
        echo '<a href="adm.php">';
        echo '<div class="widget bg-blueLight3 mx-auto mt-2">';
        echo '<span><i class="uil uil-user-plus"></i></span>';
        echo '<p class="">Cadastrar Usuário</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
?>






    <script> 
let botao = document.querySelector('#mostrar-mais');
let opcoes = document.querySelector('.opcoes');

botao.addEventListener('click', function() {
  opcoes.classList.toggle('expandido');
});
</script>



  <div class="hero mb-3">
    <div class="offtuto offtutov2">
      <div class="info me-1">
        <h1 class="d-flex m-0"><i class="uil uil-plane-fly"></i></h1>
      </div>

      <div class="footer-card footer-cardv2">

        <span>Estamos expandindo!</span>
        <p>O CloudBook está cada vez mais completo. Chegou a hora de crescer e vamos alcançar novas instituições! Se você já é assinante, agora pode usar em outras escolas. Entre em contato para mais informações!</p>
        <a href="sobre.html"><button type="button" class="btn btn-primary px-3">Sobre</button></a>
      </div>
    </div>
  </div>

  <div class="hero mb-3">
    <div class="offtuto">
      <div class="info me-1">
        <h1 class="d-flex m-0"><i class="uil uil-arrow-circle-up"></i></h1>
      </div>

      <div class="footer-card">
        <span>Como vai, professor?</span>
        <p>Está por dentro da última atualização do CloudBook?! Não fique por fora e saiba todos os novos recursos implementados e alterações!</p>
        <button type="button" class="btn btn-primary px-3" data-toggle="modal" data-target="#novidadesModal">Exibir Novidades</button>
      </div>
    </div>
  </div>

  

  

  </div>

  

  <div id="novidadesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="novidadesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novidadesModalLabel">Novidades</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Olá professor! Fique por dentro das novidades da última atualização!</p>
                    <ol>
                        <li class="mb-3">Agora é possível justificar as faltas de um aluno 😉 em Justificar Faltas.
                          <br>
                          <video class="img-fluid rounded " src="assets\tutorialjustificar.mp4" loop autoplay muted playsinline></video>
                          <br>
                          <span>É só marcar os alunos que estão com falta!</span>
                        </li>
                        <li>
                          <span>Além disso, mudamos o Chamadas Anteriores para Corrigir Chamadas.</span>
                        </li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Verificar se o modal já foi exibido anteriormente
        var modalExibido = getCookie('modalExibido1');
        if (!modalExibido) {
            // Exibir o modal
            $('#novidadesModal').modal('show');

            // Definir cookie para indicar que o modal já foi exibido
            setCookie('modalExibido1', true, 365);
        }

        // Função para obter o valor de um cookie
        function getCookie(name) {
            var cookieArr = document.cookie.split(';');
            for (var i = 0; i < cookieArr.length; i++) {
                var cookiePair = cookieArr[i].split('=');
                if (name === cookiePair[0].trim()) {
                    return decodeURIComponent(cookiePair[1]);
                }
            }
            return null;
        }

        // Função para definir um cookie
        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/';
        }
    </script>

</body>
</html>