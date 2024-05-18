<?php
include('conexao.php');

$aluno_nome = $_POST['aluno_nome'];
$user_id = $_POST['user_id'];
$disciplinaAtual = $_POST['disciplinaAtual'];
$turma = $_POST['turma'];
$escola = $_POST['escola'];
$bimestre = $_POST['bimestre'];
$apelido = $_POST['apelido'];
$insertBy = $_SESSION['user_id'];

$loc = $_POST['loc'];
$data = $_POST['data'];

// Restante do código para processar os dados e realizar as operações necessárias na tabela "whitelist"

if(empty($apelido)){
    $query_delete = "DELETE FROM apelidos WHERE turma_id = '$turma' AND aluno_id = '$aluno_nome' AND bimestre = '$bimestre' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual'";
    mysqli_query($conexao, $query_delete);
}

if(!empty($apelido)){
    $query_delete = "DELETE FROM apelidos WHERE turma_id = '$turma' AND aluno_id = '$aluno_nome' AND bimestre = '$bimestre' AND insertBy = '$user_id' AND disciplina = '$disciplinaAtual'";
    mysqli_query($conexao, $query_delete);

    $query_insert = "INSERT INTO `apelidos`(`aluno_id`, `insertBy`, `disciplina`, `bimestre`, `turma_id`, `apelido`) VALUES ('$aluno_nome','$insertBy','$disciplinaAtual','$bimestre','$turma','$apelido')";
    mysqli_query($conexao, $query_insert);

}

if($loc == ''){
    header('Location: relatorioIndividual.php?turma=' . $turma . '&disciplina=' . $disciplinaAtual . '&bimestre=' . $bimestre . '&nome=' . $aluno_nome);
}

if($loc == 'chamada'){
    header('Location: presença.php?turma=' . $turma . '&data=' . $data . '&bimestre=' . $bimestre . '&disciplina=' . $disciplinaAtual);
}

if($loc == 'notas'){
    header('Location: notas.php?turma=' . $turma . '&data=' . $data . '&bimestre=' . $bimestre . '&disciplina=' . $disciplinaAtual);
}

if($loc == 'resumo'){
    header('Location: relatorio.php?turma=' . $turma . '&data=' . $data . '&bimestre=' . $bimestre . '&disciplina=' . $disciplinaAtual);
}

exit();


?>




