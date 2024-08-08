<?php
session_start();
include_once('config.php');

// Verifica se o professor está logado
if(!isset($_SESSION['id_professor'])) {
    header('Location: loginprof.php');
    exit();
}

// ID do professor logado
$id_professor = $_SESSION['id_professor'];

$sql = "SELECT turmas.id_turma, turmas.nome_turma, turmas.codigo_turma, turmas.periodo, turmas.semestre, turmas.id_curso, materia_turma.id_materia, materias.nome_materia, cursos.nome_curso 
        FROM turmas 
        INNER JOIN cursos ON turmas.id_curso = cursos.id_curso
        INNER JOIN materia_turma ON turmas.id_turma = materia_turma.id_turma
        INNER JOIN materias ON materia_turma.id_materia = materias.id_materia
        INNER JOIN professor_turma ON turmas.id_turma = professor_turma.id_turma
        INNER JOIN professor_materia ON professor_materia.id_materia = materia_turma.id_materia
        WHERE professor_turma.id_professor = $id_professor
        GROUP BY turmas.id_turma, materias.id_materia  -- Agrupa por turma e matéria
        ORDER BY cursos.nome_curso";


$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=yes">
    <title>Lista de Turmas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: whitesmoke;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 8px;
            border: none;
            border-radius: 4px 0 0 4px;
            width: 60%; /* Ajuste o tamanho do campo de pesquisa */
            margin-right: 5px; /* Espaçamento entre o campo de texto e o botão */
        }
        .search-container button {
            padding: 8px 16px;
            border: none;
            border-radius: 0 4px 4px 0;
            background-color: rgb(0, 0, 0, 0.3);
            color: whitesmoke;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: rgb(75, 198, 133); /* Cor de fundo ao passar o mouse */
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            border: 2px solid #ddd; /* Adicionando borda à tabela */
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgb(0, 0, 0, 0.5);
            color: white; /* Mudando a cor do texto no cabeçalho */
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .actions-column a {
            text-decoration: none;
            color: white;
            padding: 6px 12px;
            background-color: rgb(0, 0, 0, 0.5);
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-right: 5px; /* Adicionando espaçamento entre os botões */
        }
        .actions-column a:hover {
            background-color: rgb(20, 150, 80);
        }
        .footer-links {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
        input[type="submit"], a {
            width: calc(50% - 5px); /* Divide o espaço igualmente */
            padding: 10px;
            background-color: rgb(0, 0, 0, 0.5);
            color: whitesmoke;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            margin-right: 5px;
            box-sizing: border-box;
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>Lista de Turmas</h1>
    <!-- Campo de pesquisa -->
    <div class="search-container">
        <form action="turmas.php" method="GET">
            <input type="text" id="pesquisar" name="search" placeholder="Pesquisar Turma">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome da Turma</th>
                <th>Código da Turma</th>
                <th>Período</th>
                <th>Semestre</th>
                <th>Curso</th>
                <th>Matéria</th>
                <th class="actions-column">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop através dos resultados da consulta e exibir cada turma
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nome_turma'] . "</td>";
                echo "<td>" . $row['codigo_turma'] . "</td>";
                echo "<td>" . $row['periodo'] . "</td>";
                echo "<td>" . $row['semestre'] . "</td>";
                echo "<td>" . $row['nome_curso'] . "</td>";
                echo "<td>" . $row['nome_materia'] . "</td>"; 
                echo "<td class='actions-column'>";
                // Adicione os links de ação aqui, como editar, excluir, adicionar notas, adicionar faltas, etc.
                echo "<a href='adicionar_notas.php?id_turma=".$row['id_turma']."&id_materia=".$row['id_materia']."'>Adicionar Notas</a>";
                echo "<a href='adicionar_faltas.php?id_turma=".$row['id_turma']."'>Adicionar Faltas</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="footer-links">
        <a href="homeprof.php">Voltar</a>
    </div>
</body>
</html>
