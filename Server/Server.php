<?php
//file: Server/Server.php

function verificar_sessao($conexao, $ID) {
    if (!isset($_SESSION['ID'])) {
        $server_resposta = "Sessão inválida";
        exit();
    } else {
        global $server_resposta;

        // Verifica se o ID existe
        $sql = "SELECT * FROM funcionarios WHERE ID = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $server_resposta = "ID não cadastrado";
            return false;
        } else {
            $server_resposta = "Sessão válida e ID encontrado";
            return true;
        }
    }
}

function conectar() {
    $host = 'localhost';
    $user = 'root';
    $password = ''; 
    $database = 'gremil'; 
    // Tente criar uma nova conexão MySQLi
    $mysqli = new mysqli($host, $user, $password, $database);

    // Verifique se houve algum erro de conexão
    if ($mysqli->connect_error) {
        die('Erro de conexão (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
    }

    return $mysqli;
}

function desconectar($conexao) {
    $conexao->close();
}

function add_tb_funcionarios($conexao, $nome, $email, $senha, $salario, $cargo) {
    global $server_resposta;
    // Criptografa a senha
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    // Gera um ID único
    $ID = rand(10, 99);  
    $sql = "SELECT * FROM funcionarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($result->num_rows > 0) {
        $ID = rand(10, 99);
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    // Verifica se o email já existe
    $sql = "SELECT * FROM funcionarios WHERE Email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $server_resposta = "Email já cadastrado";
        return false;
    }

    // Verifica se o nome já existe
    $sql = "SELECT * FROM funcionarios WHERE Nome = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $server_resposta = "Nome já cadastrado";
        return false;
    }

    // Verifica se o salario é maior que 0
    if($salario <= 0){
        $server_resposta = "Salário inválido";
        return false;
    }

    // Insere os dados na tabela funcionarios usando prepared statements
    $sql = "INSERT INTO funcionarios (ID, Nome, Email, Senha, Salario, Cargo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isssii", $ID, $nome, $email, $senha, $salario, $cargo);
    $stmt->execute();

    if ($stmt->error) {
        $server_resposta = $stmt->error;
        return false;
    }

    $server_resposta = "Cadastro realizado com sucesso";
    // Feche o statement e a conexão
    $stmt->close();
    desconectar($conexao);
    return true;
}

function logar ($conexao, $ID, $senha) {
    global $server_resposta;
    $conexao = conectar();
    // Verifica se o ID existe
    $sql = "SELECT * FROM funcionarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $server_resposta = "ID não cadastrado";
        return false;
    }

    // Verifica se a senha está correta
    $row = $result->fetch_assoc();
    if (!password_verify($senha, $row['Senha'])) {
        $server_resposta = "Senha incorreta";
        return false;
    }

    // Inicia a sessão e redireciona para a página de login
    session_start();
    $_SESSION['ID'] = $ID;
    header('Location: ../Cental/Home.php');
    return true;
}

function infor_funcio($conexao, $ID) {
    $sql = "SELECT * FROM funcionarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $infor = array(
            'ID' => $row['ID'],
            'Nome' => $row['Nome'],
            'Email' => $row['Email'],
            'Salario' => $row['Salario'],
            'Cargo' => $row['Cargo']
        );
        return $infor;
    } else {
        return null;
    }
}



?>
