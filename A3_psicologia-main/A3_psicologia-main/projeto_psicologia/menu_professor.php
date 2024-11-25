<?php
include('config.php');
include('verifica_Cadastro.php');

// Consulta a lista de alunos
$query = "SELECT * FROM aluno";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($con);
    exit;
}
?>

<html>
<body>
    <h1>Bem-vindo, Professor <?php echo $_SESSION['nome']; ?></h1>
    <h2>Lista de Alunos</h2>

    <table border="1">
        <tr>
            <th>Nome</th>
            <th>RA</th>
        </tr>
        <?php while ($coluna = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $coluna['nome']; ?></td>
                <td><?php echo $coluna['ra']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Sair</a>
</body>
</html>