<?php
include('config.php');
session_start(); // Garante que a sessão está ativa

// Solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $cpf = mysqli_real_escape_string($con, $_POST['cpf']);
    $ra = mysqli_real_escape_string($con, $_POST['ra']);
    $senha = $_POST['senha'];
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $professor_email = mysqli_real_escape_string($con, $_POST['professor_email']); // Email do professor

    // Valida se todos os campos foram preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($ra) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($professor_email)) {
        
        // Verifica se o professor existe pelo email e obtém seu ID
        $professor_query = "SELECT id FROM professor WHERE email = '$professor_email'";
        $professor_result = mysqli_query($con, $professor_query);

        if ($professor_result && mysqli_num_rows($professor_result) > 0) {
            $professor = mysqli_fetch_assoc($professor_result);
            $professor_id = $professor['id'];

            // Insere o aluno na tabela
            $query = "INSERT INTO aluno (nome, cpf, ra, senha, email, telefone, professor_id) 
                      VALUES ('$nome', '$cpf', '$ra', '$senha', '$email', '$telefone', '$professor_id')";
            $result = mysqli_query($con, $query);

            if ($result) {
                // Redireciona com base no nível do usuário
                if ($_SESSION['nivel'] === 'ADM') {
                    header('Location: menu_adm.php');
                } elseif ($_SESSION['nivel'] === 'Professor') {
                    header('Location: menu_professor.php');
                } else {
                    echo "<script>alert('Nível de acesso desconhecido!');</script>";
                }
                exit(); // Garante que o script não continue executando
            } else {
                echo "<script>alert('Erro ao cadastrar aluno: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Email do professor não encontrado.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Cadastrar Aluno</title>
    <style>
        body {
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff; /* Fundo branco com bordas arredondadas */
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            padding: 15px; /* Reduziu o padding */
            margin: 50px auto;
            width: 80%; /* Ajusta a largura da caixa */
            max-width: 600px; /* Reduziu o tamanho máximo */
        }

        h1 {
            text-align: center;
            color: #003366; /* Azul escuro para o título */
            font-size: 1.8rem; /* Reduziu o tamanho da fonte */
            margin-bottom: 20px; /* Menos espaço embaixo do título */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Reduziu o gap entre os campos */
        }

        label {
            font-weight: bold;
            color: #003366; /* Azul escuro para as labels */
            font-size: 1rem; /* Reduziu o tamanho da fonte */
        }

        input {
            padding: 10px; /* Reduziu o padding */
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 1rem; /* Reduziu o tamanho da fonte */
            width: 100%;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #0077cc; /* Azul para foco nos campos */
            outline: none;
        }

        button {
            background-color: rgb(20, 147, 220);
            color: white;
            border: 2px solid rgb(17, 54, 71);
            padding: 12px; /* Reduziu o padding */
            font-size: 1rem; /* Reduziu o tamanho da fonte */
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: rgb(17, 54, 71);
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
            gap: 8px; /* Reduziu o espaço entre os campos */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cadastrar Aluno</h1>

        <form action="#" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="number" id="cpf" name="cpf" required>
            </div>

            <div class="form-group">
                <label for="ra">RA:</label>
                <input type="number" id="ra" name="ra" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="number" id="telefone" name="telefone" required>
            </div>

            <div class="form-group">
                <label for="professor_email">Professor Responsável (Email):</label>
                <input type="email" id="professor_email" name="professor_email" required>
            </div>

            <button type="submit" name="botao" value="Cadastrar">Cadastrar</button>
        </form>
    </div>

</body>
</html>