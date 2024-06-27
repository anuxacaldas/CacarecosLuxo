<?php 
if(session_status() == PHP_SESSION_NONE) {
    session_start();


}
 require_once "conexao.php"; 
 require_once "topo.php";

 
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/components/modal/">
    <link rel="stylesheet" href="css/modalcoletas.css">
    <link rel="stylesheet" href="css/categorias.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
</head>

<style>
    
</style>
<body>
    
    <!-- Título de coletas -->
    <?php
    echo '<div class="search-form buscar" style="background-color: #637D72;">';
    echo '    <h5>Registro de Coletas</h5>';
    echo '</div>';
    ?>
    
    <!-- Filtro de coletas -->
    <div class="category-bar">
        <a href="list_coletas.php" class="status-link <?php if ($statusFilter == '') echo 'active'; ?>">Todos</a>
        <a href="list_coletas.php?status=pendente" class="status-link <?php if ($statusFilter == 'Pendente') echo 'active'; ?>">Pendente</a>
        <a href="list_coletas.php?status=agendado" class="status-link <?php if ($statusFilter == 'Agendado') echo 'active'; ?>">Agendado</a>
        <a href="list_coletas.php?status=retirado" class="status-link <?php if ($statusFilter == 'Retirado') echo 'active'; ?>">Retirado</a>
        
    </div><br>
    

    <!-- Busca de coletas -->
    <div class="container">
        <form method="GET" action="" style="display: flex; align-items: center; gap: 15px;">

            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <label for="data_retirada" style="margin-right: 5px;">Retirada:</label>
                <input type="date" name="data_retirada" id="data_retirada" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i> Buscar</button>
            </div>

            <div class="form-group">
                <a href="addcoleta.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-plus-lg"></i>
                Nova coleta</a>
            </div>
        </form>
    </div>
    
    <!-- Números de página -->

    
    <?php
        $dadosPorPagina = 5;


        $sqlTotal = "SELECT COUNT(*) AS total FROM tbfuncionario";
        $stmt = $conn->query($sqlTotal);
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($totalRegistros / $dadosPorPagina);
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        if ($paginaAtual < 1 || $paginaAtual > $totalPaginas) {
            $paginaAtual = 1;
        }

        $inicio = ($paginaAtual - 1) * $dadosPorPagina;

        // Consulta SQL com limitação para a página atual
        $sql = "SELECT * FROM tbcoletas ORDER BY id LIMIT $inicio, $dadosPorPagina";
        $resultado = $conn->query($sql);
    ?>

    

    <!-- Exibir links de paginação -->
    <div class="pagination">
        <?php
            if ($paginaAtual > 1) {
                echo "<a href='list_coletas.php?pagina=" . ($paginaAtual - 1) . "'>&laquo; Anterior</a>";
            } 
            for ($i = 1; $i <= $totalPaginas; $i++) {
                $classePaginaAtual = ($i == $paginaAtual) ? 'pagina-atual' : '';
                echo "<a href='list_coletas.php?pagina=$i' class='pagina $classePaginaAtual'>$i</a>";
            }
            if ($paginaAtual < $totalPaginas) {
                echo "<a href='list_coletas.php?pagina=" . ($paginaAtual + 1) . "'>Próxima &raquo;</a>";
            }
         ?>
    </div>


    <!-- Tabela de resultados -->

    <div class="container">
        <table>
            <tr><th>ID</th><th>Produto</th><th>Foto</th>
            <th>Status</th><th>Data Pedido</th><th>Data Retirada</th>
            <th>Dados Cliente</th><th>Ações</th></tr>
            
            <?php
            try {
                $status = isset($_GET['status']) ? $_GET['status'] : '';
                $data_retirada = isset($_GET['data_retirada']) ? $_GET['data_retirada'] : '';

                // Inicie a consulta SQL
                $sql = "SELECT tbcoletas.id, tbcoletas.produto, tbcoletas.tamanho, tbcoletas.tipo, tbcoletas.foto, tbcoletas.status, tbcoletas.data_pedido, tbcoletas.data_retirada, tbcoletas.id_cliente, tbclientes.nome AS cliente_nome, tbclientes.endereco AS cliente_endereco, tbclientes.telefone
                FROM tbcoletas
                JOIN tbclientes ON tbcoletas.id_cliente = tbclientes.id
                WHERE 1=1"; // 1=1 é uma condição sempre verdadeira, facilita a adição de outras condições

                if (!empty($status)) {
                    $sql .= " AND tbcoletas.status = :status";
                }
                if (!empty($data_retirada)) {
                    $sql .= " AND tbcoletas.data_retirada = :data_retirada";
                }
                $stmt = $conn->prepare($sql);

                // Associe os valores dos parâmetros de busca à consulta preparada
                if (!empty($status)) {
                    $stmt->bindParam(':status', $status);
                }
                if (!empty($data_retirada)) {
                    $stmt->bindParam(':data_retirada', $data_retirada);
                }
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['produto']."</td>";

                    echo "<td class='gallery-item'>
                    <a href='#' onclick='openModal(\"data:image/jpeg;base64,".base64_encode($row['foto'])."\")'>
                    <i class='bi bi-camera-fill icon-green'></i></a></td>";

                    echo "<td>".$row['status']."</td>";
                    echo "<td>".$row['data_pedido']."</td>";
                    echo "<td>".$row['data_retirada']."</td>";

                    echo "<td><a href='#' onclick='openClientModal(".$row['id_cliente'].", \"".$row['cliente_nome']."\", 
                    \"".$row['cliente_endereco']."\", \"".$row['telefone']."\")'>".$row['cliente_nome']."</a></td>";
                    
                    echo "<td>
                    
                    <a href='edit_coleta.php?id=".$row['id']."'><i class='bi bi-pencil-square icon-green'></i></a>
                    | </a>
                    <a href='#' onclick='openDeleteModal(".$row['id'].")'><i class='bi bi-trash3-fill icon-red'></i></a></td>";
                    echo "</tr>";
                }
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </table>
    </div>


    
    
    <!-- Modal de confirmação de exclusão -->
    <div id="deleteModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="#FFA500" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16" style="margin: 0 auto;">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 
                    3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <p><h6>Tem certeza de que deseja excluir esta coleta?</h6></p>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Confirmar</button><br>
                <button type="button" class="btn btn-secondary" onclick="cancelDelete()" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>


    <!-- CAIXA MODAL CLIENTES -->
    <div id="clientModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="closeClientModal()">&times;</span>
            <h6 class="modal-title"><b>INFORMAÇÕES DO CLIENTE</b></h6><br>
            <div id="clientDetails"></div>
        </div>
    </div>


    <!-- CAIXA MODAL DA IMAGEM -->
    <div id="myModal" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="">
            <button type="button" class="btn btn-secondary close-btn" onclick="closeModal()">Fechar</button>
        </div>
    </div>

    <script>
        //SCRIPT MODAL DA IMAGEM
        function openModal(imageSrc) {
            var modal = document.getElementById("myModal");
            var modalImage = document.getElementById("modalImage");
            modalImage.src = imageSrc;
            modal.style.display = "block";
            modal.style.position = "fixed"; // Define o posicionamento como fixo
            modal.style.top = "0"; // Define a posição superior como 0 para exibir o modal no topo
            }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
            }
            var modal = document.getElementById("myModal");
            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            }


        //SCRIPT MODAL CLIENTE
        function openClientModal(id, nome, endereco, telefone) {
            var modal = document.getElementById("clientModal");
            var clientDetails = document.getElementById("clientDetails");
            clientDetails.innerHTML = "<p><strong>Nome:</strong> " + nome + "</p><p><strong>Endereço:</strong> " + endereco + "</p><p><strong>Telefone:</strong> " + telefone + "</p>";
            modal.style.display = "block";
            }

        function closeClientModal() {
            var modal = document.getElementById("clientModal");
            modal.style.display = "none";
            }


        //SCRIPT MODAL EXCLUIR COLETA
        
        function openDeleteModal(id) {
            var modal = document.getElementById("deleteModal");
            modal.style.display = "block";
            // Armazena o id para uso na função confirmDelete
            window.coletaIdToDelete = id;
            }

        function confirmDelete() {
            var id = window.coletaIdToDelete;
            window.location.href = 'delete_coleta.php?id=' + id;
            }

        function cancelDelete() {
            var modal = document.getElementById("deleteModal");
            modal.style.display = "none";
            }
    </script>


</body>
</html>