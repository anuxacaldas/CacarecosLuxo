<?php
session_start(); // Inicia a sessão (se já não estiver iniciada)

// Verifica se o usuário NÃO está logado
if (!isset($_SESSION['idClientes']) && !isset($_SESSION['idFuncionario'])) {
    // Redireciona para a página de login ou outra página de acesso restrito
    header('Location: login.php');
    exit; // Encerra o script para evitar que o restante do conteúdo seja exibido
}

// Inclui o arquivo de conexão e topo.php após a verificação de login
require_once("conexao.php");
require_once("topo.php");


// Inicializar variáveis
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$cpfFilter = isset($_GET['cpf']) ? $_GET['cpf'] : '';

// Construir consulta SQL baseada nos filtros
$sql = "SELECT * FROM tbclientes WHERE 1";
$params = [];

// Filtrar por status
if (!empty($statusFilter)) {
    $sql .= " AND status = ?";
    $params[] = $statusFilter;
}

// Filtrar por CPF
if (!empty($cpfFilter)) {
    $sql .= " AND cpf LIKE ?";
    $params[] = '%' . $cpfFilter . '%';
}

$sql .= " ORDER BY id";
$resultado = $conn->prepare($sql);
$resultado->execute($params);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/components/modal/">
    <link rel="stylesheet" href="css/modalcoletas.css">
    <link rel="stylesheet" href="css/categorias.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">

    <style>
        /* Estilos adicionais podem ser colocados aqui */
    </style>
</head>
<body>
    
    <div class="search-form buscar" style="background-color: #637D72;">
        <h5>Clientes Cadastrados</h5>
    </div>

    <div class="category-bar">
        <a href="listarcliente.php" class="status-link <?php if ($statusFilter == '') echo 'active'; ?>">Todos</a>
        <a href="listarcliente.php?status=Ativo" class="status-link <?php if ($statusFilter == 'Ativo') echo 'active'; ?>">Ativos</a>
        <a href="listarcliente.php?status=Inativo" class="status-link <?php if ($statusFilter == 'Inativo') echo 'active'; ?>">Inativos</a>
    </div><br>

    <div class="container">
        <form method="GET" action="">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                    <label for="cpf" style="margin-right: 5px;">CPF:</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo htmlspecialchars($cpfFilter); ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i> Buscar</button>
                </div>
                <div class="form-group">
                    <a href="cadcliente.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo Cliente</a>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <table class='table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Data Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $registro): ?>
                    <tr>
                        <td><?php echo $registro["id"]; ?></td>
                        <td><?php echo $registro["nome"]; ?></td>
                        <td><?php echo $registro["sobrenome"]; ?></td>
                        <td><?php echo $registro["cpf"]; ?></td>
                        <td><?php echo $registro["email"]; ?></td>
                        <td><?php echo $registro["status"]; ?></td>
                        <td><?php echo $registro["data_cadastro"]; ?></td>
                        
                        <td>
                            <a href='cadcliente.php?id=<?php echo $registro["id"]; ?>&acao=editar'><i class='bi bi-pencil-square icon-green'></i> Editar</a>
                            <a href='cadcliente.php?id=<?php echo $registro["id"]; ?>&acao=excluir'><i class='bi bi-trash3-fill icon-red'></i> Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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
                <p><h6>Tem certeza de que deseja excluir este cliente?</h6></p>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Confirmar</button><br>
                <button type="button" class="btn btn-secondary" onclick="cancelDelete()" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>

   

</body>
</html>

<?php
require_once "rodape.php";
?>
