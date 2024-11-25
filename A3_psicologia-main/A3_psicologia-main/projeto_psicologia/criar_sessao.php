<?php
include('config.php');
session_start();

// Verifica se o ID do paciente foi enviado
if (!isset($_POST['paciente_id'])) {
    echo "ID do paciente não fornecido.";
    exit;
}

$paciente_id = intval($_POST['paciente_id']);

// Recupera o aluno_id da sessão
if (!isset($_SESSION['aluno_id'])) {
    echo "ID do aluno não encontrado. Faça login novamente.";
    exit;
}

$aluno_id = intval($_SESSION['aluno_id']);

// Insere uma nova sessão
$query = "INSERT INTO sessao (paciente_id, aluno_id, data_horario, status) VALUES ($paciente_id, $aluno_id, NOW(), 'pendente')";
$result = mysqli_query($con, $query);

if ($result) {
    // Atualiza a lista de sessões e envia de volta como resposta
    $query_sessoes = "SELECT * FROM sessao WHERE paciente_id = $paciente_id";
    $result_sessoes = mysqli_query($con, $query_sessoes);

    echo '<table border="1">
            <tr>
                <th>Data e Hora</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>';
    while ($sessao = mysqli_fetch_array($result_sessoes)) {
        echo '<tr>
                <td>' . $sessao['data_horario'] . '</td>
                <td>' . $sessao['status'] . '</td>
                <td>
                    <a href="sessao.php?sessao_id=' . $sessao['id'] . '">Editar Sessão</a>
                </td>
            </tr>';
    }
    echo '</table>';
} else {
    echo "Erro ao criar sessão: " . mysqli_error($con);
}
?>
