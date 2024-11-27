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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Sessão</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .session-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            width: 80%;
            height: 80%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
            color: #333;
            box-sizing: border-box;
        }

        .session-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            color: rgb(20, 147, 220);
        }

        .details-section {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .details-section p {
            font-size: 18px;
            line-height: 1.8;
            margin: 8px 0;
            padding: 12px 16px;
            background-color: rgba(240, 240, 240, 0.9);
            border-radius: 4px;
            box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .details-section p strong {
            display: inline-block;
            width: 200px;
            color: rgb(17, 54, 71);
        }

        .btn-back {
            display: block;
            margin: 20px auto 0;
            padding: 15px 30px;
            background-color: rgb(20, 147, 220);
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            font-size: 18px;
            transition: background-color 0.3s;
            width: fit-content;
        }

        .btn-back:hover {
            background-color: rgb(17, 54, 71);
        }

        @media (max-width: 768px) {
            .session-container {
                width: 95%;
                height: auto;
            }

            .details-section p strong {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="session-container">
        <h1>Detalhes da Sessão</h1>
        
        <div class="details-section">
            <p><strong>Data e Hora:</strong> <?php echo $sessao['data_horario']; ?></p>
            <p><strong>Presença do Paciente:</strong> <?php echo $sessao['presenca'] ? 'Presente' : 'Ausente'; ?></p>
            <p><strong>Observações:</strong> <?php echo $sessao['observacoes']; ?></p>
        </div>

        <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>" class="btn-back">Voltar</a>
    </div>
</body>
</html>
