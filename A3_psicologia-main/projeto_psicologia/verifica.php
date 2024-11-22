<?php
//inicia sessao
session_start();

//verifica credenciais 
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["id_usuario"])){
    
    //caso nao encontrado, redireciona pagina de login
    header("Location: login.php");
    exit;
}
?>