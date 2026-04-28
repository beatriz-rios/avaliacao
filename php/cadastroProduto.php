<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos Eletrônicos</title>
</head>
<body>
    <ul>
    <li><a href="http://localhost/avaliacao/php/menu.php">Menu</a></li>
    <li><a href="http://localhost/avaliacao/php/cadastroProduto.php">Cadastro de Produtos</a></li>
    <li><a href="http://localhost/avaliacao/php/cadastroMovimento.php">Cadastro de Movimentação</a></li>
    <li><a href="http://localhost/avaliacao/php/consultaTabela.php">Consulta de Produtos</a></li>
</ul>
    <h1>Cadastro de Produtos Eletrônicos</h1>
    <form method="post">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome"><br>

        <label for="tensao">Tensão/Voltagem:</label>
        <input type="text" id="tensao" name="tensao"><br>

        <label for="tela">Resolução da Tela:</label>
        <input type="text" id="tela" name="tela"><br>

        <label for="armazenamento">Armazenamento:</label>
        <input type="text" id="armazenamento" name="armazenamento"><br>

        <label for="conectividade">Conectividade:</label>
        <input type="text" id="conectividade" name="conectividade"><br>
        
        <input type="submit" value="Cadastrar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nome = $_POST['nome'];
        $tensao = $_POST['tensao'];
        $tela = $_POST['tela'];
        $armazenamento = $_POST['armazenamento'];
        $conectividade = $_POST['conectividade'];




        $servername = "localhost";
        $database = "saep_db";
        $username = "root";
        $password = "";

        $conn = mysqli_connect($servername, $username, $password, $database);
       if (!$conn) {
            echo "<div class='mensagem erro'>Falha na conexão: " . mysqli_connect_error() . "</div>";
            die();
        }


        $sql = "INSERT INTO produtos (
        nome, 
        tensaoVoltagem, 
        resolucaoTela, 
        armazenamento, 
        conectividade
        ) 
        VALUE (
        '$nome', 
        '$tensao',
        '$tela', 
        '$armazenamento', 
        '$conectividade'
        )";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='mensagem sucesso'>Produto cadastrado com sucesso.</div>";
        } else {
            echo "<div class='mensagem erro'> " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }


        mysqli_close($conn);
    }
    
    ?>
</body>
</html>