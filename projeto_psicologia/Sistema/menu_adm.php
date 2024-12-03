<?php
include('config.php');
include('verifica_Cadastro.php');
include('navbar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'], $_POST['id'])) {
    $tipo = mysqli_real_escape_string($con, $_POST['tipo']);
    $id = (int)$_POST['id'];
    $tabela = '';

    if ($tipo === 'Aluno') {
        $tabela = 'aluno';
    } elseif ($tipo === 'Professor') {
        $tabela = 'professor';
    } elseif ($tipo === 'Paciente') {
        $tabela = 'paciente';
    }

    if ($tabela) {
        $query = "DELETE FROM $tabela WHERE id = $id";
        if (mysqli_query($con, $query)) {
            $status = "success";
        } else {
            $status = "error";
        }
    } else {
        $status = "invalid_type";
    }
}

// Consulta registros com filtro
$filtro = isset($_GET['filtro']) ? mysqli_real_escape_string($con, $_GET['filtro']) : '';

$query = "
    SELECT 'Aluno' AS tipo, a.id, a.nome
    FROM aluno a
    WHERE a.nome LIKE '%$filtro%'
    UNION
    SELECT 'Professor' AS tipo, pr.id, pr.nome
    FROM professor pr
    WHERE pr.nome LIKE '%$filtro%'
    UNION
    SELECT 'Paciente' AS tipo, p.id, p.nome
    FROM paciente p
    WHERE p.nome LIKE '%$filtro%'
";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($con);
    exit;
}

// Feedback de status
$status_message = '';
if (isset($status)) {
    if ($status === 'success') {
        $status_message = "<div class='alert success'>Registro deletado com sucesso!</div>";
    } elseif ($status === 'error') {
        $status_message = "<div class='alert error'>Erro ao deletar o registro.</div>";
    } elseif ($status === 'invalid_type') {
        $status_message = "<div class='alert error'>Tipo de registro inválido!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Menu Administrador</title>
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

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }

        h1 {
            text-align: center;
            color: #0077cc;
            margin-bottom: 20px;
        }

        .form-filtro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-filtro input[type="text"] {
            width: calc(100% - 110px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-filtro button {
            padding: 10px 20px;
            background-color: rgb(20, 147, 220);
            color: #fff;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            cursor: pointer;
        }

        .form-filtro button:hover {
            background-color: rgb(17, 54, 71);
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .btn-container button {
            margin: 5px;
            padding: 10px 20px;
            background-color: rgb(20, 147, 220);
            color: #fff;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-container button:hover {
            background-color: rgb(17, 54, 71);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            color: black;
        }

        table th {
            background-color: rgb(17, 54, 71);
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: rgba(20, 147, 220, 0.2);
        }

        table td:nth-child(1) {
            color: #000;
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

        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #ff3333;
            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            color: #cc0000;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Menu Administrador</h1>

        <?php echo $status_message; ?>

        <form class="form-filtro" method="GET">
            <input type="text" name="filtro" placeholder="Filtrar por nome" value="<?php echo htmlspecialchars($filtro); ?>">
            <button type="submit">Filtrar</button>
        </form>

        <div class="btn-container">
            <button onclick="window.location.href='cadastro_professor.php'">Cadastrar Professor</button>
            <button onclick="window.location.href='cadastro_aluno.php'">Cadastrar Aluno</button>
            <button onclick="window.location.href='cadastro_paciente.php'">Cadastrar Paciente</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($coluna = mysqli_fetch_array($result)) { 
                    $link = '#';
                    if ($coluna['tipo'] === 'Aluno') {
                        $link = "menu_aluno.php?id=" . urlencode($coluna['id']);
                    } elseif ($coluna['tipo'] === 'Professor') {
                        $link = "menu_professor.php?id=" . urlencode($coluna['id']);
                    } elseif ($coluna['tipo'] === 'Paciente') {
                        $link = "prontuario.php?id=" . urlencode($coluna['id']);
                    }
                ?>
                    <tr>
                        <td><?php echo $coluna['tipo']; ?></td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $coluna['nome']; ?></a>
                        </td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="tipo" value="<?php echo $coluna['tipo']; ?>">
                                <input type="hidden" name="id" value="<?php echo $coluna['id']; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Tem certeza que deseja deletar este registro?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
