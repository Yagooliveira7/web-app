<?php
session_start();
include('conexao_db.php');

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $conexao->real_escape_string(trim($_POST['email']));
    $senha = $conexao->real_escape_string(trim($_POST['senha']));

    // Verifica se a conta está bloqueada
    $check_bloqueio = "
        SELECT * FROM usuarios 
        WHERE login = '$email' AND bloqueado_ate IS NOT NULL AND bloqueado_ate > NOW()
        LIMIT 1
    ";
    $result_bloqueio = $conexao->query($check_bloqueio);

    if ($result_bloqueio && $result_bloqueio->num_rows > 0) {
        header('Location: entrar.php?error=3'); // Conta bloqueada
        exit();
    }

    // Verifica se o usuário existe e a senha confere
    $sql = "SELECT * FROM usuarios WHERE login = '$email' AND senha = '$senha' LIMIT 1";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Resetar tentativas e desbloqueio
        $reset_sql = "UPDATE usuarios 
                      SET tentativas_login = 0, bloqueado_ate = NULL, quant_acesso = quant_acesso + 1 
                      WHERE login = '$email'";
        $conexao->query($reset_sql);

        // Cria sessão do usuário
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['login'];

        header('Location: efetuado.php');
        exit();

    } else {
        // Incrementar tentativas falhas (apenas se o e-mail existir)
        $update_tentativas = "UPDATE usuarios 
                              SET tentativas_login = tentativas_login + 1 
                              WHERE login = '$email'";
        $conexao->query($update_tentativas);

        // Buscar quantas tentativas o usuário já fez
        $check_tentativas = "SELECT tentativas_login FROM usuarios WHERE login = '$email' LIMIT 1";
        $result_tentativas = $conexao->query($check_tentativas);

        if ($result_tentativas && $result_tentativas->num_rows > 0) {
            $dados = $result_tentativas->fetch_assoc();

            if ($dados['tentativas_login'] >= 3) {
                // Bloquear por 30 minutos
                $bloqueio_sql = "
                    UPDATE usuarios 
                    SET bloqueado_ate = DATE_ADD(NOW(), INTERVAL 30 MINUTE) 
                    WHERE login = '$email'
                ";
                $conexao->query($bloqueio_sql);
                header('Location: entrar.php?error=3'); // Conta bloqueada
                exit();
            } else {
                // Mostrar quantas tentativas restam
                $restantes = 3 - $dados['tentativas_login'];
                header("Location: entrar.php?error=1&tentativas={$restantes}");
                exit();
            }
        } else {
            header('Location: entrar.php?error=1');
            exit();
        }
    }
} else {
    header('Location: entrar.php?error=2'); // Campos vazios
    exit();
}
?>
