<?php
include_once "../Server/Server.php";
include_once "Controler.php";

//verifica se tem alguma sessão ativa
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: ../index.php');
    exit();
}

$conexao = conectar();
$ID = $_SESSION['ID'];
$Infor = infor_funcio($conexao, $ID);
$nome = htmlspecialchars($Infor['Nome']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="Sidebar" id="sidebar">
        <div class="Sidebar_Container">
            <h2>Olá <?php echo htmlspecialchars($nome); ?></h2>
            <a href="Home.php">Home</a>
            <a href="Perfil/Perfil.php">Perfil</a>
            <a href="../Server/Sair.php">Sair</a>
        </div>
    </div>
    <script>
        const sidebar = document.querySelector('.Sidebar');
        const sidebarContainer = document.querySelector('.Sidebar_Container');
        const container = document.querySelector('.Container');

        sidebar.addEventListener('mouseover', () => {
            sidebar.style.width = '300px';
            sidebarContainer.style.display = 'block';
            container.style.marginLeft = '300px';
        });

        sidebar.addEventListener('mouseout', () => {
            sidebar.style.width = '50px';
            sidebarContainer.style.display = 'none';
            container.style.marginLeft = '50px';
        });
    </script>

    <div class="Container">
        <div class="criar-chat">
            <form action="Chat_add.php" method="post">
                <input type="text" name="nomeChat" placeholder="Digite o nome do chat" required><br>
                <button type="submit">Criar Chat</button>
            </form>
        </div>
        <div class="listar-chats">
            <h2>Seus Chats</h2>
            <?php listar_chats($ID); ?>
        </div>
    </div>
</body>
</html>
