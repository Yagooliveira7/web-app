<?php 
$host = 'localhost';
$usuario = 'root';
$senha = '';
$database = 'bd_crud_php';

// Cria a conexão corretamente
$conexao = new mysqli($host, $usuario, $senha, $database);

// Verifica se houve erro na conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error); 
}
?>
