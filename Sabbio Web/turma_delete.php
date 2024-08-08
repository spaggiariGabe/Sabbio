<?php
// Verifica se o parâmetro ID foi passado
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Inclui o arquivo de configuração do banco de dados
    include_once('config.php');

    // Obtém o ID da turma a ser excluída
    $id_turma = $_GET['id'];

    // Prepara e executa a instrução SQL para excluir a turma
    $query_delete = "DELETE FROM turmas WHERE id_turma = '$id_turma'";
    $result_delete = mysqli_query($conexao, $query_delete);

    // Verifica se a exclusão foi bem-sucedida
    if($result_delete) {
        // Redireciona de volta para a página de lista de turmas
        header("Location: sistematurma.php");
        exit(); // Encerra o script após redirecionar
    } else {
        echo "Erro ao excluir a turma: " . mysqli_error($conexao);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
} else {
    echo "ID da turma não especificado.";
}
?>
