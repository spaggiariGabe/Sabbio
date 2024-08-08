<?php
// Conexão com o banco de dados
include_once('config.php');

// Verifica se o parâmetro id_turma foi recebido
if (isset($_GET['id_turma'])) {
    // Recebe o parâmetro
    $id_turma = $_GET['id_turma'];

    // Consulta SQL para obter os alunos da turma especificada
    $query_alunos = "SELECT id_aluno, nome FROM alunos WHERE id_turma = $id_turma";
    
    // Executa a consulta SQL
    $result_alunos = mysqli_query($conexao, $query_alunos);

    // Verifica se a consulta retornou algum resultado
    if ($result_alunos) {
        // Array para armazenar os alunos
        $alunos = array();

        // Loop através dos resultados da consulta e adicione os alunos ao array
        while ($row = mysqli_fetch_assoc($result_alunos)) {
            $alunos[] = $row;
        }

        // Converta o array de alunos para o formato JSON e imprima
        echo json_encode($alunos);
    } else {
        echo "Erro na consulta SQL: " . mysqli_error($conexao);
    }
} else {
    // Se o parâmetro id_turma não foi recebido, exiba uma mensagem de erro
    echo "Parâmetro id_turma não foi fornecido.";
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
