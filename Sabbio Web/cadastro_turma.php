<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Turma</title>
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
        form {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: rgb(113, 202, 150);
        }
         input[type="text"], input[type="number"], select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
        }
        input[type="submit"], a {
            width: calc(100% - 20px); /* Utiliza 100% do espaço disponível */
            padding: 10px;
            background-color: rgb(0, 0, 0, 0.2);
            color: whitesmoke;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none; /* Adicionado para remover o sublinhado do link */
            display: inline-block; /* Adicionado para alinhar o link ao lado do botão */
            margin-top: 10px; /* Adicionado para separar o botão "Voltar" do botão "Cadastrar Turma" */
            box-sizing: border-box; /* Adicionado para incluir o padding e a borda na largura */
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05); /* Aumenta ligeiramente o tamanho ao passar o mouse */
        }
    </style>
</head>
<body>
    <form action="processar_turma.php" method="POST">
        <h2>Cadastro de Turma</h2>
        
        <!-- Campo para selecionar o curso -->
        <select name="id_curso" required onchange="updateSemestres(this.value)">
            <option value="">Selecione o curso...</option>
            <?php
            include_once('config.php');
            $query = "SELECT id_curso, nome_curso, duracao_semestres FROM cursos";
            $result = mysqli_query($conexao, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id_curso'] . "' data-duracao='" . $row['duracao_semestres'] . "'>" . $row['nome_curso'] . "</option>";
            }
            ?>
        </select>
        
        <!-- Campo para selecionar o semestre -->
        <select name="semestre" id="semestre" required disabled>
            <option value="">Selecione o semestre...</option>
        </select>
        
        <input type="text" name="nome_turma" placeholder="Nome da Turma" required>
        <input type="text" name="codigo_turma" placeholder="Código da Turma" required>
        <input type="text" name="periodo" placeholder="Período" required>

        <input type="submit" value="Cadastrar Turma">
        <a href="home.php">Voltar</a>
    </form>

    <script>
        // Atualiza as opções de semestre com base na duração do curso selecionado
        function updateSemestres(cursoId) {
            var duracaoSemestres = parseInt(document.querySelector('select[name="id_curso"] [value="' + cursoId + '"]').getAttribute('data-duracao'));
            var semestreSelect = document.getElementById('semestre');
            semestreSelect.innerHTML = '<option value="">Selecione o semestre...</option>';
            for (var i = 1; i <= duracaoSemestres; i++) {
                semestreSelect.innerHTML += '<option value="' + i + '">' + i + 'º Semestre</option>';
            }
            semestreSelect.disabled = false;
        }
    </script>
</body>
</html>
