<?php
include_once('config.php');

if(isset($_GET['id_turma'])) {
    $id_turma = $_GET['id_turma'];
    
    $query_alunos = "SELECT * FROM alunos WHERE id_turma = $id_turma";

    $result_alunos = mysqli_query($conexao, $query_alunos);

    if ($result_alunos) {
        $alunos = [];
        while ($row = mysqli_fetch_assoc($result_alunos)) {
            $alunos[] = $row;
        }
        echo json_encode($alunos);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
