<?php
include_once('config.php');

if(isset($_GET['curso_id'])) {
    $cursoId = $_GET['curso_id'];

    // Consultar o banco de dados para obter as matérias relacionadas ao curso
    $queryMaterias = "SELECT id_materia, nome_materia FROM materias WHERE id_curso = $cursoId";
    $resultMaterias = mysqli_query($conexao, $queryMaterias);

    // Preparar os dados para enviar de volta à página HTML
    $materias = [];

    while ($row = mysqli_fetch_assoc($resultMaterias)) {
        $materias[] = $row;
    }

    // Enviar os dados de volta à página HTML em formato JSON
    echo json_encode($materias);
} else {
    // Se o ID do curso não foi fornecido, retornar um erro
    echo json_encode(['error' => 'ID do curso não fornecido']);
}
?>
