<?php

include '../Server/Server.php';
$conexao = conectar();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <div class="Container">
        <div class="Box">
            <form action="Server/Server.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder="Nome">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="Email">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" placeholder="Senha">
                <label for="salario">Salario:</label>
                <input type="number" name="salario" placeholder="Salario">
            </form>
        </div>
    </div>
    
</body>
</html>