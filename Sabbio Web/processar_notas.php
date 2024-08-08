<?php
session_start();
include_once('config.php');

// Verifica se o professor está logado
if (!isset($_SESSION['id_professor'])) {
    header('Location: loginprof.php');
    exit();
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $id_turma = $_POST['id_turma'];
    $tipo_nota = $_POST['tipo_nota'];
    $notas = $_POST['notas'];

    // Obtém o id_materia passado via POST
    $id_materia = isset($_POST['id_materia']) ? $_POST['id_materia'] : null;

    // Prepara e executa a inserção das notas no banco de dados
    $stmt = $conexao->prepare("INSERT INTO notas (id_aluno, id_turma, id_tipo_nota, valor, id_materia) VALUES (?, ?, ?, ?, ?)");
    foreach ($notas as $id_aluno => $nota) {
        // Verifica se a nota é válida (entre 0 e 10)
        if ($nota >= 0 && $nota <= 10) {
            $stmt->bind_param("iiidi", $id_aluno, $id_turma, $tipo_nota, $nota, $id_materia);
            $stmt->execute();
        }
    }
    $stmt->close();

    // Redireciona de volta para a página de adicionar notas
    header("Location: adicionar_notas.php?id_turma=$id_turma&id_materia=$id_materia");
    exit();
} else {
    // Se não foi enviado via POST, redireciona para a página anterior
    $id_turma = $_GET['id_turma'];
    $id_materia = $_GET['id_materia'];
    header("Location: adicionar_notas.php?id_turma=$id_turma&id_materia=$id_materia");
    exit();
}
?>
