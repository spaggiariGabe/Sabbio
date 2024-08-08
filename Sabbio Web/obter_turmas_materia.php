<?php
// Conexão com o banco de dados
include_once('config.php');

// Verifica se o parâmetro do curso foi recebido
if(isset($_GET['curso_id'])) {
    // Recebe o parâmetro do curso
    $curso_id = mysqli_real_escape_string($conexao, $_GET['curso_id']);

    // Consulta para selecionar as turmas com base no curso
    $query = "SELECT id_turma, nome_turma 
              FROM turmas 
              WHERE id_curso = '$curso_id'";
    $result = mysqli_query($conexao, $query);

    // Verifica se a consulta foi bem-sucedida
    if($result) {
        // Monta as opções para o select de turmas
        $options = "<option value=''>Selecione a turma...</option>";
        while($row = mysqli_fetch_assoc($result)) {
            $options .= "<option value='{$row['id_turma']}'>{$row['nome_turma']}</option>";
        }
        // Retorna as opções como resposta
        echo $options;
    } else {
        // Se houver um erro na consulta, retorna uma mensagem de erro
        echo "<option value=''>Erro ao obter as turmas: " . mysqli_error($conexao) . "</option>";
    }
} else {
    // Retorna uma opção padrão caso o parâmetro do curso não tenha sido recebido
    echo "<option value=''>Selecione a turma...</option>";
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
