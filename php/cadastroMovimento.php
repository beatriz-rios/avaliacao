<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Movimentação</title>
</head>

<body>
    <h1>Cadastro de Movimentação</h1>

    <ul>
        <li><a href="http://localhost/avaliacao/php/menu.php">Menu</a></li>
        <li><a href="http://localhost/avaliacao/php/cadastroProduto.php">Cadastro de Produtos</a></li>
        <li><a href="http://localhost/avaliacao/php/cadastroMovimento.php">Cadastro de Movimentação</a></li>
        <li><a href="http://localhost/avaliacao/php/consultaTabela.php">Consulta de Produtos</a></li>
    </ul>

    <form method="post">

        <select name="movimento" id="mov" required>
            <option value="">Selecione Movimentação</option>
            <option value="1">Entrada</option>
            <option value="2">Saida</option>
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
        } else {
            echo "<div class='mensagem erro'> " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    }

    // ============================================================================
    // VERIFICAÇÃO DE ESTOQUE PARA O ALERTA JS
    // ============================================================================
    $connAlerta = mysqli_connect("localhost", "root", "", "saep_db");
    $lista_alertas = []; // Criamos uma lista vazia para guardar as mensagens

    if ($connAlerta) {
        // Usamos a mesma query inteligente da consultaTabela.php para calcular o saldo exato
        $sqlEstoque = "
        SELECT 
            p.nome, 
            COALESCE(
                SUM(CASE WHEN m.movimentacao = '1' THEN m.quantidade ELSE 0 END) - 
                SUM(CASE WHEN m.movimentacao = '2' THEN m.quantidade ELSE 0 END)
            , 0) AS saldo_atual
        FROM 
            produtos p
        LEFT JOIN 
            movimentacao m ON p.idprodutos = m.produtos_idprodutos
        GROUP BY 
            p.idprodutos, p.nome
        HAVING 
            saldo_atual <= 10
    "; // O HAVING filtra o resultado mostrando APENAS os que têm 10 ou menos

        $resEstoque = mysqli_query($connAlerta, $sqlEstoque);

        if ($resEstoque) {
            // Para cada produto acabando, guardamos a frase personalizada
            while ($linha = mysqli_fetch_assoc($resEstoque)) {
                $lista_alertas[] = "⚠️ ALERTA DE ESTOQUE: O produto '" . $linha['nome'] . "' está acabando! Restam apenas " . $linha['saldo_atual'] . " no estoque.";
            }
        }
        mysqli_close($connAlerta);
    }
    ?>

    <script>
        // Pegamos a lista que o PHP criou e passamos para o JavaScript
        var alertas = <?php echo json_encode($lista_alertas); ?>;

        // Se a lista não estiver vazia (ou seja, se tiver produto acabando)
        if (alertas.length > 0) {
            // O join('\n\n') junta todas as mensagens e pula duas linhas entre elas
            // caso tenha mais de um produto acabando ao mesmo tempo.
            alert(alertas.join('\n\n'));
        }
    </script>

</body>

</html>

</body>

</html>