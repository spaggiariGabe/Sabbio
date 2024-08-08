<?php

    session_start();
    include_once('config.php');
    //print_r($_SESSION);

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: loginprof.php');
    }
    $logado = $_SESSION['email'];

    if(!empty($_GET['search']))
        {
            $data = $_GET['search'];
            $sql = "SELECT * FROM alunos WHERE id LIKE '%$data%' or nome LIKE '%$data%' or cpf LIKE '%$data%' ORDER BY id DESC";
        }
    else
    {
        $sql = "SELECT * FROM alunos ORDER BY id DESC";
    }

    $result = $conexao->query($sql);

    //print_r($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <title>Editar notas e faltas</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(10, 100, 150), rgb(20, 150, 80));
            text-align: center;
            color: whitesmoke;
        }
        .table-bg{
            position: fixed;
            font-size: 14px;
            text-align: center;
        }
        a{
            text-decoration: none;
            border: 1px solid rgb(75, 198, 133);
            border-radius: 5px;
            padding: 6px;
            color: white;
            font-size: 14px;
            background-color: rgb(0, 0, 0, 0.3);
        }
        a:hover{
            background-color: rgb(20, 150, 80);
        }
        p{
            position: absolute;
            top: 3%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
        }
        th, td {
            padding-top: 30px;
        }
        .box-search{
            display: flex;
            justify-content: center;
            gap: .1%;
            position: fixed;
            top: 12%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .footer-links {
            position: fixed;
            top: 98%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10x;
            height: 60px;
            width: 450px;
            border-radius: 15px;
            text-align: center;
        }
        .table-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 520px;
            width: 360px;
            border: 1px solid rgb(255, 255, 255);
            border-radius: 5px;
            max-height: 450px; /* Defina a altura máxima desejada */
            max-width: 450px;
            overflow-y: scroll; /* Adicione rolagem vertical quando necessário */
        }
    </style>
</head>
<body>
    <?php
            echo "<p>Bem vindo <u>$logado</u> ao Sistema para editar notas e faltas.</p>";
        ?>
        <div class="box-search">
            <input type="search" class="form-control w-25" placeholder="Pesquisar Cadastro" id="pesquisar">
            <button onclick="searchData()" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </div>
    <div class="box">
        <div class="table-container">
            <table class="table text-white table-bg">
                <thead>
                    <tr>
                    <th scope="col">Editar</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($user_data = mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                            echo "<td>
                                <a class='btn btn-sm btn-primary' href='editnota.php?id=$user_data[id]'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='12' height='10' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg>
                                </a></td>";
                            echo "<td>".$user_data['id']."</td>";
                            echo "<td>".$user_data['nome']."</td>";
                            echo "<td>".$user_data['cpf']."</td>";
                            echo "<td>
                            </td>";
                            echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="footer-links">
        <a href="homeprof.php">Voltar para Tela Principal</a>
        <a href="sair.php">Sair / Desconectar</a>
    </div>
</body>
    <script>
        var search = document.getElementById('pesquisar');
        
        search.addEventListener("keydown", function(event) {
            if (event.key ==="Enter")
            {
                searchData();
            }
        });
        
        function searchData()
        {
            window.location = 'sistemanota.php?search='+search.value;
        }
    </script>
</html>