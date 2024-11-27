<?php
include('config.php');

// Verifica se o ID da sessão foi enviado via GET
if (!isset($_GET['sessao_id'])) {
    echo "Sessão não encontrada.";
    exit;
}

$sessao_id = intval($_GET['sessao_id']); // Garante que o ID é um número inteiro

// Consulta os dados da sessão
$query_sessao = "SELECT * FROM sessao WHERE id = $sessao_id";
$result_sessao = mysqli_query($con, $query_sessao);

if (!$result_sessao || mysqli_num_rows($result_sessao) == 0) {
    echo "Sessão não encontrada.";
    exit;
}

$sessao = mysqli_fetch_array($result_sessao);
?>

<html>
<body>
    <h1>Detalhes da Sessão</h1>
    
    <p><strong>Data e Hora:</strong> <?php echo $sessao['data_horario']; ?></p>
    <p><strong>Presença do Paciente:</strong> <?php echo $sessao['presenca'] ? 'Presente' : 'Ausente'; ?></p>
    <p><strong>Observações:</strong> <?php echo nl2br(htmlspecialchars($sessao['observacoes'])); ?></p>
    
    <br>
    <a href="sessao_editar.php?sessao_id=<?php echo $sessao['id']; ?>">Editar Sessão</a>
    <br><br>
    <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>">Voltar</a>
</body>
</html>
