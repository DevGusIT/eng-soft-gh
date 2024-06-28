<?php

if(isset($_POST['submit'])){
    require_once 'conexao.php';

    $cpf = $_POST['cpf'];
    $cpf = mysqli_real_escape_string($mysqli, $cpf);

    $sql_verificar = "SELECT cpf FROM pacientes WHERE cpf='$cpf'";
    $resultado_verificar = mysqli_query($mysqli, $sql_verificar);

    if (empty($cpf)) {
        echo "Campo CPF não pode ser vazio.";
    } else {
        if (mysqli_num_rows($resultado_verificar) > 0) { 
            echo "CPF já cadastrado. Por favor, tente novamente com um CPF diferente.";
        } else {
            $nome = $_POST['nome'];
            $data_nascimento = $_POST['data_nascimento'];
            $sexo = $_POST['genero'];
            $telefone = $_POST['telefone'];
            $cep = $_POST['cep'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // INSERE OS DADOS DO USUÁRIO NA TABELA
            $sql = "INSERT INTO pacientes (cpf, nome, data_nascimento, sexo, telefone, cep, email, senha) 
                    VALUES ('$cpf', '$nome', '$data_nascimento', '$sexo', '$telefone', '$cep', '$email', '$senha')";
                    
            $resultado = mysqli_query($mysqli, $sql);

            if ($resultado) {
                echo "Usuário cadastrado com sucesso";
                header("Location: login.php");

            } else {
                echo "Erro ao cadastrar usuário: " . mysqli_error($mysqli);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Morello - Cadastro</title>

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
        background-color: midnightblue;
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
            position: relative;
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
        }

        body {
            margin: 0;
            padding: 0;
            background-image: url('../componentes/imagens/backcad2.jpg'); /* Substitua 'caminho_para_sua_imagem.jpg' pelo caminho da sua imagem de fundo */
            background-size: cover;
            background-position: center;
        } 

        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 40px;
            margin-bottom: 20px;
            font-size : 40px
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
            font-weight: bold;
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

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
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

        input[type="submit"] {
            width: 100%;
            background-color: blue;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
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
                <li><a href="login.php"><span>Login</span></a></li>
            </ul>
        </nav>
    </header>

    <h1>Cadastro de Pacientes</h1>
    <form action="cadastro.php" method="POST">
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
        
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <script>
            document.getElementById("nome").addEventListener('input', function(e) {
                var nome = e.target.value;
                var apenasLetras = /^[a-zA-Z\s]*$/;

                if (!apenasLetras.test(nome)) {
                    e.target.value = nome.replace(/[^a-zA-Z\s]/g, '');
                }
            });
        </script>
        
        <label for="data_nascimento">Data de Nascimento:</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" min="2011-01-01" max="<?php echo date('Y-m-d'); ?>" required><br><br>
        
        <script>
            document.getElementById('data_nascimento').addEventListener('input', function (e) {
                var inputDate = new Date(e.target.value);
                var minDate = new Date('2011-01-01');

                if (inputDate < minDate) {
                    e.target.setCustomValidity('Por favor, selecione ou digite uma data de nascimento a partir de 2011.');
                } else {
                    e.target.setCustomValidity('');
                }
            });
        </script>

        <label for="genero">Gênero:</label><br>
        <select id="genero" name="genero" required>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select><br>
        
        <label for="cep">CEP:</label><br>
        <input type="text" id="cep" name="cep" maxlength="9" required><br>
        <span id="cepError" style="color: red; display: none;">O CEP deve ter o formato XXXXX-XXX.</span><br><br>

        <script>
            document.getElementById("cep").addEventListener('input', function(e) {
                var cep = e.target.value.replace(/\D/g, '');

                if (cep.length > 8) {
                    cep = cep.substring(0, 8);
                }

                // Formatar o CEP
                var formattedCep = cep;
                if (cep.length === 8) {
                    formattedCep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');
                }

                e.target.value = formattedCep;

                if (!/^\d{5}-\d{3}$/.test(formattedCep)) {
                    document.getElementById("cepError").style.display = 'inline';
                    e.target.setCustomValidity("Formato de CEP inválido.");
                } else {
                    document.getElementById("cepError").style.display = 'none';
                    e.target.setCustomValidity("");
                }
            });
        </script>

        <label for="telefone">Telefone:</label><br>
        <input type="tel" id="telefone" name="telefone" required><br>
        <span id="telefoneError" style="color: red; display: none;">O telefone deve ter o formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.</span><br><br>

        <script>
            document.getElementById("telefone").addEventListener('input', function(e) {
                var telefone = e.target.value.replace(/\D/g, '');

                // Limitar o telefone a 11 caracteres
                if (telefone.length > 11) {
                    telefone = telefone.substring(0, 11);
                }

                // Formatar o telefone
                var formattedTelefone;
                if (telefone.length === 11) {
                    formattedTelefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (telefone.length === 10) {
                    formattedTelefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else {
                    formattedTelefone = telefone;
                }

                e.target.value = formattedTelefone;

                // Verificar se o telefone tem um dos formatos esperados
                if (!/^(\(\d{2}\) \d{5}-\d{4})|(\(\d{2}\) \d{4}-\d{4})$/.test(formattedTelefone)) {
                    document.getElementById("telefoneError").style.display = 'inline';
                    e.target.setCustomValidity("Formato de telefone inválido.");
                } else {
                    document.getElementById("telefoneError").style.display = 'none';
                    e.target.setCustomValidity("");
                }
            });
        </script>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="@gmail.com" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com">
        <span id="emailError" style="color: red; display: none;">O email deve ter o formato nomeusuario@gmail.com.</span><br>

        <script>
            document.getElementById("email").addEventListener('input', function(e) {
                // Verificar se o email tem o formato esperado
                if (!/^[\w.%+-]+@gmail\.com$/.test(e.target.value)) {
                    document.getElementById("emailError").style.display = 'inline';
                    e.target.setCustomValidity("Formato de email inválido.");
                } else {
                    document.getElementById("emailError").style.display = 'none';
                    e.target.setCustomValidity("");
                }
            });
        </script>
        
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <input type="submit" name="submit" id="submit">
        <br><br>
    </form>

    <script>
        document.getElementById('agendamento_form').addEventListener('submit', function(e) {
            var inputDate = new Date(document.getElementById('data_nascimento').value);
            var minDate = new Date('2011-01-01');

            if (inputDate < minDate) {
                e.preventDefault(); // Impede o envio do formulário
                alert('Por favor, selecione ou digite uma data de nascimento a partir de 2011.');
            }
        });
    </script>

</body>
</html>
