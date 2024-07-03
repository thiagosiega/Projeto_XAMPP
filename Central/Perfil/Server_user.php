<?php

function conectar_user() {
    $host = 'localhost';
    $user = 'root'; // Adicione seu usuário do banco de dados aqui
    $password = ''; // Adicione sua senha do banco de dados aqui
    $database = 'gremil';
    $mysqli = new mysqli($host, $user, $password, $database);

    if ($mysqli->connect_error) {
        die('Erro de conexão (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
    }
    return $mysqli;
}

function desconectar_user($conexao) {
    $conexao->close();
}

function add_user_tabela($conexao, $ID, $nome, $email, $senha){
    $sql = "INSERT INTO usuarios (ID, Nome, Email, Senha) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isss", $ID, $nome, $email, $senha);
    $stmt->execute();
}

function transferencia($conexao, $ID){
    $sql = "SELECT * FROM funcionarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $Infor = $result->fetch_assoc();
        add_user_tabela($conexao, $Infor['ID'], $Infor['Nome'], $Infor['Email'], $Infor['Senha']);
        return true;
    } else {
        return false;
    }
}

function verificar_user($conexao, $ID){
    $sql = "SELECT * FROM usuarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function editar_user($conexao, $ID, $nome, $email, $data, $nik, $sexo, $perfil_img) {
    // pesquisa o id
    $sql = "SELECT * FROM usuarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // atualiza os dados
        $sql = "UPDATE usuarios SET Nome = ?, Email = ?, Data = ?, Nik = ?, Sexo = ?, Perfil_img = ? WHERE ID = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssssi", $nome, $email, $data, $nik, $sexo, $perfil_img, $ID);
        $stmt->execute();

        // Verifica se a atualização foi bem-sucedida
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if (transferencia($conexao, $ID)) {
            echo "<script>alert('Transferência bem-sucedida!');</script>";
            header('Location: Perfil.php');
            exit;
        } else {
            echo "<script>alert('Erro ao transferir dados');</script>";
            header('Location: ../../index.php');
            exit;
        }
    }
}
?>