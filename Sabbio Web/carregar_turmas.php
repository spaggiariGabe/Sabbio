<?php
include_once('config.php');

// Verifica se o ID da matéria foi recebido por POST
if(isset($_POST['id_materia'])) {
    // Obtém o ID da matéria do POST
    $id_materia = $_POST['id_materia'];

    // Consulta as turmas relacionadas com a matéria selecionada na tabela turma_materia
    $sqlTurmas = "SELECT t.id_turma, t.nome_turma 
                  FROM turmas t
                  INNER JOIN materia_turma mt ON t.id_turma = mt.id_turma
                  WHERE mt.id_materia = $id_materia";

    $resultTurmas = $conexao->query($sqlTurmas);

    // Verifica se há turmas encontradas
    if ($resultTurmas->num_rows > 0) {
        // Inicializa um array para armazenar as turmas
        $turmas = array();

        // Constrói o array de turmas
        while ($rowTurma = $resultTurmas->fetch_assoc()) {
            $turmas[] = $rowTurma;
        }

        // Retorna o array de turmas como JSON
        echo json_encode($turmas);
    } else {
        // Se não houver turmas encontradas, retorna uma mensagem indicando que nenhuma turma foi encontrada
        echo json_encode(array("message" => "Nenhuma turma encontrada"));
    }
} else {
    // Se o ID da matéria não foi recebido por POST, retorna uma mensagem de erro
    echo json_encode(array("error" => "ID da matéria não fornecido"));
}
?>
