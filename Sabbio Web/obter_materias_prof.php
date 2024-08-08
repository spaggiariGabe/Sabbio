<?php
include_once('config.php');

if(isset($_GET['materia_id'])) {
    $materia_id = $_GET['materia_id'];

    $query = "SELECT id_materia, nome_materia FROM materias WHERE id_materia = '$materia_id'";
    $result = mysqli_query($conexao, $query);

    $materias = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $materias[] = $row;
    }

    echo json_encode($materias);
} else {
    echo json_encode(array('error' => 'Parâmetro materia_id não especificado'));
}
?>
