<?php
include_once('config.php');

if (isset($_GET['curso_id'], $_GET['materia_id'])) {
    $cursoId = $_GET['curso_id'];
    $materiaId = $_GET['materia_id'];

    // Obter turmas associadas à matéria e ao curso selecionados
    $query_turmas = "SELECT t.id_turma, t.nome_turma 
                     FROM turmas t 
                     INNER JOIN materia_turma mt ON t.id_turma = mt.id_turma 
                     INNER JOIN materias m ON mt.id_materia = m.id_materia 
                     WHERE t.id_curso = $cursoId AND m.id_materia = $materiaId";
    $result_turmas = mysqli_query($conexao, $query_turmas);

    $turmas = [];
    if ($result_turmas) {
        while ($row = mysqli_fetch_assoc($result_turmas)) {
            $turmas[] = $row;
        }
    }

    // Enviar a resposta como JSON
    echo json_encode($turmas);
} else {
    echo json_encode([]);
}
?>
