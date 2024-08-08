<?php
session_start();

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('config.php'); // Incluir o arquivo de configuração do banco de dados

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta SQL para verificar se o email existe no banco de dados
    $sql = "SELECT * FROM professores WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1) {
        // Email não cadastrado
        $_SESSION['error'] = 'Email ou senha incorreta';
        header('Location: loginprof.php');
        exit();
    } else {
        // Verificar se a senha está correta
        $row = $result->fetch_assoc();
        if ($row['senha'] != $senha) {
            // Senha incorreta
            $_SESSION['error'] = 'Email ou senha incorreta';
            header('Location: loginprof.php');
            exit();
        } else {
            // Login bem-sucedido
            $_SESSION['id_professor'] = $row['id_professor'];
            $_SESSION['nome_professor'] = $row['nome'];
            header('Location: homeprof.php');
            exit();
        }
    }
} else {
    // Não foram fornecidos email e senha
    $_SESSION['error'] = 'Por favor, preencha todos os campos';
    header('Location: loginprof.php');
    exit();
}
?>
