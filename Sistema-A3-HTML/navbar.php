<?php
session_start();
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit;
}

// Define a navbar com base no papel do usuário
if ($_SESSION['user_role'] === 'adm') {
    echo '
    <nav class="top-nav">
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="#">Central</a></li>
                <li><a href="#">Cadastro</a></li>
                <li><a href="#">Relatório de Sessões</a></li>
            </ul>
        </div>
    </nav>';
} elseif ($_SESSION['user_role'] === 'professor') {
    echo '
    <nav class="top-nav">
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="#">Central</a></li>
                <li><a href="#">Cadastro</a></li>
                <li><a href="#">Relatório de Sessões</a></li>
            </ul>
            <ul class="nav-links">
                <li><a href="#" class="notification-btn">
                    <img src="https://uxwing.com/wp-content/themes/uxwing/download/communication-chat-call/bell-line-icon.png" alt="Notificações">
                </a></li>
                <li><a href="#" class="user-btn">
                    <img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" alt="Usuário">
                </a></li>
            </ul>
        </div>
    </nav>';
} elseif ($_SESSION['user_role'] === 'aluno') {
    echo '
    <nav class="top-nav">
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="#">Central</a></li>
                <li><a href="#">Cadastro</a></li>
                <li><a href="#">Agendamento</a></li>
            </ul>
            <ul class="nav-links">
                <li><a href="#" class="notification-btn">
                    <img src="https://uxwing.com/wp-content/themes/uxwing/download/communication-chat-call/bell-line-icon.png" alt="Notificações">
                </a></li>
                <li><a href="#" class="user-btn">
                    <img src="https://cdn-icons-png.flaticon.com/512/1144/1144760.png" alt="Usuário">
                </a></li>
            </ul>
        </div>
    </nav>';
} else {
    echo "Erro: Papel de usuário não reconhecido.";
}
?>
