<?php
// Incluir arquivo de configuração do banco de dados
include_once('config.php');

// Verificar se o parâmetro curso_id foi enviado via GET
if (isset($_GET['curso_id'])) {
    // Sanitize o valor do parâmetro curso_id para evitar injeção de SQL
    $curso_id = mysqli_real_escape_string($conexao, $_GET['curso_id']);

    // Consulta SQL para obter as turmas relacionadas ao curso selecionado
    $query_turmas = "SELECT * FROM turmas WHERE id_curso = '$curso_id'";
    $resultado_turmas = mysqli_query($conexao, $query_turmas);

    // Verificar se há turmas cadastradas para o curso selecionado
    if (mysqli_num_rows($resultado_turmas) > 0) {
        // Iniciar a string de opções do select
        $options = '';

        // Loop através dos resultados e construir as opções do select
        while ($row = mysqli_fetch_assoc($resultado_turmas)) {
            $options .= '<option value="' . $row['id_turma'] . '">' . $row['nome_turma'] . '</option>';
        }

        // Retornar as opções do select
        echo $options;
    } else {
        // Se não houver turmas cadastradas para o curso selecionado, retornar uma opção indicando isso
        echo '<option value="">Nenhuma turma encontrada para este curso</option>';
    }
} else {
    // Se o parâmetro curso_id não foi enviado, retornar uma opção indicando isso
    echo '<option value="">Parâmetro curso_id não foi fornecido</option>';
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
