<?php
session_start();
include 'conexao_db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: entrar.php");
    exit;
}

$email_usuario = $conexao->real_escape_string($_SESSION['email']);

// Busca ID do usuário logado
$resUser = $conexao->query("SELECT id FROM usuarios WHERE login = '$email_usuario'");
$id_usuario = $resUser->fetch_assoc()['id'] ?? 0;

if (!$id_usuario) {
    header("Location: entrar.php");
    exit;
}

// Mensagem opcional
$msg = isset($_GET['msg']) ? urldecode($_GET['msg']) : "";

// Busca reservas do usuário
$sql = "
    SELECT r.id_reserva, r.status, e.nome, e.local, e.data, e.hora
    FROM reservas r
    INNER JOIN eventos e ON r.id_evento = e.id_evento
    WHERE r.id_usuario = $id_usuario
    ORDER BY e.data, e.hora
";
$res = $conexao->query($sql);
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Minhas Reservas</title>
<link rel="stylesheet" href="css/style.css?v=2.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'estrutura/navbar.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Minhas Reservas</h3>
  </div>

  <?php if ($msg): ?>
    <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <?php if ($res && $res->num_rows > 0): ?>
  <div class="table-responsive shadow-sm border rounded">
    <table class="table table-striped align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Evento</th>
          <th>Local</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Status</th>
          <th class="text-center" style="width:180px;">Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nome']) ?></td>
          <td><?= htmlspecialchars($row['local']) ?></td>
          <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
          <td><?= date('H:i', strtotime($row['hora'])) ?></td>
          <td>
            <?php if ($row['status'] === 'A'): ?>
              <span class="badge bg-success">Ativa</span>
            <?php else: ?>
              <span class="badge bg-secondary">Cancelada</span>
            <?php endif; ?>
          </td>
          <td class="text-center">
            <?php if ($row['status'] === 'A'): ?>
              <form method="post" action="cancelar_reserva.php" class="d-inline" onsubmit="return confirm('Deseja cancelar esta reserva?')">
                <input type="hidden" name="id_reserva" value="<?= $row['id_reserva'] ?>">
                <button type="submit" class="btn btn-warning btn-sm text-dark fw-semibold">Cancelar</button>
              </form>
            <?php endif; ?>
            <form action="excluir_reserva.php" method="POST" style="display:inline;">
            <input type="hidden" name="id_reserva" value="<?= $row['id_reserva'] ?>">
            <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Deseja realmente excluir esta reserva?')">
                Excluir
            </button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-info mt-3">Você ainda não possui reservas.</div>
  <?php endif; ?>
</div>

</body>
</html>
