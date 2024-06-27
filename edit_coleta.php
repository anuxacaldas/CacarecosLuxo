<?php
  require_once "topo.php";
  require_once "bd/conexao.php";
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link rel="stylesheet" href="css/formularios.css">
</head>
</head>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validação e sanitização de entrada de dados
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $produto = isset($_POST['produto']) ? htmlspecialchars($_POST['produto']) : '';
    $tamanho = isset($_POST['tamanho']) ? htmlspecialchars($_POST['tamanho']) : '';
    $tipo = isset($_POST['tipo']) ? htmlspecialchars($_POST['tipo']) : '';
    $data_pedido = isset($_POST['data_pedido']) ? $_POST['data_pedido'] : '';
    $data_retirada = isset($_POST['data_retirada']) ? $_POST['data_retirada'] : '';
    $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';
    $id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : 0;

    // Lidar com o upload da imagem
    $foto = null;
    if (!empty($_FILES['foto']['tmp_name'])) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }

    // Atualizar a coleta no banco de dados
    $sql = "UPDATE tbcoletas SET produto = :produto, tamanho = :tamanho, tipo = :tipo, data_pedido = :data_pedido, data_retirada = :data_retirada, status = :status, id_cliente = :id_cliente";
    if ($foto !== null) {
        $sql .= ", foto = :foto";
    }
    $sql .= " WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':produto', $produto);
    $stmt->bindParam(':tamanho', $tamanho);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':data_pedido', $data_pedido);
    $stmt->bindParam(':data_retirada', $data_retirada);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id_cliente', $id_cliente);
    if ($foto !== null) {
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Coleta de $produto atualizada para $status.');window.location.href='list_coletas.php';</script>";
    } else {
        echo "Erro ao atualizar coleta.";
    }
}
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbcoletas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $coleta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($coleta) {
    ?>

<?php
echo '<div class="search-form buscar" style="background-color: #637D72;">';
echo '    <h5>Registrar novas coletas</h5>';
echo '</div>';
?>
<br>

    <div class="container">
        <form action="edit_coleta.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $coleta['id']; ?>">
        <div>ID Cliente: <input type="number" name="id_cliente" value="<?php echo $coleta['id_cliente']; ?>" readonly required><br>
        </div>
        <?php if (isset($_SESSION['idFuncionario'])): ?>
        <div>Status: <br>
        <select name="status" style="padding: 8px; width: 190px; border: 1px solid #ccc;">
            <option value="Pendente" <?php echo ($coleta['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
            <option value="Agendado" <?php echo ($coleta['status'] == 'Agendado') ? 'selected' : ''; ?>>Agendado</option>
            <option value="Retirado" <?php echo ($coleta['status'] == 'Retirado') ? 'selected' : ''; ?>>Recolhido</option>
        </select></div><br><?php endif; ?>
        <div>Produto: <input type="text" name="produto" value="<?php echo $coleta['produto']; ?>" required></div><br>
        <div>Tamanho: <input type="text" name="tamanho" value="<?php echo $coleta['tamanho']; ?>"><br></div>
        <div>Tipo: <input type="text" name="tipo" value="<?php echo $coleta['tipo']; ?>"><br></div>

        <div>Foto: <input type="file" name="foto" accept="image/*"><br> </div>
        <div>Data Pedido: <input type="date" name="data_pedido" value="<?php echo $coleta['data_pedido']; ?>" required><br></div>
        <?php if (isset($_SESSION['idFuncionario'])): ?>
            <div>Data Retirada: <input type="date" name="data_retirada" value="<?php echo $coleta['data_retirada']; ?>"><br>
        </div><?php endif; ?>

        <input type="submit" name="submit" value="Atualizar" class="btn btn-primary" id="saveButton">
    

    </form>
    </div>
    
    <?php
        } else {
            echo "Coleta não encontrada.";
        }
    }
    ?>
</body>
</html>
