<?php
// Defina as credenciais do banco de dados
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'A3';

// Criação da conexão
$con = mysqli_connect($host, $username, $password, $database);

// Verificação de erro de conexão
if (!$con) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Defina o charset para garantir a correta codificação dos caracteres
mysqli_set_charset($con, 'utf8');

// Verificação da seleção do banco de dados
if (!mysqli_select_db($con, $database)) {
    die("Erro ao selecionar o banco de dados: " . mysqli_error($con));
}
?>