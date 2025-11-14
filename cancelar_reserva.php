<?php
session_start();
include 'conexao_db.php';

// Usuário deve estar logado
if (!isset($_SESSION['email'])) {
    header("Location: entrar.php");
    exit;
}

$email = $conexao->real_escape_string($_SESSION['email']);
$id_reserva = 0;

// Aceita tanto GET (mais simples) quanto POST (recomendado)
if (isset($_POST['id_reserva'])) {
    $id_reserva = (int) $_POST['id_reserva'];
} elseif (isset($_GET['id_reserva'])) {
    $id_reserva = (int) $_GET['id_reserva'];
}

if ($id_reserva <= 0) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva inválida."));
    exit;
}

// Pega id do usuário logado
$res = $conexao->query("SELECT id FROM usuarios WHERE login = '$email'");
$id_usuario = $res->fetch_assoc()['id'] ?? 0;
if (!$id_usuario) {
    header("Location: entrar.php");
    exit;
}

// Verifica se a reserva pertence ao usuário
$ver = $conexao->query("SELECT id_reserva, status FROM reservas WHERE id_reserva = $id_reserva AND id_usuario = $id_usuario LIMIT 1");
if (!$ver || $ver->num_rows === 0) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva não encontrada ou não pertence a você."));
    exit;
}

$row = $ver->fetch_assoc();
if ($row['status'] === 'C') {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva já está cancelada."));
    exit;
}

// Atualiza status para 'C' (cancelada)
$update = $conexao->query("UPDATE reservas SET status = 'C' WHERE id_reserva = $id_reserva");
if ($update) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva cancelada com sucesso."));
} else {
    header("Location: suas_reservas.php?msg=" . urlencode("Erro ao cancelar: " . $conexao->error));
}
exit;
?>
