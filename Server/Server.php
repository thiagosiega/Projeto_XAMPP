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

function add_tb_funcionarios($conexao) {
    $sql = "SELECT * FROM funcionarios";
    $result = $conexao->query($sql);
    $funcionarios = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = $row;
        }
    }
    return $funcionarios;
}
?>
