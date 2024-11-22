<?php
include('config.php');

//solicita as informações de cadastro e registra no banco
if(isset($_POST ['botao']) && $_POST['botao'] == "Cadastrar"){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $ra = $_POST['ra'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = $_POST['nivel'];

    //valida se todos os campos foram preenchidos 
    if(!empty($nome) && !empty($cpf) && !empty($ra) && !empty($senha) && !empty($email) && !empty($telefone) && !empty($nivel)){

        $query = "INSERT INTO aluno (nome, cpf, ra, senha, email, telefone, nivel) VALUES ('$nome','$cpf','$ra','$senha', '$email','$telefone', '$nivel')";
        $result = mysqli_query($con, $query);

    }
}
?>