<?php

    include('../DAO/conexao.php');
    include('../DAO/protect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morello - Portal do Paciente</title>

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
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .box {
            width: calc(33.33% - 20px);
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
        }

        .box img {
            max-width: 100%;
            height: auto;
        }

        .box h2 {
            margin-top: 10px;
            font-size: 18px;
            text-align: center;
            color: black;
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
        <div class="box" onclick="location.href='agendamento.php';">
            <img src="../componentes/imagens/historico1.png" alt="Agendar Consulta">
            <h2>Agendar Consulta</h2>
        </div>

        <div class="box" onclick="location.href='resultados.php';">
            <img src="../componentes/imagens/historico2.png" alt="Ver Resultados">
            <h2>Ver Resultados</h2>
        </div>

        <div class="box" onclick="location.href='historico.php';">
            <img src="../componentes/imagens/historico3.png" alt="Histórico de Consultas">
            <h2>Histórico de Consultas</h2>
        </div>
    </div>

</body>
</html>
