<?php
include('config.php');
include('verifica_Cadastro.php');

// Consulta a lista de alunos
$query = "SELECT * FROM paciente";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($con);
    exit;
}
?>

<html>
<body>
    <h1>Bem-vindo</h1>
    <h2>Lista</h2>

    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Nivel</th>
        </tr>
        <?php while ($coluna = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $coluna['email']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Sair</a>
</body>
</html>