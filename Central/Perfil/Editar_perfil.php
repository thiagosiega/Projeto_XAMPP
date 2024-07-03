<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $nik = $_POST['nik'];
    $sexo = $_POST['sexo'];
    $img = $_FILES['img'];

    include_once "Server_user.php";
    $conexao_user = conectar_user();
    session_start();
    $ID = $_SESSION['ID'];

    // verifica se o usuário já existe
    $infor = verificar_user($conexao_user, $ID);
    if ($infor == false) {
        $infor2 = transferencia($conexao, $ID);
        if ($infor2 == false) {
            echo "<script>alert('Erro ao transferir dados\\ncadastre ou logue novamente!');</script>";
            header('Location: ../../index.php');
            exit;
        } else {
            $infor_user = verificar_user($conexao_user, $ID);
        }
    } else {
        $infor_user = verificar_user($conexao_user, $ID);
    }

    // verifica a imagem
    if ($img['error'] === UPLOAD_ERR_OK) {
        //tamanho
        if ($img['size'] > 1000000) {
            echo "<script>alert('Imagem muito grande!');</script>";
            header('Location: Perfil.php');
            exit;
        }

        //tipo
        $extensao = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
            echo "<script>alert('Imagem não suportada!');</script>";
            header('Location: Perfil.php');
            exit;
        }

        //aleatoriza o nome da imagem
        $novo_nome = md5(time()) . '.' . $extensao;
        $file_img_perfil = $ID . "/Informacoes/Img_perfil/";
        if (!file_exists($file_img_perfil)) {
            mkdir($file_img_perfil, 0777, true);
        }

        //salva a imagem
        if (move_uploaded_file($img['tmp_name'], $file_img_perfil . $novo_nome)) {
            $perfil_img = $file_img_perfil . $novo_nome;
        } else {
            echo "<script>alert('Erro ao salvar imagem!');</script>";
            header('Location: Perfil.php');
            exit;
        }
    } else {
        $perfil_img = $infor_user['Perfil_img'];
    }

    // salva as informações no banco
    if (editar_user($conexao_user, $ID, $nome, $email, $data, $nik, $sexo, $perfil_img)) {
        echo "<script>alert('Perfil atualizado com sucesso!');</script>";
        header('Location: Perfil.php');
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar perfil!');</script>";
        header('Location: Perfil.php');
        exit;
    }
}
?>
