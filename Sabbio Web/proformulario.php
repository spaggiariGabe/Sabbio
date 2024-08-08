 <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor</title>
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
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
            width: 320px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: rgb(113, 202, 150);
        }
        input[type="text"], input[type="tel"], input[type="email"], input[type="password"], select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #75c7e0;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="tel"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
            border-color: #45aaf2;
            outline: none;
        }
        input[type="submit"], a {
            width: 100%;
            padding: 12px;
            background-color: rgb(0, 0, 0, 0.2);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-size: 16px;
            color: whitesmoke;
            box-sizing: border-box;
        }
        input[type="submit"]:hover, a:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <form action="processar_professor.php" method="POST" id="professorForm">
        <h2>Cadastro de Professor</h2>
        <!-- Se houver mensagens, exibe-as aqui -->
        <?php
        session_start();
        if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
            echo '<div style="margin-bottom: 10px; color: ' . ($_SESSION['message_type'] === 'error' ? 'red' : 'green') . ';">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="text" name="cpf" id="cpf" placeholder="CPF" required>
        <input type="tel" name="telefone" id="telefone" placeholder="Telefone" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>

        <!-- Seleção do Curso -->
        <select name="id_curso" required>
            <option value="" disabled selected>Selecione o Curso</option>
            <?php
            include_once('config.php');
            $sqlCursos = "SELECT * FROM cursos";
            $resultCursos = $conexao->query($sqlCursos);
            if ($resultCursos->num_rows > 0) {
                while ($rowCurso = $resultCursos->fetch_assoc()) {
                    echo "<option value='" . $rowCurso['id_curso'] . "'>" . $rowCurso['nome_curso'] . "</option>";
                }
            }
            ?>
        </select>

        <input type="submit" value="Cadastrar Professor">
        <a href="home.php">Voltar</a>
    </form>
    <script>
    
     function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g,'');
            if(cpf == '' || cpf.length != 11) {
                alert('CPF inválido. Por favor, insira 11 dígitos.');
                return false;
            }
            return true;
        }
         function validarTelefone(telefone) {
            telefone = telefone.replace(/[^\d]+/g,'');
            if(telefone == '' || telefone.length < 10 || telefone.length > 11) {
                alert('Telefone inválido. Por favor, insira entre 10 e 11 dígitos.');
                return false;
            }
            return true;
        }
        // Função para formatar o CPF
        function formatarCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            return cpf;
        }

        // Função para formatar o telefone
        function formatarTelefone(telefone) {
            telefone = telefone.replace(/\D/g, '');
            telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2');
            telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2');
            return telefone;
        }

        // Aplica as máscaras aos campos CPF e telefone
        document.getElementById('cpf').addEventListener('input', function (e) {
            var cpf = e.target.value;
            e.target.value = formatarCPF(cpf);
        });

        document.getElementById('telefone').addEventListener('input', function (e) {
            var telefone = e.target.value;
            e.target.value = formatarTelefone(telefone);
        });


    </script>
</body>
</html>