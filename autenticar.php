<?php
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (array_key_exists($username, $usuarios_registrados) && $usuarios_registrados[$username] == $password) {

        $_SESSION['email'] = true;
        $_SESSION['senha'] = $senha;

        header("Location: pagina_protegida.php");
        exit();
    } else {

        header("Location: index.html?erro=1");
        exit();
    }
?>