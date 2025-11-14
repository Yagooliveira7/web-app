<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'estrutura/navbar.php' ?>
    <div class="container mt-3 pb-2">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4 mt-2" style="font-weight: bolder">Alterar Senha</h3>

                <?php
                // Mensagens de erro
                if (isset($_GET['error'])) {
                    $errors = [
                        1 => 'As novas senhas não coincidem!',
                        2 => 'Senha atual incorreta!',
                        3 => 'Erro ao atualizar senha!',
                        4 => 'Preencha todos os campos!'
                    ];
                    echo '<div class="alert alert-danger">' . $errors[$_GET['error']] . '</div>';
                }
                ?>

                <form action="modi_senha_action.php" method="POST">
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="senha_atual" placeholder="Sua senha atual"
                            name="senha_atual" required>
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" placeholder="Digite a nova senha"
                            name="nova_senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha"
                            placeholder="Confirme a nova senha" name="confirmar_senha" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="mostrarSenhas" onclick="
                            document.getElementById('senha_atual').type = this.checked ? 'text' : 'password';
                            document.getElementById('nova_senha').type = this.checked ? 'text' : 'password';
                            document.getElementById('confirmar_senha').type = this.checked ? 'text' : 'password';
                        ">
                        <label class="form-check-label" for="mostrarSenhas">Mostrar senhas</label>
                    </div>

                    <a href="entrar.php">Voltar para login</a>
                    <br><br>
                    <button type="submit" class="btn btn-primary w-100 mb-4">Alterar Senha</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>