<?php
session_start();
include 'conexao_db.php';

// Impede acesso sem login
if (!isset($_SESSION['email'])) {
    header("Location: entrar.php");
    exit;
}

$email_usuario = $_SESSION['email'];

// Busca o ID do usuário logado
$stmtUser = $conexao->prepare("SELECT id FROM usuarios WHERE login = ?");
$stmtUser->bind_param("s", $email_usuario);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows === 0) {
    header("Location: entrar.php");
    exit;
}

$id_usuario = $resultUser->fetch_assoc()['id'];

// Verifica se veio o ID da reserva
if (!isset($_POST['id_reserva'])) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva não informada."));
    exit;
}

$id_reserva = (int) $_POST['id_reserva'];

// Exclui apenas a reserva (não o evento)
$stmt = $conexao->prepare("DELETE FROM reservas WHERE id_reserva = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_reserva, $id_usuario);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva excluída com sucesso!"));
} else {
    header("Location: suas_reservas.php?msg=" . urlencode("Erro: reserva não encontrada ou já excluída."));
}
exit;
?>
