<?php
session_start();
require_once "topo.php";
require_once "bd/conexao.php";

if (!isset($_SESSION['idFuncionario'])) {
    // Redirecionar para alguma página de erro ou login
    //header("Location: index.php"); // Substitua 'algumapagina.php' pela página desejada
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/formularios.css">
</head>


<?php
echo '<div class="search-form buscar" style="background-color: #637D72;">';
echo '    <h5>Registrar novos produtos</h5>';
echo '</div>';
?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'];
    $produto = $_POST['produto'];
    $valor = $_POST['valor'];
    $status = $_POST['status'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if ($id) {
        // Update
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
            $sql = "UPDATE galeria SET categoria = :categoria, produto = :produto, valor = :valor, status = :status, imagem = :imagem WHERE id = :id";
        } else {
            $sql = "UPDATE galeria SET categoria = :categoria, produto = :produto, valor = :valor, status = :status WHERE id = :id";
        }
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':produto', $produto);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':status', $status);
            if (isset($imagem)) {
                $stmt->bindParam(':imagem', $imagem, PDO::PARAM_LOB);
            }
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "<script language='javascript' type='text/javascript'>
            alert('Cadastro $produto atualizado com sucesso.');window.location .
            href='galeria.php'</script>";

        } catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        // Create
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
            try {
                $sql = "INSERT INTO galeria (categoria, produto, valor, status, imagem) VALUES (:categoria, :produto, :valor, :status, :imagem)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':produto', $produto);
                $stmt->bindParam(':valor', $valor);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':imagem', $imagem, PDO::PARAM_LOB);
                $stmt->execute();
                echo "Imagem adicionada com sucesso!";
                echo "<script language='javascript' type='text/javascript'>
                alert('Cadastro $produto realizado com sucesso.');window.location .
                href='galeria.php'</script>";
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Erro no upload do arquivo.";
        }
    }
}

if (isset($_GET['delete_id'])) {
    // Delete
    $delete_id = $_GET['delete_id'];
    try {
        $sql = "DELETE FROM galeria WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $delete_id);
        $stmt->execute();
        echo "Imagem excluída com sucesso!";
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";

$edit_data = null;
if (isset($_GET['edit_id'])) {
    // Retrieve data for editing
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM galeria WHERE id = :id");
    $stmt->bindParam(':id', $edit_id);
    $stmt->execute();
    $edit_data = $stmt->fetch();
}

?>



<body>
    <div class="container">
        <form action="addgaleria.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            
            <div><label for="produto">Nome do produto:</label>
                <input type="text" name="produto" id="produto" value="<?php echo $edit_data ? $edit_data['produto'] : ''; ?>" required><br>
            </div>
            
            <div><label for="valor">Valor:</label>
                <input type="text" name="valor" id="valor" value="<?php echo $edit_data ? $edit_data['valor'] : ''; ?>" required><br>
            </div>
        
            <div><label for="imagem">Imagem:
                <input type="file" name="imagem" id="imagem" accept="image/*"></label><br>
            </div>

            <div>Categoria: <br>
                <select name="categoria" style="padding: 8px; width: 190px; border: 1px solid #ccc;">
                    <option value="">Selecione</option>
                    <option value="moveis" <?php echo ($categoria == 'moveis') ? 'selected' : ''; ?>>Móveis</option>
                    <option value="estofados" <?php echo ($categoria == 'estofados') ? 'selected' : ''; ?>>Estofados</option>
                </select>
            </div><br>

            <div><label for="status ">Status: <br><select name="status" id="status" style="padding: 8px; width: 190px; border: 1px solid #ccc" required>
                <option value="disponível" <?php if ($edit_data && $edit_data['status'] == 'disponível') echo 'selected'; ?>>Disponível</option>
                <option value="vendido" <?php if ($edit_data && $edit_data['status'] == 'vendido') echo 'selected'; ?>>Vendido</option>
                </select></label>
            </div> 
        

            <input  type="submit" name="submit" value="<?php echo $edit_data ? 'Atualizar' : 'Adicionar'; ?>"> </div>
        
        </form>
    </div>
    
</body>
</html>