<?php

session_start();
session_unset();
session_destroy();

echo "<script> alert ('Você encerrou a sessão. Para recomeçar, faça o login.'); top.location.href='login.php';</script>";

// Aguarda 2 segundos para a mensagem ser visível
sleep(2);

// Redireciona para a página de login
header("Location: login.php");
exit;
?>