<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Completo de Aluno</title>
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
            border-radius: 5px;
            width: 335px;
            font-size: 14px;
            text-align: center;
        }
        fieldset{
            border: 1px solid rgb(113, 202, 150);
            border-radius: 5px;
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
        .mensagem {
            display: none;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .sucesso {
            background-color: rgb(92, 184, 92);
        }
        .erro {
            background-color: rgb(217, 83, 79);
        }
    </style>
    <script>
               function formatarCEP(campo) {
            // Remove caracteres não numéricos do CEP
            campo.value = campo.value.replace(/\D/g, '');
            
            // Limita a entrada de caracteres a 9 (8 dígitos + 1 caractere de formatação)
            campo.value = campo.value.substring(0, 8);
            
            // Verifica se o CEP possui mais de 5 dígitos
            if (campo.value.length > 5) {
                // Formata o CEP no padrão "00000-000"
                campo.value = campo.value.replace(/^(\d{5})(\d{1,3})$/, "$1-$2");
            }
        }

       function validarCEP(campo) {
            var cep = campo.value.replace(/\D/g, '');

            // Verifica se o CEP possui 8 dígitos após a formatação
            if (cep.length !== 8) {
                // Exibe mensagem de erro
                campo.setCustomValidity('CEP inválido! Insira um CEP válido.');
            } else {
                // Limpa a mensagem de erro, caso exista
                campo.setCustomValidity('');
            }
        }

        // Evento para formatar o CEP quando o usuário digitar
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cep').addEventListener('input', function() {
                formatarCEP(this);
                validarCEP(this);
            });

            document.getElementById('telefone').addEventListener('input', function() {
                formatarTelefone(this);
            });
        });
        function formatarCPF(campo) {
            campo.value = campo.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }
        
        function formatarRG(campo) {
            campo.value = campo.value.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");
        }

       function formatarTelefone(campo) {
            // Remove caracteres não numéricos do telefone
            campo.value = campo.value.replace(/\D/g, '');
            
            // Limita a entrada de caracteres a 14 (11 dígitos + 3 caracteres de formatação)
            campo.value = campo.value.substring(0, 14);
            
            // Verifica se o telefone possui mais de 2 dígitos (código de área)
            if (campo.value.length > 2) {
                // Formata o telefone no padrão "(00) 00000-0000"
                campo.value = campo.value.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
            }
        }

        // Função para carregar as turmas relacionadas ao curso selecionado
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
        
        function buscarCEP(cep) {
            // Remove caracteres não numéricos do CEP
            cep = cep.replace(/\D/g, '');

            // Verifica se o CEP possui 8 dígitos
            if (cep.length === 8) {
                // URL da API ViaCEP
                var url = 'https://viacep.com.br/ws/' + cep + '/json/';

                // Requisição AJAX para obter os dados do endereço
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Parse dos dados JSON recebidos
                        var endereco = JSON.parse(xhr.responseText);

                        // Preenche os campos de endereço com os dados recebidos
                        document.getElementById('cidade').value = endereco.localidade;
                        document.getElementById('estado').value = endereco.uf;
                        document.getElementById('rua').value = endereco.logradouro;
                        // Aqui você pode preencher mais campos se necessário, como bairro e complemento
                    } else {
                        // Tratar erros de requisição
                        console.error('Erro ao buscar endereço: ' + xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Erro ao buscar endereço: falha na conexão.');
                };
                xhr.send();
            }
        }
        

    </script>
</head>
<body>
    <div class="box">
        <?php
        if(isset($_GET['error'])) {
            echo '<p style="color: red;">' . $_GET['error'] . '</p>';
        }
        if(isset($_GET['success'])) {
            echo '<p style="color: green;">' . $_GET['success'] . '</p>';
        }
        ?>
        <form action="processar_aluno.php" method="POST">
            <fieldset>
                <legend><b>Cadastro Completo de Aluno</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="matricula" id="matricula" class="inputUser" required>
                    <label for="matricula" class="labelInput">Matrícula</label>
                </div>
                <br><br>
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
                    <input type="text" name="rg" size="12" maxlength="12" id="rg" class="inputUser" oninput="formatarRG(this)" required>
                    <label for="rg" class="labelInput">RG</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">E-mail</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="telefone" id="telefone" class="inputUser" oninput="formatarTelefone(this)" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="curso">Curso: </label>
                    <select name="curso" id="curso" required>
                        <option value="">Selecione um curso</option>
                        <?php
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
                <div class="inputBox">
                    <label for="turma">Turma: </label>
                    <select name="turma" id="turma">
                        <option value="">Selecione um curso primeiro</option>
                    </select>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="data_nasc">Data de Nascimento: </label>
                    <input type="date" name="data_nasc" id="data_nasc" class="inputUser" required>
                </div>
                <br><br>
                
                <div class="inputBox">
                    <label for="sexo">Sexo: </label>
                    <select name="genero">
                        <option value="">Selecione...</option>
                        <option value="feminino">Feminino</option>
                        <option value="masculino">Masculino</option>
                    </select>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cep" id="cep" class="inputUser" onblur="buscarCEP(this.value)" required>
                    <label for="cep" class="labelInput">CEP</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="rua" id="rua" class="inputUser" required>
                    <label for="rua" class="labelInput">Rua</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="numero" id="numero" class="inputUser" required>
                    <label for="numero" class="labelInput">Numero</label>
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
                <br><br>
                <a href="home.php">Voltar</a>
                <input type="submit" name="submit" id="submit"></input>
                <div id="mensagem" class="mensagem"></div>
            </fieldset>
        </form>
    </div>
</body>
</html>
