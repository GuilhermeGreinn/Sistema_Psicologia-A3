<?php
include('config.php');

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if(isset($_POST['botao']) && $_POST['botao'] == "Login"){
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Consulta para verificar as credenciais
    $query = "SELECT * FROM usuario WHERE login = '$login'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    // Verifica se a senha está correta
    if($user && password_verify($senha, $user['senha'])){
        // Inicia a sessão e armazena as informações do usuário
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['nivel'] = $user['nivel'];
        $_SESSION['nome'] = $user['nome'];

        // Redireciona para a página correspondente ao tipo de usuário
        if($user['nivel'] == 'ADM') {
            header("Location: menu_admin.php");
        } elseif($user['nivel'] == 'PROFESSOR') {
            header("Location: menu_professor.php");
        } else {
            header("Location: menu_aluno.php");
        }
        exit;
    } else {
        echo "Credenciais inválidas.";
    }
}
?>
