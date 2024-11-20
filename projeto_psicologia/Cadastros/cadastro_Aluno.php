<?php
include('config.php');

//solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar") {
    // Coleta as informações do aluno
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $ra = $_POST['ra'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nivel = 'ALUNO';  // Definir como ALUNO diretamente

    // Valida se todos os campos estão preenchidos
    if (!empty($nome) && !empty($cpf) && !empty($ra) && !empty($senha) && !empty($email) && !empty($telefone)) {
        // Verificar se o RA já existe
        $checkQuery = $con->prepare("SELECT id FROM usuario WHERE ra = ?");
        $checkQuery->bind_param("s", $ra);
        $checkQuery->execute();
        $checkQuery->store_result();
        if ($checkQuery->num_rows > 0) {
            echo "Esse RA já está em uso.";
            $checkQuery->close();
            exit;
        }
        $checkQuery->close();

        // Hash da senha para segurança
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir o aluno no banco
        $query = $con->prepare("INSERT INTO usuario (nome, cpf, ra, senha, email, telefone, nivel) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("sssssss", $nome, $cpf, $ra, $senhaHash, $email, $telefone, $nivel);
        
        if ($query->execute()) {
            echo "Aluno cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar aluno.";
        }
        $query->close();
    } else {
        echo "Preencha todos os campos.";
    }
}
?>
