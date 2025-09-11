<?php 
session_start();
include('conection.php');

echo 'Bem vindo, '.$_SESSION['nome'];

?>