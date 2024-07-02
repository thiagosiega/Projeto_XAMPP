<?php
session_start();
include_once "../Server/Server.php";
include_once "Controler.php"; // Certifique-se de que Controler.php contém a função add_chat

// Verifica se o usuário está logado
if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    exit();
}

// Obtém o ID do usuário e o nome do chat da URL
$ID = $_SESSION['ID'];
$nomeChat = isset($_GET['Chat']) ? htmlspecialchars($_GET['Chat']) : '';

if (!$nomeChat) {
    echo "Chat não especificado.";
    exit();
}

// Caminho para o arquivo do chat
$arquivoChat = "Chat/" . $ID . "/" . $nomeChat . ".json";

if (!file_exists($arquivoChat)) {
    echo "Chat não encontrado.";
    exit();
}

// Carrega o conteúdo do chat
$conteudoChat = json_decode(file_get_contents($arquivoChat), true);
$mensagens = $conteudoChat['Mensagens'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexao = conectar();
    $ID = $_SESSION['ID'];
    $infor = infor_funcio($conexao, $ID);
    $nome = htmlspecialchars($infor['Nome']);
    $novaMensagem = htmlspecialchars($_POST['mensagem']);
    $mensagens[] = array("autor" => $nome, "mensagem" => $novaMensagem);

    // Atualiza o arquivo do chat
    $conteudoChat['Mensagens'] = $mensagens;
    file_put_contents($arquivoChat, json_encode($conteudoChat));
    
    // Redireciona para evitar reenvio de formulário
    header("Location: Chat.php?Chat=" . urlencode($nomeChat));
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nomeChat); ?></title>
    <link rel="stylesheet" href="chat.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            height: 100vh;
            background-color: #251bb171;
            margin: 0;
        }

        .Container {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            height: 100%;
            width: 100%;
        }

        .mensagens {
            display: flex;
            flex-direction: column-reverse;
            overflow-y: auto;
            flex-grow: 1;
            padding: 10px;
            margin-bottom: 10px;
        }

        .mensagem {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            width: fit-content;
            max-width: 80%;
        }

        form {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        textarea {
            width: 80%;
            height: 50px;
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            resize: none;
        }

        button {
            width: 20%;
            height: 60px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        a {
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #007bff;
        }

        a:hover {
            background-color: #00ff4c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="Container">
        <div class="mensagens">
            <?php foreach (array_reverse($mensagens) as $mensagem): ?>
                <div class="mensagem">
                    <p><strong><?php echo htmlspecialchars($mensagem['autor']); ?>:</strong> <?php echo htmlspecialchars($mensagem['mensagem']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="post">
            <textarea name="mensagem" placeholder="Digite sua mensagem" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
