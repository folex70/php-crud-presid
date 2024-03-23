<?php
session_start();

$msg = '';

// Verificar se o usuário está logado
if(!isset($_SESSION['nome'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_product'])  ) {
    include ("assets/conexao.php");
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $sql = "INSERT INTO produto (nome, descricao, preco) VALUES ('$nome', '$descricao', $preco)";

    if ($conn->query($sql) === TRUE) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
}
//$conn->close();

?>
<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
    </head>
    <body>
    <div class="sidenav">
         <div class="login-main-text">
            <?php 
            echo "<h2>Bem-vindo, " . $_SESSION['nome'] . "!</h2>";
            echo "<p>Esta é a área logada.</p>";
            ?>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
            <body>
                <h2>Cadastro de Produto</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                    <label for="nome">Nome do Produto:</label><br>
                    <input type="text" id="nome" name="nome" required><br><br>
                    <label for="descricao">Descrição:</label><br>
                    <textarea id="descricao" name="descricao" required></textarea><br><br>
                    <label for="preco">Preço:</label><br>
                    <input type="number" id="preco" name="preco" step="0.01" required><br><br>
                    <input type="submit" name="insert_product" value="Cadastrar Produto">
                </form>
                <!-- listagem -->
                <?php
                // Verificar se o formulário para deletar um produto foi submetido
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
                    // Verificar se o ID do produto a ser excluído foi recebido
                    if (isset($_POST['product_id'])) {
                        $product_id = $_POST['product_id'];
                        // Consulta SQL para excluir o produto
                        include ("assets/conexao.php");
                        $sql = "DELETE FROM produto WHERE id = $product_id";

                        if ($conn->query($sql) === TRUE) {
                            echo "Produto excluído com sucesso.";
                        } else {
                            echo "Erro ao excluir produto: " . $conn->error;
                        }
                    }
                }

                // Consulta SQL para selecionar todos os produtos
                include ("assets/conexao.php");
                $sql = "SELECT id, nome, descricao, preco, link FROM produto";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Exibir cabeçalho da tabela
                    echo "<table><tr><th>Nome</th><th>Descrição</th><th>Preço</th><th>Excluir</th><th>Editar</th></tr>";
                    
                    // Exibir cada linha da tabela
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["descricao"] . "</td>";
                        echo "<td>R$ " . $row["preco"] . "</td>";
                        
                        // Adicionar o formulário para excluir o produto
                        echo "<td>
                                <form method='post' action='" . $_SERVER["PHP_SELF"] . "' onsubmit='return confirm(\"Tem certeza que deseja excluir este produto?\")'>
                                    <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                                    <input type='submit' name='delete_product' value='Excluir'>
                                    
                                </form>
                            </td>";
                        echo "<td><a href='editar_produto.php?id=".$row["id"]."'>Editar</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Nenhum produto encontrado.";
                }?>
            </body>     
            </div>
         </div>
      </div>
    </body>
</html>