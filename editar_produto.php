<?php

include ("assets/conexao.php");
// Verifica se o ID do produto foi fornecido na URL
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtém os detalhes do produto do banco de dados
    $sql = "SELECT * FROM produto WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Se o formulário foi submetido, atualize os detalhes do produto no banco de dados
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = $_POST['preco'];
            $link = $_POST['link'];

            $sql_update = "UPDATE produto SET nome='$nome', descricao='$descricao', preco='$preco', link='$link' WHERE id=$id";

            if ($conn->query($sql_update) === TRUE) {
                echo "Produto atualizado com sucesso.";
                header("Location: logado.php");

            } else {
                echo "Erro ao atualizar produto: " . $conn->error;
            }
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
</head>
<body>
    <h2>Editar Produto</h2>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $row['nome']; ?>"><br><br>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"><?php echo $row['descricao']; ?></textarea><br><br>
        <label for="preco">Preço:</label>
        <input type="text" id="preco" name="preco" value="<?php echo $row['preco']; ?>"><br><br>
        <label for="link">Link:</label>
        <input type="text" id="link" name="link" value="<?php echo $row['link']; ?>"><br><br>
        <input type="submit" value="Salvar">
    </form>
</body>
</html>
<?php
    } else {
        echo "Produto não encontrado.";
    }
} else {
    echo "ID do produto não fornecido.";
}

$conn->close();
?>
