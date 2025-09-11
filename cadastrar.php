<?php
include('conection.php');

if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO usuarios (login, senha, nome, tipo, quant_acesso, status) 
            VALUES ('$email', '$senha', '$nome', 1, 0, 'A')";

    mysqli_query($conexao, $sql);
    
    header('Location: index.php');
    mysqli_close($conexao);
}
?>