


<!-- html normal basico  -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form method="post">
        <input type="hidden" name="idprodutos" value="<?php echo $produto['idprodutos']; ?>">

        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
        <a href="consultaTabela.php">Cancelar</a>
    </form>

    <?php
$servername = "localhost";
$database = "saep_db";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

// Se o formulário foi enviado para atualizar o produto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['idprodutos'];
    $novoNome = $_POST['nome'];

    // Atualiza o nome do produto no banco
    $sqlAtualiza = "UPDATE produtos SET nome = '$novoNome' WHERE idprodutos = '$id'";
    
    if (mysqli_query($conn, $sqlAtualiza)) {
        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='consultaTabela.php';</script>";
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conn);
    }
}

// Busca os dados do produto para preencher o formulário
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT idprodutos, nome FROM produtos WHERE idprodutos = '$id'";
    $resultado = mysqli_query($conn, $sql);
    $produto = mysqli_fetch_assoc($resultado);
}
?>
</body>
</html>