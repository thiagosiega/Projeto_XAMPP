<?php

include_once '../Server/Server.php';
session_start();
$ID = $_SESSION['ID'];
$conexao = conectar();
verificar_sessao($conexao, $ID);
$funcionario = infor_funcio($conexao, $ID);
if ($funcionario) {
    // Processa os dados do funcionário
    $email = $funcionario['Email'];
    $nome = $funcionario['Nome'];
    $salario = $funcionario['Salario'];
    $cargo = $funcionario['Cargo'];
} else {
    $server_resposta = "Funcionário não encontrado";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID: <?php echo $ID ?></title>
</head>
<body>
    
</body>
</html>


