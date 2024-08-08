<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
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
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgb(0, 0, 0, 0.3);
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .actions-column a {
            text-decoration: none;
            color: white;
            padding: 6px 12px;
            background-color: rgb(0, 0, 0, 0.3);
            border-radius: 4px;
            transition: background-color 0.3s;
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
            background-color: rgb(0, 0, 0, 0.2);
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
        <form action="sistematurma.php" method="GET">
            <input type="text" id="pesquisar" name="search" placeholder="Pesquisar Turma">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <!-- Lista de turmas -->
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Turma</th>
                <th>Código da Turma</th>
                <th>Período</th>
                <th>Semestre</th>
                <th>Curso</th> <!-- Alterado o cabeçalho para 'Curso' -->
                <!-- Adicione mais colunas conforme necessário -->
                <th class="actions-column">Ações</th>
            </tr>
        </thead>
       <tbody>
            <!-- Aqui serão listadas as turmas cadastradas -->
            <?php
                // Conexão com o banco de dados e consulta das turmas
                include_once('config.php');

                // Verifica se há parâmetro de pesquisa
                $filtro_pesquisa = "";
                if(isset($_GET['search'])) {
                    $filtro_pesquisa = " WHERE nome_turma LIKE '%".$_GET['search']."%'";
                }

                // Consulta SQL para buscar as turmas com o nome do curso e ordenar por nome do curso
                $sql = "SELECT turmas.id_turma, turmas.nome_turma, turmas.codigo_turma, turmas.periodo, turmas.semestre, turmas.id_curso, cursos.nome_curso 
                        FROM turmas 
                        INNER JOIN cursos ON turmas.id_curso = cursos.id_curso" . $filtro_pesquisa . " ORDER BY cursos.nome_curso";
                $result = $conexao->query($sql);

                // Lista as turmas
                while($turma = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$turma['id_turma']."</td>";
                    echo "<td>".$turma['nome_turma']."</td>";
                    echo "<td>".$turma['codigo_turma']."</td>";
                    echo "<td>".$turma['periodo']."</td>";
                    echo "<td>".$turma['semestre']."</td>";
                    echo "<td>".$turma['nome_curso']."</td>"; // Exibindo o nome do curso
                    // Adicione mais colunas com outros dados da turma, se necessário
                    echo "<td class='actions-column'>";
                    echo "<a href='editaturma.php?id=".$turma['id_turma']."'>Editar</a>";
                    echo "<a href='turma_delete.php?id=".$turma['id_turma']."' style='background-color: rgb(220, 53, 69);'>Excluir</a>";
                    // Botão para adicionar matérias
                    echo "<a href='adicionar_materias_turma.php?id=".$turma['id_turma']."' >Adicionar Matérias</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

    <!-- Link para cadastrar nova turma -->
    <div class="footer-links">
        <a href="cadastro_turma.php">Cadastrar Nova Turma</a><br>
        <a href="home.php">Voltar</a>
    </div>
</body>
</html>