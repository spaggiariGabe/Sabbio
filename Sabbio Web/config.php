<?php

$dbHost = '127.0.0.1:3306';
$dbUsername = 'u211327283_sabbioapp';
$dbPassword = 'Rodrigo121804';
$dbName ='u211327283_cadastros';

$conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

/*if($conexao->connect_errno)
{
   echo "Erro";
}
else{
    echo "Cadastro efetuado com Sucesso!";
}
*/
?>