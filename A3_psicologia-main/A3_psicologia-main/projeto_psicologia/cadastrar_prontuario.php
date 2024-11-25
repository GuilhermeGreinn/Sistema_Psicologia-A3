<?php
include('config.php');

// Verifica se o ID do paciente foi passado via GET
if (isset($_GET['id'])) {
    $id_paciente = $_GET['id'];
} else {
    echo "ID do paciente não informado.";
    exit;
}

// Verifica se o formulário foi enviado
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $data_hora = $_POST['data_hora'];
    $avaliacao = $_POST['avaliacao'];
    $historico_familiar = $_POST['historico_familiar'];
    $historico_social = $_POST['historico_social'];

    if (!empty($data_hora) && !empty($avaliacao) && !empty($historico_familiar) && !empty($historico_social)) {
        $query = "INSERT INTO prontuario (id_paciente, data_hora, avaliacao, historico_familiar, historico_social)
                  VALUES ('$id_paciente', '$data_hora', '$avaliacao', '$historico_familiar', '$historico_social')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Prontuário cadastrado com sucesso!');</script>";
            echo "<script>window.location.href='menu_aluno.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar prontuário: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Cadastrar Prontuário</title>
    <style>
        /* Estilos Gerais */
        body {
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        .container {
            background: #ffffff; /* Fundo branco com bordas arredondadas */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 15px; /* Diminui o padding para reduzir o tamanho da caixa */
            margin: 50px auto;
            width: 80%; /* Diminui a largura da caixa */
            max-width: 600px; /* Limita a largura máxima da caixa */
        }
        
        h1 {
            text-align: center;
            color: #003366; /* Azul escuro para o título */
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
            color: #003366; /* Azul escuro para as labels */
            font-size: 1rem;
        }
        
        input, textarea {
            padding: 10px; /* Mantém o tamanho de digitação */
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%; /* Ajusta para 100% da largura */
            box-sizing: border-box;
        }
        
        input:focus, textarea:focus {
            border-color: #0077cc; /* Azul para foco nos campos */
            outline: none;
        }
        
        textarea {
            resize: vertical;
            height: 100px; /* Mantém o tamanho fixo do campo */
        }
        
        button {
            background-color: #0077cc; /* Azul para o botão */
            color: white;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
            width: 100%; /* Largura do botão para ocupar 100% do espaço */
        }
        
        button:hover {
            background-color: #005999; /* Azul mais escuro no hover */
        }
        
        .alert {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        
        /* Estilos para o layout e espaçamento */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%; /* Garante que os campos de texto também ocupem 100% da largura */
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Cadastrar Prontuário</h1>

        <?php if (isset($error)) { ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php } ?>

        <form action="#" method="post">
            <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">

            <div class="form-group">
                <label for="data_hora">Data e Hora:</label>
                <input type="datetime-local" id="data_hora" name="data_hora" required>
            </div>

            <div class="form-group">
                <label for="avaliacao">Avaliação:</label>
                <textarea id="avaliacao" name="avaliacao" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="historico_familiar">Histórico Familiar:</label>
                <textarea id="historico_familiar" name="historico_familiar" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="historico_social">Histórico Social:</label>
                <textarea id="historico_social" name="historico_social" rows="4" required></textarea>
            </div>

            <button type="submit" name="botao" value="Cadastrar">Cadastrar</button>
        </form>
    </div>

</body>
</html>
