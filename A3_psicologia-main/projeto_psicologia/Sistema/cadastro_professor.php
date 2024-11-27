<?php
include('config.php');

// Solicita informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = $_POST['nivel'];

    // Validar se todos os campos estão preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($nivel)) {
        $query = "INSERT INTO professor (nome, cpf, senha, email, telefone, nivel) VALUES ('$nome', '$cpf', '$senha', '$email', '$telefone', '$nivel')";
        $result = mysqli_query($con, $query);

        // Verifica se o cadastro foi bem-sucedido
        if ($result) {
            // Redireciona para a página menu_adm.php após o cadastro bem-sucedido
            header('Location: menu_adm.php');
            exit(); // Garante que o script não continue executando
        } else {
            echo "<script>alert('Erro ao cadastrar professor: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Cadastrar Professor</title>
    <style>
        body {
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            width: 80%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #003366;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #003366;
            font-size: 1rem;
        }

        input, textarea {
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #005999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cadastrar Professor</h1>

        <form action="#" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="number" name="cpf" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="telefone">Telefone:</label>
            <input type="number" name="telefone" required>

            <label for="nivel">Nível:</label>
            <input type="text" name="nivel" required>

            <button type="submit" name="botao" value="Cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
