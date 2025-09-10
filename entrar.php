rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card p-2">
            <h3 class="mb-4 text-center"><i class="bi bi-door-open-fill"></i>Entrar</h3>
            <form id="cadastroForm">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control focus-ring focus-ring-dark " id="email" placeholder="Digite o seu e-mail" required style="border-color: black;"/>
                </div>
                <div class="mb-3 position-relative">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control focus-ring focus-ring-dark" id="senha" placeholder="Digite a sua senha" required style="border-color: black;"/>
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
                <a href="modi_senha.php" class="link small">Esqueceu a senha?</a> | <a href="index.php" class="link small">Cadastrar-se</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        // Função para alternar a visibilidade da senha
        document.getElementById('togglePassword').addEventListener('click', function() {
            const senhaInput = document.getElementById('senha');
            const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', type);
            
            // Alternar ícone
            this.classList.toggle('bi-eye-fill');
            this.classList.toggle('bi-eye-slash-fill');
        });

        // Função para limpar os campos
        document.getElementById('btnLimpar').addEventListener('click', function() {
            document.getElementById('email').value = '';
            document.getElementById('senha').value = '';
        });

        // Prevenir envio do formulário para demonstração
        document.getElementById('cadastroForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Formulário enviado com sucesso!');
        });
    </script>
</body>
</html>