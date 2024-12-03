<?php
include('config.php');
include('verifica_Cadastro.php');
include('navbar.php');

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
    <link rel="stylesheet" href="Main.CSS">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-content {
            width: 90%;
            max-width: 1400px;
            margin: 20px auto;
        }

        h2 {
            color: white;
            text-align: left;
            font-size: 24px;
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
            width: 35%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .filter-container button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: rgb(20, 147, 220);
            border: none;
            border-radius: 4px;
            color: white;
            transition: background-color 0.3s;
        }

        .filter-container button:hover {
            background-color: rgb(17, 54, 71);
        }

        #list-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            font-size: 24px;
            text-align: center;
        }

        #list-table th, #list-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: black;
            text-align: center;
            vertical-align: middle;
        }

        #list-table th {
            background-color: rgb(17, 54, 71);
            color: white;
        }

        #list-table tr:hover {
            background-color: rgba(20, 147, 220, 0.2);
        }

        .new-patient-button {
            background-color: rgb(20, 147, 220);
            color: white;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            text-align: center;
            margin: 20px auto;
        }

        .new-patient-button:hover {
            background-color: rgb(17, 54, 71);
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?></h2>

        <div class="filter-container">
            <input type="text" id="name-search" placeholder="Buscar paciente" onkeyup="filterName()" />
            <button type="button" onclick="sortDate()">Alternar Ordem</button>
        </div>

        <table id="list-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Abertura</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($coluna = mysqli_fetch_array($result_pacientes)) { ?>
                <tr>
                    <td><a href="prontuario.php?id=<?php echo $coluna['id']; ?>"><?php echo $coluna['nome']; ?></a></td>
                    <td><?php echo $coluna['data_abertura']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <button class="new-patient-button" onclick="window.location.href='cadastro_paciente.php'">
            Cadastrar Novo Paciente
        </button>
    </div>
    <script>
        function filterName() {
            const searchInput = document.getElementById('name-search').value.toLowerCase();
            const rows = document.querySelectorAll('#list-table tbody tr');
            rows.forEach(row => {
                const listName = row.cells[0].innerText.toLowerCase();
                row.style.display = listName.includes(searchInput) ? '' : 'none';
            });
        }

        let isDescending = true;

        function sortDate() {
            const rows = Array.from(document.querySelectorAll('#list-table tbody tr'));
            rows.sort((a, b) => {
                const dateA = new Date(a.cells[1].innerText.split('/').reverse().join('-'));
                const dateB = new Date(b.cells[1].innerText.split('/').reverse().join('-'));
                return isDescending ? dateB - dateA : dateA - dateB;
            });
            const tbody = document.querySelector('#list-table tbody');
            rows.forEach(row => tbody.appendChild(row));
            isDescending = !isDescending;
        }
    </script>
</body>
</html>