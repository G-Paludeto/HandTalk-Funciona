<?php
session_start();

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'handtalk';

// Conectar ao banco de dados MySQL
$conectar = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se as chaves estão definidas no array $_POST
    if (isset($_POST['nome']) && isset($_POST['senha'])) {
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        // Verifica se a conexão com o banco de dados é bem-sucedida
        if ($conectar) {
            $sql = "SELECT id, senha_hash FROM usuarios WHERE username = ?";
            $stmt = $conectar->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $nome);
                $stmt->execute();
                $stmt->bind_result($id, $senha_hash);

                if ($stmt->fetch() && password_verify($senha, $senha_hash)) {
                    $_SESSION['user_id'] = $id;
                    header("Location: Inicio.html");
                    exit();
                } else {
                    $mensagem = "Erro: Nome de usuário ou senha inválidos.";
                }

                $stmt->close();
            } else {
                $mensagem = "Erro na preparação da declaração: " . $conectar->error;
            }
        } else {
            $mensagem = "Erro na conexão com o banco de dados.";
        }
    } else {
        $mensagem = "Erro: Campos de nome e senha não foram recebidos.";
    }

    // Verifica se $conectar está definida antes de tentar fechar
    if (isset($conectar)) {
        $conectar->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, #81d3ba, #085a42);
        }
        div{
            background-color: #10392d;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 15px;
            color: #fff;
        }
        input{
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
        }
        button{
            background-color: #085a42;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            
        }
        button:hover{
            background-color: #117d5d;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="Inicio.html" method="POST">
        <div>
            <h1>Login</h1>
            <input type="text" name="nome" placeholder="Nome">
            <br><br>
            <input type="password" name="senha" placeholder="Senha">
            <br><br>
            <button type="submit">Enviar</button>
            <p>Não possui uma conta? <a href="Cadastro.php">Fazer Cadastro</a></p>
            <br><br>
        </div>
    </form>
</body>
</html>
