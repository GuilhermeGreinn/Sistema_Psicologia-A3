<?php
include('config.php');

// Solicita informações de cadastro e registra no banco
if(isset($_POST['botao']) && $_POST['botao'] == "Cadastrar"){

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = 'PROFESSOR';  // Definir como PROFESSOR diretamente

    // Validar se todos os campos estão preenchidos
    if(!empty($nome) && !empty($cpf) && !empty($senha) && !empty($email) && !empty($telefone)) {

        // Hash da senha para segurança
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verificar se o CPF já existe
        $checkQuery = $con->prepare("SELECT id FROM usuario WHERE cpf = ?");
        $checkQuery->bind_param("s", $cpf);
        $checkQuery->execute();
        $checkQuery->store_result();
        if ($checkQuery->num_rows > 0) {
            echo "Esse CPF já está em uso.";
            $checkQuery->close();
            exit;
        }
        $checkQuery->close();

        // Inserir o professor no banco
        $query = $con->prepare("INSERT INTO usuario (nome, cpf, senha, email, telefone, nivel) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param("ssssss", $nome, $cpf, $senhaHash, $email, $telefone, $nivel);
        
        if ($query->execute()) {
            echo "Professor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar professor.";
        }
        $query->close();
    } else {
        echo "Preencha todos os campos.";
    }
}
?>
