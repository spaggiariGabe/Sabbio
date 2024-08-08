<?php

    include_once('config.php');

    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $sexo = $_POST['genero'];
        $data_nasc = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];
        $curso = $_POST['curso'];

        $sqlUpdate = "UPDATE professor SET nome='$nome',cpf='$cpf',rg='$rg',email='$email',senha='$senha',telefone='$telefone',sexo='$sexo',data_nasc='$data_nasc',cidade='$cidade',estado='$estado',endereco='$endereco',curso='$curso' WHERE id='$id'";

        $result = $conexao->query($sqlUpdate);

    }
    header('Location: profsistema.php');

?>    