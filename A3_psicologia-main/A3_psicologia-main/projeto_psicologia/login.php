<?php
include('config.php');
session_start();

if (@$_REQUEST['botao'] == "Entrar") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query_adm = "SELECT * FROM adm WHERE email = '$email' AND senha = '$senha'";
    $result_adm = mysqli_query($con, $query_adm);
    if ($coluna = mysqli_fetch_array($result_adm)) {
        $_SESSION['id_usuario'] = $coluna['id'];
        $_SESSION['nome'] = $coluna['nome'];
        $_SESSION['nivel'] = 'ADM';
        header('Location: menu_adm.php');
        exit;
    }

    $query_professor = "SELECT * FROM professor WHERE email = '$email' AND senha = '$senha'";
    $result_professor = mysqli_query($con, $query_professor);
    if ($coluna = mysqli_fetch_array($result_professor)) {
        $_SESSION['id_usuario'] = $coluna['id'];
        $_SESSION['nome'] = $coluna['nome'];
        $_SESSION['nivel'] = 'Professor';
        header('Location: menu_professor.php');
        exit;
    }

    $query_aluno = "SELECT * FROM aluno WHERE email = '$email' AND senha = '$senha'";
    $result_aluno = mysqli_query($con, $query_aluno);
    if ($coluna = mysqli_fetch_array($result_aluno)) {
        $_SESSION['id_usuario'] = $coluna['id'];
        $_SESSION['nome'] = $coluna['nome'];
        $_SESSION['nivel'] = 'Aluno';
        header('Location: menu_aluno.php');
        exit;
    }

    echo "<script>alert('Credenciais inválidas.');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .login-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            width: 320px;
            padding: 20px 30px;
            text-align: center;
            color: #333;
        }

        .login-input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        .login-input::placeholder {
            color: #aaa;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: rgb(20, 147, 220);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: rgb(17, 54, 71);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <form action="#" method="post">
                <label for="login"><strong>Login</strong></label>
                <input type="email" name="email" placeholder="Digite seu e-mail" class="login-input" required>
                <label for="senha"><strong>Senha</strong></label>
                <input type="password" name="senha" placeholder="Digite sua senha" class="login-input" required>
                <button type="submit" name="botao" value="Entrar" class="login-btn">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
