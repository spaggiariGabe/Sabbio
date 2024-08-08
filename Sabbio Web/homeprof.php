<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal do Professor</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: whitesmoke;
            text-align: center;
        }
        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.4);
            padding: 40px;
            width: 300px;
            border-radius: 5px;
            text-align: center;
        }
        h1 {
            color: rgb(75, 198, 133);
            font-size: 24px;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            display: block;
            background-color: rgb(0, 0, 0, 0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        a:hover {
            background-color: rgb(20, 150, 80);
        }
    </style>
</head>
<body>
    <div class="box">
        <img class="b2" src="./logosappio.png"
            width="250"
            height="140"
            alt="Sabbio"/>
            <br><br><br><br><br>
        <h1>Bem-vindo, <?php echo $_SESSION['nome_professor']; ?>!</h1>
        <a href="turmas.php">Ver Turmas</a>
        <a href="editar_faltas.php">Editar Falta</a>
        <a href="loginprof.php">Sair</a>
    </div>
</body>
</html>
