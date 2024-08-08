<?php
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todas as variáveis do formulário estão definidas
    if (isset($_POST['id_materia'], $_POST['nome_materia'], $_POST['id_curso'])) {
        // Recebe os dados do formulário
        $id_materia = $_POST['id_materia'];
        $nome_materia = $_POST['nome_materia'];
        $id_curso = $_POST['id_curso'];


        // Insere a matéria na tabela materias
        $query_materia = "INSERT INTO materias (id_materia, nome_materia, id_curso) 
                          VALUES ('$id_materia', '$nome_materia', '$id_curso')";

        if (mysqli_query($conexao, $query_materia)) {
            // Mensagem de sucesso
            echo "<script>alert('Matéria cadastrada com sucesso!'); window.location = 'cadastro_materia.php';</script>";
        } else {
            // Mensagem de erro ao cadastrar a matéria
            echo "<script>alert('Erro ao cadastrar a matéria: " . mysqli_error($conexao) . "'); window.location = 'cadastro_materia.php';</script>";
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    } else {
        // Mensagem de erro se algum campo estiver vazio
        echo "<script>alert('Todos os campos devem ser preenchidos!');</script>";
    }
}
?>
