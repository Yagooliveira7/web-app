<?php
include 'conection.php';

if(isset($_POST['email']) && isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo "Preencha o seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        echo "Preencha a sua senha";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar-se</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card p-2">
            <h3 class="mb-4 text-center"><i class="bi bi-door-open-fill"></i>Cadastrar-se</h3>
            <form id="cadastroForm" action="cadastrar.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control focus-ring focus-ring-dark " id="email" name="email" placeholder="Coloque o seu e-mail" required style="border-color: black;"/>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control focus-ring focus-ring-dark " id="nome" name="nome" placeholder="Coloque o seu nome" required style="border-color: black;"/>
                    </div>
                </div>
                <div class="mb-3 position-relative">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control focus-ring focus-ring-dark" id="senha" name="senha" placeholder="Crie uma Senha" required style="border-color: black;"/>
                    <i class="bi bi-eye-fill position-absolute" id="togglePassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                <div class="mb-3 position-relative">
                    <label for="confirmar-senha" class="form-label">Confirmar senha</label>
                    <input type="password" class="form-control focus-ring focus-ring-dark" id="confirmar-senha" name="confirmar-senha" placeholder="Confirme a senha" required style="border-color: black;"/>
                    <i class="bi bi-eye-fill position-absolute" id="togglePassword" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-clear me-md-2" id="btnLimpar">
                        <i class="bi bi-eraser-fill"></i> Limpar
                    </button>
                    <button type="submit" class="btn btn-dark text-white">Validar</button>
                </div>
            </form>
            <div class="mt-3 text-center">
                <a href="tela_entrar.php" class="link small">Entrar</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
</body>
</html>