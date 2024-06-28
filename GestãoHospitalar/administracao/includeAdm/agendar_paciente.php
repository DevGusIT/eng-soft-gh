<?php
session_start();
include('../../DAO/conexao.php');
ob_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['cpf_paciente']) && isset($_POST['tipo_agendamento']) && isset($_POST['data_agendamento']) && isset($_POST['hora_agendamento'])) {
        // Atribui os valores dos campos do formulário a variáveis
        $cpf = $_POST['cpf_paciente'];
        $tipo_agendamento = $_POST['tipo_agendamento'];
        $data_agendamento = $_POST['data_agendamento'];
        $hora_agendamento = $_POST['hora_agendamento'];

        // Consulta SQL para verificar se o CPF existe na tabela 'pacientes' e obter o 'idpacientes'
        $cpf_query = "SELECT idpacientes FROM pacientes WHERE cpf = ?";
        $cpf_stmt = $mysqli->prepare($cpf_query);

        if ($cpf_stmt) {
            $cpf_stmt->bind_param("s", $cpf);
            $cpf_stmt->execute();
            $cpf_stmt->store_result();
            
            // Verifica se o CPF foi encontrado
            if ($cpf_stmt->num_rows > 0) {
                // Associa a variável 'id_paciente_agendamento' ao resultado da consulta
                $cpf_stmt->bind_result($id_paciente_agendamento);
                $cpf_stmt->fetch();

                // Consulta SQL para verificar se já existe um agendamento na mesma data e hora para outro paciente
                $check_query = "SELECT * FROM agendamento WHERE id_paciente_agendamento != ? AND data_agendamento = ? AND hora_agendamento = ?";
                $check_stmt = $mysqli->prepare($check_query);

                if ($check_stmt) {
                    $check_stmt->bind_param("iss", $id_paciente_agendamento, $data_agendamento, $hora_agendamento);
                    $check_stmt->execute();
                    $check_stmt->store_result();

                    // Verifica se já existe um agendamento no mesmo horário para outro paciente
                    if ($check_stmt->num_rows > 0) {
                        // Mensagem de erro se já existir um agendamento
                        $message = "Desculpe, já existe um agendamento para outro paciente na mesma data e horário.";
                    } else {
                        // Consulta SQL para inserir um novo agendamento
                        $insert_stmt = $mysqli->prepare("INSERT INTO agendamento (id_paciente_agendamento, cpf_paciente, tipo_agendamento, data_agendamento, hora_agendamento) VALUES (?, ?, ?, ?, ?)");

                        if ($insert_stmt) {
                            // Associa os parâmetros da consulta
                            $insert_stmt->bind_param("issss", $id_paciente_agendamento, $cpf, $tipo_agendamento, $data_agendamento, $hora_agendamento);
                            $insert_stmt->execute();

                            // Verifica se a inserção foi bem-sucedida
                            if ($insert_stmt->affected_rows > 0) { 
                                header("Location: ../historico_paciente.php");
                                exit();
                            } else {
                                // Mensagem de erro se a inserção falhar
                                $message = "Não foi possível realizar o agendamento.";
                            }
                            $insert_stmt->close();
                        } else {
                            // Mensagem de erro se a preparação da consulta de inserção falhar
                            $message = "Erro na preparação da consulta de inserção: " . $mysqli->error;
                        }
                    }
                    // Fecha a consulta de verificação de agendamento
                    $check_stmt->close();
                } else {
                    // Mensagem de erro se a preparação da consulta de verificação falhar
                    $message = "Erro na preparação da consulta de verificação: " . $mysqli->error;
                }
            } else {
                // Mensagem de erro se o CPF não for encontrado
                $message = "CPF não encontrado. Por favor, verifique e tente novamente.";
            }
            // Fecha a consulta de verificação de CPF
            $cpf_stmt->close();
        } else {
            // Mensagem de erro se a preparação da consulta de verificação de CPF falhar
            $message = "Erro na preparação da consulta de CPF: " . $mysqli->error;
        }
    }
}
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
            background-image: url('../../componentes/imagens/agenda_admin_back.jpg'); /* Substitua 'caminho_para_sua_imagem.jpg' pelo caminho da sua imagem de fundo */
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
            font-size : 40px;
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
</style>

</head>
<body>

    <header>
        <nav class="navegacao">

            <img src="../../componentes/imagens/logo2.png" alt="logo da empresa Morello com cores azuis" class="logo">

            <ul class="nav-menu">

                <li><a href="../portalAdmin.php">Portal Administrativo</a></li>
                <li><a href="../../DAO/logout.php">Sair da Conta</a></li>
                
            </ul>
        </nav>
    </header>

    <div class="container">

        <h2>Agendamento</h2>

        <form action="agendar_paciente.php" method="post">
            
            <input type="hidden" name="id_paciente_agendamento" value="<?php echo isset($_SESSION['idpacientes']) ? $_SESSION['idpacientes'] : ''; ?>">

            <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}" title="Formato de CPF inválido. Use XXX.XXX.XXX-XX" maxlength="14" onkeypress="return onlyNumbers(event)" required>
        <span id="cpf-error" style="color: red;"></span><br>

        <script>
            // Função para formatar o CPF conforme o usuário digita
            document.getElementById('cpf').addEventListener('input', function (e) {
                var cpf = e.target.value.replace(/\D/g, '');
                if (cpf.length > 0) {
                    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
                    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
                    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                }
                e.target.value = cpf;

                var symbol = document.getElementById('cpfSymbol');
                if (cpf.length === 14) {
                    symbol.innerHTML = '<i class="bi bi-check-circle correct"></i>';
                } else {
                    symbol.innerHTML = '<i class="bi bi-x-circle incorrect"></i>';
                }
            });
        </script>

            <label for="tipo_agendamento">Tipo de Agendamento:</label>
            <select id="tipo_agendamento" name="tipo_agendamento" required>
                <option value="Consulta Medica">Consulta Médica</option>
                <option value="Exame">Exame</option>
                <option value="Procedimento Médico">Procedimento</option>
            </select><br>
            <label for="data_agendamento">Data do Agendamento:</label><br>
            <input type="date" id="data_agendamento" name="data_agendamento" min="2024-05-01" max="2024-12-01"<?php echo date('Y-m-d'); ?> required><br>
        
            <script>
             document.getElementById('data_agendamento').addEventListener('input', function (e) {
                 var inputDate = new Date(e.target.value);
                 var minDate = new Date('2024-05-01');

                 if (inputDate < minDate) {
                    e.target.setCustomValidity('Por favor, selecione ou digite uma data a partir de 2024/05.');
                 } else {
                    e.target.setCustomValidity('');
                 }
            });
            </script>

            <label for="hora_agendamento">Hora da Consulta:</label>
            <input type="time" id="hora_agendamento" name="hora_agendamento" min="08:00" max="18:00"required><br>

            <input type="submit" id="agendar" name="submit" value="Agendar">
            <br><br>
            

        </form>
    </div>
</body>
</html>