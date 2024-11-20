<?php
session_start();

// Verifica se o usuário está logado
if(!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Exibe o menu de acordo com o nível do usuário
if ($_SESSION['nivel'] == 'ADM') {
    echo "<h2>Bem-vindo, Administrador</h2>";
    echo "<a href='listar_professores.php'>Lista de Professores</a><br>";
    echo "<a href='listar_alunos.php'>Lista de Alunos</a><br>";
    echo "<a href='listar_pacientes.php'>Lista de Pacientes</a><br>";
} elseif ($_SESSION['nivel'] == 'PROFESSOR') {
    echo "<h2>Bem-vindo, Professor</h2>";
    echo "<a href='listar_alunos.php'>Lista de Alunos</a><br>";
    echo "<a href='listar_pacientes.php'>Lista de Pacientes</a><br>";
} else {
    echo "<h2>Bem-vindo, Aluno</h2>";
    echo "<a href='listar_pacientes.php'>Lista de Pacientes</a><br>";
}
?>