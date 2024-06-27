<?php
session_start();
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
echo '<div class="search-form buscar" style="background-color: #637D72;">';
echo '    <h5>Faça seu cadastro de cliente</h5>';
echo '</div>';
?>


<?php

// Função para verificar se o CPF ou email já estão registrados
function verificarExistencia($conn, $cpf, $email, $id = null) {
    $filtroId = $id ? " AND id != :id" : "";
    $sql = "SELECT COUNT(*) AS total FROM tbclientes WHERE (cpf = :cpf OR email = :email) $filtroId";
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
$email = isset($_POST['email']) ? $_POST['email'] : "";
$senha = isset($_POST['senha']) ? $_POST['senha'] : "";
$status = isset($_POST['status']) ? $_POST['status'] : "Ativo";
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
$endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
$cidade = isset($_POST['cidade']) ? $_POST['cidade'] : "";
$estado = isset($_POST['estado']) ? $_POST['estado'] : "";
$cep = isset($_POST['cep']) ? $_POST['cep'] : "";

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se CPF ou email já existem
    if (verificarExistencia($conn, $cpf, $email, $id)) {
        echo "<script>alert('CPF ou Email já estão registrados.')</script>";
        echo "<script>window.location.href = 'cadcliente.php';</script>";
        exit;
    }

    // Processar ação
    if ($acao == "novo") {
        // Inserir novo registro
        $sql = "INSERT INTO tbclientes (cpf, nome, sobrenome, email, senha, telefone, endereco, cidade, estado, cep, status) VALUES (:cpf, :nome, :sobrenome, :email, :senha, :telefone, :endereco, :cidade, :estado, :cep, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        echo "<script>alert('Cadastro de $nome realizado com sucesso'); window.location.href = 'listarcliente.php';</script>";

    } elseif ($acao == "editar" && $id > 0) {
        // Atualizar registro existente
        $sql = "UPDATE tbclientes SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha, telefone = :telefone, endereco = :endereco, cidade = :cidade, estado = :estado, cep = :cep, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        echo "<script>alert('Cadastro de $nome atualizado com sucesso'); window.location.href = 'listarcliente.php';</script>";
    }

    // Limpar variáveis após ação
    $acao = "novo";
    $id = 0;
    $cpf = "";
    $nome = "";
    $sobrenome = "";
    $email = "";
    $senha = "";
    $telefone = "";
    $endereco = "";
    $cidade = "";
    $estado = "";
    $cep = "";
    $status = "";
}

// Consultar registro para edição, se ação for editar
if ($acao == "editar" && $id > 0) {
    $sql = "SELECT * FROM tbclientes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($registro) {
        $cpf = $registro['cpf'];
        $nome = $registro['nome'];
        $sobrenome = $registro['sobrenome'];
        $email = $registro['email'];
        $senha = $registro['senha'];
        $telefone = $registro['telefone'];
        $endereco = $registro['endereco'];
        $cidade = $registro['cidade'];
        $estado = $registro['estado'];
        $cep = $registro['cep'];
        $status = $registro['status'];
    }
}

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id_excluir = $_GET['id'];
    
    // Query SQL para excluir o cliente
    $sql_excluir = "DELETE FROM tbclientes WHERE id = ?";
    $stmt_excluir = $conn->prepare($sql_excluir);
    $stmt_excluir->execute([$id_excluir]);
    echo "<script>alert('Cadastro de $nome excluído com sucesso'); window.location.href = 'listarcliente.php';</script>";
}
?>



<br>

<div class="container">
    <form action="cadcliente.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="acao" value="<?php echo $acao; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>Nome: <input type="text" name="nome" required value="<?php echo htmlspecialchars($nome); ?>"></div>

        <div>Sobrenome: <input type="text" name="sobrenome" required value="<?php echo htmlspecialchars($sobrenome); ?>"></div>
        
        <?php if ($acao == "novo"): ?>
            <div>CPF: <input type="text" name="cpf" required value="<?php echo htmlspecialchars($cpf); ?>"></div>
        <?php else: ?>
            <div>CPF: <input type="text" name="cpf" required value="<?php echo htmlspecialchars($cpf); ?>" disabled></div>
        <?php endif; ?>

        <div>Email: <input type="email" name="email" required value="<?php echo htmlspecialchars($email); ?>"></div>
        
        <div>Senha: <input type="password" name="senha" required value="<?php echo htmlspecialchars($senha); ?>"></div>
        
        <div>Telefone: <input type="text" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>"></div>

        <div>Endereço: <input type="text" name="endereco" value="<?php echo htmlspecialchars($endereco); ?>"></div>

        <div>Cidade: <input type="text" name="cidade" value="<?php echo htmlspecialchars($cidade); ?>"></div>

        <div>Estado: <input type="text" name="estado" maxlength="2" value="<?php echo htmlspecialchars($estado); ?>"></div>
       
        <div>CEP: <input type="text" name="cep" value="<?php echo htmlspecialchars($cep); ?>"></
        
        <?php
// Verificar se o usuário está logado como funcionário ativo
if(isset($_SESSION['idFuncionario'])) {
    // Verificar se o status do funcionário é ativo
    $idFuncionario = $_SESSION['idFuncionario'];
    $sqlFuncionario = "SELECT * FROM tbfuncionario WHERE id = :id AND status = 'Ativo'";
    $stmtFuncionario = $conn->prepare($sqlFuncionario);
    $stmtFuncionario->bindParam(':id', $idFuncionario);
    $stmtFuncionario->execute();
    $funcionario = $stmtFuncionario->fetch(PDO::FETCH_ASSOC);

    if($funcionario) {
        // Se o funcionário estiver ativo, exibir o campo para editar o status
?>
<div>Status do cadastro: <br>
    <select name="status" style="padding: 8px; width: 190px; border: 1px solid #ccc;">
        <option value="Ativo" <?php echo ($status == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
        <option value="Inativo" <?php echo ($status == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
</div><br>
<?php
    } // fim do if $funcionario
} // fim do if isset $_SESSION['idFuncionario']
?>


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
