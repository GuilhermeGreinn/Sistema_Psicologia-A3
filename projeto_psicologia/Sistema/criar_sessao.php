<?php
include('config.php');
include('navbar.php');

if (!$con) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}


// Verifica se o ID do paciente foi enviado e é válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Paciente não encontrado ou ID inválido.";
    exit;
}

$id_paciente = intval($_GET['id']); // Garante que o ID é um número

// Trata o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_horario = mysqli_real_escape_string($con, $_POST['data_horario']);
    $presenca = mysqli_real_escape_string($con, $_POST['presenca']);
    $observacoes = mysqli_real_escape_string($con, $_POST['observacoes']);

    // Insere os dados na tabela 'sessao'
    $query = "INSERT INTO sessao (paciente_id, data_horario, presenca, observacoes) 
              VALUES ('$id_paciente', '$data_horario', '$presenca', '$observacoes')";

    if (mysqli_query($con, $query)) {
        echo "<script>
                alert('Sessão criada com sucesso!');
                window.location.href = 'prontuario.php?id=$id_paciente';
              </script>";
    } else {
        echo "<p style='color:red;'>Erro ao criar sessão: " . mysqli_error($con) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Sessão</title>
    <link rel="stylesheet" href="main.css">
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

        .container {
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
            margin-top: 20px;

        }

        h1 {
            text-align: center;
            color: #003366;
            font-size: 1.8rem;
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: rgb(17, 54, 71);
            font-size: 1rem;
        }

        input, select, textarea {
            padding: 12px 15px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        button.botao, .voltar-btn {
            display: block; /* Garante que os botões ocupem 100% da largura definida */
            text-align: center; /* Centraliza o texto dentro dos botões */
            width: 100%; /* Faz os botões ocuparem toda a largura do formulário */
            box-sizing: border-box; /* Inclui o padding e bordas no cálculo da largura */
        }

        .botao {
            background-color: rgb(20, 147, 220);
            color: white;
            border: 2px solid rgb(17, 54, 71);
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .botao:hover {
            background-color: rgb(17, 54, 71);
        }

        .voltar-btn {
            border: 2px solid rgb(17, 54, 71);
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            border-radius: 4px;
            transition: background-color 0.3s;
            background-color: #cccccc;
            color: #003366;
            text-decoration: none;
        }

        .voltar-btn:hover {
            background-color: #b2b2b2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Criar Sessão</h1>
        
        <form action="" method="POST">
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
            <a href="prontuario.php?id=<?php echo $id_paciente; ?>" class="voltar-btn">Voltar</a>
        </form>
    </div>
</body>
</html>
