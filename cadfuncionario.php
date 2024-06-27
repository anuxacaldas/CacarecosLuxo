<?php
session_start();
require_once "topo.php";
require_once "bd/conexao.php";

if (!isset($_SESSION['idFuncionario'])) {
    echo "<div class='alert alert-warning' role='alert'>Por favor, faça seu cadastro para acessar esta página.</div>";
    exit();
}
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
echo '<div class="search-form buscar" style="background-color: #637D72;">';
echo '    <h5>Área do Funcionário</h5>';
echo '</div>';
?>


<?php

// Função para verificar se o CPF ou email já estão registrados
function verificarExistencia($conn, $cpf, $email, $id = null) {
    
    $filtroId = $id ? " AND id != :id" : "";
    $sql = "SELECT COUNT(*) AS total FROM tbfuncionario WHERE (cpf = :cpf OR email = :email) $filtroId";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    if ($id) {
        $stmt->bindParam(':id', $id);
    }
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['total'] > 0;
}

// Inicialização das variáveis
$acao = isset($_GET['acao']) ? $_GET['acao'] : (isset($_POST['acao']) ? $_POST['acao'] : "novo");
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
$nome = isset($_POST['nome']) ? $_POST['nome'] : "";
$sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : "";
$funcao = isset($_POST['funcao']) ? $_POST['funcao'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$senha = isset($_POST['senha']) ? $_POST['senha'] : "";
$status = isset($_POST['status']) ? $_POST['status'] : "";


// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST['senha'];
    

    // Verificar se CPF ou email já existem
    if (verificarExistencia($conn, $cpf, $email, $id)) {
        echo "<script>alert('CPF ou Email já estão registrados.')</script>";
        echo "<script>window.location.href = 'cadfuncionario.php';</script>";
        exit;
    }

    // Processar ação
    if ($acao == "novo") {
        // Inserir novo registro
        $sql = "INSERT INTO tbfuncionario (cpf, nome, sobrenome, funcao, email, senha, status) VALUES (:cpf, :nome, :sobrenome, :funcao, :email, :senha, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':funcao', $funcao);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        echo "<script>alert('Cadastro de $nome realizado com sucesso'); window.location.href = 'listarusuario.php';</script>";

    } elseif ($acao == "editar" && $id > 0) {
        // Atualizar registro existente
        $sql = "UPDATE tbfuncionario SET nome = :nome, sobrenome = :sobrenome, funcao = :funcao, email = :email, senha = :senha, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':funcao', $funcao);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        echo "<script>alert('Cadastro de $nome atualizado com sucesso'); window.location.href = 'listarusuario.php';</script>";
    }

    // Limpar variáveis após ação
    $acao = "novo";
    $id = 0;
    $cpf = "";
    $nome = "";
    $sobrenome = "";
    $funcao = "";
    $email = "";
    $senha = "";
    $status = "";
}

// Consultar registro para edição, se ação for editar
if ($acao == "editar" && $id > 0) {
    $sql = "SELECT * FROM tbfuncionario WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($registro) {
        $cpf = $registro['cpf'];
        $nome = $registro['nome'];
        $sobrenome = $registro['sobrenome'];
        $funcao = $registro['funcao'];
        $email = $registro['email'];
        $senha = $registro['senha'];
        $status = $registro['status'];
    }
}

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id_excluir = $_GET['id'];
    
    // Query SQL para excluir o funcionário
    $sql_excluir = "DELETE FROM tbfuncionario WHERE id = ?";
    $stmt_excluir = $conn->prepare($sql_excluir);
    $stmt_excluir->execute([$id_excluir]);
    echo "<script>alert('Cadastro de $nome excluído com sucesso'); window.location.href = 'listarusuario.php';</script>";
}
?>






<br>

<div class="container">
    <form action="cadfuncionario.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="acao" value="<?php echo $acao; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>Nome: <input type="text" name="nome" required value="<?php echo $nome; ?>"></div>
        <div>Sobrenome: <input type="text" name="sobrenome" required value="<?php echo $sobrenome; ?>"></div>
        
        <div>CPF: <input type="text" name="cpf" required value="<?php echo $cpf; ?>" <?php echo ($acao == "editar") ? 'disabled' : ''; ?>></div>
        
        <div>Função: <input type="text" name="funcao" required value="<?php echo $funcao; ?>"></div>
        <div>Email: <input type="email" name="email" required value="<?php echo $email; ?>"></div>
        <div>Senha: <input type="password" name="senha" required value="<?php echo $senha; ?>"></div>
        <div>Status do cadastro: <br>
            <select name="status" style="padding: 8px; width: 190px; border: 1px solid #ccc;">
                <option value="">Selecione</option>
                <option value="Ativo" <?php echo ($status == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                <option value="Suspenso" <?php echo ($status == 'Suspenso') ? 'selected' : ''; ?>>Suspenso</option>
            </select>
        </div><br>

        <div>
            <input type="submit" name="submit" value="<?php echo ($acao == 'editar' && $id > 0) ? 'Atualizar' : 'Adicionar'; ?>">
            <input type="reset" value="Cancelar"><br><br>
        </div>
    </form>
</div>

</body>
</html>

<?php
require_once "rodape.php";
?>
