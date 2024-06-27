<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="imagens/ico.svg"/>
    <title>Cacarecos de Luxo</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cacarecos de Luxo</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" style="text-decoration: none; color: grey;" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="text-decoration: none; color: grey;" href="empresa.php">Empresa</a>
                </li>

                <?php if (!isset($_SESSION['idFuncionario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" style="text-decoration: none; color: grey;" href="galeria.php">Galeria</a>
                    </li>
                <?php endif; ?>



                <?php if (!isset($_SESSION['idClientes']) && isset($_SESSION['idFuncionario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="cadcliente" id="navbarDropdown" style="text-decoration: none; color: grey;" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clientes</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="listarcliente.php">Listar</a>
                        </div>
                    </li>
                <?php endif; ?>



                <?php if (!isset($_SESSION['idClientes']) && isset($_SESSION['idFuncionario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="text-decoration: none; color: grey;" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Produtos</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="addgaleria.php">Registrar</a>
                            <a class="dropdown-item" href="galeria.php">Listar</a>
                        </div>
                    </li>
                <?php endif; ?>


                
                <?php if (isset($_SESSION['idFuncionario']) || isset($_SESSION['idClientes'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" style="text-decoration: none; color: grey;" href="#" id="navbarDropdown" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Coletas</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="addcoleta.php">Solicitar</a>
                            <a class="dropdown-item" href="list_coletas.php">Listar</a>
                        </div>
                    </li>
                <?php endif; ?>





                <?php if (!isset($_SESSION['idClientes']) && isset($_SESSION['idFuncionario'])): ?>
                    <li class="nav-item dropdown dropdown-funcionarios">
                        <a class="nav-link dropdown-toggle" style="text-decoration: none; color: grey;" href="#" id="navbarDropdown" 
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Funcionários</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="cadfuncionario.php">Cadastro</a>
                            <a class="dropdown-item" href="listarfuncionario.php">Listar</a>
                        </div>
                    </li>
                <?php endif; ?>

                
                  
                <li class="nav-item dropdown nome-usuario">
                    <a class="nav-link dropdown-toggle" style="color: grey;" href="#" id="navbarDropdown" 
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>
                          Olá
                            <?php 
                            if(isset($_SESSION['idClientes'])) {
                                echo $_SESSION['nomeClientes']; // Se estiver logado como cliente, exibe o nome do cliente
                            } elseif(isset($_SESSION['idFuncionario'])) {
                                echo $_SESSION['nomeFuncionario']; // Se estiver logado como funcionário, exibe o nome do funcionário
                            }
                            ?>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item">Perfil <div class="dropdown-divider"></div></a>
                        <?php
                        if(isset($_SESSION['idClientes'])) {
                            echo "<a class='dropdown-item' href='cadcliente.php?id=" . $_SESSION['idClientes'] . "&acao=editar'>Meu cadastro</a>";
                        } elseif(isset($_SESSION['idFuncionario'])) {
                            echo "<a class='dropdown-item' href='cadfuncionario.php?id=" . $_SESSION['idFuncionario'] . "&acao=editar'>Meu cadastro</a>";
                        } else {
                          echo "<a href='cadcliente.php' class='dropdown-item'>Cadastre-se</a>";

                        }
                        ?>
                        <a class="dropdown-item" href="logout.php">Sair</a>
                    </div>
                </li>

                <li class="nav-item active mr-2">
                    <a class="nav-link btn btn-success" style="text-decoration: none; color: white; padding: 4px 10px;" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
