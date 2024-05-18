<?php
include('conexao.php');

$turma = $_POST['turma'];
$data = $_POST['data'];
$bimestre = $_POST['bimestre'];
$disciplina = $_POST['disciplina'];
$user_id = $_POST['user_id'];
$alunos_faltantes = $_POST['alunos_faltantes'];
$conteudos = $_POST['conteudo'];
$justificada_checkbox = $_POST['justificada_checkbox']; // Novo campo para justificação

// Deletar faltas existentes
$query_delete = "DELETE FROM faltas WHERE turma_id = '$turma' AND data = '$data' AND bimestre = '$bimestre' AND insertBy = '$user_id' AND disciplina = '$disciplina'";
mysqli_query($conexao, $query_delete);

// Deletar conteúdos existentes
$query_delete_conteudo = "DELETE FROM conteudo WHERE data = '$data' AND insertBy = '$user_id' AND disciplina = '$disciplina'";
mysqli_query($conexao, $query_delete_conteudo);

foreach ($alunos_faltantes as $aluno_id) {
  // Verifique se o aluno foi marcado como "justificado"
  $justificada = (isset($justificada_checkbox[$aluno_id]) && $justificada_checkbox[$aluno_id] == 'justificada') ? 'justificada' : '';

  // Inserir falta com status "justificada" quando aplicável
  $query_insert = "INSERT INTO faltas (turma_id, data, bimestre, aluno_id, id, disciplina, insertBy, FJ) VALUES ('$turma', '$data', '$bimestre', '$aluno_id', '1', '$disciplina', '$user_id', '$justificada')";
  mysqli_query($conexao, $query_insert);
}

if (!empty($conteudos)) {
  $conteudoCount = count($conteudos);
  for ($i = 0; $i < $conteudoCount; $i++) {
    $conteudo = $conteudos[$i];
    $query_insert_conteudo = "INSERT INTO conteudo (conteudo, data, insertBy, disciplina) VALUES ('$conteudo', '$data', '$user_id', '$disciplina')";
    mysqli_query($conexao, $query_insert_conteudo);
  }
}


header('Location: chamadasAnteriores.php?turma=' . $turma . '&data=' . $data . '&bimestre=' . $bimestre . '&disciplina=' . $disciplina);
exit();
?>
