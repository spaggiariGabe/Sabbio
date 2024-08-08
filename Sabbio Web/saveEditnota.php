<?php
include_once('config.php');

if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $nota = $_POST['nota'];
    $faltas = $_POST['faltas'];
    $materia = $_POST['materia'];

    $sqlUpdate = "UPDATE alunos SET nota='$nota',faltas='$faltas',materia='$materia' WHERE id='$id'";

    if ($conexao->query($sqlUpdate) === TRUE) {
        echo "Atualizado com sucesso";
    } else {
        echo "Erro ao atualizar: " . $conexao->error;
    }
    
    $conexao->close();
}

header('Location: sistemanota.php');
?>