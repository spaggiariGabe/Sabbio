<?php
include_once('config.php');

session_start();
$id_professor = $_SESSION['id_professor'];

$query_cursos = "SELECT c.id_curso, c.nome_curso 
                 FROM cursos c 
                 INNER JOIN professor_curso pc ON c.id_curso = pc.id_curso 
                 WHERE pc.id_professor = $id_professor";

$result_cursos = mysqli_query($conexao, $query_cursos);

if ($result_cursos) {
    $cursos = [];
    while ($row = mysqli_fetch_assoc($result_cursos)) {
        $cursos[] = $row;
    }
    echo json_encode($cursos);
} else {
    echo json_encode([]);
}
?>
