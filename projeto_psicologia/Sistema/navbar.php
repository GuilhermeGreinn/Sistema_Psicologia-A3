<?php
include('verifica_Cadastro.php');

if (!isset($_SESSION['nivel'])) {
    header("Location: login.php");
    exit;
}

$central_url = "#";

if ($_SESSION['nivel'] === 'ADM') {
    $central_url = "menu_adm.php?id=" . $_SESSION['id_usuario'];
} elseif ($_SESSION['nivel'] === 'Professor') {
    $central_url = "menu_professor.php?id=" . $_SESSION['id_usuario'];
} elseif ($_SESSION['nivel'] === 'Aluno') {
    $central_url = "menu_aluno.php?id=" . $_SESSION['id_usuario'];
}

// Define a navbar com base no papel do usuário
echo '
<nav class="top-nav">
    <div class="nav-container">
        <ul class="nav-links">
            <li><a href="' . $central_url . '">Central</a></li>
        </ul>
        <ul class="nav-links">
            <li><a href="login.php" class="nav-btn-logout">Sair</a></li>
        </ul>
    </div>
</nav>';
?>
