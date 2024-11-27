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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Sessão</title>
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            width: 80%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #003366;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #003366;
            font-size: 1rem;
        }

        input, select, textarea {
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        .botao {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .botao:hover {
            background-color: #005999;
        }

        .voltar-btn {
            background-color: #cccccc;
            color: #003366;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
            margin-bottom: -20px; /* Remove espaço extra abaixo do botão */
        }

        .voltar-btn:hover {
            background-color: #b2b2b2;
        }

        .voltar-container {
            margin-top: 10px; /* Espaço acima do botão */
            margin-bottom: 0; /* Remove espaço inferior do container */
        }
    </style>
</head>

<body>
    <div class="container">
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
            
            <button type="submit" class="botao">Criar</button>
        </form>

        <!-- Botão Voltar -->
        <div class="voltar-container">
            <form action="prontuario.php?id=<?php echo $id_paciente; ?>" method="get">
                <button type="submit" class="voltar-btn">Voltar</button>
            </form>
        </div>
    </div>
</body>
</html>
