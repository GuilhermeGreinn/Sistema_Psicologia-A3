<?php
include('config.php');
include('verifica_Cadastro.php');

// Deleta registro se solicitado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'], $_POST['id'])) {
    $tipo = mysqli_real_escape_string($con, $_POST['tipo']);
    $id = (int)$_POST['id']; // Garante que o ID seja um número
    $tabela = '';

    // Determina a tabela com base no tipo
    if ($tipo === 'Aluno') {
        $tabela = 'aluno';
    } elseif ($tipo === 'Professor') {
        $tabela = 'professor';
    } elseif ($tipo === 'Paciente') {
        $tabela = 'paciente';
    }

    // Executa a exclusão
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

// Consulta para pegar os registros das três tabelas
$query = "
    SELECT 'Aluno' AS tipo, a.id, a.nome
    FROM aluno a
    UNION
    SELECT 'Professor' AS tipo, pr.id, pr.nome
    FROM professor pr
    UNION
    SELECT 'Paciente' AS tipo, p.id, p.nome
    FROM paciente p
";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($con);
    exit;
}

// Mensagem de feedback
if (isset($status)) {
    if ($status === 'success') {
        echo "<p style='color: green;'>Registro deletado com sucesso!</p>";
    } elseif ($status === 'error') {
        echo "<p style='color: red;'>Erro ao deletar o registro. Tente novamente.</p>";
    } elseif ($status === 'invalid_type') {
        echo "<p style='color: red;'>Tipo de registro inválido!</p>";
    }
}
?>

<html>
<body>
    <h1>Bem-vindo</h1>
    <h2>Lista de Registros</h2>

    <!-- Botões para os cadastros -->
    <div style="margin-bottom: 20px;">
        <button onclick="window.location.href='cadastro_professor.php'">Cadastro Professor</button>
        <button onclick="window.location.href='cadastro_aluno.php'">Cadastro Aluno</button>
        <button onclick="window.location.href='cadastro_paciente.php'">Cadastro Paciente</button>
    </div>

    <!-- Tabela de registros -->
    <table border="1">
        <tr>
            <th>Tipo</th> <!-- Tipo de registro (Aluno, Professor, Paciente) -->
            <th>Nome</th>
            <th>Ações</th> <!-- Coluna para as ações -->
        </tr>
        <?php while ($coluna = mysqli_fetch_array($result)) { 
            // Definir o link de redirecionamento com base no tipo
            $link = '#'; // Valor padrão
            if ($coluna['tipo'] === 'Aluno') {
                $link = "menu_aluno.php?id=" . urlencode($coluna['id']);
            } elseif ($coluna['tipo'] === 'Professor') {
                $link = "menu_professor.php?id=" . urlencode($coluna['id']);
            } elseif ($coluna['tipo'] === 'Paciente') {
                $link = "prontuario.php?id=" . urlencode($coluna['id']);
            }
        ?>
            <tr>
                <td><?php echo $coluna['tipo']; ?></td> <!-- Exibe o tipo de registro -->
                <td>
                    <a href="<?php echo $link; ?>"><?php echo $coluna['nome']; ?></a> <!-- Link para página específica -->
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="tipo" value="<?php echo $coluna['tipo']; ?>">
                        <input type="hidden" name="id" value="<?php echo $coluna['id']; ?>">
                        <button type="submit" onclick="return confirm('Tem certeza que deseja deletar este registro?')">Deletar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br><br>
    <a href="logout.php">Sair</a>
</body>
</html>