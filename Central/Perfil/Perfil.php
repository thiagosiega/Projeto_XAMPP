<?php
include_once "../../Server/Server.php";
include_once "Server_user.php";
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: ../../index.php');
    exit();
}

$conexao = conectar();
$ID = $_SESSION['ID'];

// Verificação de tabela para os usuários
$conexao_user = conectar_user();
$infor = verificar_user($conexao_user, $ID);
if ($infor == false) {
    $infor2 = transferencia($conexao, $ID);
    if ($infor2 == false) {
        echo "<script>alert('Erro ao transferir dados');</script>";
        header('Location: ../../index.php');
    } else {
        $infor_user = verificar_user($conexao_user, $ID);
    }
} else {
    $infor_user = verificar_user($conexao_user, $ID);
}

// Tabela: ID Nome Data Senha Perfil_img Fundo_img Nik Sexo
if ($infor_user) {
    $nome = htmlspecialchars($infor_user['Nome']);
    $email = htmlspecialchars($infor_user['Email']);
    $senha = htmlspecialchars($infor_user['Senha']);
    $data = htmlspecialchars($infor_user['Data']);
    $perfil_img = htmlspecialchars($infor_user['Perfil_img']);
    $fundo_img = htmlspecialchars($infor_user['Fundo_img']);
    $nik = htmlspecialchars($infor_user['Nik']);
    $sexo = htmlspecialchars($infor_user['Sexo']);
    $ID = htmlspecialchars($infor_user['ID']);
}
//rorreçao do caminho da image

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil: <?php echo $nome; ?></title>
    <link rel="stylesheet" href="../CSS/Perfil.css">
</head>
<body>
    <script>
        function toggleEditForm() {
            var editForm = document.getElementById('editForm');
            if (editForm.style.display === 'none' || editForm.style.display === '') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }
    </script>
    <div class="Sidebar" id="sidebar">
        <div class="Sidebar_Container">
            <h2>Olá <?php echo $nome; ?></h2>
            <a href="../Home.php">Home</a>
            <a href="#">Perfil</a>
            <a href="../../Server/Sair.php">Sair</a>
        </div>
    </div>
    <div class="Container">
        <div class="infor_perfil">
            <h2>Perfil</h2>
            <div class="infor_perfil">
                <img src="<?php echo $perfil_img; ?>" alt="Perfil">
            </div>
            <h3>Nome: <?php echo $nome; ?></h3>
            <h3>Email: <?php echo $email; ?></h3>
            <h3>Data de Nascimento: <?php echo $data; ?></h3>
            <h3>Nik: <?php echo $nik; ?></h3>
            <h3>Sexo: <?php echo $sexo; ?></h3>
            <button id="editButton" onclick="toggleEditForm()">Editar Perfil</button>
        </div>
        <br>
        <div class="Editrar" id="editForm">
            <form action="Editar_perfil.php" method="post">
                <h2>Editar Perfil</h2>
                <label for="nome">Nome:</label><br>
                <input type="text" name="nome" placeholder="Nome" value="<?php echo $nome; ?>"><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>"><br>
                <label for="data">Data de Nascimento:</label><br>
                <input type="date" name="data" value="<?php echo $data; ?>"><br>
                <label for="nik">Nik:</label><br>
                <input type="text" name="nik" placeholder="Nik" value="<?php echo $nik; ?>"><br>
                <label for="sexo">Sexo:</label><br>
                <select name="sexo">
                    <option value="Masculino" <?php if ($sexo == 'Masculino') { echo 'selected'; } ?>>Masculino</option>
                    <option value="Feminino" <?php if ($sexo == 'Feminino') { echo 'selected'; } ?>>Feminino</option>
                </select><br>
                <label for="img">Imagem de Perfil:</label><br>
                <div class="infor_perfil">
                    <img src="<?php echo $perfil_img; ?>" alt="Perfil">
                </div>
                <input type="file" name="img"><br>
                <input type="submit" value="Salvar">
            </form>
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
</body>
</html>