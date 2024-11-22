<?php

session_start();
session_unset();
session_destroy();

echo "<script> alert ('Você encerrou a sessão. Para recomeçar, faça o login.'); top.location.href='login.php';</script>";
?>