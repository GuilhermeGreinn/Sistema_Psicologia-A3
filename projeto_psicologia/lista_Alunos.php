<?php
include('config.php');

// Verifica se o usuário é administrador
session_start();
if ($_SESSION['nivel'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Verifica se há filtro (nome ou RA)
$filter = '';
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}

// Consulta para listar alunos com filtro
$query = "SELECT * FROM aluno WHERE nome LIKE '%$filter%' OR ra LIKE '%$filter%'";
$result = mysqli_query($con, $query);

echo "<h2>Lista de Alunos</h2>";
echo "<input type='text' id='alunoFilter' placeholder='Pesquisar por nome ou RA...'>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li><a href='listar_pacientes.php?id_aluno=" . $row['id_aluno'] . "'>" . $row['nome'] . "</a></li>";
}
echo "</ul>";
?>
