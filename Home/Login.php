<?php
include '../Server\Server.php';
$conexao = conectar();

if (isset($_POST['ID']) && isset($_POST['senha'])) {
    $ID = $_POST['ID'];
    $senha = $_POST['senha'];

    if (logar($conexao, $ID, $senha)) {
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
    <title>Login</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="Container">
        <div class="Box">
            <h1>Login</h1>
            <form action="Login.php" method="POST">
                <label for="ID">ID:</label>
                <input type="number" name="ID" placeholder="ID" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
            <a href="Cadastro.php">Cadastrar</a>
        </div>
    </div>
    
</body>
</html>