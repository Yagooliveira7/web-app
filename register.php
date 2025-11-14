<?php
session_start();
include('conexao_db.php'); // Corrigido: nome do arquivo certo

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['senha'])) {
    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE login = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if ($usuario['senha'] === $senha) {
            // Guarda dados do usuário na sessão
            $_SESSION['email'] = $usuario['login'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo']; // caso use tipo (admin, comum etc.)

            header('Location: homepage.php');
            exit();
        } else {
            header('Location: tela_entrar.php?error=1'); // Senha incorreta
            exit();
        }
    } else {
        header('Location: tela_entrar.php?error=2'); // Usuário não encontrado
        exit();
    }

} else {
    header('Location: tela_entrar.php?error=3'); // Campos não preenchidos
    exit();
}
?>
