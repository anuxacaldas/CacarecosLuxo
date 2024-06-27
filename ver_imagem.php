<?php
require_once("conexao.php");

// Verificar se o parâmetro 'id' foi enviado na URL
if(isset($_GET['id'])) {
    try {
        // Preparar e executar a consulta para obter os dados da coleta
        $stmt = $conn->prepare("SELECT foto FROM tbcoletas WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        // Verificar se a coleta foi encontrada
        if($stmt->rowCount() > 0) {
            // Recuperar os dados da coleta
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Definir o tipo de conteúdo da página como imagem
            header("Content-Type: image/jpeg");
            // Exibir a imagem em seu tamanho real
            echo $row['foto'];
            exit(); // Parar a execução do script após exibir a imagem
        } else {
            echo "Coleta não encontrada.";
        }
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "ID da coleta não especificado.";
}
?>
