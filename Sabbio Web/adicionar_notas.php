<?php
session_start();
include_once('config.php');

// Verifica se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: loginprof.php');
    exit();
}

// Verifica se o ID da turma foi passado via GET
if (!isset($_GET['id_turma'])) {
    echo "ID da turma não especificado.";
    exit();
}

// ID do professor logado
$id_professor = $_SESSION['id_professor'];

// ID da turma
$id_turma = $_GET['id_turma'];

// ID da matéria (adicione esta linha)
$id_materia = $_GET['id_materia']; 

// Consulta SQL para buscar os alunos da turma específica
$sql_alunos = "SELECT alunos.id_alunos, alunos.nome 
               FROM alunos 
               INNER JOIN turmas ON alunos.id_turma = turmas.id_turma
               WHERE alunos.id_turma = $id_turma";
$result_alunos = $conexao->query($sql_alunos);

// Consulta SQL para buscar os tipos de nota disponíveis
$sql_tipos_notas = "SELECT * FROM tipos_notas";
$result_tipos_notas = $conexao->query($sql_tipos_notas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=yes">
    <title>Adicionar Notas</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        select, input[type="number"], input[type="submit"] {
            margin-top: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        a {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Adicionar Notas</h1>
        <form action="processar_notas.php?id_materia=<?php echo $id_materia; ?>" method="POST"> <!-- Adicionado o id_materia aqui -->
            <input type="hidden" name="id_turma" value="<?php echo $id_turma; ?>">
            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
            <label for="tipo_nota">Tipo de Nota:</label>
            <select name="tipo_nota" id="tipo_nota">
                <?php while($tipo_nota = $result_tipos_notas->fetch_assoc()): ?>
                    <?php if ($tipo_nota['nome'] !== 'N2'): ?>
                        <option value="<?php echo $tipo_nota['id']; ?>"><?php echo $tipo_nota['nome']; ?></option>
                    <?php endif; ?>
                <?php endwhile; ?>
            </select>
            <table>
                <thead>
                    <tr>
                        <th>ID Aluno</th>
                        <th>Nome</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($aluno = $result_alunos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $aluno['id_alunos']; ?></td>
                            <td><?php echo $aluno['nome']; ?></td>
                            <td><input type="number" name="notas[<?php echo $aluno['id_alunos']; ?>]" min="0" max="10" step="0.1"></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <input type="submit" value="Adicionar Notas">
            <a href="turmas.php">Voltar</a>
        </form>
    </div>
</body>
</html>
