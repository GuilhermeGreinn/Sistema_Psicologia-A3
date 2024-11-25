<?php
include('config.php');
include('verifica_Cadastro.php');

// Excluir aluno se a solicitação POST for enviada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_aluno_id'])) {
    $aluno_id = intval($_POST['excluir_aluno_id']);
    $delete_query = "DELETE FROM aluno WHERE id = $aluno_id";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        echo "<p>Aluno excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir o aluno: " . mysqli_error($con) . "</p>";
    }
}

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
            <th>Ações</th>
        </tr>
        <?php while ($coluna = mysqli_fetch_array($result)) { ?>
            <tr>
                <!-- Nome do aluno como link -->
                <td><a href="menu_aluno.php?aluno_id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                <td><?php echo $coluna['ra']; ?></td>
                <td>
                    <!-- Botão para excluir aluno -->
                    <form method="post" action="" style="display:inline;">
                        <input type="hidden" name="excluir_aluno_id" value="<?php echo $coluna['id']; ?>">
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <!-- Botões para registrar aluno e paciente -->
    <div style="margin-bottom: 20px;">
        <button onclick="window.location.href='cadastro_aluno.php'">Cadastrar Aluno</button>
        <button onclick="window.location.href='cadastro_paciente.php'">Cadastrar Paciente</button>
    </div>

    <a href="logout.php">Sair</a>
</body>
</html>
