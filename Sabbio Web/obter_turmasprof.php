<?php
include_once('config.php');

session_start();
$id_professor = $_SESSION['id_professor'];

if(isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];
    
    $query_turmas = "SELECT t.id_turma, t.nome_turma 
                     FROM turmas t 
                     INNER JOIN materia_turma mt ON t.id_turma = mt.id_turma 
                     INNER JOIN professor_materia pm ON mt.id_materia = pm.id_materia 
                     WHERE t.id_curso = $id_curso AND pm.id_professor = $id_professor";

    $result_turmas = mysqli_query($conexao, $query_turmas);

    if ($result_turmas) {
        $turmas = [];
        while ($row = mysqli_fetch_assoc($result_turmas)) {
            $turmas[] = $row;
        }
        echo json_encode($turmas);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
