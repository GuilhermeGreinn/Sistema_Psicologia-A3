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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacoes = mysqli_real_escape_string($con, $_POST['observacoes']);
    $presenca = isset($_POST['presenca']) ? 1 : 0;

    // Gerencia o upload de arquivos
    $arquivo_nome = null;
    if (!empty($_FILES['arquivo']['name'])) {
        $upload_dir = 'uploads/';
        $arquivo_nome = $upload_dir . basename($_FILES['arquivo']['name']);

        if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivo_nome)) {
            echo "<script>alert('Erro ao fazer upload do arquivo.');</script>";
            $arquivo_nome = null;
        }
    }

    // Atualiza os dados da sessão no banco
    $query_update = "UPDATE sessao 
                     SET prontuario = '$observacoes', 
                         presenca = $presenca, 
                         arquivo = " . ($arquivo_nome ? "'$arquivo_nome'" : "NULL") . " 
                     WHERE id = $sessao_id";

    if (mysqli_query($con, $query_update)) {
        echo "<script>alert('Sessão atualizada com sucesso!');</script>";
        header("Location: prontuario.php?id=" . $sessao['paciente_id']);
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar sessão: " . mysqli_error($con) . "');</script>";
    }
}
?>

<html>
<body>
    <h1>Editar Sessão</h1>
    <p><strong>Data e Hora:</strong> <?php echo $sessao['data_horario']; ?></p>
    <p><strong>Status:</strong> <?php echo $sessao['status']; ?></p>

    <form method="post" enctype="multipart/form-data">
        <label for="observacoes">Observações:</label><br>
        <textarea name="observacoes" id="observacoes" rows="5" cols="50"><?php echo htmlspecialchars($sessao['prontuario']); ?></textarea><br><br>

        <label for="arquivo">Upload de Arquivo:</label><br>
        <input type="file" name="arquivo" id="arquivo"><br><br>

        <label for="presenca">Presença do Paciente:</label>
        <input type="checkbox" name="presenca" id="presenca" <?php echo $sessao['presenca'] ? 'checked' : ''; ?>><br><br>

        <button type="submit">Enviar</button>
    </form>

    <br><br>
    <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>">Voltar</a>
</body>
</html>
