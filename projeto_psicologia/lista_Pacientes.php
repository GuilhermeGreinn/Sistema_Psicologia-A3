<?php
include('config.php');

// Verifica se o usuário é administrador
session_start();
if ($_SESSION['nivel'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Verifica se há filtro (nome)
$filter = '';
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}

// Consulta para listar pacientes com filtro
$query = "SELECT * FROM paciente WHERE nome LIKE '%$filter%'";
$result = mysqli_query($con, $query);

echo "<h2>Lista de Pacientes</h2>";
echo "<input type='text' id='pacienteFilter' placeholder='Pesquisar por nome...'>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li><a href='listar_sessoes.php?id_paciente=" . $row['id_paciente'] . "'>" . $row['nome'] . "</a></li>";
}
echo "</ul>";
?>
