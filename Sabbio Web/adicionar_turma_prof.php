<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Adicionar Turma ao Professor</title>
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
            text-align: center;
        }
        .box {
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
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #75c7e0;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        select:focus {
            border-color: #45aaf2;
            outline: none;
        }
        #submit {
            padding: 12px;
            background-color: rgb(0, 0, 0, 0.3);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 16px;
            color: whitesmoke;
            box-sizing: border-box;
        }
        #submit:hover {
            background-color: rgb(75, 198, 133);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Adicionar Turma ao Professor</h1>
        <form action="processar_turma_prof.php" method="POST" id="addTurmaForm">
            <select name="id_materia" id="id_materia" required>
                <option value="" disabled selected>Selecione a Matéria</option>
                <?php
                include_once('config.php');
                $id_professor = $_GET['id'];
                $sqlMat = "SELECT DISTINCT m.id_materia, m.nome_materia 
                           FROM materias m
                           INNER JOIN professor_materia pm ON m.id_materia = pm.id_materia
                           WHERE pm.id_professor = $id_professor";
                $resultMat = $conexao->query($sqlMat);
                if ($resultMat->num_rows > 0) {
                    while ($rowMat = $resultMat->fetch_assoc()) {
                        echo "<option value='".$rowMat['id_materia']."'>".$rowMat['nome_materia']."</option>";
                    }
                }
                ?>
            </select>
            <select name="id_turma" id="id_turma" required>
                <option value="" disabled selected>Selecione a Turma</option>
                <!-- Turmas serão carregadas dinamicamente aqui -->
            </select>
            <input type="hidden" name="id_professor" value="<?php echo $id_professor; ?>">
            <button type="submit" id="submit">Adicionar Turma</button>
            <a href="sistemaprof.php" class="button">Voltar</a>
        </form>
    </div>

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#id_materia').change(function(){
                var id_materia = $(this).val();
                $.ajax({
                    url: 'carregar_turmas.php',
                    method: 'POST',
                    data: {id_materia: id_materia},
                    dataType: 'json',
                    success: function(data){
                        $('#id_turma').empty(); // Limpa o select de turmas
                        if (data.length > 0) {
                            // Se foram encontradas turmas, adiciona as opções ao select
                            $.each(data, function(index, turma){
                                $('#id_turma').append('<option value="' + turma.id_turma + '">' + turma.nome_turma + '</option>');
                            });
                        } else {
                            // Se nenhuma turma foi encontrada, exibe uma opção padrão indicando isso
                            $('#id_turma').append('<option value="" disabled selected>Nenhuma turma encontrada</option>');
                        }
                    },
                    error: function(xhr, status, error){
                        // Se ocorrer um erro na requisição AJAX, exibe uma mensagem de erro
                        console.error(xhr.responseText);
                        alert('Erro ao carregar turmas. Por favor, tente novamente.');
                    }
                });
            });
        });
    </script>
</body>
</html>
