<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "topo.php";

if (isset($_SESSION['idClientes']) || isset($_SESSION['idFuncionario'])) {
    $nome = isset($_SESSION['nomeClientes']) ? $_SESSION['nomeClientes'] : $_SESSION['nomeFuncionario'];
    $mensagem = "Você já está logado como $nome.";
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <title>Login</title>
</head>
<body>
    <div class="container">
        <section id="content">
            <?php if (isset($mensagem)): ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $mensagem; ?>
                </div>
            <?php else: ?>
                <form action="validarlogin.php" method="POST">
                    <h1>Login</h1>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group">
                        <input type="senha" name="senha" class="form-control" id="floatingPassword" placeholder="Senha" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Entrar" class="btn btn-primary" />
                        <a href="cadcliente.php">Cadastre-se</a>
                    </div>
                </form>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
