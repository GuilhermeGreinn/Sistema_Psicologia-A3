<?php
include('config.php');

if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash seguro para senha
    $nivel = 'ADM'; // Sempre ADM para este cadastro

    // Verificar se o login já existe
    $checkQuery = $con->prepare("SELECT id FROM usuario WHERE login = ?");
    $checkQuery->bind_param("s", $login);
    $checkQuery->execute();
    $checkQuery->store_result();
    if ($checkQuery->num_rows > 0) {
        echo "Esse login já está em uso.";
        $checkQuery->close();
        exit;
    }
    $checkQuery->close();

    // Inserir no banco se o login for único
    $query = $con->prepare("INSERT INTO usuario (login, senha, nivel) VALUES (?, ?, ?)");
    $query->bind_param("sss", $login, $senha, $nivel);
    if ($query->execute()) {
        echo "Administrador cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar administrador.";
    }
    $query->close();
}
?>
