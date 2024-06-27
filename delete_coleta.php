<?php require_once("conexao.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tbcoletas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script language='javascript' type='text/javascript'>
        alert('Coleta excluída com sucesso.');window.location .
        href='list_coletas.php'</script>";

    } else {
        echo "Erro ao excluir coleta.";
    }
}
    
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
