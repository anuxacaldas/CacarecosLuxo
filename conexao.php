<?php
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
    $conn = new PDO("mysql:host=$servername;
    dbname=bdCacarecosDeLuxo",
    $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, 
    PDO::ERRMODE_EXCEPTION);
    //echo "Você está conectado!<br>";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>