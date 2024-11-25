<?php
include("config.php");

// Solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $data_abertura = $_POST['data_abertura'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato_emergencia = $_POST['contato_emergencia'];
    $escolaridade = $_POST['escolaridade'];
    $ocupacao = $_POST['ocupacao'];
    $necessidade = $_POST['necessidade'];
    $aluno_responsavel = $_POST['aluno_responsavel'];
    $professor_supervisor = $_POST['professor_supervisor'];
    $ra = $_POST['ra'];

    // Valida se todos os campos obrigatórios foram preenchidos
    if (
        !empty($data_abertura) && !empty($nome) && !empty($data_nascimento) &&
        !empty($genero) && !empty($endereco) && !empty($telefone) &&
        !empty($aluno_responsavel) && !empty($professor_supervisor) && !empty($ra)
    ) {
        // Consulta para buscar o ID do aluno pelo RA
        $query_aluno = "SELECT id FROM aluno WHERE ra = '$ra'";
        $result_aluno = mysqli_query($con, $query_aluno);

        if ($result_aluno && mysqli_num_rows($result_aluno) > 0) {
            $row = mysqli_fetch_assoc($result_aluno);
            $aluno_id = $row['id'];

            // Prepara a query de inserção
            $query = "INSERT INTO paciente (data_abertura, nome, data_nascimento, genero, endereco, telefone, email, contato_emergencia, escolaridade, ocupacao, necessidade, aluno_responsavel, professor_supervisor, aluno_id) 
                      VALUES ('$data_abertura', '$nome', '$data_nascimento', '$genero', '$endereco', '$telefone', '$email', '$contato_emergencia', '$escolaridade', '$ocupacao', '$necessidade', '$aluno_responsavel', '$professor_supervisor', '$aluno_id')";

            $result = mysqli_query($con, $query);

            // Verifica se o registro foi bem-sucedido
            if ($result) {
                echo "<script>alert('Paciente cadastrado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar paciente: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Aluno com o RA informado não encontrado.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
}
?>
<html>
<body>
    <form action="#" method="post">
        Data de Abertura: <input type="date" name="data_abertura" required><br>
        Nome Completo: <input type="text" name="nome" required><br>
        Data de Nascimento: <input type="date" name="data_nascimento" required><br>
        Gênero: <input type="text" name="genero" required><br>
        Endereço: <input type="text" name="endereco" required><br>
        Telefone: <input type="number" name="telefone" required><br>
        Email: <input type="email" name="email"><br>
        Contato Emergencial: <input type="number" name="contato_emergencia"><br>
        Escolaridade: <input type="text" name="escolaridade"><br>
        Ocupação: <input type="text" name="ocupacao"><br>
        Necessidade: <input type="text" name="necessidade"><br>
        Aluno Responsável: <input type="text" name="aluno_responsavel" required><br>
        Professor Supervisor: <input type="text" name="professor_supervisor" required><br>
        RA do Aluno Responsável: <input type="number" name="ra" required><br>
        <input type="submit" name="botao" value="Cadastrar">
        <a href="cadastrar_prontuario.php">Cadastrar Prontuario</a>
    </form>
</body>
</html>

