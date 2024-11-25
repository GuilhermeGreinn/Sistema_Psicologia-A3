<?php
include('config.php');
include('verifica_Cadastro.php');

// Consulta a lista de pacientes
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
    <h2>Lista de Pacientes</h2>

    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Data de Abertura</th>
            <th>Ações</th> <!-- Nova coluna para ações -->
        </tr>
        <?php while ($coluna = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><a href="prontuario.php?id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                <td><?php echo $coluna['data_abertura']; ?></td>
                <td>
                    <!-- Botão para cadastrar prontuário, passando o ID do paciente -->
                    <button onclick="window.location.href='cadastrar_prontuario.php?id=<?php echo $coluna['id']; ?>'">Cadastrar Prontuário</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Botão para registrar novo paciente -->
    <button onclick="window.location.href='cadastro_paciente.php'">Cadastrar Novo Paciente</button>

    <a href="logout.php">Sair</a>
</body>
</html>
