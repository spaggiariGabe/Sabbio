<?php
include_once('config.php');

// Verifica se o formulário foi submetido
if(isset($_POST['nome_turma'], $_POST['codigo_turma'], $_POST['periodo'], $_POST['semestre'], $_POST['id_curso'])) {
    // Recebe os dados do formulário
    $nome_turma = $_POST['nome_turma'];
    $codigo_turma = $_POST['codigo_turma'];
    $periodo = $_POST['periodo'];
    $semestre = $_POST['semestre'];
    $id_curso = $_POST['id_curso'];

    // Verifica se já existe uma turma com o mesmo código
    $query_verifica_codigo = "SELECT * FROM turmas WHERE codigo_turma = '$codigo_turma'";
    $result_verifica_codigo = mysqli_query($conexao, $query_verifica_codigo);
    if (mysqli_num_rows($result_verifica_codigo) > 0) {
        echo "<script>alert('Já existe uma turma cadastrada com este código. Por favor, escolha outro código.');</script>";
        echo "<script>window.location = 'cadastro_turma.php';</script>"; // Retorna para a página de cadastro de turma
        exit(); // Encerra o script após exibir a mensagem de erro
    }

    // Insere os dados na tabela de turmas
    $query = "INSERT INTO turmas (nome_turma, codigo_turma, periodo, semestre, id_curso) 
              VALUES ('$nome_turma', '$codigo_turma', '$periodo', '$semestre', '$id_curso')";

    $resultado = mysqli_query($conexao, $query);

    // Verifica se a inserção foi bem-sucedida
    if ($resultado) {
        echo "<script>alert('Turma cadastrada com sucesso.');</script>";
        echo "<script>window.location = 'cadastro_turma.php';</script>"; // Redireciona para a página de cadastro de turma
    } else {
        echo "<script>alert('Erro ao cadastrar turma. Por favor, tente novamente.');</script>";
        echo "<script>window.location = 'cadastro_turma.php';</script>"; // Retorna para a página de cadastro de turma
    }
} else {
    // Se o formulário não foi enviado, redireciona para a página de cadastro de turma
    header("Location: cadastro_turma.php");
}
?>
