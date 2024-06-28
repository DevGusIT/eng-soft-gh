<?php
    include('../DAO/conexao.php');
    include('../DAO/protect.php');

$idpacientes = $_SESSION['idpacientes'];

// Consulta ao banco de dados para obter as consultas do paciente
$query_consultas = "SELECT nome, tipo_agendamento, data_agendamento, hora_agendamento, id_agendamento
                    FROM pacientes 
                    LEFT JOIN agendamento ON pacientes.idpacientes = agendamento.id_paciente_agendamento
                    WHERE agendamento.id_paciente_agendamento = '$idpacientes'
                    ORDER BY data_agendamento DESC";

$resultado = mysqli_query($mysqli, $query_consultas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Morello - Historico de Consultas</title>


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

    .historico {
        margin: 20px;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .historico h4 {
        text-align: center;
        font-size: 40px;
        margin-bottom: 20px;
        font-size : 40px
    }

    #listar-Pacientes {
        margin-top: 20px;
    }

    #listar-Pacientes table {
        width: 100%;
        border-collapse: collapse;
    }

    #listar-Pacientes th{
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    #listar-Pacientes td{
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #listar-Pacientes th {
        background-color: #f2f2f2;
    }

    #listar-Pacientes tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #listar-Pacientes tr:hover {
        background-color: #f2f2f2;
    }
    

    </style>

</head>
<body>

    <script src="custom.js"></script>
    
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

    <div class="historico">
        <h4>Historico de Consultas</h4>
        <span id="msgAlerta"></span>

        <div id="listar-Pacientes">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo de Agendamento</th>
                        <th>Data do Agendamento</th>
                        <th>Hora do Agendamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($consulta = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $consulta['nome'] . "</td>";
        echo "<td>" . $consulta['tipo_agendamento'] . "</td>";
        echo "<td>" . $consulta['data_agendamento'] . "</td>";
        echo "<td>" . $consulta['hora_agendamento'] . "</td>";
        echo "<td> 
            <a href='excluir_agendamento.php?id_agendamento={$consulta['id_agendamento']}' onclick='return confirm(\"Tem certeza de que deseja excluir este agendamento?\")'>
                <img src='../componentes/imagens/delete.jpg' alt='Excluir' style='width: 20px; height: 20px;'> <!-- Substitua caminho_para_sua_imagem.png pelo caminho da sua imagem -->
            </a>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nenhuma consulta encontrada.</td></tr>";
}
?>

                </tbody>
            </table>
        </div>
    </div>

    
</body>
</html>
