<?php
$servername = "localhost";
$database = "saep_db";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

// Verifica se a URL enviou um ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //  Excluir as movimentações vinculadas a este produto
    $sqlMovimentacao = "DELETE FROM movimentacao WHERE produtos_idprodutos = '$id'";
    mysqli_query($conn, $sqlMovimentacao);

    //  Exibir o produto em si
    $sqlProduto = "DELETE FROM produtos WHERE idprodutos = '$id'";
    
    if (mysqli_query($conn, $sqlProduto)) {
        echo "<script>alert('Produto excluído com sucesso!'); window.location.href='consultaTabela.php';</script>";
    } else {
        echo "Erro ao excluir: " . mysqli_error($conn);
    }
}
?>