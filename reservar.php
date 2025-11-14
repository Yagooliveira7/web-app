<?php
session_start();
include 'conexao_db.php';

// Impede acesso sem login
if (!isset($_SESSION['email'])) {
    header('Location: entrar.php');
    exit;
}

$email = $conexao->real_escape_string($_SESSION['email']);
$id_evento = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_evento <= 0) {
    header("Location: marcar.php?msg=" . urlencode("Evento inválido."));
    exit;
}

// Busca o ID do usuário logado
$res = $conexao->query("SELECT id FROM usuarios WHERE login = '$email'");
$id_usuario = $res->fetch_assoc()['id'] ?? 0;

if (!$id_usuario) {
    header("Location: entrar.php");
    exit;
}

// Verifica se já existe reserva para este evento
$verifica = $conexao->query("SELECT id_reserva FROM reservas WHERE id_usuario = $id_usuario AND id_evento = $id_evento");

if ($verifica->num_rows > 0) {
    header("Location: suas_reservas.php?msg=" . urlencode("Você já reservou este evento."));
    exit;
}

// Insere reserva na tabela
$sql = "INSERT INTO reservas (id_usuario, id_evento, status, data_reserva)
        VALUES ($id_usuario, $id_evento, 'A', NOW())";

if ($conexao->query($sql)) {
    header("Location: suas_reservas.php?msg=" . urlencode("Reserva realizada com sucesso!"));
} else {
    header("Location: suas_reservas.php?msg=" . urlencode("Erro ao registrar reserva: " . $conexao->error));
}
exit;
?>
