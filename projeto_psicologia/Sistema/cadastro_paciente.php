<?php
include("config.php");
include('navbar.php');

// Solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $data_abertura = mysqli_real_escape_string($con, $_POST['data_abertura']);
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $data_nascimento = mysqli_real_escape_string($con, $_POST['data_nascimento']);
    $genero = mysqli_real_escape_string($con, $_POST['genero']);
    $endereco = mysqli_real_escape_string($con, $_POST['endereco']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contato_emergencia = mysqli_real_escape_string($con, $_POST['contato_emergencia']);
    $escolaridade = mysqli_real_escape_string($con, $_POST['escolaridade']);
    $ocupacao = mysqli_real_escape_string($con, $_POST['ocupacao']);
    $necessidade = mysqli_real_escape_string($con, $_POST['necessidade']);
    $estagiario = mysqli_real_escape_string($con, $_POST['estagiario']);
    $orientador = mysqli_real_escape_string($con, $_POST['orientador']);
    $ra = mysqli_real_escape_string($con, $_POST['ra']);

    // Valida se todos os campos obrigatórios foram preenchidos
    if (
        !empty($data_abertura) && !empty($nome) && !empty($data_nascimento) &&
        !empty($genero) && !empty($endereco) && !empty($telefone) &&
        !empty($estagiario) && !empty($orientador) && !empty($ra)
    ) {
        // Consulta para buscar o ID do aluno pelo RA
        $query_aluno = "SELECT id FROM aluno WHERE ra = '$ra'";
        $result_aluno = mysqli_query($con, $query_aluno);

        if ($result_aluno && mysqli_num_rows($result_aluno) > 0) {
            $row = mysqli_fetch_assoc($result_aluno);
            $aluno_id = $row['id'];

            // Prepara a query de inserção
            $query = "INSERT INTO paciente (data_abertura, nome, data_nascimento, genero, endereco, telefone, email, contato_emergencia, escolaridade, ocupacao, necessidade, estagiario, orientador, aluno_id) 
                      VALUES ('$data_abertura', '$nome', '$data_nascimento', '$genero', '$endereco', '$telefone', '$email', '$contato_emergencia', '$escolaridade', '$ocupacao', '$necessidade', '$estagiario', '$orientador', '$aluno_id')";

            $result = mysqli_query($con, $query);

            // Verifica se o registro foi bem-sucedido
            if ($result) {
                // Redireciona com base no nível do usuário
                if ($_SESSION['nivel'] === 'ADM') {
                    header('Location: menu_adm.php');
                } elseif ($_SESSION['nivel'] === 'Professor') {
                    header('Location: menu_professor.php?id=' . $_SESSION['id_usuario']);
                } elseif ($_SESSION['nivel'] === 'Aluno') {
                    header('Location: menu_aluno.php');
                } else {
                    echo "<script>alert('Nível de acesso desconhecido!');</script>";
                }
                exit(); // Garante que o script não continue executando
            } else {
                echo "<script>alert('Erro ao cadastrar paciente: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Aluno com o RA informado não encontrado.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Main.CSS">
    <title>Cadastrar Paciente</title>
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
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            padding: 15px;
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

        input, textarea {
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        button {
            background-color: rgb(20, 147, 220);
            color: white;
            border: 2px solid rgb(17, 54, 71);
            padding: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: rgb(17, 54, 71);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cadastrar Paciente</h1>

        <form action="#" method="post">

            <label for="data_abertura">Data de Abertura:</label>
            <input type="date" name="data_abertura" required>

            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" required>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" required>

            <label for="genero">Gênero:</label>
            <input type="text" name="genero" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" required>

            <label for="telefone">Telefone:</label>
            <input type="number" name="telefone" required>

            <label for="email">Email:</label>
            <input type="email" name="email">

            <label for="contato_emergencia">Contato Emergencial:</label>
            <input type="number" name="contato_emergencia">

            <label for="escolaridade">Escolaridade:</label>
            <input type="text" name="escolaridade">

            <label for="ocupacao">Ocupação:</label>
            <input type="text" name="ocupacao">

            <label for="necessidade">Necessidade:</label>
            <input type="text" name="necessidade">

            <label for="estagiario">Aluno Responsável:</label>
            <input type="text" name="estagiario" required>

            <label for="orientador">Professor Supervisor:</label>
            <input type="text" name="orientador" required>

            <label for="ra">RA do Aluno Responsável:</label>
            <input type="number" name="ra" required>

            <button type="submit" name="botao" value="Cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
