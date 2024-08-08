<?php
session_start();

if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email_inst = $_POST['email_inst'];
    $senha = $_POST['senha'];

    // Validar CPF
    if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        $_SESSION['error'] = 'CPF inválido.';
        header('Location: simples.php');
        exit();
    }

    // Validar telefone
    if (!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $telefone)) {
        $_SESSION['error'] = 'Telefone inválido.';
        header('Location: simples.php');
        exit();
    }

    // Validar senha
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/", $senha)) {
        $_SESSION['error'] = 'A senha deve conter pelo menos 7 caracteres, incluindo pelo menos uma letra maiúscula e um número.';
        header('Location: simples.php');
        exit();
    }

    // Verificar se o email institucional já está cadastrado
    $query_verificar_email_inst = "SELECT * FROM alunos WHERE email_inst = '$email_inst'";
    $resultado_verificar_email_inst = mysqli_query($conexao, $query_verificar_email_inst);

    // Verificar se o CPF já está cadastrado
    $query_verificar_cpf = "SELECT * FROM alunos WHERE cpf = '$cpf'";
    $resultado_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);

    if(mysqli_num_rows($resultado_verificar_email_inst) > 0) {
        // Se houver registros com o mesmo email institucional, exibir mensagem de erro
        $_SESSION['error'] = 'Este email institucional já está em uso. Por favor, escolha outro.';
    } elseif(mysqli_num_rows($resultado_verificar_cpf) > 0) {
        // Se houver registros com o mesmo CPF, exibir mensagem de erro
        $_SESSION['error'] = 'Este CPF já está cadastrado.';
    } else {
        // Se o email institucional e o CPF não estiverem em uso, inserir o novo registro
        $query_inserir_alunos = "INSERT INTO alunos (nome, cpf, telefone, email_inst, senha)
                                VALUES ('$nome', '$cpf', '$telefone', '$email_inst', '$senha')";
        $resultado_inserir_alunos = mysqli_query($conexao, $query_inserir_alunos);
    
        if($resultado_inserir_alunos) {
            $_SESSION['success'] = 'Cadastro realizado com sucesso.';
        } else {
            $_SESSION['error'] = 'Erro ao cadastrar aluno. Por favor, tente novamente.';
        }
    }
    header('Location: simples.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=0, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Cadastro Simples de Aluno</title>
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
            border-radius:5px;
            width: 335px;
            font-size: 14px;
            text-align: center;
        }
        fieldset{
            border: 1px solid rgb(113, 202, 150);
            border-radius: 5px;
        }
        legend{
            padding: 5px;
            width: 250px;
            text-align: center;
            background-color: rgb(113, 202, 150);
            border-radius: 5px;
        }
        .inputBox{
            position: absolute;
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
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .3s;
        }
        .inputUser:focus ~ .labelInput, 
        .inputUser:valid ~ .labelInput{
            top: -10px;
            font-size: 10px;
            color: rgb(0, 225, 255);
        }
        #data_nasc{
            color: black;
            border: none;
            padding: 2px;
            background-color: aliceblue;
            width: fit-content;
            outline: none;
            font-size: 14px;
        }
        #submit{
            text-decoration: none;
            width: 200px;
            border-radius: 5px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
        }
        #submit:hover{
            background-color: rgb(75, 198, 133);
        }
        a{
            text-decoration: none;
            border-radius: 5px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
        }
        a:hover{
            background-color: rgb(10, 100, 150);
        }
    </style>
    <script>
        function formatarCPF(campo) {
            campo.value = campo.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }
        
        function formatarTelefone(campo) {
            campo.value = campo.value.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
        }
    </script>
</head>
<body>
    <div class="box">
        <?php
        if(isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])) {
            echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>
        <form action="simples.php" method="POST">
            <fieldset>
            <legend><b>Cadastro Rápido de Aluno</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" size="14" maxlength="14" id="cpf" class="inputUser" oninput="formatarCPF(this)" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" oninput="formatarTelefone(this)" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email_inst" id="email_inst" class="inputUser" required>
                    <label for="email_inst" class="labelInput">E-mail Institucional</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br><br>
                <div>
                    <a href="home.php">Voltar</a>
                    <input type="submit" name="submit" id="submit">
                </div>
                <br><br>
                <div>
                    <a href="formulario.php">Ir para Cadastro Completo</a>
                </div>
                <br><br>
                </fieldset>
            </form>
        </div>
    </body>
</html>
