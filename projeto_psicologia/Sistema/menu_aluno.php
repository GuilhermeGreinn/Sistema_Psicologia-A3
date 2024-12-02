<?php
include('config.php');
include('verifica_Cadastro.php');

// Verifica se o ID do aluno foi passado pela URL
if (isset($_GET['id'])) {
    $aluno_id = intval($_GET['id']);
} else {
    if (isset($_SESSION['id_usuario']) && $_SESSION['nivel'] === 'Aluno') {
        $aluno_id = $_SESSION['id_usuario'];
    } else {
        die("ID do aluno não informado.");
    }
}

// Consulta informações do aluno
$query_aluno = "SELECT * FROM aluno WHERE id = $aluno_id";
$result_aluno = mysqli_query($con, $query_aluno);

if ($result_aluno && $coluna_aluno = mysqli_fetch_assoc($result_aluno)) {
    $nome_aluno = $coluna_aluno['nome'];
    $ra_aluno = $coluna_aluno['ra'];
} else {
    die("Aluno não encontrado.");
}

// Consulta lista de pacientes do aluno
$query_pacientes = "SELECT * FROM paciente WHERE aluno_id = $aluno_id";
$result_pacientes = mysqli_query($con, $query_pacientes);

if (!$result_pacientes) {
    die("Erro na consulta de pacientes: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <style>
        /* Adicione aqui o CSS fornecido */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
        }
        .main-content {
            width: 90%;
            margin: 20px auto;
            color: #333;
        }
        #list-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }
        #list-table th, #list-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        #list-table th {
            background-color: rgb(17, 54, 71);
            color: white;
        }
        #list-table tr:hover {
            background-color: rgba(20, 147, 220, 0.2);
        }
        .button {
            background-color: rgb(20, 147, 220);
            color: white;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }
        .button:hover {
            background-color: rgb(17, 54, 71);
        }
        .logout-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Bem-vindo</h1>
        <h2>Lista de Pacientes</h2>

        <table id="list-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Abertura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($coluna = mysqli_fetch_array($result_pacientes)) { ?>
                    <tr>
                        <td><a href="prontuario.php?id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                        <td><?php echo $coluna['data_abertura']; ?></td>
                        <td>
                            <button class="button" onclick="window.location.href='cadastrar_prontuario.php?id=<?php echo $coluna['id']; ?>'">
                                Cadastrar Prontuário
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <button class="button" onclick="window.location.href='cadastro_paciente.php'">
            Cadastrar Novo Paciente
        </button>
        <a class="logout-link" href="logout.php">Sair</a>
    </div>
</body>
</html>