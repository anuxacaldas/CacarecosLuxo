<?php
session_start();

require_once "conexao.php"; 
require_once "topo.php";


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Compra</title>
    <link rel="stylesheet" href="css/galery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
</head>

<body>
    <div class="category-bar">
        <a href="galeria.php" class="status-link <?php if ($statusFilter == '') echo 'active'; ?>">Todos</a>
        <a href="?categoria=móveis">Móveis</a>
        <a href="?categoria=estofados">Estofados</a>
        <a href="?status=Disponível">Disponível</a>
        <a href="?status=Vendido">Vendidos</a>
    </div>

    <div class="gallery">
        <?php
            $filtroCategoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
            $filtroStatus = isset($_GET['status']) ? $_GET['status'] : null;

            $sql = "SELECT * FROM galeria";

            if ($filtroCategoria) {
                // Adicionar filtro por categoria
                $sql .= " WHERE categoria = :categoria";
            } elseif ($filtroStatus) {
                // Adicionar filtro por status
                $sql .= " WHERE status = :status";
            }

            $stmt = $conn->prepare($sql);

            if ($filtroCategoria) {
                $stmt->bindParam(':categoria', $filtroCategoria);
            } elseif ($filtroStatus) {
                $stmt->bindParam(':status', $filtroStatus);
            }

            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $produto = htmlspecialchars($row['produto']);
                $valor = htmlspecialchars($row['valor']);
                $status = htmlspecialchars($row['status']);
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($row['imagem']);
                $whatsappMessage = "Olá, gostaria de comprar o produto $produto no valor de R$ $valor. O produto ainda está disponível?";
            
                // Adicionando status do produto
                $statusClass = $status == 'Disponível' ? 'status-Disponivel' : 'status-Indisponivel';
            
                // Verifica se o produto é destacado (supondo que 'destacado' seja um campo booleano na tabela)
            
                echo "<div class='gallery-item'>";
                echo "<img src='$imageSrc' alt='$produto'>";
                echo "<button class='enlarge-button' onclick='openModal(\"$imageSrc\")'>Ampliar</button>";
                echo "<p><h4>$produto</h4></p>";
                echo "<p><h6>R$ $valor</h6></p>";
                // Adicionando a classe CSS ao status do produto
                echo "<p class='$statusClass'>$status</p>";
                
                echo "<p>";

                // Verificar se o usuário está logado como funcionário
                if (isset($_SESSION['idFuncionario'])) {
                    echo "<a href='addgaleria.php?edit_id=" . $row['id'] . "'>Editar</a> | ";
                    echo "<a href='addgaleria.php?delete_id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja excluir esta imagem?');\">Excluir</a>";
                }
                
                echo "</p>";
                                // Mostrar botão do WhatsApp apenas se o produto estiver disponível
                if ($status == 'Disponível') {
                    echo "<a class='whatsapp-button' href='https://api.whatsapp.com/send?phone=5517992628925&text=" . urlencode($whatsappMessage) . "' target='_blank'>Comprar ❯</a>";
                }
                
                echo "</p>";
                echo "</div>";
            }
        ?>
    </div>

        <!-- "Modal para exibição de imagem em tamanho completo" -->
        <div id="imageModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>
        
        <script>
            function openModal(src) {
                document.getElementById("imageModal").style.display = "block";
                document.getElementById("modalImage").src = src;
            }

            function closeModal() {
                document.getElementById("imageModal").style.display = "none";
            }
        </script>

</body>
</html>
