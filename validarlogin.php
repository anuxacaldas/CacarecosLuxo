<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "bd/conexao.php";
require_once "topo.php";

// Verificar se já existe um usuário logado
if(isset($_SESSION['idClientes']) || isset($_SESSION['idFuncionario'])) {
    // Definir o conteúdo da popup com JavaScript
    echo "<script>";
    echo "alert('Você já está logado como ";
    
    if(isset($_SESSION['idClientes'])) {
        echo "cliente.');";

    } elseif(isset($_SESSION['idFuncionario'])) {
        echo "funcionário.');";
    }
    echo "window.location.href = 'index.php';";
    echo "</script>";
    exit;
}

// Continuar com o código de validação de login apenas se não houver uma sessão existente

if(isset($_POST['email']) && isset($_POST['senha'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário na tabela tbclientes
    $sql_cliente = "SELECT * FROM tbclientes WHERE email = '$email' AND senha = '$senha'";
    $resultado_cliente = $conn->query($sql_cliente);

    if($resultado_cliente->rowCount() > 0) {
        // Se encontrou o cliente
        $registro = $resultado_cliente->fetch(PDO::FETCH_ASSOC);
        if($registro['status'] == 'Ativo') {
            $_SESSION['idClientes'] = $registro['id'];
            $_SESSION['nomeClientes'] = $registro['nome'];
            echo "<script>";
            echo "alert('Você entrou como cliente.');";
            echo "window.location.href = 'index.php';";
            echo "</script>";
            exit; // Termina a execução após login bem-sucedido
        } else {
            echo "<script>";
            echo "alert('Seu status está inativo ou suspenso. Entre em contato com o suporte.');";
            echo "window.location.href = 'login.php';";
            echo "</script>";
            exit; // Redireciona para login.php se status não for ativo
        }
    }

    // Verificar na tabela tbfuncionario
    $sql_funcionario = "SELECT * FROM tbfuncionario WHERE email = '$email' AND senha = '$senha'";
    $resultado_funcionario = $conn->query($sql_funcionario);

    if($resultado_funcionario->rowCount() > 0) {
        // Se encontrou o funcionário
        $registro = $resultado_funcionario->fetch(PDO::FETCH_ASSOC);
        if($registro['status'] == 'Ativo') {
            $_SESSION['idFuncionario'] = $registro['id'];
            $_SESSION['nomeFuncionario'] = $registro['nome'];
            echo "<script>";
            echo "alert('Você entrou como funcionário.');";
            echo "window.location.href = 'list_coletas.php';";
            echo "</script>";
            exit; // Termina a execução após login bem-sucedido
        } else {
            echo "<script>";
            echo "alert('Seu status está inativo ou suspenso. Entre em contato com o suporte.');";
            echo "window.location.href = 'login.php';";
            echo "</script>";
            exit; // Redireciona para login.php se status não for ativo
        }
    }

    // Se não encontrou nenhum usuário válido
    echo "<script>window.alert('Usuário ou senha inválidos.')</script>";
} else {
    echo "<script>window.alert('Preencha o e-mail e a senha.')</script>";
}
?>
