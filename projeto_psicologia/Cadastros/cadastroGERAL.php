<?php
include('config.php');

// Verifica se o usuário está logado e tem permissão para cadastrar outros usuários
session_start();
if ($_SESSION['nivel'] != 'ADM' && $_SESSION['nivel'] != 'PROFESSOR') {
    header("Location: login.php");
    exit;
}

if(isset($_POST['botao']) && $_POST['botao'] == "Cadastrar"){
    // Recebe os dados do formulário
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  // Criptografando a senha
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = $_POST['nivel'];

    // Verifica se todos os campos estão preenchidos
    if(!empty($login) && !empty($senha) && !empty($nome) && !empty($cpf) && !empty($email) && !empty($nivel)) {
        // Insere o usuário na tabela
        $query = "INSERT INTO usuario (login, senha, nome, cpf, email, telefone, nivel) 
                  VALUES ('$login', '$senha', '$nome', '$cpf', '$email', '$telefone', '$nivel')";
        $result = mysqli_query($con, $query);

        if($result) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário.";
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}
?>
