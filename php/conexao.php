<?php 
$servername = "localhost";
$database = "saep_db";
$username = "root";
$password = "";

// CORREÇÃO: A ordem correta é Servidor, Usuário, Senha e Banco de Dados
$conn = mysqli_connect($servername, $username, $password, $database);

// Opcional, mas muito útil: Verifica se a conexão falhou e avisa o motivo
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>