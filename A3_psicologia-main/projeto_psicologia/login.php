<?php
include('config.php');
session_start();

if(@$_REQUEST['botao'] == "Entrar"){
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha'";
    $result = mysqli_query($con, $query);

            echo $login.$senha;
    
}
?>

<hmtml>
<body>
    <form action=# method=post>

    Login:<input type=text name=login>
    Senha:<input type=text name=senha>
    <input type=submit name=botao value=Entrar>
</form>