<?php


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
    //criptografa a senha
    $senha = password_hash($senha, PASSWORD_DEFAULT);
    $ID = rand(10, 99);  
    //verifica se  ID já existe
    $sql = "SELECT * FROM tb_funcionarios WHERE ID = $ID";
    $result = $conexao->query($sql);
    while ($result->num_rows > 0) {
        $ID = rand(10, 99);
        $sql = "SELECT * FROM tb_funcionarios WHERE ID = $ID";
        $result = $conexao->query($sql);
    }
    // Insira os dados na tabela tb_funcionarios
    $sql = "INSERT INTO tb_funcionarios (ID, Nome, Email, Senha, Salario, Cargo) VALUES ($ID, '$nome', '$email', '$senha', $salario, $cargo)";
    $conexao->query($sql);
    if ($conexao->error) {
        return $conexao->error;
    }
    desconectar($conexao);
}
?>
