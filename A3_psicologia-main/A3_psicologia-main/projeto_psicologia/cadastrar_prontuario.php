<?php
include('config.php');

// Verifica se o ID do paciente foi passado via GET
if (isset($_GET['id'])) {
    $id_paciente = $_GET['id'];
} else {
    echo "ID do paciente não informado.";
    exit;
}

// Verifica se o formulário foi enviado
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $data_hora = $_POST['data_hora'];
    $avaliacao = $_POST['avaliacao'];
    $historico_familiar = $_POST['historico_familiar'];
    $historico_social = $_POST['historico_social'];

    // Verifica se todos os campos estão preenchidos
    if (!empty($data_hora) && !empty($avaliacao) && !empty($historico_familiar) && !empty($historico_social)) {
        // Insere os dados no banco de dados
        $query = "INSERT INTO prontuario (id_paciente, data_hora, avaliacao, historico_familiar, historico_social)
                  VALUES ('$id_paciente', '$data_hora', '$avaliacao', '$historico_familiar', '$historico_social')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Prontuário cadastrado com sucesso!');</script>";
            // Redireciona de volta para a página de pacientes
            echo "<script>window.location.href='menu_aluno.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar prontuário: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
    }
}
?>

<html>
<body>
    <h1>Cadastrar Prontuário</h1>

    <form action="#" method="post">
        <!-- ID do paciente está oculto -->
        <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">

        Data e Hora: <input type="datetime-local" name="data_hora" required><br><br>
        Avaliação: <textarea name="avaliacao" rows="4" cols="50" required></textarea><br><br>
        Histórico Familiar: <textarea name="historico_familiar" rows="4" cols="50" required></textarea><br><br>
        Histórico Social: <textarea name="historico_social" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" name="botao" value="Cadastrar">
    </form>

    <br><br>
</body>
</html>
