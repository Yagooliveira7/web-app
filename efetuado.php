<?php
session_start();
include('conexao_db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

$nome_usuario = $_SESSION['nome'] ?? 'Usuário';
$id_usuario = $_SESSION['id_usuario'] ?? null; // importante para integrar com eventos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Logada</title>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'estrutura/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 text-center">
                <div class="py-3 mb-2">
                    <h4 class="text-xl text-blue-600">
                        Bem-vindo, <span class="fw-bolder">@<?= htmlspecialchars($nome_usuario) ?></span>!
                    </h4>
                </div>
                <div class="container">
                    <div class="row bg-dark bg-opacity-25 rounded py-2">
                        <h4>Opções Ativas:</h1>
                        <div class="col-4">
                            <form action="logout.php" method="POST">
                                <button type="submit" class="css-botao btn btn-danger btn-sm">
                                    Sair
                                </button>
                            </form>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='marcar.php'">
                                Marcar Evento
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='suas_reservas.php'">
                                Reservas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GOOGLE MAPS -->
    <div class="container mt-5 mb-5">
        <h5 class="text-center mb-3">Mapa de Localização</h5>
        <div id="map" style="height: 400px; width: 100%; border-radius: 10px; border: 2px solid #ccc;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(button => {
            button.addEventListener('click', () => button.blur());
        });

        // Inicializa o mapa
        function initMap() {
            const local = { lat: -23.2237, lng: -45.9009 }; // São José dos Campos/SP (exemplo)
            const mapa = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: local,
            });
            new google.maps.Marker({
                position: local,
                map: mapa,
                title: "São José dos Campos - SP"
            });
        }
    </script>

    <!-- Substitua a chave abaixo pela sua chave da API Google Maps -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1ymgJSOFD9yCS4hoC7hNeU8Km40bbQi0&callback=initMap">
    </script>

</body>
</html>
