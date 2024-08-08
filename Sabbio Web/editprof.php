<?php
    if(!empty($_GET['id']))
    {
        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM professores WHERE id_professor=$id";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            while($user_data = mysqli_fetch_assoc($result))
            {   
                $nome = $user_data['nome'];
                $cpf = $user_data['cpf'];
                $telefone = $user_data['telefone'];
                $email = $user_data['email'];
                $senha = $user_data['senha'];
            }
        }
        else
        {
            header('Location: sistemaprof.php');
        }
    }
    else
    {
        header('Location: sistemaprof.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=0, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Editar Cadastro de Professor</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            color: whitesmoke;
        }
        .box{
            color: aliceblue;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.4);
            padding: 10px;
            border-radius: 15px;
            width: 335px;
            font-size: 14px;
            text-align: center;
        }
        fieldset{
            border: 1px solid rgb(113, 202, 150);
            border-radius: 15px;
        }
        legend{
            border: 1px solid rgb(113, 202, 150);
            padding: 5px;
            width: 250px;
            text-align: center;
            background-color: rgb(113, 202, 150);
            border-radius: 10px;
        }
        .inputBox{
            position: relative;
            margin-bottom: 20px;
        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: aliceblue;
            font-size: 15px;
            width: 300px;
            letter-spacing: 1px;
        }
        .labelInput{
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            transition: .3s;
            color: rgba(255, 255, 255, 0.7);
        }
        .inputUser:focus ~ .labelInput, 
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 10px;
            color: rgb(0, 225, 255);
        }
        #submit{
            text-decoration: none;
            width: 200px;
            border: 1px solid rgb(75, 198, 133);
            border-radius: 15px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
            display: inline-block;
            margin-right: 10px;
        }
        #submit:hover{
            background-color: rgb(75, 198, 133);
        }
        a{
            text-decoration: none;
            border: 1px solid rgb(75, 198, 133);
            border-radius: 15px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
            display: inline-block;
        }
        a:hover{
            background-color: rgb(10, 100, 150);
        }
    </style>
</head>
<body>
    <div class="box">
        <form action="saveEditprof.php" method="POST">
            <fieldset>
                <legend><b>Editar Cadastro</b></legend>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" value="<?php echo $nome; ?>" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="cpf" size="14" maxlength="14" id="cpf" class="inputUser" value="<?php echo $cpf; ?>" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" value="<?php echo $email; ?>" required>
                    <label for="email" class="labelInput">E-mail</label>
                </div>
                <div class="inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" value="<?php echo $telefone; ?>" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="senha" id="senha" class="inputUser" value="<?php echo $senha; ?>" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <a href="sistemaprof.php">Voltar</a>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" name="update" id="submit" value="Atualizar">
            </fieldset>
        </form>
    </div>
</body>
</html>
