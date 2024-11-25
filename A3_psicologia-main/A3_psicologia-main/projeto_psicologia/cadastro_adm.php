<?php
include('config.php');

if(isset($_POST['botao']) && $_POST['botao'] == "Cadastrar"){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];

    if(!empty($email) && !empty($senha) && !empty($nivel)){
        $query = "INSERT INTO adm (email, senha, nivel) VALUES ('$email', '$senha', '$nivel')";
        $result = mysqli_query($con, $query);
    }
}
?>

<html>
    <body>
    <form action=# method=post>

Email:<input type=text name=email>
Senha:<input type=text name=senha>
Nível:<input type=text name=nivel>
<input type=submit name=botao value=Cadastrar>
</form>