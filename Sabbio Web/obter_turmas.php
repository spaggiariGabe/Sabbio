<?php
// Conexão com o banco de dados
include_once('config.php');

// Verifica se os parâmetros foram recebidos
if(isset($_GET['curso_id']) && isset($_GET['semestre'])) {
    // Recebe os parâmetros
    $curso_id = $_GET['curso_id'];
    $semestre = $_GET['semestre'];

    // Consulta SQL para obter as turmas do curso e semestre especificados
    $query = "SELECT id_turma, nome_turma FROM turmas WHERE id_curso = '$curso_id' AND semestre = '$semestre'";
    $result = mysqli_query($conexao, $query);

    // Monta as opções para o select de turmas
    $options = "<option value=''>Selecione a turma...</option>";
    while($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id_turma']}'>{$row['nome_turma']}</option>";
    }

    // Retorna as opções como resposta
    echo $options;
} else {
    // Retorna uma opção padrão caso os parâmetros não tenham sido recebidos
    echo "<option value=''>Selecione a turma...</option>";
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
