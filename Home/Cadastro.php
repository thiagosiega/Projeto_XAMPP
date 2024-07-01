<?php

include '../Server/Server.php';
$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];
    // Removendo o argumento não definido
    add_tb_funcionarios($nome, $email, $senha, $salario, $cargo);
    if ($conexao->error) {
        echo '<script>alert("Erro ao cadastrar: ' . $conexao->error . '")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="Container">
        <div class="Box">
            <form action="Cadastro.php" method="POST">
                <label for="nome">Nome:</label><br>
                <input type="text" name="nome" placeholder="Nome"><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" placeholder="Email"><br>
                <label for="senha">Senha:</label><br>
                <input type="password" name="senha" placeholder="Senha"><br>
                <label for="salario">Salario:</label><br>
                <input type="number" name="salario" placeholder="Salario"><br>
                <label for="cargo">Cargo:</label><br>
                <select name="cargo">
                    <option value="1">Fachineiro</option>
                    <option value="2">Garçon</option>
                    <option value="3">Cozinheiro</option>
                    <option value="4">Gerente</option>
                    <option value="5">RH</option>
                    <option value="6">Financeiro</option>
                    <option value="7">Programador</option>
                </select><br>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
    
</body>
</html>
