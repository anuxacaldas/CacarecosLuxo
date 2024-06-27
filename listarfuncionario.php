<?php
session_start();
require_once "topo.php";
require_once "bd/conexao.php";

if (!isset($_SESSION['idFuncionario'])) {
    // Redirecionar para alguma página de erro ou login
    //header("Location: index.php"); // Substitua 'algumapagina.php' pela página desejada
    exit;
}




// Inicializar variáveis
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$cpfFilter = isset($_GET['cpf']) ? $_GET['cpf'] : '';

// Construir consulta SQL baseada nos filtros
$sql = "SELECT * FROM tbfuncionario WHERE 1";
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
    <link rel="stylesheet" href="css/galery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    echo '<div class="search-form buscar" style="background-color: #637D72;">';
    echo '    <h5>Funcionários cadastrados</h5>';
    echo '</div>';
    ?>

    <div class="category-bar">
        <a href="listarfuncionario.php" class="status-link <?php if ($statusFilter == '') echo 'active'; ?>">Todos</a>
        <a href="listarfuncionario.php?status=Ativo" class="status-link <?php if ($statusFilter == 'Ativo') echo 'active'; ?>">Ativos</a>
        <a href="listarfuncionario.php?status=Suspenso" class="status-link <?php if ($statusFilter == 'Suspenso') echo 'active'; ?>">Suspensos</a>
    </div>
    <br>

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
                    <a href="cadfuncionario.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-plus-lg"></i> Novo funcionário</a>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <!-- Barra de navegação para filtrar por status -->

        <?php
        echo "<table class='table'>";
        echo "<tr>
            <th>ID</th>
            <th>CPF</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Função</th>
            <th>Email</th>
            <th>Status</th>
            <th>Ações</th>
            </tr>";

        foreach($resultado as $registro) {
            $sobrenome = isset($registro["sobrenome"]) ? $registro["sobrenome"] : 'N/A';
            $status = isset($registro["status"]) ? $registro["status"] : 'N/A';
            echo "<tr>
                <td>".$registro["id"]."</td>
                <td>".$registro["cpf"]."</td>
                <td>".$registro["nome"]."</td>
                <td>".$sobrenome."</td>
                <td>".$registro["funcao"]."</td>
                <td>".$registro["email"]."</td>
                <td>".$status."</td>
                <td>
                    <a href='cadfuncionario.php?id=".$registro["id"]."&acao=editar'><i class='bi bi-pencil-square icon-green'></i> Editar</a>
                    <a href='cadfuncionario.php?id=".$registro["id"]."&acao=excluir'><i class='bi bi-trash3-fill icon-red'></i> Excluir</a>
                </td>
                </tr>";
        }

        echo "</table>";
        ?>
    </div>
</body>
</html>

<?php
require_once "rodape.php";
?>
