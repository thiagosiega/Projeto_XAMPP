<?php
session_start();
include_once "../Server/Server.php";
include_once "Controler.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexao = conectar();
    $ID = $_SESSION['ID'];
    $nomeChat = htmlspecialchars($_POST['nomeChat']);

    // Chamar a função add_chat
    add_chat($ID, $nomeChat);
}
?>
