<?php
session_start();
include_once('../DAO/conexao.php');

$idusuario = $_SESSION['idusuario'];

$query_consultas = "SELECT idpacientes, nome, cpf, email, telefone, sexo, data_nascimento, cep FROM pacientes";

$resultado = mysqli_query($mysqli, $query_consultas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Morello - Pacientes</title>

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

        .nav-menu li a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -3px;
    left: 0;
    background-color: blue;
    visibility: hidden;
    transition: all 0.3s ease-in-out;
}

.nav-menu li a:hover::after {
    width: 100%;
    visibility: visible;
}

.nav-menu li a:hover {
    color: brown;
    background-color: rgba(0, 0, 255, 0.1); /* Efeito de fundo ao passar o mouse */
}

/* Adicione isso ao seu arquivo style.css */

/* Efeito de linha ao passar o mouse sobre os links */
.nav-menu li a {
    position: relative;
}

.nav-menu li a::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: -3px; /* Ajuste conforme necessário */
    left: 0;
    background-color: blue; /* Cor da linha */
    visibility: hidden;
    transform: scaleX(0);
    transition: all 0.3s ease-in-out;
}

.nav-menu li a:hover::after {
    visibility: visible;
    transform: scaleX(1);
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

        .action-icons {
            display: flex;
            justify-content: space-around;
        }

        .action-icons img {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }


        input[type="text"]:hover,
input[type="date"]:hover,
input[type="tel"]:hover,
input[type="email"]:hover,
input[type="password"]:hover,
select:hover {
    background-color: rgba(0, 0, 255, 0.1); /* Efeito de fundo ao passar o mouse */
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="tel"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
select:focus {
    border-color: blue;
    box-shadow: 0px 0px 10px rgba(0, 0, 255, 0.2);
}

input[type="submit"]:hover {
    background-color: #0056b3;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
}



    </style>

</head>
<body>
    <script src="custom.js"></script>

    <header>
        <nav class="navegacao">
            <img src="../componentes/imagens/logo2.png" alt="logo da empresa Morello com cores azuis" class="logo">
            <ul class="nav-menu">
                <li><a href="portalAdmin.php">Portal Administrativo</a></li>
                <li><a href="../DAO/logout_admin.php">Sair da Conta</a></li>
            </ul>
        </nav>
    </header>

    <div class="historico">
        <h4>Pacientes</h4>
        <span id="msgAlerta"></span>

        <div id="listar-Pacientes">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Sexo</th>
                        <th>Data Nascimento</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <main></main>
                        <?php
                        if ($resultado) {
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['idpacientes']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['sexo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['data_nascimento']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cep']) . "</td>";
                                    echo "<td class='action-icons'>
                                            <a href='./includeAdm/editar_paciente.php?idpacientes=" . htmlspecialchars($row['idpacientes']) . "'>
                                                <img src='../componentes/imagens/edit1.png' alt='Editar'>
                                            </a>
                                            <a href='./includeAdm/excluir_paciente_listar.php?idpacientes=" . htmlspecialchars($row['idpacientes']) . "' onclick='return confirm(\"Tem certeza de que deseja excluir este paciente?\")'>
                                                <img src='../componentes/imagens/delete.jpg' alt='Excluir'>
                                            </a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>Nenhum paciente encontrado.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Erro ao executar a consulta.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
