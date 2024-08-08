<?php
include_once('config.php');

session_start();
$id_professor = $_SESSION['id_professor'];

if(isset($_GET['id_turma'])) {
    $id_turma = $_GET['id_turma'];
    
    $query_materias = "SELECT m.id_materia, m.nome_materia 
                       FROM materias m 
                       INNER JOIN professor_materia pm ON m.id_materia = pm.id_materia 
                       INNER JOIN materia_turma mt ON m.id_materia = mt.id_materia 
                       WHERE mt.id_turma = $id_turma AND pm.id_professor = $id_professor";

    $result_materias = mysqli_query($conexao, $query_materias);

    if ($result_materias) {
        $materias = [];
        while ($row = mysqli_fetch_assoc($result_materias)) {
            $materias[] = $row;
        }
        echo json_encode($materias);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
