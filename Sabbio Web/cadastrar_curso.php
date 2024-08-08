<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Curso</title>
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
            width: calc(50% - 5px); /* Divide o espaço igualmente */
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
            margin-right: 5px; /* Adicionado espaçamento entre os botões */
            box-sizing: border-box; /* Adicionado para incluir o padding e a borda na largura */
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05); /* Aumenta ligeiramente o tamanho ao passar o mouse */
        }
    </style>
</head>
<body>
    <form action="processar_curso.php" method="POST">
        <h2>Cadastro de Curso</h2>
        <input type="text" name="nome_curso" placeholder="Nome do Curso" required>
        <input type="text" name="descricao" placeholder="Descrição do Curso" required>
        <input type="number" name="duracao" placeholder="Duração em Semestres" required>
        <input type="submit" value="Cadastrar Curso">
        <a href="home.php">Voltar</a>
    </form>
</body>
</html>
