<?php
include('config.php');

// Verifica se o usuário é administrador
session_start();
if ($_SESSION['nivel'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Verifica se há filtro (nome ou email)
$filter = '';
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}

// Consulta para listar professores com filtro
$query = "SELECT * FROM professor WHERE nome LIKE '%$filter%' OR email LIKE '%$filter%'";
$result = mysqli_query($con, $query);

echo "<h2>Lista de Professores</h2>";
echo "<input type='text' id='professorFilter' placeholder='Pesquisar por nome ou email...'>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li><a href='listar_alunos.php?id_professor=" . $row['id_professor'] . "'>" . $row['nome'] . "</a></li>";
}
echo "</ul>";
?>
