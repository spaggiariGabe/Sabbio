<?php
// Verifica se o ID da turma foi passado via GET
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_turma = $_GET['id'];

    // Incluir o arquivo de configuração do banco de dados
    include_once('config.php');

    // Consulta SQL para obter todas as matérias do mesmo curso da turma
    $sql_materias = "SELECT materias.id_materia, materias.nome_materia 
                     FROM materias 
                     INNER JOIN cursos ON materias.id_curso = cursos.id_curso
                     INNER JOIN turmas ON cursos.id_curso = turmas.id_curso
                     WHERE turmas.id_turma = '$id_turma'";
    $result_materias = $conexao->query($sql_materias);

    // Verifica se há matérias disponíveis para essa turma
    $num_materias = $result_materias->num_rows;

    // Define uma variável para controlar a exibição do erro
    $erro = false;

    // Verifica se o formulário foi submetido
    if(isset($_POST['submit'])) {
        // Obtém as matérias selecionadas do formulário
        if(isset($_POST['materias']) && is_array($_POST['materias'])) {
            $materias_selecionadas = $_POST['materias'];

            // Itera sobre as matérias selecionadas
            foreach($materias_selecionadas as $id_materia) {
                // Verifica se a combinação de id_materia e id_turma já existe na tabela materia_turma
                $sql_check_existence = "SELECT * FROM materia_turma 
                                        WHERE id_materia = '$id_materia' 
                                        AND id_turma = '$id_turma'";
                $result_check_existence = $conexao->query($sql_check_existence);

                if($result_check_existence->num_rows == 0) {
                    // Se não existe, insere na tabela materia_turma
                    $query_insert = "INSERT INTO materia_turma (id_materia, id_turma) 
                                     VALUES ('$id_materia', '$id_turma')";
                    $result_insert = $conexao->query($query_insert);
                } else {
                    // Se já existe, define a variável de erro como true
                    $erro = true;
                }
            }

            // Verifica se a inserção foi bem-sucedida e se houve erro
            if(isset($result_insert) && $result_insert && !$erro) {
                echo "<script>alert('Matérias adicionadas com sucesso para a turma.');</script>";
            } 
        }
    }
} else {
    // Se o ID da turma não foi passado, redireciona para a página anterior
    header("Location: sistematurma.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adicionar Matérias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0a6496, #149650);
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: 0 auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #71ca96;
        }
        select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
            text-align: left;
        }
        input[type="submit"], a.button {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.2);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
            box-sizing: border-box;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        input[type="submit"]:hover, a.button:hover {
            background-color: #4bc685;
            transform: scale(1.05);
        }
        a.button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Adicionar Matérias para a Turma</h1>
    <div class="container">

        <form action="" method="POST">
            <h2>Matérias Disponíveis</h2>
            <select name="materias[]" >
                <?php
                if($num_materias > 0) {
                    while($materia = $result_materias->fetch_assoc()) {
                        echo "<option value='".$materia['id_materia']."'>".$materia['nome_materia']."</option>";
                    }
                } else {
                    echo "<option>Nenhuma matéria disponível para essa turma</option>";
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Adicionar Matérias">
        </form>
        <?php 
            // Se houver erro, exibe a mensagem de erro
            if($erro) {
                echo "<p style='color: red;'>Erro: A matéria já foi adicionada a esta turma.</p>";
            }
        ?>
        <a href="sistematurma.php" class="button">Voltar</a>
    </div>
</body>
</html>
