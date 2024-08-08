<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Tela de Login</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: whitesmoke;
        }
        .box{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgb(0, 0, 0, 0.4);
            padding: 40px;
            width: 250px;
            height: 500px;
            text-align: center;
            border-radius: 5px;
        }
        .agg{
            border-radius: 5px;
            padding: 8px;
            text-align: center;
            width: 120px;
            color: white;
            background-color: rgb(0, 0, 0, 0.2);
        }
        .agg:hover{
            background-color: rgb(20, 150, 80);
        }
        .b2{
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        h1{
            color: rgb(75, 198, 133);
            font-size: 16px;
        }
        .ema{
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        a{
            position: absolute;
            top: 95%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-decoration: none;
            border-radius: 5px;
            padding: 8px;
            width: 200px;
            color: white;
            font-size: 12px;
            text-align: center;
            background-color: rgb(0, 0, 0, 0.1);
        }
        a:hover{
            background-color: rgb(10, 100, 150);
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="box">
        <img class=b2 src="./logosappio.png"
        width="250"
        height="140"
        alt="Sabbio"/>
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <h1>Login de Professor</h1>
        <form action="testLoginprof.php" method="POST">
            <input class="ema" type="text" name="email" placeholder="Email">
            <br><br>
            <input class="ema" type="password" name="senha" placeholder="Senha">
            <br><br><br>
            <input class="agg" type="submit" name="submit" value="Entrar">
            <a href="default.php">Voltar para a área da Administração</a>
        </form>
        <?php
        session_start();
        if(isset($_SESSION['error'])) {
            // Exibir mensagem de erro
            echo "<div class='error-message'>".$_SESSION['error']."</div>";
            unset($_SESSION['error']); // Limpar a mensagem de erro da sessão após exibir
        }
        ?>
    </div>
</body>
</html>