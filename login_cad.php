<?php
session_start();
include 'conexao_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $login = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);
    $captcha = $_POST['h-captcha-response'];

    // 🔒 Verifica se o hCaptcha foi preenchido
    if (empty($captcha)) {
        header("Location: index.php?error=captcha"); // CORRIGIDO: volta para index.php
        exit;
    }

    // 🔒 Chave secreta do hCaptcha
    $secretKey = "ES_d7a5a7767acd4b2196485888808702df";

    // Verifica com o hCaptcha
    $verify = file_get_contents("https://hcaptcha.com/siteverify?secret={$secretKey}&response={$captcha}");
    $responseData = json_decode($verify);

    if (!$responseData->success) {
        header("Location: index.php?error=captcha"); // CORRIGIDO: volta para index.php
        exit;
    }

    // Evita logins duplicados
    $check = $conexao->query("SELECT * FROM usuarios WHERE login = '$login'");
    if ($check->num_rows > 0) {
        header("Location: index.php?error=email"); // CORRIGIDO: volta para index.php
        exit;
    }

    // Inserir o novo usuário
    $stmt2 = $conexao->prepare("INSERT INTO usuarios (login, senha, nome, tipo, quant_acesso, status, tentativas_login) VALUES (?, ?, ?, 'U', 0, 'A', 0)");
    $stmt2->bind_param("sss", $login, $senha, $nome);

    if ($stmt2->execute()) {
        header("Location: index.php?success=1"); // CORRIGIDO: volta para index.php
        exit;
    } else {
        die("Erro ao inserir usuário: " . $conexao->error);
    }
} else {
    header("Location: index.php"); // CORRIGIDO: volta para index.php
    exit;
}