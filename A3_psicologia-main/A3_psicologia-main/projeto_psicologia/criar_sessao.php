<?php
include('config.php');

// Verifica se o ID do paciente foi enviado
if (!isset($_GET['id'])) {
    echo "Paciente não encontrado.";
    exit;
}

$id_paciente = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_horario = mysqli_real_escape_string($con, $_POST['data_horario']);
    $presenca = mysqli_real_escape_string($con, $_POST['presenca']);
    $observacoes = mysqli_real_escape_string($con, $_POST['observacoes']);

    $query = "INSERT INTO sessao (paciente_id, data_horario, presenca, observacoes) 
              VALUES ('$id_paciente', '$data_horario', '$presenca', '$observacoes')";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Sessão criada com sucesso!'); window.location.href='prontuario.php?id=$id_paciente';</script>";
    } else {
        echo "<script>alert('Erro ao criar sessão: " . mysqli_error($con) . "');</script>";
    }
}
?>

<html>
<body>
    <h1>Criar Sessão</h1>
    <form action="#" method="POST">
        <label for="data_horario">Data e Hora:</label>
        <input type="datetime-local" name="data_horario" required>
        
        <label for="presenca">Presença:</label>
        <select name="presenca" required>
            <option value="presente">Presente</option>
            <option value="ausente">Ausente</option>
        </select>
        
        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" rows="4" cols="50"></textarea>
        
        <button type="submit">Criar</button>
    </form>
    <br>
    <a href="prontuario.php?id=<?php echo $id_paciente; ?>">Voltar</a>
</body>
</html>
