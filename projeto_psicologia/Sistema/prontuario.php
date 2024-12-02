<?php
include('config.php');

// Verifica se o ID do paciente foi enviado via GET
if (!isset($_GET['id'])) {
    echo "Paciente não encontrado.";
    exit;
}

$id_paciente = intval($_GET['id']); // Garante que o ID é um número inteiro

// Consulta os dados do paciente
$query_paciente = "SELECT * FROM paciente WHERE id = $id_paciente";
$result_paciente = mysqli_query($con, $query_paciente);

if (!$result_paciente || mysqli_num_rows($result_paciente) == 0) {
    echo "Paciente não encontrado.";
    exit;
}

$paciente = mysqli_fetch_array($result_paciente);

// Consulta o prontuário do paciente
$query_prontuario = "SELECT * FROM prontuario WHERE id_paciente = $id_paciente";
$result_prontuario = mysqli_query($con, $query_prontuario);
$prontuario = mysqli_fetch_array($result_prontuario);

// Consulta as sessões do paciente
$query_sessoes = "SELECT * FROM sessao WHERE paciente_id = $id_paciente";
$result_sessoes = mysqli_query($con, $query_sessoes);

if (isset($_POST['baixar_todas_sessoes'])) {
    // Gera conteúdo para todas as sessões
    $conteudo = "Prontuário do Paciente - " . $paciente['nome'] . "\n\n";
    $conteudo .= "Dados do Paciente:\n";
    $conteudo .= "Nome: " . $paciente['nome'] . "\n";
    $conteudo .= "Data de Abertura: " . $paciente['data_abertura'] . "\n";
    // (adicione outros campos como no exemplo anterior)

    // Prontuário
    $conteudo .= "\nProntuário:\n";
    if ($prontuario) {
        $conteudo .= "Avaliação: " . $prontuario['avaliacao'] . "\n";
        $conteudo .= "Histórico Familiar: " . $prontuario['historico_familiar'] . "\n";
    } else {
        $conteudo .= "Prontuário não cadastrado.\n";
    }

    // Sessões
    $conteudo .= "\nSessões:\n";
    $query_sessoes = "SELECT * FROM sessao WHERE paciente_id = $id_paciente";
    $result_sessoes = mysqli_query($con, $query_sessoes);
    while ($sessao = mysqli_fetch_assoc($result_sessoes)) {
        $conteudo .= "Data e Hora: " . $sessao['data_horario'] . "\n";
        $conteudo .= "Presença: " . $sessao['presenca'] . "\n";
        $conteudo .= "Observações: " . $sessao['observacoes'] . "\n\n";
    }

    // Envia o arquivo
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="prontuario_completo_' . $paciente['id'] . '.txt"');
    echo $conteudo;
    exit();
}

if (isset($_POST['baixar_sessao_individual']) && isset($_POST['sessao_id'])) {
    $sessao_id = intval($_POST['sessao_id']);

    // Consulta a sessão específica
    $query_sessao = "SELECT * FROM sessao WHERE id = $sessao_id";
    $result_sessao = mysqli_query($con, $query_sessao);
    $sessao = mysqli_fetch_assoc($result_sessao);

    if ($sessao) {
        $conteudo = "Sessão do Paciente - " . $paciente['nome'] . "\n\n";
        $conteudo .= "Data e Hora: " . $sessao['data_horario'] . "\n";
        $conteudo .= "Presença: " . $sessao['presenca'] . "\n";
        $conteudo .= "Observações: " . $sessao['observacoes'] . "\n";

        // Envia o arquivo
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="sessao_' . $sessao_id . '.txt"');
        echo $conteudo;
        exit();
    } else {
        echo "<script>alert('Sessão não encontrada.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuário do Paciente</title>
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
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }
        h1, h2 {
            text-align: center;
            color: rgb(17, 54, 71);
        }
        p {
            margin: 10px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: rgb(17, 54, 71);
            color: white;
            padding: 10px;
            text-align: center;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: rgb(20, 147, 220);
        }
        a:hover {
            text-decoration: underline;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: rgb(20, 147, 220);
            color: #fff;
            border: 2px solid rgb(17, 54, 71);
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
        }
        .btn:hover {
            background-color: rgb(17, 54, 71);
            color: white;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Prontuário do Paciente</h1>
        
        <h2>Dados do Paciente</h2>
        <p><strong>Nome:</strong> <?php echo $paciente['nome']; ?></p>
        <p><strong>Data de Abertura:</strong> <?php echo $paciente['data_abertura']; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo $paciente['data_nascimento']; ?></p>
        <p><strong>Gênero:</strong> <?php echo $paciente['genero']; ?></p>
        <p><strong>Endereço:</strong> <?php echo $paciente['endereco']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $paciente['telefone']; ?></p>
        <p><strong>Email:</strong> <?php echo $paciente['email']; ?></p>
        <p><strong>Contato de Emergência:</strong> <?php echo $paciente['contato_emergencia']; ?></p>
        <p><strong>Escolaridade:</strong> <?php echo $paciente['escolaridade']; ?></p>
        <p><strong>Ocupação:</strong> <?php echo $paciente['ocupacao']; ?></p>
        <p><strong>Necessidades:</strong> <?php echo $paciente['necessidade']; ?></p>
        <p><strong>Estagiário:</strong> <?php echo $paciente['estagiario']; ?></p>
        <p><strong>Orientador:</strong> <?php echo $paciente['orientador']; ?></p>

        <h2>Prontuário</h2>
        <?php if ($prontuario) { ?>
            <p><strong>Avaliação:</strong> <?php echo $prontuario['avaliacao']; ?></p>
            <p><strong>Histórico Familiar:</strong> <?php echo $prontuario['historico_familiar']; ?></p>
            <p><strong>Histórico Social:</strong> <?php echo $prontuario['historico_social']; ?></p>
        <?php } else { ?>
            <p>Prontuário não cadastrado.</p>
        <?php } ?>

        <h2>Sessões</h2>
        <div class="actions">
            <!-- Botão Criar Sessão -->
            <a href="criar_sessao.php?id=<?php echo $paciente['id']; ?>" class="btn">Criar Sessão</a>

            <!-- Botão para baixar todas as sessões -->
            <form method="POST" action="" style="margin: 0;">
                <button type="submit" name="baixar_todas_sessoes" class="btn">Baixar Todas as Sessões</button>
            </form>
        </div>

        <!-- Tabela com as sessões -->
        <table>
            <tr>
                <th>Data e Hora</th>
                <th>Ações</th>
            </tr>
            <?php while ($sessao = mysqli_fetch_array($result_sessoes)) { ?>
                <tr>
                    <td>
                        <a href="sessao_detalhes.php?sessao_id=<?php echo $sessao['id']; ?>">
                            <?php echo $sessao['data_horario']; ?>
                        </a>
                    </td>
                    <td>
                        <!-- Botão para baixar a sessão individual -->
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="sessao_id" value="<?php echo $sessao['id']; ?>">
                            <button type="submit" name="baixar_sessao_individual" class="btn">Baixar Sessão</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>