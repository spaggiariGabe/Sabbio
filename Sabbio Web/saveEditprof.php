<?php
include_once('config.php');

if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sqlUpdate = "UPDATE professores SET nome='$nome', cpf='$cpf', telefone='$telefone', email='$email', senha='$senha' WHERE id_professor='$id'";

    if ($conexao->query($sqlUpdate) === TRUE) {
        echo "Cadastro atualizado com sucesso";
    } else {
        echo "Erro ao atualizar Cadastro: " . $conexao->error;
    }
    
    $conexao->close();
}

header('Location: sistemaprof.php');
?>
