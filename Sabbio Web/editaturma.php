<?php
$mensagem_erro = $mensagem_sucesso = '';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    include_once('config.php');
    
    $id_turma = $_GET['id'];
    
    $query = "SELECT * FROM turmas WHERE id_turma = '$id_turma'";
    $result = mysqli_query($conexao, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $nome_turma = $row['nome_turma'];
        $codigo_turma = $row['codigo_turma'];
        $periodo = $row['periodo'];
        $semestre = $row['semestre'];
        $id_curso = $row['id_curso'];
    } else {
        header("Location: sistematurma.php");
        exit();
    }
} else {
    header("Location: sistematurma.php");
    exit();
}

if(isset($_POST['editar_turma'])) {
    $nome_turma_novo = $_POST['nome_turma'];
    $codigo_turma_novo = $_POST['codigo_turma'];
    $periodo_novo = $_POST['periodo'];
    $semestre_novo = $_POST['semestre'];
    $id_curso_novo = $_POST['id_curso'];
    
    // Verifica se o código da turma já existe
    $query_check = "SELECT * FROM turmas WHERE codigo_turma = '$codigo_turma_novo' AND id_turma != '$id_turma'";
    $result_check = mysqli_query($conexao, $query_check);
    if(mysqli_num_rows($result_check) > 0) {
        $mensagem_erro = "O código da turma já está em uso. Por favor, escolha outro.";
    } else {
        $query_update = "UPDATE turmas SET nome_turma = '$nome_turma_novo', codigo_turma = '$codigo_turma_novo', 
                        periodo = '$periodo_novo', semestre = '$semestre_novo', id_curso = '$id_curso_novo' 
                        WHERE id_turma = '$id_turma'";
        $result_update = mysqli_query($conexao, $query_update);
        
        if($result_update) {
            header("Location: sistematurma.php?sucesso=".urlencode($mensagem_sucesso));
            exit(); 
        } else {
            $mensagem_erro = "Erro ao editar a turma. Por favor, tente novamente.";
        }
    }
}

// Consulta SQL para buscar todos os cursos
$query_cursos = "SELECT * FROM cursos";
$result_cursos = mysqli_query($conexao, $query_cursos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: whitesmoke;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }
        a, input[type="text"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: whitesmoke;
            box-sizing: border-box;
            text-decoration: none; /* Adicionado para remover o sublinhado */
            display: block; /* Adicionado para o botão ocupar a largura total */
        }
        input[type="submit"], a {
            background-color: rgb(0, 0, 0, 0.3);
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block; /* Adicionado para o alinhamento horizontal */
            margin-right: 5px; /* Adicionado para espaçamento entre os botões */
            text-align: center; /* Centraliza o texto */
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
        }
        label {
            color: whitesmoke;
            margin-top: 10px;
            display: block;
        }
        .mensagem {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .mensagem-erro {
            background-color: #ff9999;
        }
        .mensagem-sucesso {
            background-color: #99ff99;
        }
    </style>
</head>
<body>
     <div class="container">
        <h1>Editar Turma</h1>
        <!-- Exibir mensagem de erro -->
        <?php if(!empty($mensagem_erro)): ?>
            <div class="mensagem mensagem-erro"><?php echo $mensagem_erro; ?></div>
        <?php endif; ?>
        <!-- Exibir mensagem de sucesso -->
        <?php if(!empty($mensagem_sucesso)): ?>
            <div class="mensagem mensagem-sucesso"><?php echo $mensagem_sucesso; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="nome_turma">Nome da Turma:</label>
            <input type="text" id="nome_turma" name="nome_turma" value="<?php echo $nome_turma; ?>" required>
            
            <label for="codigo_turma">Código da Turma:</label>
            <input type="text" id="codigo_turma" name="codigo_turma" value="<?php echo $codigo_turma; ?>" required>
            
            <label for="periodo">Período:</label>
            <input type="text" id="periodo" name="periodo" value="<?php echo $periodo; ?>" required>
            
            <label for="semestre">Semestre:</label>
            <input type="text" id="semestre" name="semestre" value="<?php echo $semestre; ?>" required>
            
            <label for="id_curso">Curso:</label>
            <select id="id_curso" name="id_curso" required>
                <?php
                // Loop para exibir todas as opções de cursos
                while($row_curso = mysqli_fetch_assoc($result_cursos)) {
                    $curso_id = $row_curso['id_curso'];
                    $curso_nome = $row_curso['nome_curso'];
                    // Marcar a opção selecionada
                    $selected = ($curso_id == $id_curso) ? 'selected' : '';
                    echo "<option value='$curso_id' $selected>$curso_nome</option>";
                }
                ?>
            </select>
            
            <input type="submit" name="editar_turma" value="Salvar Alterações">
            <a href="sistematurma.php" class="btn-voltar">Voltar</a>
        </form>
    </div>
</body>
</html>
