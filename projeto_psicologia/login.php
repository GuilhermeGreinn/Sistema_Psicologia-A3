<?php
include('config.php');
session_start();

if (isset($_POST['botao']) && $_POST['botao'] == "Entrar") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Consultar o banco de dados para verificar o login
    $query = $con->prepare("SELECT id, senha, nivel FROM usuario WHERE login = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($id, $hashedPassword, $nivel);
        $query->fetch();

        // Verificar a senha
        if (password_verify($senha, $hashedPassword)) {
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
            $_SESSION['nivel'] = $nivel;
            echo "Login bem-sucedido. Bem-vindo(a), $nivel!";
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
    $query->close();
}
?>
