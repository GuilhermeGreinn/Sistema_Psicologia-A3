<?php
include('config.php'); // Conexão com o banco de dados
include('verifica_Cadastro.php'); // Verificação de login e permissões
include('navbar.php'); // Navbar de navegação

// Verifica se o ID do professor foi fornecido via GET
if (!isset($_GET['id'])) {
    echo "ID do professor não informado.";
    exit;
}

$professor_id = intval($_GET['id']); // Obtém o ID do professor

// Excluir aluno, se solicitado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_aluno_id'])) {
    $aluno_id = intval($_POST['excluir_aluno_id']); // ID do aluno a ser excluído

    // Query para excluir o aluno
    $delete_query = "DELETE FROM aluno WHERE id = $aluno_id";
    if (mysqli_query($con, $delete_query)) {
    } else {
        echo "<p>Erro ao excluir o aluno: " . mysqli_error($con) . "</p>";
    }
}

// Consulta para buscar os alunos vinculados ao professor
$query = "SELECT id, nome, ra FROM aluno WHERE professor_id = $professor_id";
$result = mysqli_query($con, $query);

// Verifica se a consulta foi bem-sucedida
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
    <link rel="stylesheet" href="Main.CSS">
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
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            font-size: 24px;
        }
        #list-table th, #list-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
            color: black;
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

        .delete-btn {
            padding: 8px 12px;
            background: #ff4d4d;
            color: #fff;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #cc0000;
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

        .filter-container {
            margin: 10px 0;
            padding: 10px;
            background-color: rgba(20, 20, 20, 0.85);
            border-radius: 5px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
        }

        .filter-container input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .filter-container label {
            font-size: 16px;
            color: #fff;
            font-weight: bold;
        }

        /* Centralizar os botões de cadastrar */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        h2 {
            color: white;
            text-align: left;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?></h2>

        <div class="filter-container">
            <div>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome do aluno" onkeyup="filtrarTabela('nome')">
            </div>
            <div>
                <input type="text" id="ra" name="ra" placeholder="Digite o RA" onkeyup="filtrarTabela('ra')">
            </div>
        </div>

        <table id="list-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                    <th>RA</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($coluna = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><a href="menu_aluno.php?id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="excluir_aluno_id" value="<?php echo $coluna['id']; ?>">
                                <button class="delete-btn" type="submit" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
                            </form>
                        </td>
                        <td><?php echo $coluna['ra']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="action-buttons">
            <button class="button" onclick="window.location.href='cadastro_aluno.php'">Cadastrar Aluno</button>
            <button class="button" onclick="window.location.href='cadastro_paciente.php'">Cadastrar Paciente</button>
        </div>
    </div>

    <script>
        function filtrarTabela(campo) {
            let input = document.getElementById(campo);
            let filter = input.value.toUpperCase();
            let table = document.getElementById("list-table");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td")[campo === 'nome' ? 0 : 2];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
