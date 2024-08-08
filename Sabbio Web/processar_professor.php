<?php
session_start();
include_once('config.php');

// Função para verificar se o CPF já está cadastrado
function verificarCPF($conexao, $cpf) {
    $query_verificar_cpf = "SELECT * FROM professores WHERE cpf = ?";
    $stmt = mysqli_prepare($conexao, $query_verificar_cpf);
    mysqli_stmt_bind_param($stmt, "s", $cpf);
    mysqli_stmt_execute($stmt);
    $result_verificar_cpf = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result_verificar_cpf) > 0) {
        return true; // CPF encontrado no banco de dados
    } else {
        return false; // CPF não encontrado no banco de dados
    }
}

// Recebe os dados do formulário
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
$telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
$email = mysqli_real_escape_string($conexao, $_POST['email']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$id_curso = mysqli_real_escape_string($conexao, $_POST['id_curso']);

// Verifica se CPF já está cadastrado
if(verificarCPF($conexao, $cpf)) {
    $_SESSION['message'] = 'Este CPF já está cadastrado.';
    $_SESSION['message_type'] = 'error';
    header("Location: proformulario.php");
    exit();
}

// Verifica se o CPF está no formato correto
if(!preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $cpf)) {
    $_SESSION['message'] = 'CPF inválido. Por favor, insira um CPF válido.';
    $_SESSION['message_type'] = 'error';
    header("Location: proformulario.php");
    exit();
}

// Verifica se o telefone está no formato correto
if(!preg_match('/^\(\d{2}\)\s?\d{4,5}\-\d{4}$/', $telefone)) {
    $_SESSION['message'] = 'Telefone inválido. Por favor, insira um telefone válido.';
    $_SESSION['message_type'] = 'error';
    header("Location: proformulario.php");
    exit();
}

// Inicia uma transação
mysqli_autocommit($conexao, false);

// Insere os dados na tabela de professores
$query_professor = "INSERT INTO professores (nome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
$stmt_professor = mysqli_prepare($conexao, $query_professor);
mysqli_stmt_bind_param($stmt_professor, "sssss", $nome, $cpf, $telefone, $email, $senha);
$result_professor = mysqli_stmt_execute($stmt_professor);

// Verifica se a inserção do professor foi bem-sucedida
if(!$result_professor) {
    $_SESSION['message'] = 'Erro ao cadastrar professor.';
    $_SESSION['message_type'] = 'error';
    mysqli_rollback($conexao);
    mysqli_autocommit($conexao, true);
    mysqli_stmt_close($stmt_professor);
    mysqli_close($conexao);
    header("Location: proformulario.php");
    exit();
}

// Obtém o ID do professor inserido
$id_professor = mysqli_insert_id($conexao);

// Insere os dados na tabela de relacionamento professor_curso
$query_professor_curso = "INSERT INTO professor_curso (id_professor, id_curso) VALUES (?, ?)";
$stmt_professor_curso = mysqli_prepare($conexao, $query_professor_curso);
mysqli_stmt_bind_param($stmt_professor_curso, "ii", $id_professor, $id_curso);
$result_professor_curso = mysqli_stmt_execute($stmt_professor_curso);

// Verifica se a inserção na tabela de relacionamento foi bem-sucedida
if($result_professor_curso) {
    // Commit da transação
    mysqli_commit($conexao);
    mysqli_autocommit($conexao, true);
    mysqli_stmt_close($stmt_professor);
    mysqli_stmt_close($stmt_professor_curso);
    mysqli_close($conexao);
    $_SESSION['message'] = 'Professor cadastrado com sucesso.';
    $_SESSION['message_type'] = 'success';
    header("Location: proformulario.php");
    exit();
} else {
    $_SESSION['message'] = 'Erro ao cadastrar professor.';
    $_SESSION['message_type'] = 'error';
    mysqli_rollback($conexao);
    mysqli_autocommit($conexao, true);
    mysqli_stmt_close($stmt_professor);
    mysqli_stmt_close($stmt_professor_curso);
    mysqli_close($conexao);
    header("Location: proformulario.php");
    exit();
}
?>
