<?php
session_start(); // Inicia a sessão PHP para gerenciar as variáveis de sessão

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    // Verifica se o formulário foi submetido e se os campos de email e senha foram preenchidos

    include_once('config.php'); // Inclui o arquivo de configuração do banco de dados

    $email = $_POST['email']; // Obtém o valor do campo de email do formulário
    $senha = $_POST['senha']; // Obtém o valor do campo de senha do formulário

    // Consulta SQL para verificar se o email existe no banco de dados
    $sql = "SELECT * FROM adm WHERE email = '$email'";
    $result = $conexao->query($sql); // Executa a consulta no banco de dados

    if(mysqli_num_rows($result) < 1) {
        // Se não houver registros retornados pela consulta, significa que o email não está cadastrado
        $_SESSION['error'] = 'Email ou senha incorreta.'; // Define uma mensagem de erro na sessão
        header('Location: default.php'); // Redireciona de volta para a página de login
        exit(); // Termina a execução do script
    } else {
        // Se o email existir no banco de dados, verifica se a senha está correta

        $row = $result->fetch_assoc(); // Obtém o registro retornado pela consulta como um array associativo

        if ($row['senha'] != $senha) {
            // Se a senha fornecida não corresponder à senha armazenada no banco de dados
            $_SESSION['error'] = 'Email ou senha incorreta.'; // Define uma mensagem de erro na sessão
            header('Location: default.php'); // Redireciona de volta para a página de login
            exit(); // Termina a execução do script
        } else {
            // Se a senha estiver correta, o login é bem-sucedido

            $_SESSION['email'] = $email; // Armazena o email na sessão para uso posterior
            $_SESSION['senha'] = $senha; // Armazena a senha na sessão para uso posterior
            header('Location: home.php'); // Redireciona para a página inicial após o login
            exit(); // Termina a execução do script
        }
    }
} else {
    // Se o formulário não foi submetido ou se algum dos campos está vazio
    $_SESSION['error'] = 'Por favor, preencha todos os campos.'; // Define uma mensagem de erro na sessão
    header('Location: default.php'); // Redireciona de volta para a página de login
    exit(); // Termina a execução do script
}
?>
