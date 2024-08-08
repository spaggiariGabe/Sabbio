<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    include_once('config.php');
    
    // Recebe os dados do formulário
    $nome_curso = $_POST['nome_curso'];
    $descricao = $_POST['descricao'];
    $duracao_semestres = $_POST['duracao'];

    // Prepara a query SQL para inserir os dados na tabela de cursos
    $query_inserir_curso = "INSERT INTO cursos (nome_curso, descricao, duracao_semestres) 
                            VALUES ('$nome_curso', '$descricao', '$duracao_semestres')";

    // Executa a query
    $resultado = mysqli_query($conexao, $query_inserir_curso);

    // Verifica se a inserção foi bem-sucedida
    if ($resultado) {
        echo "<script>alert('Curso cadastrado com sucesso.');</script>";
        echo "<script>window.location = 'home.php';</script>"; // Redireciona para a página principal do administrador
    } else {
        echo "<script>alert('Erro ao cadastrar curso. Por favor, tente novamente.');</script>";
        echo "<script>window.history.back();</script>"; // Retorna para a página anterior
    }
} else {
    // Se o formulário não foi enviado, redireciona para a página principal do administrador
    header("Location: processar_curso.php");
}
?>
