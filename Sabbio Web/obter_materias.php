<?php
include_once('config.php');

if(isset($_GET['curso_id'])) {
    $curso_id = $_GET['curso_id'];

    $query = "SELECT id_materia, nome_materia FROM materias WHERE id_curso = '$curso_id'";
    $result = mysqli_query($conexao, $query);

    if(mysqli_num_rows($result) > 0) {
        $options = "<option value=''>Selecione a matéria...</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= "<option value='" . $row['id_materia'] . "'>" . $row['nome_materia'] . "</option>";
        }
        echo $options;
    } else {
        echo "<option value=''>Nenhuma matéria encontrada para este curso</option>";
    }
} else {
    echo "<option value=''>Erro: Curso não especificado</option>";
}
?>
