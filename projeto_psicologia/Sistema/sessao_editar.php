<?php
include('config.php');
include('navbar.php');

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sessão</title>
    <link rel="stylesheet" href="Main.CSS">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .edit-container {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            width: 80%;
            padding: 40px;
            box-sizing: border-box;
            color: #333;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .edit-container h1 {
            text-align: center;
            font-size: 1.8rem;
            color: #003366;
            margin: 0;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            color: rgb(17, 54, 71);
        }

        form input, form select, form textarea {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .voltar-button {
            margin-right: auto;
        }
        
        .editar-button {
            margin-left: auto;
        }

        .custom-button,
        .custom-button[type="submit"] {
            padding: 12px 20px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            background-color: rgb(20, 147, 220);
            text-align: center;
            transition: background-color 0.3s;
            border: 2px solid rgb(17, 54, 71);
            cursor: pointer;
            display: inline-block;
        }

        .custom-button:hover {
            background-color: rgb(17, 54, 71);
        }


        @media (max-width: 768px) {
            .session-container {
                width: 95%;
            }

            .details-section p strong {
                width: 150px;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
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

            <div class="button-container">
                <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>" class="custom-button">Voltar</a>
                <button type="submit" class="custom-button">Salvar</button>
            </div>
                
        </form>
    </div>
</body>
</html>