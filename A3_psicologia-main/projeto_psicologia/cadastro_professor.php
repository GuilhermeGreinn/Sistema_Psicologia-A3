<?php
include('config.php');

//solicita informações de cadastro e registra no banco
if(isset($_POST['botao']) && $_POST['botao'] == "Cadastrar"){

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = $_POST['nivel'];

    //validar se todos os campos estao preenchidos
    if(!empty($nome) && !empty($cpf) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($nivel)) {
        $query = "INSSERT INTO professor (nome, cpf, senha, email, telefone, nivel) VALUES ('$nome', '$cpf', '$senha', '$email', '$telefone', '$nivel')";
        $result = mysqli_query($con, $query);
    }
}
?>