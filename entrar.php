<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'estrutura/navbar.php'; ?>
    <div class="container mt-3 pb-2">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4 mt-2 fw-bold">Entrar</h3>

                <?php
                // Mensagens de erro ou sucesso
                $errors = [
                    1 => 'E-mail ou senha incorretos!',
                    2 => 'Por favor, valide o hCaptcha para continuar!',
                    3 => 'Conta bloqueada! Tente novamente em 30 minutos.'
                ];

                if (isset($_GET['error'])) {
                    $error_code = (int) $_GET['error'];
                    if (isset($errors[$error_code])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($errors[$error_code]);
                        if (isset($_GET['tentativas'])) {
                            $tentativas = (int) $_GET['tentativas'];
                            echo '<br>Tentativas restantes: ' . $tentativas;
                        }
                        echo '</div>';
                    }
                }

                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success">Cadastro feito com sucesso</div>';
                }
                ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="exemplo@gmail.com" name="email"
                            required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" placeholder="Sua senha" name="senha"
                            required autocomplete="off">
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" id="mostrarSenha"
                                onclick="document.getElementById('senha').type = this.checked ? 'text' : 'password'">
                            <label class="form-check-label" for="mostrarSenha">Mostrar senha</label>
                        </div>
                    </div>

                    <!-- 🔒 hCaptcha em Português -->
                    <div class="mb-3 text-center">
                        <div class="h-captcha" data-sitekey="589430fe-8536-4b56-b472-7f72a758c61c" data-hl="pt"></div>
                    </div>

                    <a href="modi_senha.php">Esqueci a Senha</a><br>
                    <a href="index.php">Não está cadastrado? Cadastrar-se</a>
                    <br><br>

                    <button type="submit" class="btn btn-primary w-100 mb-4">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script do hCaptcha em Português -->
    <script src="https://hcaptcha.com/1/api.js?hl=pt" async defer></script>
</body>
</html>