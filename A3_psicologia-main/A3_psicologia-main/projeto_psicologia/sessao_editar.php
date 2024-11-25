<?php
include('config.php');

// Verifica se o ID da sessão foi enviado via GET
if (!isset($_GET['sessao_id'])) {
    echo "Sessão não encontrada.";
    exit;
}

$sessao_id = intval($_GET['sessao_id']);

// Consulta os dados da sessão
$query_sessao = "SELECT * FROM sessao WHERE id = $sessao_id";
$result_sessao = mysqli_query($con, $query_sessao);

if (!$result_sessao || mysqli_num_rows($result_sessao) == 0) {
    echo "Sessão não encontrada.";
    exit;
}

$sessao = mysqli_fetch_array($result_sessao);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_horario = mysqli_real_escape_string($con, $_POST['data_horario']);
    $presenca = mysqli_real_escape_string($con, $_POST['presenca']);
    $observacoes = mysqli_real_escape_string($con, $_POST['observacoes']);

    $query_update = "UPDATE sessao 
                     SET data_horario = '$data_horario', 
                         presenca = '$presenca', 
                         observacoes = '$observacoes'
                     WHERE id = $sessao_id";

    if (mysqli_query($con, $query_update)) {
        echo "<script>alert('Sessão atualizada com sucesso!'); window.location.href='prontuario.php?id=" . $sessao['paciente_id'] . "';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar sessão: " . mysqli_error($con) . "');</script>";
    }
}
?>

<html>
<body>
    <h1>Editar Sessão</h1>
    <form method="POST">
        <label for="data_horario">Data e Hora:</label><br>
        <input type="datetime-local" name="data_horario" value="<?php echo date('Y-m-d\TH:i', strtotime($sessao['data_horario'])); ?>" required><br><br>

        <label for="presenca">Presença:</label><br>
        <select name="presenca" required>
            <option value="1" <?php echo $sessao['presenca'] ? 'selected' : ''; ?>>Presente</option>
            <option value="0" <?php echo !$sessao['presenca'] ? 'selected' : ''; ?>>Ausente</option>
        </select><br><br>

        <label for="observacoes">Observações:</label><br>
        <textarea name="observacoes" rows="5" cols="50"><?php echo htmlspecialchars($sessao['observacoes']); ?></textarea><br><br>

        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>">Voltar</a>
</body>
</html>
