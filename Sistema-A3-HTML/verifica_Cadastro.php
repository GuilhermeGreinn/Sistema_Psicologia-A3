<?php
// Conexão com o banco de dados
include 'config.php';

// Recebe os dados do formulário
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

// Busca o usuário no banco de dados
$query = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($con, $query);

// Verifica se o usuário existe
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Verifica se a senha está correta
    if (password_verify($password, $user['senha'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_role'] = $user['role']; // Adiciona o papel do usuário

        // Redireciona com base no papel do usuário
        if ($user['role'] === 'adm') {
            header("Location: menu_ADM.php");
        } elseif ($user['role'] === 'professor') {
            header("Location: menu_professor.php");
        } elseif ($user['role'] === 'aluno') {
            header("Location: menu_aluno.php");
        } else {
            echo "Papel de usuário inválido!";
        }
        exit;
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}
?>
