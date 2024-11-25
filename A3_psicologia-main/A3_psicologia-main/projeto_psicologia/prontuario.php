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
?>

<html>
<body>
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
        <table border="1">
            <tr>
                <th>Data e Hora</th>
                <th>Ações</th>
            </tr>
            <?php while ($sessao = mysqli_fetch_array($result_sessoes)) { ?>
                <tr>
                    <td><a href="sessao_detalhes.php?sessao_id=<?php echo $sessao['id']; ?>"><?php echo $sessao['data_horario']; ?></a></td>
                    <td>
                        <a href="sessao_editar.php?sessao_id=<?php echo $sessao['id']; ?>">Editar Sessão</a>
                    </td>
                </tr>
            <?php } ?>
        </table>


    <br>
    <a href="criar_sessao.php?id=<?php echo $paciente['id']; ?>" class="btn">Criar Sessão</a>
    <br><br>
</body>
</html>
