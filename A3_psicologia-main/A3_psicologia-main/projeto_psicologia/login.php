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

<html>
<body>
    <form action="#" method="post">
        Email: <input type="email" name="email" required>
        Senha: <input type="password" name="senha" required>
        <input type="submit" name="botao" value="Entrar">
    </form>
</body>
</html>