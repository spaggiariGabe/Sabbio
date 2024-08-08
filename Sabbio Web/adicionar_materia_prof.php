<?php
include_once('config.php');

if(isset($_POST['adicionar'])) {
    $id_professor = $_POST['id_professor'];
    $id_materia = $_POST['id_materia'];

    // Verifica se o professor já leciona esta matéria
    $sqlCheck = "SELECT * FROM professor_materia WHERE id_professor = '$id_professor' AND id_materia = '$id_materia'";
    $resultCheck = $conexao->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        $errorMessage = "O professor já leciona esta matéria";
        header("Location: adicionar_materia_prof.php?id=$id_professor&error=" . urlencode($errorMessage));
        exit();
    }

    $sqlInsert = "INSERT INTO professor_materia (id_professor, id_materia) VALUES ('$id_professor', '$id_materia')";

    if ($conexao->query($sqlInsert) === TRUE) {
        $successMessage = "Matéria adicionada ao professor com sucesso";
        header("Location: adicionar_materia_prof.php?id=$id_professor&success=" . urlencode($successMessage));
        exit();
    } else {
        $errorMessage = "Erro ao adicionar matéria ao professor: " . $conexao->error;
        header("Location: adicionar_materia_prof.php?id=$id_professor&error=" . urlencode($errorMessage));
        exit();
    }
    
    $conexao->close();
}

// Consulta todas as matérias relacionadas ao curso do professor
$id_professor = $_GET['id'];
$sqlMat = "SELECT DISTINCT m.id_materia, m.nome_materia 
           FROM materias m
           INNER JOIN cursos c ON m.id_curso = c.id_curso
           INNER JOIN professor_curso pc ON c.id_curso = pc.id_curso
           WHERE pc.id_professor = $id_professor";
$resultMat = $conexao->query($sqlMat);

// Verifica se houve sucesso ou erro na última operação
$successMessage = isset($_GET['success']) ? $_GET['success'] : "";
$errorMessage = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Adicionar Matéria ao Professor</title>
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
        select, option {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 8px;
            margin-bottom: 16px;
            resize: vertical;
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
        <?php if($successMessage): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <?php if($errorMessage): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="adicionar_materia_prof.php" method="POST">
            <fieldset>
                <legend><b>Adicionar Matéria ao Professor</b></legend>
                <br><br>
                <label for="id_materia">Selecione a Matéria:</label><br>
                <select id="id_materia" name="id_materia" required>
                    <?php
                    while($rowMat = $resultMat->fetch_assoc()) {
                        echo "<option value='".$rowMat['id_materia']."'>".$rowMat['nome_materia']."</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="id_professor" value="<?php echo $_GET['id']; ?>">
                <br><br>
                <a href="sistemaprof.php">Cancelar</a>
                <input type="submit" name="adicionar" id="submit" value="Adicionar Matéria">
            </fieldset>
        </form>
    </div>
</body>
</html>