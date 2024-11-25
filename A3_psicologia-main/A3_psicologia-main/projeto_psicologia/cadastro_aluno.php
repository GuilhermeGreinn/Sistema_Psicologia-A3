<?php
include('config.php');

//solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $ra = $_POST['ra'];
    $senha = $_POST['senha']; // Criptografa a senha
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = "Aluno"; // Define o nível fixo para alunos
    $professor_id = $_POST['professor_id']; // Relacionamento obrigatório

    //valida se todos os campos foram preenchidos 
    if (!empty($nome) && !empty($cpf) && !empty($ra) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($professor_id)) {

        $query = "INSERT INTO aluno (nome, cpf, ra, senha, email, telefone, nivel, professor_id) 
                  VALUES ('$nome', '$cpf', '$ra', '$senha', '$email', '$telefone', '$nivel', '$professor_id')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Aluno cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar aluno: " . mysqli_error($con) . "');</script>";
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
            Professor Responsável (ID): <input type="number" name="professor_id" required><br>
            <input type="submit" name="botao" value="Cadastrar">

        </form>
    </body>
</html>
