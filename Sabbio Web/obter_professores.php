<?php
include_once('config.php');

if (isset($_GET['curso_id'])) {
    $curso_id = $_GET['curso_id'];
    
    // Consulta para obter os professores que lecionam o curso
    $query = "SELECT id_professor, nome FROM professores WHERE id_professor IN (SELECT id_professor FROM professor_curso WHERE id_curso = $curso_id)";
    
    $result = mysqli_query($conexao, $query);
    
    $options = '<option value="">Selecione o professor...</option>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row['id_professor'] . "'>" . $row['nome'] . "</option>";
    }
    
    echo $options;
} else {
    echo '<option value="">Erro ao carregar os professores</option>';
}
?>
