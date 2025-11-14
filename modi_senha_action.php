<?php
session_start();
include('conexao_db.php');

if (isset($_POST['senha_atual'], $_POST['nova_senha'], $_POST['confirmar_senha'])) {
    // Verificar se o usuário está logado
    if (!isset($_SESSION['email'])) {
        header('Location: entrar.php?error=3'); // Não logado
        exit();
    }

    $email = $_SESSION['email'];
    $senha_atual = $conexao->real_escape_string($_POST['senha_atual']);
    $nova_senha = $conexao->real_escape_string($_POST['nova_senha']);
    $confirmar_senha = $conexao->real_escape_string($_POST['confirmar_senha']);

    // Verificar se as novas senhas coincidem
    if ($nova_senha !== $confirmar_senha) {
        header('Location: modi_senha.php?error=1'); // Senhas não coincidem
        exit();
    }

    // Verificar se a senha atual está correta
    $sql = "SELECT * FROM usuarios WHERE login = '$email' AND senha = '$senha_atual'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        // Atualizar a senha
        $update_sql = "UPDATE usuarios SET senha = '$nova_senha' WHERE login = '$email'";
        
        if ($conexao->query($update_sql)) {
            header('Location: entrar.php?success=2'); // Senha alterada com sucesso
            exit();
        } else {
            header('Location: modi_senha.php?error=3'); // Erro ao atualizar no banco
            exit();
        }
    } else {
        header('Location: modi_senha.php?error=2'); // Senha atual incorreta
        exit();
    }

} else {
    header('Location: modi_senha.php?error=4'); // Campos não preenchidos
    exit();
}
?>