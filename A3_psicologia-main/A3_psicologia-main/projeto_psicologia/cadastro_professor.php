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
        $query = "INSERT INTO professor (nome, cpf, senha, email, telefone, nivel) VALUES ('$nome', '$cpf', '$senha', '$email', '$telefone', '$nivel')";
        $result = mysqli_query($con, $query);
    }
}
?>

<html>
    <body>
        <form action=# method=post>

Nome: <input type=text name=nome>
CPF:<input type=number name=cpf>
Senha:<input type=text name=senha>
Email:<input type=text name=email>
Telefone:<input type=number name=telefone>
Nivel:<input type=text name=nivel>
<input type=submit name=botao value=Cadastrar>
        </form>
