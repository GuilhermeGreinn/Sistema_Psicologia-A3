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
            height: auto;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 20px;
            color: #333;
        }

        .session-container h1 {
            text-align: center;
            margin: 0;
            font-size: 1.8rem;
            color: #003366;
        }

        .details-section {
            flex-grow: 1;
            margin-top: 20px;
        }

        .details-section p {
            font-size: 18px;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: rgba(240, 240, 240, 0.9);
            border-radius: 4px;
            box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .details-section p strong {
            display: inline-block;
            width: 200px;
            color: rgb(17, 54, 71);
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


        .custom-button {
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
    <div class="session-container">
        <h1>Detalhes da Sessão</h1>
        
        <div class="details-section">
            <p><strong>Data e Hora:</strong> <?php echo $sessao['data_horario']; ?></p>
            <p><strong>Presença do Paciente:</strong> <?php echo $sessao['presenca'] ? 'Presente' : 'Ausente'; ?></p>
            <p><strong>Observações:</strong> <?php echo $sessao['observacoes']; ?></p>
        </div>

        <div class="button-container">
            <a href="prontuario.php?id=<?php echo $sessao['paciente_id']; ?>" class="custom-button">Voltar</a>
            <a href="sessao_editar.php?sessao_id=<?php echo $sessao_id; ?>" class="custom-button">Editar</a>
        </div>
            
            
    </div>
</body>
</html>