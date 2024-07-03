<?php
// verifica se tem alguma sessão ativa
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: Home/Login.php');
    exit();
}else{
    header('Location: Central/Home.php');
    exit();
}


?>