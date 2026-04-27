<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Movimentação</title>
</head>
<body>
    <h1>Cadastro de Movimentação</h1>

    <form method="post">

      <select name="movimento" id="mov" required>
            <option value="">Selecione Movimentação</option>
            <option value="2">Entrada</option>
            <option value="3">Saida</option>
        </select>

        <select name="produto" id="produto" required>
            <option value="">Selecione um Produto</option>
            <?php
            include 'conexao.php';
            
            if (isset($conn) && $conn) {
                $sqlObras = "SELECT idprodutos, nome FROM produtos ORDER BY nome";
                
                // Usando o padrão correto para não dar erro fatal e sumir com o resto da tela
                $resO = mysqli_query($conn, $sqlObras);
                
                if ($resO) {
                    while ($o = mysqli_fetch_assoc($resO)) {
                        $id = $o['idprodutos'];
                        $nome = htmlspecialchars($o['nome']);
                        echo "<option value='$id'>$nome</option>";
                    }
                }
            }
            ?>
        </select>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade"><br><br>

        <input type="submit" value="Cadastrar">
    </form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mov = $_POST["movimento"];
        $produto = $_POST["produto"];
        $quantidade = $_POST["quantidade"];

        $servername = "localhost";
        $database = "saep_db";
        $username = "root";
        $password = "";

        $conn = mysqli_connect($servername, $username, $password, $database);
        if (!$conn) {
            echo "<div class='mensagem erro'>Falha na conexão: " . mysqli_connect_error() . "</div>";
            die();
        }

        // Registra o histórico na tabela de movimentação
        $sql = "INSERT INTO movimentacao (
            movimentacao,
            produtos_idprodutos,
            quantidade
        ) 
        VALUES (
            '$mov', 
            '$produto',
            '$quantidade'
        )";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='mensagem sucesso'>Movimentação cadastrada com sucesso.</div>";
            
            // ====================================================================
            // NOVO: ATUALIZANDO O ESTOQUE FÍSICO NA TABELA PRODUTOS
            // ====================================================================
            if ($mov == '2') { // Se for Entrada, soma
                $sqlUpdate = "UPDATE movimentacao SET quantidade = quantidade + $quantidade WHERE idmovimentacao = '$produto'";
            } else if ($mov == '3') { // Se for Saída, subtrai
                $sqlUpdate = "UPDATE movimentacao SET quantidade = quantidade - $quantidade WHERE idmovimentacao = '$produto'";
            }
            
            // Executa a atualização na tabela produtos
            if(isset($sqlUpdate)){
                mysqli_query($conn, $sqlUpdate);
            }
            // ====================================================================

        } else {
            echo "<div class='mensagem erro'> " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    }
   
// ============================================================================
// VERIFICAÇÃO DE ESTOQUE PARA O ALERTA JS
// ============================================================================
$connAlerta = mysqli_connect("localhost", "root", "", "saep_db");
$lista_alertas = []; // Criamos uma lista vazia para guardar os nomes dos produtos

if ($connAlerta) {
    // Essa consulta soma as entradas (2) e subtrai as saídas (3) para achar o saldo real
    $sqlEstoque = "SELECT p.nome, 
                   SUM(CASE WHEN m.movimentacao = '2' THEN m.quantidade WHEN m.movimentacao = '3' THEN -m.quantidade ELSE 0 END) as saldo_atual 
                   FROM produtos p 
                   JOIN movimentacao m ON p.idprodutos = m.produtos_idprodutos 
                   GROUP BY p.idprodutos 
                   HAVING saldo_atual <= 10"; // Só pega se tiver 10 ou menos
                   
    $resEstoque = mysqli_query($connAlerta, $sqlEstoque);
    
    // Verificador de erros para te ajudar caso o banco rejeite a consulta
    if (!$resEstoque) {
        echo "<script>console.error('Erro no SQL do Alerta: " . mysqli_error($connAlerta) . "');</script>";
    } else {
        // Para cada produto acabando, guardamos uma frase na nossa lista
        while ($linha = mysqli_fetch_assoc($resEstoque)) {
            $lista_alertas[] = $linha['nome'] . " (Restam apenas " . $linha['saldo_atual'] . " no estoque)";
        }
    }
    mysqli_close($connAlerta);
}
?>

<script>
    // Pegamos a lista que o PHP criou e transformamos em uma lista do JavaScript
    var listaDeProdutosAcabando = <?php echo json_encode($lista_alertas); ?>;
</script>

<script src="../js/mov.js"></script>

</body>
</html>