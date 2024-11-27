<?php
include('config.php');

if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];

    if (!empty($email) && !empty($senha) && !empty($nivel)) {
        $query = "INSERT INTO adm (email, senha, nivel) VALUES ('$email', '$senha', '$nivel')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Administrador cadastrado com sucesso!');</script>";
            echo "<script>window.location.href='menu_adm.php';</script>"; // Redireciona para o menu do administrador
        } else {
            echo "<script>alert('Erro ao cadastrar administrador: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Cadastrar Administrador</title>
    <style>
        /* Estilos Gerais */
        body {
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff; /* Fundo branco com bordas arredondadas */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            width: 80%; /* Ajusta a largura da caixa */
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #003366; /* Azul escuro para o título */
            font-size: 2rem;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-weight: bold;
            color: #003366; /* Azul escuro para as labels */
            font-size: 1rem;
        }

        input {
            padding: 12px;
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #0077cc; /* Azul para foco nos campos */
            outline: none;
        }

        button {
            background-color: #0077cc; /* Azul para o botão */
            color: white;
            border: none;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #005999; /* Azul mais escuro no hover */
        }

        .alert {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        /* Estilos para o layout e espaçamento */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group input {
            width: calc(100% - 24px); /* Ajusta a largura */
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cadastrar Administrador</h1>

        <form action="#" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-group">
                <label for="nivel">Nível:</label>
                <input type="text" id="nivel" name="nivel" required>
            </div>

            <button type="submit" name="botao" value="Cadastrar">Cadastrar</button>
        </form>
    </div>

</body>
</html>
