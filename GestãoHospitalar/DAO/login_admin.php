<?php

require_once 'conexao.php';
session_start();
$mensagem = "";

if (isset($_POST['email']) && isset($_POST['senha'])){

    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    if(strlen($email) == 0){
        $mensagem = "Preencha seu email";
    } else if(strlen($senha) == 0){
        $mensagem = "Preencha sua senha";
    } else {
        $sql_code = "SELECT * FROM usuarios WHERE email_usuario = '$email' AND senha_usuario = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidadeRequisitos = $sql_query->num_rows;

        if($quantidadeRequisitos == 1) {

            $usuario = $sql_query->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
            $_SESSION['id_grupo'] = $usuario['id_grupo'];
            $_SESSION['idusuario'] = $usuario['idusuario'];

            header("Location: ../administracao/portalAdmin.php");

        } else {
            $mensagem = "Falha ao entrar! Email ou senha incorretos";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morello - Login Administrativo</title>

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
        
        body {
            margin: 0;
            padding: 0;
            background-image: url('../componentes/imagens/login2.jpg');
            background-size: cover;
            background-position: center;
        }

        button {
        transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        button:hover {
        background-color: #0056b3;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
        border-color: blue;
        box-shadow: 0px 0px 10px rgba(0, 0, 255, 0.2);
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

        .nav-menu li a {
            position: relative;
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -3px; /* Ajuste conforme necessário */
            left: 0;
            background-color: blue; /* Altere para a cor desejada */
            visibility: hidden;
            transition: all 0.3s ease-in-out;
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

        .nav-menu li a:hover::after {
            width: 100%;
            visibility: visible;
        }

        .logo {
            width: 50px;
            height: auto;
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

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 40px;
            padding: 0 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 40px;
        }

        form {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out; /* Adiciona uma transição suave */
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
        border-color: blue;
        box-shadow: 0px 0px 10px rgba(0, 0, 255, 0.2);
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

        input[type="text"]:hover,
        input[type="password"]:hover,
        input[type="email"]:hover {
            border-color: blue; /* Cor da borda ao passar o mouse */
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="email"],
        input[type="password"],
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

        p {
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border: 2px solid red;
            border-radius: 5px;
            background-color: #f8d7da;
        }
    </style>
</head>
<body>

    <header>
        <div class="recuo"></div>
        <nav class="navegacao">
            <img src="../componentes/imagens/logo2.png" alt="logo da empresa Morello com cores azuis" class="logo">
            <ul class="nav-menu">
                <li><a href="../index.html">Nosso Hospital</a></li>
                <li><a href="../includePac/portalPaciente.php">Portal do Paciente</a></li>
                <li><a href="../administracao/portalAdmin.php">Portal Empresarial</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Login</h2>

        <form action="" method="POST">

            <div class="formulario">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="@gmail.com" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com">
                <span id="emailError" style="color: red; display: none;">O email deve ter o formato nomeusuario@gmail.com.</span><br>

                <script>
                    document.getElementById("email").addEventListener('input', function(e) {
                        if (!/^[\w.%+-]+@gmail\.com$/.test(e.target.value)) {
                            document.getElementById("emailError").style.display = 'inline';
                            e.target.setCustomValidity("Formato de email inválido.");
                        } else {
                            document.getElementById("emailError").style.display = 'none';
                            e.target.setCustomValidity("");
                        }
                    });
                </script>
            </div>

            <div class="formulario">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <br><br>
            </div>

            <button type="submit">Login</button>
            <?php if ($mensagem !== ""): ?>
                <p class="error-message"><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </form>

        <br>
    </div>

</body>
</html>
