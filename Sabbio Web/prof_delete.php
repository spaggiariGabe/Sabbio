<?php

    if(!empty($_GET['id']))
    {
        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM professores WHERE id_professor=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM professores WHERE id_professor=$id";
            $resultDelete = $conexao->query($sqlDelete);
        }
    }
    header('Location: sistemaprof.php');
