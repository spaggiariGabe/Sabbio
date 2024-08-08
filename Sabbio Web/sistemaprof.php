<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Lista de Professores</title>
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
        .actions-column {
            text-align: center;
        }
        .actions-column a {
            display: block;
            margin-bottom: 5px;
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
        .footer-links a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px;
            background-color: rgb(0, 0, 0, 0.2);
            color: whitesmoke;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
        }
        .footer-links a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>Lista de Professores</h1>
    <!-- Campo de pesquisa -->
    <div class="search-container">
        <form action="sistemaprof.php" method="GET">
            <input type="text" id="pesquisar" name="search" placeholder="Pesquisar Professor">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <!-- Lista de professores -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Email</th>
                <!-- Adicione mais colunas conforme necessário -->
                <th class="actions-column">Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aqui serão listados os professores cadastrados -->
            <?php
                // Conexão com o banco de dados e consulta dos professores
                include_once('config.php');

                // Verifica se há parâmetro de pesquisa
                $filtro_pesquisa = "";
                if(isset($_GET['search'])) {
                    $filtro_pesquisa = " WHERE nome LIKE '%".$_GET['search']."%'";
                }

                $sql = "SELECT * FROM professores" . $filtro_pesquisa;
                $result = $conexao->query($sql);

                // Lista os professores
                while($professor = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$professor['id_professor']."</td>";
                    echo "<td>".$professor['nome']."</td>";
                    echo "<td>".$professor['cpf']."</td>";
                    echo "<td>".$professor['telefone']."</td>";
                    echo "<td>".$professor['email']."</td>";
                    // Adicione mais colunas com outros dados do professor, se necessário
                    echo "<td class='actions-column'>";
                    echo "<a href='editprof.php?id=".$professor['id_professor']."'>Editar</a>";
                    echo "<a href='prof_delete.php?id=".$professor['id_professor']."' style='background-color: rgb(220, 53, 69);'>Excluir</a>";
                    echo "<a href='adicionar_materia_prof.php?id=".$professor['id_professor']."'>Adicionar Matéria</a>";
                    echo "<a href='adicionar_turma_prof.php?id=".$professor['id_professor']."'>Adicionar Turma</a>";

                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

    <!-- Link para cadastrar novo professor -->
    <div class="footer-links">
        <a href="cadastrar_prof.php">Cadastrar Novo Professor</a>
        <a href="home.php">Voltar</a>
    </div>
</body>
</html>
