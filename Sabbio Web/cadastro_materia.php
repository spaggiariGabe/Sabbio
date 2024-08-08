<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Matéria</title>
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
        input[type="text"], select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
        }
        input[type="submit"], a {
            width: calc(100% - 20px);
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
            box-sizing: border-box;
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <form action="processar_materia.php" method="POST" id="materiaForm">
        <h2>Cadastro de Matéria</h2>
        <input type="text" name="id_materia" placeholder="ID da Matéria" required>
        <input type="text" name="nome_materia" placeholder="Nome da Matéria" required>
        <select name="id_curso" id="id_curso" required onchange="getProfessores(this.value); getSemestres(this.value)">
    <option value="">Selecione o curso...</option>
    <?php
    include_once('config.php');
    $query = "SELECT id_curso, nome_curso, duracao_semestres FROM cursos";
    $result = mysqli_query($conexao, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['id_curso'] . "' data-duracao='" . $row['duracao_semestres'] . "'>" . $row['nome_curso'] . "</option>";
    }
    ?>


        <input type="submit" value="Cadastrar Matéria">
        <a href="home.php">Voltar</a>
    </form>

    <script>

    </script>
</body>
</html>

