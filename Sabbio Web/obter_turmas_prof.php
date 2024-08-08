<?php
include_once('config.php');

if(isset($_GET['materia_id'])) {
    $materia_id = $_GET['materia_id'];

    // Consulta para obter as turmas que possuem a matéria selecionada
    $query = "SELECT t.id_turma, t.nome_turma FROM turmas t INNER JOIN materia_turma mt ON t.id_turma = mt.id_turma WHERE mt.id_materia = '$materia_id'";
    $result = mysqli_query($conexao, $query);

    $turmas = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $turmas[] = $row;
    }

    echo json_encode($turmas);
} else {
    echo json_encode(array('error' => 'Parâmetro materia_id não especificado'));
}
?>
