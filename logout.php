
<?php
session_start();
session_destroy();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>