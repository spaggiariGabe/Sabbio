<?php
include_once('config.php');

if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $curso = $_POST['curso'];
    $turma = $_POST['turma'];
    $data_nasc = $_POST['data_nasc'];
    $sexo = $_POST['genero']; // Alteração feita aqui, alterando o nome do campo para 'genero'
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $email_inst = $_POST['email_inst'];
    $senha = $_POST['senha'];

    // Consulta SQL para atualizar o cadastro do aluno
    $sqlUpdate = "UPDATE alunos SET nome='$nome', cpf='$cpf', rg='$rg', email='$email', telefone='$telefone', id_curso='$curso', id_turma='$turma', data_nasc='$data_nasc', sexo='$sexo', cidade='$cidade', estado='$estado', rua='$rua', numero='$numero', email_inst='$email_inst', senha='$senha' WHERE id_alunos='$id'"; // Correção feita aqui, utilizando id_alunos em vez de id

    if ($conexao->query($sqlUpdate) === TRUE) {
        echo "Cadastro atualizado com sucesso";
    } else {
        echo "Erro ao atualizar Cadastro: " . $conexao->error;
    }
    
    $conexao->close();
}

header('Location: sistema.php');
?>
