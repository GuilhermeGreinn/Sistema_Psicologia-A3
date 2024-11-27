<?php
include('config.php');
include('verifica_Cadastro.php');

// Excluir aluno se a solicitação POST for enviada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_aluno_id'])) {
    $aluno_id = intval($_POST['excluir_aluno_id']);
    $delete_query = "DELETE FROM aluno WHERE id = $aluno_id";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        echo "<p>Aluno excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir o aluno: " . mysqli_error($con) . "</p>";
    }
}

// Consulta a lista de alunos
$query = "SELECT * FROM aluno";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($con);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <style>
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
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        #list-table th, #list-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center; /* Centraliza horizontalmente */
            vertical-align: middle; /* Centraliza verticalmente */
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
            border: none;
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
        form {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Bem-vindo, Professor <?php echo $_SESSION['nome']; ?></h1>
        <h2>Lista de Alunos</h2>

        <table id="list-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>RA</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($coluna = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><a href="menu_aluno.php?aluno_id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                        <td><?php echo $coluna['ra']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="excluir_aluno_id" value="<?php echo $coluna['id']; ?>">
                                <button class="button" type="submit" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>
        <div>
            <button class="button" onclick="window.location.href='cadastro_aluno.php'">Cadastrar Aluno</button>
            <button class="button" onclick="window.location.href='cadastro_paciente.php'">Cadastrar Paciente</button>
        </div>

        <a class="logout-link" href="logout.php">Sair</a>
    </div>
</body>
</html>
