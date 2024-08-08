<?php
// Verifica se o formulário foi submetido
if(isset($_POST['id_materia']) && isset($_POST['id_turma']) && isset($_POST['id_professor'])) {
    include_once('config.php');

    // Obtém os dados do formulário
    $id_materia = $_POST['id_materia'];
    $id_turma = $_POST['id_turma'];
    $id_professor = $_POST['id_professor'];

    // Verifica se já existe um professor lecionando a mesma matéria para a mesma turma
    $sqlCheck = "SELECT * FROM professor_turma 
                 WHERE id_professor = ? AND id_materia = ? AND id_turma = ?";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->bind_param("iii", $id_professor, $id_materia, $id_turma);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    // Se já existir uma correspondência, exibe uma mensagem de erro
    if($resultCheck->num_rows > 0) {
        echo "<script>alert('Já existe um professor lecionando esta matéria para esta turma.');</script>";
        echo "<script>window.history.back();</script>";
        exit; // Encerra o script para evitar a inserção duplicada
    }

    // Prepara a consulta SQL para inserir os dados na tabela professor_turma
    $sqlInsert = "INSERT INTO professor_turma (id_professor, id_materia, id_turma) 
                  VALUES (?, ?, ?)";
    
    // Prepara a declaração SQL
    $stmt = $conexao->prepare($sqlInsert);

    // Verifica se a preparação da declaração foi bem-sucedida
    if($stmt) {
        // Faz a ligação dos parâmetros com a declaração
        $stmt->bind_param("iii", $id_professor, $id_materia, $id_turma);

        // Executa a declaração
        if ($stmt->execute()) {
            // Inserção bem-sucedida
             echo "<script>alert('Turma cadastrada ao professor com sucesso');</script>";
             echo "<script>window.location = 'sistemaprof.php';</script>"; 
        } else {
            // Se houver algum erro na execução, exibe uma mensagem de erro
             echo "<script>alert('Erro ao adicionar turma ao professor.');</script>";
             echo "<script>window.history.back();</script>";
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        // Se houver algum erro na preparação da declaração, exibe uma mensagem de erro
         echo "<script>alert('Erro ao preparar a declaração.');</script>";
         echo "<script>window.history.back();</script>";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
} else {
    // Se os parâmetros necessários não foram fornecidos, retorna uma mensagem de erro
    echo json_encode(array("error" => "Parâmetros ausentes"));
}
?>
