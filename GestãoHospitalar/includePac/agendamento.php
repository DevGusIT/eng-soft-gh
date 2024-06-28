<?php

include('../DAO/conexao.php');
include('../DAO/protect.php');
ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morello - Agendar Consultas</title>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
        list-style: none;
        text-decoration: none;
    }
    .recuo {
        margin-top: 10px;
        background-color: #74AFB2;
    }
    .navegacao {
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
    .navegacao h1 {
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
        background-image: url('../componentes/imagens/agenda_admin_back.jpg');
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
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 40px;
        padding: 8px;
    }
    form {
        width: 100%;
        max-width: 800px;
        margin: 0 auto; 
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    label {
        font-weight: bold;
        font-size: 16px;
    }
    input[type="text"],
    input[type="date"],
    input[type="time"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        width: 100%;
        background-color: blue;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
        text-align: center;
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

        <h2>Agendamento</h2>

        <form action="agendamento.php" method="post">
            
            <input type="hidden" name="id_paciente_agendamento" value="<?php echo isset($_SESSION['idpacientes']) ? $_SESSION['idpacientes'] : ''; ?>">
            
            <label for="tipo_agendamento">Tipo de Agendamento:</label>
            <select id="tipo_agendamento" name="tipo_agendamento" required>
                <option value="Consulta Medica">Consulta Médica</option>
                <option value="Exame">Exame</option>
                <option value="Procedimento Médico">Procedimento</option>
            </select><br>
            
            <label for="data_agendamento">Data do Agendamento:</label><br>
            <input type="date" id="data_agendamento" name="data_agendamento" min="2024-05-01" max="2024-12-01"<?php echo date('Y-m-d'); ?> required><br>
            <script>
    // Função para formatar a data no formato YYYY-MM-DD
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

    // Definir a data mínima como amanhã
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);

    var minDate = formatDate(tomorrow);
    document.getElementById('data_agendamento').setAttribute('min', minDate);

    document.getElementById('data_agendamento').addEventListener('input', function (e) {
        var inputDate = new Date(e.target.value);
        var minDate = new Date();
        minDate.setDate(minDate.getDate() + 1);

        if (inputDate < minDate) {
            e.target.setCustomValidity('Por favor, selecione uma data a partir de amanhã.');
        } else {
            e.target.setCustomValidity('');
        }
    });
</script>

            <label for="hora_agendamento">Hora da Consulta:</label>
            <input type="time" id="hora_agendamento" name="hora_agendamento" min="08:00" max="18:00"required><br>

            <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if (isset($_SESSION['idpacientes']) && isset($_POST['tipo_agendamento']) && isset($_POST['data_agendamento']) && isset($_POST['hora_agendamento'])) {
                        $id_paciente_agendamento = $_SESSION['idpacientes'];
                        $tipo_agendamento = $_POST['tipo_agendamento'];
                        $data_agendamento = $_POST['data_agendamento'];
                        $hora_agendamento = $_POST['hora_agendamento'];

                        // Verificar se já existe um agendamento na mesma data e hora
                        $check_query = "SELECT * FROM agendamento WHERE id_paciente_agendamento != $id_paciente_agendamento AND data_agendamento = '$data_agendamento' AND hora_agendamento = '$hora_agendamento'";
                        $check_result = $mysqli->query($check_query);

                        if ($check_result) {
                            if ($check_result->num_rows > 0) {
                                echo "<div class='error-message'>Desculpe, já existe um agendamento para outro paciente na mesma data e horário.</div>";
                            } else {
                                // Inserir o novo agendamento
                                $insert_query = "INSERT INTO agendamento (id_paciente_agendamento, tipo_agendamento, data_agendamento, hora_agendamento) VALUES ($id_paciente_agendamento, '$tipo_agendamento', '$data_agendamento', '$hora_agendamento')";
                                $insert_result = $mysqli->query($insert_query);

                                if ($insert_result) {
                                    header("Location: historico.php");
                                    exit();
                                } else {
                                    echo "<div class='error-message'>Não foi possível realizar o agendamento.</div>";
                                }
                            }
                        } else {
                            echo "<div class='error-message'>Erro na execução da consulta: " . $mysqli->error . "</div>";
                        }
                    }
                }
                ?>

            <input type="submit" id="agendar" name="submit" value="Agendar">
            <br><br>
        </form>
    </div>
</body>
</html>
