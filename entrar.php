<?php 
session_start();
include('conection.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE login = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $resultado = mysqli_fetch_array($resultado);
        if ($resultado["senha"] == $senha) {
        $_SESSION['nome'] = $resultado["nome"];
        header('Location: homepage.php');
        } else {
        header('Location: tela_entrar.php');
        };
    };
    
    mysqli_close($conexao);
}

?>