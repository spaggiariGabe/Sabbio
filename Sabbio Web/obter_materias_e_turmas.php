<?php
include_once('config.php');

if (isset($_GET['curso_id'])) {
    $cursoId = $_GET['curso_id'];

    // Obter matérias do curso selecionado
    $query_materias = "SELECT id_materia, nome_materia FROM materias WHERE id_curso = $cursoId";
    $result_materias = mysqli_query($conexao, $query_materias);

    $materias = [];
    if ($result_materias) {
        while ($row = mysqli_fetch_assoc($result_materias)) {
            $materias[] = $row;
        }
    }

    // Obter turmas relacionadas ao curso e às matérias selecionadas
    $query_turmas = "SELECT t.id_turma, t.nome_turma 
                     FROM turmas t 
                     INNER JOIN materia_turma mt ON t.id_turma = mt.id_turma 
                     INNER JOIN materias m ON mt.id_materia = m.id_materia 
                     WHERE t.id_curso = $cursoId";
    $result_turmas = mysqli_query($conexao, $query_turmas);

    $turmas = [];
    if ($result_turmas) {
        while ($row = mysqli_fetch_assoc($result_turmas)) {
            $turmas[] = $row;
        }
    }

    // Montar e enviar a resposta como JSON
    $response = [
        'materias' => $materias,
        'turmas' => $turmas
    ];
    echo json_encode($response);
} else {
    echo json_encode([]);
}
?>
