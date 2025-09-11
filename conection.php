<?php
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'bd_crud_php';

    $conexao = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    if ($conexao->connect_error) {
        echo('erro');
    }
?>