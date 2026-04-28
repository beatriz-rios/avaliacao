<?php
// 1. CONEXÃO COM O BANCO
$conn = mysqli_connect("localhost", "root", "", "saep_db");

// 2. PEGA O ID DA URL (ex: editarProduto.php?id=5)
$id = $_GET['id'];

// 3. BUSCA OS DADOS DO PRODUTO NO BANCO
$sql = "SELECT * FROM produtos WHERE idprodutos = '$id'";
$resultado = mysqli_query($conn, $sql);

// 4. GUARDA OS DADOS NA VARIÁVEL $produto
// É aqui que a variável $produto nasce!
$produto = mysqli_fetch_assoc($resultado);

// 5. LÓGICA PARA SALVAR (Se clicar no botão salvar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novoNome = $_POST['nome'];
    $sqlUpdate = "UPDATE produtos SET nome = '$novoNome' WHERE idprodutos = '$id'";
    
    if (mysqli_query($conn, $sqlUpdate)) {
        header("Location: consultaTabela.php"); // Volta para a tabela
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto: <?php echo $produto['nome']; ?></h1>

    <form method="POST">
        <label>Nome do Produto:</label>
        <input type="text" name="nome" value="<?php echo $produto['nome']; ?>" required>
        
        <br><br>
        <button type="submit">Salvar Alterações</button>
        <a href="consultaTabela.php">Cancelar</a>
    </form>
</body>
</html>