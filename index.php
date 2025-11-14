<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar-se</title>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'estrutura/navbar.php'; ?>
    <div class="container mt-3 pb-2">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4 mt-2 fw-bold">Cadastrar-se</h3>

                <?php
                // Exibir mensagens de sucesso ou erro
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'captcha') {
                        echo '<div class="alert alert-danger">Por favor, valide o hCaptcha para continuar!</div>';
                    } elseif ($_GET['error'] == 'email') {
                        echo '<div class="alert alert-danger">Este e-mail já está cadastrado!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Erro no cadastro. Tente novamente.</div>';
                    }
                } elseif (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">Cadastro realizado com sucesso! Faça login.</div>';
                }
                ?>

                <form action="login_cad.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Seu nome completo" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="exemplo@gmail.com" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" placeholder="Crie uma senha" name="senha" required>
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" id="mostrarSenha"
                                onclick="document.getElementById('senha').type = this.checked ? 'text' : 'password'">
                            <label class="form-check-label" for="mostrarSenha">Mostrar senha</label>
                        </div>
                    </div>

                    <!-- hCaptcha  -->
                    <div class="mb-3 text-center">
                        <div class="h-captcha" data-sitekey="589430fe-8536-4b56-b472-7f72a758c61c" data-hl="pt"></div>
                    </div>

                    <a href="entrar.php">Já está cadastrado? Entrar</a>
                    <br><br>

                    <button type="submit" class="btn btn-primary w-100 mb-4">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script do hCaptcha em Português -->
    <script src="https://hcaptcha.com/1/api.js?hl=pt" async defer></script>
</body>
</html>