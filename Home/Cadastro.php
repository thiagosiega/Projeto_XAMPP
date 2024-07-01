<?php

include '../Server/Server.php';
$conexao = conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];

    // Chama a função de adicionar funcionário e exibe a resposta
    if (add_tb_funcionarios($conexao, $nome, $email, $senha, $salario, $cargo)) {
        echo "<div class='alert alert-success' role='alert'>Funcionário cadastrado com sucesso</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>$server_resposta</div>";
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
                <input type="text" name="nome" placeholder="Nome" required><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <label for="senha">Senha:</label><br>
                <input type="password" name="senha" placeholder="Senha" required><br>
                <label for="salario">Salario:</label><br>
                <input type="number" name="salario" placeholder="Salario" required><br>
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
            <a href="Login.php">Voltar</a>
        </div>
    </div>
    
</body>
</html>
