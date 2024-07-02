<?php
include_once "../Server/Server.php";

function listar_chats($ID) {
    $dir = "Chat/" . $ID;
    if (file_exists($dir) && is_dir($dir)) {
        $chats = array_diff(scandir($dir), array('.', '..')); // Remove . e .. do array

        if (empty($chats)) {
            echo "Você não possui chats";
            return;
        }

        foreach ($chats as $chat) {
            $chatName = pathinfo($chat, PATHINFO_FILENAME); // Remove a extensão .json
            echo "<a href='Chat.php?Chat=" . urlencode($chatName) . "'>" . htmlspecialchars($chatName) . "</a><br>";
        }
    } else {
        echo "Você não possui chats";
    }
}

function add_chat($ID, $nomeChat) {
    $conexao = conectar();
    $ID = $_SESSION['ID'];
    $infor = infor_funcio($conexao, $ID);
    $nome = htmlspecialchars($infor['Nome']);
    $File = "Chat/" . $ID . "/" . $nomeChat . ".json";
    if (!file_exists($File)) {
        if (!is_dir("Chat/" . $ID)) {
            mkdir("Chat/" . $ID, 0777, true);
        }
        $Chat = fopen($File, "w");
        $conteudo = array(
            "Anfitiao" => $nome,
            "Mensagens" => array()
        );
        fwrite($Chat, json_encode($conteudo));
        fclose($Chat);
        echo "<script>alert('Chat criado com sucesso!')</script>";
        header("Location: Home.php");
    } else {
        echo "<script>alert('Chat já existe!')</script>";
        echo "<script>window.history.back()</script>";
    }
}
?>