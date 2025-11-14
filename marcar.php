<?php
session_start();
include 'conexao_db.php';

// Impede acesso sem login
if (!isset($_SESSION['email'])) {
    header('Location: entrar.php');
    exit;
}

$email_usuario = $_SESSION['email'];
$msg = $_GET['msg'] ?? "";

// Excluir evento (apenas se o evento pertencer ao usuário)
if (isset($_GET['excluir'])) {
    $id_excluir = (int) $_GET['excluir'];

    // Confere se o evento pertence ao usuário
    $verifica = $conexao->query("
        SELECT e.imagem 
        FROM eventos e 
        JOIN usuarios u ON e.id_usuario = u.id 
        WHERE e.id_evento = $id_excluir AND u.login = '$email_usuario'
    ");

    if ($verifica && $verifica->num_rows > 0) {
        $evento = $verifica->fetch_assoc();

        // Exclui a imagem do servidor (se existir)
        if (!empty($evento['imagem']) && file_exists($evento['imagem'])) {
            unlink($evento['imagem']);
        }

        // Remove o evento do banco
        $conexao->query("DELETE FROM eventos WHERE id_evento = $id_excluir");
        header("Location: marcar.php?msg=" . urlencode("Evento excluído com sucesso!"));
        exit;
    } else {
        $msg = "Erro: evento não encontrado ou você não tem permissão para excluí-lo.";
    }
}

// Cadastrar evento
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $descricao = $conexao->real_escape_string($_POST['descricao']);
    $local = $conexao->real_escape_string($_POST['local']);
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $capacidade = (int) $_POST['capacidade'];

    $res = $conexao->query("SELECT id FROM usuarios WHERE login = '$email_usuario'");
    $id_usuario = $res->fetch_assoc()['id'] ?? null;

    if (!$id_usuario) die("Erro: usuário não encontrado.");

    // Upload da imagem
    $imagem = "";
    if (!empty($_FILES['imagem']['name'])) {
        $pasta = "uploads/";
        if (!is_dir($pasta)) mkdir($pasta);
        $nome_arquivo = time() . "_" . basename($_FILES['imagem']['name']);
        $caminho = $pasta . $nome_arquivo;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $caminho;
        }
    }

    $sql = "INSERT INTO eventos (id_usuario, nome, descricao, local, data, hora, capacidade, imagem)
            VALUES ($id_usuario, '$nome', '$descricao', '$local', '$data', '$hora', $capacidade, '$imagem')";

    if ($conexao->query($sql)) {
        header("Location: marcar.php?msg=" . urlencode("Evento cadastrado com sucesso!"));
        exit;
    } else {
        $msg = "Erro ao cadastrar evento: " . $conexao->error;
    }
}

// Buscar eventos do usuário logado
$eventos = $conexao->query("
    SELECT * FROM eventos 
    WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$email_usuario')
    ORDER BY data, hora
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Evento</title>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'estrutura/navbar.php'; ?>

    <div class="container py-4">
        <h3 class="mb-4" style="font-weight: bolder;">Cadastrar Novo Evento</h3>

        <?php if ($msg): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <!-- Formulário de cadastro -->
        <form method="post" enctype="multipart/form-data" class="card p-4 bg-body-secondary shadow-sm mb-5">
            <div class="mb-3">
                <label class="form-label">Nome do evento</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Local</label>
                <input type="text" name="local" class="form-control" required placeholder="Ex: Avenida Paulista, São Paulo">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Data</label>
                    <input type="date" name="data" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Capacidade</label>
                    <input type="number" name="capacidade" class="form-control" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem do evento</label>
                <input type="file" name="imagem" class="form-control" accept="image/*">
            </div>

            <button class="btn btn-success w-25">Salvar</button>
        </form>

        <!-- Exibição dos eventos -->
        <div>
            <h4 class="mb-3">Seus eventos cadastrados</h4>

            <?php if ($eventos && $eventos->num_rows > 0): ?>
                <div class="row gy-4">
                    <?php while ($e = $eventos->fetch_assoc()): ?>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($e['imagem'])): ?>
                                    <img src="<?= htmlspecialchars($e['imagem']) ?>" 
                                         class="card-img-top"
                                         style="object-fit:cover;aspect-ratio:16/9;">
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($e['nome']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($e['descricao']) ?></p>
                                    <p><b>Local:</b> <?= htmlspecialchars($e['local']) ?></p>
                                    <p><b>Data:</b> <?= date('d/m/Y', strtotime($e['data'])) ?> às <?= date('H:i', strtotime($e['hora'])) ?></p>
                                    <p><b>Capacidade:</b> <?= (int)$e['capacidade'] ?></p>
                                </div>

                                <div class="card-footer bg-transparent d-flex gap-2">
                                    <a href="reservar.php?id=<?= $e['id_evento'] ?>" class="btn btn-success btn-sm w-50">Reservar</a>
                                    <a href="marcar.php?excluir=<?= $e['id_evento'] ?>" 
                                       class="btn btn-danger btn-sm w-50"
                                       onclick="return confirm('Deseja realmente excluir este evento?')">Excluir</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert bg-danger text-light">Nenhum evento cadastrado ainda.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
