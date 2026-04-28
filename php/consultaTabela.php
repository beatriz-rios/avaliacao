<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consulta Estoque</title>
</head>

<body>
    <h1>Consulta de Estoque</h1>
    <ul>
        <li><a href="http://localhost/avaliacao/php/menu.php">Menu</a></li>
        <li><a href="http://localhost/avaliacao/php/cadastroProduto.php">Cadastro de Produtos</a></li>
        <li><a href="http://localhost/avaliacao/php/cadastroMovimento.php">Cadastro de Movimentação</a></li>
        <li><a href="http://localhost/avaliacao/php/consultaTabela.php">Consulta de Produtos</a></li>
    </ul>
    <form method="GET">
        <input type="text" name="pesquisa" placeholder="Nome do produto">
        <button type="submit">Pesquisar</button>
    </form>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "saep_db");

    // 2. PEGA O QUE FOI DIGITADO (Se não digitou nada, fica vazio)
    $nome_pesquisado = $_GET['pesquisa'] ?? '';

    // 3. MONTA A QUERY SQL
    // O WHERE p.nome LIKE '$nome_pesquisado' filtra nomes que contenham o texto
    $sql = "
    SELECT 
        p.idprodutos, 
        p.nome, 
        COALESCE(
            SUM(CASE WHEN m.movimentacao = '1' THEN m.quantidade ELSE 0 END) - 
            SUM(CASE WHEN m.movimentacao = '2' THEN m.quantidade ELSE 0 END)
        , 0) AS estoque_atual
    FROM 
        produtos p
    LEFT JOIN 
        movimentacao m ON p.idprodutos = m.produtos_idprodutos
    WHERE p.nome LIKE '%$nome_pesquisado%'
    GROUP BY 
        p.idprodutos, p.nome
    ";

    $resultado = mysqli_query($conn, $sql);

    // 4. MOSTRA A TABELA
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Produto</th><th>Estoque</th><th>Ações</th></tr>";

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $row['idprodutos'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['estoque_atual'] . "</td>";
        echo "<td>
                <a href='editarProduto.php?id=" . $row['idprodutos'] . "'>Editar</a> | 
                <a href='excluirProduto.php?id=" . $row['idprodutos'] . "'>Excluir</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>


</body>

</html>