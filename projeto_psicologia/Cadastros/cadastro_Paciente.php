<?php
include("config.php");

// Solicita as informações de cadastro e registra no banco
if (isset($_POST['botao']) && $_POST['botao'] == "Cadastrar"){
    $data_abertura = $_POST['data_abertura'];
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato_emergencial = $_POST['contato_emergencial'];
    $escolaridade = $_POST['escolaridade'];
    $ocupacao = $_POST['ocupacao'];
    $necessidade = $_POST['necessidade'];
    $estagiario = $_POST['estagiario'];
    $orientador = $_POST['orientador'];

    // Valida se todos os campos foram preenchidos
    if(!empty($data_abertura) && !empty($nome) && !empty($data_nascimento) && !empty($genero) && !empty($endereco) && !empty($telefone) && !empty($email) && !empty($contato_emergencial) && !empty($escolaridade) && !empty($ocupacao) && !empty($necessidade) && !empty($estagiario) && !empty($orientador)){
        
        // Verificar se o paciente já existe (exemplo: pelo nome ou telefone)
        $checkQuery = $con->prepare("SELECT id FROM paciente WHERE telefone = ? OR email = ?");
        $checkQuery->bind_param("ss", $telefone, $email);
        $checkQuery->execute();
        $checkQuery->store_result();
        if ($checkQuery->num_rows > 0) {
            echo "Esse paciente já está cadastrado.";
            $checkQuery->close();
            exit;
        }
        $checkQuery->close();

        // Inserir o paciente no banco de dados
        $query = $con->prepare("INSERT INTO paciente (data_abertura, nome, data_nascimento, genero, endereco, telefone, email, contato_emergencial, escolaridade, ocupacao, necessidade, estagiario, orientador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("sssssssssssss", $data_abertura, $nome, $data_nascimento, $genero, $endereco, $telefone, $email, $contato_emergencial, $escolaridade, $ocupacao, $necessidade, $estagiario, $orientador);
        
        if ($query->execute()) {
            echo "Paciente cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar paciente.";
        }
        $query->close();
    } else {
        echo "Preencha todos os campos.";
    }
}
?>
