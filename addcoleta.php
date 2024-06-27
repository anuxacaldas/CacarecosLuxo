<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "conexao.php";
require_once "topo.php";

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link rel="stylesheet" href="css/formularios.css">
</head>
<body>
    <div class="search-form buscar" style="background-color: #637D72;">
        <h5>Registrar novas coletas</h5>
    </div>

    <br>

    <div class="container">
        <form action="addcoleta.php" method="post" enctype="multipart/form-data">
            <div>Id: <input type="text" name="id" value="<?php echo isset($_SESSION['idClientes']) ? htmlspecialchars($_SESSION['idClientes']) : ''; ?>" readonly required></div>

            <div>Produto: <input type="text" name="produto" required></div>
            <div>Tamanho: <input type="text" name="tamanho"></div>
            <div>Tipo: <input type="text" name="tipo"></div>

            <div>Foto: <input type="file" name="foto" accept="image/*" required></div>
            <div>Data Pedido: <input type="date" name="data_pedido" required></div>

            <input type="submit" value="Cadastrar">
            <input type="reset" value="Cancelar"><br><br>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $produto = $_POST['produto'];
        $tamanho = $_POST['tamanho'];
        $tipo = $_POST['tipo'];
        $data_pedido = $_POST['data_pedido'];
        $id_cliente_post = $_POST['id']; // Nome do campo corrigido para 'id'
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Lidar com o upload da imagem

        // Validar se o ID Cliente enviado no formulário é o mesmo da sessão atual
        if ($id_cliente_post != $_SESSION['idClientes']) {
            die("Erro: Tentativa de adicionar coleta com ID de cliente inválido.");
        }

        try {
            $sql = "INSERT INTO tbcoletas (produto, tamanho, tipo, foto, data_pedido, id_cliente) 
                    VALUES (:produto, :tamanho, :tipo, :foto, :data_pedido, :id_cliente)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':produto', $produto);
            $stmt->bindParam(':tamanho', $tamanho);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
            $stmt->bindParam(':data_pedido', $data_pedido);
            $stmt->bindParam(':id_cliente', $_SESSION['idClientes']); // Usar $_SESSION['idClientes'] diretamente aqui

            $stmt->execute();

            echo "<script language='javascript' type='text/javascript'>
                  alert('Coleta solicitada com sucesso.');window.location.
                  href='list_coletas.php'</script>";
        } catch (PDOException $e) {
            echo "Erro ao adicionar coleta: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
