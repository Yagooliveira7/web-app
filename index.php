<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if ($email === "teste@exemplo.com" && $senha === "1234") {
        header("Location: home.php");
        exit();
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
        <form method="POST" action="">
            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit">Cadastrar</button>
        </form>

        <div class="forgot-password">
            <p><a href="#">Esqueci minha senha</a></p>
        </div>
    </div>
</body>
</html>


