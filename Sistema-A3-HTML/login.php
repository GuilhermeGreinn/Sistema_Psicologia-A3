<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/main.css">
    <title>Login</title>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <form action="verifica_Cadastro.php" method="post">
            <label for="email"><strong>Login</strong></label>
            <input class="login-input" type="email" id="email" name="email" placeholder="numerodoRA@ulife.com.br" required>
            <label for="password"><strong>Senha</strong></label>
            <input class="login-input" type="password" id="password" name="password" placeholder="Insira sua senha" required>
            <button type="submit" class="login-btn">Entrar</button>
        </form>
    </div>
</div>

</body>
</html>
