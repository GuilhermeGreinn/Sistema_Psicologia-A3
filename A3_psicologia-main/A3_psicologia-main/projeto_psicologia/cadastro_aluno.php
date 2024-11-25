<?php
include('config.php');

// Solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $cpf = mysqli_real_escape_string($con, $_POST['cpf']);
    $ra = mysqli_real_escape_string($con, $_POST['ra']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografa a senha
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telefone = mysqli_real_escape_string($con, $_POST['telefone']);
    $professor_email = mysqli_real_escape_string($con, $_POST['professor_email']); // Email do professor

    // Valida se todos os campos foram preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($ra) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($professor_email)) {
        
        // Verifica se o professor existe pelo email e obtém seu ID
        $professor_query = "SELECT id FROM professor WHERE email = '$professor_email'";
        $professor_result = mysqli_query($con, $professor_query);

        if ($professor_result && mysqli_num_rows($professor_result) > 0) {
            $professor = mysqli_fetch_assoc($professor_result);
            $professor_id = $professor['id'];

            // Insere o aluno na tabela
            $query = "INSERT INTO aluno (nome, cpf, ra, senha, email, telefone, professor_id) 
                      VALUES ('$nome', '$cpf', '$ra', '$senha', '$email', '$telefone', '$professor_id')";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<script>alert('Aluno cadastrado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar aluno: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Professor não encontrado. Verifique o email informado.');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos obrigatórios.');</script>";
    }
}
?>

<html>
    <body>
        <form action="#" method="post">

            Nome completo: <input type="text" name="nome" required><br>
            CPF: <input type="number" name="cpf" required><br>
            RA: <input type="number" name="ra" required><br>
            Senha: <input type="password" name="senha" required><br>
            Email: <input type="email" name="email" required><br>
            Telefone: <input type="number" name="telefone" required><br>
            Professor Responsável (Email): <input type="email" name="professor_email" required><br>
            <input type="submit" name="botao" value="Cadastrar">

        </form>
    </body>
</html>
