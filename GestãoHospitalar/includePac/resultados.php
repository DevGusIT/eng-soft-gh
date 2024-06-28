<?php

include('../DAO/conexao.php');
include('../DAO/protect.php');

$idPaciente = $_SESSION['idpacientes'];

function exibirRelatorios($mysqli, $idPaciente) {
    $sql = "SELECT pacientes.nome, agendamento.tipo_agendamento, agendamento.data_agendamento, relatorios.relatorio
            FROM pacientes
            LEFT JOIN agendamento ON pacientes.idpacientes = agendamento.id_paciente_agendamento
            LEFT JOIN relatorios ON agendamento.id_paciente_agendamento = relatorios.id_paciente_relatorio
            WHERE pacientes.idpacientes = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nome"] . "</td>";
            echo "<td>" . $row["tipo_agendamento"] . "</td>";
            echo "<td>" . $row["data_agendamento"] . "</td>";
            echo "<td><a href='#' class='ver-relatorio' data-relatorio='" . htmlspecialchars($row["relatorio"], ENT_QUOTES, 'UTF-8') . "'>Exibir</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nenhuma consulta encontrada.</td></tr>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morello - Portal do Paciente</title>

    <style>
        /* Estilos */
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');

        * {
            margin: 0px;
            padding: 0px; 
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            list-style: none;
            text-decoration: none;
        }
        .recuo{
            margin-top: 10px;
            background-color: #74AFB2;
        }
        
        .navegacao{
            background-color: rgba(255, 255, 255, 0.904);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 40px;
            box-shadow: 0 0.1rem 0.5rem #ccc;
            width: 100%;
        }

        .logo {
            width: 50px;
            height: auto;
        }

        .navegacao h1{
        font-size: 18px;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 5rem;
            list-style-type: none;
        }

        .nav-menu li a {
            color: black;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.5s;
        }

        .nav-menu li a:hover {
            color: brown;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../componentes/imagens/agenda_admin_back.jpg'); /* Substitua 'caminho_para_sua_imagem.jpg' pelo caminho da sua imagem de fundo */
            background-size: cover;
            background-position: center;
        } 

        .container {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h4 {
            text-align: center;
            font-size: 40px;
            margin-bottom: 20px;
            font-size : 40px
        }

        #listar-relatorios {
            margin-top: 20px;
        }

        #listar-relatorios table {
            width: 100%;
            border-collapse: collapse;
        }

        #listar-relatorios th{
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #listar-relatorios td{
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #listar-relatorios th {
            background-color: #f2f2f2;
        }

        #listar-relatorios tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #listar-relatorios tr:hover {
            background-color: #f2f2f2;
        }

        /* Estilos da Janela Modal */
        .modal {
            display: none; /* Oculta a janela modal por padrão */
            position: fixed; /* Permite que a janela modal flutue sobre o conteúdo da página */
            z-index: 1; /* Define a ordem de empilhamento */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Adiciona rolagem se necessário */
            background-color: rgb(0,0,0); /* Cor de fundo escura */
            background-color: rgba(0,0,0,0.4); /* Cor de fundo escura com transparência */
        }

        /* Conteúdo da janela modal */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centraliza a janela modal verticalmente */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Define a largura da janela modal */
        }

        /* Botão de fechar */
        .fechar-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .fechar-modal:hover,
        .fechar-modal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body>

    <header>
        <div class="recuo"></div>

        <nav class="navegacao">

        <img src="../componentes/imagens/logo2.png" alt="logo da empresa Morello com cores azuis" class="logo">

            <h1>Bem vindo ao portal do paciente, <?php echo $_SESSION['nome']; ?>.</h1>

            <ul class="nav-menu">
                <li><a href="../index.html">Nosso Hospital</a></li>
                <li><a href="portalPaciente.php">Portal do Paciente</a></li>
                <li><a href="../DAO/logout.php">Sair da Conta</a></li>
            </ul>

        </nav>
    </header>

    <div class="container">

        <h4>Resultados e Relatórios</h4>

        <div id="listar-relatorios">

            <span id="msgAlerta"></span>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo de Agendamento</th>
                        <th>Data do Agendamento</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        exibirRelatorios($mysqli, $idPaciente);
                        $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var modal = document.getElementById("modal");
        var conteudoRelatorio = document.getElementById("conteudo-relatorio");

        // Atualize a seleção de links para que ela funcione depois do carregamento do conteúdo PHP
        document.addEventListener("DOMContentLoaded", function() {
            var linksRelatorio = document.querySelectorAll(".ver-relatorio");

            linksRelatorio.forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    modal.style.display = "block";
                    var relatorio = this.getAttribute("data-relatorio");
                    conteudoRelatorio.innerHTML = relatorio;
                });
            });
        });

        var btnFechar = document.querySelector(".fechar-modal");
        btnFechar.addEventListener("click", function() {
            modal.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    </script>
</body>
</html>
