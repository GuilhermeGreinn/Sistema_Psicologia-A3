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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Sessão</title>
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0077cc;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        form input, form select, form textarea {
            width: calc(100% - 20px); /* Redução para alinhamento com a margem */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box; /* Inclui o padding no cálculo total */
        }

        form textarea {
            resize: vertical;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btn-container button, 
        .btn-container a {
            padding: 10px 20px;
            text-decoration: none;
            text-align: center;
            color: #fff;
            background: #0077cc;
            border-radius: 4px;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-container button:hover, 
        .btn-container a:hover {
            background: #005999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Sessão</h1>
        <form method="POST">
            <label for="data_horario">Data e Hora:</label>
            <input type="datetime-local" name="data_horario" value="<?php echo date('Y-m-d\TH:i', strtotime($sessao['data_horario'])); ?>" required>

            <label for="presenca">Presença:</label>
            <select name="presenca" required>
                <option value="1" <?php echo $sessao['presenca'] ? 'selected' : ''; ?>>Presente</option>
                <option value="0" <?php echo !$sessao['presenca'] ? 'selected' : ''; ?>>Ausente</option>
            </select>

            <label for="observacoes">Observações:</label>
            <textarea name="observacoes" rows="5"><?php echo htmlspecialchars($sessao['observacoes']); ?></textarea>

            <div class="btn-container">
                <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>">Voltar</a>
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>