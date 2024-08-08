<?php
session_start();

if(!empty($_GET['id'])) {
    include_once('config.php');

    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM alunos WHERE id_alunos=$id";

    $result = $conexao->query($sqlSelect);
    
    if($result->num_rows > 0) {
        while($user_data = $result->fetch_assoc()) {   
            $nome = $user_data['nome'];
            $cpf = $user_data['cpf'];
            $rg = $user_data['rg'];
            $email = $user_data['email'];
            $telefone = $user_data['telefone'];
            $curso = $user_data['id_curso'];
            $turma = $user_data['id_turma'];
            $data_nasc = $user_data['data_nasc'];
            $sexo = $user_data['sexo'];
            $cidade = $user_data['cidade'];
            $estado = $user_data['estado'];
            $rua = $user_data['rua'];
            $numero = $user_data['numero'];
            $email_inst = $user_data['email_inst'];
            $senha = $user_data['senha'];
        }
    } else {
        header('Location: sistema.php');
        exit();
    }
} else {
    header('Location: sistema.php');
    exit();
}

// Consulta para carregar os cursos
$sqlCursos = "SELECT * FROM cursos";
$resultCursos = $conexao->query($sqlCursos);

// Consulta para carregar as turmas
$sqlTurmas = "SELECT * FROM turmas WHERE id_curso='$curso'";
$resultTurmas = $conexao->query($sqlTurmas);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Cadastro de Aluno</title>
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
            border: 1px solid rgb(75, 198, 133);
            border-radius: 15px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
        }
        #submit:hover{
            background-color: rgb(75, 198, 133);
        }
        #update{
            text-decoration: none;
            width: 200px;
            border: 1px solid rgb(75, 198, 133);
            border-radius: 15px;
            padding: 8px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.2);
        }
        #update:hover{
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
        }
        a:hover{
            background-color: rgb(10, 100, 150);
        }
</style>
</head>
<body>
    <div class="box">
        <form action="saveEdit.php" method="POST">
            <fieldset>
                <legend><b>Editar Cadastro</b></legend>
                <br><br>
                <!-- Nome Completo -->
                <label for="nome">Nome completo:</label><br>
                <input type="text" name="nome" id="nome" value="<?php echo $nome; ?>" required><br><br>
                
                <!-- CPF -->
                <label for="cpf">CPF com pontuação:</label><br>
                <input type="text" name="cpf" id="cpf" value="<?php echo $cpf; ?>" oninput="formatarCPF(this)" required><br><br>
                
                <!-- RG -->
                <label for="rg">RG com pontuação:</label><br>
                <input type="text" name="rg" id="rg" value="<?php echo $rg; ?>" oninput="formatarRG(this)" required><br><br>
                
                <!-- E-mail -->
                <label for="email">E-mail:</label><br>
                <input type="email" name="email" id="email" value="<?php echo $email; ?>" required><br><br>
                
                <!-- Telefone -->
                <label for="telefone">Telefone:</label><br>
                <input type="tel" name="telefone" id="telefone" value="<?php echo $telefone; ?>" oninput="formatarTelefone(this)" required><br><br>
                
                <!-- Curso -->
                <div class="inputBox">
                    <label for="curso">Curso: </label>
                    <select name="curso" id="curso" required>
                        <option value="">Selecione um curso</option>
                        <?php
                        // Conexão com o banco de dados
                        include_once('config.php');

                        // Query para selecionar os cursos
                        $query_cursos = "SELECT * FROM cursos";
                        $resultado_cursos = mysqli_query($conexao, $query_cursos);

                        // Verificar se há cursos cadastrados
                        if (mysqli_num_rows($resultado_cursos) > 0) {
                            // Loop através dos resultados para preencher as opções do select
                            while ($row = mysqli_fetch_assoc($resultado_cursos)) {
                                echo '<option value="' . $row['id_curso'] . '">' . $row['nome_curso'] . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>Nenhum curso cadastrado</option>';
                        }
                        ?>
                    </select>
                </div>
                <br><br>
                
                <!-- Turma -->
                <div class="inputBox">
                    <label for="turma">Turma: </label>
                    <select name="turma" id="turma">
                        <option value="">Selecione um curso primeiro</option>
                    </select>
                </div>
                <br><br>
                
                <!-- Data de Nascimento -->
                <div class="inputBox">
                    <label for="data_nasc">Data de Nascimento: </label>
                    <input type="date" name="data_nasc" id="data_nasc" class="inputUser" value="<?php echo $data_nasc_formatada; ?>" required>
                </div>
                <br><br>
                
                <!-- Sexo -->
                <div class="inputBox">
                    <label for="sexo">Sexo: </label>
                    <select name="genero">
                        <option value="">Selecione...</option>
                        <option value="feminino">Feminino</option>
                        <option value="masculino">Masculino</option>
                    </select>
                </div>
                <br><br>
                
                <!-- Cidade -->
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" value="<?php echo $cidade; ?>" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                
                <!-- Estado -->
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" value="<?php echo $estado; ?>" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                
                <!-- Rua -->
                <div class="inputBox">
                    <input type="text" name="rua" id="rua" class="inputUser" value="<?php echo $rua; ?>" required>
                    <label for="rua" class="labelInput">Rua</label>
                </div>
                <br><br>
                
                <!-- Número -->
                <div class="inputBox">
                    <input type="text" name="numero" id="numero" class="inputUser" value="<?php echo $numero; ?>" required>
                    <label for="numero" class="labelInput">Numero</label>
                </div>
                <br><br>
                
                <!-- E-mail Institucional -->
                <div class="inputBox">
                    <input type="email" name="email_inst" id="email_inst" class="inputUser" value="<?php echo $email_inst; ?>" required>
                    <label for="email_inst" class="labelInput">E-mail Institucional</label>
                </div>
                <br><br>
                
                <!-- Senha -->
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" value="<?php echo $senha; ?>" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>
                
                <!-- Botão de atualizar -->
                <a href="sistema.php">Voltar</a>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" name="update" id="update" value="Atualizar">
            </fieldset>
        </form>
    </div>
</body>
</html>

<script>
     document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('curso').addEventListener('change', function() {
                var cursoId = this.value;
                var turmaSelect = document.getElementById('turma');

                // Limpar as opções atuais do campo de turma
                turmaSelect.innerHTML = '<option value="">Carregando...</option>';

                // Requisição AJAX para obter as turmas relacionadas ao curso
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'obter_turmas_curso.php?curso_id=' + cursoId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Atualizar as opções do campo de turma com as turmas recebidas
                        turmaSelect.innerHTML = xhr.responseText;
                    } else {
                        // Tratar erros de requisição
                        turmaSelect.innerHTML = '<option value="">Erro ao carregar turmas</option>';
                    }
                };
                xhr.send();
            });
        });
         function formatarCPF(campo) {
            campo.value = campo.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }
        
        function formatarRG(campo) {
            campo.value = campo.value.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");
        }

        function formatarTelefone(campo) {
            campo.value = campo.value.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
        }
        
</script>
