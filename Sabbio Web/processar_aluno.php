<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $id_alunos = $_POST['matricula'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $curso_id = $_POST['curso']; // Agora recebe o id_curso
    $turma_id = $_POST['turma']; // Agora recebe o id_turma
    $data_nasc = $_POST['data_nasc'];
    $sexo = $_POST['genero'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $email_inst = $_POST['email_inst'];
    $senha = $_POST['senha'];

    // Verificar se o email, CPF, RG ou email institucional já estão cadastrados
    $query_verificar_dados = "SELECT * FROM alunos WHERE email = '$email' OR cpf = '$cpf' OR rg = '$rg' OR email_inst = '$email_inst'";
    $resultado_verificar_dados = mysqli_query($conexao, $query_verificar_dados);

    if (mysqli_num_rows($resultado_verificar_dados) > 0) {
        header('Location: formulario.php?error=Email, CPF, RG ou Email Institucional já estão cadastrados.');
        exit();
    }

    // Verificar se a senha atende aos critérios
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/", $senha)) {
        header('Location: formulario.php?error=A senha deve conter pelo menos 7 caracteres, incluindo pelo menos uma letra maiúscula e um número.');
        exit();
    }

    // Verificar se o CPF é válido
    if (!preg_match("/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/", $cpf)) {
        header('Location: formulario.php?error=CPF inválido.');
        exit();
    }

    // Verificar se o RG é válido
    if (!preg_match("/^\d{2}\.\d{3}\.\d{3}\-\d{1}$/", $rg)) {
        header('Location: formulario.php?error=RG inválido.');
        exit();
    }

    // Verificar se o número de telefone é válido
    if (!preg_match("/^\(\d{2}\) \d{5}\-\d{4}$/", $telefone)) {
        header('Location: formulario.php?error=Número de telefone inválido.');
        exit();
    }

    // Inserir o novo cadastro no banco de dados
    $query_inserir_aluno = "INSERT INTO alunos (id_alunos, nome, cpf, rg, email, telefone, id_curso, id_turma, data_nasc, sexo, cep, cidade, estado, rua, numero, email_inst, senha)
                            VALUES ('$id_alunos', '$nome', '$cpf', '$rg', '$email', '$telefone', '$curso_id', '$turma_id', '$data_nasc', '$sexo','$cep', '$cidade', '$estado', '$rua', '$numero', '$email_inst', '$senha')";
    $resultado_inserir_aluno = mysqli_query($conexao, $query_inserir_aluno);

    if ($resultado_inserir_aluno) {
        header('Location: formulario.php?success=Cadastro realizado com sucesso!');
        exit();
    } else {
        header('Location: formulario.php?error=Erro ao cadastrar aluno. Por favor, tente novamente.');
        exit();
    }
}
?>
